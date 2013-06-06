<?php /* Smarty version 2.6.6, created on 2010-03-09 11:58:10
         compiled from auction_submititem.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'curr', 'auction_submititem.tpl', 128, false),array('block', 'timeleft', 'auction_submititem.tpl', 147, false),array('modifier', 'date_format', 'auction_submititem.tpl', 148, false),)), $this); ?>

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
		<h1>Silent Auction -- Submitting a new object</h1>
		<?php if ($this->_tpl_vars['authorised'] == 'valid'): ?>
					<?php if ($this->_tpl_vars['stage'] == 'submission'): ?>
				<p>Please enter the details of the item you want to offer for sale on this auction site.</p>
				<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>

				<form enctype="multipart/form-data" name="newitem" action="submititem.php" method="post">
				<input type="hidden" name="stage" value="submission" />
				<input type="hidden" name="userID" value="<?php echo $this->_tpl_vars['user']->ID; ?>
" />
				<input type="hidden" name="ID" value="0">
				<input type="hidden" name="processed" value="no">
				<input type="hidden" name="formdata" value="submission" />
			<!--	<input type="hidden" name="debug" value="no">-->
				<table>
					<tr>
						<th>Category</th>
						<td>
							<select <?php if ($this->_tpl_vars['error_field'] == 'categoryID'): ?>class="error"<?php endif; ?> name="categoryID">
								<option value="<?php echo $this->_tpl_vars['listing']['categoryID']; ?>
"><?php echo $this->_tpl_vars['submit_categories'][$this->_tpl_vars['listing']['categoryID']]['name']; ?>
</option>
							<?php if (count($_from = (array)$this->_tpl_vars['submit_categories'])):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
								<option value="<?php echo $this->_tpl_vars['k']; ?>
"><?php echo $this->_tpl_vars['v']['name']; ?>
</option>
							<?php endforeach; unset($_from); endif; ?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Name of item</th>
						<td>
							<input <?php if ($this->_tpl_vars['error_field'] == 'name'): ?>class="error"<?php endif; ?> type="text" name="name" value="<?php echo $this->_tpl_vars['listing']['name']; ?>
" />
						</td>
					</tr>
					<tr>
						<th>Image (50k max)</th>
						<td>
							<input type="hidden" name="MAX_FILE_SIZE" value="100000">
							<input <?php if ($this->_tpl_vars['error_field'] == 'image'): ?>class="error"<?php endif; ?> type="file" name="image" />
						</td>
					</tr>
					<tr>
						<th>Full description</th>
						<td>
							<textarea <?php if ($this->_tpl_vars['error_field'] == 'description'): ?>class="error"<?php endif; ?> name="description" cols="40" rows="12"><?php echo $this->_tpl_vars['listing']['description']; ?>
</textarea>
						</td>
					</tr>
					<tr>
						<th>Starting Price (in US$)</th>
						<td>
							<?php if ($this->_tpl_vars['INCREMENT_TYPE'] == 'proportion'): ?>
                            <input <?php if ($this->_tpl_vars['error_field'] == 'startprice'): ?>class="error"<?php endif; ?> 
                                type="text" name="startprice" value="<?php echo $this->_tpl_vars['listing']['startprice']; ?>
" 
                                onchange="document.getElementById('increment').value=Math.ceil(this.value/<?php echo $this->_tpl_vars['INCREMENT_PROPORTION']; ?>
);"/>
                        <?php else: ?>
                            <input <?php if ($this->_tpl_vars['error_field'] == 'startprice'): ?>class="error"<?php endif; ?> type="text" name="startprice" value="<?php echo $this->_tpl_vars['listing']['startprice']; ?>
" />
                        <?php endif; ?>
						</td>
					</tr>					
                <tr>
						<th>Bid increment<?php if ($this->_tpl_vars['INCREMENT_TYPE'] == 'seller'): ?> (<?php echo $this->_tpl_vars['INCREMENT_MIN']; ?>
 - <?php echo $this->_tpl_vars['INCREMENT_MAX']; ?>
)<?php endif; ?></th>
						<td>
							<?php if ($this->_tpl_vars['INCREMENT_TYPE'] == 'seller'): ?>
                            <input <?php if ($this->_tpl_vars['error_field'] == 'increment'): ?>class="error"<?php endif; ?> type="text" name="increment" 
                            value="<?php echo $this->_tpl_vars['listing']['increment']; ?>
" 
                            onchange="checkIncValues(this, <?php echo $this->_tpl_vars['INCREMENT_MIN']; ?>
, <?php echo $this->_tpl_vars['INCREMENT_MAX']; ?>
); this.focus();" />
                        <?php elseif ($this->_tpl_vars['INCREMENT_TYPE'] == 'proportion'): ?>                            
                            <input id="increment" type="text" readonly="readonly" name="increment" value="0" 
                            style="border:none;"/>
                        <?php elseif ($this->_tpl_vars['INCREMENT_TYPE'] == 'auction'): ?>                            
                            <input type="text" readonly="readonly" name="increment" value="<?php echo $this->_tpl_vars['INCREMENT_VALUE']; ?>
" 
                                style="border:none;" />
                        <?php endif; ?>
						</td>
					</tr>
					<?php if ($this->_tpl_vars['RESERVE'] == 'on'): ?>
                <tr>
						<th>Reserve Price (optional)</th>
						<td>
							<input <?php if ($this->_tpl_vars['error_field'] == 'reserve'): ?>class="error"<?php endif; ?> type="text" name="reserve" value="<?php echo $this->_tpl_vars['listing']['reserve']; ?>
" />
						</td>
					</tr>
                <?php endif; ?>
					<tr>
						<th>Listing length</th>
						<td>
							<select <?php if ($this->_tpl_vars['error_field'] == 'auctionlength'): ?>class="error"<?php endif; ?> name="auctionlength">
								<?php if ($this->_tpl_vars['listing']['auctionlength'] > 0): ?><option selected="selected" value="<?php echo $this->_tpl_vars['listing']['auctionlength']; ?>
"><?php echo $this->_tpl_vars['listing']['auctionlength']; ?>
 Days</option><?php endif; ?>
								<option value="3">3 Days</option>
								<option value="5">5 Days</option>
								<option value="7">7 Days</option>
								<option value="9">9 Days</option>
								<option value="11">11 Days</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="Preview" /></td>
					</tr>
				</table>
				</form>	
			<?php elseif ($this->_tpl_vars['stage'] == 'preview'): ?>
				<p>Here is a preview of your item listing.</p>
				<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
				<h2><?php echo $this->_tpl_vars['item']->name; ?>
</h2>
				<form name="item" method="post" action="submititem.php">
				<input type="hidden" name="formdata" value="confirmation" />
				<input type="hidden" name="itemID" value="<?php echo $this->_tpl_vars['item']->ID; ?>
" />
				<input type="submit" value="Confirm Listing" />
				<table summary="Item Details">
					<tr>
						<td rowspan="8"><img title="Image of <?php echo $this->_tpl_vars['item']->name; ?>
" alt="Image of <?php echo $this->_tpl_vars['item']->name; ?>
" src="<?php echo $this->_tpl_vars['item']->image; ?>
" /></td>
						<th>Starting Price</th>
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['item']->startprice;  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
					</tr>
					<tr>
						<th>Current Price</th>
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['item']->getCurrentPrice();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?><br />
							<input type="submit" value="Place bid" disabled="disabled" />
						</td>
					</tr>
					<tr>
						<th>Number of bids</th>
						<td><?php echo $this->_tpl_vars['item']->getNumberOfBids(); ?>
</td>
					</tr>
					<tr>
						<th>Bid Increments</th>
						<td><?php $this->_tag_stack[] = array('curr', array()); smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['item']->increment;  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_curr($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></td>
					</tr>
					<tr>
						<th>Time left</th>
						<td>
							<?php $this->_tag_stack[] = array('timeleft', array()); smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['item']->getSecondsLeft();  $this->_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_timeleft($this->_tag_stack[count($this->_tag_stack)-1][1], $this->_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?><br />
							<?php echo $this->_tpl_vars['item']->auctionlength; ?>
-day listing, ends <?php echo ((is_array($_tmp=$this->_tpl_vars['item']->auctionend)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A, %B %e, %Y") : smarty_modifier_date_format($_tmp, "%A, %B %e, %Y")); ?>

						</td>
					</tr>
					<tr>
						<th>Start Date</th>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']->dateentered)) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
					</tr>	
					<tr>
						<th>Location</th>
						<td><?php echo $this->_tpl_vars['user']->city; ?>
, <?php echo $this->_tpl_vars['user']->state; ?>
, <?php echo $this->_tpl_vars['user']->country; ?>
.</td>
					</tr>
					<tr>
						<td><a href="<?php echo $this->_tpl_vars['item']->image; ?>
" target="_blank">Larger picture</a></td>
					</tr>	
				</table>
				<hr />
				<h2 style="background-color:#DDDDFF">Description</h2>
				<p><?php echo $this->_tpl_vars['item']->description; ?>
</p>
				<input type="submit" value="Confirm Listing" />
				</form>
			<?php elseif ($this->_tpl_vars['stage'] == 'confirmation'): ?>
				<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
			<?php else: ?>
				<p id="message">There has been an error, please start the item submission process again.</p>
				<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
			<?php endif; ?>
			
				<?php else: ?>
			<p>Before you can submit an item for auction, you must be either <a href="login.php">logged in</a> or <a href="register.php">registered</a>.</p>
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
