<style>
    .donationpad label { background: <?php echo get_option('wpdonation_box_color_1'); ?> !important; }
    .donationpad label.selected{ background: <?php echo get_option('wpdonation_box_color_2'); ?> !important; }
    .btn.btn-primary{ background: <?php echo get_option('wpdonation_box_color_2'); ?> !important; }
    .btn.btn-primary:hover{ background: <?php echo get_option('wpdonation_box_color_1'); ?> !important; }
</style>
<div id="wp-donation-wrap">

    <header class="entry-header text-center">
        <h2 class="entry-title">Donate to <?php echo get_option('wpdonation_organization_name'); ?></h2>
    </header>

    <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="POST" id="payment-form" name="payment-form" onSubmit="return validate_cc_exp();">
        <input type="hidden" name="organization_id" value="1" />

        <section id="donatenow">

            <div class="wpd-row donationopt">
                <div class="donationopt_btn">
                    <label for="donationopt_onetime" class="selected">
                        <input class="radiobtn" checked="" type="radio" name="wpdonation_donor_recur" value="onetime" id="donationopt_onetime" autocomplete="off" />
                        <span>One Time</span>
                    </label>
                </div>
                <div class="donationopt_btn">
                    <label for="donationopt_monthly">
                        <input class="radiobtn" type="radio" name="wpdonation_donor_recur" value="monthly" id="donationopt_monthly" autocomplete="off" />
                        <span>Monthly</span>
                    </label>
                </div>
            </div><!-- /donationopt -->

            <div class="wpd-row donationpad">
                <?php for($i=1;$i<=7;$i++): ?>
                <div class="donationpad_btn">
                    <label for="donationamount_1">
                        <input class="radiobtn" type="radio" name="wpdonation_donor_amount" value="<?php echo get_option('wpdonation_amount_'.$i); ?>" id="donationamount_<?php echo $i ?>" autocomplete="off" />
                        <span><?php if(get_option('wpdonation_amount_label_'.$i) == '') {echo '&nbsp;';} else {echo get_option('wpdonation_amount_label_'.$i);} ?></span>
                    </label>
                </div>
                <?php endfor; ?>
                <div class="donationpad_btn">
                    <label for="donationamount_other">
                        <input class="radiobtn" type="radio" name="wpdonation_donor_amount" value="other" id="donationamount_other" autocomplete="off" />
                        <span>Other</span>
                    </label>
                </div>
                <div id="donationamount_otherinput" class="donationpad_otheramount hidden clearfix">
                    <div class="inline-form clearfix">
                        <span class="prepend">$</span>
                        <input type="text" class="form-control numeric" name="wpdonation_otheramount" id="otheramount" placeholder="" />
                    </div>
                </div>
            </div><!-- /donationpad -->

            <div class="wpd-row donationaddinfo">
                <div class="wpd-m-12">

                    <div class="checkbox">
                        <label for="addinfo">
                            <input type="checkbox" name="donationaddinfo" id="addinfo" /> Add additional information
                        </label>
                    </div>
                    <div id="addinfotext" class="hidden">
                        <textarea name="wpdonation_donor_note" rows="4"></textarea>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="donationaddinfo_covercc" id="covercc" value="1" /> I will cover the credit card processing fee
                        </label>
                    </div>
                    <div id="covercctext" class="hidden">
                        <div class="inline-form clearfix">
                            <span class="prepend">Fee Amount</span>
                            <input type="text" class="form-control" name="wpdonation_donor_fee" id="coverccfee" placeholder="Amount" value="0.00" readonly />
                        </div>
                        <div class="inline-form clearfix">
                            <span class="prepend">Total Donation</span>
                            <input type="text" class="form-control" id="covercctotal" placeholder="Amount" value="0.00" disabled />
                        </div>
                    </div>

                </div>
            </div><!-- /donationaddinfo -->

            <div class="wpd-row donationsubmit">
                <div class="wpd-m-12">
                    <input type="button" name="name" class="btn btn-lg btn-primary btn-donate" value="Donate" data-toggle="modal" data-target=""/>
                </div>
            </div>

        </section>

        <div class="modal fade" id="donor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        	<div class="modal-dialog" role="document">
        		<div class="modal-content">

        			<div class="modal-header clearfix">
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h4 class="modal-title" id="myModalLabel">Donate to <?php echo get_option('wpdonation_organization_name'); ?></h4>
        			</div>

        			<div class="modal-body">

                        <div class="donor_form">
        					<p class="payment-errors"></p>

        					<p>
        						<label for="donor_email" class="col-sm-4 control-label">Email</label>
        						<input type="text" name="wpdonation_donor_email" required="" class="form-control" id="donor_email" placeholder="Email" >
        					</p>

        					<p>
        						<label for="donor_name" class="col-sm-4 control-label">Name</label>
        						<input type="text" name="wpdonation_donor_name" required="" class="form-control" id="donor_name" placeholder="Full Name">
        					</p>

        					<p>
        						<label for="donor_address" class="col-sm-4 control-label">Address</label>
        						<input type="text" name="wpdonation_donor_address" required="" class="form-control" id="donor_address" placeholder="Address">
        					</p>

        					<p>
        						<label for="donor_city" class="col-sm-4 control-label">City</label>
        						<input type="text" name="wpdonation_donor_city" required="" class="form-control" id="donor_city" placeholder="City">
        					</p>

        					<p>
                                <label for="donor_zipcode" class="col-sm-4 control-label">Zip Code</label>
                                <input type="text" name="wpdonation_donor_zipcode" required="" class="form-control numeric" id="donor_zipcode" placeholder="Zip Code">
                            </p>

                            <p>
        						<label for="donor_cardnum" class="col-sm-4 control-label">Card Number</label>
        						<input type="text" data-stripe="number" name="wpdonation_card_number" required="" class="form-control numeric" id="donor_cardnum" placeholder="Card Number">
        					</p>

        					<p>
        						<label for="donor_cvc" class="col-sm-4 control-label">CVC</label>
        						<input type="text" class="form-control numeric" id="donor_cvc" size="4" data-stripe="cvc" name="cvv" maxlength="4">
        					</p>

        					<p>
        						<label for="donor_cvc" class="col-sm-4 control-label">Expiration (MM/YYYY)</label>
    							<input type="text" size="2" class="form-control numeric" data-stripe="exp-month" name="wpdonation_exp_month" id="exp_month" maxlength="2" required="" style="width:60px;" />
    							/
    							<input type="text" size="4" class="form-control numeric" data-stripe="exp-year" name="wpdonation_exp_year" id="exp_year" maxlength="4" required="" style="width:80px;" />
        					</p>

        				</div>

        			</div>

        			<div class="modal-footer">
        			    <button type="submit" class="btn btn-primary donate-button">Donate</button>
        			</div>

        		</div>
        	</div>
        </div><!-- /modal -->

    </form>

</div><!-- / wp-donation-wrap -->
<script>
function changedFund() {
	if (jQuery('#fundselect').val() != 'default') {
		jQuery('.donationfields').removeClass('hidden');
	}
	else {
		jQuery('.donationfields').addClass('hidden');
	}
}
jQuery(function() {

	jQuery('.numeric').numeric();

	jQuery(document).find('.temp').css({
		width: '100px',
		display: 'inline-block'
	});

	jQuery('.btn-donate').on('click', function(e) {
		if(jQuery('input:radio[name=wpdonation_donor_amount]:checked').length > 0) {
			jQuery(this).attr('data-target', '#donor');
		}
		else {
			jQuery(this).attr('data-target','');
		}

		var val = jQuery('input:radio[name=wpdonation_donor_amount]:checked').val();

		if (val === 'other') {

			if(jQuery('#otheramount').val() <= 0 || jQuery('#otheramount').val() == '') {
				jQuery(this).attr('data-target','');
				jQuery('#otheramount').addClass('redifyHim'); // ^______________^
			}
			else {
				jQuery(this).attr('data-target', '#donor');
			}
		}
        jQuery('#donor').addClass('show');
        jQuery('body').addClass('modal-show');
	});

    jQuery('#donor .close').on('click', function() {
        jQuery('#donor').removeClass('show');
        jQuery('body').removeClass('modal-show');
    });

	jQuery('.btn-send').on('click', function(e) {
		e.preventDefault();
		var hasError = false;

        jQuery('#payment-form [required]').each(function() {

            if (jQuery.trim(jQuery(this).val()) === '') {
                jQuery(this).addClass('redifyHim');
                hasError = true;
            } else {
                jQuery(this).removeClass('redifyHim');
            }

        });

        if (hasError) {
            return false;
        }
        else {
        	jQuery('form').submit();
        }
	});

	jQuery('.donationpad label').on('click', function(e) {
		e.preventDefault();
		jQuery('.donationpad label').removeClass('selected').find('.radiobtn').prop('checked', false);
		if (!jQuery(this).hasClass('selected')) {
			jQuery(this).addClass('selected').find('.radiobtn').prop('checked', true);
		}

		if (jQuery('#donationamount_other').parent().hasClass('selected')) {
			jQuery('#donationamount_otherinput').removeClass('hidden').find('input').focus();
		}
		else {
			jQuery('#donationamount_otherinput').addClass('hidden');
		}
		calculate();
	});

	jQuery('.donationopt label').on('click', function(e) {
		e.preventDefault();
		jQuery('.donationopt label').removeClass('selected').find('.radiobtn').prop('checked', false);
		if (!jQuery(this).hasClass('selected')) {
			jQuery(this).addClass('selected').find('.radiobtn').prop('checked', true);
		}
	});

	jQuery('#addinfo').on('click', function() {
		if (jQuery(this).prop('checked')) {
			jQuery('#addinfotext').removeClass('hidden').find('textarea').focus();
		}
		else {
			jQuery('#addinfotext').addClass('hidden').find('textarea').click();
		}
	});

	jQuery('#covercc').on('click', function() {

		var val = jQuery('input:radio[name=wpdonation_donor_amount]:checked').val();

		if (val === 'other') {
			val = jQuery('#otheramount').val();
		}

		if (val !== '' && typeof val !== 'undefined') {

			if (jQuery(this).prop('checked')) {
				jQuery('#covercctext').removeClass('hidden');
			}
			else {
				jQuery('#covercctext').addClass('hidden');
			}

			calculate();

		} else {
			alert("Please select an amount first!"); // this alert can be change later on
			return false;
		}
	});

	jQuery('#otheramount').keyup(function() {
		calculate();
	});

	function calculate()
	{
		var val = jQuery('input:radio[name=wpdonation_donor_amount]:checked').val();

		if (val === 'other') {
			val = jQuery('#otheramount').val();
		}

		if (val !== '' && typeof val !== 'undefined') {

			var feeAmount = (Number(val) * 0.029) + 0.3;
			var totalAmount = Number(val) + feeAmount;

			jQuery('#coverccfee').val(feeAmount.toFixed(2));
			jQuery('#covercctotal').val(totalAmount.toFixed(2));

			var am = totalAmount;

			if (jQuery('#covercc').prop('checked')) {
				am = am.toFixed(2);
			}

			if (am >= 1000) {
				am = (am / 1000) + 'K';
			}

			jQuery('.donate-button').html('Donate $' + (am));

		}
	}

});

function validate_cc_exp() {
    value = parseInt(jQuery('#exp_month').val(), 10);

    var m_result = true;
    var y_result = true;

    var year = jQuery('#exp_year').val(),
        currentMonth = new Date().getMonth() + 1,
        currentYear  = new Date().getFullYear();

    if (value < 1 || value > 12) {
        m_result = false;
    }

    if(m_result){
        year = parseInt(year, 10);
        if (year > currentYear || (year == currentYear && value >= currentMonth)) {
            m_result = true;
        } else {
            m_result = false;
        }
    }

    value = parseInt(jQuery('#exp_year').val(), 10);

    var month = jQuery('#exp_month').val(),
        currentMonth = new Date().getMonth() + 1,
        currentYear  = new Date().getFullYear();
    if (value < currentYear || value > currentYear + 10) {
        y_result = false;
    }

    if(y_result){
        month = parseInt(month, 10);
        if (value > currentYear || (value == currentYear && month >= currentMonth)) {
            y_result = true;
        } else {
            y_result = false;
        }
    }

    if(m_result==true && y_result==true){
        jQuery('#exp_month').removeClass('redifyHim');
        jQuery('#exp_year').removeClass('redifyHim');
        return true;
    }else{
        jQuery('#exp_month').addClass('redifyHim');
        jQuery('#exp_year').addClass('redifyHim');
        return false;
    }
}
</script>
