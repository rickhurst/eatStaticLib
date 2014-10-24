<?php

class eatStaticAdminController {


	public $path;
	public $login_exceptions = Array(); // TODO this needs to be dynamic

	function __construct($path){

		$this->login_exceptions[] = ADMIN_ROOT.'login';

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

			$site_base = ADMIN_ROOT;
			header('location:'.$site_base.$uri);
			die();
	}

}

class adminPage {

	public $context = Array();
	public $stub;
	public $layout = 'base_layout';

	function __construct($stub=''){

		$this->context['show_navbar'] = true;
		$this->context['site_root'] = ADMIN_ROOT;

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

		require_once(EATSTATIC_ROOT.'/eatStaticCSRF.class.php');
		$csrf = new eatStaticCSRF();

		switch($path[2]){
			case "":

				$page = new adminPage('login_form.php');

				if(eatStatic::getValue('postback','post') == '1'){

					$csrf->verifyRequest();

					$email = eatStatic::getValue('email','post');
					$password = eatStatic::getValue('password','post');
					if($this->validUser($email, $password)){
						$_SESSION['admin'] = 1;
						$_SESSION['admin_user'] = $email;
						eatStaticAdminController::redirect("");
					} else {
						$page->context['error_message'] = 'Invalid username or password';
					}
				}

				
				$page->context['title'] = "Log in";
				$page->context['show_navbar'] = false;
				$page->context['body_class'] = 'login-page';
				$page->context['csrf'] = $csrf;
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