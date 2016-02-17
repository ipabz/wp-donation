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
		add_action('wp_enqueue_scripts', array($this, 'wpdonation_init_frontend_scripts_styles'));
		add_action('wp_enqueue_scripts', array($this, 'wpdonation_init_backend_scripts_styles'));
        
        add_shortcode('wp-donation', array($this,'wpdonation_form'));
	}
	

	public function wpdonation_settings_page() {
		add_options_page( 'WP-Donation Options', 'WP-Donation', 'manage_options', 'WP-Donation', array($this, 'wpdonation_settings_page_content') );
	}

	public function wpdonation_settings_page_content() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		$blog_url = rtrim(site_url(), "/") . "/";
		include 'wp-donation-settings.php';
	}
	
	
	public function wpdonation_init_frontend_scripts_styles() {
		wp_register_style( 'bootstrap', plugins_url('css/bootstrap.min.css', __FILE__) );
        wp_register_style( 'custom', plugins_url('css/custom.css', __FILE__) );
        wp_register_style( 'rwd', plugins_url('css/rwd.css', __FILE__) );
        wp_register_style( 'roboto', 'https://fonts.googleapis.com/css?family=Roboto:400,300,700,900' );
        
        wp_register_script( 'bootstrap', plugins_url('js/bootstrap.min.js', __FILE__), array( 'jquery' ) );
        wp_register_script( 'script', plugins_url('js/script.js', __FILE__),array( 'jquery' ) );
        wp_register_script( 'jquery-numeric', plugins_url('js/jquery.numeric.min.js', __FILE__),array( 'jquery' ) );
        
        wp_enqueue_style( 'roboto' );
        wp_enqueue_style( 'bootstrap' );
        wp_enqueue_style( 'custom' );
        wp_enqueue_style( 'rwd' );
        
        wp_enqueue_script( 'bootstrap' );
        wp_enqueue_script( 'script' );
        wp_enqueue_script( 'jquery-numeric' );
	}
	
	public function wpdonation_init_backend_scripts_styles() {
		// put scripts, styles here for the frontend
	}
	
	public function wpdonation_ui(){
        require_once( plugin_dir_path( __FILE__ ) . 'wp-donation-ui.php' );
    }
    
    
}


WPDonation::get_instance();
