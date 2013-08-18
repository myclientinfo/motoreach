<?php 
$secret = 'WTsat9Eg78';
$store_id = '13011553712';

echo sha1(bin2hex($store_id . $_POST['txndatetime'] . $_POST['chargetotal'] . $_POST['currency'] . $secret));
?>