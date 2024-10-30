<div class="row collapse" id="applyAdProgramQuestion" class="applyAdProgramQuestion" style="width: 100%;">
	<div class="small-12 columns">
		<?php _e('Want us to rep you and monetize your videos'); ?>? <span class="applyForAdProgram" href="<?php echo admin_url('admin-ajax.php') . '?action=askMonetize'; ?>" id="addVideoQuestion"><?php _e('Click here to apply'); ?></span>
	</div>
</div>
<script>
	jQuery('.applyForAdProgram').colorbox({
		innerWidth: 920,
		innerHeight: 650
	});
</script>