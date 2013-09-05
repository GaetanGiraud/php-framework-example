<?php if (flash()):?>
	<div class = "alert <?php echo flash()['severity'] ? 'alert-'. flash()['severity'] : '' ?>">
	
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<?= flash()['msg']; ?>
		
	</div>
<?php endif; ?>