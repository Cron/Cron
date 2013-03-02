<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Lock;

use Cron\Command\CommandInterface;

interface LockInterface
{
    /**
     * Check if a command is locked.
     *
     * @param \Cron\Command\CommandInterface $command
     * @return bool
     */
    public function isLocked(CommandInterface $command);

    /**
     * Lock a command.
     *
     * @param \Cron\Command\CommandInterface $command
     * @return bool
     */
    public function setLock(CommandInterface $command);

    /**
     * Remove the lock.
     *
     * @param \Cron\Command\CommandInterface $command
     * @return bool
     */
    public function removeLock(CommandInterface $command);
}
