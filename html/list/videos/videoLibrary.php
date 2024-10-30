<?php
$insertIntoContent = '#Videos-content';
//Playlist mode
if ($mode != '') {
	$insertIntoContent = '#video-list';
}

?>
<script type="text/javascript">
	var mode = '<?php echo $mode; ?>'; //playlist mode
	var buttonsOff = '<?php echo $buttonsOff; ?>';
	var playlistType = '<?php echo $playlistType; ?>';
	var videoLibraryPlayers = [];
	<?php foreach ($players as $player) : ?>
		videoLibraryPlayers[<?php echo $player['Player']['id']; ?>] = {
			"autoplay": "<?php echo $player['Player']['autoplay']; ?>"
		};
	<?php endforeach; ?>
</script>

<div class="attachments-browser">
	<div class="media-toolbar media-brid-toolbar" style="width:100%;display:inline-block; height: 0px; padding-top: 10px;">
		<div class="media-toolbar-secondary">

			<div class="filter-button">
				<img src="<?php echo BRID_PLUGIN_URL; ?>img/filter.svg" />
			</div>

			<div class="filter-box">
				<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoIndexForm" data-loadintodivclass="bp_list_items" method="post" accept-charset="utf-8">
					<input type="hidden" name="_method" value="POST">

					<!-- Filter title -->
					<input value="<?php echo $search; ?>" placeholder="Search Title" class="inputSearch filter" autocomplete="off" type="text" id="VideoSearch">

					<!-- Filter tag -->
					<input value="<?php echo $searchTag; ?>" placeholder="Search Tag" class="inputSearchTag filter" autocomplete="off" type="text" id="VideoSearchTag">

					<!-- Filter status -->
					<select class="inputSearchStatus filter chzn-select" id="VideoSearchStatus" style="width: 300px;">
						<option value="">Choose video status</option>
						<option value="0">Paused</option>
						<option value="1">Published</option>
						<option value="3">Encoding</option>
						<option value="4">Uploading</option>
						<option value="5">Failed</option>
						<option value="7">Pending</option>
					</select>

					<!-- Filter carousel -->
					<div class="filter-checkbox">
						<label for="VideoSearchCarousel">Show only carousel videos</label>
						<input id="VideoSearchCarousel" class="filter" type="checkbox" value="1">
					</div>

					<!-- Filter reset -->
					<div class="button secondary" id="filter-reset">Reset</div>

				</form>
			</div>

			<script>
				// Open filter box
				jQuery(document).off("click", ".filter-button").on("click", ".filter-button", function(e) {
					jQuery(".filter-box").toggle();
				});

				// Reset filters
				jQuery(document).off("click", "#filter-reset").on("click", "#filter-reset", function(e) {
					jQuery('#VideoSearch').val("");
					jQuery('#VideoSearchTag').val("");
					jQuery('#VideoSearchStatus').val("").trigger("chosen:updated");
					jQuery('#VideoSearchCarousel').attr("checked", false);

					jQuery('#VideoSearch').trigger("change");
				});

				// Apply filters on input|select change
				jQuery(document).off("change").on("change", ".filter", function(e) {
					jQuery("#bridSpin").css("visibility", "visible");

					setTimeout(function() {
						jQuery(".filter-box").toggle();
					}, 300);

					jQuery.ajax({
						url: "/wp-admin/admin-ajax.php",
						type: "POST",
						data: {
							action: "videoLibraryPost",
							search: jQuery("#VideoSearch").val(),
							searchTag: jQuery("#VideoSearchTag").val(),
							status: jQuery("#VideoSearchStatus").val(),
							carouselOnly: jQuery("#VideoSearchCarousel:checked").val(),
						},
						success: function(response) {
							// console.log("SUCCESS");

							jQuery("#bridSpin").css("visibility", "hidden");
							jQuery("#brid-content").html(response);
						},
						error: function(response) {
							// console.log("ERROR");
						},
					});

					return false;
				});
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
		<?php require_once 'videos_list.php'; ?>
	</div>

	<!-- SIde bar -->
	<div class="media-sidebar">

		<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">

			<input name="id" type="hidden" id="VideoId">
			<input name="partner_id" type="hidden" id="VideoPartnerId">
			<input type="hidden" name="action" value="editVideo">
			<input type="hidden" name="insert_via" id="VideoInsertVia" value="2">

			<div class="attachment-info save-ready" id="bridVideoDetails" style="display:none;">

				<div id="video-embed" style="margin-top:10px;"></div>
				<h3>
					<?php _e('Video Details'); ?>
					<span class="settings-save-status">
						<span class="spinner"></span>
						<span class="saved"><?php _e('Saved'); ?>.</span>
					</span>
				</h3>
				<div class="separator" style="border-bottom: 1px solid #ddd;margin-bottom:10px;"></div>

				<label class="setting" data-setting="title">
					<span><?php _e('Video Title'); ?></span>
					<input name="name" maxlength="250" type="text" placeholder="Video title" id="VideoName" required="required">
				</label>
				<label class="setting" data-setting="caption">
					<span><?php _e('Description'); ?></span>
					<textarea name="description" placeholder="Video description" id="VideoDescription"></textarea>
				</label>
				<label class="setting" data-setting="description">
					<span><?php _e('Publish date'); ?></span>
					<div style="position:relative;z-index:9999;cursor:pointer">
						<input name="publish" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" default-value="<?php echo date('d-m-Y'); ?>" class="datepicker inputField" type="text" id="VideoPublish" style="cursor:pointer">
					</div>
				</label>
				<p class="setting" data-setting="status">
					<span><?php _e('Status'); ?></span>
					<span id="VideoStatus"></span>
				</p>
			</div>
		</form>
	</div>

</div>
<script type="text/javascript">
	var checkStatusInterval;

	// // Ajax video status check
	function checkVideosStatus(index) {

		// Close interval if widget box is closed
		if (jQuery("#colorbox").css("display") == "none") {
			console.log('-- videos ajax close interval --');
			clearInterval(checkStatusInterval);
			return false;
		}

		var page_value = jQuery(".paging").find(".current").text();
		// var search_value = jQuery("#VideoSearch").val();

		jQuery.ajax({
			url: '/wp-admin/admin-ajax.php',
			type: 'POST',
			dataType: "json",
			data: {
				action: "getVideosInfo",
				apiQueryParams: "page:" + page_value,
				search: search_from_post,
				searchTag: search_tag_from_post,
				status: search_status,
				carouselOnly: search_carousel,
			},
			success: function(response) {
				// Update variables with fres data
				brid_videos = response;
				brid_video_item = brid_videos[index];

				debug.log("videos - status checking - ", brid_video_item);

				// Set new status message
				setStatus(brid_video_item);
			},
			error: function(response) {
				console.log("ERROR");
				console.log(response);
			}
		});
	}

	//Video Library post page
	var paginationOrder = '';
	var default_player = <?php echo BridOptions::getOption('player'); ?>;
	var saved = false;
	var save = saveObj.init();

	jQuery(".chzn-select").chosen();

	jQuery('#copy_shortcode').css('display', 'inline-block');
	jQuery('#copy_shortcode').addClass('disabled');

	jQuery('#videoSaveAdd').css('display', 'inline-block');
	jQuery('#videoSaveAdd').addClass('disabled');

	jQuery(document).ready(function() {
		jQuery("#copy_shortcode").unbind('click').css('display', 'inline-block');
		jQuery('#copy_shortcode').off('click.AddPostBrid').on('click.AddPostBrid', function() {

			// If status is not true
			// and
			// If enabled, disable copy_shortcode button
			// than we will disable copy_shortcode button on click
			if (setStatus(brid_video_item) == false && disable_shortcode != '0') {
				return;
			}

			saved = true;
			if (brid_video_item != undefined) {

				if (checkFormChanges()) {
					jQuery("#videoSaveAdd").removeAttr('data-method');
					save.save('VideoAddForm');
				}
				var player_selected = default_player;
				if (jQuery('#playerSelected').length > 0) {
					player_selected = parseInt(jQuery('#playerSelected').val());
				}

				debug.log('Player selected', player_selected);

				var code = $Brid.Util.shortCode(
					brid_video_item.Video.id,
					player_selected,
					jQuery('#VideoName').val(), //brid_video_item.Video.name,
					"video",
					videoLibraryPlayers[player_selected].autoplay
				);
				var raw_embed = <?php echo BridOptions::getOption('raw_embed'); ?>;
				if (raw_embed) {
					jQuery.ajax({
							method: "POST",
							url: "<?php echo admin_url('admin-ajax.php') . '?action=getRawEmbed' ?>",
							data: {
								shortcode: code
							}
						})
						.done(function(msg) {
							code = msg;
							jQuery("#brid_shortcode").show();
							jQuery("#brid_shortcode").val(code);
							var copyText = jQuery("#brid_shortcode").select();
							document.execCommand("copy");
							jQuery("#brid_shortcode").hide();
							jQuery.colorbox.close();
						});
				} else {
					jQuery("#brid_shortcode").show();
					jQuery("#brid_shortcode").val(code);
					var copyText = jQuery("#brid_shortcode").select();
					document.execCommand("copy");
					jQuery("#brid_shortcode").hide();
					jQuery.colorbox.close();
				}
			}
		});

		jQuery("#videoSaveAdd").unbind('click');

		jQuery('#videoSaveAdd').off('click.PostBrid').on('click.PostBrid', function() {

			debug.log('click.PostBrid save from videoLibrary.php');

			if (!jQuery(this).hasClass('disabled')) {

				if (checkFormChanges()) {
					jQuery("#videoSaveAdd").removeAttr('data-method');
					save.save('VideoAddForm', null, 'updateBridItem');
				}
			}

		});

		function callSave() {
			if (brid_video_item != undefined && !saved) {
				if (!jQuery(this).hasClass('disabled') && !jQuery("#videoSaveAdd").hasClass('inprogress')) {

					//save changes made to title, desc, publish
					if (checkFormChanges()) {
						jQuery("#videoSaveAdd").removeAttr('data-method');
						save.save('VideoAddForm');
					}
					//onVideoSave callback will add shortcode to post

				}

			}
		}

		function checkFormChanges() {

			if (jQuery('#VideoName').val() != brid_video_item.Video.name) {
				return true;
			}
			if (jQuery('#VideoDescription').val() != brid_video_item.Video.description) {
				return true;
			}
			if (jQuery('#VideoPublish').val() != brid_video_item.Video.publish) {
				return true;
			}
			return false;
		}

		document.BridAPIReady = function() {

			var brid = jQuery('#video-embed').find('.brid')
			brid.css('height', '200px');
			var id = brid.attr('id');
			$bp(id).onResize();
		}

		window.bindBridItemClick = function() {

			jQuery('.bridItem').on('click', function() {

				for (var p in Brid.players) {
					if (Brid.players[p]) {
						Brid.players[p].destroy();
					}
				}

				var i = jQuery(this);
				document.APIReadyDispatched = false;
				jQuery('.bridItem').removeClass('details selected');

				if (!i.hasClass('selected')) {

					i.addClass('details selected');
					var index = i.attr('data-video-index');

					brid_video_item = brid_videos[index];
					//Show save button
					jQuery('#copy_shortcode').css('display', 'inline-block');
					jQuery('#copy_shortcode').removeClass('disabled');

					jQuery('#videoSaveAdd').css('display', 'inline-block');
					jQuery('#videoSaveAdd').removeClass('disabled');
					jQuery('#updateBridItem').removeClass('disabled');

					jQuery('#bridVideoDetails').show();
					jQuery('.flashFalbackWarring').show();

					var brid_id = 'Brid_' + brid_video_item.Video.id;

					jQuery('#video-embed').html("").html('<div id="' + brid_id + '"></div>');

					$bp(brid_id, {
						"id": jQuery('#playerSelected').val(),
						"autoplay": false,
						"slide_inview": false,
						"width": "16",
						"height": "9",
						"video": brid_video_item.Video.id
					});

					jQuery('#VideoId').val(brid_video_item.Video.id);
					jQuery('#VideoName').val(brid_video_item.Video.name);
					jQuery('#VideoDescription').val(brid_video_item.Video.description);
					jQuery('#VideoPublish').val(brid_video_item.Video.publish);
					jQuery('#VideoInsertVia').val(brid_video_item.Video.insert_via);
					jQuery('#VideoPartnerId').val(brid_video_item.Video.partner_id);

					jQuery(document).bind('cbox_cleanup', callSave);

					debug.log('selected index - ', index);

					// Set video status message
					setStatus(brid_video_item);
					// Remove old interval
					clearInterval(checkStatusInterval)
					// Set interval for ajax checking status
					checkStatusInterval = setInterval(checkVideosStatus, 5000, index);

				} else {
					jQuery('#bridVideoDetails').hide();
					jQuery('.flashFalbackWarring').hide();
					i.removeClass('details selected');
					jQuery('#videoSaveAdd').addClass('disabled');
					jQuery('#copy_shortcode').addClass('disabled');
					brid_video_item = null;
				}

				debug.log('brid_video_item', brid_video_item);

			});
		}

		window.bindBridPagination = function() {
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
						action: "videoLibraryPost",
						subaction: '<?php echo $subaction; ?>',
						mode: mode,
						view: page,
						search: search_from_post,
						searchTag: search_tag_from_post,
						status: search_status,
						carouselOnly: search_carousel,
						apiQueryParams: paginationOrder + 'page:' + page,
						buttons: buttonsOff
					},
					callback: {
						after: {
							name: "insertContentPagination",
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


		bindBridItemClick();
		bindBridPagination();

		initBridMain();
	});
</script>