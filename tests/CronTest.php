<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron;

use Cron\Executor\Executor;
use Cron\Report\ReportInterface;
use Cron\Resolver\ArrayResolver;
use Cron\Job\ShellJob;
use Cron\Schedule\CrontabSchedule;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class CronTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Cron
     */
    private $cron;

    protected function setUp(): void
    {
        $this->cron = new Cron();
    }

    protected function tearDown(): void
    {
        unset($this->cron);
    }

    public function testExecutor()
    {
        $executor = new Executor();
        $this->cron->setExecutor($executor);

        $this->assertEquals($executor, $this->cron->getExecutor());
    }

    public function testResolver()
    {
        $resolver = new ArrayResolver();
        $this->cron->setResolver($resolver);

        $this->assertEquals($resolver, $this->cron->getResolver());
    }

    public function testRunReport()
    {
        $this->cron->setResolver(new ArrayResolver());
        $this->cron->setExecutor(new Executor());

        $this->assertInstanceOf(ReportInterface::class, $this->cron->run());
    }

    public function testRunArray()
    {
        $task = new ShellJob();

        $this->cron->setResolver(new ArrayResolver([$task]));
        $this->cron->setExecutor(new Executor());

        $this->assertInstanceOf(ReportInterface::class, $this->cron->run());
    }

    public function testExample()
    {
        $job = new ShellJob();
        $job->setCommand('echo "total"');
        $job->setSchedule(new CrontabSchedule('* * * * *'));

        $resolver = new ArrayResolver();
        $resolver->addJob($job);

        $cron = new Cron();
        $cron->setExecutor(new Executor());
        $cron->setResolver($resolver);

        $report = $cron->run();

        $this->assertInstanceOf(ReportInterface::class, $report);

        while ($cron->isRunning()) {
        }

        $reportOutput = $report->getReport($job)->getOutput();
        $this->assertEquals('total', trim($reportOutput[0]));
    }

    public function testNewExample()
    {
        $job1 = new ShellJob();
        $job1->setCommand('ls -la');
        $job1->setSchedule(new CrontabSchedule('*/5 * * * *'));

        $job2 = new ShellJob();
        $job2->setCommand('ls -la');
        $job2->setSchedule(new CrontabSchedule('0 0 * * 7'));

        $resolver = new ArrayResolver();
        $resolver->addJob($job1);
        $resolver->addJob($job2);

        $cron = new Cron();
        $cron->setExecutor(new Executor());
        $cron->setResolver($resolver);

        $this->assertInstanceOf(ReportInterface::class, $cron->run());
    }

    public function testDefaultExecutor()
    {
        $this->assertInstanceOf(Executor::class, $this->cron->getExecutor());
    }
}
