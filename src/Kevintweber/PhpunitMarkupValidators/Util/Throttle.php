<?php

/*
 * This file is part of the PhpunitMarkupValidators package.
 *
 * (c) Kevin Weber <kevintweber@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kevintweber\PhpunitMarkupValidators\Util;

/**
 * A singleton designed to throttle the calls to the W3C servers.
 *
 * Each service specifically states that no more than 1 call per second is
 * allowed.  This class will throttle calls on a per service basis to less
 * than 1 call per second.
 */
class Throttle
{
    protected $timeAccessed = array();

    protected static $instance = null;

    /**
     * Constructor.
     */
    protected function __construct()
    {
    }
    protected function __clone()
    {
    }

    /**
     * Will instantiate the class if not already.
     *
     * @return An instance of this object.
     */
    protected static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new Throttle();
        }

        return self::$instance;
    }

    public static function delay($service)
    {
        $instance = self::instance();

        if (isset($instance->timeAccessed[$service])) {
            $timeDifference = microtime(true) - $instance->timeAccessed[$service];

            // If this service has been called less than 1 second ago,
            // then we wait the rest of the second.
            if ($timeDifference < 1.0) {
                usleep((1.0 - $timeDifference) * 1000000);
            }
        }

        $instance->timeAccessed[$service] = microtime(true);
    }
}
