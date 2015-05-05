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
 * ResolverInterface is the interface implemented by all resolvers.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
interface ResolverInterface
{
    /**
     * Return all available jobs.
     *
     * @return JobInterface[]
     */
    public function resolve();
}
