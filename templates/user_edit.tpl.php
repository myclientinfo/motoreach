		<link type="text/css" href="/css/excite-bike/jquery-ui-1.8rc3.custom.css" rel="Stylesheet" />
		<script src="/js/jquery-ui-1.8rc3.custom.min.js"></script>
		
		<script>
		
		
		jQuery(document).ready(function(){
			
		});
		</script>
		
        
		
		<div id="inner_content_white">
		
		
		
	
			<p id="message"><?php echo $message ?></p>
			
			
            
			<?php if($_GET['edit']=='match'){ ?>
			
            <h2>edit your vehicle match preferences</h2>
			
			<p>You will be sent all vehicles that are listed on MotoReach from your region by default, including vehicles from both dealers and the public.</p>
			
			<p>You can use this system to add makes or models that you are specifically interested in buying, or specific regions you would like to buy from.</p>
			<?php echo $matches_interface ?>
			
            <?php } else if($_GET['edit']=='details') { ?>
            <style>
		#newuser {width: 500px;}
		#newuser #dealer_name, #newuser #dealer_number {width: 200px;}
		
		#email_text {
			width: 380px;
			position: relative;
			left: 95px;
			display: inline-block;
			margin-bottom: 10px;
			text-align: center;
		}
		
		#newuser label {width: 190px;}
		</style>
			<h2>edit your contact details</h2>
			
			<div class="form_left">
	
				<p>Please edit and save any details you would like changed on our records. Changing the <em>email</em> field will change your login.</p>
				
				<p>Leave <em>password</em> and <em>confirm password</em> blank if you do not wish to change your password</p>
			</div>
			
			<?php
			echo Site::drawForm('newuser');
			echo Site::drawHidden('formdata', 'update');
			echo Site::drawHidden('ID', $user['ID']);
			echo Site::drawHidden('edit', 'details');
			echo '<h3>Dealership Information</h3>';
			echo Site::drawText('dealership_name', $user['dealership_name'], 'dealership name').BR;
			echo Site::drawText('dealer_name', $user['dealer_name'], 'licensed dealer name').BR;
			echo Site::drawText('dealer_number', $user['dealer_number'], 'licensed dealer number').BR2;

			echo Site::drawText('streetaddress', $user['streetaddress'], 'dealership address').BR;
			echo Site::drawText('city', $user['city'], 'suburb').BR;
			
			if($_SESSION['l10n']['country_code'] != 'IE') echo Site::drawText('zip', @$_POST['zip'], 'postcode').BR2;
			else echo Site::drawHidden('zip', '');
			echo Site::drawSelect('state', Site::getLookupTable('states', 'id', 'state', 'id', true, false, false, false, 'country_id = '.$_SESSION['l10n']['country_id'].' AND id != 14'), $user['state'], '', $_SESSION['l10n']['term_state']).BR;



if($_SESSION['l10n']['country_code']!='IE') echo Site::drawText('city', @$_POST['city'], $_SESSION['l10n']['term_suburb']).BR;
			else echo Site::drawSelect('city', Site::getLookupTable('regions', 'id', 'region', 'region', false, false, false, false, 'state_id > 9 AND state_id < 14'), @$_POST['city'],'', 'County').BR;
			
			if($_SESSION['l10n']['country_code']!='IE') echo Site::drawText('zip', @$_POST['zip'], 'postcode').BR;
			else echo Site::drawHidden('zip', '');



			echo '<h3>Member Contact Information</h3>';
			echo Site::drawText('fullname', $user['fullname'], 'contact name').BR2;
			echo Site::drawPlainText('email_text','Login Email address is your login for MotoReach and will also be where vehicle information is sent').BR;
			echo Site::drawText('email', $user['email'], 'login email', false, 'email').BR;

			echo Site::drawText('mobile', $user['mobile'], 'mobile').BR;
			echo Site::drawText('phone', $user['phone'], 'phone').BR2;

			echo '<h3>Accounts Information</h3>';
			echo Site::drawText('account_email', $user['account_email'], 'email', false, 'email').BR;
			echo Site::drawText('account_phone', $user['account_phone'], 'phone').BR2;
			
			//echo Site::drawSubmitImage('submit','/images/button_save.png');
			echo Site::drawPlainText('password_text', '<p>If you leave the <em>Password</em> and <em>Edit Password</em> fields blank, your password will NOT be changed. You must enter two identical passwords here to change your password.</p>');
			echo Site::drawText('password', '', 'password').BR;
			echo Site::drawText('confirmpassword', '', 'confirm password').BR2;
			echo Site::drawCustomSubmit('update', '_small', '1');
			echo Site::drawDiv(false, true);
			echo Site::drawForm();
			
			} else {
			
			?>
			
			
			<h2>edit your notification preferences</h2>
			
			
			<?php
			
			echo Site::drawForm('notifications');
			echo Site::drawHidden('formdata', 'notify_preference');
			
			$notify_options = Site::getLookupTable('notification_preference_type', 'id', 'preference', 'id');
			$first = true;
			foreach($notification_options as $k => $v){
				echo $first == true?'':'<br /><br /><br />';
				echo '<h3>'.strtolower($k).'</h3>';
				
				foreach($v as $n){
					$set = isset($user_notification[$n['id']]);
					$bitmask = @$user_notification[$n['id']]['bitmask'];
					$not = isset($user_notification[$n['id']]['preference_id']) ? $user_notification[$n['id']]['preference_id'] : 2;
					
					echo Site::drawSelect('not['.$n['id'].']', $notify_options, $not, '', strtolower($n['item_name']));
				}
				$first = false;
			}
			echo Site::drawDiv(false, true);
			echo '<br /><br />';
			echo Site::drawCustomSubmit('save', '_small', '2');
			echo Site::drawForm();
			?>
			
			<?php } ?>
			
		
		</div>