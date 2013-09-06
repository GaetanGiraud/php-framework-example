<?php $this->view('components/page_head');?>


<!-- Content comes here -->

<div class="container">
	<div class = 'row'>
		<?php  $this->view('components/flash'); ?>
	</div>
</div>
	
<?php $this->view($view, $data); ?>


<!-- End Content -->

<?php $this->view('components/page_tail'); ?>
