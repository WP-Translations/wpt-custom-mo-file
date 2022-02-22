<?php
/**
 * PHPStan bootstrap file.
 *
 * @package WPT_Custom_Mo_File
 */

// Set plugin name.
if ( ! defined( 'WPT_CUSTOMOFILE_PLUGIN_NAME' ) ) {
	define( 'WPT_CUSTOMOFILE_PLUGIN_NAME', 'WPT_Custom_Mo_File' );
}


// Require plugin main file.
require_once 'wpt-custom-mo-file.php';
