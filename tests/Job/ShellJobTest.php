<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Job;

use Cron\Report\JobReport;
use Cron\Schedule\CrontabSchedule;
use PHPUnit\Framework\TestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ShellJobTest extends TestCase
{
    /**
     * @var ShellJob
     */
    protected $shellJob;

    protected function setUp(): void
    {
        $this->shellJob = new ShellJob();
    }

    protected function tearDown(): void
    {
        unset($this->shellJob);
    }

    public function testSchedule()
    {
        $schedule = new CrontabSchedule();
        $this->shellJob->setSchedule($schedule);

        $this->assertEquals($schedule, $this->shellJob->getSchedule());
    }

    public function testRunning()
    {
        $scheduleMock = $this->getMockBuilder(CrontabSchedule::class)
            ->getMock();
        $scheduleMock
            ->expects($this->exactly(2))
            ->method('valid')
            ->will($this->returnValue(true));

        $this->shellJob->setSchedule($scheduleMock);
        $this->shellJob->setCommand('sleep 10');

        $this->assertTrue($this->shellJob->valid(new \DateTime()));
        $this->shellJob->run(new JobReport($this->shellJob));
        $this->assertTrue($this->shellJob->isRunning());
        $this->assertFalse($this->shellJob->valid(new \DateTime()));
    }
}
