	<script>
	var anim_counter = 0;
	var box = 'buy';
	jQuery(document).ready(function(){
		
		var t = setInterval("move_animation()", 4000);
		
		<?php if(!isset($_SESSION['sel'])){ ?>
		gateBlock();
		<?php } ?>
	});
	
	function move_animation(){
		return false;
		if(anim_counter == $('.anim_entry', $('#anim_'+box)).length - 1){
			$('#anim_'+box).hide();
			$('#anim_back').animate({top: 20}, 1000, function(){
				anim_counter = 0;
				box = box == 'buy' ? 'sell' : 'buy';
				$('#anim_'+box).show();
			});
			
		} else {
			$('#anim_back').animate({top: '+=50'}, 1000, function() {
				// Animation complete.
				anim_counter += 1;
				//console.log(anim_counter);
				
			});
		}
	}
	
	//alert('this');
	
	</script>
	
	<style>
	#anim_outer {position: relative; width: 350px; height: 450px; border: 0px solid black; float: right; margin-left: 60px; margin-right: 10px;}
	.anim_entry {display: block; color: white; height: 40px; padding-left: 10px; width: 350px; font-size: 16px; position: relative; z-index: 20;}
	.anim_gap {height: 10px; text-align: center;width: 350px; }
	.anim_entry span {display: block; padding-top: 11px;}
	#anim_back {display: block; position: absolute; z-index: 10; top: 20px; }
	#anim_sell .anim_entry {color: white; }
	#anim_buy, #anim_sell {
		margin-top: 20px;
	}
	#inner_content {
		padding-bottom: 0px;
	}
	#hero_car {
		position: absolute;
		z-index: 5;
		left: 0px;
		top: 22px;
	}
	#index_header_text {
		position: absolute;
		top: 30px;
		left: 340px;
		width: 400px;
		
	}
	
	#index_header_text p {
		margin-top: 10px;
		color: white;
		position: relative;
		z-index: 6;
	}
	
	#index_top_spacer {
		height: 760px;
		width: 100%;
		
	}
	#header_text {
		position: relative;
		left: -40px;
		
	}
	
	#stop {
		position: absolute;
		right: 20px;
		
	}
	
	#index_text_content {
		position: absolute;
		top: 175px;
		left: 340px;
		z-index: 200;
		width: 590px;
	}
	
	.list_car{
		float: left;
	}
	#how_you_save {
		background-image: url(/images/how_save_bg.png);
		width: 273px;
		height: 354px;
		position: absolute;
		top: 334px;
		background-repeat: no-repeat;
		background-position: 0px 21px;
	}
	
	#how_save {
		position: relative;
		left: 19px;
	}
	#when_selling ul, #when_buying ul {
		color: white;
		list-style-type: disc;
		margin-left: 15px;
		padding-left: 10px;
		font-size: 18px;
		margin-top: 5px;
		width: 234px;
	}
	
	#when_selling ul li, #when_buying ul li {
		margin-bottom: 10px;
	}
	
	#how_save_benefits_link {
		position: absolute;
		bottom: 15px;
		left: 15px;
	}
	</style>
<div id="inner_content_white" style="padding-bottom: 0px; height: 975px; margin-bottom: 0px; position: relative; background-image: url(/images/white_top_gradient.png);">

	<img src="/images/hero_car.png" id="hero_car" />

	<div id="index_header_text">
		<img src="/images/header_text.png" id="header_text" />
		<p>MotoReach introduces <?php echo $_SESSION['l10n']['term_local_state_interstate'] ?> <?php echo $_SESSION['l10n']['term_wholesale'] ?> sellers and buyers, <a href="about_benefits.php">saving the time and cost of using a third party</a>.</p>
	</div>
	<img src="/images/stop.png" id="stop" style="display: none;" />

	<div id="index_top_spacer"></div>

	<div id="how_you_save">
		<img src="/images/how_save.png" id="how_save" />
	
		<div id="when_selling">
			<img src="/images/when_selling.png" id="ws" />
<ul>
	<li>Negotiate directly with buyer</li>
	<li>Accurately target interested buyers</li>
	<li>Instant connection with buyers</li>
	<li>Deal with trade-ins quickly and profitably</li>
	<li>Rotate out existing aged stock</li>
</ul>		
		</div>
		
		<div id="when_buying" style="display: none;">
			<img src="/images/when_buying.png" id="wb" />
<ul>			
	<li>Negotiate directly with seller</li>
	<li>Instant access to vehicles as they are traded</li>
	<li>Access vehicles from a large range of dealers</li>
	<li>Minimise time away from your business</li>
	<li>Ability to specify vehicles you're interested in</li>
</ul>			
		</div>
		
		<a href="/about_benefits.php"><img src="/images/more_benefits.png" id="how_save_benefits_link" /></a>
		
	</div>


	<div id="index_text_content">
		<h3>HOW IT WORKS</h3>
		
		<div style="float: right; text-align: center; border: 10px solid #15008b; border-top-width: 40px; ">
		
			<h2 style="color: orange; margin: 0px; position: absolute; top: 36px;">Proud Partners With</h2>
			<img src="/images/dublin_auctions.png"><br>
			
		</div>

		<p><a href="/register.php">Become a member now</a></p>
		
		<p>Joining the MotoReach network now gives you access to hundreds of trade vehicles from dealers and the public. MotoReach instantly puts quality stock just a click and a call away. 70% of people selling cars will be replacing them, so a stock purchase may well turn into a sale as well. All you have to do is check your email for new vehicles which are regularly listed by the public, click the ones that interest you and then call the number you are sent. </p>
				
		<p>Free leads from members of the public wanting to sell/trade-in cars.</p> 
		
		<p>Information on trade vehicles being sold by other dealers.</p>
		
		<p>Buy and sell vehicles to and from other dealers.</p>
		
		<img src="/images/list_car1.png" class="list_car" /> <strong style="color: #15008b;">Buy vehicles</strong>

		<ol style="margin: 10px 30px;  margin-left: 30px; list-style-type: decimal; position: relative; left: 30px;">
			<li>receive instant access to motor vehicles being sold by dealers</li>
			<li>request and receive contact details of seller</li>
			<li>contact dealer direct to negotiate and buy</li>
		</ol>
		<br />

		<img src="/images/list_car2.png" class="list_car" /><strong style="color: #15008b;">Sell vehicles</strong>

		<ol style="margin: 10px 30px;  list-style-type: decimal;position: relative; left: 30px;">
			<li>list a vehicle for sale</li>
			<li>instantly receive contact details of interested buyers</li>
			<li>contact dealer directly to negotiate and sell</li>
		</ol>
		<br />
		
		<p><a href="/register.php">Connect to a network of dealers around the country</a></p>

		<p><b>As a member</b> MotoReach will send you the details of vehicles as they are being sold in real time, with instant access to the seller and the ability to negotiate directly.</p>	

		<p><b>As a member</b> you can sell a vehicle. MotoReach will present your vehicle instantly to all interested dealers.</p>

		<p>MotoReach instantly exchanges direct contact details of buyers and sellers as requested, in real time.</p>

		<a href="/about_benefits.php"><img src="/images/button_how_save_lg.png" /></a>
	</div>

</div>

