<div class="mainWrapper mainWrap" style='padding-top:10px;'>
	<?php $playlistType = count($playlist->Video) ? $playlist->Video[0]->external_type : 0;  ?>
	<div class="playlists form mainWrap" style="padding-top:30px;">
		<!-- @see http://manos.malihu.gr/tuts/jquery_thumbnail_scroller.html# -->
		<table style="width:100%;">
			<tbody>
				<tr>
					<td>
						<!-- Top menu start -->
						<div class="mainWrapper mainWrap">
							<div class="list-items-menu">
								<div class="list-items-menu-wrapper">
									<ul class="items-menu">
										<li class="" style="float:left; cursor: pointer; font-family: 'Fjalla One', Arial; font-size: 17px; margin-right: 30px;">
											<div id="add-video-to-playlist" style="border: 1px solid;padding: 3px 7px;border-radius: 5px;background-color: #D70000;color: white;">
												<div class="various bridAjaxAddVideosToPlaylists" style="font-size: 16px;" data-id="<?php echo $playlist->Playlist->id; ?>" data-action="addVideoPlaylist" href="<?php echo admin_url('admin-ajax.php'); ?>"><?php _e('ADD VIDEO TO PLAYLIST'); ?></div>
											</div>
											<script>
												jQuery('.bridAjaxAddVideosToPlaylists').colorbox({
													innerWidth: "90%",
													innerHeight: "100%",
													maxWidth: 945,
													maxHeight: 808,
													data: {
														action: 'addVideoPlaylist',
														id: <?php echo $playlist->Playlist->id; ?>,
														playlistType: '<?php echo $playlistType; ?>'
													}
												});
											</script>
										</li>
										<li class="" style="float:left;">
											<div id="button-empty" class="" style="font-family: 'Fjalla One', Arial; font-size: 17px; cursor: pointer;">
												<div class="delButtonSmall" style="float:left;"></div>
											</div>
										</li>
										<li class="" style="float:left;">
											<div class="" style="font-family: 'Fjalla One', Arial; font-size: 17px; margin-top:4px;">
												<?php _e('DELETE PLAYLIST'); ?>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<!-- Top menu end -->
						<div style="width:100%; position:relative;">
							<div class="disablePlaylistOrder"></div>
							<div id="tS2" class="jThumbnailScroller">
								<div class="jTscrollerContainer">
									<div class="jTscroller" id="sortable">
										<?php foreach ($playlist->Video as $k => $v) { ?>
											<a href="javascript:void(0)" style="position:relative;" id="video-thumb-id-<?php echo $v->id; ?>" class="playlist-item" data-ajax-loaded="true" data-info="<?php echo $v->name; ?>">
												<?php

												$get_img = function () use ($v) {
													if (!empty($v->thumbnail) && strpos($v->thumbnail, 'http') === FALSE) return BridHtml::getPath(array('type' => 'thumb', 'id' => $v->partner_id)) . $v->thumbnail;
													if (!empty($v->thumbnail)) return $v->thumbnail;
													if (!empty($v->image) && strpos($v->image, 'http') === FALSE) return BridHtml::getPath(array('type' => 'snapshot', 'id' => $v->partner_id)) . $v->image;
													if (!empty($v->image)) return $v->image;
													if (!empty($v->snapshots->th)) return BridHtml::getPath(array('type' => 'snapshot', 'id' => $playlist->Playlist->partner_id)) . $v->snapshots->th;
													if (!empty($v->snapshots->sd)) return BridHtml::getPath(array('type' => 'snapshot', 'id' => $playlist->Playlist->partner_id)) . $v->snapshots->sd;
													return '';
												};

												$snapImg = $get_img();
												?>
												<img src="<?php echo $snapImg; ?>" width="120" height="104" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;" alt="">
												<div class="hoverDiv"></div>
												<div class="playlist_delete_video" data-playlist-id="<?php echo $playlist->Playlist->id; ?>" data-id="<?php echo $v->PlaylistsVideo->id; ?>" data-video-id="<?php echo $v->id; ?>"></div>
												<div class="playlist_number" id="playlist-number-0">
													<span><?php echo ($k + 1); ?></span>
												</div>
												<div class="time"><?php echo self::format_time($v->duration); ?></div>
											</a>
										<?php } ?>
									</div>
								</div>
							</div>

						</div>
					</td>
				</tr>
				<tr>
					<td style="text-align:center; color:#939598; font-size:13px;">
						<?php _e('Drag & Drop to order items in your playlist'); ?>
					</td>
				</tr>
			</tbody>
		</table>

		<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="PlaylistEditForm" method="post" data-redirect="/playlists/index/" accept-charset="utf-8">
			<div style="display:none;">
				<input type="hidden" name="_method" value="PUT">
			</div>
			<input type="hidden" name="action" value="editPlaylist">
			<input type="hidden" name="insert_via" value="2">
			<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
			<input type="hidden" name="id" id="PlaylistId" value="<?php echo $playlist->Playlist->id; ?>">

			<div style="padding-top:29px; float:left; width:100%; border-top:1px solid #d9d9da; margin-top: 3px">

				<div id="player" style="float:left;margin-left:20px;">
					<?php $random_id = 'Brid_video_' . time(); ?>
					<!-- Preview player -->
					<div id="preview-player" style="float:left">
						<script data-cfasync="false" type="text/javascript" src='<?php echo CLOUDFRONT . "player/build/brid.min.js"; ?>'></script>
						<div id="<?php echo $random_id; ?>" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
							<div id="Brid_video_adContainer"></div>
						</div>
						<script type="text/javascript">
							$bp("<?php echo $random_id; ?>", {
								id: '<?= BridOptions::getOption('player'); ?>',
								playlist: '<?php echo $playlist->Playlist->id; ?>',
								width: '366',
								height: '227'
							});
						</script>
					</div>

					<div id="playlistRightSide">

						<table style="width:100%;">

							<tbody>
								<tr>
									<td>
										<div class="input text required"><label for="PlaylistName"><?php _e('Playlist title'); ?></label><input name="name" default-value="Playlist name" data-info="Playlist name" maxlength="250" type="text" value="<?php echo $playlist->Playlist->name; ?>" id="PlaylistName" required="required"></div>
									</td>
								</tr>

								<tr>
									<td style="padding-top:15px;">
										<div class="input text"><label for="PlaylistPublish"><?php _e('Publish on a date'); ?></label>
											<input name="publish" readonly="readonly" class="datepicker inputField" default-value="<?php echo date('m-d-Y'); ?>" data-info="Publish playlist on a date" type="text" value="<?php echo $playlist->Playlist->publish; ?>" id="PlaylistPublish">
										</div>
									</td>
								</tr>

								<tr>
									<td style="padding-top:22px;">

										<div class="bridButton saveButton save-playlist" data-form-id="PlaylistEditForm" id="playlistSaveEdit" style="margin-bottom:40px;">
											<div class="buttonLargeContent"><?php _e('SAVE'); ?></div>
										</div>

									</td>
								</tr>
							</tbody>
						</table>

					</div>
				</div>

				<div class="propagate">
					<div><?php _e('Please allow up to 3 minutes for changes to propagate'); ?>.</div>
				</div>
		</form>

	</div>
</div>
<script>
	var dragInProgress = false;
	var hoverDelay = 200;
	var touchEvents = false;
	var playlistId = <?php echo $playlist->Playlist->id; ?>;
	/**
	 * Init scrollet on Playlists Edit page
	 * @param opt
	 */
	var opt = {
		scrollerType: "hoverAccelerate",
		scrollerOrientation: "horizontal",
		scrollSpeed: 3,
		scrollEasing: "easeOutCirc",
		scrollEasingAmount: 200,
		acceleration: 0.5,
		scrollSpeed: 500,
		noScrollCenterSpace: 200,
		autoScrolling: 0,
		autoScrollingSpeed: 1000,
		autoScrollingEasing: "easeInOutQuad",
		autoScrollingDelay: 5000
	};

	function initScroller(opt) {

		debug.log('INIT: initScroller');

		jQuery('.jThumbnailScroller').thumbnailScroller('destroy');
		jQuery('.jThumbnailScroller').thumbnailScroller(opt);


	}

	function updateNumbers() {

		jQuery('.playlist_number').each(function(k, v) {
			jQuery(this).html('<span>' + (k + 1) + '</span>');
		});
	}

	function getVideosOrder() {

		var videos = [];

		jQuery('#sortable').children().each(function(k, v) {
			//Update item numbers in playlist
			videos.push(jQuery(v).attr('id').replace('video-thumb-id-', ''));
		});

		return videos.join(',');
	}
	window.updateSortableWidth = function() {

		var c = jQuery('#sortable').children().length;
		var l = jQuery('#sortable a').outerWidth(true);

		debug.log('width new', (c * l));

		jQuery('#sortable').css('width', '858px');
		jQuery('.jTscrollerContainer').css('width', '858px');

	}


	function initSortable() {
		jQuery("#sortable").sortable({
			start: function(event, ui) {
				dragInProgress = true;
			},
			stop: function(event, ui) {
				jQuery('.playlist-item').css('left', '0px');
				dragInProgress = false;
			},
			containment: '#sortable',
			update: function(event, ui) {
				jQuery('.playlist-item').css('left', '0px'); //Fix floating Images - not to disapeare or make any blank space AZ bug #131 - Call it twice
				updateNumbers();
				jQuery('.disablePlaylistOrder').fadeOut();
				hideOver();

				$Brid.Api.call({
					data: {
						action: "sortVideos",
						id: playlistId,
						sort: getVideosOrder()
					},
					callback: {
						after: {
							name: "updatePlaylistItems",
							obj: jQuery("#sortable")
						}
					}
				});

			}
		});

		jQuery("#sortable").disableSelection();

	}

	var playlistHoverTimer = null;

	function showOver() {
		var $this = jQuery(this);

		//Hide all hovers
		hideOver();

		playlistHoverTimer = setInterval(function() {

			$this.find('.hoverDiv').fadeIn(100);
			$this.find('.playlist_delete_video').fadeIn();

			clearInterval(playlistHoverTimer);
			playlistHoverTimer = null;
		}, hoverDelay);

	}

	function hideOver() {
		clearInterval(playlistHoverTimer);
		playlistHoverTimer = null;

		jQuery('.hoverDiv').hide();
		jQuery('.playlist_delete_video').hide();

	}

	function initPlaylistHover() {

		jQuery('.playlist-item').off('mouseenter.Playlist', showOver);
		jQuery('.playlist-item').off('mouseleave.Playlist', hideOver);

		jQuery('.playlist-item').on('click.Playlist', showOver);
		jQuery('.playlist-item').on('mouseenter.Playlist', showOver);
		jQuery('.playlist-item').on('mouseleave.Playlist', hideOver);

	}

	var mouseX;
	var mouseW;
	var animDelay = null;

	var mousemove = function(e) {
		pos = findPos(this);
		mouseX = (e.pageX - pos[1]);
		if (mouseX < 50) {
			if (!animDelay) {
				animDelay = setInterval("jQuery('.jTscrollerPrevButton').trigger('click');", 1200);
			}
		} else if (mouseW - mouseX < 50) {
			if (!animDelay) {
				animDelay = setInterval("jQuery('.jTscrollerNextButton').trigger('click');", 1200);
			}
		} else if (animDelay) {
			clearInterval(animDelay);
			animDelay = null;
		}
	}

	//Init save object
	var save = saveObj.init();
	//Inti all necessary items
	function initDeleteItem() {
		jQuery('.playlist_delete_video').off('click').on('click', function() {

			if (confirm("Are you sure you want to remove this video?")) {
				var id = jQuery(this).attr('data-playlist-id');

				var video_id = jQuery(this).attr('data-video-id');
				$Brid.Api.call({
					data: {
						action: "removeVideoPlaylist",
						id: id,
						video_id: video_id
					},
					callback: {
						after: {
							name: "removePlaylistSingleItem",
							obj: jQuery(this)
						}
					}
				});
			}

		});
	}

	function initPlaylistMainFunctions() {

		debug.log('INIT PLAYLIST: initPlaylistMainFunctions');

		initBridMain();
		initSortable();
		initDeleteItem(); //Delete single video
		initPlaylistHover();

	}

	initPlaylistMainFunctions();

	//Clear Playlist
	jQuery('#button-empty').click(function(e) {
		e.preventDefault();
		if (confirm("Are you sure you want to remove all items from this playlist?")) {
			$Brid.Api.call({
				data: {
					action: "clearPlaylist",
					id: playlistId
				},
				callback: {
					after: {
						name: "removePlaylistItems",
						obj: jQuery("#sortable")
					}
				}
			});
		}
	});
</script>