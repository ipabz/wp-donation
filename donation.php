<?php
/*
Plugin Name: Tulsa Community Donation
Plugin URI: http://www.yourpluginurlhere.com/
Version: 1.0
Author: Squiggle Group
Description: 
*/


function the_form(){
    require_once( plugin_dir_path( __FILE__ ) . 'ui.php' );
}

add_shortcode('donation_form', 'the_form');

/**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
add_action( 'wp_enqueue_scripts', 'load_plugin_assets' );

/**
 * Enqueue plugin style-file
 */
function load_plugin_assets() {
    // Respects SSL, Style.css is relative to the current file
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
?>