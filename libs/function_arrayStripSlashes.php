<?php

/**
 * 
 *
 * @version $Id: function_arrayStripSlashes.php,v 1.1.1.1 2005/03/02 00:00:13 nicolasconnault Exp $
 * @copyright 2005 
 **/

function arrayStripSlashes($array)
{
	foreach($array as $k => $v){
		if(is_string($v))
			$array[$k] = stripslashes($v);
	}
	return $array;
}
?>