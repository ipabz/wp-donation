<div class="wrap">
	<h2>WP-Donation Settings</h2>
    
	<div id="welcome-panel" class="welcome-panel">
    <form method="post" action="options.php" class="welcome-panel-content">
    	<?php settings_fields('wpdonation_settings'); ?>
		<?php do_settings_sections('wpdonation_settings'); ?> 
		
        <h2>Organization Details</h2>
        <p class="about-description">Enter the details of the organization that will receive the donation.</p>
        <br />
        
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="organization_name">Organization Name</label></th>
                    <td>
                        <input type="text" id="organization_name" name="wpdonation_organization_name" value="<?php echo get_option('wpdonation_organization_name'); ?>" style="width: 500px;" />
                    </td>
                </tr>
            </tbody>
        </table>
        
        <h2 style="margin-top: 50px;">Form Settings</h2>
        <p class="form-description">Configure the look of the form in the website.</p>
        <br />
        
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="box_color">Box Color 1</label></th>
                    <td>
                        <input type="color" name="wpdonation_box_color_1" class="basic" value="<?php echo get_option('wpdonation_box_color_1'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="box_color">Box Color 2</label></th>
                    <td>
                        <input type="color" name="wpdonation_box_color_2" class="basic" value="<?php echo get_option('wpdonation_box_color_2'); ?>" />
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 style="margin-top: 50px;">Thank You Message</h2>
        <p class="about-description">Enter the verbiage that will show up in the Thank You Message.</p>
        <br />
        
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="thankyou_heading">Heading</label></th>
                    <td>
                        <input type="text" id="thankyou_heading" name="wpdonation_thankyou_heading" value="<?php echo get_option('wpdonation_thankyou_heading'); ?>" style="width: 500px;" />
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="thankyou_message">Message</label></th>
                    <td>
                        <?php wp_editor( get_option('wpdonation_thankyou_message'), 'wpdonation_thankyou_message', $settings = array() ); ?>
                    </td>
                </tr>
                
            
            </tbody>
        </table>

        <h2 style="margin-top: 50px;">Stripe API Keys</h2>
        <p class="about-description">Login to your Stripe Account, copy the API keys and put it here.</p>
        <br />
        
		<table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="stripe_secret_key">Stripe Secret Key</label></th>
                    <td>
                        <input type="text" id="stripe_secret_key" name="wpdonation_stripe_secret_key" value="<?php echo get_option('wpdonation_stripe_secret_key'); ?>" style="width: 400px;" />
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="stripe_public_key">Stripe Public Key</label></th>
                    <td>
                        <input type="text" id="stripe_public_key" name="wpdonation_stripe_public_key" value="<?php echo get_option('wpdonation_stripe_public_key'); ?>" style="width: 400px;" />
                    </td>
                </tr>
                
            
            </tbody>
        </table>
			
    
		<?php submit_button(); ?>
    </form>
	</div>

</div>

<script>
    
</script>



























