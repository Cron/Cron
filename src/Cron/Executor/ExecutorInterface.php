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
 * ExecutorInterface is the interface implemented by all executor classes.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface ExecutorInterface
{
    /**
     * Execute the jobs.
     *
     * @param JobInterface[] $jobs
     *
     * @return ReportInterface
     */
    public function execute(array $jobs);

    /**
     * Check if a job is running.
     *
     * @return bool
     */
    public function isRunning();
}
