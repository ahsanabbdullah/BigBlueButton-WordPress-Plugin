<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/admin
 * @author     Blindside Networks <contact@blindsidenetworks.com>
 */
class VCBBB_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   3.0.0
	 * @param   String $plugin_name       The name of this plugin.
	 * @param   String $version           The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    3.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in VCBBB_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The VCBBB_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bigbluebutton-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    3.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in VCBBB_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The VCBBB_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$translations = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bigbluebutton-admin.js', array( 'jquery', 'wp-i18n' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'vcbbb_php_vars', $translations );
	}

	/**
	 * Add Rooms as its own menu item on the admin page.
	 *
	 * @since   3.0.0
	 */
	public function create_admin_menu() {
		add_menu_page(
			__( 'BBB Rooms', 'video-conferencing-with-bbb' ),
			__( 'BBB Rooms', 'video-conferencing-with-bbb' ),
			'edit_bbb_rooms',
			'vcbbb_room',
			array( $this, 'vcbbb_room_menu_page' ),
			'dashicons-video-alt2',
			6
		);
		if ( ! VCBBB_Admin_Helper::check_posts() ) {
			add_submenu_page(
				'vcbbb_room',
				__( 'Add New', 'video-conferencing-with-bbb' ),
				__( 'Add New', 'video-conferencing-with-bbb' ),
				'add_bbb_rooms',
				'post-new.php?post_type=bbb-room',
				''
			);
		}

		if ( current_user_can( 'manage_categories' ) ) {
			add_submenu_page(
				'vcbbb_room',
				__( 'Room Categories', 'video-conferencing-with-bbb' ),
				__( 'Categories', 'video-conferencing-with-bbb' ),
				'edit_bbb_rooms',
				'edit-tags.php?taxonomy=bbb-room-category',
				''
			);
		}

		add_submenu_page(
			'vcbbb_room',
			__( 'Rooms Settings', 'video-conferencing-with-bbb' ),
			__( 'Settings', 'video-conferencing-with-bbb' ),
			'manage_options',
			'bbb-room-server-settings',
			array( $this, 'display_room_server_settings' )
		);

		if ( ! VCBBB_Loader::is_bbb_pro_active() ) {
			add_submenu_page(
				'vcbbb_room',
				__( 'Get Pro Version', 'video-conferencing-with-bbb' ),
				__( 'Get Pro Version', 'video-conferencing-with-bbb' ),
				'manage_options',
				'bbb-room-pro-version',
				array( $this, 'redirect_to_pro_version' )
			);
		}
	}


	/**
	 * Redirect parent menu to rooms list when admin.php?page=vcbbb_room is accessed.
	 *
	 * @since   3.0.0
	 */
	public function vcbbb_room_menu_page() {
		$url = admin_url( 'edit.php?post_type=bbb-room' );
		if ( ! headers_sent() ) {
			wp_safe_redirect( $url );
			exit;
		}
		echo '<script>window.location.replace("' . esc_js( $url ) . '");</script>';
		echo '<noscript><meta http-equiv="refresh" content="0;url=' . esc_url( $url ) . '"></noscript>';
		echo '<p>' . esc_html__( 'Redirecting to rooms...', 'video-conferencing-with-bbb' ) . '</p>';
		exit;
	}

	/**
	 * Add filter to highlight custom menu category submenu.
	 *
	 * @since   3.0.0
	 *
	 * @param   String $parent_file    Current parent page that the user is on.
	 * @return  String $parent_file    Custom menu slug.
	 */
	public function vcbbb_set_current_menu( $parent_file ) {
		global $submenu_file, $current_screen, $pagenow;

		// Set the submenu as active/current while anywhere in your Custom Post Type.
		if ( 'bbb-room-category' == $current_screen->taxonomy && 'edit-tags.php' == $pagenow ) {
			$submenu_file = 'edit-tags.php?taxonomy=bbb-room-category';
			$parent_file  = 'vcbbb_room';
		}
		return $parent_file;
	}

	/**
	 * Add custom room column headers to rooms list table.
	 *
	 * @since   3.0.0
	 *
	 * @param   Array $columns    Array of existing column headers.
	 * @return  Array $columns    Array of existing column headers and custom column headers.
	 */
	public function add_custom_room_column_to_list( $columns ) {
		if ( ! function_exists( 'get_current_screen' ) ) {
			include ABSPATH . '/wp-admin/includes/screen.php';
		}

		if ( function_exists( 'get_current_screen' ) ) {
			// show notice only on admin plugin pages
			$current_screen = get_current_screen();
			$allowed        = array( 'edit-bbb-room' );
			if ( isset( $current_screen->id ) && ! in_array( $current_screen->id, $allowed ) ) {
				return;
			}
		}

		$custom_columns = array(
			'category'       => __( 'Category', 'video-conferencing-with-bbb' ),
			'permalink'      => __( 'Invite Participants', 'video-conferencing-with-bbb' ),
			'token'          => __( 'Token', 'video-conferencing-with-bbb' ),
			'shortcode'      => __( 'Shortcode', 'video-conferencing-with-bbb' ),
			'start-time'     => __( 'Start Time', 'video-conferencing-with-bbb' ),
			'moderator-code' => __( 'Moderator Access Code', 'video-conferencing-with-bbb' ),
			'viewer-code'    => __( 'Viewer Access Code', 'video-conferencing-with-bbb' ),
			'start-meeting'  => __( 'Start Meeting', 'video-conferencing-with-bbb' ),
		);

		$columns = array_merge( $columns, $custom_columns );

		return $columns;
	}

	/**
	 * Fill in custom column information on rooms list table.
	 *
	 * @since 3.0.0
	 *
	 * @param   String  $column     Name of the column.
	 * @param   Integer $post_id    Room ID of the current room.
	 */
	public function vcbbb_room_custom_columns( $column, $post_id ) {
		if ( ! function_exists( 'get_current_screen' ) ) {
			include ABSPATH . '/wp-admin/includes/screen.php';
		}

		if ( function_exists( 'get_current_screen' ) ) {
			// show notice only on admin plugin pages
			$current_screen = get_current_screen();
			$allowed        = array( 'edit-bbb-room' );
			if ( isset( $current_screen->id ) && ! in_array( $current_screen->id, $allowed ) ) {
				return;
			}
		}

		switch ( $column ) {
			case 'category':
				$categories = wp_get_object_terms( $post_id, 'bbb-room-category', array( 'fields' => 'names' ) );
				if ( ! is_wp_error( $categories ) ) {
					echo esc_attr( implode( ', ', $categories ) );
				}
				break;
			case 'permalink':
    $permalink = ( get_permalink( $post_id ) ? get_permalink( $post_id ) : '' );
    echo '<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
            data-value="' . esc_attr( $permalink ) . '">
            <span class="tooltiptext invite-tooltip">' . esc_html__( 'Copy Invite URL', 'video-conferencing-with-bbb' ) . '</span>
        <span class="bbb-button button">
            <span class="bbb-dashicon dashicons dashicons-admin-page"></span>'
            . esc_html__( 'Copy', 'video-conferencing-with-bbb' ) . '
        </span>
    </span>';

    // Additional safe echo for 'Copy' if you want it separate
    echo esc_html__( 'Copy', 'video-conferencing-with-bbb' );

    break;
			case 'token':
				if ( metadata_exists( 'post', $post_id, 'bbb-room-token' ) ) {
					$token = get_post_meta( $post_id, 'bbb-room-token', true );
				} else {
					$token = 'z' . esc_attr( $post_id );
				}
				echo esc_attr( $token );
				break;
			case 'shortcode':
				if ( metadata_exists( 'post', $post_id, 'bbb-room-token' ) ) {
					$token = get_post_meta( $post_id, 'bbb-room-token', true );
				} else {
					$token = 'z' . $post_id;
				}
				echo '<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
						data-value="[bigbluebutton token=' . esc_attr( $token ) . ']">
						<span class="tooltiptext shortcode-tooltip">' . esc_html__( 'Copy Shortcode', 'video-conferencing-with-bbb' ) . '</span>
						<input type="text" disabled value="[bigbluebutton token= ' . esc_attr( $token ) . ']"/>
						<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
					</span>';
				break;
			case 'start-time':
				if ( ! VCBBB_Loader::is_bbb_pro_active() ) {
					echo '<a href="' . VIDEO_CONF_WITH_BBB_PRO . '" target="_blank" rel="noopener">Pro version feature</a>';
				} else {
					$is_start_time = get_post_meta( $post_id, 'bbb-start-time', true );
					if ( $is_start_time ) {
						$is_start_time = strtotime( $is_start_time );
					}

					if ( $is_start_time ) {
						echo esc_html( date_i18n( 'F j, Y, g:i a', $is_start_time ) );
					} else {
						esc_html_e( 'N/A', 'video-conferencing-with-bbb' );
					}
				}
				break;
			case 'moderator-code':
				echo esc_attr( get_post_meta( $post_id, 'bbb-room-moderator-code', true ) );
				break;
			case 'viewer-code':
				echo esc_attr( get_post_meta( $post_id, 'bbb-room-viewer-code', true ) );
				break;
			case 'start-meeting':
				$entry_code = strval( get_post_meta( $post_id, 'bbb-room-moderator-code', true ) );
				?>
				<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'edit.php?post_type=bbb-room&start_bbb_meeting_admin=1&room_id=' . $post_id . '&code=' . $entry_code ), 'start_meeting' ) ); ?>"
					rel="noopener" target="_blank" class="bbb-button button button-primary">
					<?php echo esc_html( __( 'Start', 'video-conferencing-with-bbb' ) ); ?>	
				</a>
				<?php
				break;
		}
	}

	/**
	 * Redirect to Pro version of the plugin on menu click
	 *
	 * @since   3.0.0
	 */
	public function redirect_to_pro_version() {
		wp_register_script( 'video-conf-bbb-dummy-js-header', '', );
		wp_enqueue_script( 'video-conf-bbb-dummy-js-header' );
		wp_add_inline_script(
			'video-conf-bbb-dummy-js-header',
			"window
                .open(
                    '" . esc_html( VIDEO_CONF_WITH_BBB_PRO ) . "',
					'_self'
                )
                .focus();
			"
		);
	}

	/**
	 * Render the server settings page for plugin.
	 *
	 * @since   3.0.0
	 */
	public function display_room_server_settings() {
		$change_success = $this->room_server_settings_change();
		$bbb_settings   = $this->fetch_room_server_settings();
		$meta_nonce     = wp_create_nonce( 'vcbbb_edit_server_settings_meta_nonce' );
		$user           = get_userdata( get_current_user_id() );
		$user_email     = ( isset( $user->user_email ) ? $user->user_email : '' );
		$display_name   = ( isset( $user->display_name ) ? $user->display_name : '' );

		//Get the active tab from the $_GET param
		$default_tab = null;
		$tab         = isset( $_GET['tab'] ) ? $_GET['tab'] : $default_tab;

		if ( VCBBB_Loader::is_bbb_pro_active() ) {
			$bbb_host = '<a target="_blank" rel="noopener" href="https://bigbluebutton.host">Bigbluebutton.host</a>';
		} else {
			$bbb_host = '<a target="_blank" rel="noopener" href="https://blindsidenetworks.com/">Blindside Networks</a>';
		}

		// Sanitize the tab parameter from URL
        $tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : $default_tab;

		require_once 'partials/bigbluebutton-settings-display.php';
	}

	/**
	 * Render the pro version page for plugin.
	 *
	 * @since   3.0.0
	 */
	public function display_pro_version_page() {
		require_once 'partials/bigbluebutton-pro-version.php';
	}

	/**
	 * Retrieve the room server settings.
	 *
	 * @since   3.0.0
	 *
	 * @return  Array   $settings   Room server default and current settings.
	 */
	public function fetch_room_server_settings() {
		$settings = array(
			'vcbbb_url'          => get_option( 'vcbbb_url', get_option( 'bigbluebutton_url', VIDEO_CONF_WITH_BBB_ENDPOINT ) ),
			'vcbbb_salt'         => get_option( 'vcbbb_salt', get_option( 'bigbluebutton_salt', VIDEO_CONF_WITH_BBB_SALT ) ),
			'vcbbb_default_url'  => VIDEO_CONF_WITH_BBB_ENDPOINT,
			'vcbbb_default_salt' => VIDEO_CONF_WITH_BBB_SALT,
		);

		return apply_filters( 'vcbbb_room_server_settings_display', $settings );
	}

	/**
	 * Show information about new plugin updates.
	 *
	 * @since   1.4.6
	 *
	 * @param   Array  $current_plugin_metadata    The plugin metadata of the current version of the plugin.
	 * @param   Object $new_plugin_metadata        The plugin metadata of the new version of the plugin.
	 */
	public function vcbbb_show_upgrade_notification( $current_plugin_metadata, $new_plugin_metadata = null ) {
		if ( ! $new_plugin_metadata ) {
			$new_plugin_metadata = $this->vcbbb_update_metadata( $current_plugin_metadata['slug'] );
		}
		// Check "upgrade_notice".
		if ( isset( $new_plugin_metadata->upgrade_notice ) && strlen( trim( $new_plugin_metadata->upgrade_notice ) ) > 0 ) {
			echo '<div style="background-color: #d54e21; padding: 10px; color: #f9f9f9; margin-top: 10px"><strong>Important Upgrade Notice:</strong> ';
			echo esc_html( strip_tags( $new_plugin_metadata->upgrade_notice ) ), '</div>';
		}
	}

	/**
	 * Get information about the newest plugin version.
	 *
	 * @since   1.4.6
	 *
	 * @param   String $plugin_slug            The slug of the old plugin version.
	 * @return  Object $new_plugin_metadata    The metadata of the new plugin version.
	 */
	private function vcbbb_update_metadata( $plugin_slug ) {
		$plugin_updates = get_plugin_updates();
		foreach ( $plugin_updates as $update ) {
			if ( $update->update->slug === $plugin_slug ) {
				return $update->update;
			}
		}
	}

	/**
	 * Check for room server settings change requests.
	 *
	 * @since   3.0.0
	 *
	 * @return  Integer 1|2|3   If the room servers have been changed or not.
	 *                          0 - failure
	 *                          1 - success
	 *                          2 - bad url format
	 *                          3 - bad bigbluebutton settings configuration
	 */
	private function room_server_settings_change() {
		if ( ! empty( $_POST['action'] ) && 'vcbbb_general_settings' == wp_unslash( $_POST['action'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vcbbb_edit_server_settings_meta_nonce'] ) ), 'vcbbb_edit_server_settings_meta_nonce' ) ) {
			if ( isset( $_POST['vcbbb_url'] ) ) {
				$bbb_url  = sanitize_text_field( wp_unslash( $_POST['vcbbb_url'] ) );
				$bbb_salt = sanitize_text_field( wp_unslash( $_POST['vcbbb_salt'] ) );

				$bbb_url .= ( substr( $bbb_url, -1 ) == '/' ? '' : '/' );

				// Remove duplicate /api/ in the end if exists
				$bbb_url = str_replace( '/bigbluebutton/api', '/bigbluebutton', $bbb_url );

				if ( ! VCBBB_Api::test_bigbluebutton_server( $bbb_url, $bbb_salt ) ) {
					return 3;
				}

				// if ( substr_compare( $bbb_url, 'bigbluebutton/', strlen( $bbb_url ) - 14 ) !== 0 ) {
				// 	return 2;
				// }

				update_option( 'vcbbb_url', $bbb_url, false );
				update_option( 'vcbbb_salt', $bbb_salt, false );
			}
	
			do_action( 'vcbbb_settings_form_save' );
	
			return 1;
		}
		return 0;
	}

	/**
	 * Generate missing heartbeat API if missing.
	 *
	 * @since   3.0.0
	 */
	public function check_for_heartbeat_script() {
		$bbb_warning_type = 'vcbbb-missing-heartbeat-api-notice';
		if ( ! wp_script_is( 'heartbeat', 'registered' ) && ! get_option( 'dismissed-' . $bbb_warning_type, false ) ) {
			$bbb_admin_warning_message = __( 'BigBlueButton works best with the heartbeat API enabled. Please enable it.', 'video-conferencing-with-bbb' );
			$bbb_admin_notice_nonce    = wp_create_nonce( $bbb_warning_type );
			require 'partials/bigbluebutton-warning-admin-notice-display.php';
		}
	}

	/**
	 * Generate review plugin notice.
	 *
	 * @since   3.0.0
	 */
	public function notice_review_plugin() {
		if ( ! function_exists( 'get_current_screen' ) ) {
			include ABSPATH . '/wp-admin/includes/screen.php';
		}

		if ( function_exists( 'get_current_screen' ) ) {
			// show notice only on admin plugin pages
			$current_screen = get_current_screen();
			$allowed        = array( 'edit-bbb-room', 'bbb-room', 'bbb-rooms_page_bbb-room-server-settings', 'edit-bbb-room-category' );
			if ( isset( $current_screen->id ) && ! in_array( $current_screen->id, $allowed ) ) {
				return;
			}
		}

		$bbb_warning_type = 'vcbbb-review-plugin';
		if ( VCBBB_Admin_Helper::check_posts() ) {
			$bbb_admin_review_message = '<strong>' . VIDEO_CONF_WITH_BBB_PLUGIN_NAME . ':</strong> You have reached the max room create limit. The free version allows to add only 2 new BBB rooms. To create unlimited rooms activate the Pro version';
			$bbb_admin_notice_nonce   = wp_create_nonce( $bbb_warning_type );
			$type                     = 'room_create_limit';
			$notice_type              = 'error';
			include 'partials/bigbluebutton-admin-notice.php';
		}

		$bbb_warning_type = 'vcbbb-review-plugin';
		if ( ! get_option( 'dismissed-' . $bbb_warning_type, false ) ) {
			$bbb_admin_review_message = '<strong>' . VIDEO_CONF_WITH_BBB_PLUGIN_NAME . ":</strong> It's critical for us to know how the plugin is working out for you.";
			$bbb_admin_notice_nonce   = wp_create_nonce( $bbb_warning_type );
			$type                     = 'review_request';
			$notice_type              = 'info';
			include 'partials/bigbluebutton-admin-notice.php';
		}
	}

	/**
	 * Hide others rooms if user does not have permission to edit them.
	 *
	 * @since  3.0.0
	 *
	 * @param  Object $query   Query so far.
	 * @return Object $query   Query for rooms.
	 */
	public function filter_rooms_list( $query ) {
		global $pagenow;

		if ( 'edit.php' != $pagenow || ! $query->is_admin || ! isset( $query->query_vars['post_type'] ) || 'bbb-room' != $query->query_vars['post_type'] ) {
			return $query;
		}

		if ( ! current_user_can( 'edit_others_bbb_rooms' ) ) {
			$query->set( 'author', get_current_user_id() );
		}
		return $query;
	}

	/**
	 * Display a custom taxonomy dropdown in admin
	 *
	 * @author Mike Hemberger
	 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
	 */
	public function vcbbb_filter_post_type_by_taxonomy() {
		global $typenow;
		$post_type = 'bbb-room'; // change to your post type
		$taxonomy  = 'bbb-room-category'; // change to your taxonomy
		if ( $typenow == $post_type ) {
			$selected      = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
			$info_taxonomy = get_taxonomy( $taxonomy );
			wp_dropdown_categories(
				array(
					'show_option_all' => sprintf( __( 'Show all %s', 'video-conferencing-with-bbb' ), $info_taxonomy->label ),
					'taxonomy'        => $taxonomy,
					'name'            => $taxonomy,
					'orderby'         => 'name',
					'selected'        => $selected,
					'show_count'      => true,
					'hide_empty'      => true,
				)
			);
		};
	}

	/**
	 * Filter posts by taxonomy in admin
	 *
	 * @author  Mike Hemberger
	 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
	 */
	public function vcbbb_convert_id_to_term_in_query( $query ) {
		global $pagenow;
		$post_type = 'bbb-room'; // change to your post type
		$taxonomy  = 'bbb-room-category'; // change to your taxonomy
		$q_vars    = &$query->query_vars;
		if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && $q_vars[ $taxonomy ] != 0 ) {
			$term                = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
			$q_vars[ $taxonomy ] = $term->slug;
		}

		return $query;
	}

	/**
	 * Order posts by menu_order in admin
	 */
	public function vcbbb_order_rooms( $query ) {
		if ( ! is_admin() ) {
			return;
		}

		$post_type = $query->get( 'post_type' );
		if ( 'bbb-room' != $post_type ) {
			return;
		}

		if ( ! function_exists( 'get_current_screen' ) ) {
			include ABSPATH . '/wp-admin/includes/screen.php';
		}

		if ( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			if ( $screen && 'edit' == $screen->base && 'bbb-room' == $screen->post_type && ! isset( $_GET['orderby'] ) ) {
				$query->set( 'orderby', 'menu_order' );
				$query->set( 'order', 'ASC' );
			}
		}
	}

	/**
	 * Start meeting from admin
	 */
	public function vcbbb_start_meeting_admin() {
		if ( ! isset( $_GET['start_bbb_meeting_admin'] ) || ! isset( $_GET['_wpnonce'] ) || ! isset( $_GET['code'] ) ) {
			return;
		}

		// Sanitize first
$nonce = isset($_GET['_wpnonce']) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';

// Verify nonce
if ( ! wp_verify_nonce( $nonce, 'start_meeting' ) ) {
    wp_die( esc_html__( 'Security check failed', 'video-conferencing-with-bbb' ) );
}

		$access_code = sanitize_text_field( wp_unslash( $_GET['code'] ) );
		$room_id     = absint( $_GET['room_id'] );
		$user        = wp_get_current_user();
		$username    = ( $user && ! empty( $user->display_name ) ) ? $user->display_name : ( $user && ! empty( $user->user_login ) ? $user->user_login : __( 'Moderator', 'video-conferencing-with-bbb' ) );

		if ( empty( $access_code ) || ! $room_id ) {
			wp_die( esc_html__( 'Invalid room or access code.', 'video-conferencing-with-bbb' ) );
		}

		$join_url = VCBBB_Api::get_join_meeting_url( $room_id, $username, $access_code );
		if ( empty( $join_url ) ) {
			wp_die( esc_html__( 'Unable to create or join the meeting. Please check your BigBlueButton server settings.', 'video-conferencing-with-bbb' ) );
		}

		wp_redirect( $join_url );
		exit;
	}

	/**
	 * Add contextual help
	 */
	public function add_help_tab( $screen ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		if ( ! isset( $screen->id ) || 'edit-bbb-room' != $screen->id ) {
			return;
		}

		ob_start();
		include 'partials/bigbluebutton-admin-help-tab-shortcode.php';
		$shortcode_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		include 'partials/bigbluebutton-admin-help-tab-invite.php';
		$invite_content = ob_get_contents();
		ob_end_clean();

		$screen->add_help_tab(
			array(
				'id'      => 'edit-bbb-room-shortcode',
				'title'   => __( 'Add Shortcode to Page', 'video-conferencing-with-bbb' ),
				'content' => $shortcode_content,
			)
		);

		$screen->add_help_tab(
			array(
				'id'      => 'edit-bbb-room-participants',
				'title'   => __( 'Invite Participants', 'video-conferencing-with-bbb' ),
				'content' => $invite_content,
			)
		);
	}
}
