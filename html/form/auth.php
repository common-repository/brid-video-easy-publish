<div class="mainWrapper" style="margin-top:50px; margin-left:40px">
	<a href="https://cms.target-video.com/" title="Visit TargetVideo Video Platform" target="_blank">
		<img src="<?php echo BRID_PLUGIN_URL; ?>img/logo_brid.tv.svg" alt="TargetVideo Video Platform" width="220px" />
	</a>

	<?php
	if ($error != '') {
	?>
		<div style="color:#ff0000; padding-top:10px;"><?php echo $error; ?></div>
	<?php } ?>
	<div class="authText">The TargetVideo <?php _e('plugin needs your authorization to access some of your information and usage data. All of this information will be accessed privately using the'); ?> <a href="http://oauth.net/2/" target="_blank">OAuth 2.0 protocol</a>. <?php _e('We will never store any of your'); ?> <a href="https://target-video.com/" target="_blank" title="TargetVideo">TargetVideo</a> <?php _e('credentials (email and password) on this blog'); ?>.</div>

	<a href="<?php echo $api->authorizationUrl($redirect_uri); ?>" title="Authorize This Plugin" style="float:left;height:48px;">
		<div class="bridButton auth-plugin" data-href="#" id="authPlugin" style="margin:0px">
			<div class="buttonLargeContent"><?php _e('AUTHORIZE THIS PLUGIN'); ?></div>
		</div>
	</a>
</div>