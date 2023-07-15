<?php
/**
 * Custom site options
 *
 * @package       CSOPT
 * @author        Dzmitry Makarski
 * @version       0.0.2
 *
 * @wordpress-plugin
 * Plugin Name:   Custom site options
 * Description:   Allows you to easily create a settings page for your custom theme or plugin
 * Version:       0.0.2
 * Author:        Dzmitry Makarski
 * Text Domain:   custom-site-options
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const CSOPT_PLUGIN_URL = WP_PLUGIN_URL . '/custom-site-options';
const CSOPT_POST_TYPE  = 'custom_options';

/* Add required files */

// Custom post type
include 'includes/classes/CSOPT_Custom_Options.php';

// AJAX processing
include 'includes/classes/CSOPT_Ajax.php';

// Custom backend post fields
include 'includes/classes/CSOPT_Custom_Fields.php';

// Third-party class implements custom backend fields
require_once 'includes/classes/third-party/CSOPT_Kama_Post_Meta_Box.php';

// Third-party class implements custom options
require_once 'includes/classes/third-party/CSOPT_Options/CSOPT_Core.php';

//Initialize the plugin
include 'includes/classes/CSOPT_Initial.php';
