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

use Cron\Report\CronReport;
use Cron\Job\JobInterface;
use Cron\Report\ReportInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Executor implements ExecutorInterface
{
    /**
     * @var ExecutorSet[]
     */
    protected $sets = array();

    /**
     * @param  JobInterface[]  $jobs
     * @return ReportInterface
     */
    public function execute(array $jobs)
    {
        $report = new CronReport();

        $this->prepareSets($jobs);
        $this->startProcesses($report);

        return $report;
    }

    /**
     * @param JobInterface[] $jobs
     */
    protected function prepareSets(array $jobs)
    {
        foreach ($jobs as $job) {
            if ($job->valid(new \DateTime())) {
                $set = new ExecutorSet();
                $set->setJob($job);
                $set->setReport($job->createReport());
                $this->sets[] = $set;
            }
        }
    }

    protected function startProcesses(CronReport $report)
    {
        foreach ($this->sets as $set) {
            $report->addJobReport($set->getReport());
            $set->run();
        }
    }

    public function isRunning()
    {
        foreach ($this->sets as $set) {
            if ($set->getJob()->isRunning()) {
                return true;
            }
        }

        return false;
    }
}
