<?php
/*
 * Plugin Name: Custom Admin and Login Styling
 * Plugin URI: https://vontainment.com
 * Description: This plugin checks for custom-admin.css and custom-login.css in the theme's assets/css directory and enqueues them in the WordPress admin and wp-login.php pages, respectively.
 * Author: YVontainment
 * Version: 1.0
 * Author URI: https://vontainment.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Custom_Admin_Login_Styling' ) ) {
	class Custom_Admin_Login_Styling {
		function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_css' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'enqueue_login_css' ) );
		}

		function enqueue_admin_css() {
			$admin_css_path = get_template_directory() . '/assets/css/custom-admin.css';
			if ( file_exists( $admin_css_path ) ) {
				wp_enqueue_style( 'custom-admin', get_template_directory_uri() . '/assets/css/custom-admin.css' );
			}
		}

		function enqueue_login_css() {
			$login_css_path = get_template_directory() . '/assets/css/custom-login.css';
			if ( file_exists( $login_css_path ) ) {
				wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/assets/css/custom-login.css' );
			}
		}
	}
	new Custom_Admin_Login_Styling();
}