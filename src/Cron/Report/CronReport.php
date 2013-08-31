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

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class CronReport implements ReportInterface
{
    /**
     * @var int
     */
    protected $successCount;

    /**
     * @var int
     */
    protected $failureCount;

    /**
     * @var JobReport[]
     */
    protected $taskReports;

    public function __construct()
    {
        $this->failureCount = 0;
        $this->successCount = 0;
    }
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return 0 == $this->failureCount;
    }

    /**
     * @param JobReport $report
     */
    public function addSuccess(JobReport $report)
    {
        $this->taskReports[] = $report;
        $this->successCount++;
    }

    /**
     * @param JobReport $report
     */
    public function addFailure(JobReport $report)
    {
        $this->taskReports[] = $report;
        $this->failureCount++;
    }

    public function addJobReport(JobReport $report)
    {

    }
}
