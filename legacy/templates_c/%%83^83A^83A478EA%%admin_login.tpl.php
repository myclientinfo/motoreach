<?php /* Smarty version 2.6.6, created on 2010-03-09 13:12:36
         compiled from admin_login.tpl */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array('title' => "Auction -- Admin Panel -- Log In")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<h1>Silent Auction -- Admin -- Log In</h1>
		<?php if ($this->_tpl_vars['authorised'] == 'admin'): ?>
			<?php if ($this->_tpl_vars['message']): ?><p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
                        <?php else: ?>You are now logged in as an administrator.  Return to the <a href="admin.php">admin panel</a> to view and edit auction settings.
                        <?php endif; ?>
		<?php else: ?>	
			<p>Use this form to login as an administrator.</p>
			<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
			<p>Please enter your alias and password:</p>
			
			<form name="login" action="admin_login.php" method="post">
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

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
