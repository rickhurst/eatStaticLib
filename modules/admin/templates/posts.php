<?php //print_r($this) ?>
<h2>Posts</h2>
<table class="table table-bordered table-striped">
<?php foreach($this->getContext('posts') as $post): ?>
	<tr>
		<td><?php echo $post->date ?></td>
		<td><?php echo $post->title ?></td>
		<td><a href="/admin/posts/edit/<?php echo $post->slug ?>">Edit</a></td>
	</tr>
<?php endforeach; ?>