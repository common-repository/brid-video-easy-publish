<!-- Create Playlist form Post -->
<script>
	var mode = '<?php echo $mode; ?>'; //playlist mode
	var buttonsOff = '<?php echo $buttonsOff; ?>';
	var playlistType = '<?php echo $playlistType; ?>';
</script>
<div class="attachments-browser">
	<div class="media-toolbar media-brid-toolbar" style="width:100%;display:inline-block; padding-top: 10px;height: 0;">
		<div class="media-toolbar-secondary">
			<div class="searchBox search-box">
				<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoIndexForm" data-loadintodivclass="bp_list_items" method="post" accept-charset="utf-8">
					<div style="display:none;">
						<input type="hidden" name="_method" value="POST">
					</div>
					<div style="width:170px;float:left;padding-top:3px;margin:0px;">
						<div class="input text">
							<input name="data[Playlist][search]" value="<?php echo $search; ?>" placeholder="Search Playlists" class="inputSearch search" autocomplete="off" type="text" id="PlaylistSearch" style="margin-top: 0px;">

						</div>
					</div>
					<div class="searchButtonWrapper">
						<div class="searchButton" id="button-search-Partneruser"></div>
					</div>
				</form>
			</div>
			<script>
				//searchObj sent to configure Search
				$Brid.init([
					['Html.Search', {
						className: '.inputSearch',
						view: 1,
						action: "playlistLibraryPost",
						after: {
							name: "insertContentPaginationPlaylist",
							obj: jQuery("#videoItems")
						},
						model: 'Playlist',
						objInto: 'videoItems'
					}]
				]);
			</script>

			<div style="padding:0px; box-sizing: border-box;float:left; margin-top: 1px;margin-left: 35px;">
				<select id="playerSelected" class="chzn-select" style="width: 300px;">
					<?php

					$selectedPlayer = BridOptions::getOption('player');
					foreach ($players as $player) {
						$selected = "";
						if ($player['Player']['id'] == $selectedPlayer) {
							$selected = "selected";
						}

						echo '<option data-width="' . $player['Player']['width'] . '" data-height="' . $player['Player']['height'] . '" value="' . $player['Player']['id'] . '" ' . $selected . '>' . $player['Player']['name'] . ' - ' . $player['Player']['width'] . ' X ' . $player['Player']['height'] . '</option>';
					}
					?>
				</select>
			</div>

		</div>
	</div>
	<div id="videoItems">
		<?php require_once('playlist_list.php'); ?>
	</div>

</div>
<script>
	var paginationOrder = '';
	var saved = false;

	jQuery('#playlistSaveAdd').css('display', 'none');
	jQuery('#playlistSaveAdd').addClass('disabled');

	jQuery('#copy_shortcode').css('display', 'inline-block');
	jQuery('#copy_shortcode').addClass('disabled');

	jQuery('#playlistSaveAdd').off('click.AddPlaylistPostBrid').on('click.AddPlaylistPostBrid', function() {
		saved = true;
		if (brid_playlist_item != undefined) {
			jQuery("#videoSaveAdd").removeAttr('data-method');
			save.save('VideoAddForm', null, 'playlistSaveAdd');
		}

	});

	jQuery('#updateBridItem').off('click.UpdatePlaylistBrid').on('click.UpdatePlaylistBrid', function() {
		if (!jQuery(this).hasClass('disabled')) {
			jQuery("#videoSaveAdd").removeAttr('data-method');
			save.save('VideoAddForm', null, 'updateBridItem');
		}
	});

	document.BridAPIReady = function() {

		var brid = jQuery('#video-embed').find('.brid')
		brid.css('height', '200px');
		var id = brid.attr('id');
		$bp(id).onResize();
	}
	window.bindBridPlaylistItemClick = function() {

		jQuery('.bridItem').on('click', function() {
			var i = jQuery(this);
			document.APIReadyDispatched = false;
			jQuery('.bridItem').removeClass('details selected');

			var index = i.attr('data-video-index');
			brid_playlist_item = brid_playlists[index];
			var id = i.attr('data-video-id');
			// Take name from first video in playlist or get playlist name
			var name = brid_playlist_item.Playlist.name;
			if (typeof brid_playlist_item.Video !== "undefined") {
				if (brid_playlist_item.Video.length >= 1) {
					var name = brid_playlist_item.Video[0].name;
				}
			}
			var playlistName = i.attr('data-video-name');

			if (!i.hasClass('selected')) {

				i.addClass('details selected');

				jQuery('#playlistSaveAdd').hide();
				jQuery('#copy_shortcode').show();

				var player_selected = $BridWordpressConfig.Player.id;
				if (jQuery('#playerSelected').length > 0) {
					player_selected = parseInt(jQuery('#playerSelected').val());
				}

				debug.log('Player selected', player_selected);

				var sc = $Brid.Util.shortCode(
					id,
					player_selected,
					name,
					"playlist"
				);
				var raw_embed = <?php echo BridOptions::getOption('raw_embed'); ?>;
				if (raw_embed) {
					jQuery.ajax({
							method: "POST",
							url: "<?php echo admin_url('admin-ajax.php') . '?action=getRawEmbed' ?>",
							data: {
								shortcode: sc
							}
						})
						.done(function(msg) {
							sc = msg;
							jQuery('#brid_shortcode').val(sc);

							jQuery('#copy_shortcode').removeClass('disabled');

							jQuery('#bridVideoDetails').show();
							jQuery('.flashFalbackWarring').show();

							jQuery('#PlaylistName').val(playlistName);

							jQuery('#PlaylistId').val(id);
							jQuery('#updateBridItem').removeClass('disabled');
							jQuery('#VideoAddForm').css('display', 'block');
						});
				} else {
					jQuery('#brid_shortcode').val(sc);

					jQuery('#copy_shortcode').removeClass('disabled');

					jQuery('#bridVideoDetails').show();
					jQuery('.flashFalbackWarring').show();

					jQuery('#PlaylistName').val(playlistName);

					jQuery('#PlaylistId').val(id);
					jQuery('#updateBridItem').removeClass('disabled');
					jQuery('#VideoAddForm').css('display', 'block');
				}
			} else {
				jQuery('.flashFalbackWarring').hide();
				i.removeClass('details selected');
				jQuery('#playlistSaveAdd').addClass('disabled');
				jQuery('#updateBridItem').addClass('disabled');
				brid_playlist_item = null;

			}

			debug.log('brid_video_item', brid_video_item);
			debug.log('selectedVideos', selectedVideos);

			initSelected();

		});
	}

	//Set playlist name
	window.bindPlaylistTitle = function() {
		var playlistName = jQuery('#PlaylistName');
		if (playlistTitle != '') {
			playlistName.val(playlistTitle);
		}

		playlistName.input(function() {

			playlistTitle = playlistName.val();
			if (playlistTitle != '') {
				jQuery('#playlistSaveAdd').removeClass('disabled');
			} else {
				jQuery('#playlistSaveAdd').addClass('disabled');
			}

		});

	}

	//Pagination links
	window.bindBridPlaylistPagination = function() {

		//Init pagination links
		jQuery(".pagination-link").on("click", function(event) {
			if (jQuery(this).attr('data-order') != undefined) {
				paginationOrder = jQuery(this).attr('data-order');
				var order = '';
				if (jQuery(this).hasClass('asc')) {
					order = 'desc';
					jQuery(this).removeClass('asc').addClass('desc');

				} else if (jQuery(this).hasClass('desc')) {
					order = 'asc';
					jQuery(this).removeClass('desc').addClass('asc');

				} else {
					order = 'asc';
					jQuery(this).addClass('asc');
				}

				paginationOrder += order + '/';
			}

			var page = jQuery(this).attr('data-page');
			var pagination = {
				data: {
					action: "playlistLibraryPost",
					subaction: '<?php echo $subaction; ?>',
					mode: mode,
					view: 0,
					search: '<?= $search ?>',
					apiQueryParams: paginationOrder + 'page:' + page,
					buttons: buttonsOff
				},
				callback: {
					after: {
						name: "insertContentPaginationPlaylist",
						obj: jQuery("#videoItems")
					}
				}
			};

			if (mode == 'playlist') {
				pagination.data.playlistType = playlistType;
			}
			$Brid.Api.call(pagination);
			return false;
		});
	}

	bindBridPlaylistItemClick();
	bindBridPlaylistPagination();
	bindPlaylistTitle();
	initBridMain();


	//Clear selected items in playlist
	function clearSelectedVideos() {
		jQuery('.bridItem').removeClass('details selected');
		selectedVideos = new Array();
		initSelected();
	}

	//Set csv ids in hidden input for selected items
	function setSlectedVideos() {
		var a = [];
		for (var k in selectedVideos) {
			a.push(selectedVideos[k].id);
		}
		jQuery('#VideoIds').val(a.join(','));
	}

	//Init seleted mark them selected
	function initSelected() {
		var i = 0;
		for (var k in selectedVideos) {
			jQuery('#brid-video-item-' + selectedVideos[k].id).addClass('details selected');
			i++;
		}

		jQuery('.count').html(i + ' selected');
		setSlectedVideos();
	}
	initSelected();
</script>