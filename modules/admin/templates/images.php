<?php //print_r($this) ?>
<h2>Images</h2>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
	<input type="hidden" name="postback" value="1" />
	<input type="hidden" name="sub_path" value="<?php echo $this->getContext('sub_path') ?>" />
	<div class="form-group">
		<label>Upload Image</label>
		<span class="btn btn-file"><input  type="file" name="file" accept="image/*" capture="camera" /></span>
	</div>
	<div class="form-group">
		<button class="btn btn-primary" type="submit">Upload</button>
	</div>
	
</form>
<?php if($this->getContext('message') != ''): ?>
<div class="alert alert-success"><?php echo $this->getContext('message') ?></div>
<?php endif; ?>
<table class="table table-bordered table-striped">
<?php foreach($this->getContext('contents') as $item): ?>
	<tr>

		<?php if($item->item_type == 'folder'): ?>
		<td>(folder)</td>
		<td><?php echo $item->name ?></td>
		<td><a href="/admin/images/folder/<?php echo $item->sub_path ?>">open</a></td>
		<?php endif; ?>

		<?php if($item->item_type == 'file'): ?>
		<td>
			<img src="<?php echo $item->getThumbnail() ?>" />
		</td>
		<td><?php echo $item->mime_type ?></td>
		<td><?php echo $item->name ?></td>
		<td><a href="/admin/images/file/<?php echo $item->sub_path ?>">view</a></td>
		<?php endif; ?>
	</tr>
<?php endforeach; ?>