<?php $this->view('components/page_head');?>


<!-- Content comes here -->

<div class="container">
	<div class = 'row'>
		<?php  $this->view('components/flash'); ?>
	</div>
</div>

<div class="container">
	<?php $this->view($view, $data); ?>
</div>



<!-- End Content -->

<?php $this->view('components/page_tail'); ?>
