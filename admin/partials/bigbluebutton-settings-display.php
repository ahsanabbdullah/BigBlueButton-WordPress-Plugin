<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<div class="zvc-row">
	<div class="zvc-position-floater-left">			
		<div class="bbb-settings-card">
			<h1><?php esc_html_e( 'Room Settings', 'video-conferencing-with-bbb' ); ?></h1>
			<nav class="nav-tab-wrapper">
				<a href="?page=bbb-room-server-settings" class="nav-tab 
				<?php
				if ( $tab === null ) :
					?>
				 nav-tab-active 
				<?php endif; ?>"><?php esc_html_e( 'Setup', 'video-conferencing-with-bbb' ); ?></a>
				<?php  do_action( 'vcbbb_settings_tab_nav', $tab ); ?>
			</nav>		
			<form id="bbb-general-settings-form" method="POST" action="" enctype="multipart/form-data">
				<input type="hidden" name="action" value="vcbbb_general_settings">
				<input type="hidden" id="vcbbb_edit_server_settings_meta_nonce" name="vcbbb_edit_server_settings_meta_nonce" value="<?php echo esc_attr( $meta_nonce); ?>">
				 <div class="tab-content">
					<?php if ( null === $tab ) : ?>
						<?php  do_action( 'vcbbb_setup_tab_content' ); ?>
						<div class="bbb-row">
							<p id="bbb_endpoint_label" class="bbb-col-left bbb-important-label"><?php esc_html_e( 'EndPoint URL', 'video-conferencing-with-bbb' ); ?>: </p>
							<input class="bbb-col-right" type="text" name="vcbbb_url" size=50 value="<?php echo esc_url( $bbb_settings['vcbbb_url'] ); ?>" aria-labelledby="bbb_endpoint_label">
						</div>
						<div class="bbb-row">
							<p class="bbb-col-left"></p>
							<label aria-labelledby="bbb_endpoint_label" class="bbb-col-right"><i><?php esc_html_e( 'Test Instance Endpoint', 'video-conferencing-with-bbb' ); ?>: <?php echo esc_url( $bbb_settings['vcbbb_default_url'] ); ?></i></label>
						</div>
						<div class="bbb-row">
							<p id="bbb_shared_secret_label" class="bbb-col-left bbb-important-label"><?php esc_html_e( 'Shared Secret/Salt', 'video-conferencing-with-bbb' ); ?>: </p>
							<input class="bbb-col-right" type="text" name="vcbbb_salt" size=50 value="<?php echo esc_attr( $bbb_settings['vcbbb_salt'] ); ?>" aria-labelledby="bbb_shared_secret_label">
						</div>
						<div class="bbb-row">
							<p class="bbb-col-left"></p>
							<label class="bbb-col-right" aria-labelledby="bbb_shared_secret_label"><?php esc_html_e( 'Test Instance Secret', 'video-conferencing-with-bbb' ); ?>: <?php echo esc_attr( $bbb_settings['vcbbb_default_salt'] ); ?></label>
						</div>
						<br />
						<label id="endpoint-url-note">
							<?php
							$vcbbb_default_notice  = '<h4><strong class="bbb-hosting-notice">' . esc_html__( 'Endpoint URL & Secret:', 'video-conferencing-with-bbb' ) . '</strong> ';
							$vcbbb_default_notice .= sprintf(
								/* translators: 1: opening anchor tag, 2: closing anchor tag */
								esc_html__( 'The default credentials are for testing only. After testing, %1$slog in or create a Blindside Networks account%2$s, choose a free or paid plan, then replace these with your own Endpoint URL and Shared Secret.', 'video-conferencing-with-bbb' ),
								'<a rel="noopener" href="https://blindsidenetworks.com/" target="_blank">',
								'</a>'
							);
							$vcbbb_default_notice .= '<p><strong class="bbb-hosting-notice">' . esc_html__( 'Important:', 'video-conferencing-with-bbb' ) . '</strong> ';
							$vcbbb_default_notice .= sprintf(
								/* translators: 1: opening anchor tag, 2: closing anchor tag */
								esc_html__( 'Review the %1$shosting guide%2$s before joining the virtual classroom', 'video-conferencing-with-bbb' ),
								'<a rel="noopener" href="https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress" target="_blank">',
								'</a>'
							);
							$vcbbb_default_notice .= '</p></h4>';
						echo wp_kses(
    apply_filters(
        'vcbbb_room_default_server_notice',
        $vcbbb_default_notice
    ),
    array(
        'a'      => array(
            'href'   => array(),
            'title'  => array(),
            'target' => array(),
            'rel'    => array(),
        ),
        'strong' => array(
            'class' => array(),
        ),
        'h4'     => array(
            'class' => array(),
        ),
        'p'      => array(
            'class' => array(),
        ),
    )
);
							?>
						</label>
						
						<?php if ( $change_success == 1 ) { ?>
							<div class="updated">
								<p><?php esc_html_e( 'Success! Your room server settings have been saved.', 'video-conferencing-with-bbb' ); ?></p>
							</div>
						<?php } elseif ( $change_success == 2 ) { ?>
							<div class="error">
								<p><?php esc_html_e( "Error: the URL you have entered must end with '/bigbluebutton/'.", 'video-conferencing-with-bbb' ); ?></p>
							</div>
						<?php } elseif ( $change_success == 3 ) { ?>
							<div class="error">
								<p><?php esc_html_e( 'Error: The server cannot be reached. Are you sure the server is running and your settings are correct?', 'video-conferencing-with-bbb' ); ?></p>
							</div>
						<?php } ?>
					<?php else : ?>
						<?php  do_action( 'vcbbb_settings_tab_content', $tab ); ?>
					<?php endif; ?>
				 </div>
				<input class="bbb-settings-btn bbb-settings-submit" type="submit" value="<?php esc_html_e( 'Save Changes', 'video-conferencing-with-bbb' ); ?>"/>
			</form>
		</div>
	</div>
	<div class="zvc-position-floater-right">
		<div class="zvc-information-sec">
			<img width="70%" height="25" src="<?php echo esc_url( VIDEO_CONF_WITH_BBB_IMG_URL . '/learndash-logo.webp' ); ?>" title="LearnDash LMS Development Service" alt="LearnDash LMS Development Service"/>
				<h3>Need help with LMS Building?</h3>
				<p>Being officially recognized as LearnDash LMS experts, we're here to aid you with your customization needs.</p>
				<a target="_blank" rel="noopener"
					href="<?php echo esc_url( 'https://elearningevolve.com/learndash-developer/' ); ?>">
					<button class="bbb-settings-btn">View LearnDash Services</button>
				</a>
			</div>
			
		<div class="zvc-information-sec">
				<h3>Never miss an important update</h3>
				<a target="_blank" rel="noopener"
					href="<?php echo esc_url( 'https://elearningevolve.com/subscribe/?display_name=' . $display_name . '&user_email=' . $user_email ); ?>">
					<button class="bbb-settings-btn">Subscribe</button>
				</a>
			</div>
		<div class="zvc-information-sec">
			<h3>Go To Links</h3>
			<ol>
				<li><a target="_blank" rel="noopener" href="https://wordpress.org/plugins/video-conferencing-with-bbb#faq/">FAQ: Commonly Occurring Issues</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/">How to get Endpoint URL/Secret</a></li>
				<li><a target="_blank" rel="noopener" href="https://wordpress.org/support/plugin/video-conferencing-with-bbb/">Support Request</a></li>
				<li><a target="_blank" rel="noopener" href="https://wordpress.org/plugins/video-conferencing-with-bbb#reviews">Write a Review</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/contact/">Contact Us</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/bigbluebutton-hosting/">Recommended BigBlueButton Hosting</a></li>
			</ol>
		</div>
		<div class="zvc-information-sec">
			<h3 id="tutorials">Tutorials</h3>
			<ol>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/">How to set up hosting & get Endpoint URL/Secret for Virtual Classroom for WordPress</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/how-to-allow-instructors-to-manage-bbb-rooms-on-wp/">How to allow instructors or users to manage BigblueButton Rooms on WordPress</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/how-to-join-bigbluebutton-room-from-wordpress/">How to join BigBlueButton Room from WordPress</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/how-to-limit-number-of-users-for-bigbluebutton-room-on-wordpress/">How to limit number of users for BigBlueButton Room on WordPress
					</a>
				</li>
			</ol>
		</div>
	</div>
</div>
