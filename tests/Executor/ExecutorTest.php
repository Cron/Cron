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
use Cron\Report\ReportInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ExecutorTest extends TestCase
{
    /**
     * @var ExecutorInterface
     */
    protected $executor;

    protected function setUp(): void
    {
        $this->executor = new Executor();
    }

    protected function tearDown(): void
    {
        unset($this->executor);
    }

    public function testExecute()
    {
        $job = new ShellJob();
        $job->setCommand('ls -la > test.log');
        $job->setCommand('du -h -d 1 /Users/driesdepeuter/Programming');

        $this->assertInstanceOf(ReportInterface::class, $this->executor->execute([$job]));
    }
}
