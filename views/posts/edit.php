<ul class = 'nav nav-tabs'>
		<li><a href="/posts">Index</a></li>
		<li><a href="/">Welcome's page</a></li>
</ul>

<h1>Edit Post</h1>

<?php echo validationErrors($post); ?>

<form action="/posts/update" method="post">
	
	<input type="hidden" id="id" name="id" value="<?= $post->id; ?>">
	
	<div class="form-group">
		<label for="title">Title</label>
		<?php echo input('title', array('value' => $post->title, 'class' => 'form-control' ) ); ?>
	</div>
	
	<div class="form-group">
		<label for="body">Body</label>
		<?php echo textarea('body', $post->body,  array('class' => 'form-control', 'rows' => 20 ) ); ?>
	</div>
	<?php echo submit("Save Changes", array('class' => 'btn btn-default' ));?>

</form>