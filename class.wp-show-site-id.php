<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WP_Show_Site_ID' ) ) {

	/**
	 * Class WP_Show_Site_ID
	 * @since 1.0.0
	 */
	class WP_Show_Site_ID {
		/**
		 * Single instance of the class
		 *
		 * @var \WP_Show_Site_ID
		 */

		protected static $instance;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WC_Dynamic_Discounts
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * WP_Show_Site_ID constructor.
		 */
		function __construct() {

			// This check prevents using this plugin not in a multisite.
			if ( function_exists( 'is_multisite' ) && ! is_multisite() ) {
				add_action( 'admin_notices', array( $this, 'show_error_no_multisite' ), 999 );
				return;
			}

			add_action( 'admin_bar_menu', array( $this, 'add_toolbar_items' ), 100 );
		}

		/**
		 * Callback of hooks 'admin_bar_menu' add the Side ID to Admin WordPress Menu
		 *
		 * @param $admin_bar
		 * @return void
		 */
		public function add_toolbar_items( $admin_bar ) {

			//Show the site ID only to super administrator
			if ( ! is_super_admin() ) {
				return;
			}

			$admin_bar->add_menu( apply_filters( 'wp_show_site_id_menu_args', array(
				'id'    => 'wp-site-ID',
				'title' => sprintf( __( 'Site ID: %d', 'wp-show-site-id' ), get_current_blog_id() ),
				'href'  => esc_url( network_admin_url( 'site-info.php?id=' . get_current_blog_id() ) ),
				'meta'  => array(
					'title' => __( 'Edit this site', 'wp-show-site-id' ),
				),
			), $admin_bar ) );

		}


		/**
		 * Show an error after the plugin activation if the installation
		 * of Wordpress is not a multisite.
		 * It is the callback of 'admin_notices'
		 *
		 * @return void
		 */
		public function show_error_no_multisite() {

			deactivate_plugins( WP_SHOW_SITE_ID_START );
			?>
			<div class="error">
				<p>
					<?php esc_html_e( 'The plugin only works in a multisite installation. It will be deactivated.', 'wp-show-site-id' ); ?>
				</p>
			</div>
			<?php
		}
	}
}

/**
 * Unique access to instance of WP_Show_Site_ID class
 *
 * @return \WP_Show_Site_ID
 */
function WP_Show_Site_ID() {
	return WP_Show_Site_ID::get_instance();
}
