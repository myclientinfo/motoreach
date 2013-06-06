<?php /* Smarty version 2.6.6, created on 2010-03-09 13:12:34
         compiled from admin_menu.tpl */ ?>
<!-- BEGINNING MENU TEMPLATE -->
<div id="adminmenu">	
	<ul>	
	<?php if ($this->_tpl_vars['authorised'] == 'admin'): ?>
	<li id="one"><a href="index.php" title="Back to auction website" accesskey="9">Auction Website</a></li>
	<li id="aa"><a href="admin.php" title="Admin panel main page">ADMIN HOME</a></li>
	<li id="bb"><a href="admin_users.php" title="View and edit user accounts">users</a>
	<li id="cc"><a href="admin_items.php" title="View and edit items on auction">items</a>
	<li id="dd"><a href="admin_bids.php" title="View and edit bids">bids</a>
	<li id="ee"><a href="admin_auction.php" title="View and edit auction settings">auction</a>
	<li id="ff"><a href="admin_messages.php" title="Add and edit message constants">messages</a>
	<li id="gg"><a href="admin.php?logout" title="Log out">log out</a>
	<?php else: ?>
		<li id="hh"><a href="admin_login.php" title="Log in as an administrator" accesskey="1">log in</a></li>
		<li id="ii"><a href="index.php" title="Back to auction website" >Auction Website</a></li>
	<?php endif; ?>
	</ul>
</div>
<!-- END MENU TEMPLATE -->