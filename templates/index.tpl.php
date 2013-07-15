<?php 
$car = Site::getCar();
?><!DOCTYPE>
<?php
$p = isset($_REQUEST['dialer'])?'..':'';
?>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="google-site-verification" content="qknd-vYIs8bLmX8fnTOsLk6iGTElR50bPol9ZGVkz30" />
	<title>MotoReach.com</title>
	<link rel="stylesheet" href="<?php echo $p ?>/css/reset.css" />
	<link rel="stylesheet" href="<?php echo $p ?>/css/style.css?ver=2" />
	<link rel="stylesheet" href="<?php echo $p ?>/css/excite-bike/jquery-ui-1.8rc3.custom.css" type="text/css" media="all" />
	<script src="<?php echo $p ?>/js/jquery-1.7.min.js" language="JavaScript" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo $p ?>/js/script.js?ver=2"></script>
	<?php if(!isset($_REQUEST['dialer'])){ ?>
	
	<script type="text/javascript" src="<?php echo $p ?>/js/cufon-yui.js"></script>
	<script type="text/javascript" src="/js/heavy.font.js"></script>
	<script type="text/javascript" src="/js/condensed.font.js"></script>
	<script type="text/javascript" src="/js/delicious_normal.font.js"></script>
	<script type="text/javascript" src="/js/cufon_config.js"></script>
	<?php } ?>
	
	<script src="/js/jquery-ui-1.8rc3.custom.min.js"></script>
	
	<?php if(in_array($_SERVER['PHP_SELF'], array('/user/editaccount.php', '/user/submititem.php', '/user/welcome.php', '/admin/prefs.php', '/admin/list.php', '/admin/items.php', '/items.php'))){ ?>
	<script type="text/javascript" language="JavaScript" src="/js/vehicles.php"></script>
	<?php } ?>
	
	<script type="text/javascript" language="JavaScript">
	
	var project = "<?php echo $GLOBALS['project']?>";
	var car = <?php echo json_encode($car)?>;
	
	var region_id = '<?php echo User::getSD('location_id')?>';
	var user_state = "<?php echo @$_SESSION['auction']->user->state ?>";
	
	<?php if(isset( $_SESSION['auction']->user)){ ?>
	var is_approved = <?php echo User::getSD('approved')? 'true' :'false'; ?>;
	var block = false;
	<?php } ?>
	
	</script>
	<?php if(!isset($_REQUEST['dialer'])){ ?>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42470116-1', 'motoreach.com');
  ga('send', 'pageview');

</script>
	<style>
	#header_image img {
		left: -<?php echo $car['left']?>px;
		top: -<?php echo $car['top']?>px;
	}
	
	
	</style>
	<?php } else { ?>
	<style>
	body {background-color: white;}
	#inner_content_white {background-image: none;}
	#make_fake {display: none !important;}
	</style>
	<?php } ?>
	<!--[if IE 6]>
	<link rel="stylesheet" href="/css/ie6.css" />
	<![endif]-->

</head>

<body>

<div id="container">
	<?php if(!isset($_REQUEST['dialer'])){ ?>
	<div id="header">
	<!--<a href="http://www.merlincarauctions.ie" target="_blank"><img src="/images/Commercial__468x60.jpg" style="border: 0px; position: absolute; right: 0px; top: 25px;"></a>-->
		
		
		
		<h1><img src="/images/logo.png" /></h1>
	
	</div>
	<div id="nav">
		<?php echo $menu; ?>
	</div>
	<?php } ?>
	<div id="maincontent">
		
		<div id="actual_content">
		<?php if(!isset($_REQUEST['dialer'])){ ?>
		<?php  if(isset($_SESSION['permissions']) && !empty($_SESSION['permissions']) && $_SESSION['authorised']=='valid'){ ?>
		
		<?php if( User::isBoxHidden()){ ?>
		<style>
		#orange_left_box, #orange_mid_box { display: none; }
		#orange_right_box { left: 0px; height: 30px;}
		
		#quicklinks { display: block; left: 184px; position: absolute; top: 0; width: 766px; }

		#quicklinks li { float: left; margin-left: 0; margin-right: 25px; top: 0;}
		#orange_bevel_sm {display: block;}
		#orange_bevel {display: none;}
		
		#orange_right_box .user_details {
		height: 30px; width: 600px; position: absolute; top: 0px;
		background-image: none;
		}
		
		#orange_box {height: 42px;}
		#orange_inner {height: 23px;}
		
		#ob_close {display: none; }
		#ob_open {display: block; }
		</style>
		<?php } ?>
		
		<div id="orange_box">
			<div id="orange_bevel"></div>
			<div id="orange_bevel_sm"></div>
			<div id="orange_top"></div>
			<div id="orange_inner">
			
				
				<br style="clear:both;" />
			</div>
			
			<div class="obox" id="orange_left_box">
				<div class="orange_header"><?php echo User::getSD('group_id') ? User::getSD('group_name'): User::getSD('fullname') ?></div>
				<span style="display: block; position: relative; top: -18px; color: white; text-align: center; font-size: 9px;"><?php echo User::getSD('group_id') ? User::getSD('dealership_name'): User::getSD('dealership_name') ?></span>
				
				<div class="user_details_left">
					<div class="user_details_inner">
					
					<?php 
					echo Site::drawPlainText('details_mobile', User::getSD('mobile')?User::getSD('mobile'):'Not provided', 'MOBILE:').BR;
					echo Site::drawPlainText('details_phone', User::getSD('phone')?User::getSD('phone'):'Not provided', 'PHONE:').BR2;
					
					//echo User::getSD('user_type_id');
					if(User::getSD('user_type_id') == 1){
						echo Site::drawPlainText('details_dname', User::getSD('dealership_name')?User::getSD('dealership_name'):'Not provided', 'DEALER:').BR;
						echo Site::drawPlainText('details_dnumb', User::getSD('dealer_number')?User::getSD('dealer_number'):'Not provided', 'DLR NUM:').BR;
					} else {
						echo Site::drawPlainText('details_dname', User::getSD('dealership_name')?User::getSD('dealership_name'):'Not provided', 'COMPANY:').BR;
					}
					?>
					
					<div class="edit_link"><a href="/user/editaccount.php?edit=details">[edit]</a></div>
					</div>
				</div>
				
			</div>
			<div class="obox" id="orange_mid_box">
				<img src="/images/middle_car.png" id="middle_car">
				
			<!--<div id="dealer_ad">
				<div id="dealer_ad_inner">
					<b class="ad_header">AMM Finance</b>
					<p>Premium dealer finance packages, paying higher than average referral commissions. Also offering good terms for poor credit rate customers.</p>
					
					<p>Call now and arrange to discuss a partnership with Australia's fastest growing finance provider.</p>
					
				</div>
			</div>-->
			
			</div>
			<div class="obox" id="orange_right_box">
			
			<div class="orange_header" id="ql_header">quick links</div>
			
				<div class="user_details">
					<div class="user_details_inner">
					
						<ul id="quicklinks">
							<li<?php echo $_SERVER['PHP_SELF']=='/user/index.php' ? ' class="active"' :'' ?>><a href="/user/index.php">Member Dashboard</a></li>
							<?php if(User::hasPermission('List')){ ?><li<?php echo $_SERVER['PHP_SELF']=='/user/submititem.php' ? ' class="active"' :'' ?>><a href="/user/submititem.php">Sell a vehicle</a></li><?php } ?>
							<?php if(User::hasPermission('Match')){ ?><li<?php echo $_SERVER['PHP_SELF']=='/user/matches.php' ? ' class="active"' :'' ?>><a href="/user/matches.php">Vehicle Matches</a></li><?php } ?>
							<?php if(User::hasPermission('List')){ ?><li<?php echo $_SERVER['PHP_SELF']=='/user/listings.php' ? ' class="active"' :'' ?> id="menu_listings"<?php if( User::isBoxHidden()){ echo ' style="display: none;"'; } ?>><a href="/user/listings.php">Your Listed Vehicles</a></li><?php } ?>
							<li<?php echo $_SERVER['PHP_SELF']=='/user/editaccount.php' && isset($_GET['edit']) && $_GET['edit'] == 'details' ? ' class="active"' :'' ?> id="menu_edit"<?php if( User::isBoxHidden()){ echo ' style="display: none;"'; } ?>><a href="/user/editaccount.php?edit=details">Edit Contact Details</a></li>
							<?php if(User::hasPermission('Match')){ ?><li<?php echo $_SERVER['PHP_SELF']=='/user/editaccount.php' && isset($_GET['edit']) && $_GET['edit'] == 'match' ? ' class="active"' :'' ?>><a href="/user/editaccount.php?edit=match">Vehicle Match Preferences</a></li><?php } ?>
							<?php if(!User::hasPermission('Admin')){ ?><li<?php echo $_SERVER['PHP_SELF']=='/contact.php' ? ' class="active"' :'' ?>><a href="/contact.php">Contact Us</a></li><?php } ?>
							<?php if(User::hasPermission('Admin')){ ?><li<?php echo $_SERVER['PHP_SELF']=='/admin/'? ' class="active"' :'' ?>><a href="/admin/">MotoReach Admin</a></li><?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div id="orange_bottom"></div>
			
			<div id="ob_close"></div>
			<div id="ob_open"></div>
		</div>
		
		<?php } else { ?>
		<div id="orange_box" style="height: 50px;">
			<div class="orange_header" id="ql_header" style="float: left; position: absolute; z-index: 120; top: 10px; left: 50px;">member login</div>
			<?php 
			if($_SERVER['PHP_SELF']!='/login.php'){
				echo Site::drawForm('login', '/login.php');
				echo Site::drawHidden('formdata', 1);
				echo Site::drawHidden('loc', @$_REQUEST['loc']);
				echo Site::drawText('login_email', '', 'email', false, 'email');
				echo Site::drawPassword('login_password', '', 'password');
				echo Site::drawSubmit('submit_mini_login', 'Log In');
				echo Site::drawForm();
			}
			?>
			<div id="orange_bevel_sm" style="display: block;"></div>
			<div id="orange_top"></div>
			<div id="orange_inner" style="height: 24px;"></div>
			<div id="orange_bottom"></div>
		</div>
		<?php } ?>
		
		<?php } ?>
			<div id="inner_content">
			<?php echo $content?>
			<div style="clear: both;"></div>
			</div>
			
		</div>
         <div style="clear: both;"></div>
	</div>
     <div style="clear: both;"></div>
	 <?php if(!isset($_REQUEST['dialer'])){ ?>
	 
	<div id="footer">
	
		<div id="footer_left">
			<span class="footer_label">phone:</span> <span class="footer_text"><?php echo $_SESSION['l10n']['phone']?></span><br />
			<span class="footer_label"><?php echo $_SESSION['l10n']['country_id']==1?'fax:':'email'?>:</span> <span class="footer_text"><?php echo $_SESSION['l10n']['fax']?></span><br />
		</div>
		
		<div id="footer_right">
		<?php 
		if(User::hasPermission('Admin')){ 
			echo Site::drawForm('select_country', '', 'GET');
			echo Site::drawSelect('force_country', array('1'=>'Australia', '2'=>'Ireland'), $_SESSION['l10n']['country_id']);
			echo Site::drawSubmit('go','Change');
			echo Site::drawForm();
		}
		?>
		<span class="footer_label_nocufon">&copy;</span> <span class="footer_text"><?php echo date('Y') ?> MotoReach <?php echo $_SESSION['l10n']['country']?></span>
		
		<br />
		
		<span class="footer_text">
		<a href="/contact.php">[website help]</a> :: <a href="/contact.php">[contact us]</a> :: <a href="/about.php">[about us]</a></span>
		</div>
	<div style="clear: both;"></div>
	
	</div>
	<?php } ?>
    <div style="clear: both;"></div>
	
	
</div>

<div id="blocker"></div>
<div id="gate_blocker" style="display: none"></div>
<div id="gate_content">
<a href="http://www.motoreach.com?sel"><img src="/images/gateway_moto.png" /></a><a href="http://www.mymotoreach.com?sel"><img src="/images/gateway_public<?php echo $_SESSION['l10n']['country_code']=='IE'?'_ie':''?>.png" /></a>
</div>

<?php if(!isset($_GET['dialer'])) {?>

<div id="alert_box">
	<div id="alert_head_bar"></div>
	<div id="alert_text"></div>
	
	<img id="alert_box_ok" src="/images/button_sm_yes2.png" />
	<img id="alert_box_yes" src="/images/button_sm_yes.png" />
	<img id="alert_box_cancel" src="/images/button_sm_no.png" />
</div>


   <?php 
if(isset($is_owner)){
	echo Site::drawForm('edit_form', '', 'POST', false, true);
	echo Site::drawDiv('edit_form_left');
	echo Site::drawHidden('itemID', $item->data['ID']);
	echo Site::drawHidden('vid', $item->data['vid']);
	echo Site::drawHidden('model_id', $item->data['model_id']);
	echo Site::drawSelect('badge_id', $GLOBALS['model_badges'][$item->data['make'].'_'.$item->data['model']], $item->data['badge_id'], '', 'badge', true).BR;
	echo Site::drawSelect('series_id', $GLOBALS['model_series'][$item->data['make'].'_'.$item->data['model']], $item->data['series_id'], '', 'series', true).BR2;
	//echo Site::drawSelect('series_id', Site::getLookupTable('type_colours', 'id', 'colour', 'colour'), $item->data['colour_id'], '', 'colour', true).BR;

	echo Site::drawText('edit_amount', $item->data['startprice'], 'offers from').BR;
	echo Site::drawHidden('buyoutprice', $item->data['buyoutprice']);
	echo Site::drawText('spend', $item->data['spend'], 'spend').BR2;
	echo Site::drawSelect('build_month', Site::getShortMonthsArray(), $item->data['build_month'], 'Month', 'build date');
	echo Site::drawText('year', $item->data['year']).BR;
	echo Site::drawSelect('comp_month', Site::getShortMonthsArray(), $item->data['comp_month'], 'Month', 'compliance date');
	echo Site::drawText('comp_year', $item->data['comp_year']).BR2;
	echo Site::drawText('mileage', $item->data['mileage'], 'mileage').BR;

	for($i=1;$i<=12;$i++){
		$rego_time = mktime (12, 0, 0, date("n")+$i, 15, date("Y"));
		$rego_array[date('Y-m', $rego_time)] = date('Y-m', $rego_time);
	}

	echo Site::drawSelect('registration', $rego_array, $item->data['registration'], '', 'rego end', true).BR2;
	
	
	echo Site::drawSelect('import', array('No', 'Yes'), $item->data['import'], '', 'personal import', true).BR;
	

	echo Site::drawDiv();
	echo Site::drawDiv('edit_form_right');
	echo Site::drawSelect('colour_id', Site::getLookupTable('type_colours', 'id', 'colour', 'colour'), $item->data['colour_id'], '', 'colour', true).BR;
	echo Site::drawSelect('interior_type_id', Site::getLookupTable('type_interiors', 'id', 'interior', 'interior'), $item->data['interior_type_id'], '', 'interior', true).BR;
	echo Site::drawSelect('interior_colour_id', Site::getLookupTable('type_colours', 'id', 'colour', 'colour'), $item->data['interior_colour_id'], '', 'interior colour', true).BR2;
	
	echo Site::drawSelect('fuel_type_id', Site::getLookupTable('type_fuel', 'id', 'fuel', 'fuel'), $item->data['fuel_type_id'], '', 'fuel type').BR;
	echo Site::drawSelect('drive_type_id', Site::getLookupTable('type_drives', 'id', 'drive', 'drive'), $item->data['drive_type_id'], '', 'drive type').BR;
	echo Site::drawSelect('body_id', Site::getLookupTable('type_body', 'id', 'body', 'body'), $item->data['body_id'], '', 'body type').BR;
	echo Site::drawSelect('transmission_id', Site::getLookupTable('type_transmission', 'id', 'transmission', 'transmission'), $item->data['roof_type_id'], '', 'transmission').BR;
	echo Site::drawSelect('roof_type_id', Site::getLookupTable('type_roofs', 'id', 'roof', 'roof'), $item->data['roof_type_id'], '', 'roof').BR;
	echo Site::drawSelect('cylinders', array(''=>'select cylinders', 3=>3, 4=>4, 5=>5,6=>6,8=>8,10=>10,12=>12,16=>16), $item->data['cylinders'], '', 'cylinders').BR;
	echo Site::drawSelect('doors', array(''=>'select doors', 2=>2,3=>3,4=>4,5=>5), $item->data['doors'], '', 'doors').BR2;
	echo Site::drawTextArea('description', $item->data['description'], 'comments').BR2;
	echo Site::drawCustomSubmit('save', '_small_ns', '', true).BR2;
	echo Site::drawDiv();
	echo Site::drawDiv('', true);
	echo Site::drawForm();
 } ?>

<?php } ?>

<?php if(!isset($_REQUEST['dialer'])){ ?>
<script type="text/javascript">
    var _bugHerdAPIKey = 'b4db07ca-3358-40a3-b3c3-15cddb619abe';
    (function (d, t) {
        var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
        bh.type = 'text/javascript';
        bh.src = "//bugherd.com/bugherd.js?s=" + (new Date()).getTime();
        s.parentNode.insertBefore(bh, s);
    })(document, 'script');
</script>
<?php } ?>
</body>
</html>