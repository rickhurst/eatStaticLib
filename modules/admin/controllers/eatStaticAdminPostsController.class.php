<?php
require_once EATSTATIC_ROOT.'/eatStaticBlog.class.php';

class eatStaticAdminPostsController {
	function __construct($path){

		switch($path[2]){
			case "":
				$this->listPosts(0);
			break;
			case "edit-raw":
				$this->editRawPost($path[3]);
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

	private function editRawPost($slug){

		$page = new adminPage('post_raw_edit.php');

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
			$post->raw_data = trim(eatStatic::getValue('raw_data','post'));

			// copy current file data to backups
			if(copy($post->data_file_path, DATA_ROOT.'/posts/backup/'.$post->file_name.'.'.eatStatic::timestamp().'.bak')){
				eatStatic::write_file($post->raw_data, $post->data_file_path);
			}
		}

		$page->context['post'] = $post;
		//print_r($page);
		//die();
		$page->render();
	}
}

?>