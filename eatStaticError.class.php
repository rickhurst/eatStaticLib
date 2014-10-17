<?php
/**
 * @version 0.1.0
 * 2011-07-13 - Rick Hurst added version number 0.1.0
 */

class eatStaticError {
	
	private $errors = array();
	
	public function add($type='default', $val){
		$this->errors[] = array($type => $val);
	}
	
	public function exists($str=''){
		if($str == ''){
			if(sizeOf($this->errors) > 0){
				return true;
			}
		} else {
			foreach($this->errors as $error){
				if(isset($error[$str])) return true;
			}
		}
	}
	
	public function printOut(){
		echo '<pre>';
		print_r($this->errors);
		echo '</pre>';
	}
	
	public function listAll($str='default'){
		?>
		<ul class="errors">
		<?php
		foreach($this->errors as $error){
			if(isset($error[$str])){
			?>
			<li><?php echo $error ?></li>
			<?php
			}
		}
		?>
		</ul>
		<?php
	}
	
}

?>