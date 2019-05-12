<?php
header('Access-Control-Allow-Origin: *');
include_once 'get_data.php';
$movieDetailControllerObj = new DataDetail();
$movieDetailControllerObj->categoryCount();
$movieDetailControllerObj->closeDBConnection();
?>