<?php
header('Access-Control-Allow-Origin: *');
include_once 'search_movie.php';
$movieDetailControllerObj = new MovieSearch();
$movieDetailControllerObj->getSearchResult();
$movieDetailControllerObj->closeDBConnection();
?>