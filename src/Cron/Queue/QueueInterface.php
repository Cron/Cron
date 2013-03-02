<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Queue;

use Cron\Command\CommandInterface;

interface QueueInterface
{
    /**
     * Get the next command on the queue.
     *
     * @return CommandInterface
     */
    public function next();

    /**
     * Remove the command from the queue.
     *
     * @param \Cron\Command\CommandInterface $command
     * @return mixed
     */
    public function remove(CommandInterface $command);
}