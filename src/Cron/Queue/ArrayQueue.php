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

class ArrayQueue implements QueueInterface
{
    /**
     * @var \SplPriorityQueue
     */
    protected $queue;

    /**
     * Create an empty queue.
     */
    public function __construct()
    {
        $this->queue = new \SplPriorityQueue();
    }

    /**
     * Get the next command on the queue.
     *
     * @return CommandInterface
     */
    public function next()
    {
        $command = $this->queue->current();
        $this->queue->next();

        return $command;
    }

    /**
     * Remove the command from the queue.
     *
     * @param \Cron\Command\CommandInterface $command
     * @return mixed
     */
    public function remove(CommandInterface $command)
    {
        //$this->queue->dequeue($command);
    }

    /**
     * Add a command to the queue.
     *
     * @param \Cron\Command\CommandInterface $command
     * @return mixed
     */
    public function add(CommandInterface $command)
    {
        $this->queue->insert($command, 0);
    }


}