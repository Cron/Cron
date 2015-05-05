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

use Symfony\Component\Process\PhpProcess;

/**
 * PhpJob is a job for running PHP scripts.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class PhpJob extends AbstractProcessJob
{
    /**
     * Set the script to execute. This is a php script in the form of a string.
     *
     * @param string $script
     */
    public function setScript($script)
    {
        $this->process = new PhpProcess($script);
    }
}
