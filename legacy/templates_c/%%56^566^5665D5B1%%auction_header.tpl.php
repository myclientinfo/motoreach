<?php /* Smarty version 2.6.6, created on 2010-03-09 12:35:10
         compiled from auction_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'auction_header.tpl', 6, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//WC3//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="application/xhtml; charset=UTF-8" />
	<title><?php echo ((is_array($_tmp=@$this->_tpl_vars['title'])) ? $this->_run_mod_handler('default', true, $_tmp, ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction") : smarty_modifier_default($_tmp, ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction")); ?>
</title>
	<link type="text/css" rel="stylesheet" href="<?php echo $this->_tpl_vars['CSSDIR']; ?>
index.css" />
	<script language="JavaScript" src="libs/functions.js" type="text/javascript"></script>
</head>
<body>
<!-- END OF HEADER TEMPLATE -->
