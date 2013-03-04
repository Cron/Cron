<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Cron;

use Cron\Lock\LockInterface;
use Cron\Queue\QueueInterface;

class Cron
{
    /**
     * @var Lock\LockInterface
     */
    protected $lock;

    /**
     * @var Queue\QueueInterface
     */
    protected $queue;

    /**
     * Build the cron object.
     *
     * @param Lock\LockInterface $lock
     * @param Queue\QueueInterface $queue
     */
    public function __construct(LockInterface $lock, QueueInterface $queue)
    {
        $this->lock = $lock;
        $this->queue = $queue;
    }

    /**
     * Execute the the first cron command.
     */
    public function execute()
    {
        $command = $this->getCommand();

	    if ($command) {
	        $this->lock->setLock($command);

	        $result = $command->execute();

	        $this->lock->removeLock($command);
	        $this->queue->remove($command);

	        return $result;
	    }
	    return false;
    }

    /**
     * Get the first command free to execute.
     *
     * @return Command\CommandInterface
     */
    protected function getCommand()
    {
        do {
            $command = $this->queue->next();
        }
        while ($command && $this->lock->isLocked($command));

        return $command;
    }
}
