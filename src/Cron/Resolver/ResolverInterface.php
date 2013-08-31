<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Resolver;

use Cron\Job\JobInterface;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface ResolverInterface
{
    /**
     * @return JobInterface[]
     */
    public function resolve();
}
