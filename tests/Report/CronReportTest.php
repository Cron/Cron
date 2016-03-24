<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Report;

use Cron\Job\JobInterface;
use Cron\Job\PhpJob;
use Cron\Job\ShellJob;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class CronReportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CronReport
     */
    protected $report;

    public function setUp()
    {
        $this->report = new CronReport();
    }

    public function tearDown()
    {
        unset($this->report);
    }

    public function testAddJobReport()
    {
        $jobReport = new JobReport(new PhpJob());

        $this->report->addJobReport($jobReport);

        $this->assertEquals([$jobReport], $this->report->getReports());
    }

    public function testGetReportExists()
    {
        $job = new PhpJob();
        $jobReport = new JobReport($job);

        $this->report->addJobReport($jobReport);

        $this->assertEquals($jobReport, $this->report->getReport($job));
    }

    public function testGetReportNull()
    {
        $job = new PhpJob();
        $jobReport = new JobReport($job);

        $this->report->addJobReport($jobReport);

        $this->assertNull($this->report->getReport(new PhpJob()));
    }

    public function testIsSuccessful()
    {
        $job = new PhpJob();
        $jobReport = new JobReport($job);

        $this->report->addJobReport($jobReport);

        $this->assertNull($this->report->isSuccessful());
    }

    public function testSuccessfulTrue()
    {
        $job = $this->createJob('ls');
        $cron = $this->createCron($job);
        $report = $cron->run();

        while ($cron->isRunning()) {
        }

        $this->assertTrue($report->isSuccessful());
    }

    public function testSuccessfulFalse()
    {
        $job = $this->createJob('thisisnocommand');
        $cron = $this->createCron($job);
        $report = $cron->run();

        while ($cron->isRunning()) {
        }

        $this->assertFalse($report->isSuccessful());
    }

    public function testStartTime()
    {
        $job = $this->createJob('ls');
        $cron = $this->createCron($job);
        $report = $cron->run();

        while ($cron->isRunning()) {
        }

        $this->assertNotEmpty($report->getReport($job)->getStartTime());
    }

    public function testOutput()
    {
        $job = $this->createJob('ls');
        $cron = $this->createCron($job);
        $report = $cron->run();

        while ($cron->isRunning()) {
        }

        $reportErrorOutput = $report->getReport($job)->getError();
        $reportOutput = $report->getReport($job)->getOutput();

        $this->assertCount(0, $reportErrorOutput);
        $this->assertContains('README.md', $reportOutput[0]);
    }

    public function testErrorOutput()
    {
        $job = $this->createJob('thisisnocommand');
        $cron = $this->createCron($job);
        $report = $cron->run();

        while ($cron->isRunning()) {
        }

        $reportErrorOutput = $report->getReport($job)->getError();
        $reportOutput = $report->getReport($job)->getOutput();

        $this->assertContains('thisisnocommand', $reportErrorOutput[0]);
        $this->assertCount(0, $reportOutput);
    }

    /**
     * @param JobInterface $job
     *
     * @return \Cron\Cron
     */
    protected function createCron(JobInterface $job)
    {
        $resolver = new \Cron\Resolver\ArrayResolver();
        $resolver->addJob($job);

        $cron = new \Cron\Cron();
        $cron->setExecutor(new \Cron\Executor\Executor());
        $cron->setResolver($resolver);

        return $cron;
    }

    /**
     * @param string $command
     *
     * @return ShellJob
     */
    protected function createJob($command)
    {
        $job = new \Cron\Job\ShellJob();
        $job->setCommand($command);
        $job->setSchedule(new \Cron\Schedule\CrontabSchedule('* * * * *'));

        return $job;
    }
}
