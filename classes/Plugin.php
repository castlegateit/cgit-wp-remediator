<?php

namespace Castlegate\Remediator;

final class Plugin
{
    /**
     * Initialization
     *
     * @return void
     */
    public static function init(): void
    {
        Admin::init();
    }
}
