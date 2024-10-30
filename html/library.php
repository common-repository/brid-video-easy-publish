<script>
	$BridWordpressConfig = {};
	$BridWordpressConfig.pluginUrl = '<?php echo BRID_PLUGIN_URL; ?>';
	$BridWordpressConfig.Player = <?php echo $playerSettings; ?>;
	//Playlist selected videos
	var selectedVideos = new Array();
	var playlistTitle = '';
	window.disable_shortcode = '<?php echo $disable_shortcode; ?>';
	window.CDN_Path = '<?php echo $CDN_Path; ?>';
</script>
<div class="supports-drag-drop" style="position: relative;">
	<div class="media-modal wp-core-ui" style="position:absolute;left:0px;bottom:0px;top:0px;right:0px;">

		<div class="media-modal-content" style="min-height:580px" id="bridLibraryContent">

			<?php require_once BRID_PLUGIN_DIR . '/html/video_library.php'; ?>
		</div>
	</div>
</div>
<script>
	var file_frame = null;
</script>