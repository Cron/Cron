<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Test\Queue;

use Cron\Queue\ArrayQueue;
use Cron\Stubs\Command;

require_once(__DIR__ . '/../../Stubs/Command.php');

class ArrayQueueTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $queue = new ArrayQueue();
        $command = new Command('testCommand');

        $queue->add($command);

        $this->assertEquals($command, $queue->next());
    }

    public function testAddMultiple()
    {
        $queue = new ArrayQueue();
        $command1 = new Command('testCommand');
        $command2 = new Command('testCommand2');

        $queue->add($command1);
        $queue->add($command2);

        $this->assertEquals($command1, $queue->next());
        $this->assertEquals($command2, $queue->next());
    }
}
