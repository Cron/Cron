<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Job;

use Cron\Report\JobReport;
use Cron\Schedule\CrontabSchedule;
use PHPUnit\Framework\TestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class PhpJobTest extends TestCase
{
    /**
     * @var PhpJob
     */
    protected $phpJob;

    protected function setUp(): void
    {
        $this->phpJob = new PhpJob();
    }

    protected function tearDown(): void
    {
        unset($this->phpJob);
    }

    public function testRunning()
    {
        $scheduleMock = $this->getMockBuilder(CrontabSchedule::class)
            ->getMock();
        $scheduleMock
            ->expects($this->exactly(2))
            ->method('valid')
            ->will($this->returnValue(true));

        $this->phpJob->setSchedule($scheduleMock);
        $expected = 'hello world!';
        $this->phpJob->setScript("<?php echo '$expected';\n");

        $this->assertTrue($this->phpJob->valid(new \DateTime()));
        $this->phpJob->run(new JobReport($this->phpJob));
        $this->assertTrue($this->phpJob->isRunning());
        $this->assertFalse($this->phpJob->valid(new \DateTime()));

        $this->phpJob->getProcess()->wait();
        $output = $this->phpJob->getProcess()->getOutput();
        $this->assertEquals($expected, $output);
    }
}
