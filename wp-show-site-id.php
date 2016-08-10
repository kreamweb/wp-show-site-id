<?php
/**
 * Plugin Name: Wp Show Site ID
 * Plugin URI: https://wpmoon.com/
 * Description: This plugin in a multisite installation shows the ID od the current site/blog
 * Version: 1.0.0
 * Author: Kreamweb
 * Author URI: https://kreamweb.com
 * Requires at least: 4.4
 * Tested up to: 4.5
 *
 * Text Domain: wp-show-site-id
 * Domain Path: /languages/
 *
 */

define( 'WP_SHOW_SITE_ID_START_VERSION', '0.0.1'  );
if ( ! defined( 'WP_SHOW_SITE_ID_START_VERSION' ) ) {
	define( 'WP_SHOW_SITE_ID_START_VERSION', '1.0.0' );
}


if ( ! defined( 'WP_SHOW_SITE_ID_START' ) ) {
	define( 'WP_SHOW_SITE_ID_START', plugin_basename( __FILE__ ) );
}

add_filter( 'plugins_loaded', 'wp_show_site_id_start' );

if ( ! function_exists( 'wp_show_site_id_start' ) ) {
	function wp_show_site_id_start() {

		require_once( 'class.wp-show-site-id.php' );
		WP_Show_Site_ID();
	}
}

