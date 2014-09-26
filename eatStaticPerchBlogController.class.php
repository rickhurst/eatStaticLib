<?php

class eatStaticPerchBlogController {

	function __construct(){

		global $stub, $path, $slug;

		//print_r($path);

		switch($path[1]){
			case "":
				$stub = "perch_blog_index.php";
				
			break;

			default:
				$slug = $path[1];
				$stub = "perch_blog_post.php";
			break;
		}

	}

}

?>