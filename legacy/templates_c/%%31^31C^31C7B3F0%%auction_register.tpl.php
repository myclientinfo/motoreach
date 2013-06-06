<?php /* Smarty version 2.6.6, created on 2010-03-09 12:34:32
         compiled from auction_register.tpl */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_header_inner.tpl", 'smarty_include_vars' => array('title' => ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction -- Register")));
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
	<div id="contents">
		<span id="loggedin" >		
			<?php if ($this->_tpl_vars['authorised'] == 'valid'): ?>
				You are logged in as <?php echo $this->_tpl_vars['user']->fullname; ?>

			<?php else: ?>	
				You are not <a href="login.php">logged in</a>	
			<?php endif; ?>
		</span>
		<h2>Silent Auction -- Registration</h2>
		<?php if ($this->_tpl_vars['authorised'] == 'valid'): ?>
			<p>You have now been registered, and you are logged in as <?php echo $this->_tpl_vars['user']->fullname; ?>
.</p>	
		<?php else: ?>
			<p class="nobold">This is registration form which will allow you to create an account with us, submit items for sale
			and purchase items on auction. Please read the <a href="terms.php">terms and conditions</a> carefully,
			as well as the <a href="privacy.php">Privacy Statement</a> before going any further. You are held 
			responsible for your knowledge of these terms, and we will expect you to abide by them from the moment 
			your account is created.</p>
			
			<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
			<p>Please note that all fields are required.</p>
			
			<form name="newuser" action="register.php" method="post">
			<input type="hidden" name="formdata" value="register" />
			<table>
				<tr>
					<th>Full Name</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'fullname'): ?>class="error"<?php endif; ?> type="text" name="fullname" value="<?php echo $this->_tpl_vars['session']['fullname']; ?>
" />
					</td>
				</tr>
				<tr>
					<th>Alias (Username)</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'alias'): ?>class="error"<?php endif; ?> type="text" name="alias" value="<?php echo $this->_tpl_vars['session']['alias']; ?>
" />
					</td>
				</tr>
				<tr>
					<th>Email Address</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'email'): ?>class="error"<?php endif; ?> type="text" name="email" value="<?php echo $this->_tpl_vars['session']['email']; ?>
" />
					</td>
				</tr>
				<tr>
					<th>Password</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'password'): ?>class="error"<?php endif; ?> type="password" name="password" value="" /> (6-15 alphanumeric characters)
					</td>
				</tr>
				<tr>
					<th>Confirm Password</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'confirmpassword'): ?>class="error"<?php endif; ?> type="password" name="confirmpassword" value="" />
					</td>
				</tr>
				<tr>
					<th>Street Address</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'streetaddress'): ?>class="error"<?php endif; ?> type="text" name="streetaddress" value="<?php echo $this->_tpl_vars['session']['streetaddress']; ?>
" />
					</td>
				</tr>
				<tr>
					<th>City</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'city'): ?>class="error"<?php endif; ?> type="text" name="city" value="<?php echo $this->_tpl_vars['session']['city']; ?>
" />
					</td>
				</tr>
				<tr>
					<th>State</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'state'): ?>class="error"<?php endif; ?> type="text" name="state" value="<?php echo $this->_tpl_vars['session']['state']; ?>
" />
					</td>
				</tr>
				<tr>
					<th>Zip Code</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'zip'): ?>class="error"<?php endif; ?> type="text" name="zip" value="<?php echo $this->_tpl_vars['session']['zip']; ?>
" />
					</td>
				</tr>
				<tr>
					<th>Country</th>
					<td>
						<select  <?php if ($this->_tpl_vars['error_field'] == 'country'): ?>class="error"<?php endif; ?>name="country"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_countries.tpl", 'smarty_include_vars' => array('country' => $this->_tpl_vars['session']['country'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></select>
					</td>
				</tr>
				<tr>
					<th>Phone Number</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'phone'): ?>class="error"<?php endif; ?> type="text" name="phone" value="<?php echo $this->_tpl_vars['session']['phone']; ?>
" />
					</td>
				</tr>
				<tr><td><input type="submit" value="Register" /></td></tr>
			</table>
			
			</form>
		<?php endif; ?>
	</div><!-- end contents -->
<div class="clearer">&nbsp;</div>	
</div><!-- end leftstatic -->

</div><!-- end pagebody -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_footer_inner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
</body>
</html>
