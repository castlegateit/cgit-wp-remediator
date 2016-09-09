<?php

namespace Cgit\Remediator;

class Plugin
{
    /**
     * Singleton class instance
     *
     * @var self
     */
    private static $instance;

    /**
     * Private constructor
     *
     * @return void
     */
    private function __construct()
    {
        // Add the admin interface
        Admin::getInstance();
    }

    /**
     * Return the singleton class instance
     *
     * @return self
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
