<?php

/*

Plugin Name: Castlegate IT WP Remediator
Plugin URI: http://github.com/castlegateit/cgit-wp-remediator
Description: Add images in the uploads directory to the media gallery.
Version: 1.0
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

use Cgit\Remediator\Plugin;

// Load plugin
require_once __DIR__ . '/src/autoload.php';

// Initialization
Plugin::getInstance();
