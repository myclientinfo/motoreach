<script type="text/javascript" src="/js/jquery.countdown.min.js"></script>

<?php
//$GLOBALS['debug']->printr($item->data);
$user = $_SESSION['auction']->user;
$is_owner = ($user->ID == $item->userID) ? true : false;
$has_bid = false;
$latest_bid = array();
foreach($history as $h){
	if($h['userID'] == $user->ID && $h['type'] == 'Request Info') $has_bid = true;
}

$length_seconds = Site::getLookupTable('auction_lengths', 'id', 'lis', 'id', false, false);
?>
	<script type="text/javascript">
	var open = <?php echo $item->data['status'] == 'Active' && $item->data['auction_end'] > time() ?  'true' : 'false'?>;
	var extended = <?php echo $item->data['extended'] ? 'true' : 'false' ?>;
	$(document).ready(function(){
	
		var userID = <?php echo $user->ID ?>;
		
		<?php if($is_owner){ ?>
		
		$('#edit_optional_details').click(function(e){
			//console.log('clicked');
			$('#blocker').css({width: $(document).width(), height: $(document).height() } );
			
			hpos = ($(window).width() / 2) - ($('#edit_form').width() / 2);
			vpos = $(document).scrollTop() + (($(window).height() / 2) - ($('#edit_form').height() / 2));
			
			$('#edit_form').css({top: vpos+'px', left: hpos+'px', position: 'absolute', 'z-index': '100000000'});
			$('#edit_form input').css({'z-index': '1000000000'});
			$('#blocker').css('opacity', '0.3');
			$('#blocker').fadeIn();
			
			$('#edit_form').fadeIn();
			
		});
	
		$('#owner_actions').change(function(e){
			
			if($('#owner_actions').val()=='extend') $('#auctionlength, #auctionlength_label').show();
			else $('#auctionlength, #auctionlength_label').hide();
			
			if($('#owner_actions').val()=='notify') $('#owner_actions_notify').show();
			else $('#owner_actions_notify').hide();
			
		});
		
		$('#action_submit').click(function(e){
			e.preventDefault();
			$.post("/api/itemaction.php", $("#actionform").serialize(), function(data){
				$('.items').prepend(data);
				if($('#owner_actions').val() == 'sell'){
					$('#text_status').text('Sold');
					$('#actionform').hide();
					$('#edit_optional_details').hide();
				} else if($('#owner_actions').val() == 'extend') {
					$('#actionform').hide();
					window.location = '<?php echo str_replace(array('&new', '&extend', '&wd'), '', $_SERVER['REQUEST_URI']) ?>&extend';
				} else if($('#owner_actions').val() == 'withdraw') {
					$('#text_status').text('Withdrawn');
					window.location = '<?php echo str_replace(array('&new', '&extend', '&wd'), '', $_SERVER['REQUEST_URI']) ?>&wd';
				} else {
					//poll_bids();
				}
			});
		});
		
		$('#submit_button').click(function(e){
			$.post("/api/itemedit.php", $("#edit_form").serialize(), function(data){
				window.location = '<?php echo str_replace('&new', '', $_SERVER['REQUEST_URI']) ?>';
			});
		});
		
		<?php echo isset($_GET['new']) ? 'newAlert(\'Your vehicle has been listed successfully.\', \'alert\');':''; ?>
		<?php echo isset($_GET['extend']) ? 'newAlert(\'Your vehicle listing has been extended successfully.\', \'alert\');':''; ?>
		<?php echo isset($_GET['wd']) ? 'newAlert(\'Your vehicle listing has been withdrawn successfully.\', \'alert\');':''; ?>
		
		<?php } else { ?>
		
		
		
		$('#submit_button_req').click(function(e){
			if(!is_approved){
				newAlert('Your account is not yet approved. You can not yet request dealer contact information.', 'stop');
			} else {
				place_bid();
			}
		});
		
		$('#buyout_button').click(function(e){
			$('#amount').val($('#buyout_temp').val());
			$('#formdata').val('buyout');
			$('#is_buyout').val(1);
			$('#auction_ends').countdown('pause');
			$('#auction_ends').text('Sale Closed').show();
			$('#text_status').text('Sold');
			
			place_bid();
			open = false;
			
		});
		
		
		<?php if(isset($_GET['request_contact'])){ ?>
		$('#submit_button_req').trigger('click');
		<?php } ?>
			
		<?php } ?>
		
		var poll_bids = function(){

			$.post("/api/recentbids.php", $("#bidform").serialize(), function(data){
				if(data == null) return false;
				
				if(data.html.length > 100){
					$('span.wb').hide();
					$('tr.temp').hide();
					if(open){
						if(data.data.userID != userID){
							//$('#bidform:hidden').slideDown();
							$('#you_win').hide();
						} else {
							$('#bidform').slideUp();
							$('#you_win').show();
						}
					}
					if(data.data.typeID==2){
						var rgx = /(\d+)(\d{3})/;
						form_num = data.data.amount.replace(rgx, '$1' + ',' + '$2');
						$('#amount').val(data.data.amount*1);
						$('#current_price').html('<?php echo $_SESSION['l10n']['currency_symbol'] ?>'+form_num);
					}
					$('.items').html(data.html);	
				}
				
			}, "json");
		}
		
		$(function () {
			
			if(!open){
				$('#auction_ends').text('Sale Closed').show();
				return false;
			}
			var auction_end = new Date(<?php echo date('Y', $item->data['auction_end']) ?>, <?php echo date('n', $item->data['auction_end'])-1 ?>, <?php echo date('j', $item->data['auction_end']) ?>, <?php echo date('G', $item->data['auction_end']) ?>, <?php echo (int)date('i', $item->data['auction_end']) ?>, <?php echo (int)date('s', $item->data['auction_end']) ?>);
			/*$('#auction_ends').countdown({
					until: auction_end, 
					format: 'dhms', 
					labels: ['yr', 'mth', 'wk', 'd', 'hr', 'm', 's'],
					labels1: ['yr', 'mth', 'wk', 'd', 'hr', 'm', 's'],
					onTick: checktick,
					onExpiry: closeAuction
				}
			);*/
		});
		
		
		
		
		//poll_bids();
	});
	
	</script>
	
	<style>
	#item_outer #comments_label {
		width: 80px;
		text-align: left;
	}
	
	#comments {
		display: inline-block;
		width: 357px;
	}
	
	#submit_button_req {
		margin-right: 100px;
	}
	
	#submit_button_req span, #submit_button span{
		margin-top: 7px;
		display: block;
		
	}
	
	#display_item_opt_right #amount{
		font-size: 20px;
		margin-bottom: 5px;
		float: left;
		width: 150px;
		height: 20px;
		margin-left: 15px;
		margin-top: 15px;
	}
	
	#submit_button {
		padding-top: 6px;
		background-repeat: no-repeat;
	}
	
	#display_item_opt_right #amount_label{
		width: 50px;
		font-size: 80px;
		text-align: left;
		float: left;
		margin-left: 13px;
		position: relative;
		top: 2px;
		margin-top: 15px; 
	} 
	
	.myBlurredClass {color: #CCCCCC;}
	.myActiveClass {color: #000000;}

	#item_public_warning {
		font-size: 12px;
	}
	</style>
	<div id="inner_content_blue">
    <h2 id="vehicle_title">Vehicle #<?php echo $item->data['ID']?>: <?php echo $item->data['year']?> <?php echo $item->data['make']?> <?php echo $item->data['model']?> <?php echo $item->data['badge']?> <?php echo $item->data['series']?></h2>
	<?php if($is_owner && $item->data['status'] == 'Active'){ ?><span id="edit_optional_details">[edit]</span><?php } ?>
	<br style="clear: both;" />
	
    <p id="breadcrumb" style="display: none;"><a href="browse.php">Browse</a>
        :: <a href="browse.php?mk=<?php echo $item->data['make'] ?>"><?php echo $item->data['make'] ?></a>
        :: <a href="browse.php?mk=<?php echo $item->data['make'] ?>&md=<?php echo $item->data['model'] ?>"><?php echo $item->data['model'] ?></a></p>

    <?php   
	if($message != 'AUCTION_NO_ITEM_FOUND'){ ?>
		
		<div id="item_outer">
		
		<div class="form_left">
			<h3>interested?</h3>

			<p>Hit the request button and we will send you the direct contact details of this vehicle's seller, who can address any specific questions and negotiate an arrangement.</p>
			
		</div>
		
		<?php if($item->data['is_lot']){ ?>
		<div style="margin: 10px;margin-left: 285px; width: 600px;">
		<p>This vehicle is part of a group sale, and includes multiple vehicles, with potentially varied details. </p>
		</div>	
		<?php }	?>
		
		<?php if($item->data['user_type_id'] =='5'){?>
		<div style="margin: 10px;margin-left: 285px; width: 600px; font-size: 18px;">
		<p>This vehicle is being listed by a member of the public. Remember that 70% of sellers are also wishing to buy a car, so we recommend treating this seller as a potential prospect.</p>
		</div>	
		<?php } ?>
		<div id="submit_item_opt_left">
			
			<div id="core_info">
				<?php
				echo Site::drawPlainText('make', $item->data['make'], 'make').BR;
				echo Site::drawPlainText('model', $item->data['model'], 'model').BR;
				?>
			</div>
			
			<div id="optional_details_text">
				
				<?php
				if( $item->data['badge']!='' ) echo Site::drawPlainText('badge', $item->data['badge'], 'badge').BR;
				if( $item->data['series'] != '' ) echo Site::drawPlainText('series', $item->data['series'], 'series').BR2;
				$month_array = Site::getShortMonthsArray();
				
				if($_SESSION['l10n']['country_code']!='IE' && $item->data['user_type_id']!=5){
					echo Site::drawPlainText('year', ($item->data['build_month']=='111'?'Various':$month_array[$item->data['build_month']]) . ' ' . $item->data['year'], 'build date').BR;
					echo Site::drawPlainText('comp_year', ($item->data['comp_month']=='111'?'Various':$month_array[$item->data['comp_month']]) . ' ' . $item->data['comp_year'], 'compliance date').BR;
				} else {
					echo Site::drawPlainText('year', $item->data['year'], 'year').BR;
				}
				
				echo Site::drawPlainText('mileage', $item->data['mileage'].' km', 'mileage').BR;
				
				if($_SESSION['l10n']['country_code']=='IE'){
					echo Site::drawPlainText('nct_month', $item->data['nct_month'].' '.$item->data['nct_year'], 'NCT info').BR2;
				} else echo BR;
				
				echo Site::drawPlainText('import', ($item->data['import']?'Yes':'No'), 'personal import').BR;
				
				if($item->data['user_type_id']!=5 && $item->data['spend'] != '') echo Site::drawPlainText('spend', (substr($item->data['spend'], 0, 1)==$_SESSION['l10n']['currency_symbol']||$item->data['spend']=='various'||$item->data['spend']=='Various'?'':$_SESSION['l10n']['currency_symbol']).$item->data['spend'], 'to spend').BR;
				
				if($item->data['registration']==0){
					$rego = 'No rego';
				} else if($item->data['is_lot'] && $item->data['registration']=='111'){
					$rego = 'Various';
				} else {
					$rego = $item->data['registration'];
				}
				
				if($_SESSION['l10n']['country_code']!='IE') echo Site::drawPlainText('registration', $rego, 'rego ends').BR2;
				
				echo Site::drawPlainText('colour',  $item->data['is_lot'] && $item->data['colour_id'] == '111' ? 'Various' : $item->data['colour'], 'colour').BR;
				echo Site::drawPlainText('interior', $item->data['is_lot'] && $item->data['interior_type_id'] == '111' ? 'Various' : $item->data['interior'], 'interior').BR;
				echo Site::drawPlainText('interior_colour', $item->data['is_lot'] && $item->data['interior_colour_id'] == '111' ? 'Various' : $item->data['interior_colour'], 'interior colour').BR2;
				
				echo Site::drawPlainText('fuel', $item->data['fuel'], 'fuel').BR;
				echo Site::drawPlainText('transmission', $item->data['transmission'], 'transmission').BR;
				echo Site::drawPlainText('roof', $item->data['roof'], 'roof').BR;
				echo Site::drawPlainText('body', $item->data['body'], 'body').BR;
				if($_SESSION['l10n']['country_code']!='IE')echo Site::drawPlainText('drive', $item->data['drive'], 'drive').BR;
				echo Site::drawPlainText('doors', $item->data['doors'], 'doors').BR;
				if($_SESSION['l10n']['country_code']!='IE') echo Site::drawPlainText('cylinders', $item->data['cylinders'], 'cylinders').BR2;
				?>
				
			</div>
			

			
			
		</div>
		
		
		<div id="display_item_opt_right">
			
			<?php 
			//echo date('d m Y @ h:i');
			//echo '<pre>';
			//print_r(date(DATE_TIME, $item->data['auction_end']));
			echo Site::drawPlainText('auction_starts', date(DATE_TIME, $item->dateentered), 'Listed On').BR;
			echo Site::drawPlainText('auction_ends', date(DATE_TIME, $item->data['auction_end']), 'Listed Until').BR2;
			if($_SESSION['l10n']['country_code']!= 'IE'){
				echo Site::drawPlainText('city', $item->data['city'], 'Location').', '; 
				echo Site::drawPlainText('region', $item->data['region'], '').BR2;
			} else {
				echo Site::drawPlainText('region', $item->data['region'], 'Location').BR2;
			}
			if($item->data['startprice']) echo Site::drawPlainText('startprice', $_SESSION['l10n']['currency_symbol'].number_format($item->data['startprice']), 'Offers From').BR;
			if($item->data['buyoutprice']) echo Site::drawPlainText('buyoutprice', $_SESSION['l10n']['currency_symbol'].number_format($item->data['buyoutprice']), 'Own It For').BR2;
			
			if($item->data['user_type_id'] == 5) echo Site::drawPlainText('sell_reason', $item->data['sell_reason']?'Yes':'No', 'Sales Prospect').BR2; 
			if($item->description != '') echo Site::drawPlainText('comments', nl2br(str_replace('\r\n', "\n", $item->description)), 'comments').BR2;
			
			if($is_owner){
				echo Site::drawDiv('item_action_panel');
				$winning_bid = Auction::getWinningBid($item->ID);
				
				//if($item->data['status'] == 'Active'){
					
					$actions_array = array();
					
					$actions_array = array('sell'=>'Confirm Sold', 'extend'=>'Extend Listing', 'withdraw'=>'Withdraw Listing');
					
					if( $item->data['count_bids'] == 0 ) unset($actions_array['sell'], $actions_array['notify']);
					//if( $item->data['extended'] == 1 ) unset($actions_array['extend']);
					if( $item->data['status'] != 'Active' ) unset($actions_array['extend'], $actions_array['withdraw']);
					
					if(!empty($actions_array)){
						echo Site::drawForm('actionform', '', 'POST', false, true);
						echo Site::drawHidden('ID', $item->data['ID']);
						echo Site::drawHidden('is_buyout', 0);
						echo Site::drawHidden('winning_bid', @$winning_bid['ID']);
						echo Site::drawHidden('amount', @$winning_bid['amount']);
						echo Site::drawSelect('owner_actions', $actions_array, '', '', 'This listing');
						echo Site::drawSelect('auctionlength', Site::getLookupTable('auction_lengths', 'id', 'length', 'lis'), '', '', 'extend for');
						echo Site::drawSelect('owner_actions_notify', array('top5'=>'Top 5', 'top10'=>'Top 10'));
						//if($item->data['buyoutprice']) echo Site::drawButton('action_submit', 'Go').BR2;
						echo Site::drawSubmitImage('action_submit', '/images/button_sm_go.png').BR2;
						echo Site::drawForm();
					}
				?>
			</div>
			
			<?php 
			}
			
			if(@$latest_bid['userID'] == $user->ID){
				echo '<span id="you_win">You are the winning bidder.</span>';
				?>
				<form id="bidform" action="" method="post" style="display: none;" onclick="return false">
			<?php
			} else if($item->data['status'] != 'Active' || $is_owner || $item->data['auction_end'] < time() || ($has_bid && !isset($_GET['offer'])) ){
			?>
				<form id="bidform" action="" method="post" style="display: none;" onclick="return false">
			<?php } else {
				echo Site::drawForm('bidform', '', 'POST', false, true);
			}
			
			$minimum_bid = ($item->data['count_bids']>0?$item->data['highest_bid']:$item->data['startprice']);
			
			if($item->data['user_type_id'] == 5){
				echo '<div id="item_public_warning">This vehicle is from the MyMotoReach public site.</div>';
			}
			
			echo Site::drawHidden('itemID', $item->ID);
			echo Site::drawHidden('formdata', 'bid');
			echo Site::drawHidden('is_buyout', '0');
			echo Site::drawHidden('action_type', 'request');
			
			echo Site::drawHidden('winning_bid', @$winning_bid['ID']);
			echo Site::drawHidden('buyout_temp', $item->data['buyoutprice']);
			echo Site::drawHidden('winning_bidder', @$latest_bid['userID']);
			
			if(isset($_GET['offer'])){
				echo Site::drawHidden('offer', 1);
				echo Site::drawText('amount', 'make an offer', 'offer?');
				echo Site::drawCustomSubmit('make an offer', '_lg_ns', '_req', true);
			} else {
				echo Site::drawHidden('offer', 0);
				echo Site::drawCustomSubmit('request seller contact', '_lg_ns', '_req', true);
			}
			
			echo Site::drawForm();
			echo Site::drawDiv('place_bid_text').Site::drawDiv();
			?>

		</div>
		
		<div style="clear: both"></div>
		
		</div>
		<?php 
		$item->image = str_replace('images', 'images/uploads',$item->image );
		if((file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$item->image) && !is_dir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$item->image))||!empty($item->description)){ ?>
		<div id="item_optional">
			
			<?php if(file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$item->image) && !is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$item->image)){ ?>
				<img style="float: left; margin-right: 15px; margin-bottom: 15px; border: 2px solid white;" alt="Image of <?php echo $item->name ?>" class="item_image" src="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $item->image)?>" />
			<?php } ?>
			
		</div>
		<div style="clear: both"></div>
		<?php } ?>
		</div>
		
		<div id="item_history" style="display: none;">
			<h2>Item History</h2>
			<table class="items">
			
			<?php //echo $history_block?>
			</table>
		</div>
		<script>
        //var t = setTimeout(poll_bids(), 3000);
        </script>
	<?php } ?>
   <div id="defaultCountdown"></div>
 
