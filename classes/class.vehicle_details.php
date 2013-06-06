<?php

class VehicleDetails extends Site{
	
	var $table_alias = 'vd';

	var $table_name = 'vehicle_details';
	
	var $table_fields = array('auction_id', 'id', 'ID', 'userID','mileage','build_month', 'year', 'comp_month', 'comp_year', 'startprice', 
							'buyoutprice', 'spend', 'statusID','model_id', 'make_id', 'auctionlength', 'dateentered', 'auction_end', 
							'badge_id', 'series_id', 'sale_type_id',  'max_requests',  'registration', 'colour_id',
							'transmission_id', 'body_id', 'drive_type_id', 'fuel_type_id', 'roof_type_id', 'interior_type_id', 
							'interior_colour_id', 'doors', 'cylinders', 'engine_size', 'description', 'sell_reason', 'import', 'VIN', 
							'flood_affected', 'upgrade', 'admin_entered', 'nct_year', 'nct_month', 'rego_number');
	
	var $save_skip = array('userID', 'make_id','startprice','buyoutprice','description', 'auctionlength', 'sale_type_id', 'currentprice','dateentered', 'auction_end', 'statusID', 'admin_entered' );
	
	var $field_list = 'CONCAT_WS(" ", vd.year, mk.make, md.model, bdg.badge, s.series) as vehicle, a.*,vd.*, u.*, md.make_id, mk.make, md.model, l.length, tc.colour, tic.colour as interior_colour, interior, body, fuel, transmission, body, roof, drive, bdg.badge, s.series, admin_entered, st.state as text_state, a.ID, nct_year, nct_month';
	
	var $list_header = array('auction_id','dealership_name', 'fullname', 'vehicle', 'dateentered', 'auction_end');

	var $table_field_mapping = array(
		'id' => array('type' => 'hidden'),
		'auction_id' => array('type' => 'hidden'),
		'engine_size' => array('type' => 'hidden'),
		'auction_id' => array('type' => 'join', 'link' => 'true', 'table' => 'auction_items', 'as' => 'a', 'on' => 'a.ID = vd.auction_id', 'label'=>'ID'),
		'userID' => array('type' => 'join', 'link' => 'true', 'table' => 'auction_users', 'as' => 'u', 'on' => 'a.userID = u.ID'),
		'model_id' => array('type' => 'join', 'link' => 'true', 'table' => 'models', 'as' => 'md', 'on' => 'md.id = vd.model_id'),
		'make_id' => array('type' => 'join', 'link' => 'true', 'table' => 'makes', 'as' => 'mk', 'on' => 'mk.id = md.make_id'),
		'series_id' => array('type' => 'join', 'link' => 'true', 'table' => 'series', 'as' => 's', 'on' => 's.id = vd.series_id'),
		'badge_id' => array('type' => 'join', 'link' => 'true', 'table' => 'badges', 'as' => 'bdg', 'on' => 'bdg.id = vd.badge_id'),
		'sale_type_id' => array('type' => 'hidden'),
		'max_requests' => array('type' => 'manual_select', 'label' => 'Requests'),
		'auctionlength' => array('type' => 'select', 'link' => 'true', 'table' => 'auction_lengths', 'as' => 'l', 'on' => 'l.id = a.auctionlength', 'key'=> 'id', 'value'=>'length', 'label' => 'List for'),
		'transmission_id' => array('type' => 'select', 'link' => 'true', 'table' => 'type_transmission', 'as' => 'tt', 'on' => 'tt.id = vd.transmission_id', 'key'=> 'id', 'value'=>'transmission', 'label' => 'Transmission'),
		'body_id' => array('type' => 'select', 'link' => 'true', 'table' => 'type_body', 'as' => 'tb', 'on' => 'tb.id = vd.body_id', 'key'=> 'id', 'value'=>'body', 'label' => 'Body'),
		'drive_type_id' => array('type' => 'select', 'link' => 'true', 'table' => 'type_drives', 'as' => 'td', 'on' => 'td.id = vd.drive_type_id', 'key'=> 'id', 'value'=>'drive', 'label' => 'Drive'),
		'fuel_type_id' => array('type' => 'select', 'link' => 'true', 'table' => 'type_fuel', 'as' => 'tf', 'on' => 'tf.id = vd.fuel_type_id', 'key'=> 'id', 'value'=>'fuel', 'label' => 'Fuel'),
		'roof_type_id' => array('type' => 'select', 'link' => 'true', 'table' => 'type_roofs', 'as' => 'tr', 'on' => 'tr.id = vd.roof_type_id', 'key'=> 'id', 'value'=>'roof', 'label' => 'Roof'),
		'colour_id' => array('type' => 'select', 'link' => 'true', 'table' => 'type_colours', 'as' => 'tc', 'on' => 'tc.id = vd.colour_id', 'key'=> 'id', 'value'=>'colour', 'label' => 'Colour'),
		'interior_type_id' => array('type' => 'select', 'link' => 'true', 'table' => 'type_interiors', 'as' => 'ti', 'on' => 'ti.id = vd.interior_type_id', 'key'=> 'id', 'value'=>'interior', 'label' => 'Interior'),
		'interior_colour_id' => array('type' => 'select', 'link' => 'true', 'table' => 'type_colours', 'as' => 'tic', 'on' => 'tic.id = vd.interior_colour_id', 'key'=> 'id', 'value'=>'colour', 'label' => 'Interior Colour'),
		'state' => array('type' => 'select', 'link' => 'true', 'table' => 'states', 'as' => 'st', 'on' => 'st.id = u.state', 'key'=> 'id', 'value'=>'state', 'label' => 'State'),
		'description'=> array('type'=>'longtext', 'label' => 'Comments'),
		'sell_reason'=> array('type'=>'longtext'),
		'startprice'=> array('type'=>'hidden'),
		'buyoutprice'=> array('type'=>'hidden'),
		'build_month' => array('type' => 'manual_select', 'label' => 'Build Date'),
		'year' => array('type' => 'smalltext', 'label' => false),
		'comp_month' => array('type' => 'manual_select', 'label' => 'Compliance Date'),
		'comp_year' => array('type' => 'smalltext', 'label' => false),
		'doors' => array('type' => 'manual_select', 'label' => 'Doors'),
		'cylinders' => array('type' => 'manual_select', 'label' => 'Cylinders'),
		'registration' => array('type' => 'manual_select', 'label' => 'Rego'),
		'import' => array('type' => 'yes_no'),
		'VIN' => array('type' => 'hidden'),
		'flood_affected' => array('type' => 'hidden'),
		'upgrade' => array('type' => 'hidden'),
		'ID' => array('type' => 'hidden'),
		'categoryID' => array('type' => 'hidden'),
		'finalprice' => array('type' => 'hidden'),
		'currentprice' => array('type' => 'hidden'),
		'increment' => array('type' => 'hidden'),
		'processed' => array('type' => 'hidden'),
		'dateentered' => array('type' => 'timestamp', 'label'=>'Listed'),
		'auction_end' => array('type' => 'timestamp'),
		'statusID' => array('type' => 'select', 'link' => 'true', 'table' => 'auction_status', 'as' => 'aus', 'on' => 'a.statusID = aus.id', 'key'=> 'id', 'value'=>'status', 'label' => 'Status'),
		'admin_entered' => array('type' => 'hidden')
		);
	
	function __construct($id, $list, $admin = false, $table_name = '', $content_type = '', $where = false){
		
		
		
		if($id){
			$this->data = $this->getOne($id);
			$this->id = $id;
		}
		if($where) $this->where = $where;
		if($list){
			$this->data_listing = $this->getAll($admin, $admin);
		}
		
	}
	
	function getOne($id){
		$query = 'SELECT ' . $this->field_list . ' FROM vehicle_details AS vd
					 LEFT JOIN auction_items AS a ON a.ID = vd.auction_id
					 LEFT JOIN auction_lengths AS l ON l.id = a.auctionlength
					 LEFT JOIN auction_users AS u ON a.userID = u.ID
					 LEFT JOIN states AS st ON st.id = u.state
					 LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
					 LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'series AS s ON s.id = vd.series_id
					 LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bdg ON bdg.id = vd.badge_id
					 LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id
					 LEFT JOIN type_transmission AS tt ON tt.id = vd.transmission_id
					 LEFT JOIN type_body AS tb ON tb.id = vd.body_id
					 LEFT JOIN type_drives AS td ON td.id = vd.drive_type_id
					 LEFT JOIN type_fuel AS tf ON tf.id = vd.fuel_type_id
					 LEFT JOIN type_roofs AS tr ON tr.id = vd.roof_type_id
					 LEFT JOIN type_colours AS tc ON tc.id = vd.colour_id
					 LEFT JOIN type_interiors AS ti ON ti.id = vd.interior_type_id
					 LEFT JOIN type_colours AS tic ON tic.id = vd.interior_colour_id
					 LEFT JOIN auction_status AS aus ON a.statusID = aus.id
					 WHERE a.ID = '.$id;
					 
		return Site::getData($query, true);
	}
	
	
	function getAll($id){
		$query = 'SELECT SQL_CALC_FOUND_ROWS ' . $this->field_list . ' FROM vehicle_details AS vd
					 LEFT JOIN auction_items AS a ON a.ID = vd.auction_id
					 LEFT JOIN auction_lengths AS l ON l.id = a.auctionlength
					 LEFT JOIN auction_users AS u ON a.userID = u.ID
					 LEFT JOIN states AS st ON st.id = u.state
					 LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'models AS md ON md.id = vd.model_id
					 LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'series AS s ON s.id = vd.series_id
					 LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'badges AS bdg ON bdg.id = vd.badge_id
					 LEFT JOIN '.$_SESSION['l10n']['table_prefix'].'makes AS mk ON mk.id = md.make_id
					 LEFT JOIN type_transmission AS tt ON tt.id = vd.transmission_id
					 LEFT JOIN type_body AS tb ON tb.id = vd.body_id
					 LEFT JOIN type_drives AS td ON td.id = vd.drive_type_id
					 LEFT JOIN type_fuel AS tf ON tf.id = vd.fuel_type_id
					 LEFT JOIN type_roofs AS tr ON tr.id = vd.roof_type_id
					 LEFT JOIN type_colours AS tc ON tc.id = vd.colour_id
					 LEFT JOIN type_interiors AS ti ON ti.id = vd.interior_type_id
					 LEFT JOIN type_colours AS tic ON tic.id = vd.interior_colour_id
					 LEFT JOIN auction_status AS aus ON a.statusID = aus.id';
		$query .= ' WHERE 1';
		
		$get_vars = Site::getGetVars();
		
		if($this->where) $query .= ' AND '.$this->where;
		$query .= ' ORDER BY '.$get_vars['order_by'].' '.$get_vars['order_direction']."\n"; 
		$query .= ' LIMIT ' . $get_vars['offset'] . ',' . $get_vars['records_displayed']."\n";
		
		$data = Site::getData($query);
		return $data;
	}
	
	function save(){
		
		if((int)$_POST['auction_id'] == 0 && $_POST['dateentered']==''){
			$_POST['dateentered'] = time();
			$lis = Auction::getAuctionLength($_POST['auctionlength']);
			$_POST['auction_end'] = time() + $lis;
		}
		
		$auction = new Extend_Auction($_POST['auction_id'], false, true, 'auction_items');
		$auction_id = $auction->save();
		
		$is_new = $_POST['auction_id'] == '' ||$_POST['auction_id'] == 0 ? true : false;
		
		unset($_POST['ID']);
		
		$_POST['id'] = @$_POST['vd_id'];
		$_POST['auction_id'] = $auction_id;
		parent::save();
		
		if($is_new){
			$query = 'INSERT INTO auction_bids(itemID, userID, datesubmitted, amount, statusID, typeID) VALUES('.$auction_id.', '.$_POST['userID'].', '.time().', "", 1, 2)';
			Site::runQuery($query);
		}
		
		return $auction_id;
	}
	
}
?>