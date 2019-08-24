<?php
/**
 * The file that defines the core plugin class.
 *
 * @link       https://BrianHenry.ie
 * @since      1.0.0
 *
 * @package    EA_WP_PNFW_bbPress
 * @subpackage EA_WP_PNFW_bbPress/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define actions, filters, and make them available to unhook.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * phpcs:disable Squiz.PHP.DisallowMultipleAssignments.Found
 *
 * @since      1.0.0
 * @package    EA_WP_PNFW_bbPress
 * @subpackage EA_WP_PNFW_bbPress/includes
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class EA_WP_PNFW_bbPress {

	/**
	 * Public variable to allow unhooking functions.
	 *
	 * @var EA_WP_PNFW_bbPress_bbPress $bbpress
	 */
	public $bbpress;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WPPB_Loader_Interface $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param WPPB_Loader_Interface $loader The class which adds the actions and filters.
	 */
	public function __construct( $loader ) {
		if ( defined( 'EA_WP_PNFW_BBPRESS_VERSION' ) ) {
			$this->version = EA_WP_PNFW_BBPRESS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ea-wp-pnfw-bbpress';

		$this->loader = $loader;

		$this->load_dependencies();

		$this->define_bbpress_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining all actions invoked by bbPress.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'bbpress/class-ea-wp-pnfw-bbpress-bbpress.php';

	}

	/**
	 * Register all of the hooks related to the bbPress initiated functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_bbpress_hooks() {

		$this->bbpress = $plugin_bbpress = new EA_WP_PNFW_bbPress_bbPress( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'bbp_post_notify_subscribers', $plugin_bbpress, 'bbp_post_notify_subscribers', 10, 3 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WPPB_Loader_Interface    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
