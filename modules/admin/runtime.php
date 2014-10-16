<?php
session_start(0);
require_once "controllers/eatStaticAdminController.class.php";

/**
 * get the url, and split the parts into an array
 */
$url = str_replace("?".$_SERVER["QUERY_STRING"],"",$_SERVER["REQUEST_URI"]);

$path = explode("/",trim(strtolower($url),"/"));
$path = array_pad($path, 10, "");

new eatStaticAdminController($path);