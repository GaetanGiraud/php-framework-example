<?php

/**
 *
 * testing the database class
 *
 *
 */

// Register the object

$db = $registry->getObject('db');

// Create the connection
$db->newConnection('localhost',  'db', 'root', 'tutsplus');

 // Data to be inserted
$insertData = array (
		'title' => 'Testing database abstraction - Insert',
		'body' => 'Seems to be working great, I can insert records'
);

// Data for update
$updateData = array (
		'title' => 'Testing database abstraction - Update',
		'body' => 'Seems to be working great, I can update records'
);

// insert
$id = $db->insert('posts', $insertData);

if (!is_int($id))
{
	echo 'Error inserting data';
}

// update
$message = $db->update('posts', ['id' => 70], $updateData);

if ($message !== TRUE) {
	echo '<pre>';
	echo 'error updating';
	echo '</pre>';
}

// Delete
$message = $db->delete('posts', ['id' => 77]);

if ($message !== TRUE) {
	echo '<pre>';
	echo 'error deleting 77';
	echo '</pre>';
}

// select

$results = $db->select('posts', array(
		'fields' => array('id', 'title'),
		//	'where' => array('title' => 'Inserted title again'),
		'order' => array('fields' => array('title'), 'order' => 'DESC' ),
		//	'limit' => 5
));

echo '<table border = 1>';
foreach ($results as $result) {
echo "<tr>";
foreach ($result as $field) {
echo '<td>' . $field . '</td>';
}
echo "</tr>";
}
echo '</table>';