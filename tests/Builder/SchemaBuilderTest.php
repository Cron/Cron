<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Builder;

class SchemaBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $builder = new SchemaBuilder();

        $this->assertEquals('* * * * * *', $builder->getSchema());
    }

    public function testToString()
    {
        $builder = new SchemaBuilder();

        $this->assertEquals('* * * * * *', (string) $builder);
    }

    public function testMinute()
    {
        $builder = new SchemaBuilder();
        $builder->setMinute(2);

        $this->assertEquals('2 * * * * *', $builder->getSchema());
    }

    public function testHour()
    {
        $builder = new SchemaBuilder();
        $builder->setHour(2);

        $this->assertEquals('* 2 * * * *', $builder->getSchema());
    }

    public function testDayOfMonth()
    {
        $builder = new SchemaBuilder();
        $builder->setDayOfMonth(2);

        $this->assertEquals('* * 2 * * *', $builder->getSchema());
    }

    public function testMonth()
    {
        $builder = new SchemaBuilder();
        $builder->setMonth(2);

        $this->assertEquals('* * * 2 * *', $builder->getSchema());
    }

    public function testDayOfWeek()
    {
        $builder = new SchemaBuilder();
        $builder->setDayOfWeek(2);

        $this->assertEquals('* * * * 2 *', $builder->getSchema());
    }

    public function testYear()
    {
        $builder = new SchemaBuilder();
        $builder->setYear(2000);

        $this->assertEquals('* * * * * 2000', $builder->getSchema());
    }

    public function testChaining()
    {
        $builder = new SchemaBuilder();
        $builder
            ->setMinute(2)
            ->setHour(2)
            ->setDayOfMonth(2)
            ->setMonth(2)
            ->setDayOfWeek(2)
            ->setYear(2000);

        $this->assertEquals('2 2 2 2 2 2000', $builder->getSchema());
    }

    public function testConstructor()
    {
        $builder = new SchemaBuilder(2, 2, 2, 2, 2, 2000);

        $this->assertEquals('2 2 2 2 2 2000', $builder->getSchema());
    }
}
