<?php 
//echo (int)$duplicate;
if($duplicate){
	echo '<a style="color: blue; text-decoration: underline;" href="users.php?ID='.(str_replace('ERROR: Email address already used for user id ','',$duplicate)).'"><h3>'.$duplicate.'</h3></a>';
} else {
$_GET['no_buttons'] = '';
?>
<script>
var user_state = "<?php echo @$user['state'] ?>";

jQuery(document).ready(function(){
	
	get_prefs(<?php echo $user['ID']?>);
	
	$('h3').click(function(){
	
		var correct_id = $(this).attr('id').replace('_header', '_outer');
		//console.log();
	
		$('#'+correct_id).toggle();
		
	
	});
	
});

</script>
		
<style>
.year {width: 40px; margin-right: 2px;}
.range {width: 20px; margin-left: 5px;}
.mileage {width: 50px; margin-left: 5px;}

#from_year {margin-left: 5px;}
#vehicles_outer, #overview_outer {width: 300px; float: left; margin: 5px;}
#matches, #vehicles, #overview { overflow: auto; }

#matches_outer {width: 650px; margin: 0px auto; }
#matches ul, #vehicles ul {margin-left: 20px;	margin-top: 0px; list-style-type:disc; margin-bottom: 10px;}
#vehicle_matches {width: 95%; margin: 0px auto;}
#add_prefs {padding: 15px; background-color: #ebebeb; border: 1px solid #000000; width: 400px; float: left; margin-right: 20px; position: relative;}
#match_text_description {background-color: white; margin: 0px; padding: 5px; border: 1px solid #999999; margin-bottom: 5px;}

#matches .match_prefs_list {width: 300px; float: left; margin: 5px;}

#details_outer, #matches_outer {display: none;}

#outer_info_box {
	width: 650px;
	margin: 0px auto;
	font-size: 12px;
}

h3 { cursor: pointer; cursor: hand;  }

span.text {color:#FF7F00; font-size: 18px; float: left;}



</style>

<div id="outer_info_box">

<a href="items.php?auction_id=0&user_id=<?php echo $user['ID'] .(isset($_GET['dialer'])?'&dialer':'') ?>" style="float: right; font-size: 15px; position: relative; left: -400px; font-weight: bold;">Add New</a>
<h3 id="details_header">User Overview</h3>
<div id="details_outer">
	<div id="overview_outer">
		
		<div id="overview">
		<?php
		$state_array = Site::getLookupTable('states', 'id', 'state', 'id', true);
		?>
			<b>Signup:</b> <?php echo date('j M Y', strtotime($user['signup_time']))?><br/><br/>
			
			<b>Contact:</b> <?php echo $user['fullname'] ?><br/>
			<b>Mobile:</b> <?php echo $user['mobile'] ?><br /><br/>
			
			<b>Address: </b> <?php echo $user['streetaddress'] ?>, <?php echo $user['city'] ?>, <?php echo $state_array[$user['state']] ?>, <?php echo $user['zip'] ?><br/><br/>
		
			<b>Requested: <?php print_r($requests); ?></b> 
		</div>
</div>

<div id="vehicles_outer">

	<?php echo count($vehicles) ?> Vehicles Listed <a href="items.php?auction_id=0&user_id=<?php echo $user['ID'] .(isset($_GET['dialer'])?'&dialer':'') ?>">Add New</a><br><br>
	
	<div id="vehicles">
	
	<?php 
	if(!empty($vehicles)){
		echo '<ul>';
		foreach($vehicles as $v){ ?>
			<li><?php echo $v['make']?> <?php echo $v['model']?> (<?php echo $v['requests']?> requests)</li>
		<?php 
		}
		echo '</ul>';
	} else {
		echo 'This user has not uploaded any vehicles this month.';
	}
	?>
	
	</div>

</div>
</div>


<?php if(!isset($_GET['dialer'])){ ?>
<div style="clear: both;"></div>
<a href="prefs.php?user_id=<?php echo $user['ID'] .(isset($_GET['dialer'])?'&dialer':'') ?>" style="float: right; font-size: 15px; position: relative; left: -400px; font-weight: bold;">Edit</a>
<h3 id="matches_header">Matches</h3>
<div id="matches_outer">
	
	<div id="matches"></div>
</div>
</div>
<?php } ?>
<div style="clear: both;"></div>
<?php } ?>