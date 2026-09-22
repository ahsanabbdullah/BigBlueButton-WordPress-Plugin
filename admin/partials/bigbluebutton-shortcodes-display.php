<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<div class="wrap">
	<div class="bbb-settings-card">
		<h1><?php esc_html_e( 'Shortcode', 'video-conferencing-with-bbb' ); ?></h1>
		<section id="shortcodes" class="bbb-pro-shortcode-usage">
			<h2><?php esc_html_e( 'Shortcode Usage Guide', 'video-conferencing-with-bbb' ); ?></h2>
			<p>
				<?php
				echo wp_kses(
					sprintf(
						/* translators: 1: opening anchor tag, 2: closing anchor tag */
						__( 'Below are the %1$sshortcodes%2$s offered by the plugin that you can use anywhere on your site.', 'video-conferencing-with-bbb' ),
						'<a rel="noopener" target="_blank" href="https://www.wpbeginner.com/wp-tutorials/how-to-add-a-shortcode-in-wordpress/">',
						'</a>'
					),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
							'rel'    => true,
						),
					)
				);
				?>
			</p>
			<ol>
				<li>
					<p><?php esc_html_e( 'Display moderator login form on the frontend', 'video-conferencing-with-bbb' ); ?></p>
					<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)" data-value="[bigbluebutton_moderator_login]">
						<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
						<input size="30" type="text" disabled value="[bigbluebutton_moderator_login]"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
						<strong><?php esc_html_e( 'Pro Version Note', 'video-conferencing-with-bbb' ); ?></strong>
					</span>
					<div class="desc">
						<ul>
							<li><?php esc_html_e( 'This shortcode displays the moderator login form on the frontend.', 'video-conferencing-with-bbb' ); ?></li>
						</ul>
					</div>
				</li>
				<li>
					<p><?php esc_html_e( 'Display moderator room management area', 'video-conferencing-with-bbb' ); ?></p>
					<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)" data-value="[bigbluebutton_room_manage]">
						<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
						<input size="30" type="text" disabled value="[bigbluebutton_room_manage]"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
						<strong><?php esc_html_e( 'Pro Version Note', 'video-conferencing-with-bbb' ); ?></strong>
					</span>
					<div class="desc">
						<ul>
							<li><?php esc_html_e( 'This shortcode displays the moderator room management area on the frontend.', 'video-conferencing-with-bbb' ); ?></li>
						</ul>
					</div>
				</li>
				<li>
					<p><?php esc_html_e( 'Display all available BBB rooms with the join form', 'video-conferencing-with-bbb' ); ?></p>
					<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)" data-value="[bigbluebutton_all_rooms]">
						<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
						<input size="30" type="text" disabled value="[bigbluebutton_all_rooms]"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
						<strong><?php esc_html_e( 'Pro Version Note', 'video-conferencing-with-bbb' ); ?></strong>
					</span>
					<div class="desc">
						<ul>
							<li><?php esc_html_e( 'This shortcode shows all rooms created under BBB Rooms → All Rooms.', 'video-conferencing-with-bbb' ); ?></li>
						</ul>
					</div>
				</li>
				<li>
					<p><?php esc_html_e( 'Display a list of BBB rooms with a join form', 'video-conferencing-with-bbb' ); ?></p>
					<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)" data-value="[bigbluebutton token='z2xxx, z2yyy, ...' room_limit='50']">
						<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
						<input size="40" type="text" disabled value="[bigbluebutton token='z2xxx, z2yyy, ...' room_limit='50']"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
						<strong><?php esc_html_e( 'Pro Version Note', 'video-conferencing-with-bbb' ); ?></strong>
					</span>
					<div class="spacer"></div>
					<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)" data-value="[bigbluebutton token='z2xxx, z2yyy, ...']">
						<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
						<input size="30" type="text" disabled value="[bigbluebutton token='z2xxx, z2yyy, ...']"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
					</span>
					<div class="desc">
						<ul>
							<li><?php echo wp_kses( __( '<strong>token</strong>: The BBB room tokens. See BBB Rooms → All Rooms → Token.', 'video-conferencing-with-bbb' ), array( 'strong' => array() ) ); ?></li>
							<li><?php echo wp_kses( __( '<strong>room_limit</strong>: Overrides Settings → Room Config and the room-level limit. Sets the maximum number of users allowed to join at the same time.', 'video-conferencing-with-bbb' ), array( 'strong' => array() ) ); ?></li>
						</ul>
					</div>
				</li>
				<li>
					<p><?php esc_html_e( 'Show a single BBB room join form on a page', 'video-conferencing-with-bbb' ); ?></p>
					<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)" data-value="[bigbluebutton token='z2xxx' room_limit='50']">
						<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
						<input size="30" type="text" disabled value="[bigbluebutton token='z2xxx' room_limit='50']"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
						<strong><?php esc_html_e( 'Pro Version Note', 'video-conferencing-with-bbb' ); ?></strong>
					</span>
					<div class="spacer"></div>
					<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)" data-value="[bigbluebutton token='z2xxx']">
						<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
						<input size="30" type="text" disabled value="[bigbluebutton token='z2xxx']"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
					</span>
					<p class="bbb-single-room-shortcode-note">
						<strong><?php esc_html_e( 'Note:', 'video-conferencing-with-bbb' ); ?></strong>
						<?php esc_html_e( 'The two shortcodes above are alternatives (with or without room_limit). Paste only one on a page; pasting both will show the same room twice.', 'video-conferencing-with-bbb' ); ?>
					</p>
					<div class="desc">
						<ul>
							<li><?php echo wp_kses( __( '<strong>token</strong>: The BBB room token. See BBB Rooms → All Rooms → Token.', 'video-conferencing-with-bbb' ), array( 'strong' => array() ) ); ?></li>
							<li><?php echo wp_kses( __( '<strong>room_limit</strong>: Overrides Settings → Room Config and the room-level limit. Sets the maximum number of users allowed to join at the same time.', 'video-conferencing-with-bbb' ), array( 'strong' => array() ) ); ?></li>
						</ul>
					</div>
				</li>
				<li>
					<p><?php esc_html_e( 'Display recordings from multiple BBB rooms', 'video-conferencing-with-bbb' ); ?></p>
					<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)" data-value="[bigbluebutton_recordings token='z2xxx, z2yyy, ...']">
						<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
						<input size="40" type="text" disabled value="[bigbluebutton_recordings token='z2xxx, z2yyy, ...']"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
					</span>
					<div class="desc">
						<ul>
							<li><?php echo wp_kses( __( '<strong>token</strong>: The BBB room tokens. See BBB Rooms → All Rooms → Token.', 'video-conferencing-with-bbb' ), array( 'strong' => array() ) ); ?></li>
						</ul>
					</div>
				</li>
				<li>
					<p><?php esc_html_e( 'Display recordings from a single BBB room', 'video-conferencing-with-bbb' ); ?></p>
					<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)" data-value="[bigbluebutton_recordings token='z2xxx']">
						<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
						<input size="30" type="text" disabled value="[bigbluebutton_recordings token='z2xxx']"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
					</span>
					<div class="desc">
						<ul>
							<li><?php echo wp_kses( __( '<strong>token</strong>: The BBB room token. See BBB Rooms → All Rooms → Token.', 'video-conferencing-with-bbb' ), array( 'strong' => array() ) ); ?></li>
						</ul>
					</div>
				</li>
			</ol>
		</section>
	</div>
</div>
