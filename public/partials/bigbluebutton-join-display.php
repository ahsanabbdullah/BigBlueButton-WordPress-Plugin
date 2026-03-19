<?php if ( isset( $start_time ) && $start_time ) : ?>
	<?php  do_action( 'vcbbb_countdown_display', $room_id, $start_time ); ?>
<?php elseif ( isset( $_REQUEST['bbb_room_join'] ) && $room_id == base64_decode( sanitize_text_field( wp_unslash( $_REQUEST['room_id'] ?? '' ) ) ) ) : ?>
	<?php  do_action( 'vcbbb_on_room_join', $room_id ); ?>
<?php elseif ( isset( $_REQUEST['rec_url'] ) ) : ?>
	<?php  do_action( 'vcbbb_recording_display' ); ?>
<?php else : ?>

<form id="joinroom<?php echo esc_attr( $room_id ); ?>" 
      target="<?php echo esc_attr( $form_target ); ?>" 
      action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" 
      class="bbb-form validate">

	<input type="hidden" name="action" value="<?php echo esc_attr( $args['action'] ); ?>">
	<input data-id="bbb_join_room_id<?php echo esc_attr( $room_id ); ?>" type="hidden" name="room_id" value="<?php echo esc_attr( $room_id ); ?>">
	<input type="hidden" id="bbb_join_room_meta_nonce" name="bbb_join_room_meta_nonce" value="<?php echo esc_attr( $meta_nonce ); ?>">
	<input type="hidden" name="current_page" value="<?php echo esc_url( $args['current_page'] ); ?>">
	<input type="hidden" name="post_id" value="<?php echo esc_attr( $args['post_id'] ); ?>">

	<?php if ( ! is_user_logged_in() ) : ?>
		<div id="bbb_join_with_username" class="bbb-join-form-block">
			<label id="bbb_meeting_name_label" class="bbb-join-room-label"><?php esc_html_e( 'Name', 'video-conferencing-with-bbb' ); ?></label>
			<input type="text" data-id="bbb_meeting_username" name="bbb_meeting_username" aria-labelledby="bbb_meeting_name_label" class="bbb-join-room-input" required />
		</div>
	<?php endif; ?>

	<?php if ( ! $access_as_moderator && ! $access_as_viewer && $access_using_code ) : ?>
		<div id="bbb_join_with_password" class="bbb-join-form-block">
	<?php else : ?>
		<div id="bbb_join_with_password" class="bbb-join-form-block" style="display:none;">
	<?php endif; ?>
			<label id="bbb_meeting_access_code_label" class="bbb-join-room-label"><?php esc_html_e( 'Access Code', 'video-conferencing-with-bbb' ); ?></label>
			<input type="text" data-id="bbb_meeting_access_code" name="bbb_meeting_access_code" aria-labelledby="bbb_meeting_access_code_label" class="bbb-join-room-input">
	</div>

	<?php if ( isset( $_REQUEST['max_user_error'] ) && ( sanitize_text_field( wp_unslash( $_REQUEST['room_id'] ?? '' ) ) == $room_id ) ) : ?>
		<div class="bbb-error">
			<label><?php esc_html_e( 'The participants limit for this meeting has been reached. Please try again in a while.', 'video-conferencing-with-bbb' ); ?></label>
		</div>
	<?php endif; ?>

	<?php if ( isset( $_REQUEST['password_error'] ) && ( sanitize_text_field( wp_unslash( $_REQUEST['room_id'] ?? '' ) ) == $room_id ) ) : ?>
		<div class="bbb-error">
			<label><?php esc_html_e( 'The access code you have entered is incorrect. Please try again.', 'video-conferencing-with-bbb' ); ?></label>
		</div>
	<?php endif; ?>

	<?php if ( isset( $_REQUEST['bigbluebutton_wait_for_mod'] ) && ( sanitize_text_field( wp_unslash( $_REQUEST['room_id'] ?? '' ) ) == $room_id ) ) : ?>
		<div class="bbb-join-form-block">
			<?php
				// Sanitize user inputs
				$temp_entry_pass = isset( $_REQUEST['temp_entry_pass'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['temp_entry_pass'] ) ) : '';
				$username       = isset( $_REQUEST['username'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['username'] ) ) : '';
			?>
			<label id="bbb-wait-for-mod-msg"
				data-room-id="<?php echo esc_attr( $room_id ); ?>"
				<?php if ( $temp_entry_pass ) : ?>
					data-temp-room-pass="<?php echo esc_attr( $temp_entry_pass ); ?>"
				<?php endif; ?>
				<?php if ( $username ) : ?>
					data-room-username="<?php echo esc_attr( $username ); ?>"
				<?php endif; ?>
			>
				<?php if ( $heartbeat_available ) : ?>
					<?php esc_html_e( 'The meeting has not started yet. You will be automatically redirected to the meeting when it starts.', 'video-conferencing-with-bbb' ); ?>
				<?php else : ?>
					<?php esc_html_e( 'The meeting has not started yet. Please wait for a moderator to start the meeting before joining.', 'video-conferencing-with-bbb' ); ?>
				<?php endif; ?>
			</label>
		</div>
	<?php endif; ?>

	<?php if ( $is_join_web ) : ?>
		<a rel="noopener" href="javascript:void(0)" onclick="joinBBBRoomFromPage('<?php echo esc_url( $url ); ?>', 0, this)">
			<button type="button" name="bbb_join_web" class="bbb-button bbb-btn-join button button-primary"><?php echo esc_html( $join_btn ); ?></button>
		</a>
	<?php endif; ?>

	<?php  do_action( 'vcbbb_join_form_buttons', $access_as_moderator, $args ); ?>
</form>

<?php endif; ?>