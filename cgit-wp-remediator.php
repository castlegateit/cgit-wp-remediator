<?php

/**
 * Plugin Name:  Castlegate IT WP Remediator
 * Plugin URI:   https://github.com/castlegateit/cgit-wp-remediator
 * Description:  Add images in the uploads directory to the media gallery.
 * Version:      1.2.0
 * Requires PHP: 8.2
 * Author:       Castlegate IT
 * Author URI:   https://www.castlegateit.co.uk/
 * License:      MIT
 * Update URI:   https://github.com/castlegateit/cgit-wp-remediator
 */

use Castlegate\Remediator\Plugin;

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

define('CGIT_WP_REMEDIATOR_VERSION', '1.2.0');
define('CGIT_WP_REMEDIATOR_PLUGIN_FILE', __FILE__);
define('CGIT_WP_REMEDIATOR_PLUGIN_DIR', __DIR__);

require_once __DIR__ . '/vendor/autoload.php';

Plugin::init();
