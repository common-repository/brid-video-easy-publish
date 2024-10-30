<?php if (isset($platform['overage']) && !empty($platform['overage'])) { ?>
	<div class="<?php echo isset($overageCss) ? $overageCss : 'brid-overage'; ?>">
		<?php _e('Account incurred total overage charges'); ?> ($<?php echo round($platform['overage']['Order']['mc_gross'], 2); ?>).
		<?php if ($user['owner']) { ?>
			<a href="https://cms.brid.tv/payments/index/<?php echo $platform['overage']['Order']['user_id']; ?>/Pending" target="_blank"><?php _e('Pay now'); ?></a>.
		<?php } else { ?>
			<?php _e('Please contact your account owner'); ?>.
		<?php } ?>
	</div>
<?php } ?>
<?php if (isset($platform['msg']) && !empty($platform['msg'])) { ?>
	<div class="brid-overage">
		<?php echo $platform['msg']; ?>
	</div>
<?php } ?>