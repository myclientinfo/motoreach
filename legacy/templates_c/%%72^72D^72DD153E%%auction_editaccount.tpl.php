<?php /* Smarty version 2.6.6, created on 2010-03-09 12:34:34
         compiled from auction_editaccount.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'curr', 'auction_editaccount.tpl', 108, false),array('block', 'timeleft', 'auction_editaccount.tpl', 113, false),array('modifier', 'date_format', 'auction_editaccount.tpl', 111, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_header_inner.tpl", 'smarty_include_vars' => array('title' => ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction -- My Account")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_menu_inner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="pagebody">
	
	<div id="leftstatic">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_sidebar_inner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="contents" class="wide"
		<span id="loggedin" >		
			<?php if ($this->_tpl_vars['authorised'] == 'valid'): ?>
				You are logged in as <?php echo $this->_tpl_vars['user']->fullname; ?>

			<?php else: ?>	
				You are not <a href="login.php">logged in</a>	
			<?php endif; ?>
		</span>
		<h1>Silent Auction -- My Account</h1>
		<?php if ($this->_tpl_vars['authorised'] == 'valid'): ?>
			<p>On this page you may edit and view your user details, and view your bids and items on auction.</p>
			<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
			<form name="changedetails" action="editaccount.php" method="post">
			<input type="hidden" name="formdata" value="update" />
			<input type="hidden" name="alias" value="<?php echo $this->_tpl_vars['user']->alias; ?>
" />
			<!--<input type="hidden" name="debug" value="1" />-->
			<table>
				<caption>Your details</caption>
				<tr>
					<th>Full Name</th>
					<td><?php echo $this->_tpl_vars['user']->fullname; ?>
</td>
				</tr>
				<tr>
					<th>Alias</th>
					<td><?php echo $this->_tpl_vars['user']->alias; ?>
</td>
				</tr>
				<tr>
					<th>New Password</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'password'): ?>class="error"<?php endif; ?> type="password" name="password" />
					</td>
				</tr>
				<tr>
					<th>Confirm New Password</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'confirmpassword'): ?>class="error"<?php endif; ?> type="password" name="confirmpassword" />
					</td>
				</tr>
				<tr>
					<th>Street Address</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'streetaddress'): ?>class="error"<?php endif; ?> type="text" name="streetaddress" value="<?php echo $this->_tpl_vars['user']->streetaddress; ?>
" />
					</td>
				</tr>
				<tr>
					<th>City</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'city'): ?>class="error"<?php endif; ?> type="text" name="city" value="<?php echo $this->_tpl_vars['user']->city; ?>
" />
					</td>
				</tr>
				<tr>
					<th>State</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'state'): ?>class="error"<?php endif; ?> type="text" name="state" value="<?php echo $this->_tpl_vars['user']->state; ?>
" />
					</td>
				</tr>
				<tr>
					<th>Zip/Postal Code</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'zip'): ?>class="error"<?php endif; ?> type="text" name="zip" value="<?php echo $this->_tpl_vars['user']->zip; ?>
" />
					</td>
				</tr>
				<tr>
					<th>E-mail</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'email'): ?>class="error"<?php endif; ?> size="60" type="text" name="email" value="<?php echo $this->_tpl_vars['user']->email; ?>
" />
					</td>
				</tr>
				<tr>
					<th>Country</th>
					<td><select name="country"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_countries.tpl", 'smarty_include_vars' => array('country' => $this->_tpl_vars['user']->country)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></select></td>
				</tr>
				<tr>
					<th>Phone Number</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'phone'): ?>class="error"<?php endif; ?> type="text" name="phone" value="<?php echo $this->_tpl_vars['user']->phone; ?>
" />
					</td>
				</tr>
				<tr>
					<td><input type="submit" value="Update" /></td></tr>
			</table>
			</form>
				
			</table>
			
			<table class="items">
				<caption>Items you are bidding on (<span class="winning">winning bids</span>)</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Starting Price</th>
					<th>Current Price</th>
					<th>Number of Bids</th>
					<th>Date Entered</th>
					<th>End date</th>
					<th>Time Left</th>
				</tr>
				<?php if (count($_from = (array)$this->_tpl_vars['items_user_is_buying'])):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr class="<?php if ($this->_tpl_vars['v']->winning == true): ?>winning<?php else: ?>losing<?php endif; ?>">				
						<td><a href="items.php?itemID=<?php echo $this->_tpl_vars['v']->ID; ?>
"><?php echo $this->_tpl_vars['v']->name; ?>
</a></td>
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->startprice;  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
						<td><?php echo $this->_tpl_vars['v']->getNumberOfBids(); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['v']->dateentered)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['v']->auctionend)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
						<td><?php $this->_tag_stack[] = array('timeleft', array()); smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getSecondsLeft();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
					</tr>
				<?php endforeach; unset($_from); endif; ?>
			</table>
			<br />
			<table class="items">
				<caption>Items you are selling</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Starting Price</th>
					<th>Current Price</th>
					<th>Number of Bids</th>
					<th>Date Entered</th>
					<th>End date</th>
					<th>Time Left</th>
				</tr>
				<?php if (count($_from = (array)$this->_tpl_vars['items_user_is_selling'])):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr>				
						<td><a href="items.php?itemID=<?php echo $this->_tpl_vars['v']->ID; ?>
"><?php echo $this->_tpl_vars['v']->name; ?>
</a></td>
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->startprice;  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
						<td><?php echo $this->_tpl_vars['v']->getNumberOfBids(); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['v']->dateentered)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['v']->auctionend)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
						<td><?php $this->_tag_stack[] = array('timeleft', array()); smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getSecondsLeft();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
					</tr>
				<?php endforeach; unset($_from); endif; ?>
			</table>
			<br />
			<table class="items">
				<caption>Items you have won</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Final Price</th>
					<th>Number of Bids</th>
					<th>Date Won</th>			
				</tr>
				<?php if (count($_from = (array)$this->_tpl_vars['items_user_has_won'])):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr>				
						<td><a href="items.php?itemID=<?php echo $this->_tpl_vars['v']->ID; ?>
"><?php echo $this->_tpl_vars['v']->name; ?>
</a></td>				
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
						<td><?php echo $this->_tpl_vars['v']->getNumberOfBids(); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['v']->auctionend)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
					</tr>
				<?php endforeach; unset($_from); endif; ?>
			</table>
			<br />
			<table class="items">
				<caption>Items you have lost</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Final Price</th>
					<th>Number of Bids</th>
					<th>Date Ended</th>			
				</tr>
				<?php if (count($_from = (array)$this->_tpl_vars['items_user_has_lost'])):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr>				
						<td><a href="items.php?itemID=<?php echo $this->_tpl_vars['v']->ID; ?>
"><?php echo $this->_tpl_vars['v']->name; ?>
</a></td>				
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
						<td><?php echo $this->_tpl_vars['v']->getNumberOfBids(); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['v']->auctionend)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
					</tr>
				<?php endforeach; unset($_from); endif; ?>
			</table>
			<br />
			<table class="items">
				<caption>Items you have sold</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Final Price</th>
					<th>Number of Bids</th>
					<th>Date Sold</th>			
				</tr>
				<?php if (count($_from = (array)$this->_tpl_vars['items_user_has_sold'])):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr>				
						<td><a href="items.php?itemID=<?php echo $this->_tpl_vars['v']->ID; ?>
"><?php echo $this->_tpl_vars['v']->name; ?>
</a></td>				
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
						<td><?php echo $this->_tpl_vars['v']->getNumberOfBids(); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['v']->auctionend)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
					</tr>
				<?php endforeach; unset($_from); endif; ?>
			</table>
			<br />
			<table class="items">
				<caption>Items you have not sold</caption>
				<tr>			
					<th class="name">Name</th>
					<th>Final Price</th>
					<th>Number of Bids</th>
					<th>Date Ended</th>			
				</tr>
				<?php if (count($_from = (array)$this->_tpl_vars['items_user_has_not_sold'])):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr>				
						<td><a href="items.php?itemID=<?php echo $this->_tpl_vars['v']->ID; ?>
"><?php echo $this->_tpl_vars['v']->name; ?>
</a></td>				
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['v']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
						<td><?php echo $this->_tpl_vars['v']->getNumberOfBids(); ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['v']->auctionend)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
					</tr>
				<?php endforeach; unset($_from); endif; ?>
			</table>
		<?php else: ?>
			<p>Before you can use this page, you must be either <a href="login.php">logged in</a> or <a href="register.php">registered</a>.</p>
		<?php endif; ?>					
	</div><!-- end contents -->
	
	</div><!-- end leftstatic -->
	
</div><!-- end pagebody -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_footer_inner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
</body>
</html>
