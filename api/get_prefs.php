<?php

require_once '../include.php';

$types = array('Include', 'Exclude');

if($_SESSION['authorised'] != "valid") die();

$prefs = User::getPrefs($_POST['user_id']);
$regions = Site::getLookupTable('regions', 'id', 'region', 'id');


foreach($types as $t){
	echo '<div class="match_prefs_list">';
	if($t == 'Include') echo '<h4>You will be sent these vehicles</h4>';
	else echo '<h4>You have requested to <span style="color: red;">never</span> be sent</h4>';
	
	if(isset($prefs[$t]) && is_array($prefs[$t])){
		echo '<ul id="list_'.strtolower($t).'">';
		foreach($prefs[$t] as $v){
		
			echo '<li id="li_'.$v['id'].'">';
			if(!isset($_GET['no_buttons'])) echo '<div id="li_del_'.$v['id'].'" style="cursor: pointer; cursor: hand;" class="li_del" onclick="alert_delete('.$v['id'].')"><img src="/images/delete.png" />remove</div>';
			
			if($v['make'] != '') echo ($v['model']==''?' all ':' '). $v['make'];
			else echo 'all makes '; 
			
			if($v['model'] !=  '') echo ' ' . $v['model'];
			
			if($v['from_year']== '1900' && $v['to_year'] != date('Y')){
				echo ' more than '.(date('Y')-$v['to_year']).' years old ';
			} else if($v['from_year']!= '1900' && $v['to_year'] == date('Y')){
				echo ' less than '.(date('Y') - $v['from_year']).' years old ';
			} else if($v['from_year']!= '1900' && $v['to_year'] != date('Y')) {
				echo ' between '.(date('Y') - $v['to_year']) . ' and '.(date('Y')-$v['from_year']).' years old ';
			}
			
			if($v['mileage']>0) echo ' with less than '. $v['mileage'].'km mileage';
			
			if($v['location']!= ''){
				if($v['location'] == '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23'){
					echo ' in all Australia';
				} else if($v['location'] == '28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53') {
					echo ' in Ireland';
				} else {
				
					$regions_array = array('1,2,3,4', '5,6', '7,8,9,10', '11,12,13', '14,15', '16,17,18', '19,20,21,22,23', '28,29,30,31,32', '33,34,35,36,37,38,39,40,41,42,43,44', '45,46,47,48,49,50', '51,52,53');
					$states_array = array('Queensland', 'Northern Territory', 'Western Australia', 'South Australia', 'Tasmania', 'Victoria', 'New South Wales', 'Connacht', 'Leinster', 'Munster', 'Ulster');
					$str = str_replace($regions_array, $states_array, $v['location']);
					$temp = explode(',',$str);
					
					foreach($temp as &$r){
						if(!in_array($r, $states_array)) $r = $regions[$r];
					}
					echo ' in ' . implode(', ', $temp);
				
				}
			}
			echo '</li>';
		}
		echo '</ul>';
	} else {
		if($t == 'Include') echo 'You are not matching any vehicles that are being listed, and will not receive any vehicles as they are listed. Please list the vehicles you are interested in.';
		else echo 'You have not said there are vehicles you do not wish to receive. This can be done by clicking on the link at the bottom of the email sent to you if you do not wish to receive more of that make or model.';
	}
	echo '</div>';
}
?>