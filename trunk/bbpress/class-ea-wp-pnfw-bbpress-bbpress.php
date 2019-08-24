<?php
/**
 * Functionality invoked by bbPress.
 *
 * @link       https://BrianHenry.ie
 * @since      1.0.0
 *
 * @package    EA_WP_PNFW_bbPress
 * @subpackage EA_WP_PNFW_bbPress/bbpress
 */

/**
 * Defines functions to be hooked onto bbPress actions and filters.
 *
 * @package    EA_WP_PNFW_bbPress
 * @subpackage EA_WP_PNFW_bbPress/bbpress
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class EA_WP_PNFW_bbPress_bbPress extends WPPB_Object {

	/**
	 * If Push Notifications for WordPress plugin is installed, send a notification to each subscriber except
	 * the author of the reply.
	 *
	 * @see bbp_notify_topic_subscribers()
	 *
	 * @param int   $reply_id ID of the newly made reply.
	 * @param int   $topic_id ID of the topic of the reply.
	 * @param array $user_ids Array of WordPress user ids subscribed to the topic.
	 */
	public function bbp_post_notify_subscribers( $reply_id, $topic_id, $user_ids ) {

		if ( ! function_exists( 'pnfw_send_notification' ) ) {
			return;
		}

		$reply_user_id = bbp_get_reply_author_id( $reply_id );

		// Don't send the notification to the author of the reply.
		$user_ids = array_diff( $user_ids, array( $reply_user_id ) );

		$topic_title = bbp_get_topic_title( $topic_id );

		$message = "New reply to $topic_title";

		// TODO: Document why 178. I assume it's the length of an iOS notification on screen.
		$message = substr( $message, 0, 178 );

		$reply_link = bbp_get_reply_url( $reply_id );

		$user_info = array();

		foreach ( $user_ids as $user_id ) {

			$message = apply_filters( 'bbp_post_notify_subscribers_pnfw_message', $message, $reply_id, $topic_id, $user_id );

			$user_info['link'] = apply_filters( 'add_autologin_to_url', $reply_link, $user_id );

			$user_info = apply_filters( 'bbp_post_notify_subscribers_pnfw_user_info', $user_info, $reply_id, $topic_id, $user_id );

			pnfw_send_notification( $user_id, $message, $user_info );
		}
	}
}

