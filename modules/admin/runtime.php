<?php
session_start(0);
require_once "controllers/eatStaticAdminController.class.php";

/**
 * get the url, and split the parts into an array
 */
$url = str_replace("?".$_SERVER["QUERY_STRING"],"",$_SERVER["REQUEST_URI"]);

// we want to be able to run the admin site at a different url, in the root or not
// e.g. /admin/ or /mysupersecretadmin or admin.foo.bar/
// so work out where the relevant parts of the path are and monkey around
// until the $path always appears to start with 'admin'

if(substr(ADMIN_ROOT, 0, 1) == '/'){
	$url = str_replace(ADMIN_ROOT, '/', $url);
}

$url = '/admin'.$url;

$path = explode("/",trim(strtolower($url),"/"));
$path = array_pad($path, 10, "");

new eatStaticAdminController($path);