<?php /* Smarty version 2.6.6, created on 2010-03-09 12:34:30
         compiled from auction_login.tpl */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_header_inner.tpl", 'smarty_include_vars' => array('title' => ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction -- Login")));
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
		<h1>Silent Auction -- Login</h1>
		<?php if ($this->_tpl_vars['authorised'] == 'valid'): ?>
			<p>You are now logged in as <?php echo $this->_tpl_vars['user']->fullname; ?>
.<?php if ($this->_tpl_vars['calling_page']): ?>
				Return to the <a href="<?php echo $this->_tpl_vars['calling_page']; ?>
">auction page</a> you previously visited.
			<?php endif; ?></p>	
		<?php else: ?>	
			<p>Use this form to login as an existing user. Alternatively, you can <a href="register.php">register</a> as a new user.</p>
			<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
			<p>Please enter your alias and password:</p>
			
			<form name="login" action="login.php<?php if ($this->_tpl_vars['calling_page']): ?>?ref=<?php echo $this->_tpl_vars['calling_page'];  endif; ?>" method="post">
			<input type="hidden" name="formdata" value="1" />
			<!--<input type="hidden" name="debug" value="1" />-->
			<table>		
				<tr>
					<th>Alias (username)</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'alias'): ?>class="error"<?php endif; ?> type="text" name="alias" value="" />
					</td>
				</tr>		
				<tr>
					<th>Password</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'password'): ?>class="error"<?php endif; ?> type="password" name="password" value="" />
					</td>
				</tr>		
				<tr>
					<td><input type="submit" value="Login" /></td>
				</tr>
			</table>
			</form>
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