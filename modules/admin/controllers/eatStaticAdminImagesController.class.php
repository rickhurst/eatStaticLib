<?php
require_once EATSTATIC_ROOT.'/modules/media-library/models/eatStaticMediaLibrary.class.php';

class eatStaticAdminImagesController {

	function __construct($path){
		switch($path[2]){
			case "":
				$this->listContents();
			break;
			case "folder":
				// TODO - support nested folders
				// for MVP we only need a single level
				$this->listContents($path[3]);
			break;
		}
	}

	private function listContents($sub_path = ''){

		$lib = new eatStaticMediaLibrary(DATA_ROOT.'/images/', $sub_path.'/');
		$page = new adminPage('images.php');

		// handle image upload
		if(eatStatic::getValue('postback','post') == "1"){
			$image = $lib->upload('images', $sub_path, 'file', 'image');
			if($image != ''){
				$page->context['message'] = $image.' uploaded';
			} else {
				$page->context['message'] = 'file not uploaded';
			}
		}

		$page->context['contents'] = $lib->getContents();
		$page->context['title'] = "Images";
		$page->context['sub_path'] = $sub_path;
		$page->render();
	}
}
?>