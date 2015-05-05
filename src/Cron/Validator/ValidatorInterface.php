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
 * ValidatorInterface implemented by all validators.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface ValidatorInterface
{
    /**
     * Validate the pattern. On failure throw an InvalidPatternException.
     *
     * @param string $pattern
     *
     * @throws InvalidPatternException
     *
     * @return string
     */
    public function validate($pattern);
}
