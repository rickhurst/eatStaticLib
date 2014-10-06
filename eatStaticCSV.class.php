<?php

class eatStaticCSV {

	public static function load($file){
		require_once(LIB_ROOT."/parsecsv.lib.php");
		if(file_exists($file)){
			$csv = new parseCSV($file);
			return $csv->data;
		} else {
			die($file);
		}
	}

}

?>