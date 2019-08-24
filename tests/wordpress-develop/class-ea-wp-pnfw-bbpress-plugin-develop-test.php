<?php
/**
 * Class EA_WP_PNFW_bbPress_Plugin_Develop_Test. Tests the root plugin setup.
 *
 * @package ea-wp-pnfw-bbpress
 * @author Brian Henry <BrianHenryIE@gmail.com>
 */

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class EA_WP_PNFW_bbPress_Plugin_Develop_Test extends WP_UnitTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'ea-wp-pnfw-bbpress', $GLOBALS );

		$this->assertInstanceOf( 'EA_WP_PNFW_bbPress', $GLOBALS['ea-wp-pnfw-bbpress'] );
	}
}
