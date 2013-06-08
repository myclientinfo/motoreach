
	<script>
	
	jQuery(document).ready(function(){
		
		$('span.mk').click(function(){
			$('div.list_models', $(this).parent('div')).toggle();
		});
		
		$('span.md').click(function(){
			$('div.list_vehicles', $(this).parent('div')).toggle();
		});
		
	});
	
	</script>
	
	<style>
	#select_makes div { width: 200px; color: white; text-align: center; float: left;  cursor: hand; cursor: pointer; height: 25px;  }
	#select_makes div { width: 200px; padding-top: 10px; font-weight: bold; }
	#select_makes div:hover {color: #009EF1;}
	.box_h, .box_n {display: none;}
	</style>
	
	<div id="inner_content_white">
    <h2>Vehicles Available Now</h2>    
	
	<?php
	ksort($content);
	//$GLOBALS['debug']->printr($content);
	
	$make_count = count(array_keys($content));
	$third_makes = ceil($make_count/3);
	$two_thirds_makes = ceil(($make_count/3)*2);
	
	//$GLOBALS['debug']->printr($make_count);
	
	?>
	<div class="form_left">

		<p>The following includes all <?php echo $_SESSION['l10n']['term_wholesale'] ?> vehicles currently available for sale. Browse and click to see all available models. Click a model to see all available vehicles.</p>
		
		<p>This list will not include your own <?php echo $_SESSION['l10n']['term_wholesale'] ?>s.</p>

	</div>
	
	<div style="width: 700px; margin-left: 190px; padding-left: 15px; margin-top: 10px;">
	<?php if(isset($_GET['type'])){ ?>
		<?php if($_GET['type']=='dealer'){ ?>
		<p>You are currently viewing all dealer listed vehicles currently available around the country. This includes only vehicles from dealers, and does not include vehicles listed by a member of the public. This list does not take into account your match preferences.</p>
	
		<p>You can also view <a href="?type=public">public vehicles only</a> or <a href="browse.php">all vehicles</a>.</p>
		<?php } else { ?>
		<p>You are currently viewing all public (myMotoreach.com) listed vehicles currently available around the country. This includes only vehicles from the, and does not include vehicles listed by another dealer. This list does not take into account your match preferences.</p>
	
		<p>You can also view <a href="?type=dealer">dealer vehicles only</a> or <a href="browse.php">all vehicles</a>.</p>
		<?php } ?>
	<?php } else { ?>
	<p>You are currently viewing all listed vehicles currently available around the country. This includes vehicles from dealers and from the public, and does not take into account your own preferences.</p>
	
	<p>You can also view <a href="?type=dealer">dealer vehicles only</a> or <a href="?type=public">public seller vehicles only</a>. </p>
	<?php } ?>
	
	</div>
	<?php if(!empty($content)){ ?>
	<div class="makes_column">
	<?php 
	$i = 1;
	//$GLOBALS['debug']->printr($content);
	foreach($content as $k => $mk){
	?>
	<div class="list_make">
		<span class="mk"><span><?php echo $k ?></span></span>
		<span class="mk_count"><?php echo count($mk) ?></span>
		<div class="list_models">
		<?php foreach($mk as $md => $mds){ 
			$smds = strtolower(str_replace(' ', '_', $md));
			$smds = str_replace(array('(',')'),'', $smds);
		?>
			<div class="model_outer">
			<span class="md"><?php echo $md; ?></span> (<?php echo count($mds) ?>)<br />
			<div class="list_vehicles">
			<?php
			foreach($mds as $vehicle){
				echo '<div class="av"><a href="/items.php?itemID='.$vehicle['ID'].'">'.$vehicle['year'].' '.$vehicle['make'].' '.$vehicle['model'].' '.$vehicle['badge'].'</a><br>';
				if($_SESSION['l10n']['country_code']!='IE') echo $vehicle['colour'].' - '.$vehicle['city'].', '. $vehicle['state_short'];
				echo '</div>';
			}
			?>
			</div>
			</div>
		<?php } ?>
			<img src="/images/browse_model_bg_bottom.png">
			
		</div>
	</div>
	
	<?php
		if($third_makes == $i || $two_thirds_makes == $i) echo "</div>\n\n<div class=\"makes_column\">";
		$i++;
	}
	?>
	</div>
	<?php } else { ?>
	<div style="float: right; width: 700px;">There are currently no vehicles listed for <?php echo $_SESSION['l10n']['term_wholesale'] ?>. <a href="/user/submititem.php"><?php echo ucwords($_SESSION['l10n']['term_wholesale']) ?> a vehicle now</a>  or check back shortly for newly listed vehicles.</div>
	<?php } ?>
	
	<br><br>
	</div>
