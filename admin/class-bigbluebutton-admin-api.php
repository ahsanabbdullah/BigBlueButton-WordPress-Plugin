<?php
/**
 * Handle the majority of Bigbluebutton API calls to admin.
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/admin
 */

/**
 * Handle the majority of Bigbluebutton API calls to admin.
 *
 * Handles saving rooms as custom post type, with custom fields.
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/admin
 * @author     Blindside Networks <contact@blindsidenetworks.com>
 */
class VCBBB_Admin_Api {

	/**
	 * Save custom post meta to the room.
	 *
	 * @since   3.0.0
	 *
	 * @param   Integer $post_id    Post ID of the new room.
	 * @return  Integer $post_id    Post ID of the new room.
	 */
	public function save_vcbbb_room( $post_id, $post, $update ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( $this->can_save_room() ) {
			$moderator_code = sanitize_text_field( $_POST['vcbbb-moderator-code'] );
			$viewer_code    = sanitize_text_field( $_POST['vcbbb-viewer-code'] );
			$recordable     = ( array_key_exists( 'vcbbb-room-recordable', $_POST ) && sanitize_text_field( $_POST['vcbbb-room-recordable'] ) == 'checked' );

			$wait_for_mod = ( isset( $_POST['vcbbb-room-wait-for-moderator'] ) && sanitize_text_field( $_POST['vcbbb-room-wait-for-moderator'] ) == 'checked' );

			// Ensure neither code is empty.
			if ( '' == $moderator_code ) {
				$moderator_code = VCBBB_Admin_Helper::generate_random_code();
			}
			if ( '' == $viewer_code ) {
				$viewer_code = VCBBB_Admin_Helper::generate_random_code();
			}

			// Ensure the Moderator Access Code is not the same as the Viewer Access Code.
			if ( $moderator_code === $viewer_code ) {
				$viewer_code = $moderator_code . VCBBB_Admin_Helper::generate_random_code( 3 );
			}

			// Add room codes to postmeta data.
			update_post_meta( $post_id, 'vcbbb-room-moderator-code', $moderator_code );
			update_post_meta( $post_id, 'vcbbb-room-viewer-code', $viewer_code );

			if ( ! get_post_meta( $post_id, 'vcbbb-room-meeting-id', true ) ) {
				update_post_meta( $post_id, 'vcbbb-room-meeting-id', sha1( home_url() . VCBBB_Admin_Helper::generate_random_code( 12 ) ) );
			}

			// Update room recordable value.
			update_post_meta( $post_id, 'vcbbb-room-recordable', ( $recordable ? 'true' : 'false' ) );
			update_post_meta( $post_id, 'vcbbb-room-wait-for-moderator', ( $wait_for_mod ? 'true' : 'false' ) );

			do_action( 'vcbbb_room_save_meta', $post_id );
		} else {
			return $post_id;
		}
	}

	/**
	 * Dismiss admin notices.
	 *
	 * @since 3.0.0
	 */
	public function dismiss_admin_notices() {
		if ( isset( $_POST['type'] ) && 'vcbbb-' === substr( $_POST['type'], 0, 6 ) ) {
			$type = sanitize_text_field( $_POST['type'] );
			if ( wp_verify_nonce( $_POST['nonce'], $type ) ) {
				update_option( 'dismissed-' . $type, true, false );
			}
		}
	}

	/**
	 * Helper function to check if metadata has been submitted with correct nonces.
	 *
	 * @since 3.0.0
	 */
	public function can_save_room() {
		return ( isset( $_POST['vcbbb-moderator-code'] ) &&
			isset( $_POST['vcbbb-viewer-code'] ) &&
			isset( $_POST['vcbbb-room-moderator-code-nonce'] ) &&
			wp_verify_nonce( $_POST['vcbbb-room-moderator-code-nonce'], 'vcbbb-room-moderator-code-nonce' ) &&
			current_user_can( 'create_recordable_bbb_room' ) );
	}
}
