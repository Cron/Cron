<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Test\Lock;

use Cron\Command\CallbackCommand;

class CallbackCommandTest extends \PHPUnit_Framework_TestCase
{
   public function testHash()
   {
       $command = new CallbackCommand('hash', function() {});

       $this->assertEquals('hash', $command->getHash());
   }

    public function testCallback()
    {
        $command = new CallbackCommand('hash', function() {
            return 'testValue';
        });

        $this->assertEquals('testValue', $command->execute());
    }
}
