<?php
/**
 * @package WP-Donation
 */
/*
Plugin Name: WP-Donation
Description: Donation plugin designed for Midamerica Prison Ministry
Author: FindingInnovation
Author URI: http://findinginnovation.com/
License: GPLv2 or later
*/

session_start();

class WPDonation {
	

	protected static $instance = NULL;
	
	public static function get_instance() 
	{
		NULL === self::$instance and self::$instance = new self;
		return self::$instance;
	}
	
	public function __construct() 
	{
		add_action('init', array($this, 'init'));
	}
	
	public function init()
	{
		add_action('admin_menu', array($this, 'wpdonation_settings_page'));
	}
	

	function wpdonation_settings_page() {
		add_options_page( 'WP-Donation Options', 'WP-Donation', 'manage_options', 'WP-Donation', array($this, 'wpdonation_settings_page_content') );
	}

	function wpdonation_settings_page_content() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		$blog_url = rtrim(site_url(), "/") . "/";
		include 'wp-donation-settings.php';
	}
	
	
}


WPDonation::get_instance();
