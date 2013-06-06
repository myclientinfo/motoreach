<link type="text/css" href="/css/excite-bike/jquery-ui-1.8rc3.custom.css" rel="Stylesheet" />
		<script src="/js/jquery-ui-1.8rc3.custom.min.js"></script>
	<script>
	
	jQuery(document).ready(function(){
		
		$(function() {
			$("#slider-range").slider({
				range: true,
				orientation: "vertical",
				min: 0,
				max: 100000,
				values: [10000, 40000],
				slide: function(event, ui) {
					$("#amount").val('$' + ui.values[0] + ' - $' + ui.values[1]);
				}
			});
			$("#amount").val('$' + $("#slider-range").slider("values", 0) + ' - $' + $("#slider-range").slider("values", 1));
		});

		if($('#make_id')){
			$('#make_id').change(function(e){
				var option_string = '';
				$.each(make_models[$('#make_id').val()], function(key, value) {
					option_string += '<option value="' + key + '">' + value + '</option>\n';
				});
				$('#model_id').html(option_string);
			});
			
		}
		
		$('#advanced_search_on').click(function(){
			$(this).hide();
			$('#advanced_search_off').show();
			$('#advanced_search_box').slideDown();
			
		});
		
		$('#advanced_search_off').click(function(){
			$(this).hide();
			$('#advanced_search_on').show();
			$('#advanced_search_box').slideUp();
			
		});
		
	});
	
	</script>
	
	<style>
	#demo-frame > div.demo { padding: 10px !important; }
	#advanced_search_box, #advanced_search_off { display: none; }
	label {width: 100px; display: inline-block; float: left;}
	#search_outer  { width: 250px; float: left;}
	#slider-range_outer { width: 30px; float: left;}
	#advanced_search_outer {width: 350px; float: left;}
	#advanced_search_on, #advanced_search_off {padding: 4px; margin-bottom: 5px; cursor: pointer; cursor: hand;}
	#year_min, #year_max {width: 50px;}
	</style>
	
	<div id="inner_content_blue">
    <h2>Search</h2>    
	
	
	<?php
	
	$make_array = array_combine(array_keys($GLOBALS['make_models']), array_keys($GLOBALS['make_models']));
	echo Site::drawForm('search_form');
	
	echo Site::drawDiv('search_outer');
	echo Site::drawText('amount', @$_POST['amount'], true).BR2;
	echo Site::drawText('year_min', @$_POST['year_min'], true) . ' - ' . Site::drawText('year_max', @$_POST['year_max']) .BR2;
	echo Site::drawSelect('make_id', $make_array, @$_POST['make_id'], '', 'Make').BR2;
	echo Site::drawSelect('model_id', array('select a make'), @$_POST['model_id'], '', 'Model').BR2;
	echo Site::drawSubmitImage('submit_form', '/images/search_button.png');
	echo Site::drawDiv();
	
	echo Site::drawDiv('slider-range_outer');
	echo Site::drawDiv('slider-range').Site::drawDiv();
	echo Site::drawDiv();
	
	echo Site::drawDiv('advanced_search_outer');
	echo Site::drawDiv('advanced_search_on').'Show Advanced Fields'.Site::drawDiv();
	echo Site::drawDiv('advanced_search_off').'Hide Advanced Fields'.Site::drawDiv();
	
	echo Site::drawDiv('advanced_search_box');
	
	echo Site::drawSelect('fuel_type_id', Site::getLookupTable('type_fuel', 'id', 'fuel', 'fuel', false, 'Please Select'), @$_POST['fuel_type_id'], '', 'Fuel Type').BR2;
	echo Site::drawSelect('transmission_type_id', Site::getLookupTable('type_transmission', 'id', 'transmission', 'transmission', false, 'Please Select'), @$_POST['transmission_type_id'], '', 'Transmission').BR2;
	echo Site::drawSelect('drive_type_id', Site::getLookupTable('type_drives', 'id', 'drive', 'drive', false, 'Please Select'), @$_POST['drive_type_id'], '', 'Drive Type').BR2;
	echo Site::drawSelect('body_id', Site::getLookupTable('type_body', 'id', 'body', 'body', false, 'Please Select'), @$_POST['body_id'], '', 'Body Type').BR2;
	echo Site::drawText('doors', @$_POST['doors'], true).BR2;
	echo Site::drawDiv();
	echo Site::drawDiv();
	
	
	echo Site::drawForm();
	echo Site::drawDiv('', true);
	
	?>
	<br>
	</div>
	
	<div id="item_history">
		
		<h2>Search Results</h2>
	
	<?php if($listing){ ?>
	<table>
	<?php echo $listing; ?>
	</table>
	<?php } else { ?>
	No results found
	<?php } ?>
	<br><br>

	</div>
