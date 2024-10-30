<?php
$insertIntoContent = '#Videos-content';
//Playlist mode
if (!isset($mode)) $mode = '';
if (!isset($buttonsOff)) $buttonsOff = false;
if ($mode != '') {
	$insertIntoContent = '#video-list';
}

if ($mode != 'playlist') {

	if (!$buttonsOff) {
?>
		<!-- Add buttons start -->
		<div class="mainWrapper mainWrap">
			<div class="mainButtonsMenu" <?php if ($user['permissions']['upload'] == 0) { ?> style="margin-bottom: 10px;" <?php } ?>>

				<?php if ($user['permissions']['upload'] == 0) : ?>
					<div class="bridButton add-video">
						<a href="<?php echo "https://cms.brid.tv/users/login/?redirect=order"; ?>" target="_blank" class="buttonLargeContent" style="text-decoration: none"><?php _e('UPLOAD VIDEO'); ?></a>
						<div class="paidOnly" style="margin-left: 12px; margin-bottom: 5px;">
							<a href="<?php echo "https://cms.brid.tv/users/login/?redirect=order"; ?>" target="_blank">* <?php _e('Paid plans only'); ?></a>
						</div>
					</div>
				<?php else : ?>
					<div class="bridButton add-video" data-href="#" id="uploadVideo">
						<div class="buttonLargeContent"><?php _e('UPLOAD VIDEO'); ?></div>
					</div>
				<?php endif; ?>

				<?php if ($user['permissions']['disable_external_url'] == 0) : ?>
					<div class="bridButton add-video" data-href="#" id="addVideo">
						<div class="buttonLargeContent"><?php _e('ADD VIDEO'); ?></div>
					</div>
				<?php endif; ?>

				<?php if ($user['permissions']['youtube'] == 1) : ?>
					<div class="bridButton add-youtube" data-href="#" id="addYoutube" style="opacity: 1;">
						<div class="buttonLargeContent"><?php _e('ADD YOUTUBE'); ?></div>
					</div>
				<?php endif; ?>

			</div>


		</div>
		<!-- Add buttons end -->
<?php }
}
?>
<script>
	var mode = '<?php echo $mode; ?>'; //playlist mode?
	var buttonsOff = '<?php echo $buttonsOff; ?>';
	var playlistType = '<?php echo isset($playlistType) ? $playlistType : ''; ?>';
</script>

<div class="list-items-menu">

	<ul class="items-menu">
		<!-- Select all checkbox -->
		<li class="last">
			<div style="float: left; margin-top: 1px; margin-left: 10px;">
				<div id="checkbox-video-check-all" class="bridCheckbox clearfix" data-method="toggleAll" data-name="video">
					<div class="checkboxContent">
						<img src="<?php echo BRID_PLUGIN_URL ?>img/checked.png" class="checked" style="display:none" alt="">
						<input type="hidden" name="data[Video][video-check-all]" class="singleCheckbox" id="video-check-all" data-value="0" style="display:none;">
					</div>
				</div>
			</div>
			<?php if ($mode != 'playlist') { ?>
				<div id="google_button" class="google_button outer_button_div" style="float: left;">
					<div id="inner_button_checkbox" class="inner_button_div">
						<img alt="Click to open submenu" src="<?php echo BRID_PLUGIN_URL ?>img/arrow_down.png" style="vertical-align: top; position:absolute; top:8px; left:3px; width:8px; height:4px">
					</div>
				</div>
				<div id="g_menu" data-checkbox-id="checkbox-video-check-all" class="gdrop_down" style="display: none;">
					<div class="chkbox_action" style="cursor:pointer;" data-method="None"><?php _e('None'); ?></div>
					<div class="chkbox_action" style="cursor:pointer;" data-method="Published"><?php _e('Published'); ?></div>
					<div class="chkbox_action" style="cursor:pointer;" data-method="Pending"><?php _e('Pending'); ?></div>
					<div class="chkbox_action" style="cursor:pointer;" data-method="Failed"><?php _e('Failed'); ?></div>
					<div class="chkbox_action" style="cursor:pointer;" data-method="Paused"><?php _e('Paused'); ?></div>
					<div class="chkbox_action" style="cursor:pointer;" data-method="Monetized"><?php _e('Monetized'); ?></div>
					<div class="chkbox_action" style="cursor:pointer;" data-method="NotMonetized"><?php _e('Not Monetized'); ?></div>
				</div>
			<?php } ?>
		</li>
		<?php if ($mode == 'playlist') { ?>
			<li class="toolbarItem">
				<div class="redButtonBg addToPlaylistButton" style="top: -4px;" id="add-to-playlist-<?php echo $subaction; ?>">
					<div class="buttonSmallContent" style=""><?php _e('ADD TO PLAYLIST'); ?></div>
				</div>
			</li>
			<?php
		} else {

			if (!$buttonsOff) {
			?>
				<!-- Additional options -->
				<li class="toolbarItem">
					<div class="redButtonBg" id="delete-partner">
						<div class="delButtonSmall"></div>
					</div>
				</li>
		<?php }
		}
		?>
	</ul>
	<!-- Search -->
	<div id="site-search-box">
		<div class="searchBox search-box" style="margin-top: 0px;">
			<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoIndexForm" data-loadintodivclass="bp_list_items" method="post" accept-charset="utf-8">
				<div style="display:none;">
					<input type="hidden" name="_method" value="POST">
					<input type="hidden" name="action" value="searchVideos">
				</div>
				<div style="width:150px;float:left;padding-top:2px;margin:0px;">
					<div class="input text">
						<input name="data[Video][search]" data-offset="2" style="font-size:13px;" value="<?php echo $search; ?>" default-value="Search Videos" class="inputSearch" autocomplete="off" type="text" id="VideoSearch">

					</div>
				</div>
				<div class="searchButtonWrapper">
					<div class="searchButton" id="button-search-Partneruser"></div>
				</div>
			</form>
		</div>
		<script>
			//searchObj sent to configure Search
			<?php
			if ($mode != '') {
			?>
				var bridSearchSetting = {
					className: '.inputSearch',
					model: 'Video',
					objInto: '<?php echo $insertIntoContent; ?>',
					playlistType: playlistType,
					mode: '<?php echo $mode; ?>',
					subaction: '<?php echo $subaction; ?>'
				};

				$Brid.init([
					['Html.Search', bridSearchSetting]
				]);
			<?php
			} else {
			?>
				$Brid.init([
					['Html.Search', {
						className: '.inputSearch',
						model: 'Video',
						objInto: '<?php echo $insertIntoContent; ?>',
						buttons: buttonsOff
					}]
				]);
			<?php
			}
			?>
		</script>
	</div>

</div>

<?php
if (!empty($videosDataset['data'])) { ?>

	<table class="list-table">
		<?php
		$paginationOrder = '';
		$direction = '';
		$field = '';
		$pagination = $videosDataset['paging']['Video'];

		if (isset($pagination['options']['order'])) {
			foreach ($pagination['options']['order'] as $k => $v) {
				$paginationOrder = 'sort:' . $k . '/direction:' . $v . '/';
				$direction = $v;
				$field = $k;
			}
		}
		$paginationFields = array(
			'Title' => array('class' => 'tableTitle', 'field' => 'Video.name'),
			'Published' => array('class' => 'tableCreated', 'field' => 'Video.publish'),
			'Syndication' => array('class' => 'tableCreated', 'field' => false),
		);

		?>
		<tbody>
			<tr class="trFirst">
				<th class="thName">
					<?php foreach ($paginationFields as $k => $v) {
						$order = 'asc';
						$css = '';
						if ($v['field'] == $field) {
							$order = $css = $direction;
						}
					?>
						<div class="<?php echo $v['class']; ?>">
							<div>
								<?php if ($v['field'] != false) : ?>
									<a href="#" class="pagination-link <?php echo $css; ?>" data-page="1" data-order="sort:<?php echo $v['field']; ?>/direction:"><?php echo $k; ?></a>
								<?php else : ?>
									<span><?php echo $k; ?></span>
								<?php endif; ?>
							</div>
						</div>
					<?php

					} ?>

				</th>
			</tr>

			<?php
			foreach ($videosDataset['data'] as $k => $v) {
				// skip unpublished videos in playlists
				if ($mode == 'playlist' && $v['Video']['publish'] > date('Y-m-d')) continue;
				//One row

				// Because these fields can be omitted from response, and that means that value is zero
				$v['Video']['status'] = isset($v['Video']['status']) ? $v['Video']['status'] : 0;
				$v['Video']['monetize'] = isset($v['Video']['monetize']) ? $v['Video']['monetize'] : 0;
			?>
				<tr id="video-row-<?php echo $v['Video']['id']; ?>" data-id="<?php echo $v['Video']['id']; ?>" class="partnerTr">
					<td style="vertical-align: top;">
						<div class="tableRowContent" id="tableRowContent<?php echo $v['Video']['id']; ?>" style="position:relative">
							<div class="tableRow" id="tableRow<?php echo $v['Video']['id']; ?>">
								<div class="videoContent" id="videoContnet<?php echo $v['Video']['id']; ?>">
									<?php if (in_array($v['Video']['status'], array(3, 4, 5, 6, 8))) {
										$processText = 'Encoding';
										if ($v['Video']['status'] == 4) {
											$processText = 'Uploading';
										}
									?>
										<div class="encodingProgressWrapper" title="Video id: <?php echo $v['Video']['id']; ?>" data-status="<?php echo $v['Video']['status']; ?>" id="encoding-<?php echo $v['Video']['id']; ?>">

											<div class="encodingProgress">

												<div class="encodingStatusBar">
													<div class="encodingStatusMsg" id="encoding-status-<?php echo $v['Video']['id']; ?>"></div>
												</div>
											</div>
											<div class="encodingProgressBar">
												<div class="encodingProgressBarMove" id="encoding-bar-<?php echo $v['Video']['id']; ?>" style="width: 666px;text-aling:center;background-color:none"><?php echo ($v['Video']['status'] == 5) ? 'Error, retry please.' : $processText . ' in progress. Refresh video list to see status.'; ?></div>
											</div>

										</div>
									<?php } ?>
									<?php
									$checkboxZindex = in_array($v['Video']['status'], array(5)) ? 'z-index:999;' : '';
									?>
									<div class="checkboxRow" style="<?php echo $checkboxZindex; ?>">
										<div id="checkbox-video-id-<?php echo $v['Video']['id']; ?>" class="bridCheckbox clearfix" data-method="toggleTopMenu" data-name="video">
											<div class="checkboxContent">
												<img src="<?php echo BRID_PLUGIN_URL ?>img/checked.png" class="checked" style="display:none" alt="">
												<input type="hidden" name="data[Video][id]" class="singleCheckbox" id="video-id-<?php echo $v['Video']['id']; ?>" data-value="<?php echo $v['Video']['id']; ?>" style="display:none;">
											</div>
										</div>
									</div>
									<div class="centerImg showHidden click" data-id="<?php echo $v['Video']['id']; ?>" data-callback="initPlayer" data-callback-args='{"id":"<?= BridOptions::getOption('player') ?>","video":"<?php echo $v['Video']['id']; ?>","width":"740","height":"360"}' data-open="playerDiv" data-callback-before="changeOverText">
										<div class="centerImgWrapper">
											<?php
											$poster = 'indicator.gif';

											$get_imge = function () use ($v) {
												if (!empty($v['Video']['thumbnail'])) return $v['Video']['thumbnail'];
												if (!empty($v['Video']['image'])) return $v['Video']['image'];

												return BRID_PLUGIN_URL . 'img/' . 'thumb_404.png';
											};

											$video_image = $get_imge();
											if (strpos($video_image, 'thumb_q_dummy') !== false) {
												$poster = $video_image;
											}

											?>
											<img src="<?php echo $video_image; ?>" id="video-img-<?php echo $v['Video']['id']; ?>" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;" data-original="<?php echo $video_image; ?>" class="thumb" width="111px" height="74px" alt="" style="display: inline;">
											<?php $video_image = null; ?>
											<div class="videoPreviewBg" style="display: none;"></div>
											<div class="videoPlay" style="display: none;">
												<img src="<?php echo BRID_PLUGIN_URL; ?>img/small_play.png" style="position:relative; margin-bottom: 3px; width: 24px; height: 24px" alt="">
											</div>
											<?php if (!empty($v['Video']['external_url'])) { ?>
												<img src="<?php echo BRID_PLUGIN_URL; ?>img/youtube.png" class="youtube_ico" width="22px" height="22px" alt="">
											<?php } ?>
										</div>
										<div class="time" id="video-duration-<?php echo $v['Video']['id']; ?>"><?php echo self::format_time(isset($v['Video']['duration']) ? $v['Video']['duration'] : 0); ?></div>
									</div>
									<?php
									$itemCss = '';
									$linkCss = '';
									$monetizeCss = '';
									if ($v['Video']['status'] == 0) {
										$itemCss = 'turnedoff';
										$linkCss = 'videoTitleDisabled';
									}
									if ($v['Video']['monetize'] == 0) {
										$monetizeCss = 'turnedoff';
									}
									if (isset($v['Video']['geo_on']) && $v['Video']['geo_on'] == true) {
										$appendGeoStat = ' on';
									}

									$appendMonetStat = ($v['Video']['monetize'] == 0) ? ' off' : '';
									$appendSyndicationStat = ($v['Video']['partner_id'] != BridOptions::getOption('site')) ? ' on' : '';
									?>

									<div class="titleRow">
										<a href="<?php echo $v['Video']['id']; ?>" class="listTitleLink <?php echo $linkCss; ?>" id="video-title-<?php echo $v['Video']['id']; ?>" title="<?php echo $v['Video']['name']; ?>">
											<!-- Geo -->
											<?php if (isset($v['Video']['geo_on']) && $v['Video']['geo_on'] == true) : ?>
												<div class="geoStatus<?php echo $appendGeoStat; ?>" title="<?php echo implode(", ", $v['Video']['geo']); ?>"></div>
											<?php endif; ?>
											<!-- Monetization -->
											<div class="monetStatus<?php echo $appendMonetStat; ?>"></div>
											<!-- Syndication -->
											<div class="syndicationStatus<?php echo $appendSyndicationStat; ?>"></div>
											<!-- Title -->
											<?php echo $v['Video']['name']; ?>
										</a>

										<div class="videoUploadedBy">
											<?php if (isset($v['Video']['credits'])) : ?>
												<small class="credits">
													<b>Credits / Source: </b>&nbsp;
													<?php echo $v['Video']['credits']; ?>
												</small>
											<?php endif; ?>

											<?php if ($mode != 'playlist') { ?>
												<div class="partner-quick-menu-section">
													<ul class="partner-quick-menu visible" id="partner-options-<?php echo $v['Video']['id']; ?>">

														<li class="item <?php echo $itemCss; ?>" title="Publish/Unpublish">
															<div class="partner-qm-item video-status" data-controller="videos" data-field="status" data-info="Video status published/paused or pending" data-ajax-loaded="true" data-value="<?php echo $v['Video']['status']; ?>" data-id="<?php echo $v['Video']['id']; ?>" data-callback-after="disableVideoTitle"></div>
														</li>
														<li class="item <?php echo $monetizeCss; ?>" title="Monetize on/off">
															<div class="partner-qm-item video-monetize video-monetize-external" data-controller="videos" data-field="monetize" id="videos-monetize" data-info="Monetize on/off" data-video-type="<?php echo isset($v['Video']['external_type']) ? $v['Video']['external_type'] : ''; ?>" data-value="<?php echo $v['Video']['monetize']; ?>" data-id="<?php echo $v['Video']['id']; ?>" data-ajax-loaded="true"></div>
														</li>

														<li class="item" title="Quick edit">
															<div class="partner-qm-item video-quickedit showHidden" data-info="Quick Edit video" data-ajax-loaded="true" data-open="editVideoDiv" data-callback-before="changeOverText" data-id="<?php echo $v['Video']['id']; ?>"></div>
														</li>

													</ul>
												</div>
											<?php } ?>
										</div>
									</div>

									<div class="dateRow" title="Published on:<?php echo $v['Video']['publish']; ?>"><?php echo self::timeFormat($v['Video']['publish']); ?></div>

									<div class="dateRow" title="<?php echo $v['ExchangeRule']['name']; ?>"><?php echo $v['ExchangeRule']['name']; ?></div>
								</div>
							</div>

							<div class="hiddenContnet" data-id="<?php echo $v['Video']['id']; ?>">
								<div class="playerDiv" id="playerDiv<?php echo $v['Video']['id']; ?>">
									<div class="loadingPreviewPlayer">Loading player</div>
									<div class="playerContent brid" id="bridPlayerVideo<?php echo $v['Video']['id']; ?>"></div>
								</div>
								<?php if ($mode != 'playlist') { ?>
									<div class="editVideoDiv">
										<div id="quickeditvideoform" class="videos formQuick" style="width:100%;float:left;position:relative;">

											<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoEditQuick<?php echo $v['Video']['id']; ?>" method="post" data-redirect="/videos/index" accept-charset="utf-8">
												<div style="display:none;">
													<input type="hidden" name="_method" value="POST">
												</div>
												<input type="hidden" name="id" value="<?php echo $v['Video']['id']; ?>">
												<input type="hidden" name="insert_via" value="<?php echo isset($v['Video']['insert_via']) ? $v['Video']['insert_via'] : ''; ?>">
												<input type="hidden" name="partner_id" value="<?php echo isset($v['Video']['partner_id']) ? $v['Video']['partner_id'] : ''; ?>">
												<input type="hidden" name="action" value="editVideo" class="VideoEdit">

												<table class="quickVideoSaveTable">
													<tbody>
														<tr style="background:none;">
															<td colspan="2">
																<div class="input text required">
																	<input name="name" value="<?php echo $v['Video']['name']; ?>" placeholder="Video title" maxlength="250" type="text" required="required">
																</div>
															</td>
														</tr>
														<tr style="background:none;">
															<td colspan="2">

																<div class="input textarea">
																	<textarea name="description" style="height:82px;" placeholder="Video description" cols="30" rows="6"><?php echo isset($v['Video']['description']) ? $v['Video']['description']  : ''; ?></textarea>
																</div>
															</td>
														</tr>
														<tr style="background:none;">
															<td colspan="2">
																<table>
																	<tbody>
																		<tr style="background:none">
																			<td style="width:250px">
																				<div class="input text">
																					<input name="publish" readonly="readonly" id="VideoPublish<?php echo $v['Video']['id']; ?>" value="<?php echo date('d-m-Y', strtotime($v['Video']['publish'])); ?>" default-value="<?php echo $v['Video']['publish']; ?>" class="datepicker inputField" data-info="Publish on a date." type="text" style="margin-left:-10px">
																				</div>
																			</td>
																			<td style="padding-left:25px;padding-top:0px">
																				<div class="bridButton saveButton save-video" data-form-id="VideoEditQuick<?php echo $v['Video']['id']; ?>" id="videoSaveAdd" data-method="reloadPage" style="display: inline-block;">
																					<div class="buttonLargeContent"><?php _e('SAVE'); ?></div>
																				</div>

																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
											</form>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</td>
				</tr>
			<?php
			} //foreach
			?>
		</tbody>
	</table>
	<div class="pagination">
		<div class="mainWrapper mwPagination">

			<div class="paging">
				<?php if ($pagination['pageCount'] > 1) { ?>
					<span class="first"><a href="#" class="pagination-link" data-page="1" rel="first"> </a></span>
					<span class="prev"><a href="#" class="pagination-link" data-page="<?php echo $pagination['page'] - 1; ?>" rel="prev"> </a></span>
					<?php
					if ($pagination['page'] < 5) {
						$pageFrom = 1;
					} else {
						$pageFrom = $pagination['page'] - 4;
					}
					if (($pagination['page'] + 4) > $pagination['pageCount']) {
						$pageTo = $pagination['pageCount'];
					} else {
						$pageTo = $pagination['page'] + 4;
					}
					for ($i = $pageFrom; $i <= $pageTo; $i++) {

						if ($i == $pagination['page']) {
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
					<span class="next"><a href="#" class="pagination-link" data-page="<?php echo $pagination['page'] + 1; ?>" rel="next"> </a></span>
					<span class="last"><a href="#" class="pagination-link" data-page="<?php echo $pagination['pageCount']; ?>" rel="last"> </a></span>
				<?php } ?>
				<div class="pagingInfo"><?php _e('Page'); ?> <?php echo $pagination['page']; ?> <?php _e('of'); ?> <?php echo $pagination['pageCount']; ?>, <?php _e('showing'); ?> <?php echo $pagination['current']; ?> <?php _e('out of'); ?> <?php echo $pagination['count']; ?> <?php _e('total'); ?></div>

			</div>
		</div>
	</div>
	<script>
		var paginationOrder = '<?php echo $paginationOrder; ?>';
		var save = saveObj.init();

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
					action: "videos",
					subaction: '<?php echo isset($subaction) ? $subaction : ''; ?>',
					mode: mode,
					apiQueryParams: paginationOrder + 'page:' + page,
					search: '<?= $search ?>',
					buttons: buttonsOff
				},
				callback: {
					after: {
						name: "insertContent",
						obj: jQuery("<?php echo $insertIntoContent; ?>")
					}
				}
			};

			if (mode == 'playlist') {
				pagination.data.playlistType = playlistType;
			}
			$Brid.Api.call(pagination);
			return false;
		});

		jQuery('.close-quick-video-edit').click(function() {
			var id = jQuery(this).parent().parent().attr('id').replace('quickEditContent-', '');

			jQuery('#quickEditContent-' + id).fadeOut();
			jQuery('#partner-options-' + id).removeClass('noHover'); //Ad this to ignore hover effect of quick menu
		});

		//Disable quick icons for Post video screen if buttons are off
		if (buttonsOff) {
			jQuery('.partner-quick-menu-section').hide();
		}

		// Init animation to show quick edit form or to open preview player
		jQuery('.showHidden').off('click', $Brid.Html.Effect.initAnimation).on('click', $Brid.Html.Effect.initAnimation);

		jQuery('.video-monetize').on('click', function(e) {

			var d = jQuery(this);
			var id = d.attr('data-id');
			var monetize = parseInt(d.attr('data-value'));
			monetize = monetize ? 0 : 1;
			var video_type = d.attr('data-video-type');

			jQuery.ajax({
				url: '<?php echo admin_url("admin-ajax.php?action=monetizeVideo"); ?>',
				data: {
					id: id,
					monetize: monetize,
					video_type: video_type
				},
				beforeSend: function() {
					jQuery("#bridSpiner").show();
				},
				complete: function() {
					jQuery("#bridSpiner").hide();
				},
				type: 'POST',
			}).done(function(data) {
				if (data.success) {
					d.closest(".titleRow").find(".monetStatus").toggleClass("off");
					d.closest(".item").toggleClass("turnedoff");
					// window.location = window.location
					console.log("monetize uradilo - " + monetize);
				}

			});

		});
		// Init date picker for quick edit form

		//Init delete button
		$Brid.Html.Button.initDelete({
			buttonId: 'delete-partner',
			model: 'Video'
		});

		// Init image hover effect
		$Brid.Html.Effect.initImageHover();

		// End control of checkbox dropdown
		jQuery('#checkbox-video-check-all img.checked').hide();

		//Set status
		jQuery('.video-status').off('click').on('click', function(e) {

			var $self = jQuery(this);

			var currentVal = $self.attr('data-value') == 1 ? 0 : 1;
			var controller = $self.attr('data-controller');
			var id = $self.attr('data-id');

			$self.attr('data-value', currentVal);

			if ($self.parent().hasClass('turnedoff')) {
				$self.parent().removeClass('turnedoff');
			} else {
				$self.parent().addClass('turnedoff');
			}

			$Brid.Api.call({
				data: {
					action: "changeStatus",
					id: id,
					controller: controller,
					status: currentVal
				},
				callback: {
					after: {
						name: "disableVideoTitle",
						obj: $self
					}
				}
			});
		});

		//Edit video //.off('click')
		jQuery('.listTitleLink').on('click', function(e) {

			e.preventDefault();

			if (mode != 'playlist') {
				var id = jQuery(this).attr('href');

				$Brid.Api.call({
					data: {
						action: "editVideo",
						id: id
					},
					callback: {
						after: {
							name: "insertContent",
							obj: jQuery("#Videos-content")
						}
					}
				});
			}
		});

		//Post video

		jQuery('#postVideo').click(function() {

			debug.log('Send short code to textares via id: postVideo');

			var selectedItems = $Brid.Html.CheckboxElement.getSelectedCheckboxes('video-id-');

			debug.log('postVideo', selectedItems, selectedItems.length);

			if (selectedItems.length > 0) {
				v = jQuery('.wp-editor-area').val();
				var shortCodes = '';
				for (id in selectedItems) {
					shortCodes += '[brid video="' + selectedItems[id] + '" player="' + $BridWordpressConfig.Player.id + '" width="' + $BridWordpressConfig.Player.width + '" height="' + $BridWordpressConfig.Player.height + '"]';
				}
				alert("videos file");
				$Brid.Util.addToPost(shortCodes);
			}
		});


		//Init add to playlist button
		function addPlaylist() {

			var selectedItems = $Brid.Html.CheckboxElement.getSelectedCheckboxes('video-id-');

			debug.log('Selected Items are:', selectedItems);
			//Add Playlist and playlist videos at the same time (add mode)
			jQuery('#addPlaylistVideos').hide();
			jQuery('#addPlaylistForm').fadeIn();

			jQuery('#VideoIds').val(selectedItems);
			//If user close Colorbox on "Add Playlist" screen, and he already has selected videos
			//On second Add playlist button click, and he tries to check other checkboxes he would not see Add to playlist button
			//AZ story #208
			var c = $Brid.Html.CheckboxElement.create({
				name: 'video'
			});
			c.deselectAll();
			c.toggleTopMenu();
		}

		function editPlaylist() {
			debug.log('ediPlaylist call');

			var selectedItems = $Brid.Html.CheckboxElement.getSelectedCheckboxes('video-id-');

			$Brid.Api.call({
				data: {
					action: "addVideoPlaylist",
					id: playlistId,
					ids: selectedItems.join(',')
				},
				callback: {
					after: {
						name: "itemsAddedToPlaylist",
						obj: jQuery("#video-list")
					}
				}
			});
		}

		jQuery("#add-to-playlist-").off('click', addPlaylist).on('click', addPlaylist);
		jQuery("#add-to-playlist-addPlaylist").off('click', addPlaylist).on('click', addPlaylist);
		jQuery("#add-to-playlist-addPlaylistyt").off('click', addPlaylist).on('click', addPlaylist);
		jQuery("#add-to-playlist-editPlaylist").off('click', editPlaylist).on('click', editPlaylist);
	</script>
	<?php
} else {
	if ($search == '') {
		$link = '<a href="/videos/add" id="add_new_video">add a video</a>';
	?>
		<div class="noItems">
			You haven't added any videos yet. Please <?php echo $link; ?>.
			<script>
				jQuery('.list-items-menu').hide();
				jQuery('#add_new_video, #add_new_video_2').on('click', function(e) {
					e.preventDefault();
					$Brid.Api.call({
						data: {
							action: "addVideo"
						},
						callback: {
							after: {
								name: "insertContent",
								obj: jQuery("#Videos-content")
							}
						}
					});
					jQuery.colorbox.close();
				});
			</script>
		</div>

	<?php } else {

	?>

		<div class="noItems">
			Your search hasn't returned any results.
		</div>

<?php
	}
}
?>
<script>
	//Onclick Tabs
	//Bind add video and add youtube buttons
	jQuery('#addVideo, #addYoutube, #uploadVideo').off('click').on('click', function() {
		jQuery("#Videos-content").hide();
		var id = jQuery(this).attr('id');
		$Brid.Api.call({
			data: {
				action: id
			},
			callback: {
				after: {
					name: "insertContent",
					obj: jQuery("#Videos-content")
				}
			}
		});

	});
</script>