<?php
/**
 * This file is part of the Cron package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cron\Stubs;

class Command implements \Cron\Command\CommandInterface
{
    protected $hash;

    public function __construct($hash)
    {
        $this->hash = $hash;
    }

    /**
     * Return a unique string identifying this command.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    public function execute()
    {

    }

}