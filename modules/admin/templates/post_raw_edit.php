<?php
//print_r($this->getContext('post'));
//die();
?>
<h2><?php echo $this->getContext('title') ?> - Raw Content</h2>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

	<input type="hidden" name="postback" value="1" />
	<input type="hidden" name="original_file_name" value="<?php echo $this->getContext('post')->file_name ?>" />

	<div class="form-group">
		<label>File Name</label>
		<input class="form-control" name="file_name" value="<?php echo $this->getContext('post')->file_name ?>" />
	</div>

	<div class="form-group">
		<label>Raw Content</label>
		<textarea class="form-control" name="raw_data" rows="50"><?php echo $this->getContext('post')->raw_data ?></textarea>
	</div>

	<button class="btn btn-lg btn-primary" type="submit">Save</button>

</form>