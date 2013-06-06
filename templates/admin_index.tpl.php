
<div id="inner_content_white">
	
	<h2>Admin Home</h2>
	
	<div class="form_left">
		
		<p>Additional functionality is yet to be added, including full reporting and a range of listing and editing options.</p>
		
		<p>If you have any questions about the functionality available please contact <a href="mailto:matt@motoreach.com">matt@motoreach.com</a></p>
		
		<p style="margin-bottom: 0px;"><b>Permissions</b></p>
		
		<?php 
		foreach($_SESSION['permissions'] as $p) { 
			if(in_array($p, array('Login', 'Admin', 'Browse', 'List', 'Request', 'Match', 'Send Match'))) continue;
		}
		?>
		
	</div>
	
	<ul id="admin_list" style="display: block; width: 650px; float: left; margin-left: 50px; margin-top: 0px;">
		
		<li><a href="reporting/">Reporting</a><br />Currently under construction to add further functionality</li>
		
		<!--<li><a href="tasks.php">Task List</a><br />Currently under construction to add further functionality</li>-->
		<li><a href="items.php">Vehicles</a><br />Edit existing vehicles or create new vehicle listings.</li>
		<li><a href="users.php">Edit Users</a><br />List and then edit all MotoReach users and set permissions. (<a href="users.php?approve">Approve</a>)</li>
		<li><a href="list.php">Manage Vehicle List</a><br />Edit make and model database, and add new information</li>
		<li><a href="group.php">Manage Dealer Groups</a><br />Add and edit Groups dealers can belong to (Zupps, Motorama, etc)<br /></li>
		<li><a href="clear_cache.php">Clear Cache</a><br />Remove saved dropdown data and force it to restore from database</li>
		
	</ul>
	
</div>