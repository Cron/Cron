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

use Symfony\Component\Process\Process;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ShellJob extends AbstractJob
{
    public function setCommand($command)
    {
        $this->process = new Process($command);
    }

    public function getProcess()
    {
        return $this->process;
    }
}
