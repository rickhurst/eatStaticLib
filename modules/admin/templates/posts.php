<?php //print_r($this) ?>
<h2><?php echo $this->getContext('title') ?></h2>
<p><a href="/admin/posts/drafts">Drafts</a></p>
<table class="table table-bordered table-striped">
<?php foreach($this->getContext('posts') as $post): ?>
	<?php //print_r($post) ?>
	<tr>
		<td><?php echo $post->date ?></td>
		<td><?php echo $post->title ?></td>
		<td>
			<a href="/admin/posts/edit-raw/<?php echo $post->slug ?>">Edit (Raw)</a> | 
			<a href="/admin/posts/delete/<?php echo $post->slug ?>" onclick="return confirm('sure?')">Delete</a> |
			<a href="/admin/posts/make-draft/<?php echo $post->slug ?>">Make Draft</a>
		</td>
	</tr>
<?php endforeach; ?>