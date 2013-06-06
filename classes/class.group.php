<?php
class Group extends Site{
	var $table_alias = 'g';	var $table_name = 'groups';	var $table_fields = array('id', 'group_name', 'active');	var $field_list = 'g.*';	var $list_header = array('id','group_name','active');	
	var $table_field_mapping = array(		'id' => array('type' => 'hidden'),		'group_name' => array('type' => 'smalltext'),		'active' => array('type' => 'no_yes')	);				function save(){				return parent::save();	}	
}?>