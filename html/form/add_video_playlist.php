<script>
	playlistId = <?php echo $playlist_id; ?>;
</script>
<div id="addPlaylistVideos">
	<h3 class="lined linedWidth" style="margin-left:15px;"><span><?php _e('ADD VIDEO TO PLAYLIST'); ?></span></h3>
	<!-- Top menu end -->
	<div class="playlist_bp_list_items mainWrapper mainWrap" id="video-list" style="-webkit-overflow-scrolling:touch;overflow-y:auto;"></div>

</div>
<!-- JS part -->
<script type="text/javascript">
	//Load video list
	$Brid.Api.call({
		data: {
			action: "videos",
			mode: 'playlist',
			subaction: 'editPlaylist',
			playlistType: '<?php echo $playlistType; ?>'
		},
		callback: {
			after: {
				name: "insertContent",
				obj: jQuery("#video-list")
			}
		}
	});
</script>