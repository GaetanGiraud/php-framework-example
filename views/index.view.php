<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Create a Grocery list</title>
</head>
<body>

	<h1>Welcome to the grocelist creator!</h1>
	<h2>Create a list!</h2>
	<form action="" method="post">
		<table>
			<tr>
				<th></th>
				<th>Name of the item</th>
				<th>Price</th>
			</tr>
			<?php foreach($items as $item) : ?>
			<tr>
				<td><input type='checkbox' name='items[]' value='<?= $item['id']; ?>'></td>
				<td> <?= ucfirst($item['name']); ?></td>
				<td>€ <?= $item['price']; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<input type="submit" value="Create list">
	</form>
	
	<?php if (isset($lists)) :?>
		<h2>The list already created:</h2>
		<table>
			<tr>
				<th>Shop</th>
				<th>Items to buy</th>
				<th>Date</th>
			</tr>
			
			<?php foreach ($lists as $list) : ?>
			<tr>
				<td><?= $list['shop']; ?></td>
				<td><?= $list['items']; ?></td>
				<td><?= $list['date']; ?></td>
			</tr>
			<?php endforeach; ?>
			
		</table>
	<?php else : ?>
		<p>Not list created yet! </p>
	<?php endif; ?>
</body>
</html>