<?php
header('Access-Control-Allow-Origin: *');
include_once 'get_category.php';
$movieDetailControllerObj = new CategoryDetail();
$movieDetailControllerObj->getCategory();
$movieDetailControllerObj->closeDBConnection();
?>