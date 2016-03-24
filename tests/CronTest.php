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
use Cron\Resolver\ArrayResolver;
use Cron\Job\ShellJob;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class CronTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Cron
     */
    private $cron;

    public function setUp()
    {
        $this->cron = new Cron();
    }

    public function tearDown()
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

        $this->assertInstanceOf('\Cron\Report\ReportInterface', $this->cron->run());
    }

    public function testRunArray()
    {
        $task = new ShellJob();

        $this->cron->setResolver(new ArrayResolver([$task]));
        $this->cron->setExecutor(new Executor());

        $this->assertInstanceOf('\Cron\Report\ReportInterface', $this->cron->run());
    }

    public function testExample()
    {
        $job = new \Cron\Job\ShellJob();
        $job->setCommand('echo "total"');
        $job->setSchedule(new \Cron\Schedule\CrontabSchedule('* * * * *'));

        $resolver = new \Cron\Resolver\ArrayResolver();
        $resolver->addJob($job);

        $cron = new \Cron\Cron();
        $cron->setExecutor(new \Cron\Executor\Executor());
        $cron->setResolver($resolver);

        $report = $cron->run();

        $this->assertInstanceOf('\Cron\Report\ReportInterface', $report);

        while ($cron->isRunning()) {
        }

        $reportOutput = $report->getReport($job)->getOutput();
        $this->assertEquals('total', trim($reportOutput[0]));
    }

    public function testNewExample()
    {
        $job1 = new \Cron\Job\ShellJob();
        $job1->setCommand('ls -la');
        $job1->setSchedule(new \Cron\Schedule\CrontabSchedule('*/5 * * * *'));

        $job2 = new \Cron\Job\ShellJob();
        $job2->setCommand('ls -la');
        $job2->setSchedule(new \Cron\Schedule\CrontabSchedule('0 0 * * *'));

        $resolver = new \Cron\Resolver\ArrayResolver();
        $resolver->addJob($job1);
        $resolver->addJob($job2);

        $cron = new \Cron\Cron();
        $cron->setExecutor(new \Cron\Executor\Executor());
        $cron->setResolver($resolver);

        $cron->run();
    }

    public function testDefaultExecutor()
    {
        $this->assertInstanceOf('\Cron\Executor\Executor', $this->cron->getExecutor());
    }
}
