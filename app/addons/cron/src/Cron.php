<?php

namespace Tygh\Addons\Cron;

use Tygh\Addons\Cron\Parser\Expression;
use Tygh\Lock\Factory;
use Tygh\Tygh;

/**
 * Class Cron
 *
 * @package Tygh\Addons\Cron
 */
class Cron
{
    /** @var \Tygh\Addons\Cron\Parser\Expression the parser instance */
    protected $cron;

    /** @var array an array of callable jobs */
    protected $jobs = [];

    /** @var Factory */
    protected $lockFactory;

    /** @var int the time at which the cron job is run */
    protected $time;

    /**
     * Cron constructor.
     */
    public function __construct()
    {
        $this->lockFactory = Tygh::$app['lock.factory'];
        $this->cron = new Expression();
        $this->time = time();
    }

    /**
     * Add a cron job to our stack
     *
     * @param string $expression
     * @param        $handler
     */
    public function add(string $expression, $handler)
    {
        if ($this->cron->isCronDue($expression, $this->time))
            $this->jobs[] = $handler;
    }

    /**
     * Run the cron jobs that are in $this->jobs
     */
    public function run()
    {
        /**
         * cron_run
         * @param int $time the time at which the cron jobs are run
         */
        fn_set_hook("cron_run", $this->time);

        // Execute all jobs that have been added to our queue
        foreach ($this->jobs as $handler) {
            $lock = $this->lockFactory->createLock($this->getLockKey($handler));
            call_user_func($handler);
            $lock->release();
        }
    }

    /**
     * Get our lock key
     *
     * @param $handler
     *
     * @return string
     */
    private function getLockKey($handler) {
        return sprintf("addons.cron.%s", md5(serialize($handler)));
    }
}
