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

use Cron\Job\JobInterface;
use Cron\Report\ReportInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface ExecutorInterface
{
    /**
     * @param  JobInterface[]    $jobs
     * @return ReportInterface[]
     */
    public function execute(array $jobs);
}
