<?php

class eatStaticAdminController {


	public $path;
	public $login_exceptions = Array('/admin/login'); // TODO this needs to be dynamic

	function __construct($path){

		$this->path = $path;

		if(eatStatic::getValue('admin', 'session') != '1'){
			if(!in_array($_SERVER["REQUEST_URI"], $this->login_exceptions)){
				$this->redirect('login');
			}
		}

		switch($path[1]){
			case "":
				new adminHomeController($path);
			break;
			case "login":
				new adminLoginController($path);
			break;
			case "posts":
				require_once "eatStaticAdminPostsController.class.php";
				new eatStaticAdminPostsController($path);
			break;
			case "images":
				require_once "eatStaticAdminImagesController.class.php";
				new eatStaticAdminImagesController($path);
			break;
		}

	}

	public static function redirect($uri){

			// TODO: allow override of $site_base from local settings
			$site_base = "/admin/";
			header('location:'.$site_base.$uri);
			die();
	}

}

class adminPage {

	public $context = [];
	public $stub;
	public $layout = 'base_layout';

	function __construct($stub=''){

		$this->context['show_navbar'] = true;

		if($stub != ''){
			$this->stub = $stub;
		}
	}

	public function render(){

		if($this->stub != ''){
			require_once EATSTATIC_ROOT.'/modules/admin/templates/'.$this->layout.'.php';
		}
	}


	function getStubPath(){
		// TODO: stub files could come from add-on modules in the future
		return EATSTATIC_ROOT.'/modules/admin/templates/'.$this->stub;
	}

	function getContext($key){
		if(isset($this->context[$key])){
			return $this->context[$key];
		}
	}

}


class adminHomeController {
	function __construct($path){
		$page = new adminPage('home.php');
		$page->context['title'] = "Admin Dashboard";
		$page->render();
	}
}


class adminLoginController {
	function __construct($path){

		//print_r($path);
		//die();

		switch($path[2]){
			case "":

				if(eatStatic::getValue('postback','post') == '1'){

					$email = eatStatic::getValue('email','post');
					$password = eatStatic::getValue('password','post');
					if($this->validUser($email, $password)){
						$_SESSION['admin'] = 1;
						$_SESSION['admin_user'] = $email;
						eatStaticAdminController::redirect("");

					}
				}

				$page = new adminPage('login_form.php');
				$page->context['title'] = "Log in";
				$page->context['show_navbar'] = false;
				$page->context['body_class'] = 'login-page';
				$page->render();
			break;

		}
	}

	function validUser($email, $password){
		// TODO: plugable user lookup
		// default is csv
		require_once EATSTATIC_ROOT.'/eatStaticCSV.class.php';
		$users = eatStaticCSV::load(DATA_ROOT.'/csv/users.csv');
		foreach($users as $user){
			//echo "[".$email.']['.$user['email'].']<br>';
			if($email == $user['email']){
				$hash = $user['password_encrypted'];
				if($hash == crypt($password, $hash)){
					return true;
				}
			}
		}
	}
}


class adminPostController {

	function __construct($path){

		print_r($path);
		die();

		switch($path){

		}
	}
}

?>