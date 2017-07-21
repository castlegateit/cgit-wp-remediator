<?php

namespace Cgit\Remediator;

class Plugin
{
    /**
     * Admin instance
     *
     * @var Admin
     */
    private $admin;

    /**
     * Constructor
     *
     * Instantiate the admin interface, which controls when and how the
     * remediator is run.
     *
     * @return void
     */
    private function __construct()
    {
        $this->admin = new Admin();
    }
}
