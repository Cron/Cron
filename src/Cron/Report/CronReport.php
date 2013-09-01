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

    }
}
