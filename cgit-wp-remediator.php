<?php

/*

Plugin Name: Castlegate IT WP Remediator
Plugin URI: http://github.com/castlegateit/cgit-wp-remediator
Description: Add images in the uploads directory to the media gallery.
Version: 1.1.4
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

require_once __DIR__ . '/classes/autoload.php';

$plugin = new \Cgit\Remediator\Plugin();

do_action('cgit_remediator_loaded');
