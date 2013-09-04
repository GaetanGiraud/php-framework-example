<h1>Edit record here</h1>

<?= $h->validationErrors($post); ?>

<form action="/posts/update" method="post">
	
	<input type="hidden" id="id" name="id" value="<?= $post->id; ?>">
	
	<div class="form-group">
		<label for="title">Title</label>
		<?= $h->input('title', array('value' => $post->title, 'class' => 'form-control' ) ); ?>
	</div>
	
	<div class="form-group">
		<label for="body">Body</label>
		<?= $h->textarea('body', $post->body,  array('class' => 'form-control', 'rows' => 20 ) ); ?>
	</div>
	<?= $h->submit("Save Changes");?>

</form>

<a href="/posts">Back</a>