<?php
require_once '../include.php';

$file = file_get_contents('import.csv');
$file = str_replace("\r", "\n", $file);
$file = str_replace("\n\n", "\n", $file);

$array = explode("\n", $file);

$i = 1;
$header = array();
foreach($array as $l){
	$new_line = array();
	$l = trim($l);
	$line = explode(',', $l);
	
	if($i == 1){
		$header = $line;
	} else {
		
		foreach($line as $k => $v){
			$new_line[$header[$k]] = $v;
		}
		
		$new_array[$new_line['Make']][$new_line['Model']][$new_line['Trim']] = '';
		
	}
	
	
	$i++;
}

ksort($new_array);


foreach($new_array as $make => &$models){
	ksort($models);
	if($make == '') continue;
	
	$query = 'INSERT INTO uk_makes(make) VALUES("'.$make.'")';
	$make_id = Site::runQuery($query);
	
	foreach($models as $model => &$badges){
		ksort($badges);
		if($model == '') continue;
		
		$query = 'INSERT INTO uk_models(model, make_id) VALUES("'.$model.'", '.$make_id.')';
		$model_id = Site::runQuery($query);
		
		foreach($badges as $badge => $blank){
			
			$query = 'INSERT INTO uk_badges(badge, model_id) VALUES("'.$badge.'", '.$model_id.')';
			$badge_id = Site::runQuery($query);
			
		}
	}
	
}
echo '<pre>';
print_r($new_array);
echo '</pre>';
die();
?>