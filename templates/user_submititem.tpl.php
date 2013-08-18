<?php 
$ut = User::getSD('user_type_id');
?>
<script type="text/javascript">
<?php if($_SESSION['l10n']['country_code']!='IE'){ ?>
var validate_array = ['year', 'comp_month', 'comp_year', 'mileage', 'colour_id', 'interior_colour_id', 'interior_type_id', 'model_id', 'registration', 'import', 'fuel_type_id', 'transmission_type_id', 'drive_type_id', 'body_id', 'roof_type_id', 'cylinders', 'doors', 'upgrade', 'build_month'];
<?php } else { ?>
var validate_array = ['startprice', 'year', 'mileage', 'cylinders', 'doors', 'upgrade'];
<?php } ?>
block = true;

var allow_submit = false;
var saved = false;

jQuery(document).ready(function(){
	
	$('#newitem').submit(function(e){
		
		if(!is_approved){
			newAlert('Your account is not yet approved. You can not yet place a vehicle.', 'stop');
			return false;
		} else {
		
			if(validate()){
			
			<?php if($_SESSION['l10n']['country_code']!='IE'){ ?>
				return true;
			<?php } else { ?>
				
				//return false;
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
				
			<?php } ?>	
			
			}
		}
		
	});
	
	$('select, input').bind('change blur', function(){
		if($(this).css('backgroundColor')=='transparent'){
			return false;
		}
		
		
		if($(this).val()!='' && $(this).attr('id') != 'is_lot' && colorToHex($(this).css('backgroundColor')).toUpperCase() == '#FF7F00'){
			$(this).css('backgroundColor', '#FFFFFF');
		}
	});
	
	
	
	<?php if(User::getSimpleUser() == 13){ ?>
	$('#make_fake').bind('click',function(){
		$('#year, #comp_year').val('2008').css('color', 'black');
		$('#build_month, #comp_month').val('6');
		$('#make_id').val('Demo');
		$('#make_id').trigger('change');
		$('#mileage').val('140,000');
		$('#spend').val('140,000');
		$('#description').val('This is a test vehicle created by MotoReach staff for maintenance purposes. Please disregard this vehicle.').css('color', 'black');
	});
	<?php } ?>
	<?php foreach($check_fields as $c){ ?>
	$('#<?php echo $c ?>').css('backgroundColor', '#FF7F00');
	<?php } ?>
	
	<?php if($_SESSION['l10n']['country_code']=='IE'){ ?>
	$('#mileage_miles').blur(update_kms);
	$('#mileage').blur(update_miles);
	$('#mileage').trigger('blur');
	
	$('#rego_number').blur(function(){
		$.get('/api/cartell.php', {registration: $('#rego_number').val() }, function(result){
			$('#make_id').val(result.make.toUpperCase());
			$('#make_id').trigger('change');
			
			setTimeout(function(){
				$("select#model_id option").each(function() {
					this.selected = (this.text.toUpperCase() == result.model); 
				});
				
			},2000);
			
			$("select#colour_id option").each(function() {
				this.selected = (this.text == result.colour); 
			});
			
			
			$("select#fuel_type_id option").each(function() {
				this.selected = (this.text == result.fuel); 
			});
			
			$("select#body_id option").each(function() {
				this.selected = (this.text == result.body); 
			});
			
			$("select#transmission_type_id option").each(function() {
				
				if(this.text == 'Automatic' && result.transmission == 'A'){
					this.selected = true;
				}
				
				if(this.text == 'Manual' && result.transmission == 'M'){
					this.selected = true;
				}
				
				
			});
			
			
			$('#doors').val(result.doors);
			
			if(result.reg.substr(0,2) > 50){
				set_year = '19'+result.reg.substr(0,2);
			} else {
				set_year = '20'+result.reg.substr(0,2);
			}

			$('#year').val(set_year);
			
			$('#nct_year').val(result.NCT_expiry_date.substr(0, 4));
			
			
			var nct_month = result.NCT_expiry_date.substr(5, 2);
			var str_month = '';
			
			if(nct_month == '01'){
				str_month = 'Jan';
			} else if(nct_month == '02'){
				str_month = 'Feb';
			} else if(nct_month == '03'){
				str_month = 'Mar';
			} else if(nct_month == '04'){
				str_month = 'Apr';
			} else if(nct_month == '05'){
				str_month = 'May';
			} else if(nct_month == '06'){
				str_month = 'Jun';
			} else if(nct_month == '07'){
				str_month = 'Jul';
			} else if(nct_month == '08'){
				str_month = 'Aug';
			} else if(nct_month == '09'){
				str_month = 'Sep';
			} else if(nct_month == '10'){
				str_month = 'Oct';
			} else if(nct_month == '11'){
				str_month = 'Nov';
			} else if(nct_month == '12'){
				str_month = 'Dec';
			} 
			
			$('#nct_month').val(str_month);
			
		})
	});
	<?php } ?>
	
	$('#is_lot').click(function(){
		
		if($(this).attr('checked')==false){ 
			$('#lot_amount_label, #lot_amount').hide();
			$('#lot_amount_label').css('display', 'none !important');
			$('.sel_var').val('');
			
			$('.sel_var').each(function(i,t){				
				$('option.sel_var_opt', $(this)).text('select');
			});
			
		} else {
			$('#lot_amount_label, #lot_amount').show();
			$('#lot_amount_label').css('display', 'inline-block !important');
			$('.sel_var option.var_sel_opt').attr('true', true);
			$('.sel_var').val('111');
			
			$('.sel_var').each(function(i,t){		
				$('option.sel_var_opt', $(this)).text('various');
			});
			
		}
	});
	
	
	//$('#is_lot').trigger('click');
	
});

</script>
<style>
#submit_button {
	margin-right: 62px;
}

#lot_amount_label {
	width: 24px !important;
	text-align: center;
	display: none !important;
	text-transform: lowercase;
}

#lot_amount {
	width: 40px;
	display: none;
}



</style>
<div id="inner_content_blue">

	<h2>List a vehicle 
	
	<?php 
	if($_SESSION['l10n']['country_code']=='IE') echo 'to sell';
	else echo 'for wholesale';?></h2>

	<div class="form_left">
		<?php if(User::getSimpleUser() == 13){ ?>
		<div id="make_fake" style="border: 1px solid #CCCCCC; background-color: #EBEBEB; padding: 5px; width: 160px; text-align: center; margin-bottom: 5px; display: block; cursor: pointer;">Create Test</div>
		<?php } ?>
		
		<p>All fields are required except for <strong>own at</strong> and <strong>comment</strong> fields. We recommend that anything unusual or noteworthy about the vehicle be listed in the <strong>comments</strong>.</p>
		
		<?php if($ut == 1){?>
		<p>If you cannot negotiate a deal you can extend the listing and you will receive additional enquiries up to double your original request at no extra cost.</p>
		<?php } else if($ut == 4) { ?>
		<p>If you list a vehicle lot you can list many of its details as "various". Mandatory fields such as <strong>spend</strong> and <strong>mileage</strong> can be filled in with the word "various".</p>
		<?php } ?>
		
	</div>
	
	<div style="float: right; width: 710px;">
			<?php 
			$auction_lengths = array(3=>'3 Days', 5=>'5 Days', 7=>'7 Days', 9=>'9 Days', 11=>'11 Days');
			
			$make_array = array_combine(array_keys($GLOBALS['make_models']), array_keys($GLOBALS['make_models']));
			
			echo Site::drawForm('newitem', '', 'POST', 'multipart/form-data');
			
			echo Site::drawDiv('submit_item_mand_left');
			echo Site::drawHidden('stage', 'submission');
			
			if($ut == 4){ 
				$cf = 'various';
				echo Site::drawCheckbox('is_lot', 1, 0, 'Lot Sale') . Site::drawText('lot_amount', '10', ' of ').BR;
			} else {
				$cf = false;
				echo Site::drawHidden('is_lot', 0);
				echo Site::drawHidden('lot_amount', 0);
			}
			
			echo Site::drawHidden('userID', isset($_SERVER['REDIRECT_URL']) && $_SERVER['REDIRECT_URL'] == '/vehicle.php' ? $_SESSION['userID'] : $_SESSION['auction']->user->ID);
			
			echo Site::drawHidden('ID', 0);
			echo Site::drawHidden('sale_type_id', 1);
			echo Site::drawHidden('processed', 'no');
			echo Site::drawHidden('formdata', 'submission');
			echo Site::drawHidden('categoryID', 1);
			echo Site::drawHidden('uniqueID', Auction::getUniqueId());
			
			if($_SESSION['l10n']['country_code']!='IE'){
				echo Site::drawSelect('build_month', Site::getShortMonthsArray(), '', 'Month', 'build date', $cf, array('class'=>'sel_var'));
				echo Site::drawText('year', (isset($_POST['year'])?@$_POST['year']:'')).BR;
				echo Site::drawSelect('comp_month', Site::getShortMonthsArray(), '', 'Month', 'compliance date', $cf, array('class'=>'sel_var'));
				echo Site::drawText('comp_year', (isset($_POST['comp_year'])?@$_POST['comp_year']:'')).BR2;
			} else {
				echo Site::drawText('rego_number', '', 'registration').BR2;
				echo Site::drawText('year', (isset($_POST['year'])?@$_POST['year']:''), 'Year').BR;
			}
			echo Site::drawSelect('make_id', $make_array, @$_POST['make_id'], '', 'make').BR;
			echo Site::drawSelect('model_id', array(''=>'select a make'), @$_POST['model_id'], '', 'model').BR;
			echo Site::drawSelect('badge_id', array('select a model'), @$_POST['badge_id'], '', 'badge').BR;
			echo Site::drawSelect('series_id', array('select a model'), @$_POST['series_id'], '', 'series').BR2;
			
			if($_SESSION['l10n']['country_code']=='IE'){
			
			
				echo Site::drawText('mileage_miles', '', 'mileage').' miles'.BR;
				echo Site::drawText('mileage', @$_POST['mileage'], ' ').' km'.BR2;
				
				$month_array = array('', 'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
				
				$month_array = array_combine($month_array, $month_array);
				
				echo Site::drawSelect('nct_month', $month_array, '', '', 'NCT Info');
				echo Site::drawSelect('nct_year', array(''=>'', '2013'=>'2013', '2014' => '2014', '2015' => '2015', '2016' => '2016'),'', '');
				
			} else {
				echo Site::drawText('mileage', @$_POST['mileage'], 'mileage').' km'.BR2;
				echo Site::drawHidden('nct_month', '');
				echo Site::drawHidden('nct_year', '');
			}
			
			
			
			echo Site::drawDiv();
			
			echo Site::drawDiv('submit_item_mand_right');
			 
			echo Site::drawSelect('auctionlength', Site::getLookupTable('auction_lengths', 'id', 'length', 'lis'), 14, '', 'list for').BR;
			?>
			<div id="extended_expiry">(can be extended before expiry)</div>
			<?php
			echo BR2;
			echo Site::drawText('startprice', @$_POST['startprice'], 'Offers Around', array('placeholder'=>'optional')).BR;
			echo Site::drawHidden('buyoutprice', @$_POST['buyoutprice']);
			
			echo Site::drawText('spend', @$_POST['spend'], 'To Spend', array('placeholder'=>'optional')).BR;
			
			
			//if($ut == 1) echo Site::drawSelect('max_requests', array('5'=>'5', '10'=>'10', '15'=>'15', '20'=>'20', '30'=>'30', '50'=>'50'), @$_POST['max_requests'], 10, 'Max Enquiries').BR2;
			echo Site::drawHidden('max_requests', 1000);
			
			$rego_array[] = 'No Rego';
			for($i=0;$i<=12;$i++){
				$rego_time = mktime (12, 0, 0, date("n")+$i, 15, date("Y"));
				$rego_array[date('m-Y', $rego_time)] = date('m-Y', $rego_time);
			}
			
			if($_SESSION['l10n']['country_code']!='IE') echo Site::drawSelect('registration', $rego_array, @$_POST['registration'], '', 'rego end', $cf, array('class'=>'sel_var')).BR2;
			
			echo Site::drawDiv(false, true);
			echo Site::drawDiv();
			
			echo Site::drawDiv(false, true);
			echo BR2;
			
			$import_term = $_SESSION['l10n']['country_code']=='IE' ? 'UK import' : 'personal import';
			
			echo Site::drawDiv('submit_item_opt_left');
			echo Site::drawSelect('import', array('No', 'Yes'),'', '', $import_term, $cf).BR;
			echo Site::drawSelect('colour_id', Site::getLookupTable('type_colours', 'id', 'colour', 'colour'), @$_POST['colour_id'], ($ut==4?'':2), 'colour', 'select colour', array('class'=>'sel_var')).BR;
			
			echo Site::drawSelect('interior_type_id', Site::getLookupTable('type_interiors', 'id', 'interior', 'interior'), @$_POST['interior_type_id'], ($ut==4?'':3), 'interior', 'select interior', array('class'=>'sel_var')).BR;
			
			echo Site::drawSelect('interior_colour_id', Site::getLookupTable('type_colours', 'id', 'colour', 'colour', ''), @$_POST['interior_colour_id'], ($ut==4?'':8), 'interior colour', 'select interior colour', array('class'=>'sel_var')).BR2;
			
			echo Site::drawSelect('fuel_type_id', Site::getLookupTable('type_fuel', 'id', 'fuel', 'fuel'), @$_POST['type_fuel'], ($ut==4?'':1), 'fuel type', 'select fuel type').BR;
			echo Site::drawSelect('transmission_type_id', Site::getLookupTable('type_transmission', 'id', 'transmission', 'transmission'), @$_POST['transmission_type_id'], ($ut==4?'':1), 'transmission', true).BR;
			
			if($_SESSION['l10n']['country_code']!='IE'){
				echo Site::drawSelect('drive_type_id', Site::getLookupTable('type_drives', 'id', 'drive', 'drive'), @$_POST['drive_type_id'], 1, 'drive type', true).BR;
			} else {
				echo Site::drawHidden('drive_type_id', 0);
			}
			
			
			
			$type_body_table = $_SESSION['l10n']['country_code']!='IE'? 'type_body' : 'uk_type_body';
			echo Site::drawSelect('body_id', Site::getLookupTable($type_body_table, 'id', 'body', 'body'), @$_POST['body_id'], 1, 'body type', true).BR;
			echo Site::drawSelect('roof_type_id', Site::getLookupTable('type_roofs', 'id', 'roof', 'roof'), @$_POST['roof_type_id'], 1, 'roof type', true).BR2;
			
			if($_SESSION['l10n']['country_code']!='IE'){
			echo Site::drawSelect('cylinders', array(''=>'select cylinders', 3=>3, 4=>4, 5=>5,6=>6,8=>8,10=>10,12=>12,16=>16), @$_POST['cylinders'], 6, 'cylinders').BR;
			} else {
			echo Site::drawHidden('cylinders', 4);
			}
			
			echo Site::drawText('engine_size', @$_POST['engine_size'], 'Engine Size').BR2;
			
			echo Site::drawSelect('doors', array(''=>'select doors', 2=>2,3=>3,4=>4,5=>5), @$_POST['doors'], 4, 'doors').BR;
			echo Site::drawDiv();
			
			echo Site::drawDiv('submit_item_opt_right');
			echo Site::drawTextArea('description', @$_POST['description'], 'comments and details of spend', array('placeholder'=>'optional')).BR2;
			echo Site::drawCustomSubmit('list vehicle');
			
			echo Site::drawDiv();
			
			echo Site::drawDiv(false, true);
			
			
			
			
			echo Site::drawForm();
		?>
		</div>
<br>




</div>

