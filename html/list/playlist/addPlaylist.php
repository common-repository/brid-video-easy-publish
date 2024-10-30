<!-- Create Playlist form Post -->
<script>
	var mode = '<?php echo $mode; ?>'; //playlist mode?
	var buttonsOff = '<?php echo $buttonsOff; ?>';
	var playlistType = '<?php echo $playlistType; ?>';
</script>
<div class="attachments-browser">
	<div class="media-toolbar media-brid-toolbar" style="width:100%;display:inline-block; padding-top: 10px; height: 0;">
		<div class="media-toolbar-secondary">
			<div class="searchBox search-box">
				<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoIndexForm" data-loadintodivclass="bp_list_items" method="post" accept-charset="utf-8">
					<div style="display:none;">
						<input type="hidden" name="_method" value="POST">
					</div>
					<div style="width:170px;float:left;padding-top:3px;margin:0px;">
						<div class="input text">
							<input name="data[Video][search]" value="<?php echo $search; ?>" placeholder="Search Videos" class="inputSearch search" autocomplete="off" type="text" id="VideoSearch" style="margin-top: 0px;">

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
						playlistType: <?php echo $playlistType; ?>,
						action: "addPlaylistPost",
						after: {
							name: "insertContentPaginationPlaylist",
							obj: jQuery("#videoItems")
						},
						model: 'Video',
						objInto: 'videoItems'
					}]
				]);
			</script>
		</div>
	</div>
	<div id="videoItems">
		<?php if (!empty($videosDataset->data)) {
			$pagination = $videosDataset->paging->Video;
		?>
			<ul class="attachments ui-sortable ui-sortable-disabled" style="overflow-y: scroll!important;">

				<?php foreach ($videosDataset->data as $k => $v) { ?>
					<li class="attachment save-ready bridItem" data-video-index="<?php echo $k; ?>" id="brid-video-item-<?php echo $v->Video->id; ?>">
						<div class="attachment-preview type-video subtype-mp4 landscape" style="width:100%; height:135px">
							<?php $poster = $v->Video->thumbnail; ?>
							<img src="<?php echo $poster; ?>" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;" class="icon" draggable="false" style="width:100%; height:100%;padding-top:0px">
							<div class="filename">
								<div><?php echo $v->Video->name; ?></div>
							</div>
							<a class="check" href="#" title="Deselect">
								<div class="media-modal-icon"></div>
							</a>
						</div>
					</li>

				<?php } ?>
			</ul>
			<div class="pagination" style="position:absolute;right:300px; left:0px; width:auto; bottom:25px;margin-bottom:0px">
				<div class="mainWrapper" style="width:auto">

					<div class="paging">
						<?php if ($pagination->pageCount > 1) { ?>
							<span class="first"><a href="#" class="pagination-link" data-page="1" rel="first"> </a></span>
							<span class="prev"><a href="#" class="pagination-link" data-page="<?php echo $pagination->prevPage; ?>" rel="prev"> </a></span>
							<?php
							if ($pagination->page < 5) {
								$pageFrom = 1;
							} else {
								$pageFrom = $pagination->page - 4;
							}
							if (($pagination->page + 4) > $pagination->pageCount) {
								$pageTo = $pagination->pageCount;
							} else {
								$pageTo = $pagination->page + 4;
							}
							for ($i = $pageFrom; $i <= $pageTo; $i++) {

								if ($i == $pagination->page) {
							?>
									<span class="current"><?php echo $i; ?></span>&nbsp;
								<?php
								} else {
								?>
									<span><a href="#" data-page="<?php echo $i; ?>" class="pagination-link"><?php echo $i; ?></a></span>&nbsp;
							<?php
								}
							}
							?>
							<span class="next"><a href="#" class="pagination-link" data-page="<?php echo $pagination->nextPage; ?>" rel="next"> </a></span>
							<span class="last"><a href="#" class="pagination-link" data-page="<?php echo $pagination->pageCount; ?>" rel="last"> </a></span>
						<?php } ?>
						<div class="pagingInfo"><?php _e('Page'); ?> <?php echo $pagination->page; ?> <?php _e('of'); ?> <?php echo $pagination->pageCount; ?>, <?php _e('showing'); ?> <?php echo $pagination->current; ?> <?php _e('out of'); ?> <?php echo $pagination->count; ?> <?php _e('total'); ?></div>

					</div>
				</div>
			</div>
		<?php } ?>

		<!-- SIde bar -->
		<div class="media-sidebar">

			<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">

				<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
				<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
				<input type="hidden" name="ids" id="VideoIds">
				<input type="hidden" name="action" value="addPlaylist">
				<input type="hidden" name="playlistType" value="<?php echo $playlistType; ?>">
				<input type="hidden" name="insert_via" id="VideoInsertVia" value="2">

				<div class="attachment-info save-ready" id="bridVideoDetails" style="display:block;">

					<div id="video-embed" style="margin-top:10px;"></div>
					<h3>
						<?php _e('Playlist Details'); ?>
						<span class="settings-save-status">
							<span class="spinner"></span>
							<span class="saved" style="display:none;"><?php _e('Saved'); ?>.</span>
						</span>
					</h3>
					<div class="separator" style="border-bottom: 1px solid #ddd;margin-bottom:10px;"></div>

					<label class="setting" data-setting="title">
						<span><?php _e('Playlist Title'); ?></span>
						<input name="name" maxlength="250" type="text" placeholder="<?php _e('Playlist Title'); ?>" id="PlaylistName" required="required">
					</label>

				</div>

			</form>
			<input type="text" id="brid_shortcode1" style="width: 200px;height: 30px;display: none; margin-top: 290px;right: 50px;" />
		</div>
	</div>

</div>
<script>
	var paginationOrder = '';

	var brid_video_item = null;

	var brid_videos = <?php echo json_encode($videosDataset->data); ?>;

	var defaultPlayer = <?php echo BridOptions::getOption('player'); ?>;

	var saved = false;

	jQuery('#playlistSaveAdd').css('display', 'inline-block');
	jQuery('#playlistSaveAdd').addClass('disabled');

	jQuery('#copy_shortcode').css('display', 'none');
	jQuery('#copy_shortcode').removeClass('disabled');

	jQuery('#playlistSaveAdd').off('click.AddPlaylistPostBrid').on('click.AddPlaylistPostBrid', function() {

		if (jQuery('#playlistSaveAdd').hasClass('disabled') && selectedVideos.length == 0) {

			alert("Please enter Playlist title and select videos first");

		} else {
			saved = true;
			save.save('VideoAddForm');
		}

	});

	jQuery('#VideoAddForm').on("keyup keypress", function(e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
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

			for (var p in Brid.players) {
				if (Brid.players[p]) {
					Brid.players[p].destroy();
				}
			}
			document.APIReadyDispatched = false;
			var i = jQuery(this);

			var index = i.attr('data-video-index');
			brid_video_item = brid_videos[index];

			if (!i.hasClass('selected')) {

				i.addClass('details selected');

				debug.log('selected index', index, brid_video_item.Video);

				jQuery('#bridVideoDetails').show();
				jQuery('.flashFalbackWarring').show();

				var brid_id = 'Brid_Playlist_' + brid_video_item.Video.id;

				jQuery('#video-embed').html("").html('<div id="' + brid_id + '"></div>');

				debug.log('aaaa', {
					"id": defaultPlayer.toString(),
					"autoplay": false,
					"slide_inview": false,
					"width": "16",
					"height": "9",
					"video": brid_video_item.Video.id.toString()
				});

				$bp(brid_id, {
					"id": defaultPlayer.toString(),
					"autoplay": false,
					"slide_inview": false,
					"width": "16",
					"height": "9",
					"video": brid_video_item.Video.id.toString()
				});

				selectedVideos[brid_video_item.Video.id] = brid_video_item.Video;
				//details selected
			} else {
				delete(selectedVideos[brid_video_item.Video.id]);
				jQuery('.flashFalbackWarring').hide();
				i.removeClass('details selected');
				jQuery('#playlistSaveAdd').addClass('disabled');
				brid_video_item = null;
			}

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
			checkEnableSavePlaylist();
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
					action: "addPlaylistPost",
					subaction: '<?php echo $subaction; ?>',
					mode: mode,
					playlistType: playlistType,
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

			debug.log(mode, playlistType, pagination);

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


	//Check can we enable save button
	window.checkEnableSavePlaylist = function() {
		var playlistName = jQuery('#PlaylistName').val(),
			videos = jQuery('#VideoIds').val();
		debug.log('checkEnableSavePlaylist', playlistName, videos);
		if (playlistName != '' && videos != '') {
			jQuery('#playlistSaveAdd').removeClass('disabled');
		} else {
			jQuery('#playlistSaveAdd').addClass('disabled');
		}
	}

	//Clear selected items in playlist
	function clearSelectedVideos() {
		jQuery('.bridItem').removeClass('details selected');
		selectedVideos = new Array();
		initSelected();
		checkEnableSavePlaylist();
	}

	//Set csv ids in hidden input for selected items
	function setSlectedVideos() {

		var a = [];
		for (var k in selectedVideos) {

			a.push(selectedVideos[k].id);

		}
		jQuery('#VideoIds').val(a.join(','));
		checkEnableSavePlaylist();

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