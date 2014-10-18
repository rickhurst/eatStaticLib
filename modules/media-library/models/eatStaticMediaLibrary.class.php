<?php 

class eatStaticMediaLibrary {

	public $path; // /site/data/images/cats/ginger/
	public $root_path; // /site/data/images/
	public $sub_path; // cats/ginger/
	public $files = [];
	public $folders = [];

	function __construct($root_path, $sub_path){
		$this->path = $root_path.$sub_path;
		$this->sub_path = $sub_path;
	}

	public function getContents(){
		$contents = array();
		if (is_dir($this->path)) {
		    if ($dh = opendir($this->path)) {
		        while (($file = readdir($dh)) !== false) {
		            //echo "filename: $file : filetype: " . filetype($this->path. $file) . "<br>";
					if(
						(filetype($this->path . $file) == 'file') &&
						(substr($file, 0, 1) != ".")
					){
						// for each file found
						$item = new eatStaticMediaLibraryFile;
						$item->path = $this->path.$file;
						$item->sub_path = $this->sub_path.$file;
						$item->name = $file;
						$item->setInfo();
						$contents[$this->path.$file] = $item;
					}
					if(
						(filetype($this->path . $file) == 'dir') &&
						($file != '.') &&
						($file != '..')
					){

						// for each folder found
						$item = new eatStaticMediaLibraryFolder;
						$item->path = $this->path.$file;
						$item->sub_path = $this->sub_path.$file.'/';
						$item->name = $file;

						//print_r($item);
						$contents[$this->path.$file] = $item;
					}
		        }
		        
		        closedir($dh);
		    }
		}

		return $contents;
	}

	public function upload($base_folder, $sub_path, $input_name, $type){

		//print_r($_FILES);

		$filename = basename($_FILES[$input_name]['name']);
		$target_path = DATA_ROOT.'/'.$base_folder.'/'.$sub_path.'/'.$filename;

		if(move_uploaded_file($_FILES[$input_name]['tmp_name'], $target_path)){
			return $target_path;
		} else {
			//echo 'not moved:'.$_FILES[$input_name]['tmp_name'];
		}

	}

}

class eatStaticMediaLibraryFile {
	public $path;
	public $sub_path;
	public $name;
	public $item_type = 'file';
	public $type; // general e.g. image, movie, document
	public $mime_type;
	public $extension;

	public function setInfo() {
		$path_parts = pathinfo($this->path);
		$this->extension = $path_parts['extension'];

		$image_ext_array = Array('jpg', 'jpeg', 'png', 'gif');

		if(in_array(strtolower($this->extension), $image_ext_array)){
			$this->type = 'image';

			// try to get mime type
			$finfo = getimagesize($this->path);
			if(isset($finfo['mime'])){
				$this->mime_type = $finfo['mime'];
			}

		}

	}

	public function getThumbnail(){
		if($this->type == 'image'){
			// TODO: convert to private protected admin only image cache view
			return "/images/".str_replace('.'.$this->extension, '_100.'.$this->extension, $this->sub_path);
		}
	}

}

class eatStaticMediaLibraryFolder {
	public $path;
	public $sub_path;
	public $name;
	public $items;
	public $item_type = 'folder';
}

?>