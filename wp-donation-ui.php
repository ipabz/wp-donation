<form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="POST" id="payment-form" name="payment-form" onSubmit="return validate_cc_exp();">
    <input type="hidden" name="organization_id" value="1" />
    <section id="donatenow">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row donationfund">
                </div>
                <div class="donationfields clearfix">

                    <div class="row donationopt">
                        <div class="col-xs-6">
                            <label for="donationopt_onetime" class="selected">
                                <input class="radiobtn" checked="" type="radio" name="recurring_period" value="onetime" id="donationopt_onetime" autocomplete="off" />
                                <span>One Time</span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label for="donationopt_monthly">
                                <input class="radiobtn" type="radio" name="recurring_period" value="monthly" id="donationopt_monthly" autocomplete="off" />
                                <span>Monthly</span>
                            </label>
                        </div>
                    </div>

                    <div class="row donationpad">
                        <div class="col-xs-3">
                            <label for="donationamount_20">
                                <input class="radiobtn" type="radio" name="amount" value="20" id="donationamount_20" autocomplete="off" />
                                <span>$20</span>
                            </label>
                        </div>
                        <div class="col-xs-3">
                            <label for="donationamount_50">
                                <input class="radiobtn" type="radio" name="amount" value="50" id="donationamount_50" autocomplete="off" />
                                <span>$50</span>
                            </label>
                        </div>
                        <div class="col-xs-3">
                            <label for="donationamount_100">
                                <input class="radiobtn" type="radio" name="amount" value="100" id="donationamount_100" autocomplete="off" />
                                <span>$100</span>
                            </label>
                        </div>
                        <div class="col-xs-3">
                            <label for="donationamount_500">
                                <input class="radiobtn" type="radio" name="amount" value="500" id="donationamount_500" autocomplete="off" />
                                <span>$500</span>
                            </label>
                        </div>


                        <div class="col-xs-3">
                            <label for="donationamount_1000">
                                <input class="radiobtn" type="radio" name="amount" value="1000" id="donationamount_1000" autocomplete="off" />
                                <span>$1k</span>
                            </label>
                        </div>
                        <div class="col-xs-3">
                            <label for="donationamount_5000">
                                <input class="radiobtn" type="radio" name="amount" value="5000" id="donationamount_5000" autocomplete="off" />
                                <span>$5k</span>
                            </label>
                        </div>
                        <div class="col-xs-3">
                            <label for="donationamount_10000">
                                <input class="radiobtn" type="radio" name="amount" value="10000" id="donationamount_10000" autocomplete="off" />
                                <span>$10k</span>
                            </label>
                        </div>
                        <div class="col-xs-3">
                            <label for="donationamount_other">
                                <input class="radiobtn" type="radio" name="amount" value="other" id="donationamount_other" autocomplete="off" />
                                <span>Other</span>
                            </label>
                        </div>

                        <div id="donationamount_otherinput" class="col-xs-12 hidden">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" for="coverccfee">$</div>
                                    <input type="text" class="form-control numeric" name="otheramount" id="otheramount" placeholder="" />
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row donationaddinfo">
                        <div class="col-xs-12">
                            <div class="checkbox">
                                <label for="addinfo">
                                    <input type="checkbox" name="donationaddinfo" id="addinfo" /> Add additional information
                                </label>
                            </div>
                            <div id="addinfotext" class="form-group hidden">
                                <textarea class="form-control" name="note" rows="4"></textarea>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="donationaddinfo_covercc" id="covercc" /> I will cover the credit card processing fee
                                </label>
                            </div>
                            <div id="covercctext" class="hidden">

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" for="coverccfee">Fee Amount</div>
                                        <input type="text" class="form-control" id="coverccfee" placeholder="Amount" value="0.00" disabled />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" for="covercctotal">Total Donation</div>
                                        <input type="text" class="form-control" id="covercctotal" placeholder="Amount" value="0.00" disabled />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="row donationsubmit">
                    <div class="col-xs-12">
                        <input type="button" name="name" class="btn btn-lg btn-primary btn-donate" value="Donate" data-toggle="modal" data-target=""/>
                    </div>
                </div>
            </div>
        </div>
    </section>

<div class="modal fade" id="donor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Donate to Midamerica Prison Ministry</h4>
			</div>

			<div class="modal-body">

				<div class="form-horizontal">

					<span class="payment-errors"></span>

					<div class="form-group">
						<label for="donor_email" class="col-sm-4 control-label">Email</label>
						<div class="col-sm-8">
							<input type="text" name="wpdonation_donor_email" required="" class="form-control" id="donor_email" placeholder="Email" >
						</div>
					</div>

					<div class="form-group">
						<label for="donor_name" class="col-sm-4 control-label">Name</label>
						<div class="col-sm-8">
							<input type="text" name="wpdonation_donor_name" required="" class="form-control" id="donor_name" placeholder="Full Name">
						</div>
					</div>

					<div class="form-group">
						<label for="donor_address" class="col-sm-4 control-label">Address</label>
						<div class="col-sm-8">
							<input type="text" name="wpdonation_donor_address" required="" class="form-control" id="donor_address" placeholder="Address">
						</div>
					</div>

					<div class="form-group">
						<label for="donor_city" class="col-sm-4 control-label">City</label>
						<div class="col-sm-8">
							<input type="text" name="wpdonation_donor_city" required="" class="form-control" id="donor_city" placeholder="City">
						</div>
					</div>

					<div class="form-group">
                        <label for="donor_zipcode" class="col-sm-4 control-label">Zip Code</label>
                        <div class="col-sm-8">
                            <input type="text" name="wpdonation_donor_zipcode" required="" class="form-control numeric" id="donor_zipcode" placeholder="Zip Code">
                        </div>
                    </div>

                    <div class="form-group">
						<label for="donor_cardnum" class="col-sm-4 control-label">Card Number</label>
						<div class="col-sm-8">
							<input type="text" data-stripe="number" name="card_number" required="" class="form-control numeric" id="donor_cardnum" placeholder="Card Number">
						</div>
					</div>

					<div class="form-group">
						<label for="donor_cvc" class="col-sm-4 control-label">CVC</label>
						<div class="col-sm-2">
							<input type="text" class="form-control numeric" id="donor_cvc" size="4" data-stripe="cvc" name="cvv" maxlength="4">
						</div>
					</div>

					<div class="form-group form-inline">
						<label for="donor_cvc" class="col-sm-4 control-label">Expiration (MM/YYYY)</label>
						<div class="col-sm-8">
							<input type="text" size="2" class="form-control numeric" data-stripe="exp-month" name="exp_month" id="exp_month" maxlength="2" required="" />
							/
							<input type="text" size="4" class="form-control numeric" data-stripe="exp-year" name="exp_year" id="exp_year" maxlength="4" required="" />
						</div>
					</div>

				</div>

			</div>

			<div class="modal-footer">
			<button type="submit" class="btn btn-primary donate-button">Donate</button>
			</div>

		</div>
	</div>

</div>
</form>
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
		if(jQuery('input:radio[name=amount]:checked').length > 0) {
			jQuery(this).attr('data-target', '#donor');
		}
		else {
			jQuery(this).attr('data-target','');
		}

		var val = jQuery('input:radio[name=amount]:checked').val();

		if (val === 'other') {

			if(jQuery('#otheramount').val() <= 0 || jQuery('#otheramount').val() == '') {
				jQuery(this).attr('data-target','');
				jQuery('#otheramount').addClass('redifyHim'); // ^______________^
			}
			else {
				jQuery(this).attr('data-target', '#donor');
			}
		}

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

		var val = jQuery('input:radio[name=amount]:checked').val();

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
		var val = jQuery('input:radio[name=amount]:checked').val();

		if (val === 'other') {
			val = jQuery('#otheramount').val();
		}

		if (val !== '' && typeof val !== 'undefined') {

			var feeAmount = (Number(val) * 0.03) + 0.3;
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