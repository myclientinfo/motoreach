
<script>
<?php if($_SESSION['l10n']['country_code']!='IE'){ ?>
var validate_array = ['fullname','email', 'phone', 'city', 'zip', 'mileage', 'streetaddress','sell_reason', 'state', 'year', 'colour_id', 'interior_colour_id', 'interior_type_id', 'model_id', 'registration', 'import', 'fuel_type_id', 'transmission_type_id', 'drive_type_id', 'body_id', 'roof_type_id', 'cylinders', 'doors', 'upgrade'];
<?php } else { ?>
var validate_array = ['fullname','email', 'phone', 'city', 'mileage', 'streetaddress','sell_reason', 'year', 'colour_id', 'interior_colour_id', 'interior_type_id', 'model_id', 'import', 'fuel_type_id', 'transmission_type_id', 'drive_type_id', 'body_id', 'roof_type_id', 'cylinders', 'doors', 'upgrade'];
<?php } ?>
var country_code = '<?php echo $_SESSION['l10n']['country_code']?>';
var submitted = false;
jQuery(document).ready(function(){
	
	$('select, input').bind('change blur', function(){
		if($(this).css('backgroundColor')=='transparent'){
			return false;
		}
		if($(this).val()!='' && $(this).attr('id') != 'is_lot' && colorToHex($(this).css('backgroundColor')).toUpperCase() == '#FF7F00'){
			$(this).css('backgroundColor', '#FFFFFF');
		}
	});
	
	$('#newitem').submit(function(e){
		
		if(!submitted) e.preventDefault();
		
		if(validate()){	
		<?php if($_SESSION['l10n']['country_code']!='IE'){ ?>
			return true;
		<?php } else { ?>
			return true;
			if(submitted){
				return true;
			}
			
			$.post("api/add_vehicle.php", $(this).serialize()).done(function(data) {
				$('#ID').val(data);
				$('#customerid').val(data);
				$('#responseSuccessURL').val('http://www.mymotoreach.com/confirm_sale.php?auction_id='+data);
				$('#responseFailURL').val('http://www.mymotoreach.com/confirm_sale.php?auction_id='+data);
				//return false;
				submitted = true;
				$('#newitem').submit();
			});
		<?php } ?>
		} else {
			return false;	
		}
		
		
	});
	
	$('#rego_number').blur(function(){
		return false;
		$.get('/api/cartell.php', {registration: $('#rego_number').val() }, function(result){
			$('#make_id').val(result.make);
			$('#make_id').trigger('change');
			
			setTimeout(function(){
				$("select#model_id option").each(function() {
					this.selected = (this.text == result.model); 
				});
				
			},2000);
			
			$('#model_id').trigger('change');
		});
	});
	
	$('#state').bind('blur change', function(){
		
	});
	
	$('#zip').bind('blur change keypress', function(){
		var first = $('#zip').val().substring(0,1);
		if (first == '0') first = 8; 
		$('#state').val(first);
	});
	
	<?php if(isset($_POST['make_id'])){ ?>
	$('#make_id').val("<?php echo $_POST['make_id'] ?>");
	$('#make_id').trigger('change');
	$('#model_id').val("<?php echo $_POST['model_id'] ?>");
	$('#model_id').trigger('change');
	$('#badge_id').val("<?php echo $_POST['badge_id'] ?>");
	<?php } ?>
	
	<?php if(isset($message)){ ?>
	newAlert('<?php echo $message ?>', 'stop');
	<?php } ?>
	
	
	
	
});
</script>
<style>
#newuser {width: 500px; }
#newuser #dealer_name, #newuser #dealer_number {width: 200px;}
#newitem {position: relative; top: -50px;}
#email_text {
	width: 380px;
	position: relative;
	left: 95px;
	display: inline-block;
	margin-bottom: 10px;
	text-align: center;
}

#newuser label {width: 190px;}

#newuser label#business_name_label, #newuser label#businessaddress_label {
	display: none;
}
#newuser label#dealership_name_label {
	display: inline-block;
}
#type_description_nond {
	display: none;
}

#type_description_nond, #type_description_dealer {
	position: relative;
	left: 223px;
	font-size: 16
}

#miniform_continue {
	left: 320px;
}

#cc_cvv2, #cc_number1, #cc_number2, #cc_number3, #cc_number4 {
	width: 40px;
	margin-right: 6px;
}

</style>
		
<div id="headermain_small">
	<h2>YOUR INFORMATION</h2>
</div>

<!-- B. MAIN -->
<div class="main">

<!-- B.1 MAIN CONTENT -->
<div class="main-content">
  <!-- Content unit - Three columns -->
    <?php //echo Site::drawForm('newitem');
	    if($_SESSION['l10n']['country_code']=='IE'){
			echo Site::drawForm('newitem', 'https://www.ipg-online.com/connect/gateway/processing', 'POST', 'multipart/form-data');
		} else {
			echo Site::drawForm('newitem', '', 'POST', 'multipart/form-data');
		}
	    
    ?>
	<div id="register_box">
		
			<img alt="" src="/images/public_sell_form_top.png">
			<div class="register_box_smallinner">

				<?php 
				if(isset($_SESSION['step']['miniform'])){ 
				$mf = $_SESSION['step']['miniform'];
				?>
				<h3>Continue sale of <?php echo $mf['year'] . ' '. $mf['make_id']. ' '. $mf['model'] . ' '. $mf['badge']  ?></h3>
				<?php } else { ?>

				<div style="padding-left: 20px; padding-right:20px;">

				<?php }
				
				
				if($_SESSION['l10n']['country_code']=='IE'){
			
					$secret = 'WTsat9Eg78';
					$store_id = '13011553712';
					
					echo Site::drawHidden('sale_type_id', 1);
					echo Site::drawHidden('txntype', 'sale');
					echo Site::drawHidden('timezone', 'GMT');
					echo Site::drawHidden('txndatetime', date('Y:m:d-H:i:s'));
					echo Site::drawHidden('hash', sha1(bin2hex($store_id . date('Y:m:d-H:i:s') . '13.01' . '978' . $secret)));
					echo Site::drawHidden('storename', $store_id);
					echo Site::drawHidden('mode', 'payonly');
					
					echo Site::drawHidden('chargetotal', '13.01');
					
					echo Site::drawHidden('currency', '978');
					echo Site::drawHidden('customerid', '');
					echo Site::drawHidden('responseSuccessURL', 'http://www.mymotoreach.com/confirm_sale.php');
					echo Site::drawHidden('responseFailURL', 'http://www.mymotoreach.com/confirm_sale.php');
					
				} 
				
				echo Site::drawHidden('country', $_SESSION['l10n']['country_id']);
				echo Site::drawHidden('ob_hidden', '0');
				echo Site::drawHidden('auction_id', '0');
				echo Site::drawHidden('location_pref', '0');
				echo Site::drawHidden('location_id', '0');
				echo Site::drawHidden('uniqueID', Auction::getUniqueId());
				echo Site::drawHidden('user_type_id', 5);
				echo Site::drawHidden('password', '');
				echo Site::drawHidden('rep_number', '');
				echo Site::drawHidden('account_email', '');
				echo Site::drawHidden('account_phone', '');
				echo Site::drawHidden('dealership_name', '');
				echo Site::drawHidden('dealer_name', '');
				echo Site::drawHidden('dealer_number', '');
				echo Site::drawHidden('opt_in', '0');
				echo Site::drawHidden('dateentered', '');

				echo Site::drawText('fullname', @$_POST['fullname'], 'contact name').BR2;
				echo Site::drawText('email', @$_POST['email'], 'email', false, 'email').BR;
				echo Site::drawText('phone', @$_POST['phone'], 'phone').BR2;
				
				echo Site::drawText('streetaddress', @$_POST['streetaddress'], 'address').BR;
				
				if($_SESSION['l10n']['country_code']!='IE') echo Site::drawText('city', @$_POST['city'], $_SESSION['l10n']['term_suburb']).BR;
				else echo Site::drawSelect('city', Site::getLookupTable('regions', 'id', 'region', 'region', false, false, false, false, 'state_id > 9 AND state_id < 14'), @$_POST['city'],'', 'County').BR;
				
				echo Site::drawSelect('state', Site::getLookupTable('states', 'id', 'state', 'id', true, false, false, false, 'country_id = '.$_SESSION['l10n']['country_id']), @$_POST['state'], '', $_SESSION['l10n']['term_state']).BR;
				
				if($_SESSION['l10n']['country_code'] != 'IE') echo Site::drawText('zip', @$_POST['zip'], 'postcode').BR2;
				else echo Site::drawHidden('zip', '');
				
				//echo Site::drawSelect('sell_reason', array('0'=>'No', '1'=>'Yes'), '', '', 'Replacing vehicle?', 'select').BR2;
				?>
				<input type="checkbox" checked="checked" value="1" name="opt_in" id="opt_in" /> <span style="color: white;">I agree to be sent further information from MotoReach or one of our dealers regarding this sale.</span>
			</div>
		</div>
		<img alt="" src="/images/public_sell_form_bottom.png">
	</div>
	
	<div style="text-align: center; margin-top: 15px; font-size: 11px; margin: 20px; width: 485px; float:right; margin-top:50px;"></div>
		
		<div style="padding-top:20px;" id="register_v_box">
				<div class="register_box_inner">
				<?php 
			$auction_lengths = array(3=>'3 Days', 5=>'5 Days', 7=>'7 Days', 9=>'9 Days', 11=>'11 Days');
			
			$make_array = array_combine(array_keys($GLOBALS['make_models']), array_keys($GLOBALS['make_models']));
			
			echo Site::drawDiv('submit_item_mand_left');
			echo Site::drawHidden('stage', 'submission');
			
			$cf = false;
			echo Site::drawHidden('is_lot', 0);
			echo Site::drawHidden('lot_amount', 0);
			
			echo Site::drawHidden('userID', isset($_POST['userID']) ? $_POST['userID'] : 0);
			
			echo Site::drawHidden('ID', 0);
			echo Site::drawHidden('sale_type_id', 1);
			echo Site::drawHidden('processed', 'no');
			echo Site::drawHidden('formdata', 'submission');
			echo Site::drawHidden('categoryID', 1);
			echo Site::drawHidden('auctionlength', 14);
			
			echo Site::drawText('rego_number', '', 'registration').BR2;
			
			echo Site::drawText('year', @$_POST['year'], 'Year').BR;
			
			echo Site::drawSelect('make_id', $make_array, @$_POST['make_id'], '', 'make').BR;
			echo Site::drawSelect('model_id', array(''=>'select a make'), @$_POST['model_id'], '', 'model').BR;
			echo Site::drawSelect('badge_id', array('select a model'), @$_POST['badge_id'], '', 'badge').BR;
			echo Site::drawSelect('series_id', array('select a model'), @$_POST['series_id'], '', 'series').BR2;
			
			echo Site::drawText('mileage', @$_POST['mileage'], 'mileage').BR2;
			
			echo Site::drawHidden('startprice', @$_POST['startprice']);
			echo Site::drawHidden('buyoutprice', @$_POST['buyoutprice']);
			echo Site::drawHidden('spend', @$_POST['spend'], 'to spend');
			echo Site::drawHidden('max_requests', 10);
			
			$rego_array[] = 'No Rego';
			for($i=0;$i<=12;$i++){
				$rego_time = mktime (12, 0, 0, date("n")+$i, 15, date("Y"));
				$rego_array[date('m-Y', $rego_time)] = date('m-Y', $rego_time);
			}
			
			if($_SESSION['l10n']['country_code']!='IE') echo Site::drawSelect('registration', $rego_array, @$_POST['registration'], '', 'rego end', $cf, array('class'=>'sel_var')).BR2;
			
			echo Site::drawDiv();
			
			echo Site::drawDiv('submit_item_mand_right');
			echo Site::drawSelect('import', array('No', 'Yes'),'', '', 'personal import', $cf).BR;
			echo Site::drawSelect('colour_id', Site::getLookupTable('type_colours', 'id', 'colour', 'colour'), @$_POST['colour_id'], 2, 'colour', $cf, array('class'=>'sel_var')).BR;
			echo Site::drawSelect('interior_type_id', Site::getLookupTable('type_interiors', 'id', 'interior', 'interior'), @$_POST['interior_type_id'], 3, 'interior', $cf, array('class'=>'sel_var')).BR;
			echo Site::drawSelect('interior_colour_id', Site::getLookupTable('type_colours', 'id', 'colour', 'colour'), @$_POST['interior_colour_id'], 8, 'interior colour', $cf, array('class'=>'sel_var')).BR2;
			
			echo Site::drawSelect('fuel_type_id', Site::getLookupTable('type_fuel', 'id', 'fuel', 'fuel'), @$_POST['type_fuel'], 1, 'fuel type', true).BR;
			echo Site::drawSelect('transmission_id', Site::getLookupTable('type_transmission', 'id', 'transmission', 'transmission'), @$_POST['transmission_id'], 1, 'transmission', true).BR;
			echo Site::drawSelect('drive_type_id', Site::getLookupTable('type_drives', 'id', 'drive', 'drive'), @$_POST['drive_type_id'], 2, 'drive type', true).BR;
			echo Site::drawSelect('body_id', Site::getLookupTable('type_body', 'id', 'body', 'body'), @$_POST['body_id'], 1, 'body type', true).BR;
			echo Site::drawSelect('roof_type_id', Site::getLookupTable('type_roofs', 'id', 'roof', 'roof'), @$_POST['roof_type_id'], 1, 'roof type', true).BR2;
			echo Site::drawSelect('cylinders', array(''=>'select cylinders', 3=>3, 4=>4, 5=>5,6=>6,8=>8,10=>10,12=>12,16=>16), @$_POST['cylinders'], 6, 'cylinders').BR;
			echo Site::drawSelect('doors', array(''=>'select doors', 2=>2,3=>3,4=>4,5=>5), @$_POST['doors'], 4, 'doors').BR;
			
			echo Site::drawDiv(false, true);
			echo Site::drawDiv();
			echo Site::drawDiv('submit_item_mand_left');
			echo Site::drawTextArea('description', @$_POST['description'], 'comments', array('placeholder'=>'optional')).BR2;
			
			echo Site::drawDiv();
			
			
			
			
			echo Site::drawDiv(false, true);
			echo BR2;
			
			?>
			
			<!--
			
			<h2>PAYMENT OPTIONS</h2>
			
			<p>Payment for MyMotoreach services is available using the following methods. Your credit card information is not stored by MotoReach, and is not accessible to MotoReach at any time. All transactions are governed by our <a>privacy policy</a>, and subject to our <a>terms and conditions</a>.
			
			<div>
			<div style="width: 450px; float: left;">
			<h3>CHARGES</h3>
			
			<p style="margin-bottom: 10px;">Payment of <span style="font-weight: bold;">ONLY &euro;19.95</span> to be paid by credit card. </p>
			
			
			<h3>CARD INFORMATION</h3>
			
			<label>Card Type</label>
			
			<input type="radio" name="cc_type" value="visa">
			
			<img src="/images/visa-3.png" style="width: 40px; position:relative; top: 10px;">
			
			<input type="radio" name="cc_type" value="visa">
			
			<img src="/images/mastercard-2.png" style="width: 40px;position:relative; top: 10px;">
			
			<br>
			
			
			<?php
			echo Site::drawText('cc_number1', '', 'Card Number');
			echo Site::drawText('cc_number2', '');
			echo Site::drawText('cc_number3', '');
			echo Site::drawText('cc_number4', '');
			
			echo Site::drawSelect('cc_month', Site::getMonthsArray(), '', '', 'Expiry');
			echo Site::drawSelect('cc_month', array(2013=>2013, 2014=>2014, 2015=>2015, 2016=>2016, 2017=>2017), '', '').BR;
			echo Site::drawText('cc_cvv2', '', 'CVV Number').BR2;
			?>
			</div>
			<div style="width: 350px; float: left;">
			<h3>BILLING INFORMATION</h3>
			<?php
			echo site::drawButton('cc_button', 'copy from above').BR2;
			
			echo Site::drawText('cc_name', '', 'Name on Card').BR;
			echo Site::drawText('cc_address', '', 'Address').BR;
			
			echo Site::drawText('cc_province', '', 'Province');
			echo Site::drawText('cc_county', '', 'County');
			?>
				</div>
				</div>
-->
			<div style="margin-left:455px;position: relative; top: -20px;">
			<?php
			//echo Site::drawText('test_question', '', 'What is 5 + 2?').BR;
			?>
			</div>
			<?php
			echo Site::drawDiv(false, true);
			
			?>
			
			
			</div>
		</div>
				<?php 
		
		echo Site::drawDiv(false, true);
		
			
			
		echo Site::drawSubmitImage('mainform_continue', '/images/public_button_continue.png');
		echo Site::drawForm(); 
		?>
		
		<div style="margin: 20px;" id="information_box">
		<h3>IMPORTANT INFORMATION</h3>
		<a style="font-size: 11px;" href="/terms_and_conditions.php">Terms and Conditions</a> |
		<a style="font-size: 11px;" href="/privacy_disclaimer.php">Privacy Disclaimer</a>
		
		</div>
</div>

</div>