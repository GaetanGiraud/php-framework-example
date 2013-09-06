<ul class = 'nav nav-tabs'>
		<li><a href="/posts">Index</a></li>
		<li><a href="/">Welcome's page</a></li>
</ul>

<h1>Title: <?php echo $post->title; ?></h1>

<section class='panel panel-primary'>
	<div class="panel-heading">Content</div>
	<div class='panel-body'>
		
		
		<p><?php echo $post->body; ?></p>
	
	</div>
	

</section>

	<div class="btn-group">
		<a href="/posts/<?php echo $post->id ?>/edit" class = 'btn btn-default'><i class='icon-edit'></i> Edit</a> 
		<a href="/posts/<?php echo $post->id ?>/delete" class = 'btn btn-default'><i class="icon-remove-sign"></i> Delete</a> 
	</div>
