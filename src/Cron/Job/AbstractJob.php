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
use Symfony\Component\Process\Process;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
abstract class AbstractJob implements JobInterface
{
    /**
     * @var ScheduleInterface
     */
    protected $schedule;

    /**
     * @var Process
     */
    protected $process;

    /**
     * {@inheritDocs}
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

    public function getLastRun()
    {
        return new \DateTime('2 weeks ago');
    }

    public function valid(\DateTime $now)
    {
        return !$this->schedule || $this->schedule->valid($this->getLastRun(), $now);
    }

}
