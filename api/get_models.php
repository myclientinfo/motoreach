<?php
if(!isset($_GET['type']) || $_GET['type'] == '') $_GET['type'] = 'model';
require '../classes/class.site.php';
session_start();

if($_GET['type'] == 'model'){
	$array = Site::getMakeModel($_GET['make']);
} else if($_GET['type'] == 'badge'){
	$array = Site::getModelBadge($_GET['model']);
} else if($_GET['type'] == 'series'){
	$array = Site::getModelSeries($_GET['model']);
}

if(isset($_GET['all_models'])) echo '<option value="">All Models</option>';

foreach($array  as $k => $v){ 
	if($k == '') continue;
?>
<option value="<?php echo $k ?>"><?php echo $v ?></option>
<?php } ?>