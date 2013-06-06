<?php /* Smarty version 2.6.6, created on 2010-03-09 13:12:34
         compiled from admin_messages.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_messages.tpl', 57, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array('title' => "Auction -- Admin Panel -- Messages")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<h1>Silent Auction -- Admin -- Messages</h1>
		<?php if ($this->_tpl_vars['authorised'] == 'admin'): ?>			
			<p>Use this form to enter new message constants into the database. By 
			default all messages are saved under the locale en_US, which is US English.
			However, you can enter messages in a different language, but you need to
			make sure that you enter the correct locale code.</p>
			<?php if ($this->_tpl_vars['message']): ?>
				<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
			<?php endif; ?>
			
			<form name="messages" action="admin_messages.php" method="post">
			<input type="hidden" name="formdata" value="submission" />
			<!--<input type="hidden" name="debug" value="1" />-->
			<table>		
				<tr>
					<th>Locale</th>
					<td>
						<input <?php if ($this->_tpl_vars['error_field'] == 'locale'): ?>class="error"<?php endif; ?> type="text" name="locale" value="en_US" />
					</td>
				</tr>		
				<tr>
					<th>Constant</th>
					<td>
						<input size="40" <?php if ($this->_tpl_vars['error_field'] == 'constant'): ?>class="error"<?php endif; ?> type="text" name="constant" value="<?php echo $this->_tpl_vars['post']['constant']; ?>
" />
					</td>
				</tr>		
				<tr>
					<th>Message</th>
					<td>
						<textarea rows="10" cols="40" <?php if ($this->_tpl_vars['error_field'] == 'message'): ?>class="error"<?php endif; ?> name="message" value=""><?php echo $this->_tpl_vars['post']['message']; ?>
</textarea>
					</td>
				</tr>	
				<tr>
					<td><input type="submit" value="Enter Message" /></td>
				</tr>
			</table>
			</form>
			
			<p>Here you can see all the message already entered in the database, and you can edit them.</p>			
			
			<table summary="All message constants are shown here and can be edited">
				<tr>
					<th>Locale</th>
					<th>Constant</th>
					<th>Message</th>
					<th>Update</th>
					<th>Delete</th>
				</tr>
				<?php if (count($_from = (array)$this->_tpl_vars['messages'])):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<form name="edit_messages_<?php echo $this->_tpl_vars['k']; ?>
" method="post" action="admin_messages.php">
					<input type="hidden" name="formdata" value="update" />
					<input type="hidden" name="ID" value="<?php echo $this->_tpl_vars['v']['ID']; ?>
" />
					<tr style="background-color:<?php echo smarty_function_cycle(array('values' => "#eeeeee,#d0d0d0"), $this);?>
">
						<td><input type="text" size="6" name="locale" value="<?php echo $this->_tpl_vars['v']['locale']; ?>
" /></td>
						<td><input type="text" size="50" name="constant" value="<?php echo $this->_tpl_vars['v']['constant']; ?>
" /></td>
						<td><textarea cols="35" rows="4" name="message"><?php echo $this->_tpl_vars['v']['message']; ?>
</textarea></td>
						<td><input type="submit" name="action" value="update" /></td>
						<td><input type="submit" name="action" value="delete" /></td>
					</tr>
					</form>
				<?php endforeach; unset($_from); endif; ?> 
			</table>
		<?php else: ?>
			<p>You are not logged in as an administrator. Please <a href="admin_login.php">login</a> now.</p>	
		<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
