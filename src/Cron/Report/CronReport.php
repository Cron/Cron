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

use Cron\Job\AbstractJob;
use Cron\Job\JobInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class CronReport implements ReportInterface
{
    /**
     * @var JobReport[]
     */
    protected $taskReports;

    /**
     * @return bool
     */
    public function isSuccessful()
    {

    }

    public function addJobReport(JobReport $report)
    {
        $this->taskReports[] = $report;
    }

    public function getReports()
    {
        return $this->taskReports;
    }

    public function getReport(JobInterface $job)
    {
        foreach ($this->taskReports as $report) {
            if ($report->getJob() == $job) {
                return $report;
            }
        }

        return null;
    }
}
