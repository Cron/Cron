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

use Cron\Job\JobInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class JobReport implements ReportInterface
{
    protected $job;
    protected $error = array();
    protected $output = array();

    /**
     * @param JobInterface $job
     */
    public function __construct(JobInterface $job)
    {
        $this->job = $job;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {

    }

    /**
     * @param string $line
     */
    public function addError($line)
    {
        $this->error[] = $line;
    }

    /**
     * @param string $line
     */
    public function addOutput($line)
    {
        $this->output[] = $line;
    }

    /**
     * @return JobInterface
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return array
     */
    public function getOutput()
    {
        return $this->output;
    }
}
