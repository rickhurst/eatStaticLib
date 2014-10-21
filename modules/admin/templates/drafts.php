<?php //print_r($this) ?>
<h2><?php echo $this->getContext('title') ?></h2>
<div class="form-group">
	<a class="btn btn-primary" href="/admin/posts/edit-raw/draft/new/">Create new draft</a>
</div>
<p><a href="/admin/posts/">Published posts</a></p>
<table class="table table-bordered table-striped">
<?php foreach($this->getContext('posts') as $post): ?>
	<tr>
		<td><?php echo $post->date ?></td>
		<td><?php echo $post->title ?></td>
		<td>
			<a href="/admin/posts/edit-raw/draft/<?php echo $post->slug ?>">Edit (Raw)</a> | 
			<!--<a href="/admin/posts/delete/draft/<?php echo $post->slug ?>" onclick="return confirm('sure?')">Delete</a> |-->
			<a href="/admin/posts/publish/<?php echo $post->slug ?>">Publish</a>

		</td>
	</tr>
<?php endforeach; ?>