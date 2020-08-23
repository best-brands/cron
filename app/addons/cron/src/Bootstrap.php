<?php

namespace Tygh\Addons\Cron;

use Tygh\Core\ApplicationInterface;
use Tygh\Core\BootstrapInterface;
use Tygh\Core\HookHandlerProviderInterface;

/**
 * Class Bootstrap
 *
 * @package Tygh\Addons\Webpack
 */
class Bootstrap implements BootstrapInterface, HookHandlerProviderInterface
{
    const ADDON_NAME = 'cron';

    /** @var ApplicationInterface */
    protected $app;

    /**
     * @inheritDoc
     */
    public function boot(ApplicationInterface $app)
    {
        $this->app = &$app;
        $this->app->register(new ServiceProvider());
    }

    /**
     * @inheritDoc
     */
    public function getHookHandlerMap()
    {
        return [];
    }
}
