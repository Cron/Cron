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

class CallbackCommand implements \Cron\Command\CommandInterface
{
    protected $hash;
    protected $callback;

    public function __construct($hash, $callback)
    {
        $this->hash = $hash;
        $this->callback = $callback;
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
        return call_user_func($this->callback);
    }

}