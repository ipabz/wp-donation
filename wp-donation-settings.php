<div class="wrap">
	<h2>WP Donation Settings</h2>
    

    <form method="post" action="options.php">
    	<?php settings_fields('wpdonation_settings'); ?>
		<?php do_settings_sections('wpdonation_settings'); ?> 

			
    
		<?php submit_button(); ?>
    </form>


</div>