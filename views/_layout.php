<?php $this->render('components/page_head');?>


<!-- Content comes here -->
<div class="container">
	<div class="row">
		<?php  $this->render($view, $data); ?>
	</div>
</div>
<!-- End Content -->

<?php $this->render('components/page_tail'); ?>
