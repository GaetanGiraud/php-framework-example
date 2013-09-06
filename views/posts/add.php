<ul class = 'nav nav-tabs'>
		<li><a href="/posts">Index</a></li>
		<li><a href="/">Welcome's page</a></li>
</ul>

<h1>Create a Post</h1>

<?php validationErrors($post); ?>

<form action="/posts/create" method="post">	
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" id="title" name="title" class="form-control">
	</div>
	<div class="form-group">
		<label for="body">Body</label>
		<textarea id="body" name="body" class="form-control" rows = 20></textarea>
	</div>
	<input type="submit" id="submit" name="submit" value="Create Post" class="btn btn-default">
</form>
