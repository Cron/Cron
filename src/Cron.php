<?php

/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron;

use Cron\Executor\Executor;
use Cron\Executor\ExecutorInterface;
use Cron\Resolver\ResolverInterface;

/**
 * Cron is the main class of the project.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Cron
{
    /**
     * @var ResolverInterface
     */
    private $resolver;

    /**
     * @var ExecutorInterface
     */
    private $executor;

    /**
     * @return Report\ReportInterface[]
     */
    public function run()
    {
        return $this->getExecutor()->execute($this->getResolver()->resolve());
    }

    /**
     * @param ResolverInterface $resolver
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @return ResolverInterface
     */
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * @param ExecutorInterface $executor
     */
    public function setExecutor(ExecutorInterface $executor)
    {
        $this->executor = $executor;
    }

    /**
     * @return ExecutorInterface
     */
    public function getExecutor()
    {
        if (is_null($this->executor)) {
            $this->executor = new Executor();
        }

        return $this->executor;
    }

    /**
     * @return bool
     */
    public function isRunning()
    {
        return $this->executor->isRunning();
    }
}
