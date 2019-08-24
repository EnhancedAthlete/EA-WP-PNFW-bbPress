<?php
/**
 * Tests EA_WP_PNFW_bbPress main setup class. Tests the actions are correctly added.
 *
 * @package ea-wp-pnfw-bbpress
 * @author Brian Henry <BrianHenryIE@gmail.com>
 */

/**
 * Class EA_WP_PNFW_bbPress_WordPress_Develop_Test
 */
class EA_WP_PNFW_bbPress_WordPress_Develop_Test extends WP_UnitTestCase {

	/**
	 * Verify the main action is correctly added.
	 */
	public function test_action_bbp_post_notify_subscribers() {

		$filter_name       = 'bbp_post_notify_subscribers';
		$expected_priority = 10;

		$ea_wp_pnfw_bbpress = $GLOBALS['ea-wp-pnfw-bbpress'];

		$plugin_bbpress = $ea_wp_pnfw_bbpress->bbpress;

		$function = array( $plugin_bbpress, 'bbp_post_notify_subscribers' );

		$actual_filter_priority = has_filter( $filter_name, $function );

		$this->assertNotFalse( $actual_filter_priority );

		$this->assertEquals( $expected_priority, $actual_filter_priority );

	}

}
