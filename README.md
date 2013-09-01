Cron
====
 [![Latest Stable Version](https://poser.pugx.org/cron/cron/v/stable.png)](https://packagist.org/packages/cron/cron)
 [![Latest Unstable Version](https://poser.pugx.org/cron/cron/v/unstable.png)](//packagist.org/packages/cron/cron)
 [![Build Status](https://secure.travis-ci.org/NoUseFreak/Cron.png)](https://travis-ci.org/NoUseFreak/Cron)
 [![Total Downloads](https://poser.pugx.org/cron/cron/downloads.png)](https://packagist.org/packages/cron/cron)

Cron enables you to schedule tasks. Cron will search those that need execution and run them. 

Usage
-----

```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

$job = new \Cron\Job\ShellJob();
$job->setCommand('ls -la >> crontest.log');
$job->setSchedule(new \Cron\Schedule\CrontabSchedule('* * * * *'));

$resolver = new \Cron\Resolver\ArrayResolver();
$resolver->addJob($job);

$cron = new \Cron\Cron();
$cron->setExecutor(new \Cron\Executor\Executor());
$cron->setResolver($resolver);

$cron->run();
```

Installing
----------

Add the following to your project's composer.json:

```javascript
{
    "require": {
        "cron/cron": "1.0.*@dev"
    }
}
```

Crontab syntax
--------------

A CRON expression is a string representing the schedule for a particular command to execute.  The parts of a CRON schedule are as follows:

    *    *    *    *    *    *
    -    -    -    -    -    -
    |    |    |    |    |    |
    |    |    |    |    |    + year [optional]
    |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
    |    |    |    +---------- month (1 - 12)
    |    |    +--------------- day of month (1 - 31)
    |    +-------------------- hour (0 - 23)
    +------------------------- min (0 - 59)

Each of the parts supports wildcards (*), ranges (2-5) and lists (2,5,6,11).

Contributing
------------

> All code contributions - including those of people having commit access - must
> go through a pull request and approved by a core developer before being
> merged. This is to ensure proper review of all the code.
>
> Fork the project, create a feature branch, and send us a pull request.
>
> To ensure a consistent code base, you should make sure the code follows
> the [Coding Standards](http://symfony.com/doc/2.0/contributing/code/standards.html)
> which we borrowed from Symfony.
> Make sure to check out [php-cs-fixer](https://github.com/fabpot/PHP-CS-Fixer) as this will help you a lot.

If you would like to help take a look at the [list of issues](http://github.com/NoUseFreak/Cron/issues).

Requirements
------------

PHP 5.3.2 or above

Author and contributors
-----------------------

Dries De Peuter - <dries@nousefreak.be> - <http://nousefreak.be>

See also the list of [contributors](https://github.com/NoUseFreak/Cron/contributors) who participated in this project.

License
-------

Cron is licensed under the MIT license.
