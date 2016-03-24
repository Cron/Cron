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

use Cron\Schedule\ScheduleInterface;
use Cron\Report\JobReport;

/**
 * JobInterface is the interface implemented by all jobs.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface JobInterface
{
    /**
     * Set the task schedule.
     *
     * @param ScheduleInterface $schedule
     */
    public function setSchedule(ScheduleInterface $schedule);

    /**
     * @return ScheduleInterface
     */
    public function getSchedule();

    /**
     * @param \DateTime $now
     *
     * @return bool
     */
    public function valid(\DateTime $now);

    /**
     * @return JobReport
     */
    public function createReport();

    /**
     * @param JobReport $report
     */
    public function run(JobReport $report);

    /**
     * @return bool
     */
    public function isRunning();
}
