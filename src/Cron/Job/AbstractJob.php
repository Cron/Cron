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
use Cron\Schedule\ScheduleInterface;

/**
 * AbstractJob base job class.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
abstract class AbstractJob implements JobInterface
{
    /**
     * @var ScheduleInterface
     */
    protected $schedule;

    /**
     * {@inheritdoc}
     */
    public function setSchedule(ScheduleInterface $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @return ScheduleInterface
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Validate the job.
     *
     * @param \DateTime $now
     *
     * @return bool
     */
    public function valid(\DateTime $now)
    {
        return !$this->schedule || $this->schedule->valid($now);
    }

    /**
     * @return JobReport
     */
    public function createReport()
    {
        return new JobReport($this);
    }
}
