<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Test;

use Cron\Command\CallbackCommand;
use Cron\Cron;
use Cron\Lock\FileLock;
use Cron\Queue\ArrayQueue;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;

class CronTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $root = vfsStream::setup();
        $dir = new vfsStreamDirectory('lockDir');
        $file = new vfsStreamFile('lockFile');
        $dir->addChild($file);
        $root->addChild($dir);
    }

    public function test()
    {
        $command1 = new CallbackCommand('testCommand', function() {
            return 'command1';
        });
        $command2 = new CallbackCommand('testCommand2', function() {
            return 'command2';
        });

        $queue = new ArrayQueue();
        $queue->add($command1);
        $queue->add($command2);

        $lock = new FileLock(vfsStream::url('lockDir/lockFile'));
        $cron = new Cron($lock, $queue);

        $this->assertEquals('command1', $cron->execute());
        $this->assertEquals('command2', $cron->execute());
    }

	public function testEmptyQueue()
	{
		$queue = new ArrayQueue();

		$lock = new FileLock(vfsStream::url('lockDir/lockFile'));
		$cron = new Cron($lock, $queue);

		$this->assertFalse($cron->execute());
	}
}