<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Builder;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class SchemaBuilder
{
    /**
     * @var string
     */
    private $minute;

    /**
     * @var string
     */
    private $hour;

    /**
     * @var string
     */
    private $dayOfMonth;

    /**
     * @var string
     */
    private $month;

    /**
     * @var string
     */
    private $dayOfWeek;

    /**
     * @var string
     */
    private $year;

    /**
     * @param string $minute
     * @param string $hour
     * @param string $dayOfMonth
     * @param string $month
     * @param string $dayOfWeek
     * @param string $year
     */
    public function __construct(
        $minute = '*',
        $hour = '*',
        $dayOfMonth = '*',
        $month = '*',
        $dayOfWeek = '*',
        $year = '*'
    ) {
        $this->minute = $minute;
        $this->hour = $hour;
        $this->dayOfMonth = $dayOfMonth;
        $this->month = $month;
        $this->dayOfWeek = $dayOfWeek;
        $this->year = $year;
    }

    /**
     * @param string $minute
     *
     * @return $this
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;

        return $this;
    }

    /**
     * @param string $hour
     *
     * @return $this
     */
    public function setHour($hour)
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * @param string $dayOfMonth
     *
     * @return $this
     */
    public function setDayOfMonth($dayOfMonth)
    {
        $this->dayOfMonth = $dayOfMonth;

        return $this;
    }

    /**
     * @param string $month
     *
     * @return $this
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @param string $dayOfWeek
     *
     * @return $this
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    /**
     * @param string $year
     *
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return string
     */
    public function getSchema()
    {
        return sprintf(
            '%s %s %s %s %s %s',
            $this->minute,
            $this->hour,
            $this->dayOfMonth,
            $this->month,
            $this->dayOfWeek,
            $this->year
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getSchema();
    }
}
