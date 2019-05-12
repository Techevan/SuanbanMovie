<?php
header('Access-Control-Allow-Origin: *');
include_once 'get_movie_detail.php';
$movieDetailControllerObj = new MovieDetail();
$movieDetailControllerObj->getDetail();
$movieDetailControllerObj->closeDBConnection();
?>