<?php
$all_regions = Auction::getRegions();
//getLookupTable($table, $id, $value, $order = false, $active = false, $blank = false, $use_cache = true, $force_cache = false, $where = false)
$states = Site::getLookupTable('states', 'id', 'state', 'id', true, false, false);
?>

<script>
jQuery(document).ready(function(){
	
});

</script>


<div id="match_interface">
	
	<div id="match_interface_left">
		<div id="match_interface_border"></div>
	
		<?php echo Site::drawForm('add_prefs'); ?>
		
		<div id="make_model_box">
		<h4>Vehicle Details</h4>
		
		<?php 
		echo Site::drawHidden('match_type_id', 1);
		echo Site::drawHidden('mileage', 0);
		echo Site::drawHidden('user_id', isset($_GET['user_id'])?$_GET['user_id']:User::getSimpleUser());
		echo Site::drawSelect('make_id', Site::getLookupTable($_SESSION['l10n']['table_prefix'].'makes', 'id', 'make', 'make', false, false, true, $_SESSION['l10n']['table_prefix'].'make_by_id'), '', '', false, 'All Makes', array('class'=>'select_make'));
		echo Site::drawSelect('model_id', array(), '', '', false, 'All Models', array('class'=>'select_model')).BR2;
		
		echo Site::drawSelect('to_year', array('100'=>'any', '2'=>'2 years', '5'=>'5 years', '8' => '8 years', '10'=>'10 years'), '', '', 'Older than', false).BR;
		echo Site::drawSelect('from_year', array('100'=>'any', '2'=>'2 years', '5'=>'5 years', '8' => '8 years', '10'=>'10 years'), '', '', 'Newer than', false).BR2;
		
		echo Site::drawSelect('mileage', array('0'=>'any', '20000'=>'under 20,000kms', '50000'=>'under 50,000kms', '100000'=>'under 100,000kms', '150000'=>'under 150,000kms'), '', '', 'Mileage ', false).BR;
		
		
		echo Site::drawDiv();
		?>
		
		
		<!--<select name="state_select" style="display: none;">
		<?php foreach($all_regions as $state => $regions){ ?>
		<option value="<?php echo str_replace(array(' ', '/'), '', $state) ?>"><?php echo $state ?></option>
		<?php } ?>
		</select>-->
		
		<div id="match_states">

		<?php foreach($all_regions as $state => $regions){ ?>
			<div class="state" id="state_<?php echo str_replace(array(' ', '/'), '', $state) ?>">
				
				<div class="header_state"><?php echo $state?><input type="checkbox"></div>
				<ul style="display: <?php echo $states[User::getSD('state')] == $state? 'block' : 'none' ?>">
				<?php foreach($regions as $region_id => $region){ ?>
					<li id="list_region_<?php echo $region_id?>"><?php echo $region?> <input type="checkbox" name="regions[]" id="region_<?php echo $region_id?>" value="<?php echo $region_id?>" /></li>
				<?php } ?>
				</ul>
			</div>
		<?php } ?>
		</div>
		<?php
		echo Site::drawCustomSubmit('save', '', '_save_pref');
		
		echo Site::drawForm();
		?>
	</div>
	
	<div id="match_map">
		<?php 
		foreach($all_regions as $state => $regions){ 
		foreach($regions as $region_id => $region){ ?>
			<img src="/images/map/map_region_<?php echo $region_id?>.png" id="map_region_<?php echo $region_id?>" />
		<?php 
			} 
		} 
		?>
	
	</div>
	<div style="clear: both"></div>
	<div id="matches">
	
	</div>

</div>

