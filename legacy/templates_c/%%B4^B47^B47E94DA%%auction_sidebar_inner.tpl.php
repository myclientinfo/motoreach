<?php /* Smarty version 2.6.6, created on 2010-03-09 11:58:10
         compiled from auction_sidebar_inner.tpl */ ?>
<!-- Start sidebar -->
			<div id="positionlogo">
				<a href="<?php echo $this->_tpl_vars['COMPANY_URL']; ?>
"><img alt="<?php echo $this->_tpl_vars['COMPANY_NAME']; ?>
" src="img/logo.gif" /></a>
			</div><!-- close positionlogo -->
			<div id="sidemenu">
				<img alt="Browse Categories" src="img/browse.gif" />
				<ul>
				<?php if ($this->_tpl_vars['categories_error']): ?>
					<li><?php echo $this->_tpl_vars['categories_error']; ?>
</li>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['categories']): ?>
					<?php if (count($_from = (array)$this->_tpl_vars['categories'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['v']):
?>
					<li><a href="categories.php?categoryID=<?php echo $this->_tpl_vars['key']; ?>
" title="<?php echo $this->_tpl_vars['v']['name']; ?>
"><?php echo $this->_tpl_vars['v']['name']; ?>
 (<?php echo $this->_tpl_vars['v']['count']; ?>
)</a></li>		
					<?php endforeach; unset($_from); endif; ?>
				<?php endif; ?>
				</ul>

			</div><!-- close sidemenu -->

<!-- close sidebar -->