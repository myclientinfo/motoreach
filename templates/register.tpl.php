		<script>		var validate_array = ['fullname','email', 'dealer_name', 'mobile', 'phone', 'city', 'streetaddress', 'state'];				jQuery(document).ready(function(){															$('#newuser').submit(function(event){				//console.log();				return validate();			});						$('#state').bind('blur change', function(){								if($('input:checked').length==1){					$('#location_2, #location_3, #location_4, #location_5, #location_6, #location_7, #location_8').attr('checked', false);				}								$('#location_'+$('#state').val()).attr('checked','checked');							});						$('input[type=checkbox]').bind('click', function(e){				if($(this).attr('id').replace('location_', '') == $('#state').val() && $(this).attr('checked')==false){					e.preventDefault();				}			})						$('#fullname, #email, #mobile, #phone').bind('blur change', function(){							if($(this).val()!='' && $('#user_type_id').val() == '1' && ($('#dealership_name').val()=='' || $('#dealer_name').val()=='')) {					newAlert('You must fill in your dealer info first.', 'stop');				}			});						$('#zip').bind('change keypress', function(){				var first = $('#zip').val().substring(0,1);				if (first == '0') first = 8;				$('#state').val(first);								/*				if($('#zip').val().length == 4){					$.post("/api/get_region.php", {postcode: $('#zip').val()}, function(data){						$('#location_id').val(data.id);					});				}				*/			});												$('#user_type_id').bind('blur change', function(){								var user_type = $("option:selected", this).text();								if(user_type != 'Motor Dealer'){										$('#di_di').hide();					$('#di_bi').show();					$('#type_description_nond').show();					$('#type_description_dealer').hide();					$('#dealership_name_label, #streetaddress_label').css('display', 'none');					$('#business_name_label, #businessaddress_label').css('display', 'inline-block');										$('#dealer_info_box').hide();										validate_array = ['fullname','email', 'mobile', 'phone', 'city', 'streetaddress', 'zip', 'state'];									} else {										$('#di_bi').hide();					$('#di_di').show();										$('#type_description_nond').hide();					$('#type_description_dealer').show();										$('#dealership_name_label, #streetaddress_label').css('display', 'inline-block');					$('#business_name_label, #businessaddress_label').css('display', 'none');										$('#dealer_info_box').show();										validate_array = ['fullname','email', 'dealer_name', 'mobile', 'phone', 'city', 'streetaddress', 'zip', 'state'];									}			});						$('#country_id').val(<?php echo $_SESSION['l10n']['country_id']?>);						$('#country_id').bind('change blur', function(){				//	console.log($('#country_id').val());			});									<?php if(isset($fail_fields)){ 			foreach($fail_fields as $f){ ?>			//alert(<?php echo $f?>);			$('#<?php echo $f?>').css('backgroundColor', '#FF7F00');			<?php } 			} ?>						<?php if(isset($message)){ 			//$messages = array(			//	'AUCTION_NONMATCHING_PASSWORDS' => 'Your password and confirmation password do not match. Please try again.'			//);			?>			newAlert('<?php echo $message ?>', 'stop');			<?php } ?>		});		</script>		<style>		#newuser {width: 500px;}		#newuser #dealer_name, #newuser #dealer_number {width: 200px;}				#email_text {			width: 380px;			position: relative;			left: 95px;			display: inline-block;			margin-bottom: 10px;			text-align: center;		}				#newuser label {width: 190px;}				#newuser label#business_name_label, #newuser label#businessaddress_label {			display: none;		}		#newuser label#dealership_name_label {			display: inline-block;		}		#type_description_nond {			display: none;		}				#type_description_nond, #type_description_dealer {			position: relative;			left: 223px;			font-size: 16px;		}				#stop{			position: relative;			left: -8px;		}		</style>		<div id="inner_content_blue">				<h2>Become a Member</h2>				<?php if (!empty($_POST) && !isset($message) ){?>			<p>You have now been registered, and you are logged in as <?php echo @$user->fullname?>.</p>		<?php } else {?>					<div class="form_left">						<p><b>Email:</b> This is the email address you will recieve vehicle matches to, and will also be used to log in.</p>						<p><b>Address:</b> The street address (not postal) of the dealership.</p>						<p><b>Accounts - Email:</b> The email address to which invoices will be sent.</p>						<p><b>Accounts - Phone:</b> The phone number to contact if there is any issues with account payments.</p>						<p><b>Rep ID:</b> If form is filled in by our representatives they may enter their number here to have the account approved immediately.</p>						<p>Please note that all fields are required except <em>Rep ID</em>.</p>			<img src="/images/stop.png" id="stop" />			</div>									<?php			echo Site::drawForm('newuser');			echo Site::drawHidden('formdata', 'register');			echo Site::drawHidden('ob_hidden', '0');			echo Site::drawHidden('location_pref', '0');			echo Site::drawHidden('location_id', '0');						$user_types = array('1'=>'Motor Dealer','2'=>'Corporate Fleet','3'=>'Government Fleet','4'=>'Vehicle Rental');			echo Site::drawSelect('user_type_id', $user_types, @$_POST['user_type_id'], '', 'Your Business Type').BR2;			/*			echo Site::drawLabel('type_description_dealer', 'Access type');			echo Site::drawDiv('type_description_dealer').'Buy, Sell, etc'.Site::drawDiv();			echo Site::drawDiv('type_description_nond').'Sell only'.Site::drawDiv();			*/			echo '<h3 id="di_di">Dealership Information</h3>';			echo '<h3 id="di_bi" style="display: none;">Business Information</h3>';						echo Site::drawLabel('business_name', 'Business Name');									echo Site::drawText('dealership_name', @$_POST['dealership_name'], 'dealership name').BR;			echo Site::drawDiv('dealer_info_box');			echo Site::drawText('dealer_name', @$_POST['dealer_name'], 'licensed dealer name').BR;			if($_SESSION['l10n']['country_code'] != 'IE'){				echo Site::drawText('dealer_number', @$_POST['dealer_number'], 'licensed dealer number').BR2;			} else {				echo Site::drawHidden('dealer_number', 0);				echo BR;			}			echo Site::drawDiv();			echo Site::drawLabel('businessaddress', 'Business address');			echo Site::drawText('streetaddress', @$_POST['streetaddress'], 'dealership address').BR;			//echo Site::drawText('city', @$_POST['city'], $_SESSION['l10n']['term_suburb']).BR;						if($_SESSION['l10n']['country_code']!='IE') echo Site::drawText('city', @$_POST['city'], $_SESSION['l10n']['term_suburb']).BR;			else echo Site::drawSelect('city', Site::getLookupTable('regions', 'id', 'region', 'region', false, false, false, false, 'state_id > 9 AND state_id < 14'), @$_POST['city'],'', 'County').BR;						if($_SESSION['l10n']['country_code']!='IE') echo Site::drawText('zip', @$_POST['zip'], 'postcode').BR;			else echo Site::drawHidden('zip', '');						echo Site::drawSelect('state', Site::getLookupTable('states', 'id', 'state', 'id', true, false, false, false, 'country_id = '.$_SESSION['l10n']['country_id']), @$_POST['state'], '', $_SESSION['l10n']['term_state']).BR;			echo Site::drawSelect('country_id', Site::getLookupTable('countries', 'id', 'country', 'id', true), @$_POST['country_id'], '', 'country').BR2;						echo '<h3>Member Contact Information</h3>';			echo Site::drawText('fullname', @$_POST['fullname'], 'contact name').BR2;			echo Site::drawPlainText('email_text','Login Email address is your login for MotoReach and will also be where vehicle information is sent').BR;			echo Site::drawText('email', @$_POST['email'], 'login email', false, 'email').BR;			echo Site::drawPassword('password', @$_POST['password'], 'create password').BR;			echo Site::drawPassword('confirmpassword', @$_POST['confirmpassword'], 'confirm password').BR2;			echo Site::drawText('mobile', @$_POST['mobile'], 'mobile').BR;			echo Site::drawText('phone', @$_POST['phone'], 'phone').BR2;			echo '<h3>Accounts Information</h3>';			echo Site::drawText('account_email', @$_POST['account_email'], 'email', false, 'email').BR;			echo Site::drawText('account_phone', @$_POST['account_phone'], 'phone').BR;			echo Site::drawText('rep_number', '', 'Rep ID', array('placeholder'=>'Office use only - leave blank if unknown')).BR2;						echo 'to prevent "spam" signups, please complete the following simple mathematical question<br><br>';						echo Site::drawText('test_question', '', 'What is 5 + 2?').BR;						echo Site::drawCustomSubmit('join now');			echo Site::drawDiv(false, true);			echo Site::drawForm();			?>					<?php } ?>		<br><br>		</div>