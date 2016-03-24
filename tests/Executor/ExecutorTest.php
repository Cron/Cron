<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Executor;

use Cron\Job\ShellJob;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ExecutorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExecutorInterface
     */
    protected $executor;

    public function setUp()
    {
        $this->executor = new Executor();
    }

    public function tearDown()
    {
        unset($this->executor);
    }

    public function testExecute()
    {
        $job = new ShellJob();
        $job->setCommand('ls -la > test.log');
        $job->setCommand('du -h -d 1 /Users/driesdepeuter/Programming');

        $this->executor->execute([$job]);
    }
}
