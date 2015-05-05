<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Executor;

use Cron\Job\JobInterface;
use Cron\Report\ReportInterface;
use Cron\Report\JobReport;

/**
 * ExecutorSet is the collection of a job and its reports.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ExecutorSet
{
    /**
     * @var JobInterface
     */
    protected $job;

    /**
     * @var ReportInterface
     */
    protected $report;

    /**
     * @param JobInterface $job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }

    /**
     * @return JobInterface
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param ReportInterface $report
     */
    public function setReport($report)
    {
        $this->report = $report;
    }

    /**
     * @return JobReport
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Runs the job.
     */
    public function run()
    {
        $this->job->run($this->getReport());
    }
}
