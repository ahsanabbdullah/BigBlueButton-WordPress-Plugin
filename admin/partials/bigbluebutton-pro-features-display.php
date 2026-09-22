<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<div class="wrap">
	<div class="bbb-settings-card">
		<h1><?php esc_html_e( 'Pro Version Features', 'video-conferencing-with-bbb' ); ?></h1>
		<p>
			<?php esc_html_e( 'The Pro version lets you create fully white-label virtual classrooms and adds extra customization options for BBB rooms.', 'video-conferencing-with-bbb' ); ?>
		</p>
		<div class="zvc-information-sec">
			<img
				width="100%"
				height="180"
				src="<?php echo esc_url( VIDEO_CONF_WITH_BBB_IMG_URL . '/video-conferencing-with-BBB.png' ); ?>"
				title="<?php echo esc_attr__( 'BigBlueButton WordPress Pro', 'video-conferencing-with-bbb' ); ?>"
				alt="<?php echo esc_attr__( 'BigBlueButton WordPress Pro', 'video-conferencing-with-bbb' ); ?>"
			/>
			<h2><?php esc_html_e( 'What you get with Pro', 'video-conferencing-with-bbb' ); ?></h2>
			<ul>
				<li><?php esc_html_e( 'Embed a BigBlueButton room on WordPress', 'video-conferencing-with-bbb' ); ?></li>
				<li><?php esc_html_e( 'Set a countdown or schedule for a room', 'video-conferencing-with-bbb' ); ?></li>
				<li><?php esc_html_e( 'Fully white-label virtual classroom', 'video-conferencing-with-bbb' ); ?></li>
				<li><?php esc_html_e( 'Limit the maximum number of participants per room or per page (for example 5 or 10) for 1:1 or group sessions', 'video-conferencing-with-bbb' ); ?></li>
				<li><?php esc_html_e( 'Upload your brand logo so it is visible in the BBB room', 'video-conferencing-with-bbb' ); ?></li>
				<li><?php esc_html_e( 'Customize the room background color to match your brand', 'video-conferencing-with-bbb' ); ?></li>
				<li><?php esc_html_e( 'Change the welcome message shown in the Public Chat section', 'video-conferencing-with-bbb' ); ?></li>
				<li><?php esc_html_e( 'Customize the thank-you message when a user leaves the meeting', 'video-conferencing-with-bbb' ); ?></li>
				<li><?php esc_html_e( 'Pre-upload a presentation globally or per room', 'video-conferencing-with-bbb' ); ?></li>
				<li><?php esc_html_e( 'Frontend room management area for moderators', 'video-conferencing-with-bbb' ); ?></li>
			</ul>
			<p>
				<a rel="noopener" target="_blank" href="<?php echo esc_url( VIDEO_CONF_WITH_BBB_PRO ); ?>">
					<button type="button" class="bbb-settings-btn"><?php esc_html_e( 'View More', 'video-conferencing-with-bbb' ); ?></button>
				</a>
			</p>
		</div>
	</div>
</div>
