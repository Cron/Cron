<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Resolver;

use Cron\Job\JobInterface;

/**
 * ArrayResolver resolves jobs from an array of jobs.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ArrayResolver implements ResolverInterface
{
    /**
     * @var JobInterface[]
     */
    protected $jobs;

    /**
     * @param array $jobs
     */
    public function __construct(array $jobs = [])
    {
        $this->jobs = $jobs;
    }

    /**
     * @param JobInterface $job
     */
    public function addJob(JobInterface $job)
    {
        $this->jobs[] = $job;
    }

    /**
     * @param JobInterface[] $jobs
     */
    public function addJobs(array $jobs)
    {
        $this->jobs = array_merge($this->jobs, $jobs);
    }

    /**
     * @return JobInterface[]
     */
    public function resolve()
    {
        $jobs = [];
        $now = new \DateTime();

        foreach ($this->jobs as $job) {
            if ($job->valid($now)) {
                $jobs[] = $job;
            }
        }

        return $jobs;
    }
}
