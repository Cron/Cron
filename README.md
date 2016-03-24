Cron
====
 [![Packagist](https://img.shields.io/packagist/v/cron/cron.svg?style=flat-square)](https://packagist.org/packages/cron/cron)
 [![Build Status](https://img.shields.io/travis/Cron/Cron.svg?style=flat-square)](https://travis-ci.org/Cron/Cron)
 [![Quality](https://img.shields.io/scrutinizer/g/Cron/Cron.svg?style=flat-square)](https://scrutinizer-ci.com/g/Cron/Cron)
 [![Coverage](https://img.shields.io/scrutinizer/coverage/g/Cron/Cron.svg?style=flat-square)](https://scrutinizer-ci.com/g/Cron/Cron)
 [![SensioLabs Insight](https://img.shields.io/sensiolabs/i/f4992bd7-896a-4340-b2b5-d3af5b281101.svg?style=flat-square)](https://insight.sensiolabs.com/projects/f4992bd7-896a-4340-b2b5-d3af5b281101)
 [![Packagist](https://img.shields.io/packagist/dt/Cron/Cron.svg?style=flat-square)](https://packagist.org/packages/cron/cron)
 [![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
 
This library enables you to have only one general crontab entry that will trigger several different cronjobs that can be
defined through this library. The Cron library will decide if the job needs to run or not.

**Attention**: make sure you set the server crontab job to a correctly chosen frequency because if there is for example
a cronjob defined in code to run every minute, your general crontab job needs to run at least every minute as well to
work properly.

Use Case
--------

Say you need two cronjobs in your application. One that will write the contents of a folder to a log file, and one that
will empty the folder. This library enables you to create separate scripts (for example: cron.php) where you notify
the Cron library of the two cronjobs. After defining the Jobs with their specifics, they can be added to the resolver and
the run command can be given.

Your server crontab could now look something like:
```
* * * * * /path/to/php /path/to/cron.php >/dev/null 2>&1
```

The code example below is matched to this use case.

Code example
------------

```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

// Write folder content to log every five minutes.
$job1 = new \Cron\Job\ShellJob();
$job1->setCommand('ls -la /path/to/folder');
$job1->setSchedule(new \Cron\Schedule\CrontabSchedule('*/5 * * * *'));

// Remove folder contents every hour.
$job2 = new \Cron\Job\ShellJob();
$job2->setCommand('rm -rf /path/to/folder/*');
$job2->setSchedule(new \Cron\Schedule\CrontabSchedule('0 0 * * *'));

$resolver = new \Cron\Resolver\ArrayResolver();
$resolver->addJob($job1);
$resolver->addJob($job2);

$cron = new \Cron\Cron();
$cron->setExecutor(new \Cron\Executor\Executor());
$cron->setResolver($resolver);

$cron->run();
```

Cron currently only support triggering shell commands. This means you can trigger anything although it is highly encouraged
not to call web urls. But if you really need to here are some example commands.

```
* * * * * /usr/bin/lynx -source http://example.com/cron.php
* * * * * /usr/bin/wget -O - -q -t 1 http://www.example.com/cron.php
* * * * * curl -s http://example.com/cron.php
```

Installation
------------

Add the following to your project's composer.json:

```bash
$ composer require cron/cron
```

```javascript
{
    "require": {
        "cron/cron": "^1.0"
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

If you would like to help, take a look at the [list of issues](http://github.com/NoUseFreak/Cron/issues).

Requirements
------------

PHP 5.5.0 or above

Author and contributors
-----------------------

Dries De Peuter - <dries@nousefreak.be> - <http://nousefreak.be>

See also the list of [contributors](https://github.com/NoUseFreak/Cron/contributors) who participated in this project.

License
-------

Cron is licensed under the MIT license.
