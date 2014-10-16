<?php
require_once EATSTATIC_ROOT.'/eatStaticBlog.class.php';

class eatStaticAdminPostsController {
	function __construct($path){

		switch($path[2]){
			case "":
				$this->listPosts(0);
			break;
			case "edit":
				$this->editPost($path[3]);
			break;
		}
	}

	private function listPosts($page_no=0){
		$blog = new eatStaticBlog;
		$page = new adminPage('posts.php');
		$page->context['posts'] = $blog->getSlicedPosts($page_no, 100);
		$page->context['title'] = "Posts";
		$page->render();

	}

	private function editPost($slug){

		$page = new adminPage('post_edit.php');

		$post = new eatStaticBlogPost;

		if(file_exists(DATA_ROOT.'/posts/'.$slug.'.txt')){
			$post->data_file_path = DATA_ROOT.'/posts/'.$slug.'.txt';
		}
		if(file_exists(DATA_ROOT.'/posts/'.$slug.'.md')){
			$post->data_file_path = DATA_ROOT.'/posts/'.$slug.'.md';
		}
		if(file_exists($post->data_file_path)){
		    $post->hydrate();
		} else {
			die('post not found: '.$slug);
		}

		if(eatStatic::getValue('postback') == '1'){
			$post->slug = eatStatic::getValue('slug','post');
		}

		$page->context['post'] = $post;
		//print_r($page);
		//die();
		$page->render();
	}
}

?>