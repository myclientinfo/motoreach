<script>jQuery(document).ready(function(){	<?php if(isset($message) && $message != '' && $message != 'SUCCESS'){ ?>	newAlert('<?php echo $message ?>', 'stop');	<?php } else if(isset($message) && $message == 'SUCCESS') { ?>	window.location = '/login.php';	<?php } ?>			if( $('#show_reset').length > 0 ){		$('#show_reset').click(function(){			$('#login2').hide();			$('#password_reset').show();		});					$('#show_login').click(function(){			$('#password_reset').hide();			$('#login2').show();		});	}		$("#login_email, #login_password").keypress(function(event) {		if(event.which==13){			$('#login2').submit();		}	})	});</script><style>#login2 {margin-bottom: 30px;}#password_reset {}#password_reset{	display: none;}#show_reset, #show_login {	color: #FF7F00;	text-decoration: underline;	cursor: pointer;	cursor: hand;	position: relative;	top: 40px;}p.small {	font-size: 10px;}</style>
<div id="inner_content_white">
<h2>Member Login</h2><div class="form_left">	<p>Log in here to access MotoReach to buy and trade vehicles.</p>		<p>If you are not a MotoReach user and you are a registered dealer please <a href="/register.php">become a member</a>.</p>		<!--<p>Cannot remember your login details?--></div>
<?php//print_r($_GET);if(!isset($_GET['reset']) || (isset($_GET['reset'])) && isset($auth_invalid) ){	echo Site::drawForm('login2');	echo Site::drawHidden('formdata', 1);	echo Site::drawHidden('loc', @$_GET['loc']);	echo Site::drawText('login_email', @$_POST['email'], 'email').BR;	echo Site::drawPassword('login_password', '', 'password').BR;	echo Site::drawCustomSubmit('log in', '_small');	echo Site::drawDiv('show_reset').'forgotten password?'.Site::drawDiv();	echo Site::drawForm();	echo Site::drawForm('password_reset');	echo Site::drawPlaintext('reset_description','<p class="small">If you have lost or forgotten your password, please enter your email address here and an email will be sent telling you how to reset your password.</p>');	echo Site::drawHidden('formdata', 1);	echo Site::drawText('password_reset_email', @$_POST['email'], 'email').BR;	echo Site::drawCustomSubmit('Reset Password');	echo Site::drawDiv('show_login').'cancel reset'.Site::drawDiv();	echo Site::drawForm();} else {	echo Site::drawForm('login2');	echo Site::drawPlaintext('reset_description','<p class="small">Enter and confirm your password here</p>');	echo Site::drawHidden('formdata', 1);	echo Site::drawHidden('reset', 1);	echo Site::drawHidden('auth', $_GET['auth']);	echo Site::drawHidden('userID', $_GET['userID']);	echo Site::drawText('password', '', 'password').BR;	echo Site::drawText('confirm_password', '', 'confirm password').BR;	echo Site::drawCustomSubmit('Reset Password');	echo Site::drawForm();}?>
<br><br>
</div>