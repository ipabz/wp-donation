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
	
	private $settings = array(
		'wpdonation_stripe_secret_key' => 'put your stripe secret key here',
		'wpdonation_stripe_public_key' => '<put your stripe public key here>'
	);
	
	public function __construct() 
	{
		add_action('init', array($this, 'init'));		
	}
	
	public function init()
	{
		add_action('admin_menu', array($this, 'wpdonation_settings_page'));
		add_action('admin_init', array($this, 'wpdonation_register_settings'));
		add_action('wp_enqueue_scripts', array($this, 'wpdonation_init_frontend_scripts_styles'));
		add_action('wp_enqueue_scripts', array($this, 'wpdonation_init_backend_scripts_styles'));       
        add_shortcode('wp-donation', array($this,'wpdonation_ui'));
		$this->create_post_types();
	}
	
	
	protected function create_post_types()
	{
		register_post_type( 'wpdonation_donors',
		    array(
		      'labels' => array(
		        'name' => __( 'Donors' ),
		        'singular_name' => __( 'Donor' ),
		        'add_new_item' => __('Add New Donor')
		      ),
		      'public' => true,
		      'has_archive' => true,
		      'supports' => array('title')
		    )
		  );

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
		
	}
	
	public function wpdonation_register_settings() {
		foreach ($this->settings as $setting_name => $default_value) {
			register_setting('wpdonation_settings', $setting_name);
		}

		add_meta_box("wpdonation_donor_custom_fields", "Donor Info", array($this, "wpdonation_donor_custom_fields"), "wpdonation_donors", "normal", "low");
		add_action('save_post', array($this, 'wpdonation_donor_save_details')); 
	}


	public function wpdonation_donor_custom_fields()
	{
		global $post;

		$custom = get_post_custom($post->ID);
		$name = $custom["wpdonation_donor_name"][0];
		$email = $custom["wpdonation_donor_email"][1];
		$address = $custom["wpdonation_donor_address"][2];
		$city = $custom["wpdonation_donor_city"][3];
		$state = $custom["wpdonation_donor_state"][4];
		$zipcode = $custom["wpdonation_donor_zipcode"][5];
		$country = $custom["wpdonation_donor_country"][6];

		?>
		<table>
			<tr>
				<td>Donor Name</td>
				<td><input type="text" name="wpdonation_donor_name" value="<?php echo $name; ?>" /></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="wpdonation_donor_email" value="<?php echo $email; ?>" /></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><input type="text" name="wpdonation_donor_address" value="<?php echo $address; ?>" /></td>
			</tr>
			<tr>
				<td>City</td>
				<td><input type="text" name="wpdonation_donor_city" value="<?php echo $city; ?>" /></td>
			</tr>
			<tr>
				<td>State</td>
				<td><input type="text" name="wpdonation_donor_state" value="<?php echo $state; ?>" /></td>
			</tr>
			<tr>
				<td>Zip Code</td>
				<td><input type="text" name="wpdonation_donor_zipcode" value="<?php echo $zipcode; ?>" /></td>
			</tr>
			<tr>
				<td>Country</td>
				<td><input type="text" name="wpdonation_donor_country" value="<?php echo $country; ?>" /></td>
			</tr>
		</table>
		<?php
	}

	public function wpdonation_donor_save_details()
	{
		global $post;
 		
  		update_post_meta($post->ID, "wpdonation_donor_name", $_POST["wpdonation_donor_name"]);
  		update_post_meta($post->ID, "wpdonation_donor_email", $_POST["wpdonation_donor_email"]);3
  		update_post_meta($post->ID, "wpdonation_donor_address", $_POST["wpdonation_donor_address"]);
  		update_post_meta($post->ID, "wpdonation_donor_city", $_POST["wpdonation_donor_city"]);
  		update_post_meta($post->ID, "wpdonation_donor_state", $_POST["wpdonation_donor_state"]);
  		update_post_meta($post->ID, "wpdonation_donor_zipcode", $_POST["wpdonation_donor_zipcode"]);
  		update_post_meta($post->ID, "wpdonation_donor_country", $_POST["wpdonation_donor_country"]);
	}

	
	public function wpdonation_ui(){
        require_once( plugin_dir_path( __FILE__ ) . 'wp-donation-ui.php' );
    }
    
    
}

WPDonation::get_instance();
