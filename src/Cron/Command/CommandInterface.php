<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Command;

interface CommandInterface
{
    /**
     * Return a unique string identifying this command.
     *
     * @return string
     */
    public function getHash();

    public function execute();
}
