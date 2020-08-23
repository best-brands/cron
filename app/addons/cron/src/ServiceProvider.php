<?php

namespace Tygh\Addons\Cron;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Tygh\Addons\Cron\Cron;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['cron'] = function () {
            return new Cron();
        };
    }
}