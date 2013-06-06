<?php
require_once '../include.php';
$region = User::getRegion($_POST['postcode']);

header('Content-type: application/json');
echo json_encode($region);
?>