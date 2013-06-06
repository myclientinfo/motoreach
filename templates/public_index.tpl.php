<!DOCTYPE HTML>
<html lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<?php 
	$location = str_replace(array('/', '.php', '.html'), '', $_SERVER['REQUEST_URI']);
	
	switch($location){
		case 'index': $title = ' - Instantly match your car to licensed dealers with customers waiting.'; break;
		case 'sell_vehicle': $title = ' - Sell With myMotoReach'; break;
		case 'about': $title = ' - About MotoReach'; break;
		case 'contact': $title = ' - Contact MotoReach'; break;
		case 'confirm_sale': $title = ' - Credit Card Response'; break;
		case 'terms_and_conditions': $title = ' - Terms and Conditions'; break;
		case 'privacy_disclaimer': $title = ' - Privacy Policy'; break;
		default: $title = ''; break;
	}
	?>
	<title>myMotoReach<?php echo $title ?></title>
	<meta name="description" content="Instantly match your car to licensed dealers with customers waiting. Easy. Quick. Cash." />
	<meta name="keywords" content="australia ireland sell buy instant car sale online " />
	<meta http-equiv="Content-Language" content="en"/>
	<link rel="stylesheet" href="/css/reset.css" />
	<link rel="stylesheet" href="/css/public_style.css" />
	<link rel="stylesheet" href="<?php echo $p ?>/css/excite-bike/jquery-ui-1.8rc3.custom.css" type="text/css" media="all" />
	<script src="/js/jquery-1.7.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/js/script.js"></script>
	<script type="text/javascript" src="/js/cufon-yui.js"></script>
	<script type="text/javascript" src="/js/hv.font.js"></script>
	<script type="text/javascript" src="/js/condensed.font.js"></script>
	<script type="text/javascript" src="/js/public_cufon_config.js"></script>
	
	<script type="text/javascript">	
	var project = "<?php echo $GLOBALS['project']?>";
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-24536513-1']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
	<script src="/js/jquery-ui-1.8rc3.custom.min.js"></script>
	<script type="text/javascript" src="/js/vehicles.php"></script>
</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

<body>
	<!-- Main Page Container -->
	
	<div class="page-container">
		
		<h1><a href="index.php" title="Go to Start page"><img src="/images/public_logo.png" alt="My MotoReach Logo"/></a></h1>
		
		<div id="intro_text">Instantly match your car to licensed dealers with customers waiting.<br /><br />Easy. Quick. Cash.</div>
		
		<div class="nav">
		<?php echo $menu; ?>
		</div>

	<?php echo $content?>


    <!-- C. FOOTER AREA -->      
	
	
	
    <div class="footer">
		<div class="footer_text">
		<ul>
			<li><a href="/index.php">Home</a></li>
			<li><a href="/register.php">Sell Your Vehicle</a></li>
			<li><a href="/contact.php">Contact Us</a></li>
			<li><a href="/terms_and_conditions.php">Terms and Conditions</a></li>
		</ul>
		</div>
		<div class="hrline"></div>
		<div class="footer_text">
		<ul>
			<li>&copy; <?php echo date('Y') ?> MotoReach</li>
			<li>Phone: <?php echo $_SESSION['l10n']['public_phone']?></li>
			<li><?php echo $_SESSION['l10n']['country_code']=='IE'?'email': 'fax'?>: <?php echo $_SESSION['l10n']['fax']?></li>
		</ul>
		</div>
    </div>      
 </div> 
  
<div id="blocker"></div>

<div id="gate_blocker" style="display: none"></div>
<div id="gate_content">
<a href="http://www.motoreach.com?sel"><img src="/images/gateway_moto.png" alt="motoreach gateway sell vehicle dealers rental"/></a><a href="http://www.mymotoreach.com?sel"><img src="/images/gateway_public<?php echo $_SESSION['l10n']['country_code']=='IE'?'_ie':''?>.png" alt="motoreach gateway sell vehicle dealers rental"/></a>
</div>    

<div id="alert_box">
	<div id="alert_head_bar"></div>
	<div id="alert_text"></div>
	
	<img id="alert_box_ok" src="/images/button_sm_yes2.png" alt="ok"/>
	<img id="alert_box_yes" src="/images/button_sm_yes.png" alt="yes"/>
	<img id="alert_box_cancel" src="/images/button_sm_no.png" alt="cancel"/>
</div>

</body>
</html>



