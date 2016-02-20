<div class="wrap">
	<h1>WP-Donation Settings</h1>

	<form method="post" action="options.php" id="post">
	<?php settings_fields('wpdonation_settings'); ?>
	<?php do_settings_sections('wpdonation_settings'); ?>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<div id="post-body-content">
				<div id="titlediv">
					<div id="titlewrap">
						<label class="" id="title-prompt-text" for="title">Enter Organization Name</label>
						<input type="text" name="wpdonation_organization_name" size="30" id="title" spellcheck="true" autocomplete="off" class="post-title-field" value="<?php echo get_option('wpdonation_organization_name'); ?>" />
					</div>
					<div class="inside"></div>
				</div><!-- /titlediv -->
			</div>

			<div id="postbox-container-1" class="postbox-container">
				<div id="submitdiv" class="postbox">
					<h2 class=""><span>Save Changes</span></h2>
					<div id="major-publishing-actions">
						<?php submit_button(); ?>
						<div class="clear"></div>
					</div>
				</div>
			</div>

			<div id="postbox-container-2" class="postbox-container">

				<div id="wpdonation_formsettings" class="postbox">
					<h2 class="hndle"><span>Form Settings</span></h2>
					<div class="inside" style="padding:0;margin:0;">

						<table class="wpdonation-table">
				            <tbody>
				                <tr>
				                    <th scope="row"><label for="box_color">Color 1</label></th>
				                    <td>
				                        <input type="color" name="wpdonation_box_color_1" class="basic" value="<?php echo get_option('wpdonation_box_color_1'); ?>" />
				                    </td>
				                </tr>
				                <tr>
				                    <th scope="row"><label for="box_color">Color 2</label></th>
				                    <td>
				                        <input type="color" name="wpdonation_box_color_2" class="basic" value="<?php echo get_option('wpdonation_box_color_2'); ?>" />
				                    </td>
				                </tr>

				                <?php for($i=1;$i<=7;$i++): ?>
				                    <tr>
				                        <th scope="row">
				                        	<label>Button <?php echo $i; ?></label>
				                        </th>
				                        <td>
											<table class="wpdonation-nested-table">
												<tbody>
													<tr>
														<td>
															<label for="wpdonation_amount_<?php echo $i; ?>">Amount</label>
															<input type="text" name="wpdonation_amount_<?php echo $i; ?>" value="<?php echo get_option('wpdonation_amount_'.$i); ?>" />
														</td>
														<td>
															<label for="wpdonation_amount_label_<?php echo $i; ?>">Label</label>
															<input type="text" name="wpdonation_amount_label_<?php echo $i; ?>" value="<?php echo get_option('wpdonation_amount_label_'.$i); ?>" />
														</td>
													</tr>
												</tbody>
											</table>
										</td>
				                    </tr>
				                <?php endfor; ?>
				            </tbody>
				        </table>

					</div>
				</div>

				<div id="wpdonation_tymsg" class="postbox">
					<h2 class="hndle"><span>Thank You Message</span></h2>
					<div class="inside" style="padding:0;margin:0;">

						<table class="wpdonation-table">
				            <tbody>
				                <tr>
				                    <th scope="row"><label for="thankyou_heading">Heading</label></th>
				                    <td>
				                        <input type="text" id="thankyou_heading" name="wpdonation_thankyou_heading" value="<?php echo get_option('wpdonation_thankyou_heading'); ?>" class="fw" />
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

					</div>
				</div>

				<div id="wpdonation_stripe" class="postbox">
					<h2 class="hndle"><span>Stripe API Keys</span></h2>
					<div class="inside" style="padding:0;margin:0;">

						<table class="wpdonation-table">
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

					</div>
				</div>

			</div><!-- /#postbox-container-2 -->

		</div>
	</div><!-- /#poststuff -->

	</form>

</div>

<script>
	if (jQuery('.post-title-field').val() != '') {
		jQuery('#title-prompt-text').addClass('screen-reader-text');
	}
	jQuery('.post-title-field').on('click', function() {
		jQuery('#title-prompt-text').addClass('screen-reader-text');
	});
</script>
