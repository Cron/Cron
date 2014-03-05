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
use Cron\Report\ReportInterface;
use Symfony\Component\Process\Process;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ShellJob extends AbstractJob
{
    /**
     * @var Process
     */
    protected $process;

    protected $pid;

    public function setCommand($command)
    {
        $this->process = new Process($command);
    }

    public function getProcess()
    {
        return $this->process;
    }

    /**
     * @param mixed $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    public function run(JobReport $report)
    {
        $this->getProcess()->start(function ($type, $buffer) use ($report) {
            if (Process::ERR === $type) {
                $report->addError($buffer);
            } else {
                $report->addOutput($buffer);
            }
        });
    }

    public function valid(\DateTime $now)
    {
        return parent::valid($now) && $this->getProcess() && !$this->isRunning();
    }

    public function isRunning()
    {
        if (is_null($this->pid)) {
            return $this->getProcess()->isRunning();
        }

        return (bool)posix_getpgid($this->pid);
    }

}
