<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Schedule;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface ScheduleInterface
{
    /**
     * @param  \DateTime $lastRun
     * @param  \DateTime $now
     * @return bool
     */
    public function valid(\DateTime $lastRun, \DateTime $now);
}
