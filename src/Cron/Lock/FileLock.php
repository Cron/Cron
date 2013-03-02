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

class FileLock implements LockInterface
{
    protected $file;

    protected $locks;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            if (!is_dir(dirname($file))) {
                throw new \InvalidArgumentException('The directory does not exist.');
            }
            elseif (!is_writable(dirname($file))) {
                throw new \InvalidArgumentException('The directory does not writeable.');
            }
        }

        $this->file = $file;
    }

    /**
     * Check if a command is locked.
     *
     * @param \Cron\Command\CommandInterface $command
     * @return bool
     */
    public function isLocked(CommandInterface $command)
    {
        return in_array($command->getHash(), $this->getLocks());
    }

    /**
     * Lock a command.
     *
     * @param \Cron\Command\CommandInterface $command
     * @return bool
     */
    public function setLock(CommandInterface $command)
    {
        if (!in_array($command->getHash(), $this->getLocks())) {
            $this->locks[] = $command->getHash();
            $this->writeLocks();
        }
        return true;
    }

    /**
     * Remove the lock.
     *
     * @param \Cron\Command\CommandInterface $command
     * @return bool
     */
    public function removeLock(CommandInterface $command)
    {
        if ($this->isLocked($command)) {
            unset($this->locks[array_search($command->getHash(), $this->getLocks())]);
            $this->writeLocks();
        }
        return true;
    }

    protected function getLocks()
    {
        if (is_null($this->locks)) {
            $file = file_get_contents($this->file);
            $this->locks = array_filter(explode("\n", $file));
        }
        return $this->locks;
    }

    protected function writeLocks()
    {
        file_put_contents($this->file, implode("\n", $this->getLocks()));
    }
}
