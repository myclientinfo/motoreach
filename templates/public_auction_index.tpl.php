<script>
$(window).load(function(){
	
	<?php if(!isset($_GET['click'])){ ?>
	var rotate_frames = setInterval(function(){
	<?php } else { ?>
	$('div.frame').click(function(){
	<?php } ?>
		var current = $('div.frame:visible').attr('id').replace('frame', '');
		$('div.frame').fadeOut(2000);
		var new_frame = (current * 1) + 1;
		if(new_frame > 5) new_frame = 1;
		
		$('#frame'+new_frame).fadeIn(2000);
		$('#frame_position img').css('opacity', '0.5');
		$('#frame_position img#frame_pos_'+new_frame).css('opacity', '1');
	<?php if(!isset($_GET['click'])){ ?>
	}, 5000);
	<?php } else { ?>
	});
	<?php } ?>
	
	$('#frame_position img').click(function(){
		clearInterval(rotate_frames);
		var new_frame = $(this).attr('id').replace('frame_pos_', '');
		$('#frame_position img').css('opacity', '0.5');
		$('#frame_position img#frame_pos_'+new_frame).css('opacity', '1');
		$('div.frame').fadeOut(2000);
		$('#frame'+new_frame).fadeIn(2000);
	});
	
	
	var rotate_free = setInterval(function(){
		if($('#free_image_2').css('display') == 'none'){
			$('#free_image_2').fadeIn();
		} else {
			$('#free_image_2').fadeOut();
		}
		
	}, 1000);
});
</script>
<style>
#frame_position {position: absolute; z-index: 1000000; bottom: 27px; left: 45px; }
#frame_position img {opacity: 0.5; cursor: pointer; cursor: hand; margin-right: 3px;}
#frame_position img#frame_pos_1 {opacity: 1;}
</style>

<div id="headermain">
	<div id="frame_position">
	<img src="/images/frame_dot.png" id="frame_pos_1" />
	<img src="/images/frame_dot.png" id="frame_pos_2" />
	<img src="/images/frame_dot.png" id="frame_pos_3" />
	<img src="/images/frame_dot.png" id="frame_pos_4" />
	<img src="/images/frame_dot.png" id="frame_pos_5" />
	</div>
	<div id="frame1" class="frame">
		<a href="/sell_vehicle.php"><img src="/images/public_animation_1_left<?php echo $_SESSION['l10n']['country_code'] == 'IE'?'_ie':'' ?>.png" id="frame1_left" class="bg" alt="car"></a>
		<a href="/sell_vehicle.php"><img src="/images/public_animation_1_text.png" class="frame_text" alt="cash sale easy quick"></a>
		<a href="/sell_vehicle.php"><img src="/images/public_animation_gradient.png" class="gradient" alt=""></a>
		<a href="/sell_vehicle.php"><img src="/images/public_animation_1_person<?php echo $_SESSION['l10n']['country_code'] == 'IE'?'_ie':'' ?>.png" id="frame1_person" class="person" alt="girl holding large cash"></a>
	</div>
	
	<div id="frame2" class="frame">
		<a href="/contact.php"><img src="/images/public_animation_2_left.png" id="frame2_left" alt="no paperwork"></a>
		<a href="/contact.php"><img src="/images/public_animation_2_text<?php echo $_SESSION['l10n']['country_code'] == 'IE'?'_ie':'' ?>.png" class="frame_text" alt="no roadworthy dont spend money on a car you are selling"></a>
		<a href="/contact.php"><img src="/images/public_animation_gradient.png" class="gradient" alt=""></a>
		<a href="/contact.php"><img src="/images/public_animation_2_person.png" class="person" alt="girl holding key"></a>
	</div>
	
	<div id="frame3" class="frame">
		<a href="/sell_vehicle.php"><img src="/images/public_animation_3_left.png" id="frame3_left" alt="key privacy"></a>
		<a href="/sell_vehicle.php"><img src="/images/public_animation_3_text.png" class="frame_text" alt="no strangers keep your privacy when selling"></a>
		<a href="/sell_vehicle.php"><img src="/images/public_animation_gradient.png" class="gradient" alt=""></a>
		<a href="/sell_vehicle.php"><img src="/images/public_animation_3_person<?php echo $_SESSION['l10n']['country_code'] == 'IE'?'_ie':'' ?>.png" id="frame3_person" class="person" alt="stranger with cash at door"></a>
	</div>
	
	<div id="frame4" class="frame">
		<a href="/about.php"><img src="/images/public_animation_4_left.png" id="frame4_left" alt="big tick"></a>
		<a href="/about.php"><img src="/images/public_animation_4_text.png" class="frame_text" alt="loans paid out no hassle"></a>
		<a href="/about.php"><img src="/images/public_animation_gradient.png" class="gradient" alt=""></a>
		<a href="/about.php"><img src="/images/public_animation_4_person.png" id="frame4_person" class="person" alt="satisfied person"></a>
	</div>
	
	<div id="frame5" class="frame">
		<a href="/sell_vehicle.php"><img src="/images/public_animation_5_left.png" id="frame5_left" alt="car for people to buy"></a>
		<a href="/sell_vehicle.php"><img src="/images/public_animation_5_text.png" class="frame_text" alt="no time wasters your tyres dont need kicking"></a>
		<a href="/sell_vehicle.php"><img src="/images/public_animation_gradient.png" class="gradient" alt=""></a>
		<a href="/sell_vehicle.php"><img src="/images/public_animation_5_person.png" class="person" alt="person at desk waiting for buyers"></a>
	</div>
	
</div>

<!-- B. MAIN -->
<div class="main">

<!-- B.1 MAIN CONTENT -->
<div class="main-content">
  <!-- Content unit - Three columns -->

  <?php echo $miniform?>

  <div class="column3-unit-main">
	
	<?php if(true){ ?>
	<div id="free_image">
		<!--<img src="/images/free_image_1_<?php echo strtolower($_SESSION['l10n']['country_code']) ?>.jpg" />
		<img id="free_image_2" src="/images/free_image_2_<?php echo strtolower($_SESSION['l10n']['country_code']) ?>.jpg" />-->
		
		
		<!--<p style="font-size: 52px">DEALERS</p>
		<p style="font-size: 47px">ALL OVER</p>-->
		<p>TRY IT NOW</p>
		<div id="free_image_2">
		<?php if($_SESSION['l10n']['country_code']=='AU'){ ?>
			<p style="font-size: 90px;">100%</p>
			<p style="font-size: 90px;">FREE</p>
		<?php } else {?>
			<p style="font-size: 85px;">ONLY</p>
			<p style="font-size: 67px;">&euro;19.95</p>
			<!--<p style="font-size: 22px;">IRELAND ARE</p>
			<p style="font-size: 53px;">WAITING</p>
			<p style="font-size: 33px;">FOR YOUR CAR</p>-->
		<?php } ?>
		</div>
		
		
	</div>
  <?php } ?>
	<div id="dealer_header">DEALERS HAVE CUSTOMERS WAITING FOR ALL TYPES OF CARS</div>

	<p>By using MotoReach to sell your car you place it directly in front of the dealers that have buyers already lined up for a vehicle just like yours, meaning you'll get the best possible price. You could sell for as much or more than selling privately without the hassle and inconvenience.</p>
	
	<p style="margin-bottom: 0px;">Just follow these simple steps:</p>
	
	<img id="public_list_arrow" alt="enter your vehicle details into our matching system" src="/images/public_list_arrow.png" />
	<ol id="main_list" start="2">
		<li><span>Our patented system instantly matches your car to dealers with waiting buyers.</span></li>
		<li><span>Multiple dealers will then call you directly with offers on your vehicle, giving you the best possible price on your vehicle.</span></li>
		<li><span>Make arrangements with the best dealer to transfer over the car.</span></li>
		<li><span>Drop off your car to the dealer, and pick up your cash!</span></li>
		<li><span>Easy. Quick. Cash.</span></li>
	</ol>
	
	<?php if($_SESSION['l10n']['country_code']=='IE'){ ?>
	<p class="feature">DEALERS ALL OVER IRELAND ARE WAITING FOR YOUR CAR.</p>
	<?php } ?>

  </div>
	<div id="lower_box" style="display: none;">
		<img style="float:left;" alt="lower news section" src="/images/public_lower_box_photo.png">
		<div id="lower_box_text">
			<h2>MyMotoReach Expands</h2>
			
			<p>Traders please note:</p>
			
			<p><b>1st March 2013</b> - MyMotoReach expands into the UK, adding to our extensive network of dealers.</p>

		</div>
	</div>
	
</div>
</div>
             
