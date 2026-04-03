<div class="bbb-warning-notice notice is-dismissible notice-<?php echo esc_attr( $notice_type ); ?>" 
     data-notice="<?php echo esc_attr( $bbb_warning_type ); ?>" 
     data-nonce="<?php echo esc_attr( $bbb_admin_notice_nonce ); ?>">
     
	<p>
	<?php
	if ( isset( $bbb_admin_review_message ) ) {
		?>
		
		<?php echo wp_kses( $bbb_admin_review_message, array( 'strong' => array() ) ); ?>
		<br /><br />

		<?php if ( 'review_request' == $type ) : ?>
			<a target="_blank" rel="noopener" href="https://wordpress.org/support/plugin/video-conferencing-with-bbb/reviews/#new-post">
				<button class="bbb-settings-btn" 
				        data-notice="<?php echo esc_attr( $bbb_warning_type ); ?>" 
				        data-nonce="<?php echo esc_attr( $bbb_admin_notice_nonce ); ?>">
					<?php esc_html_e( 'Share feedback', 'video-conferencing-with-bbb' ); ?>
				</button>
			</a>

		<?php elseif ( 'room_create_limit' == $type ) : ?>
			
			<a target="_blank" rel="noopener" href="<?php echo esc_url( VIDEO_CONF_WITH_BBB_PRO ); ?>">
				<button class="bbb-settings-btn" 
				        data-notice="<?php echo esc_attr( $bbb_warning_type ); ?>" 
				        data-nonce="<?php echo esc_attr( $bbb_admin_notice_nonce ); ?>">
					<?php esc_html_e( 'Get Pro Version', 'video-conferencing-with-bbb' ); ?>
				</button>
			</a>

		<?php endif; ?>
	<?php } ?>
	</p>
</div>