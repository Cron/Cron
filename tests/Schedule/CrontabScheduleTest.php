<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Schedule;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class CrontabScheduleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CrontabSchedule
     */
    protected $schedule;

    public function setUp()
    {
        $this->schedule = new CrontabSchedule();
    }

    public function tearDown()
    {
        unset($this->schedule);
    }

    /**
     * @dataProvider validPatternProvider
     */
    public function testValidPatterns($pattern)
    {
        $this->schedule->setPattern($pattern);
    }

    public function validPatternProvider()
    {
        return [
            ['* * * * *'],
            ['* * * * * *'],
            ['*/2 * * * *'],
            ['* */2 * * *'],
            ['* * */2 * *'],
            ['* * * */2 *'],
            ['* * * * */2'],
            ['* * * * * */2'],
            ['1 * * * */2'],
            ['1,3 * * * */2'],
            ['1 * 1,2 * */2'],
            ['1 * 1-2 * */2'],
            ['1 * 1-2 * */2 */2'],
            ['@yearly'],
            ['@annually'],
            ['@monthly'],
            ['@weekly'],
            ['@daily'],
            ['@hourly'],
        ];
    }

    /**
     * @dataProvider invalidPatternProvider
     */
    public function testInvalidPatterns($pattern)
    {
        $this->setExpectedException('\Cron\Exception\InvalidPatternException');
        $this->schedule->setPattern($pattern);
    }

    public function invalidPatternProvider()
    {
        return [
            ['* * * *'],
            ['* * * * * '],
            [' * * * * *'],
            ['a * * * *'],
            ['* a * * *'],
            ['* * a * *'],
            ['* * * a *'],
            ['* * * * a'],
            ['60 * * * *'],
            ['1-60 * * * *'],
            ['* 24 * * *'],
            ['* 1-24 * * *'],
            ['* * 32 * *'],
            ['* * 1-32 * *'],
            ['* * * 13 *'],
            ['* * * 1-13 *'],
            ['* * * * 7'],
            ['* * * * 1-7'],
            ['@unknown'],
        ];
    }

    /**
     * @dataProvider validTrueProvider
     */
    public function testValidTrue($pattern, $now)
    {
        $this->schedule->setPattern($pattern);
        $this->assertTrue($this->schedule->valid($now));
    }

    public function validTrueProvider()
    {
        $data = [];
        foreach ($this->dateProvider() as $now) {
            $min = $now->format('i');
            $hour = $now->format('H');
            $day = $now->format('d');
            $month = $now->format('n');
            $dow = $now->format('w');

            $data[] = ['* * * * *', $now];
            $data[] = [$min.' * * * *',  $now];
            $data[] = ['* '.$hour.' * * *', $now];
            $data[] = ['* * '.$day.' * *', $now];
            $data[] = ['* * * '.$month.' *', $now];
            $data[] = ['* * * * '.$dow, $now];
        }

        return $data;
    }

    /**
     * @dataProvider validFalseProvider
     */
    public function testValidFalse($pattern, $now)
    {
        $this->schedule->setPattern($pattern);
        $this->assertFalse($this->schedule->valid($now));
    }

    public function validFalseProvider()
    {
        $data = [];
        foreach ($this->dateProvider() as $now) {
            $min = (int) $now->format('i');
            $badMin = ($min - 1 < 0) ? ($min + 1) : ($min - 1);
            $hour = (int) $now->format('H');
            $badHour = ($hour - 1 < 0) ? ($hour + 1) : ($hour - 1);
            $day = (int) $now->format('d');
            $badDay = ($day - 1 < 1) ? ($day + 1) : ($day - 1);
            $month = (int) $now->format('n');
            $badMonth = ($month - 1 < 1) ? ($month + 1) : ($month - 1);
            $dow = (int) $now->format('w');
            $badDow = ($dow - 1 < 0) ? ($dow + 1) : ($dow - 1);

            $data[] = [$badMin.' * * * *', $now];
            $data[] = ['* '.$badHour.' * * *', $now];
            $data[] = ['* * '.$badDay.' * *', $now];
            $data[] = ['* * * '.$badMonth.' *', $now];
            $data[] = ['* * * * '.$badDow, $now];
        }

        return $data;
    }

    /**
     * @return \DateTime[]
     */
    public function dateProvider()
    {
        return [
            new \DateTime(),
            new \DateTime('+1 day'),
            new \DateTime('+2 days'),
            new \DateTime('+3 days'),
            new \DateTime('+4 days'),
            new \DateTime('+5 days'),
            new \DateTime('+6 days'),
        ];
    }

    /**
     * @dataProvider parseRuleProvider
     */
    public function testParseRule($expected, $rule, $minMax)
    {
        $method = new \ReflectionMethod('\Cron\Schedule\CrontabSchedule', 'parseRule');
        $method->setAccessible(true);

        $this->assertEquals($expected, $method->invoke(new CrontabSchedule(), $rule, $minMax[0], $minMax[1]));
    }

    public function parseRuleProvider()
    {
        return [
            [[1], '1', [0, 59]],
            [[1, 2], '1,2', [0, 59]],
            [[2, 3, 4], '2-4', [0, 59]],
            [[0, 30], '*/30', [0, 59]],
            [[0, 15, 30, 45], '*/15', [0, 59]],
        ];
    }

    public function testPatternSetters()
    {
        $pattern = '* * * * *';
        $this->schedule->setPattern($pattern);

        $this->assertEquals($pattern, $this->schedule->getPattern());

        $schedule = new CrontabSchedule($pattern);
        $this->assertEquals($pattern, $schedule->getPattern());
    }

    /**
     * Minutes validation broke validation of the seconds where at 0.
     *
     * @link https://github.com/Cron/Cron/issues/12
     */
    public function testBadSecondsValidation()
    {
        $this->schedule->setPattern('*/5 * * * *');

        for ($i = 0; $i < 60; $i++) {
            $now = new \DateTime('2014-12-27 13:11:'.$i);
            $this->assertFalse($this->schedule->valid($now));
        }
    }
}
