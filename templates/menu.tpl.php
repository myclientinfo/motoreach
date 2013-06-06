			<ul id="menu">

			<?php if(  !isset($_SESSION['authorised']) || $_SESSION['authorised'] != 'valid' || !isset($_SESSION['permissions']) || empty($_SESSION['permissions'])){ ?>
			<li style=" float: right; margin-right: 0px; display: none;" id="login_nav" class="<?php echo $_SERVER['PHP_SELF']=='/login.php' ? '' :'in' ?>active"><a href="/login.php">member login</a></li>
			<li class="<?php echo $_SERVER['PHP_SELF']=='/index.php' ? '' :'in' ?>active"><a href="/index.php">home</a></li>
			<li class="<?php echo $_SERVER['PHP_SELF']=='/about.php' ? '' :'in' ?>active"><a href="/about.php">about us</a></li>
			<li id="menu_register_box" class="<?php echo $_SERVER['PHP_SELF']=='/register.php' ? '' :'in' ?>active"><a href="/register.php">become a member</a></li>
			<!--<li class="<?php echo $_SERVER['PHP_SELF']=='/rates.php' ? '' :'in' ?>active"><a href="/rates.php">rates</a></li>-->
			<li class="<?php echo $_SERVER['PHP_SELF']=='/contact.php' ? '' :'in' ?>active"><a href="/contact.php">contact</a></li>
			
			<?php } else {?>
		<li class="<?php echo $_SERVER['PHP_SELF']=='/index.php' ? '' :'in' ?>active"><a href="/index.php">home</a></li>
			<?php if(User::hasPermission('Browse')){?>
			<li id="menu_browse" class="<?php echo $_SERVER['PHP_SELF']=='/browse.php' || $_SERVER['PHP_SELF']=='/items.php' ? '' :'in' ?>active"><a href="/browse.php">vehicles available now</a></li>
			<?php } ?>
			<?php if(User::hasPermission('List')){ ?>
			<li class="<?php echo $_SERVER['PHP_SELF']=='/user/submititem.php' ? '' :'in' ?>active"><a href="/user/submititem.php">sell vehicle</a></li>
			<?php } ?>
			<?php //if(!in_array($_SERVER['PHP_SELF'], array('/','/login.php')){ ?>
			<li style="float: right; margin-right: 0px;" class="<?php echo $_SERVER['PHP_SELF']=='/login.php' ? '' :'in' ?>active"><a href="/login.php?log_out">logout</a></li>
			<?php //} ?>
			

			<?php } ?>
			
			<?php if(isset($_SESSION['authorised']) && $_SESSION['authorised']=='valid'){ ?>
			<li class="<?php echo substr($_SERVER['PHP_SELF'], 0, 6)=='/user/' && $_SERVER['PHP_SELF']!='/user/submititem.php' ? '' :'in' ?>active"><a href="/user/">my account</a></li>
			<?php } ?>

		</ul>

<?php

if(false){
	echo Site::drawForm('login', '/login.php');
	echo Site::drawHidden('formdata', 1);
	echo Site::drawText('email', 'email').BR;
	echo Site::drawText('password', 'password').BR;
	echo Site::drawSubmit('submit_mini_login', 'Log In');
	echo Site::drawForm();
}

?>