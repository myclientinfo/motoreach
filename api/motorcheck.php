<?php 

$api_key = '3d7366a31cadf063f76dc06f0b112a68833dfdb6';

$url = 'http://api.motorcheck.ie/vehicle/reg/'.$_GET['registration'].'/lookup?_username=motoreach&_api_key='.$api_key.'&format=json';

$content = file_get_contents($url);

$content = json_decode($content);

$content = $content->vehicle;
$content->model = strtoupper($content->model);

header('Content-Type: application/json');
echo json_encode($content);
?>