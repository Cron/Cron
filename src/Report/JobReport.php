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

/**
 * JobReport contains the output of a job.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class JobReport implements ReportInterface
{
    protected $job;
    protected $error = [];
    protected $output = [];
    protected $startTime;
    protected $endTime;
    protected $successful;

    /**
     * @param JobInterface $job
     */
    public function __construct(JobInterface $job)
    {
        $this->job = $job;
    }

    /**
     * @param bool $state
     */
    public function setSuccessful($state)
    {
        $this->successful = $state;
    }

    /**
     * @return bool|null
     */
    public function isSuccessful()
    {
        return $this->successful;
    }

    /**
     * @param string $line
     */
    public function addError($line)
    {
        $this->error[] = $line;
    }

    /**
     * @param string $line
     */
    public function addOutput($line)
    {
        $this->output[] = $line;
    }

    /**
     * @return JobInterface
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @return string[]
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return string[]
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param float $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return float
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param float $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return float
     */
    public function getStartTime()
    {
        return $this->startTime;
    }
}
