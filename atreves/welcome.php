<?php
/**
 * AKD Flow !!!
 *
 * @package AkdFlow
 */

define( 'REQUIRED_PLUGIN_VERSION', '1.0.1' );
add_action( 'admin_menu', 'akd_welcome_about_menu_page' );

/**
 * AKD welcome menu page
 */
function akd_welcome_about_menu_page() {
	$required_plugin = get_option( '_akd_requied_plugin_inst' );
	if ( ! $required_plugin ) {
		$activated_theme = wp_get_theme();
		$theme_name      = $activated_theme->get( 'Name' );
		add_theme_page(
			__( 'Welcome to atreves', 'atreves' ),
			__( 'Welcome to atreves', 'atreves' ),
			'edit_theme_options',
			sanitize_title( $theme_name ),
			'akd_menu_page_content'
		);
	}
}

/**
 * Define content for akd menu page
 */
function akd_menu_page_content() {
	$activated_theme = wp_get_theme();
	?>
	<div class="akd-about-menu-page">
		<div class="akd-logo">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo/logo.png' ); ?>" alt="<?php echo esc_attr( $activated_theme->get( 'Name' ) ); ?>">
		</div>
		<h1 class="akd-menu-page-title" style="width:30%">
			<?php
				$theme_name    = esc_html( $activated_theme->get( 'Name' ) );
				$theme_version = esc_html( $activated_theme->get( 'Version' ) );
				printf(
					/* translators: 1: Theme name, 2: Theme version */
					esc_html__( 'Introducing %1$s %2$s', 'atreves' ),
					esc_html( $theme_name ),
					esc_html( $theme_version )
				);
			?>
		</h1>
		<div class="akd-menu-page-desc" style="width:30%">
			<p>
				<?php esc_html_e( 'This theme is designed & developed by Designing Media. In case of any issues, please contact us through our support channel at', 'atreves' ); ?>
				<a href="<?php echo esc_url( 'http://designingmedia.com/support/' ); ?>"><?php esc_html_e( 'designingmedia.com/support', 'atreves' ); ?></a>.
			</p>
			<p>
				<?php esc_html_e( 'To continue the setup, please click install button to install and activate', 'atreves' ); ?>
				<b><?php esc_html_e( 'AKD Demo Importer', 'atreves' ); ?></b>.
			</p>
		</div>
		<div class="akd-menu-page-btn">
			<a class="install-akd-framework" href="#" data-slug="akd-demo-importer" data-name="akd-demo-importer" data-processing=" <?php esc_attr_e( 'Installing ...', 'atreves' ); ?> " aria-label=" <?php esc_attr_e( 'Install akd_framework', 'atreves' ); ?> "> <?php esc_html_e( 'Install', 'atreves' ); ?></a>		
		</div>
	</div>
	<?php
}

/**
 * Redirect to AKD menu page on theme activation
 */
add_action( 'admin_init', 'akd_redirect_on_theme_activation' );

/**
 * Redirect user on the theme activation
 */
function akd_redirect_on_theme_activation() {
	if ( ( isset( $_GET['activated'] ) && is_admin() ) || ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'activate_akd_framework_nonce' ) ) ) {
		$required_plugin = get_option( '_akd_requied_plugin_inst' );
		if ( ! $required_plugin ) {
			$activated_theme = wp_get_theme();
			wp_safe_redirect( admin_url( 'themes.php?page=' . sanitize_title( $activated_theme->get( 'Name' ) ) ) );
			exit;
		}
	}

	if ( isset( $_GET['page'] ) && 'merlin' === $_GET['page'] ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
}


add_action( 'wp_ajax_install_plugin', 'akd_required_plugin_callback' );
/**
 * Method to install requierd plugin for theme
 */
function akd_required_plugin_callback() {
	$nonce = isset( $_POST['akdNonce'] ) ? sanitize_text_field( wp_unslash( $_POST['akdNonce'] ) ) : '';
	if ( isset( $_POST['plugin_slug'] ) && isset( $nonce ) && wp_verify_nonce( $nonce, 'activate_akd_framework_nonce' ) ) {
		$plugin_slug = isset( $_POST['plugin_slug'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin_slug'] ) ) : '';
		$plugin_name = isset( $_POST['plugin_name'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin_name'] ) ) : '';
		$plugin      = $plugin_slug . '/' . $plugin_slug . '.php';
	}

	include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	include_once ABSPATH . 'wp-admin/includes/file.php';
	include_once ABSPATH . 'wp-admin/includes/misc.php';
	include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

	/**
	 * Check if the plugin is active
	 */
	$plugin_path = WP_PLUGIN_DIR . '/' . $plugin;
	if ( file_exists( $plugin_path ) ) {
		deactivate_plugins( $plugin );
	}

	/**
	 * Attempt to delete the plugin
	 */
	$result = delete_plugins( array( $plugin ) );

	$zip_file_path = get_template_directory() . '/plugins/' . $plugin_slug . '.zip';
	$plugin_dir    = WP_PLUGIN_DIR . '/' . $plugin_slug;

	/**
	 * Download the ZIP file using wp_remote_get
	 */
	$response = wp_remote_get(
		'https://designingmedia.com/Plugins/atreves/akd-demo-importer.zip',
		array(
			'timeout' => 900,
		),
	);

	if ( is_wp_error( $response ) ) {
		wp_send_json_error( 'Error downloading the file.' );
	}

	$zip_file_content = wp_remote_retrieve_body( $response );

	if ( empty( $zip_file_content ) ) {
		wp_send_json_error( 'Error: File content is empty.' );
	}

	global $wp_filesystem;
	WP_Filesystem();

	/**
	 * Write the file content to a temporary file using WP_Filesystem
	 */
	if ( ! $wp_filesystem->put_contents( $zip_file_path, $zip_file_content, FS_CHMOD_FILE ) ) {
		wp_send_json_error( 'Error saving the file.' );
	}

	$zip = new ZipArchive;
	if ( true === $zip->open( $zip_file_path ) ) {

		/**
		 * Check if the plugin directory already exists
		 */
		if ( ! file_exists( $plugin_dir ) ) {
			/**
			 * Create the plugin directory
			 */
			wp_mkdir_p( $plugin_dir );

			/**
			 * Unzip the plugin file to the plugins directory
			 */
			$result = $zip->extractTo( $plugin_dir );
			$zip->close();

			$wp_filesystem->delete( $zip_file_path );

			/**
			 * Check if the plugin was unzipped successfully
			 */
			if ( $result ) {

				$plugin_things = akd_check_plugin_files_and_version();

				if ( $plugin_things ) {
					activate_plugin( $plugin );
					$arr = array(
						'required_akd_plugin'        => true,
						'required_akd_plugin_notice' => true,
					);
					update_option( '_akd_requied_plugin_inst', $arr );
					wp_send_json_success( 'Plugin installed and activated successfully.' );
				} else {
					$wp_filesystem->delete( $zip_file_path );
					wp_send_json_error( 'Something went wrong. Your installed AKD Demo Importer plugin version or files are mismatched consider it deleting and try again.' );
				}
			} else {
				$wp_filesystem->delete( $zip_file_path );
				wp_send_json_error( 'Error installing the plugin.' );
			}
		} else {

			$plugin_things = akd_check_plugin_files_and_version();
			$wp_filesystem->delete( $zip_file_path );
			if ( $plugin_things ) {
				wp_send_json_success( 'Plugin already installed and activated.' );
			} else {
				wp_send_json_error( 'Something went wrong. Your installed AKD Demo Importer plugin version or files are mismatched consider it deleting and try again.' );
			}
		}
	} else {
		wp_send_json_error( 'Error opening the ZIP file.' );
	}
}

/**
 * Method to check AKD Demo Importer plugin files and version
 */
function akd_check_plugin_files_and_version() {
	$plugin_things = false;
	$plugin_dir    = WP_PLUGIN_DIR . '/akd-demo-importer';

	/**
	 * Define the main plugin file path
	 */
	$plugin_file = $plugin_dir . '/akd-demo-importer.php';

	if ( is_dir( $plugin_dir ) ) {
		/**
		 * Check if the main plugin file exists
		 */
		if ( file_exists( $plugin_file ) ) {
			/**
			 * Check if a specific version is required
			 */
			if ( REQUIRED_PLUGIN_VERSION ) {
				/**
				 * Get the plugin data (this includes version info)
				 */
				$plugin_data = get_plugin_data( $plugin_file );

				/**
				 * Check if the version matches the required version
				 */
				if ( version_compare( $plugin_data['Version'], REQUIRED_PLUGIN_VERSION, '>=' ) ) {
					$plugin_things = true;
				}
			}
		} else {
			$plugin_things = false;
		}
	}

	return $plugin_things;
}

/**
 * Enqueue scripts and styles for the admin area
 */
add_action( 'admin_enqueue_scripts', 'akd_enqueue_admin_assets' );

/**
 * Method to enqueue required scripts
 */
function akd_enqueue_admin_assets() {
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/assets/css/custom-style.css', array(), '1.0' );
	wp_enqueue_style( 'akd-sweetalert', get_template_directory_uri() . '/assets/css/sweetalert2.min.css', array(), '1.0' );

	wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/assets/js/custom-script.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'akd-sweetalert', get_template_directory_uri() . '/assets/js/sweetalert2.min.js', array( 'jquery' ), '1.0', true );

	/**
	 * Localize script with necessary data
	 */
	akd_localize_custom_script();
}

/**
 * Localize custom script with necessary data
 */
function akd_localize_custom_script() {

	$activated_theme = wp_get_theme();
	/**
	 * Prepare data for localization
	 */
	$localization_data = array(
		'ajaxUrl'               => esc_url( admin_url( 'admin-ajax.php' ) ),
		'adminUrl'              => esc_url( admin_url() ),
		'themeTemplate'         => esc_html( $activated_theme->get_template() ),
		'akdNonce'              => wp_create_nonce( 'activate_akd_framework_nonce' ),
		'requiredPlguinVersion' => REQUIRED_PLUGIN_VERSION,
	);

	/**
	 * Localize custom script
	 */
	wp_localize_script( 'custom-script', 'urls', $localization_data );
}

add_action( 'admin_notices', 'akd_show_activation_notice' );
/**
 * Method to add required plugin notice
 */
function akd_show_activation_notice() {
	global $pagenow;

	/**
	 * Get activated theme details
	 */
	$activated_theme = wp_get_theme();

	/**
	 * Activate AKD framework if activation form is submitted
	 */
	akd_activate_akd_framework_plugin();

	/**
	 * Check if the current page is the custom menu page with the slug '{theme-name}'
	 */
	$nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';
	$page  = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
	if ( ( 'themes.php' !== $pagenow || ! $page || ! isset( $nonce ) || ! wp_verify_nonce( $nonce, 'activate_akd_framework_nonce' ) ) && str_replace( ' ', '-', strtolower( $activated_theme ) ) !== $page ) {
		$theme_name     = $activated_theme->get( 'Name' );
		$theme_version  = $activated_theme->get( 'Version' );
		$screenshot_url = get_template_directory_uri() . '/screenshot.png';
		$message        = '';

		/**
		 * Plugin slug (directory name)
		 */
		$plugin_slug = 'akd-demo-importer';

		/**
		 * Check if the plugin is active
		 */
		$active_plugins = get_option( 'active_plugins' );

		if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_slug . '/akd-demo-importer.php' ) && ! in_array( $plugin_slug . '/akd-demo-importer.php', $active_plugins, true ) ) {
			/**
			 * Plugin installed but not activated message
			 */
			$message .= akd_get_activate_plugin_notice( $screenshot_url, $theme_name, $theme_version );
		} elseif ( ! get_option( '_hostiko_requied_akd_plugin' ) && ! in_array( $plugin_slug . '/akd-demo-importer.php', $active_plugins, true ) ) {
			/**
			 * Plugin not installed message
			 */
			$message .= akd_get_required_plugin_notice( $screenshot_url, $theme_name, $theme_version );
		} elseif ( in_array( $plugin_slug . '/akd-demo-importer.php', $active_plugins, true ) && file_exists( $plugin_slug . '/akd-demo-importer.php' ) ) {
			$message .= akd_get_activate_plugin_notice( $screenshot_url, $theme_name, $theme_version );
		}

		/**
		 * Output the message safely
		 */
		echo wp_kses_post( $message );
	}
}

/**
 * Callback method for the notice
 *
 * @param string $screenshot_url The URL of the theme's screenshot.
 * @param string $theme_name The name of the theme.
 * @param string $theme_version The version of the theme.
 */
function akd_get_required_plugin_notice( $screenshot_url, $theme_name, $theme_version ) {
	$theme_desc    = __( 'Meet atreves, your ultimate solution for building digital products, brands, and experiences.', 'atreves' );
	$activate_link = esc_url( admin_url( 'themes.php?page=' . str_replace( ' ', '-', strtolower( $theme_name ) ) ) );

	return sprintf(
		'<div class="notice notice-info is-dismissible">
			<div class="akd-theme-screenshot">
				<img src="%1$s" alt="%2$s">
				<h6>%2$s</h6>
			</div>
			<div class="akd-theme-info">
				<h2>%3$s %4$s</h2>
				<p>%5$s</p>
				<p class="akd-label"><strong>%6$s</strong> %7$s</p>
				<div class="plugin-btn">
					<a href="%8$s" class="button-primary">%9$s</a>
				</div>
			</div>
		</div>',
		esc_url( $screenshot_url ),
		esc_html( $theme_name ),
		__( 'Introducing', 'atreves' ),
		esc_html( $theme_name ) . ' ' . esc_html( $theme_version ),
		esc_html( $theme_desc ),
		__( 'Notice!', 'atreves' ),
		__( 'The "<strong>AKD Demo Importer</strong>" is required.', 'atreves' ),
		$activate_link,
		__( 'Install plugin "AKD Demo Importer"', 'atreves' )
	);
}

/**
 * Callback method for the notice to install plugin
 *
 * @param string $screenshot_url The URL of the theme's screenshot.
 * @param string $theme_name The name of the theme.
 * @param string $theme_version The version of the theme.
 */
function akd_get_activate_plugin_notice( $screenshot_url, $theme_name, $theme_version ) {
	$theme_desc = __( 'Meet atreves, your ultimate solution for building digital products, brands, and experiences.', 'atreves' );

	$plugin_things = akd_check_plugin_files_and_version();
	if ( $plugin_things ) {
		return sprintf(
			'<div class="notice notice-info is-dismissible">
				<div class="akd-theme-screenshot">
					<img src="%1$s" alt="%2$s">
					<h6>%2$s</h6>
				</div>
				<div class="akd-theme-info">
					<h2>%3$s %4$s</h2>
					<p>%5$s</p>
					<hr>
					<p class="akd-label"><strong>%6$s</strong> %7$s</p>
					<form method="post">
						<button class="button-primary" type="submit" name="activate_akd_framework">%8$s</button>
					</form>
				</div>
			</div>',
			esc_url( $screenshot_url ),
			esc_html( $theme_name ),
			__( 'Introducing', 'atreves' ),
			esc_html( $theme_name ) . ' ' . esc_html( $theme_version ),
			esc_html( $theme_desc ),
			__( 'Notice!', 'atreves' ),
			__( 'The <strong>"AKD Demo Importer"</strong> is required.', 'atreves' ),
			__( 'Activate AKD Importer Plugin', 'atreves' )
		);
	} else {
		return sprintf(
			'<div class="notice notice-info is-dismissible">
				<div class="akd-theme-screenshot">
					<img src="%1$s" alt="%2$s">
					<h6>%2$s</h6>
				</div>
				<div class="akd-theme-info">
					<h2>%3$s %4$s</h2>
					<p>%5$s</p>
					<hr>
					<p class="akd-label akd-label-warning"><strong>%6$s</strong> %7$s</p>
				</div>
			</div>',
			esc_url( $screenshot_url ),
			esc_html( $theme_name ),
			__( 'Introducing', 'atreves' ),
			esc_html( $theme_name ) . ' ' . esc_html( $theme_version ),
			esc_html( $theme_desc ),
			__( 'Warning!', 'atreves' ),
			__( 'The <strong>"AKD Demo Importer"</strong> version is outdated. <br><br> Please consider deleting the plugin and try again from <strong> Appearance > Welcome to Atreves </strong>. <br><br>Or try installing latest version manually from the bundled plugin directory.', 'atreves' ),
		);
	}
}

/**
 * Method to activate theme's required plugin
 */
function akd_activate_akd_framework_plugin() {
	/**
	 * Check if the activation trigger is set
	 */
	$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) : '';
	if ( isset( $_POST['activate_akd_framework'] ) && empty( $_POST['activate_akd_framework'] ) && isset( $_POST['activate_akd_framework_plugin'] ) && ! empty( $_POST['activate_akd_framework_plugin'] ) && ! empty( $nonce ) && wp_verify_nonce( $nonce, 'activate_akd_framework_nonce' ) ) {
		if ( 'activate' === sanitize_text_field( wp_unslash( $_POST['activate_akd_framework_plugin'] ) ) ) {

			/**
			 * Retrieve active plugins
			 */
			$active_plugins = get_option( 'active_plugins' );

			/**
			 * Define plugin slug and path
			 */
			$plugin_slug = 'akd-demo-importer';
			$plugin_path = "{$plugin_slug}/akd-demo-importer.php";

			/**
			 * Check if the plugin is not already activated
			 */
			if ( ! in_array( $plugin_path, $active_plugins, true ) ) {
				/**
				 * Activate the plugin
				 */
				activate_plugin( $plugin_path );
			}
		}
	}
}


/**
 * Track required plugin deletion.
 *
 * @param string $plugin The path to the plugin file relative to the plugins directory.
 */
function akd_track_required_plugin_deletion( $plugin ) {
	/**
	 * Sanitize the plugin path
	 */
	$plugin_path = plugin_basename( $plugin );

	if ( 'akd-demo-importer/akd-demo-importer.php' === $plugin_path ) {
		/**
		 * Delete the option if the specified plugin is deleted
		 */
		delete_option( '_akd_requied_plugin_inst' );
	}
}
add_action( 'deleted_plugin', 'akd_track_required_plugin_deletion' );
