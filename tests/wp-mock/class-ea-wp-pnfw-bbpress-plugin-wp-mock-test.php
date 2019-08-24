<?php
/**
 * Tests for the root plugin file.
 *
 * @package ea-wp-pnfw-bbpress
 * @author Brian Henry <BrianHenryIE@gmail.com>
 */

/**
 * Class EA_WP_PNFW_bbPress_Plugin_WP_Mock_Test
 */
class EA_WP_PNFW_bbPress_Plugin_WP_Mock_Test extends \WP_Mock\Tools\TestCase {

	/**
	 * Verifies the plugin initialization.
	 *
	 * @runInSeparateProcess
	 */
	public function test_plugin_include() {

		global $plugin_root_dir;

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		// Hit in Settings constructor.
		\WP_Mock::userFunction(
			'get_option'
		);

		require_once $plugin_root_dir . '/ea-wp-pnfw-bbpress.php';

		$this->assertArrayHasKey( 'ea-wp-pnfw-bbpress', $GLOBALS );

		$this->assertInstanceOf( 'EA_WP_PNFW_bbPress', $GLOBALS['ea-wp-pnfw-bbpress'] );

	}


	/**
	 * Verifies the plugin does not output anything to screen.
	 *
	 * @runInSeparateProcess
	 */
	public function test_plugin_include_no_output() {

		global $plugin_root_dir;

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		// Hit in Settings constructor.
		\WP_Mock::userFunction(
			'get_option'
		);

		ob_start();

		require_once $plugin_root_dir . '/ea-wp-pnfw-bbpress.php';

		$printed_output = ob_get_contents();

		ob_end_clean();

		$this->assertEmpty( $printed_output );

	}

}
