<?php

define('SECONDS_IN_HOUR', 3600);
define('SECONDS_IN_DAY', 86400);
define('SECONDS_IN_WEEK', 604800);
define('TEMPLATE_PATH', 'templates/');

define('DAY_MONTH_YEAR', 'j F Y');
define('BR3', "<br /><br /><br />\n\n");

if(isset($_GET['dialer'])){
	define('BR', "<br /><div style=\"clear: both\"></div>\n");
	define('BR2', "<br /><br /><div style=\"clear: both\"></div>\n\n");
} else {
	define('BR', "<br />\n");
	define('BR2', "<br /><br />\n\n");
}

function stripslashes_deep($value){
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);

    return $value;
}


class Site{

	var $data;
	var $id;
	var $admin = false;
	var $data_listing = array();
	var $content_type;
	var $table_name;
	var $table_fields;
	var $where;
	
	function __construct($id, $list, $admin = false, $table_name = '', $content_type = '', $where = false){
		if($content_type != '') $this->content_type = $content_type;
		if($table_name != '' && empty($this->table_name))$this->table_name = $table_name;
		if(empty($this->table_fields)) $this->table_fields = $this->getFieldsForType($this->content_type);
		if($admin) $this->setAdmin(1);
		if($id){
			$this->data = $this->getOne($id);
			$this->id = $id;
		}
		if($where) $this->where = $where;
		if($list) $this->data_listing = $this->getAll($admin, $admin);
		
	}
	
	
	
	function setWhere($where){
		$this->where = $where;
	}
	
	function setAdmin($admin = true){
		$this->admin = $admin;
	}
	
	function mysqlConnect(){
		$link = mysql_connect('localhost', MYSQL_USER, MYSQL_PASS);
		mysql_select_db(MYSQL_DB);
		return $link;	
	}
	
	function numbersOnly($string){
		if(substr($string, -3, 3) === '.00'){
			$string = substr($string, 0, -3);
		}
		return preg_replace('/\D/', '', $string);
	}
	
	function isProtected(){
		$location_array = explode('/', $_SERVER['SCRIPT_NAME']);
		if(in_array('user', $location_array) || in_array($_SERVER['SCRIPT_NAME'], array('/browse.php', '/items.php'))){
			
			if($_SERVER['REDIRECT_URL'] == '/vehicle.php') return false;
			
			return base64_encode($_SERVER['REQUEST_URI']);
		}
		return false;
	}
	
	function formatTimeLeft($integer){ 
		$seconds=$integer; 
		$return = '';
		$weeks = '';
		if ($seconds/60 >=1){ 
		
			$minutes=floor($seconds/60); 
	
			if ($minutes/60 >= 1){ # Hours 
				$hours=floor($minutes/60); 
				if ($hours/24 >= 1){ #days 
					$days=floor($hours/24); 
					if ($days/7 >=1){ #weeks 
						$weeks=floor($days/7); 
						if ($weeks>=2) $return="$weeks Weeks"; 
						else $return="$weeks Week"; 
					} #end of weeks 
					
					$days=$days-(floor($days/7))*7; 
					if ($weeks>=1 && $days >=1) $return="$return, "; 
					if ($days >=2) $return="$return $days days";
					if ($days ==1) $return="$return $days day";
				} #end of days
				
				$hours=$hours-(floor($hours/24))*24; 
				if ($days>=1 && $hours >=1) $return="$return, "; 
				if ($hours >=2) $return="$return $hours hours";
				if ($hours ==1) $return="$return $hours hour";
			} #end of Hours
			
			$minutes=$minutes-(floor($minutes/60))*60; 
			if ($hours>=1 && $minutes >=1) $return="$return, "; 
			if ($minutes >=2) $return="$return $minutes minutes";
			if ($minutes ==1) $return="$return $minutes minute";
		} #end of minutes 
		
		$seconds=$integer-(floor($integer/60))*60; 
		if ($minutes>=1 && $seconds >=1) $return="$return, "; 
		if ($seconds >=2) $return="$return $seconds seconds";
		if ($seconds ==1) $return="$return $seconds second";
		return $return; 
	} 
	
	

	function getTime($type, $time = '', $return_format = 'PHP'){
		if($time == '') $time = time();

		if($type == 'week_from_time'){
			$new_time = $time + SECONDS_IN_WEEK;
		} elseif($type == 'start_this_week') {
			$day_of_week = date('N', $time);
			$day = date('j', $time);
			$start_day_of_week = $day - ($day_of_week - 1);
			$new_time = mktime(0, 0, 1, date('n', $time), $start_day_of_week, date('Y', $time));
		} elseif($type == 'end_this_week') {
			$day_of_week = date('N', $time);
			$day = date('j', $time);
			$end_day_of_week = $day + (7 - $day_of_week);
			$new_time = mktime(24,59,59,date('n', $time), $end_day_of_week, date('Y', $time));
		} elseif($type == 'plus_three_weeks'){
			$new_time = $time + (SECONDS_IN_WEEK * 3);
		} elseif($type == 'end_this_month'){
			// todo
		} elseif($type == 'start_this_month'){
			// todo
		} elseif($type == 'start_day'){
			$new_time = mktime(0,0,0,date('n', $time), date('j', $time), date('Y', $time));
		}

		if($return_format == 'PHP') return $new_time;
		else return date('Y-m-d H:i:s', $new_time);
	}

	function nl2pimport($text){
		$text_array = explode("\n", $text);
		$text_array = array_map("trim", $text_array);
		
		$text = implode("</p>\n\n<p>", $text_array);
		$text = str_replace("<p></p>\n\n", '', $text);
		$text = '<p>'.$text.'</p>';
		
		return $text;

    }
	
	
	
	function nl2p ($text){

		$text = str_replace('\r','',$text);

		// put all text into <p> tags
        $text = '<p>' . $text . '</p>';

		// replace all newline characters with paragraph ending and starting tags
        $text = str_replace('\n','</p><p>',$text);

		// remove any cariage return characters
       

        // remove empty paragraph tags
		$text = str_replace('<p></p>','',$text);


        // optional replacement, if you need a nice-looking XHTML source and not all source in one line.
        $text = str_replace('<p><img', '<img', $text);
        $text = str_replace('</span></p>', '</span>', $text);
        $text = str_replace('<p><div', '<div', $text);
        $text = str_replace('<p><span class="caption"', '<span class="caption"', $text);
        $text = str_replace('<p><div align="center"></p>', '<div align="center">', $text);
        
        $text = str_replace('</p><p>', "</p>\n\n<p>", $text);
        $text = str_replace('</p><div ', "</p>\n\n<div ", $text);
        $text = str_replace("align=\"center\">\n\n<img", "align=\"center\">\n<img", $text);
        $text = str_replace("<br >\n\n<span class=", "<br >\n<span class=", $text);
        $text = str_replace('<div align="center"><img src="/images/screenshots', "<div align=\"center\">\n<img src=\"/images/screenshots", $text);
      
		return $text;
    }

	function getTimeString($start, $end = 0){
		if($end == '0000-00-00 00:00:00') $end = 0;

		$string = '';

		$start_mod = strtotime($start);
		$end_mod = strtotime($end);

		if(date('Ymd',$start_mod)==date('Ymd',$end_mod)){
			return date('l, jS \of F', $start_mod);
		} else {
			$start_string = date('l, jS \of F g:ia', $start_mod);
			$end_string = ' to '. date('l, jS \of F g:ia', $end_mod);
			$string = $start_string.$end_string;
		}

		return $string;
	}

	function getDateString($date, $format){
		$date = strtotime($date);
		return date($format, $date);
	}

	function getMonthsArray(){
		$array = array(''=>'',1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');
		//unset($array[0]);
		return $array;
	}
	
	function getShortMonthsArray(){
		$array = array('Month', 'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');
		//unset($array[0]);
		return $array;
	}

	function drawDiv($id = false, $clear = false, $attr = false){
		
		if($id === false && $clear == false) return '</div>';
		if($clear) return '<div style="clear: both;"></div>';
		
		$string = '';
		$string .= '<div id="'.$id.'"';
		if($attr){
			foreach($attr as $k => $v){
				$string .= ' '.$k.'="'.$v.'"';
			}
		}
		$string .= '>';
		
		return $string;
	}

	function drawFieldset($id = false, $label = false){
		if($id){
			$str = '<fieldset id="'.$id.'">';
			if($label){
				$str .= "\n<legend>".$label."</legend>";
			}
			return $str;
		} else return '</fieldset>';
	}
	
	function drawSelect($name, $array, $preset = false, $default = false, $label = false, $clearfield = false, $attr = false){
		$string = '<select name="'.$name.'" id="'.$name . '"';
		if($attr){
			foreach($attr as $k => $v){
				$string .= ' '.$k.'="'.$v.'"';
			}
		}
		$string   .=   ">\n";

		if($clearfield && $clearfield === true){
			$string .= '<option value="">Select '.$label."</option>\n";
		} else if ($clearfield == 'various') { 
			$string .= "<option value=\"111\" class=\"sel_var_opt\">various</option>\n";
		} else if ($clearfield && $clearfield !== true){
			$string .= '<option value=""'.($default==='' && $preset === ''?' selected':'').'>'.$clearfield."</option>\n";
		}
		
		foreach($array as $key => $val){
			$string .= '<option value="'.$key.'"'.( $preset == $key || !$preset && $default === $key ? ' selected' : '' ).'>'.$val."</option>\n";
		}
		$string .= "</select>\n";
		if($label) return Site::drawLabel($name, $label) . $string;
		else return $string;
	}
	
	function drawCheckbox($name, $value, $checked = false, $label = false){
		
		$string = '<input type="checkbox" name="'.$name.'" id="'.$name.'" value="'.$value.'"'.($checked ? ' checked="checked"' : '' ).'>';
		
		if($label) return Site::drawLabel($name, $label) . $string;
		else return $string;
	}
	
	function drawRadio($name, $array, $preset = false, $default = false, $label = false){
		$string = '';
		$i = 1;
		foreach($array as $key => $val){
			$string .= '<input type="radio" name="'.$name.'" id="'.$name.'_'.$i.'" value="'.$key.'"'.( $preset == $key || !$preset && $default == $key ? ' checked' : '' ).'>'.$val;
			$i++;
		}
		if($label) return Site::drawLabel($name, $label) . $string;
		else return $string;
	}
	
	function drawHidden($name, $value){
		return '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'">';
	}
	
	function drawSubmit($name, $label){
		return '<input type="submit" name="'.$name.'" id="'.$name.'" value="'.$label.'">';
	}
	
	function drawButton($name, $label, $attr = false){
		$string = '<button name="'.$name.'" id="'.$name.'"';
		if($attr){
			foreach($attr as $k => $v){
				$string .= ' '.$k.'="'.$v.'"';
			}
		}
		$string .= '>'. $label . '</button>';
		return $string;
	}
	
	function drawSubmitImage($name, $src, $attr = false){
		$string = '<input type="image" name="'.$name.'" id="'.$name.'" src="'.$src.'"';
		
		if($attr){
			foreach($attr as $k => $v){
				$string .= ' '.$k.'="'.$v.'"';
			}
		}
		$string .= ' />';
		return $string;
	}
	
	function drawImage($name, $src, $attr = false){
	//print_r($attr);
		$string = '<img name="'.$name.'" id="'.$name.'" src="'.$src.'"';
		if($attr){
			foreach($attr as $k => $v){
				$string .= ' '.$k.'="'.$v.'"';
			}
		}
		$string .= '>';
		
		return $string;
	}
	
	function drawCustomSubmit($label, $size='', $unique='', $returnfalse = false){
		$string = Site::drawButton('hidden_submit_button', 'Submit Form', array('class'=>'hidden_submit_button'));
		$string .= '<div id="submit_button'.$unique.'" class="button'.$size.'"'.($returnfalse?' rel="no_submit"':'').'><span>'.$label.'</span></div>';
		
		return $string;
	}
	
	function drawUploader($name, $src, $label){
		$string = '<input type="file" id="'.$name.'" name="'.$name.'" />';
		if($label) return Site::drawLabel($name, $label) . $string;
		else return $string;
	}
	
	function drawLabel($name, $label){
		return '<label for="'.$name.'" id="'.$name.'_label">'.($label === true ? ucwords(str_replace('_',' ', $name)) : ucwords($label)).'</label>';
	}
	
	function drawText($name, $value = false, $label = false, $attr = false, $field_type = 'text'){
		$string = '<input type="'.$field_type.'" name="'.$name.'" id="'.$name.'" value="'.$value.'"';
		if($attr && is_array($attr)){
			foreach($attr as $k => $v){
				$string .= ' '.$k.'="'.$v.'"';
			}
		}
		$string .= '>';
		if($label) return Site::drawLabel($name, $label) . $string;
		else return $string;
	}
	
	function drawTextArea($name, $value = false, $label = false){
		$string = '<textarea name="'.$name.'" id="'.$name.'">'.$value.'</textarea>';
		
		if($label) return Site::drawLabel($name, $label) . $string;
		else return $string;
	}
	
	
	function drawEditor($name, $content, $height = '300'){
		$content = preg_replace('/\r\n|\r/', "\n", $content);
		$string_array = explode("\n",$content);
		//$GLOBALS['debug']->printr($string_array);
		
		$string = '<script type="text/javascript">
		
<!--
var giveContent	= \'\';
';
foreach($string_array as $row){ 
	$string .= 'giveContent += \'' . $row . '\';
	';
} 
$string .= 'var oFCKeditor = new FCKeditor( \''.$name.'\' ) ;
oFCKeditor.BasePath = \'/fckeditor/\';
oFCKeditor.Height	= '.$height.';
oFCKeditor.Value	= giveContent;
oFCKeditor.Create() ;
//-->
		</script>';

		return $string;
	}
	
	function drawPassword($name, $value = false, $label = false){
		$string = '<input type="password" name="'.$name.'" id="'.$name.'" value="'.$value.'">';
		if($label) return Site::drawLabel($name, $label) . $string;
		else return $string;
	}
	
	function drawPlainText($name, $value = false, $label = false){
		$string = '<span id="'.$name.'">'.$value.'</span>';
		if($label) return Site::drawLabel($name, $label) . $string;
		else return $string;
	}
	
	
	function drawFile($name, $label=false){
		$string = '<input type="file" name="'.$name.'" id="'.$name.'">';
		if($label) return Site::drawLabel($name, $label) . $string;
		else return $string;
	}
	
	function drawForm($name='', $action = '', $method = 'POST', $enc = false, $block_submit = false){
		if($name!='') return '<form action="'.$action.'" name="'.$name.'" id="'.$name.'" '.($enc ?'enctype="multipart/form-data"' :'' ).' method="'.$method.'"'.($block_submit?' onSubmit="return false"':'').'>';
		else return '</form>';
	}
	
	function deleteCache(){
		$file_location = $_SERVER['DOCUMENT_ROOT'].'/cache/';
		foreach (glob($file_location.'*.php') as $filename) {
			unlink($filename);
		}
	}
	
	function getLookupTable($table, $id, $value, $order = false, $active = false, $blank = false, $use_cache = true, $force_cache = false, $where = false){
		
		$cache_name = $force_cache ? $force_cache : $table;
		
		$file_location = $_SERVER['DOCUMENT_ROOT'].'/cache/'.strtolower($cache_name).'.php';
		
		if(file_exists($file_location) && $use_cache){
			$array = unserialize(file_get_contents($file_location));
		} else {
			$query = 'SELECT * FROM '.$table.' WHERE 1 ';
			if($where) $query .= ' AND '.$where;
			if($active) $query .= ' AND active = 1';
			if($order) $query .= ' ORDER BY '.$order;
			if($blank) $array[] = $blank;
			$array = Site::getData($query, false, $id, $value);
			
			if($use_cache){
				if(!file_put_contents($file_location, serialize($array))){
					echo '<!-- failed: '.$file_location.' -->';
				}
			}
		}
		return $array;
	}

	
	function getMakeModel($make = false){
		
		$file_location = $_SERVER['DOCUMENT_ROOT'].'/cache/'.$_SESSION['l10n']['table_prefix'].'makes.php';

		if(file_exists($file_location)){
			$array = unserialize(file_get_contents($file_location));
		} else {
			$query = 'SELECT md.id, make, model FROM '.$_SESSION['l10n']['table_prefix'].'makes AS mk
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.make_id = mk.id
						ORDER BY make ASC, model ASC';
			
			foreach($GLOBALS['db']->getAll($query) as $item){
				$array[$item['make']][$item['id']] = $item['model'];
			}
			@file_put_contents($file_location, serialize($array));
		}
		
		if($make) return $array[$make];
		else return $array;
	}
	
	function getModelBadge($model = false){
		$file_location = $_SERVER['DOCUMENT_ROOT'].'/cache/'.$_SESSION['l10n']['table_prefix'].'badges.php';
		
		if(file_exists($file_location)){
			$array = unserialize(file_get_contents($file_location));
		} else {
			$query = 'SELECT b.id, make, model, badge, mk.id as make_id, md.id as model_id FROM '.$_SESSION['l10n']['table_prefix'].'models AS md
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS b ON b.model_id = md.id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON md.make_id = mk.id
						ORDER BY make ASC, model ASC, badge ASC';
			
			foreach($GLOBALS['db']->getAll($query) as $item){
				$array[$item['make'].'_'.$item['model']][$item['id']] = $item['badge'];
			}
			
			@file_put_contents($file_location, serialize($array));
		}
		
		
		if($model) return $array[$model];
		else return $array;
	}
	
	function getModelSeries($model = false){
		$file_location = $_SERVER['DOCUMENT_ROOT'].'/cache/'.$_SESSION['l10n']['table_prefix'].'series.php';
		
		if(file_exists($file_location)){
			$array = unserialize(file_get_contents($file_location));
		} else {
			$query = 'SELECT s.id, make, model, model_id, series, mk.id as make_id, s.id as series_id FROM '.$_SESSION['l10n']['table_prefix'].'models AS md
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'series AS s ON s.model_id = md.id
						LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON md.make_id = mk.id
						ORDER BY make ASC, model ASC, series ASC';
			
			foreach($GLOBALS['db']->getAll($query) as $item){
				$array[$item['make'].'_'.$item['model']][$item['id']] = $item['series'];
			}
			@file_put_contents($file_location, serialize($array));
		}
		
		if($model) return $array[$model];
		else return $array;
	}
	
	function getData($query, $single = false, $key_by_id = false, $value = false, $group = false){
		$result = mysql_query($query);
		if(!$result){
			//$GLOBALS['debug']->query_fail($query, true);
			Site::mysqlConnect();
			$result = mysql_query($query);
		}
		$array = array();
		while($row = @mysql_fetch_assoc($result)){
			$row = array_map('stripslashes', $row);
			if($single) return $row;
			
			if(!$key_by_id) $array[] = $row;
			else{
				if(!$value && !$group) $array[$row[$key_by_id]] = $row;
				else if(!$value && $group) $array[$row[$group]][$row[$key_by_id]] = $row;
				else if($value && $group) $array[$row[$group]][$row[$key_by_id]] = $row[$value];
				else $array[$row[$key_by_id]] = $row[$value];
			}
		}
		if(strstr($query, 'SQL_CALC_FOUND_ROWS')){
			$result = mysql_query('SELECT FOUND_ROWS() AS total');
			$total = mysql_fetch_assoc($result);
			
			$array['total'] = $total['total'];
		}
		return $array;
	}
	
	function getGetVars(){
		
		if(isset($_GET['ob'])){
			$array['order_by'] = $_GET['ob'];
		} else if(isset($this->list_order)){
			$array['order_by'] = $this->list_order;
		} else if ($this->admin){
			$array['order_by'] = $this->table_fields[0];
		} else if(in_array('order_num', $this->table_fields)){
			$array['order_by'] = (isset($this->table_alias)?$this->table_alias.'.':'').'order_num';
		} else if(in_array('publish_date', $this->table_fields)){
			$array['order_by'] = 'publish_date';
		} else {
			$array['order_by'] = $this->table_fields[0];
		}
		
		$array['order_direction'] = isset($_GET['od']) ? $_GET['od'] : ($array['order_by'] == 'order_num'?'ASC':'DESC');
		$array['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
		$array['records_displayed'] = isset($_GET['num']) ? $_GET['num'] : 30;
		$array['offset'] = $array['page'] * $array['records_displayed'] - $array['records_displayed'];
		
		return $array;
	}
	
	function getAll($get_inactive = false, $get_unpublished = false, $key_by_id = false){
		
		$get_vars = $this->getGetVars();
		
		$query = 'SELECT SQL_CALC_FOUND_ROWS '.(isset($this->field_list)?$this->field_list:'*').' FROM '.$this->table_name;
		if(isset($this->table_alias))$query .= ' AS '.$this->table_alias."\n";
		if(isset($this->table_field_mapping)){
			$sorted_mapping = $this->groupTableFieldMapping();
			if(isset($sorted_mapping['select'])){
				if(isset($sorted_mapping['join'])){
					foreach($sorted_mapping['join'] as $key => $value){
						$query .= ' LEFT JOIN ' . $value['table'] . ' AS ' . $value['as'] . ' ON ' . $value['on']."\n";
					}
				}
				if(isset($sorted_mapping['select'])){
					foreach($sorted_mapping['select'] as $key => $value){
						$query .= ' LEFT JOIN ' . $value['table'] . ' AS ' . $value['as'] . ' ON ' . $value['on']."\n";
					}
				}
				if(isset($sorted_mapping['manual_select'])){				
					foreach($sorted_mapping['manual_select'] as $key => $value){
						if(isset($value['link'])){
							$query .= ' LEFT JOIN ' . $value['table'] . ' AS ' . $value['as'] . ' ON ' . $value['on']."\n";
						}
					}
				}
			}
		}
		$query .= ' WHERE 1';
		if(!$get_unpublished && in_array('publish_date', $this->table_fields)) $query .= ' AND publish_date < NOW() '."\n";
		if(!$get_inactive) $query .= ' AND '.(isset($this->table_alias)?$this->table_alias.'.':'').'active = 1'."\n";
		if($this->where) $query .= ' AND '.$this->where;
		$query .= ' ORDER BY '.$get_vars['order_by'].' '.$get_vars['order_direction']."\n"; 
		$query .= ' LIMIT ' . $get_vars['offset'] . ',' . $get_vars['records_displayed']."\n";
		
		//$GLOBALS['debug']->printr($query);
		
		return $this->getData($query, false, $key_by_id);
	}
	
	function checkCache($class, $id = 'id'){
		$file_location = $_SERVER['DOCUMENT_ROOT'].'/classes/cache/'.strtolower($class).'.php';
		
		if(file_exists($file_location)){
			$array = unserialize(file_get_contents($file_location));
		} else {
			$array = $this->getAll(false, false, $id);
			file_put_contents($file_location, serialize($array));
		}
		return $array;
	}
	
	function removeCache($class){
		unlink($_SERVER['DOCUMENT_ROOT'].'/classes/cache/'.strtolower($class).'.php');
	}


	function getMethodCache($class, $method, $return = false){
		$file_location = $_SERVER['DOCUMENT_ROOT'].'/classes/cache/'.strtolower($class).'_'.strtolower($method).'.php';
		if(!file_exists($file_location)){
			return false;
		} else {
			if($return){
				return unserialize(file_get_contents($file_location));
			} else {
				return true;
			}
		}
	}
	
	function setMethodCache($class, $method, $data){
		$file_location = $_SERVER['DOCUMENT_ROOT'].'/classes/cache/'.strtolower($class).'_'.strtolower($method).'.php';
		file_put_contents($file_location, serialize($data));
	}
	
	function groupTableFieldMapping(){
		$array = $this->table_field_mapping;
		foreach($array as $key => $value){
			$new_array[$value['type']][$key] = $value;
		}
		return $new_array;
	}
	
	function getOne($id){
        $query = 'SELECT * FROM '.$this->table_name.' WHERE ' . $this->table_fields[0] . ' = ' . $id;
        $data = $this->getData($query, true);
		return array_map('stripslashes', $data);
    }
	
	function runQuery($query){
		
		Site::mysqlConnect();
		$result = mysql_query($query);
		
		if(!$result){
			//echo mysql_error();
			$result = mysql_query($query);
			@mail('matt@australiangamer.com', 'matches', 'query failure: '.$query.' - '.mysql_error());
			return 'ERROR:'.mysql_error();
		} else {
			if(mysql_insert_id() == ''){
				if(isset($this)) return $_POST[$this->table_fields[0]];
				else return true;
			} else {
				return mysql_insert_id();
			}
		}
	}
	
	function save($update_duplicate = true){
		$field_string = '';
		$value_string = '';
		$set_string = '';
		$i=0;
		
		foreach($this->table_fields as $field){
			if(!isset($_POST[$field])) continue;
			
			if(isset($this->save_skip) && in_array($field, $this->save_skip)) continue;
			$field_string .= ($i?',':'') . $field;
			
			if($this->table_name == 'content' && $field == 'content') $_POST[$field] = $this->autop(mysql_real_escape_string(stripslashes($_POST[$field])));
			else $_POST[$field] = mysql_real_escape_string(stripslashes($_POST[$field]));
			
			$set_string .= ($i?', ':'')."\n" . $field . ' = "' . $_POST[$field] . '"';
			$value_string .= ($i?',':'')."\n" . '"' . $_POST[$field] . '"';
			$i++;
		}
		
		$query = 'INSERT INTO '.$this->table_name.'('.$field_string.') VALUES('.$value_string.')';
		
		if($update_duplicate) $query .= ' ON DUPLICATE KEY UPDATE '.$set_string;
		
		//die($query);
		echo $query.'<br>';
		$id = $this->runQuery($query);
		
		return $id;
	}
	
	
	function mailAdmin($type, $array = array()){
    	$writers_array = $this->getLookupTable('writers', 'writer_id', 'short_name', 'short_name', true); 
    	if($type == 'new_content'){
        	$subject = 'New content from ' . $writers_array[$array['writer_id']] . ' - ' . $array['title'];
        	$msg = 'http://www.australiangamer.com/admin/content.php?content_id='.$array['id'];
    	} elseif($type == 'ready_to_publish') {
        	$subject = 'Content ready to publish - ' . $array['title'];
        	$msg = 'http://www.australiangamer.com/admin/content.php?content_id='.$array['id'];
    	}
    	$email = 'Matt Burgess <matt@australiangamer.com>, Guy Blomberg <yug@australiangamer.com>';
    	// Additional headers
		$headers = 'To: Matt Burgess <matt@australiangamer.com>, Guy Blomberg <yug@australiangamer.com>' . "\r\n";
		$headers .= 'From: Australian Gamer Content Management <noreply@australiangamer.com>' . "\r\n";
    	$headers .= 'Reply-To: '.strtolower($writers_array[$array['writer_id']]).'@australiangamer.com'. "\r\n";
        mail($email,$subject,$msg, $headers);
    }
    
    

	

/**
 * Replaces double line-breaks with paragraph elements.
 *
 * A group of regex replaces used to identify text formatted with newlines and
 * replace double line-breaks with HTML paragraph tags. The remaining
 * line-breaks after conversion become <<br />> tags, unless $br is set to '0'
 * or 'false'.
 *
 * @since 0.71
 *
 * @param string $pee The text which has to be formatted.
 * @param int|bool $br Optional. If set, this will convert all remaining line-breaks after paragraphing. Default true.
 * @return string Text which has been converted into correct paragraph tags.
 */
	function autop($pee, $br = true) {
		if ( trim($pee) === '' )
			return '';
			//$pee = str_replace('\r\n', '\n\n', $pee);
		$pee = $pee . "\n"; // just to make things a little easier, pad the end
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
		
		// Space things out a little
		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr)';
		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
		$pee = str_replace(array('\r\n', '\r'), "\n", $pee); // cross-platform newlines
		

	if ( strpos($pee, '<object') !== false ) {
			$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
			$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
		}
		$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
		// make paragraphs, including one at the end
		$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
		
		
		//$GLOBALS['debug']->printr($pees, true);
		$pee = '';
		foreach ( $pees as $tinkle ){
			$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
			$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
			$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
			$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
			$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
			$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
			$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
			$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
			$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
			if ($br) {
				$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', create_function('$matches', 'return str_replace("\n", "<WPPreserveNewline />", $matches[0]);'), $pee);
				$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
				$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
			}
			$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
			$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
			if (strpos($pee, '<pre') !== false)
				$pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee );
			$pee = preg_replace( "|\n</p>$|", '</p>', $pee );
			
			$pee = preg_replace( "|</p>\n<p>|", "</p>\n\n<p>", $pee );
		}
			//$pee = preg_replace('/<p>\s*?(' . '' . ')\s*<\/p>/s', '$1', $pee); // don't auto-p wrap shortcodes that stand alone
		return $pee;
	}

	function getCar($id = false){
		$query = 'SELECT * FROM cars WHERE id = '.($id?$id:'DAYOFYEAR(NOW())');
		return Site::getData($query, true);
	}
	
	function getAdminFormattedUsers(){
		$query = 'SELECT ID, CONCAT_WS(" - ", dealership_name, fullname) as dealer FROM auction_users WHERE group_id != 1 AND country_id = 2 ORDER BY dealership_name ASC, fullname ASC';
		return Site::getData($query, false, 'ID', 'dealer');
	}
	
}



?>