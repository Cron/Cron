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
        return array(
            array('* * * * *'),
            array('* * * * * *'),
            array('*/2 * * * *'),
            array('* */2 * * *'),
            array('* * */2 * *'),
            array('* * * */2 *'),
            array('* * * * */2'),
            array('* * * * * */2'),
            array('1 * * * */2'),
            array('1,3 * * * */2'),
            array('1 * 1,2 * */2'),
            array('1 * 1-2 * */2'),
            array('1 * 1-2 * */2 */2'),
            array('@yearly'),
            array('@annually'),
            array('@monthly'),
            array('@weekly'),
            array('@daily'),
            array('@hourly'),
        );
    }

    /**
     * @dataProvider invalidPatternProvider
     */
    public function testInvalidPatterns($pattern)
    {
        $this->setExpectedException('\InvalidArgumentException');
        $this->schedule->setPattern($pattern);
    }

    public function invalidPatternProvider()
    {
        return array(
            array('* * * *'),
            array('* * * * * '),
            array(' * * * * *'),
            array('a * * * *'),
            array('* a * * *'),
            array('* * a * *'),
            array('* * * a *'),
            array('* * * * a'),
            array('60 * * * *'),
            array('1-60 * * * *'),
            array('* 24 * * *'),
            array('* 1-24 * * *'),
            array('* * 32 * *'),
            array('* * 1-32 * *'),
            array('* * * 13 *'),
            array('* * * 1-13 *'),
            array('* * * * 7'),
            array('* * * * 1-7'),
            array('@unknown'),
        );
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
        $data = array();
        foreach ($this->dateProvider() as $now) {
            $min = $now->format('i');
            $hour = $now->format('H');
            $day = $now->format('d');
            $month = $now->format('n');
            $dow = $now->format('w');

            $data[] = array('* * * * *', $now);
            $data[] = array($min . ' * * * *',  $now);
            $data[] = array('* ' . $hour . ' * * *', $now);
            $data[] = array('* * ' . $day . ' * *', $now);
            $data[] = array('* * * ' . $month . ' *', $now);
            $data[] = array('* * * * ' . $dow, $now);
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
        $data = array();
        foreach ($this->dateProvider() as $now) {
            $min = (int)$now->format('i');
            $badMin = ($min - 1 < 0) ? ($min + 1) : ($min - 1);
            $hour = (int)$now->format('H');
            $badHour = ($hour - 1 < 0) ? ($hour + 1) : ($hour - 1);
            $day = (int)$now->format('d');
            $badDay = ($day - 1 < 1) ? ($day + 1) : ($day - 1);
            $month = (int)$now->format('n');
            $badMonth = ($month - 1 < 0) ? ($month + 1) : ($month - 1);
            $dow = (int)$now->format('w');
            $badDow = ($dow - 1 < 0) ? ($dow + 1) : ($dow - 1);

            $data[] = array($badMin . ' * * * *', $now);
            $data[] = array('* ' . $badHour . ' * * *', $now);
            $data[] = array('* * ' . $badDay . ' * *', $now);
            $data[] = array('* * * ' . $badMonth . ' *', $now);
            $data[] = array('* * * * ' . $badDow, $now);
        }

        return $data;
    }

    /**
     * @return \DateTime[]
     */
    public function dateProvider()
    {
        return array(
            new \DateTime(),
            new \DateTime('+1 day'),
            new \DateTime('+2 days'),
            new \DateTime('+3 days'),
            new \DateTime('+4 days'),
            new \DateTime('+5 days'),
            new \DateTime('+6 days'),
        );
    }

    /**
     * @dataProvider parseRuleProvider
     */
    public function testParseRule($expected, $rule, $minMax)
    {
        $method = new \ReflectionMethod('\Cron\Schedule\CrontabSchedule', 'parseRule');
        $method->setAccessible(true);

        $this->assertEquals($expected, $method->invoke(new CrontabSchedule, $rule, $minMax[0], $minMax[1]));
    }

    public function parseRuleProvider()
    {
        return array(
            array(array(1), '1', array(0, 59)),
            array(array(1, 2), '1,2', array(0, 59)),
            array(array(2, 3, 4), '2-4', array(0, 59)),
            array(array(0, 30), '*/30', array(0, 59)),
            array(array(0, 15, 30, 45), '*/15', array(0, 59)),
        );
    }

    public function testPatternSetters()
    {
        $pattern = '* * * * *';
        $this->schedule->setPattern($pattern);

        $this->assertEquals($pattern, $this->schedule->getPattern());

        $schedule = new CrontabSchedule($pattern);
        $this->assertEquals($pattern, $schedule->getPattern());
    }
}
