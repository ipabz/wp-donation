<div class="wrap">
	<h2>WP Donation Settings</h2>
    
	<div id="welcome-panel" class="welcome-panel">
    <form method="post" action="options.php" class="welcome-panel-content">
    	<?php settings_fields('wpdonation_settings'); ?>
		<?php do_settings_sections('wpdonation_settings'); ?> 
		
        <h2>Stripe API Keys</h2>
        <p class="about-description">Login to your Stripe Account, copy the API keys and put it here.</p>
        <br />
        
		<table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="stripe_public_key">Stripe Public Key</label></th>
                    <td>
                        <input type="text" id="stripe_public_key" name="wpdonation_stripe_public_key" value="<?php echo get_option('wpdonation_stripe_public_key'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="stripe_secret_key">Stripe Secret Key</label></th>
                    <td>
                        <input type="text" id="stripe_secret_key" name="wpdonation_stripe_secret_key" value="<?php echo get_option('wpdonation_stripe_secret_key'); ?>" />
                    </td>
                </tr>
            
            </tbody>
        </table>
			
    
		<?php submit_button(); ?>
    </form>
	</div>

</div>





























