<?php
//print_r($this->getContext('post'));
//die();
?>

<h2><?php echo $this->getContext('title') ?></h2>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

	<input type="hidden" name="postback" value="1" />
	<input type="hidden" name="file_name" value="<?php echo $this->getContext('post')->file_name ?>" />

	<div class="form-group">
		<label>Date</label>
		<input name="date" class="form-control" type="text" value="<?php echo $this->getContext('post')->date ?>" />
	</div>

	<div class="form-group">
		<label>Slug</label>
		<input name="slug_trimmed" class="form-control" type="text" value="<?php echo $this->getContext('post')->slug_trimmed ?>" />
	</div>

	<div class="form-group">
		<label>Title</label>
		<input name="title" class="form-control" type="text" value="<?php echo $this->getContext('post')->title ?>" />
	</div>

	<div class="form-group">
		<label>Content</label>
		<textarea class="form-control" name="content" rows="20"><?php echo $this->getContext('post')->raw_body ?></textarea>
	</div>

	<div class="form-group">
		<label>Meta</label>
		<textarea class="form-control" name="meta" rows="5"><?php echo $this->getContext('post')->raw_meta ?></textarea>
	</div>

	<button class="btn btn-lg btn-primary" type="submit">Save</button>

</form>