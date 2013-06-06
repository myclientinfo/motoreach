<?php /* Smarty version 2.6.6, created on 2010-03-09 12:35:10
         compiled from auction_index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_header.tpl", 'smarty_include_vars' => array('title' => ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction -- Home")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="container">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="rightstatic">
</div><!-- close rightstatic -->  
	<div id="pagebody">
		
		<div id="leftstatic">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_sidebar.tpl", 'smarty_include_vars' => array()));
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
				<h1 id="auctionheader" title="<?php echo $this->_tpl_vars['COMPANY_NAME']; ?>
 Silent Auction">
					<span></span>
				</h1>
				<p>
					                Welcome to <?php echo $this->_tpl_vars['COMPANY_NAME']; ?>
's Silent Auction site.  
					Here you can contribute to many great relief efforts
					throughout the world by donating items to the auction, or
					by placing bids on the items.  All proceeds will go to 
					aiding the poor, the homeless, and the suffering.
				</p>

				<p id="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
				<div id="start">					
					<div class="button">
						<a href="categories.php?categoryID=0">view items</a>
					</div><!-- close button -->
					<img alt="Picture of wheat crops" src="img/crops.jpg" />
				</div><!-- close start -->
			</div><!-- end contents -->
			
		</div><!-- end leftstatic -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "auction_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clearer">&nbsp;</div>		
	</div><!-- end pagebody -->
</div><!-- end container -->
</body>
</html>