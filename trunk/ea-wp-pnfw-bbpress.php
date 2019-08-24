<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://BrianHenry.ie
 * @since             1.0.0
 * @package           EA_WP_PNFW_bbPress
 *
 * @wordpress-plugin
 * Plugin Name:       EA WP PNFW bbPress
 * Plugin URI:        https://github.com/EnhancedAthlete/ea-wp-pnfw-bbpress
 * Description:       Sends bbPress forum topic reply notifications through Delite Studio's Push Notifications for WordPress plugin.
 * Version:           1.0.0
 * Author:            BrianHenryIE
 * Author URI:        https://BrianHenry.ie
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ea-wp-pnfw-bbpress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * WordPress Plugin Boilerplate classes.
 */
require_once plugin_dir_path( __FILE__ ) . 'lib/wppb/interface-wppb-loader.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/wppb/class-wppb-loader.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/wppb/class-wppb-object.php';


/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EA_WP_PNFW_BBPRESS_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ea-wp-pnfw-bbpress.php';


/**
 * Configure an instance of the plugin.
 *
 * @return EA_WP_PNFW_bbPress
 */
function instantiate_ea_wp_pnfw_bbpress() {

	$loader = new WPPB_Loader();

	$ea_wp_pnfw_bbpress = new EA_WP_PNFW_bbPress( $loader );

	return $ea_wp_pnfw_bbpress;
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 *
 * phpcs:disable Squiz.PHP.DisallowMultipleAssignments.Found
 */
$GLOBALS['ea-wp-pnfw-bbpress'] = $ea_wp_pnfw_bbpress = instantiate_ea_wp_pnfw_bbpress();
$ea_wp_pnfw_bbpress->run();

