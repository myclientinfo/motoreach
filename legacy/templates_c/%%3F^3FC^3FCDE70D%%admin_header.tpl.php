<?php /* Smarty version 2.6.6, created on 2010-03-09 13:12:34
         compiled from admin_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'admin_header.tpl', 6, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//WC3//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="application/xhtml; charset=UTF-8" />
	<title><?php echo ((is_array($_tmp=@$this->_tpl_vars['title'])) ? $this->_run_mod_handler('default', true, $_tmp, ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction") : smarty_modifier_default($_tmp, ($this->_tpl_vars['COMPANY_NAME'])." :: Silent Auction")); ?>
</title>
	<link type="text/css" rel="stylesheet" href="css/admin.css" />
	<script language="JavaScript" src="libs/functions.js"></script>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="pagebody">
<div id="continner">	
<div id="leftstatic">
<div id="contents">

<!-- END OF HEADER TEMPLATE -->
