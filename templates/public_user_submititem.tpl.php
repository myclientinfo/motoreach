<?php 
$ut = User::getSD('user_type_id');
$mf = isset($_SESSION['step']['miniform']) ? $_SESSION['step']['miniform'] : false;
$cf = '';
?>
<script type="text/javascript">

var validate_array = ['year', 'comp_month', 'comp_year', 'mileage', 'colour_id', 'interior_colour_id', 'interior_type_id', 'model_id', 'spend', 'registration', 'import', 'fuel_type_id', 'transmission_type_id', 'drive_type_id', 'body_id', 'roof_type_id', 'cylinders', 'doors', 'upgrade', 'build_month'];

block = true;

jQuery(document).ready(function(){
	
	$('#newitem').submit(function(e){
		
		
		<?php if($_SESSION['l10n']['country_code']=='IE'){ ?>
		$.post("api/add_vehicle.php", $(this).serialize()).done(function(data) {
			$('#ID').val(data);
			$('#customerid').val(data);
			$('#responseSuccessURL').val('http://www.mymotoreach.com/confirm_sale.php?auction_id='+data);
			return false;
		});
		<?php } ?>
		
	});
	
	<?php if($mf){ ?>
	$('#make_id').val("<?php echo $mf['make_id'] ?>");
	$('#make_id').trigger('change');
	$('#model_id').val("<?php echo $mf['model_id'] ?>");
	$('#model_id').trigger('change');
	$('#badge_id').val("<?php echo $mf['badge_id'] ?>");
	<?php } ?>
	
	<?php foreach($check_fields as $c){ ?>
	$('#<?php echo $c ?>').css('backgroundColor', '#FF7F00');
	<?php } ?>
	
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

	<h2>List a vehicle for Wholesale</h2>

	 <div id="register_box">
				<img src="/images/public_sell_form_top.png" alt="">
			<?php 
			$make_array = array_combine(array_keys($GLOBALS['make_models']), array_keys($GLOBALS['make_models']));
			
			//$action = $_SESSION['l10n']['country_code']=='IE' ? '' : '';
			
			if($_SESSION['l10n']['country_code']=='IE'){
			
				echo Site::drawForm('newitem', 'https://test.ipg- online.com/connect/gateway/processing', 'POST', 'multipart/form-data');
				
				echo Site::drawHidden('sale_type_id', 1);
				//storename + txndatetime + chargetotal + currency + sharedsecret
				echo Site::drawHidden('txntype', 'sale');
				echo Site::drawHidden('timezone', 'GMT');
				echo Site::drawHidden('txndatetime', date('Y:m:d-H:i:s'));
				echo Site::drawHidden('hash', sha1(bin2hex('13011553712' + date('Y:m:d-H:i:s') + '19.95' + '978' + 'jfiS9erFBG')));
				echo Site::drawHidden('storename', '13011553712');
				echo Site::drawHidden('mode', 'payonly');
				echo Site::drawHidden('chargetotal', '19.95');
				echo Site::drawHidden('currency', '978');
				echo Site::drawHidden('customerid', '');
				echo Site::drawHidden('responseSuccessURL', 'http://www.mymotoreach.com/confirm_sale.php');
				
			} else {
				
				echo Site::drawForm('newitem', '', 'POST', 'multipart/form-data');
				
			}
			
			echo Site::drawHidden('userID', $_SESSION['auction']->user->ID);
			
			echo Site::drawHidden('ID', 0);
			echo Site::drawHidden('sale_type_id', 1);
			echo Site::drawHidden('processed', 'no');
			echo Site::drawHidden('formdata', 'submission');
			echo Site::drawHidden('categoryID', 1);
			echo Site::drawHidden('uniqueID', Auction::getUniqueId());
			
			echo Site::drawText('year', (isset($_POST['year'])?@$_POST['year']:($mf?$mf['year']:'')), 'Year', array('placeholder'=>'optional')).BR;
			
			echo Site::drawSelect('make_id', $make_array, @$_POST['make_id'], '', 'make').BR;
			echo Site::drawSelect('model_id', array(''=>'select a make'), @$_POST['model_id'], '', 'model').BR;
			echo Site::drawSelect('badge_id', array('select a model'), @$_POST['badge_id'], '', 'badge').BR;
			
			echo Site::drawText('mileage', (isset($_POST['mileage'])?@$_POST['mileage']:($mf?$mf['mileage']:'')), 'mileage').BR2;
			 
			echo Site::drawHidden('auctionlength', '3').BR;
			
			echo Site::drawHidden('max_requests', 20);
			
			$rego_array[] = 'No Rego';
			
			for($i=0;$i<=12;$i++){
				$rego_time = mktime (12, 0, 0, date("n")+$i, 15, date("Y"));
				$rego_array[date('Y-m', $rego_time)] = date('Y-m', $rego_time);
			}
			
			echo Site::drawSelect('registration', $rego_array, @$_POST['registration'], '', 'rego end', false, array('class'=>'sel_var')).BR2;
			
			echo Site::drawSelect('colour_id', Site::getLookupTable('type_colours', 'id', 'colour', 'colour'), @$_POST['colour_id'], ($ut==4?'':2), 'colour', false, array('class'=>'sel_var')).BR;
						
			echo Site::drawSelect('build_month', Site::getShortMonthsArray(), '', 'Month', 'build date', $cf, array('class'=>'sel_var'));
			echo Site::drawText('year', (isset($_POST['year'])?@$_POST['year']:'year')).BR;
			echo Site::drawSelect('comp_month', Site::getShortMonthsArray(), '', 'Month', 'compliance date', $cf, array('class'=>'sel_var'));
			echo Site::drawText('comp_year', (isset($_POST['comp_year'])?@$_POST['comp_year']:'year')).BR2;

			echo Site::drawHidden('startprice', @$_POST['startprice']);
			echo Site::drawHidden('buyoutprice', @$_POST['buyoutprice']);
			echo Site::drawText('spend', @$_POST['spend'], 'to spend', array('placeholder'=>'optional')).BR;
			
			echo Site::drawSelect('import', array('No', 'Yes'),'', '', 'personal import', $cf).BR;
			echo Site::drawSelect('interior_type_id', Site::getLookupTable('type_interiors', 'id', 'interior', 'interior'), @$_POST['interior_type_id'], ($ut==4?'':3), 'interior', $cf, array('class'=>'sel_var')).BR;
			echo Site::drawSelect('interior_colour_id', Site::getLookupTable('type_colours', 'id', 'colour', 'colour'), @$_POST['interior_colour_id'], ($ut==4?'':8), 'interior colour', $cf, array('class'=>'sel_var')).BR2;
			
			echo Site::drawSelect('fuel_type_id', Site::getLookupTable('type_fuel', 'id', 'fuel', 'fuel'), @$_POST['type_fuel'], ($ut==4?'':1), 'fuel type', true).BR;
			echo Site::drawSelect('transmission_type_id', Site::getLookupTable('type_transmission', 'id', 'transmission', 'transmission'), @$_POST['transmission_type_id'], ($ut==4?'':1), 'transmission', true).BR;
			echo Site::drawSelect('drive_type_id', Site::getLookupTable('type_drives', 'id', 'drive', 'drive'), @$_POST['drive_type_id'], 2, 'drive type', true).BR;
			echo Site::drawSelect('body_id', Site::getLookupTable('type_body', 'id', 'body', 'body'), @$_POST['body_id'], 1, 'body type', true).BR;
			echo Site::drawSelect('roof_type_id', Site::getLookupTable('type_roofs', 'id', 'roof', 'roof'), @$_POST['roof_type_id'], 1, 'roof type', true).BR2;
			echo Site::drawSelect('cylinders', array(''=>'select cylinders', 3=>3, 4=>4, 5=>5,6=>6,8=>8,10=>10,12=>12,16=>16), @$_POST['cylinders'], 6, 'cylinders').BR;
			echo Site::drawSelect('doors', array(''=>'select doors', 2=>2,3=>3,4=>4,5=>5), @$_POST['doors'], 4, 'doors').BR;
			
			echo Site::drawTextArea('description', @$_POST['description'], 'comments', array('placeholder'=>'optional')).BR2;
			
			echo Site::drawCustomSubmit('list vehicle');
			
		
			echo Site::drawForm();
			
			
		?>
		
		 <img src="/images/public_sell_form_bottom.png" alt="">
		</div>
</div>


