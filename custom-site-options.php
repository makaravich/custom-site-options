<?php
/**
 * Custom site options
 *
 * @package       CSO
 * @author        Dzmitry Makarski
 * @version       0.0.1
 *
 * @wordpress-plugin
 * Plugin Name:   Custom site options
 * Description:   Allows you to easily create a settings page for your custom theme or plugin
 * Version:       0.0.1
 * Author:        Dzmitry Makarski
 * Text Domain:   custom-site-options
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const CSO_PLUGIN_URL = WP_PLUGIN_URL . '/custom-site-options';
const CSO_POST_TYPE  = 'custom_options';

/* Add required files */

// Custom post type
include 'includes/classes/csoCPTCustomOptions.php';

// AJAX processing
include 'includes/classes/csoAJAX.php';

// Custom backend post fields
include 'includes/classes/csoCustomFields.php';

// Third-party class implements custom backend fields
require_once 'includes/classes/third-party/class.Kama_Post_Meta_Box.php';

// Third-party class implements custom options
require_once 'includes/classes/third-party/wptOptions/wptSettings.php';

//Initialize the plugin
include 'includes/classes/csoInitial.php';
