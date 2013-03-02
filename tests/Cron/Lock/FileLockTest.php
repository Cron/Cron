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

use Cron\Lock\FileLock;
use Cron\Stubs\Command;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use org\bovigo\vfs\vfsStreamWrapper;

require_once(__DIR__ . '/../../Stubs/Command.php');

class FileLockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    protected $dir;
    protected $file;

    public function setUp()
    {
        $root = vfsStream::setup();
        $this->dir = new vfsStreamDirectory('lockDir');
        $this->file = new vfsStreamFile('lockFile');
        $this->dir->addChild($this->file);
        $root->addChild($this->dir);
    }

    public function testDirectoryException()
    {
        $this->setExpectedException('InvalidArgumentException');

        new FileLock('/non-existing/test');
    }

    public function testSetLock()
    {
        $file = vfsStream::url('lockDir/lockFile');
        file_put_contents($file, '');

        $lock = new FileLock($file);

        $lock->setLock(new Command('testCommand'));

        $this->assertEquals('testCommand', file_get_contents($file));
    }

    public function testSet2Locks()
    {
        $file = vfsStream::url('lockDir/lockFile');
        file_put_contents($file, '');

        $lock = new FileLock($file);

        $lock->setLock(new Command('testCommand'));
        $lock->setLock(new Command('testCommand2'));

        $this->assertEquals("testCommand\ntestCommand2", file_get_contents($file));
    }

    public function testIsLocked()
    {
        $file = vfsStream::url('lockDir/lockFile');
        file_put_contents($file, '');

        $lock = new FileLock($file);

        $command1 = new Command('testCommand');
        $command2 = new Command('testCommand2');

        $lock->setLock($command1);

        $this->assertTrue($lock->isLocked($command1));
        $this->assertFalse($lock->isLocked($command2));
    }

    public function testRemoveLock()
    {
        $file = vfsStream::url('lockDir/lockFile');
        file_put_contents($file, '');

        $lock = new FileLock($file);

        $command = new Command('testCommand');

        $lock->setLock($command);
        $lock->removeLock($command);

        $this->assertFalse($lock->isLocked($command));
    }
}
