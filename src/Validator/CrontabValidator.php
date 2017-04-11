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

/**
 * CrontabValidator validates a schedule pattern.
 *
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

        $tests = [
            [
                'partName' => 'minute',
                'pattern' => '[0-5]?\d',
                'required' => true,
            ],
            [
                'partName' => 'hour',
                'pattern' => '[01]?\d|2[0-3]',
                'required' => true,
            ],
            [
                'partName' => 'day',
                'pattern' => '0?[1-9]|[12]\d|3[01]',
                'required' => true,
            ],
            [
                'partName' => 'month',
                'pattern' => '[1-9]|1[012]',
                'required' => true,
            ],
            [
                'partName' => 'day of week',
                'pattern' => '[0-7]',
                'required' => true,
            ],
            [
                'partName' => 'year',
                'pattern' => '20([0-9]{2})',
                'required' => false,
            ],
        ];

        foreach ($tests as $i => $test) {
            if (!$test['required'] && !isset($parts[$i])) {
                continue;
            }
            if (!isset($parts[$i]) || !preg_match($this->buildPattern($test['pattern']), $parts[$i])) {
                throw new InvalidPatternException(sprintf('Invalid %s "%s".', $test['partName'], isset($parts[$i]) ? $parts[$i] : ''));
            }
        }

        return $pattern;
    }

    /**
     * @param string $rangeRegex
     *
     * @return string
     */
    private function buildPattern($rangeRegex)
    {
        $range = '('.$rangeRegex.')(-('.$rangeRegex.'))?';

        return '/^(\*(\/\d+)?|'.$range.'(,'.$range.')*)$/';
    }

    /**
     * Translate known shorthands to basic cron syntax.
     *
     * @param string $pattern
     *
     * @return string
     */
    protected function findReplacements($pattern)
    {
        if (0 !== strpos($pattern, '@')) {
            return $pattern;
        }

        $replace = [
            '@yearly'   => '0 0 1 1 * *',
            '@annually' => '0 0 1 1 * *',
            '@monthly'  => '0 0 1 * *',
            '@weekly'   => '0 0 * * 0',
            '@daily'    => '0 0 * * *',
            '@hourly'   => '0 * * * *',
        ];
        if (isset($replace[$pattern])) {
            $pattern = $replace[$pattern];
        }

        return $pattern;
    }
}
