<?php /* Smarty version 2.6.6, created on 2010-03-09 12:35:10
         compiled from auction_sidebar.tpl */ ?>
<!-- Start sidebar -->
			<div id="positionlogo">
				<a href="<?php echo $this->_tpl_vars['COMPANY_URL']; ?>
"><img alt="<?php echo $this->_tpl_vars['COMPANY_NAME']; ?>
" src="img/logo.gif" /></a>
			</div><!-- close positionlogo -->	
	     			<div id="sidemenu">
				<img alt="Browse Categories" src="img/browse.gif" />
				<ul>
					<?php if (count($_from = (array)$this->_tpl_vars['categories'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['v']):
?>
					<li><a href="categories.php?categoryID=<?php echo $this->_tpl_vars['key']; ?>
" title="<?php echo $this->_tpl_vars['v']['name']; ?>
"><?php echo $this->_tpl_vars['v']['name']; ?>
 (<?php echo $this->_tpl_vars['v']['count']; ?>
)</a></li>		
					<?php endforeach; unset($_from); endif; ?>
				</ul>
			</div><!-- close sidemenu -->
<!-- close sidebar -->