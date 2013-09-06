<ul class = 'nav nav-tabs'>
		<li  class = 'active'><a href="/posts">Index</a></li>
		<li><a href="/">Welcome's page</a></li>
</ul>

	<h2>Last 10 published blog posts</h2>
	
	<p>
		<a href="/posts/add" class = 'btn btn-default'><i class="icon-plus-sign"></i> Create New</a>
	</p>
	
	<?php foreach($posts as $post):?>
		<article class='panel panel-primary'>
			<div class='panel-body'>
				<h3>Title: <a href="/posts/<?= $post->id ?>"><?= $post->title; ?></a></h3>
				
				<div class="btn-group">
					<a href="/posts/<?php echo $post->id ?>" class = 'btn btn-default' >
						<i class="icon-expand"></i> View</a>
					<a href="/posts/<?php echo $post->id ?>/edit" class = 'btn btn-default'>
						<i class='icon-edit'></i> Edit</a> 
					<a href="/posts/<?php echo $post->id ?>/delete" class = 'btn btn-default'>
						<i class="icon-remove-sign"></i> Delete</a> 
				</div>
			</div>
		</article>
	<?php endforeach; ?>
