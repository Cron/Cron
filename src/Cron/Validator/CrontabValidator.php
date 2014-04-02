<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Validator;

use Cron\Exception\InvalidPatternException;
use Cron\Schedule\ScheduleInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class CrontabValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate($pattern)
    {
        $pattern = $this->findReplacements($pattern);

        if (false !== strpos($pattern, '@')) {
            throw new InvalidPatternException('Unknown shorthand.');
        }

        $parts = preg_split('/[\s\t]+/', $pattern);

        if (!isset($parts[0]) || !preg_match($this->buildPattern('[0-5]?\d'), $parts[0])) {
            throw new InvalidPatternException('Invalid minute.');
        }
        if (!isset($parts[1]) || !preg_match($this->buildPattern('[01]?\d|2[0-3]'), $parts[1])) {
            throw new InvalidPatternException('Invalid hour.');
        }
        if (!isset($parts[2]) || !preg_match($this->buildPattern('0?[1-9]|[12]\d|3[01]'), $parts[2])) {
            throw new InvalidPatternException('Invalid day.');
        }
        if (!isset($parts[3]) || !preg_match($this->buildPattern('[1-9]|1[012]'), $parts[3])) {
            throw new InvalidPatternException('Invalid month.');
        }
        if (!isset($parts[4]) || !preg_match($this->buildPattern('[0-6]'), $parts[4])) {
            throw new InvalidPatternException('Invalid day of week.');
        }
        if (isset($parts[5]) && !preg_match($this->buildPattern('20([0-9]{2})'), $parts[5])) {
            throw new InvalidPatternException('Invalid year.');
        }

        return $pattern;
    }

    /**
     * @param  string $rangeRegex
     * @return string
     */
    private function buildPattern($rangeRegex)
    {
        $range = '(' . $rangeRegex . ')(-(' . $rangeRegex . '))?';

        return '/^(\*(\/\d+)?|' . $range . '(,' . $range . ')*)$/';
    }

    /**
     * Translate known shorthands to basic cron syntax.
     *
     * @param  string $pattern
     * @return string
     */
    protected function findReplacements($pattern)
    {
        if (0 !== strpos($pattern, '@')) {
            return $pattern;
        }

        $replace = array(
            '@yearly'   => '0 0 1 1 * *',
            '@annually' => '0 0 1 1 * *',
            '@monthly'  => '0 0 1 * *',
            '@weekly'   => '0 0 * * 0',
            '@daily'    => '0 0 * * *',
            '@hourly'   => '0 * * * *',
        );
        if (isset($replace[$pattern])) {
            $pattern = $replace[$pattern];
        }

        return $pattern;
    }
}
