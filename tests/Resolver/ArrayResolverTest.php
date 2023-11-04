<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Resolver;

use Cron\Job\ShellJob;
use Cron\Schedule\CrontabSchedule;
use PHPUnit\Framework\TestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ArrayResolverTest extends TestCase
{
    /**
     * @var ArrayResolver
     */
    protected $resolver;

    protected function setUp(): void
    {
        $this->resolver = new ArrayResolver();
    }

    protected function tearDown(): void
    {
        unset($this->resolver);
    }

    public function testEmptyResolve()
    {
        $this->assertEquals([], $this->resolver->resolve());
    }

    /**
     * @dataProvider resolverProvider
     */
    public function testResolve($all, $expected)
    {
        $this->resolver->addJobs($all);

        $this->assertEquals($expected, $this->resolver->resolve());
    }

    public static function resolverProvider()
    {
        $now = new \DateTime();
        $dow = (int) $now->format('w');
        $badDow = ($dow - 1 < 0) ? ($dow + 1) : ($dow - 1);

        $validJob = new ShellJob();
        $validJob->setSchedule(new CrontabSchedule('* * * * *'));
        $validJob->setCommand('ls -la');

        $noScheduleJob = new ShellJob();

        $noCommandJob = new ShellJob();
        $noCommandJob->setSchedule(new CrontabSchedule('* * * * *'));

        $invalidJob = new ShellJob();
        $invalidJob->setSchedule(new CrontabSchedule('* * * * '.$badDow));

        return [
            [[], []],
            [[$validJob], [$validJob]],
            [[$noScheduleJob], []],
            [[$validJob, $noScheduleJob], [$validJob]],
            [[$noCommandJob], []],
            [[$noCommandJob, $noScheduleJob], []],
            [[$noCommandJob, $validJob, $noScheduleJob], [$validJob]],
            [[$invalidJob], []],
            [[$invalidJob, $validJob], [$validJob]],
            [[$invalidJob, $validJob, $noCommandJob], [$validJob]],
            [[$invalidJob, $validJob, $noCommandJob, $noScheduleJob], [$validJob]],
        ];
    }

    public function testAddJobs()
    {
        $property = new \ReflectionProperty($this->resolver, 'jobs');
        $property->setAccessible(true);

        $job = new ShellJob();
        $this->resolver->addJob($job);

        $this->assertEquals([$job], $property->getValue($this->resolver));
    }
}
