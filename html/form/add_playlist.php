<div id="addPlaylistVideos">
	<h3 class="lined linedWidth" style="margin-left:15px;"><span><?php _e('ADD VIDEO TO PLAYLIST'); ?></span></h3>

	<!-- Top menu start -->

	<!-- Top menu end -->
	<div class="playlist_bp_list_items mainWrapper mainWrap" id="video-list" style="-webkit-overflow-scrolling:touch;overflow-y:auto;"></div>

</div>

<div class="mainWrapper mainWrap">
	<!-- Form part -->
	<div class="users form" id="addPlaylistForm">
		<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="PlaylistAddForm" onsubmit="event.returnValue = false; return false;" method="post" data-redirect="/playlists/index/" accept-charset="utf-8">
			<div style="display:none;">
				<input type="hidden" name="_method" value="POST">
			</div>

			<div class="formWrapper">

				<h3 class="lined"><span><?php _e('ADD PLAYLIST'); ?></span></h3>
				<div id="mainDataLight">
					<table>
						<tbody>
							<tr>
								<td>
									<input type="hidden" name="action" value="addPlaylist">
									<input type="hidden" name="insert_via" value="2">
									<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
									<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
									<input type="hidden" name="ids" id="VideoIds">
									<input type="hidden" name="submit" value="1" id="PlaylistSubmit">
									<div class="input text required">
										<input name="name" id="PlaylistNameId" data-info="Playlist name" default-value="Enter playlist name" maxlength="250" type="text" required="required">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="bridButton saveButton dsiabled lightboxSave" data-callback="insertContentPlaylists" data-form-id="PlaylistAddForm" id="playlistSaveAdd1">
										<div class="buttonLargeContent"><?php _e('SAVE'); ?></div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

			</div>
		</form>
	</div>
</div>
<!-- JS part -->
<script type="text/javascript">
	var playlistType = '<?php echo $playlistType; ?>';
	//Load video list
	$Brid.Api.call({
		data: {
			action: "videos",
			playlistType: playlistType,
			mode: 'playlist',
			subaction: 'addPlaylist' + '<?php echo $videoType; ?>'
		},
		callback: {
			after: {
				name: "insertContent",
				obj: jQuery("#video-list")
			}
		}
	});

	//Execute save on enter
	jQuery('#PlaylistNameId').keypress(function(e) {
		if (e.which == 13) {
			var save = saveObj.init();
			save.save('PlaylistAddForm');
		}
	});

	jQuery('#addPlaylistVideos #VideoIndexForm').submit(function() {
		return false;
	});
</script>