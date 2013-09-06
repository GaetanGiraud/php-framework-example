<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset='utf-8'> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url('css/blog.css'); ?>" rel="stylesheet" media="screen">
</head>

<?php 
	// load scrolispy if the controller is the welcome controller
	if ($this->_controller == 'welcome'):?>

	<body data-spy="scroll" data-target="#navbar">

<?php else: ?>
	<body>
<?php endif; ?>



