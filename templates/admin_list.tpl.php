<script>
jQuery(document).ready(function(){
	var action = '';
	$('.edit, .add, .delete').click(function(){
		$('#action').val($(this).attr('id'));
		action = $(this).attr('id').split('_');
		$('.edit_text, .save').hide();
		$('#edit_'+action[1]+'_text').val('');
		if(action[0] != 'delete'){
			$('#edit_'+action[1]+'_text').show();
			$('#edit_'+action[1]+'_button').show();
		}
		if(action[0]=='edit'){
			$('#edit_'+action[1]+'_text').val($('#'+action[1]+'_id option:selected').text());
		} else if(action[0]=='delete'){
			$('.save').trigger('click');
		}
		
	});
	$('.save').click(function(){
		$.post("/api/edit_list.php", $("#newitem").serialize(), function(data){
			if(data!='FAILED'){
				$('.edit_text').val('');
				$('.edit_text, .save').hide();
				newAlert('Changes have been saved, but cache has not been updated. Please clear the cache if you need to see these changes.', 'stop');
				//window.location = '/admin/list.php?make_id='+$('#make_id').val()+'&model_id='+$('#model_id').val();
			}
		});
	});
	
	
	
	<?php if(isset($_GET['new'])){ ?>
	newAlert('vehicle data updated', 'alert');
	<?php } ?>
	
	<?php if(isset($_GET['make_id'])){ ?>
	$('#make_id').val("<?php echo @$_GET['make_id'] ?>");
	$('#make_id').trigger('change');
	$('#model_id').val("<?php echo @$_GET['model_id'] ?>");
	$('#model_id').trigger('change');
	<?php } ?>
});
</script>

<style>
#newitem  {
	margin-left: 200px;
}

.edit_text, .save {
	display: none;
	margin-left: 10px;
}

.save {
	position: absolute;
}

img.add, img.edit, img.delete {
	margin-left: 5px;
	position: relative;
	top: 3px;
	cursor: pointer;
	cursor:  hand;
}

.list_bar {
	height: 40px;
}

</style>

<div id="inner_content_white">

	<h2>Edit Vehicle List</h2>
	
	<a href="index.php">Admin Home</a><br /><br />
	
	<div class="form_left">
		<p>Click the edit button to change details of the current dropdown. Click add to make a new one. New models are added to the make selected. New series/badges are added to the model selected.</p>
		
		<p>Once you have finished your changes hit <em>reload</em> to update all of the dropdowns.</p>
	</div>
	
	<?php
	$make_array = array_combine(array_keys($GLOBALS['make_models']), array_keys($GLOBALS['make_models']));
	echo Site::drawDiv('right_content');
	echo Site::drawForm('newitem');
	echo Site::drawHidden('action','');
	echo Site::drawDiv('make_bar', false, array('class'=>'list_bar'));
	

	echo Site::drawSelect('make_id', $make_array, @$_POST['make_id'], '', 'make');
	echo Site::drawImage('add_make', '/images/add.png', array('title'=>'add new make', 'class'=>'add'));
	echo Site::drawImage('delete_make', '/images/delete.png', array('title'=>'delete make', 'class'=>'delete'));
	echo Site::drawImage('edit_make', '/images/pencil.png', array('title'=>'edit make', 'class'=>'edit'));
	echo Site::drawText('edit_make_text', false, false, array('class'=>'edit_text'));
	echo Site::drawImage('edit_make_button', '/images/button_sm_save.png', array('class'=>'save'));
	echo Site::drawDiv();
	
	echo Site::drawDiv('model_bar', false, array('class'=>'list_bar'));
	echo Site::drawSelect('model_id', array(''=>'select a make'), @$_POST['model_id'], '', 'model');
	echo Site::drawImage('add_model', '/images/add.png', array('title'=>'add model to above make', 'class'=>'add'));
	echo Site::drawImage('delete_model', '/images/delete.png', array('title'=>'delete model', 'class'=>'delete'));
	echo Site::drawImage('edit_model', '/images/pencil.png', array('title'=>'edit model', 'class'=>'edit'));
	echo Site::drawText('edit_model_text', false, false, array('class'=>'edit_text'));
	echo Site::drawImage('edit_model_button', '/images/button_sm_save.png', array('class'=>'save'));
	echo Site::drawDiv();
	
	echo Site::drawDiv('badge_bar', false, array('class'=>'list_bar'));
	echo Site::drawSelect('badge_id', array('select a model'), @$_POST['badge_id'], '', 'badge');
	echo Site::drawImage('add_badge', '/images/add.png', array('title'=>'add badge to above model', 'class'=>'add'));
	echo Site::drawImage('delete_badge', '/images/delete.png', array('title'=>'delete badge', 'class'=>'delete'));
	echo Site::drawImage('edit_badge', '/images/pencil.png', array('title'=>'edit badge', 'class'=>'edit'));
	echo Site::drawText('edit_badge_text', false, false, array('class'=>'edit_text'));
	echo Site::drawImage('edit_badge_button', '/images/button_sm_save.png', array('class'=>'save'));
	echo Site::drawDiv();
	
	echo Site::drawDiv('series_bar', false, array('class'=>'list_bar'));
	echo Site::drawSelect('series_id', array('select a model'), @$_POST['series_id'], '', 'series');
	echo Site::drawImage('add_series', '/images/add.png', array('title'=>'add series to above model', 'class'=>'add'));
	echo Site::drawImage('delete_series', '/images/delete.png', array('title'=>'delete series', 'class'=>'delete'));
	echo Site::drawImage('edit_series', '/images/pencil.png', array('title'=>'edit series', 'class'=>'edit'));
	echo Site::drawText('edit_series_text', false, false, array('class'=>'edit_text'));
	echo Site::drawImage('edit_series_button', '/images/button_sm_save.png', array('class'=>'save'));
	echo Site::drawDiv();
	
	echo Site::drawForm();
	echo Site::drawDiv();
	?>
	<div style="margin-left: 400px;"><a href="clear_cache.php">Refresh Data</a></div>
</div>