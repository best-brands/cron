<?php

use Tygh\Tygh;

if (php_sapi_name() === 'cli') {
    if ($mode === 'run') {
        Tygh::$app['cron']->run();
        exit(0);
    }
} else {
    return [CONTROLLER_STATUS_DENIED];
}
