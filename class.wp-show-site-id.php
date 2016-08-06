<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WP_Show_Site_ID' ) ) {

	/**
	 * Class WP_Show_Site_ID
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
			if ( is_multisite() ) {
				add_action( 'admin_bar_menu', array( $this, 'add_toolbar_items' ), 100 );
			}
		}


		/**
		 * Callback of hooks 'admin_bar_menu' add the Side ID to Admin WordPress Menu
		 *
		 * @param $admin_bar
		 */
		public function add_toolbar_items( $admin_bar ) {

			//Show the site ID only to super administrator
			if ( ! is_super_admin() ) {
				return;
			}

			$admin_bar->add_menu( array(
				'id'    => 'wp-site-ID',
				'title' => sprintf( __( 'Site ID: %d', 'wp-show-site-id' ), get_current_blog_id() ),
				'href'  => esc_url( network_admin_url( 'site-info.php?id=' . get_current_blog_id() ) ),
				'meta'  => array(
					'title' => __( 'Edit this site', 'wp-show-site-id' ),
				),
			) );
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