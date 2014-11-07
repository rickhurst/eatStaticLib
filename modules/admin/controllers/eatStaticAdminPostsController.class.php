<?php
require_once EATSTATIC_ROOT.'/eatStaticBlog.class.php';

class eatStaticAdminPostsController {
	function __construct($path){

		switch($path[2]){
			case "":
				$this->listPosts(0);
			break;
			case "drafts":
				$this->listDrafts();
			break;
			case "edit":
				switch($path[3]){
					case "draft":
						$this->editPost($path[4], $draft=true);
					break;
					default:
						//print_r($path);
						$this->editPost($path[3]);
					break;
				}
			break;
			case "edit-raw":
				switch($path[3]){
					case "draft":
						$this->editRawPost($path[4], $draft=true);
					break;
					default:
						$this->editRawPost($path[3]);
					break;
				}
				
			break;
			case "delete":
				$this->deletePost($path[3]);
			break;
			case "publish":
				$this->publishPost($path[3]);
			break;
			case "make-draft":
				$this->makeDraft($path[3]);
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

	private function listDrafts($page_no=0){
		$blog = new eatStaticBlog;
		$page = new adminPage('drafts.php');
		$page->context['posts'] = $this->getDrafts();
		$page->context['title'] = "Drafts";
		$page->render();
	}

	private function editRawPost($slug, $draft=false){



		$post_folder = DATA_ROOT.'/posts/';
		if($draft){
			$post_folder = $post_folder.'draft/';
		}

		//die($post_folder);

		$page = new adminPage('post_raw_edit.php');

		$post = new eatStaticBlogPost;

		if(file_exists($post_folder.$slug.'.txt')){
			$post->data_file_path = $post_folder.$slug.'.txt';
		}
		if(file_exists($post_folder.$slug.'.md')){
			$post->data_file_path = $post_folder.$slug.'.md';
		}
		if(file_exists($post->data_file_path)){
			$page->context['title'] = "Edit Post";
		    $post->hydrate();
		} else {
			$page->context['title'] = "New Post";
		}

		if(eatStatic::getValue('postback') == '1'){

			//die($slug);

			$post->raw_data = trim(eatStatic::getValue('raw_data','post'));

			$post->file_name = trim(eatStatic::getValue('file_name','post'));
			$post->original_file_name = trim(eatStatic::getValue('original_file_name','post'));

			//die($slug);

			// copy current file data to backups
			if($slug != 'new'){
				copy($post->data_file_path, DATA_ROOT.'/posts/backup/'.$post->file_name.'.'.eatStatic::timestamp().'.bak');
				if($post->original_file_name != $post->file_name){

					//die($post->data_file_path);
					// remove original
					unlink($post->data_file_path);

					$new_data_file_path = $post_folder.$post->file_name;

					eatStatic::write_file($post->raw_data, $new_data_file_path);

				} else {
					eatStatic::write_file($post->raw_data, $post->data_file_path);
				}
				
			} else {
				$post->data_file_path = $post_folder.$post->file_name;
				eatStatic::write_file($post->raw_data, $post->data_file_path);
				header('location:'.ADMIN_ROOT.'posts/drafts/');
				die();
			}
		}

		$page->context['post'] = $post;
		//print_r($page);
		//die();
		$page->render();
	}

	private function editPost($slug, $draft=false){

		//die($slug);

		$post_folder = DATA_ROOT.'/posts/';
		if($draft){
			$post_folder = $post_folder.'draft/';
		}

		//die($post_folder);

		$page = new adminPage('post_edit.php');

		$post = new eatStaticBlogPost;

		if(file_exists($post_folder.$slug.'.txt')){
			$post->data_file_path = $post_folder.$slug.'.txt';
		}
		if(file_exists($post_folder.$slug.'.md')){
			$post->data_file_path = $post_folder.$slug.'.md';
		}
		if(file_exists($post->data_file_path)){
			$page->context['title'] = "Edit Post";
		    $post->hydrate();
		} else {
			$page->context['title'] = "New Post";
			$post->date = date("Y-m-d");
		}

		if(eatStatic::getValue('postback') == '1'){

			//die($slug);

			$post->raw_body = trim(eatStatic::getValue('content','post'));
			$post->date = trim(eatStatic::getValue('date','post'));
			$post->slug_trimmed = trim(eatStatic::getValue('slug','post'));
			$post->title = trim(eatStatic::getValue('title','post'));
			$post->raw_meta = trim(eatStatic::getValue('meta','post'));

			$post->file_name = $post->date.'-'.$post->slug_trimmed.'.md';
			$post->original_file_name = trim(eatStatic::getValue('original_file_name','post'));

			// reassemble 
			$post->raw_data = $post->title."\n\n";
			$post->raw_data .= $post->raw_body."\n";
			$post->raw_data .= "--\n";
			$post->raw_data .= $post->raw_meta;

			//print_r($post);
			//die();

			// copy current file data to backups
			if($slug != 'new'){
				copy($post->data_file_path, DATA_ROOT.'/posts/backup/'.$post->file_name.'.'.eatStatic::timestamp().'.bak');
				if($post->original_file_name != $post->file_name){

					//die($post->data_file_path);
					// remove original
					unlink($post->data_file_path);

					$new_data_file_path = $post_folder.$post->file_name;

					eatStatic::write_file($post->raw_data, $new_data_file_path);

				} else {
					eatStatic::write_file($post->raw_data, $post->data_file_path);
				}
				
			} else {
				$post->data_file_path = $post_folder.$post->file_name;
				eatStatic::write_file($post->raw_data, $post->data_file_path);
				header('location:'.ADMIN_ROOT.'posts/drafts/');
				die();
			}
		}

		$page->context['post'] = $post;
		//print_r($page);
		//die();
		$page->render();
	}

	private function deletePost($slug){
		$post = new eatStaticBlogPost;
		
		if(file_exists(DATA_ROOT.'/posts/'.$slug.'.txt')){
			$post->data_file_path = DATA_ROOT.'/posts/'.$slug.'.txt';
		}
		if(file_exists(DATA_ROOT.'/posts/'.$slug.'.md')){
			$post->data_file_path = DATA_ROOT.'/posts/'.$slug.'.md';
		}
		if(file_exists($post->data_file_path)){
			$post->hydrate();
			copy($post->data_file_path, DATA_ROOT.'/posts/backup/'.$post->file_name.'.'.eatStatic::timestamp().'.bak');
			unlink($post->data_file_path);

			header('location:'.ADMIN_ROOT.'posts/');
			die();
		}
	}

	private function getDrafts(){
		$drafts_folder = DATA_ROOT.'/posts/draft/';
		$drafts = Array();
		if (is_dir($drafts_folder)) {
		    if ($dh = opendir($drafts_folder)) {
		        while (($file = readdir($dh)) !== false) {
		            //echo "filename: $file : filetype: " . filetype($this->post_folder . $file) . "\n";
					if(
						(filetype($drafts_folder . $file) == 'file') && 
						(substr($file,-3) == "txt" || substr($file,-2) == "md")
					){
						// for each post found
						$post = new eatStaticBlogPost;
						$post->data_file_path = $drafts_folder . $file;
						$post->hydrate();
						$drafts[$post->data_file_path] = $post;
					}
		        }
		        ksort($drafts);
		        closedir($dh);
		    }
		}
		return $drafts;
	}

	private function publishPost($slug){
		$draft_folder  = DATA_ROOT.'/posts/draft/';
		if(file_exists($draft_folder.$slug.'.txt')){
			$post_file = $draft_folder.$slug.'.txt';
		}
		if(file_exists($draft_folder.$slug.'.md')){
			$post_file = $draft_folder.$slug.'.md';
		}

		if(file_exists($post_file)){
			if(copy($post_file, str_replace('/draft/','/', $post_file))){
				unlink($post_file);
				header('location:'.ADMIN_ROOT.'posts/');
				die();
			}
		}
	}

	private function makeDraft($slug){
		$draft_folder = DATA_ROOT.'/posts/draft/';
		$post_folder = DATA_ROOT.'/posts/';

		if(file_exists($post_folder.$slug.'.txt')){
			$post_file = $post_folder.$slug.'.txt';
			$file_name = $slug.'.txt';
		}
		if(file_exists($post_folder.$slug.'.md')){
			$post_file = $post_folder.$slug.'.md';
			$file_name = $slug.'.md';
		}

		if(file_exists($post_file)){
			if(copy($post_file, $draft_folder.$file_name)){
				unlink($post_file);
				header('location:'.ADMIN_ROOT.'posts/drafts/');
				die();
			}
		}

	}

}

?>