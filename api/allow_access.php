<?php
if(!isset($_GET['auth_matt'])){
	header("HTTP/1.0 404 Not Found");
	die();
}

if($_GET['type']=='in'){
	$time = time()+1209600;
	$val = 1;
} else {
	$time = time()-13600;
	$val = 0;
	
}
setcookie('allow_access', $val, $time, '/');
?>
<html>
<body>

You have been approved on the site.<br /><br />

<a href="/">Go to site</a>



</body>

</html>