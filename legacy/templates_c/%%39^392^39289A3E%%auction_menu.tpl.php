<?php /* Smarty version 2.6.6, created on 2010-03-09 12:35:10
         compiled from auction_menu.tpl */ ?>
<!-- BEGINNING MENU TEMPLATE -->
<div id="menu">	
	<ul>
		<li id="two"><a href="login.php" title="Log in to Silent auction." accesskey="2">log in</a></li>
		<li id="three"><a href="register.php" title="Registration page for OpUSA Silent Auction." accesskey="3">register</a></li>
		<li id="four"><a href="editaccount.php" title="My Account Information." accesskey="4">my account</a></li>
		<li id="five"><a href="submititem.php" title="Contribute an item to the auction." accesskey="5">contribute an item</a></li>
		<?php if ($this->_tpl_vars['authorised'] == 'valid'): ?><li id="seven"><a href="index.php?logout" title="Log out" accesskey="7">Log out</a></li><?php endif; ?>
	</ul>		
</div>
<!-- END MENU TEMPLATE -->
<!-- BEGINNING OF BODY -->