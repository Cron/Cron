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
use Symfony\Component\Process\Process;

/**
 * AbstractProcessJob Base for all process jobs.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
abstract class AbstractProcessJob extends AbstractJob
{
    /**
     * The symfony process instance.
     *
     * @var Process
     */
    protected $process;

    /**
     * @var JobReport
     */
    protected $report;

    /**
     * The process id.
     *
     * @var int
     */
    protected $pid;

    /**
     * @return Process
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * @param int $pid
     */
    protected function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * Start the process.
     *
     * @param JobReport $report
     */
    public function run(JobReport $report)
    {
        $this->report = $report;
        $report->setStartTime(microtime(true));
        $this->getProcess()->start(function ($type, $buffer) use ($report) {
            if (Process::ERR === $type) {
                $report->addError($buffer);
            } else {
                $report->addOutput($buffer);
            }
        });
    }

    /**
     * Validate the job.
     *
     * Will check if we have a process and make sure it isn't already running.
     *
     * @param \DateTime $now
     *
     * @return bool
     */
    public function valid(\DateTime $now)
    {
        return parent::valid($now) && $this->getProcess() && !$this->isRunning();
    }

    /**
     * Validate if the process is running.
     *
     * @return bool
     */
    public function isRunning()
    {
        $running = $this->isProcessRunning();

        if (!$running && $this->getProcess()->isStarted()) {
            $this->registerEnd();
            $this->registerSuccessful();
        }

        return $running;
    }

    /**
     * @return bool
     */
    protected function isProcessRunning()
    {
        if (is_null($this->pid)) {
            return $this->getProcess()->isRunning();
        }

        return (bool) posix_getpgid($this->pid);
    }

    /**
     * Register the end of a job to the report.
     */
    protected function registerEnd()
    {
        if (is_null($this->report->getEndTime())) {
            $this->report->setEndTime(microtime(true));
        }
    }

    /**
     * Register the end state.
     */
    protected function registerSuccessful()
    {
        $this->report->setSuccessful($this->getProcess()->isSuccessful());
    }
}
