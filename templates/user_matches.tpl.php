
		
		
		</script>
		
		<div id="inner_content_white">
		
			<h2>Vehicles That Match Your Preferences</h2>
			
			<div class="form_left">
	
		<h3>your matches</h3>

		<p>These vehicles are currently on sale and match your listed interests. Click on the link to see more about the vehicle, and if you wish to ask any questions, contact the seller.</p>

	</div>
		
			
			<?php if(is_array($user_matches) && !empty($user_matches)){ ?>
			<table class="items">
			<tr>
                <th>Vehicle Details</th>
                <th>Colour</th>
                <th>Sale Closes</th>
            </tr>
			<?php foreach($user_matches as $v){ ?>
            <tr>
                <td><b><a href="/items.php?itemID=<?php echo $v['ID']?>"><?php echo $v['year']?> <?php echo $v['make']?> <?php echo $v['model']?> <?php echo $v['badge']?></a></b></td>
                <td><?php echo $v['colour']?></td>
                <td><?php echo date(DATE_TIME, $v['auction_end']) ?></td>
            </tr>
			<?php } ?>
			</table>
			<?php } else { ?>
			<div style="float: right; width: 700px;">There are currently no vehicles that match your preferences. You may wish to <a href="/user/editaccount.php?edit=match">edit your preferences</a>.</div>
		
			
			<?php } ?>
			
		</div>