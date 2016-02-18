<?php
/**
 * @package WP-Donation
 */
/*
Plugin Name: WP-Donation
Description: Donation Plugin for Stripe
Author: Squiggle Group
Author URI: http://squigglegroup.com/
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
        'wpdonation_stripe_public_key' => 'put your stripe public key here',
        'wpdonation_organization_name' => '',
        'wpdonation_box_color_1' => '#0da7d4',
        'wpdonation_box_color_2' => '#014c6c',
        
        'wpdonation_amount_1' => '20000',
        'wpdonation_amount_label_1' => '20k',
        
        'wpdonation_amount_2' => '50000',
        'wpdonation_amount_label_2' => '50k',
        
        'wpdonation_amount_3' => '100000',
        'wpdonation_amount_label_3' => '100k',
        
        'wpdonation_amount_4' => '500000',
        'wpdonation_amount_label_4' => '500k',
        
        'wpdonation_amount_5' => '1000',
        'wpdonation_amount_label_5' => '1k',
        
        'wpdonation_amount_6' => '5000',
        'wpdonation_amount_label_6' => '5k',
        
        'wpdonation_amount_7' => '10000',
        'wpdonation_amount_label_7' => '10k',
        
        'wpdonation_thankyou_heading' => '',
        'wpdonation_thankyou_message' => ''
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
        
        add_filter( 'manage_wpdonation_donors_posts_columns', array($this,'set_custom_edit_donor_columns') );
        add_action( 'manage_wpdonation_donors_posts_custom_column' , array($this,'custom_donor_column'), 10 ,2 );
	}
	
	
	protected function create_post_types()
	{
		register_post_type( 'wpdonation_donors',
		    array(
		      'labels' => array(
		        'name' => __( 'Donors' ),
		        'singular_name' => __( 'Donor' ),
		        'add_new' => __('Add New Donor'),
		        'add_new_item' => __('Add New Donor'),
		        'edit_item' => __('Edit Donor')
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

    public function set_custom_edit_donor_columns($columns) {
        $columns = array(
            'title' => __( 'Donor Name' ),
            'frequency' => __( 'Frequency' ),
            'amount' => __( 'Amount' ),
            'address' => __( 'Address' ),
            'email' => __( 'Email' ),
            'date' => __( 'Donation Date' )
        );
        return $columns;
    }

    public function custom_donor_column( $column, $post_id ) {
        $custom = get_post_custom($post->ID);
        
        switch ( $column ) {

            case 'amount' :
                echo number_format($custom["wpdonation_donor_amount"][0],2);
                break;

            case 'frequency' :
                echo $custom["wpdonation_donor_recur"][0];
                break;
            
            case 'address' :
                echo $custom["wpdonation_donor_address"][0].', '.$custom["wpdonation_donor_city"][0];
                break;
                
            case 'email' :
                echo $custom["wpdonation_donor_email"][0];
                break;
        }
    }
    
	public function wpdonation_donor_custom_fields()
	{
		global $post;

		$custom = get_post_custom($post->ID);
		$name = $custom["wpdonation_donor_name"][0];
		$email = $custom["wpdonation_donor_email"][0];
		$address = $custom["wpdonation_donor_address"][0];
		$city = $custom["wpdonation_donor_city"][0];
		$state = $custom["wpdonation_donor_state"][0];
		$zipcode = $custom["wpdonation_donor_zipcode"][0];
		$country = $custom["wpdonation_donor_country"][0];
        $recur = $custom["wpdonation_donor_recur"][0];
        $amount = $custom["wpdonation_donor_amount"][0];
        $fee = $custom["wpdonation_donor_fee"][0];
        $note = $custom["wpdonation_donor_note"][0];
        
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
            <tr>
				<td>Donation Type</td>
				<td><input type="text" name="wpdonation_donor_recur" value="<?php echo $recur; ?>" disabled /></td>
			</tr>
            <tr>
				<td>Amount</td>
				<td><input type="text" name="wpdonation_donor_amount" value="<?php echo $amount; ?>" disabled /></td>
			</tr>
            <tr>
				<td>Processing Fee</td>
				<td><input type="text" name="wpdonation_donor_fee" value="<?php echo $fee; ?>" disabled /></td>
			</tr>
            
            <tr>
				<td>Additional Info</td>
				<td><input type="text" name="wpdonation_donor_note" value="<?php echo $note; ?>" disabled /></td>
			</tr>
		</table>
		<?php
	}

	public function wpdonation_donor_save_details()
	{
		global $post;
 		
  		update_post_meta($post->ID, "wpdonation_donor_name", $_POST["wpdonation_donor_name"]);
  		update_post_meta($post->ID, "wpdonation_donor_email", $_POST["wpdonation_donor_email"]);
  		update_post_meta($post->ID, "wpdonation_donor_address", $_POST["wpdonation_donor_address"]);
  		update_post_meta($post->ID, "wpdonation_donor_city", $_POST["wpdonation_donor_city"]);
  		update_post_meta($post->ID, "wpdonation_donor_state", $_POST["wpdonation_donor_state"]);
  		update_post_meta($post->ID, "wpdonation_donor_zipcode", $_POST["wpdonation_donor_zipcode"]);
  		update_post_meta($post->ID, "wpdonation_donor_country", $_POST["wpdonation_donor_country"]);
        update_post_meta($post->ID, "wpdonation_donor_recur", $_POST["wpdonation_donor_recur"]);
        update_post_meta($post->ID, "wpdonation_donor_amount", $_POST["wpdonation_donor_amount"]);
        update_post_meta($post->ID, "wpdonation_donor_fee", $_POST["wpdonation_donor_fee"]);
        update_post_meta($post->ID, "wpdonation_donor_note", $_POST["wpdonation_donor_note"]);
	}

	
	public function wpdonation_ui(){        
        if($_POST and !$_SESSION['submitted']){ 
            $post = array(
                'post_title' => $_POST['wpdonation_donor_name'],
                'tags_input' => $tags,
                'post_status' => 'publish',
                'post_type' => 'wpdonation_donors'
            );
            
            $post = wp_insert_post($post);

            $amount = $_POST["wpdonation_donor_amount"];

            if ($amount === 'other') {
            	$amount = $_POST['wpdonation_otheramount'];
            }
            
            update_post_meta($post, "wpdonation_donor_name", $_POST["wpdonation_donor_name"]);
            update_post_meta($post, "wpdonation_donor_email", $_POST["wpdonation_donor_email"]);
            update_post_meta($post, "wpdonation_donor_address", $_POST["wpdonation_donor_address"]);
            update_post_meta($post, "wpdonation_donor_city", $_POST["wpdonation_donor_city"]);
            update_post_meta($post, "wpdonation_donor_state", $_POST["wpdonation_donor_state"]);
            update_post_meta($post, "wpdonation_donor_zipcode", $_POST["wpdonation_donor_zipcode"]);
            update_post_meta($post, "wpdonation_donor_country", $_POST["wpdonation_donor_country"]);
            update_post_meta($post, "wpdonation_donor_recur", $_POST["wpdonation_donor_recur"]);
            update_post_meta($post, "wpdonation_donor_amount", $amount);
            update_post_meta($post, "wpdonation_donor_fee", $_POST["wpdonation_donor_fee"]);
            update_post_meta($post, "wpdonation_donor_note", $_POST["wpdonation_donor_note"]);           
	    	

            $desc = "Donation from " . $_POST["wpdonation_donor_name"];

            $metaData = [
				'Organization' => get_option('wpdonation_organization_name'),
				'Donor Name' => $_POST["wpdonation_donor_name"],
				'Address' => $_POST["wpdonation_donor_address"] . ', ' . $_POST["wpdonation_donor_city"]. ' ' . $_POST["wpdonation_donor_zipcode"] 
			];

			$coverFee = false;

            $c = $this->charge(
            		$_POST['wpdonation_card_number'],
            		$_POST['wpdonation_exp_month'],
            		$_POST['wpdonation_exp_year'],
            		$amount,
            		$desc,
            		$coverFee,
            		$metaData,
            		$post,
            		$_POST
            	);

            if ($c !== TRUE) {			
				// show error
				$_SESSION['submitted'] = false;
				$_SESSION['error'] = $c;
            	require_once( plugin_dir_path( __FILE__ ) . 'wp-donation-ui.php' );
			} else {
				require_once( plugin_dir_path( __FILE__ ) . 'wp-donation-thankyou.php' );            
            	$_SESSION['submitted'] = true;
			}            
            
        }else{
        	unset($_SESSION['error']);
            $_SESSION['submitted'] = false;
            require_once( plugin_dir_path( __FILE__ ) . 'wp-donation-ui.php' );
        }
    }


    protected function charge($cardNumber, $expMonth, $expYear, $amount, $description, $coverProcessingFee=false, $metaData=[], $postID=NULL,$donorDetails=[], $currency="usd")
    {
    	require_once( plugin_dir_path( __FILE__ ) . 'stripe-php/init.php' );

    	$amount = $amount * 100;

		if ( $coverProcessingFee ) {
			$amount = $amount + (($amount * 0.03) + 0.3);
		}

		\Stripe\Stripe::setApiKey(get_option('wpdonation_stripe_secret_key'));

		$card = [
			'number' => $cardNumber, 
			'exp_month' => $expMonth, 
			'exp_year' => $expYear
		];

		try {

			$customer = \Stripe\Customer::create([
				'email' => $donorDetails['wpdonation_donor_email'],
				'metadata' => [
					'name' => $donorDetails['wpdonation_donor_name'],
					'address' => $donorDetails['wpdonation_donor_address'],
					'city' => $donorDetails['wpdonation_donor_city'],
					'zipcode' => $donorDetails['wpdonation_donor_zipcode']
				],
				'card' => $card
			]);

			$charge = \Stripe\Charge::create([
				'amount' => $amount, 
				'currency' => $currency,
				'description' => $description,
				'metadata' => $metaData,
				'customer' => $customer->id
			]);

			update_post_meta($postID, "wpdonation_donor_stripe_customer_id", $customer->id);    

		} catch(Exception $e) {
			return $e->getMessage();
		}


		return $charge->paid;
    }
    
    
}

WPDonation::get_instance();
