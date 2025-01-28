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
 * ShellJob is a job for running shell commands.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ShellJob extends AbstractProcessJob
{
    /**
     * Set the command to execute as if you would run it in the shell.
     *
     * @param string $command
     */
    public function setCommand($command, $cwd = null, ?array $env = null, $input = null, $timeout = 60, array $options = [])
    {
        if (method_exists(Process::class, 'fromShellCommandline')) {
            $this->process = Process::fromShellCommandline($command, $cwd, $env, $input, $timeout);

        } else {
            $this->process = new Process($command, $cwd, $env, $input, $timeout);
        }
    }
}
