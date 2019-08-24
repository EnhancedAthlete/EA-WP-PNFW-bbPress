<?php
/**
 * Test the main plugin action.
 *
 * @package ea-wp-pnfw-bbpress
 * @author Brian Henry <BrianHenryIE@gmail.com>
 */

/**
 * Class EA_WP_PNFW_bbPress_bbPress_WordPress_Develop_Test
 */
class EA_WP_PNFW_bbPress_bbPress_WordPress_Develop_Test extends BBP_UnitTestCase {

	/**
	 * Verify the main action is working correctly.
	 *
	 * When a reply is added, do_action( 'bbp_post_notify_subscribers', $reply_id, $topic_id, $user_ids ) gets called.
	 */
	public function test_function_bbp_post_notify_subscribers() {

		// Topic 1: user 1
		// Reply 1: user 2
		// Reply 2: user 3

		// Reply 3: user 1

		// users two and three should get a notification.

		$forum_id = $this->factory->forum->create();

		$user_one_id = $this->factory->user->create();

		$topic_id = $this->factory->topic->create( array(
			'post_title' => 'Topic 1',
			'post_parent' => $forum_id,
			'post_author' => $user_one_id,
			'topic_meta' => array(
				'forum_id' => $forum_id,
			),
		) );

		$user_two_id = $this->factory->user->create();

		$reply_one = $this->factory->reply->create( array(
			'post_title' => 'Reply 1 To: Topic 1',
			'post_author' => $user_two_id,
			'post_content' => 'Content of reply 1 to Topic 1',
			'post_parent' => $topic_id,
			'reply_meta' => array(
				'forum_id' => $forum_id,
				'topic_id' => $topic_id,
			),
		) );

		$user_three_id = $this->factory->user->create();

		$reply_two_id = $this->factory->reply->create( array(
			'post_title' => 'Reply 2 To: Topic 1',
			'post_author' => $user_three_id,
			'post_content' => 'Content of reply 2 to Topic 1',
			'post_parent' => $topic_id,
			'reply_meta' => array(
				'forum_id' => $forum_id,
				'topic_id' => $topic_id,
			),
		) );

		$reply_three_id = bbp_insert_reply( array(
				'post_parent'    => $topic_id,
				'post_author'    => $user_one_id,
				'post_content'   => 'Content of reply 3 to Topic 1',
				'post_title'     => 'Reply 3 To: Topic 1',

			));

		global $sent;
		$sent = array();

		/**
		 * Spy global function.
		 *
		 * Should I be using Mockery for this?
		 *
		 * @param int $user_id     The user id, username, email address or user object to send to
		 * @param string $message   The notification title
		 * @param array() $user_info    The message payload
		 */
		function pnfw_send_notification( $user_id, $message, $user_info ) {

			global $sent;
			$sent[] = $user_id;
		}

	    // $user_ids = bbp_get_subscribers( $topic_id );
		$user_ids = array( $user_one_id, $user_two_id, $user_three_id );

		do_action( 'bbp_post_notify_subscribers', $reply_three_id, $topic_id, $user_ids );

		$this->assertEqualSets( $sent, array( $user_two_id, $user_three_id ) );

	}

}
