<h1>Index page for Posts</h1>

<h2>Create New</h2>

<a href="/posts/add">Add new post</a>

<h2>Listing of existing blog posts</h2>
<table class="table">
<thead>
	<tr>
		<th>Id</th>
		<th>Title</th>
	</tr>
</thead>
<tbody>
	<?php foreach($posts as $post):?>
		<tr>
			<td><?= $post['id']; ?></td>
			<td><a href="/posts/<?= $post['id'] ?>"><?= $post['title']; ?></a></td>
			<td>
			<a href="/posts/<?= $post['id'] ?>/edit">Edit</a> 
			<a href="/posts/<?= $post['id'] ?>/delete">Delete</a> 
			</td>
		</tr>
	<?php endforeach; ?>
</tbody>
</table>