<script>
	var buttonsOff = '<?php echo $buttonsOff; ?>';
</script>
<?php
if (!$buttonsOff) {
?>
	<div class="mainWrapper mainWrap">
		<div class="mainButtonsMenu">
			<div class="bridButton add-playlist various bridAjaxLightbox" data-action="addPlaylist" href="<?php echo admin_url('admin-ajax.php') . '?action=addPlaylist'; ?>" id="addPlaylist">
				<div class="buttonLargeContent"><?php _e('ADD PLAYLIST'); ?></div>
			</div>
		</div>
	</div>
	<script>
		jQuery('.bridAjaxLightbox').colorbox({
			innerWidth: "90%",
			innerHeight: "100%",
			maxWidth: 945,
			maxHeight: 808,
			onClosed: function() {
				jQuery('.toolbarItem').hide();
				$Brid.init([
					['Html.Search', {
						className: '.inputSearch',
						model: 'Playlist'
					}]
				]);
			}
		});
	</script>
<?php } else {
?>
	<div class="mainWrapper mainWrap">
		<div class="mainButtonsMenu" style="text-align:right;">
			<div class="bridButton post-playlist disabled" data-href="#" id="postPlaylist" style="margin-right:40px;">
				<div class="buttonLargeContent"><?php _e('POST'); ?></div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="list-items-menu">

	<ul class="items-menu">
		<!-- Select all checkbox -->
		<li class="last">
			<div style="float:left; margin-top: 1px; margin-left: 10px;">
				<div id="checkbox-playlist-check-all" class="bridCheckbox clearfix" data-method="toggleAll" data-name="playlist">
					<div class="checkboxContent">
						<img src="<?php echo BRID_PLUGIN_URL; ?>img/checked.png" class="checked" style="display:none" alt="">
						<input type="hidden" name="data[Playlist][playlist-check-all]" class="singleCheckbox" id="playlist-check-all" data-value="0" style="display:none;">
					</div>
				</div>
			</div>

			<div id="google_button" class="google_button outer_button_div" style="float: left;">
				<div id="inner_button_checkbox" class="inner_button_div">
					<img alt="Click to open submenu" src="<?php echo BRID_PLUGIN_URL; ?>img/arrow_down.png" style="vertical-align: top; position:absolute; top:8px; left:3px; width:8px; height:4px">
				</div>
			</div>
			<div id="g_menu" data-checkbox-id="checkbox-playlist-check-all" class="gdrop_down" style="display: none;">
				<div class="chkbox_action" style="cursor:pointer;" data-method="None"><?php _e('None'); ?></div>
				<div class="chkbox_action" style="cursor:pointer;" data-method="Published"><?php _e('Published'); ?></div>
				<div class="chkbox_action" style="cursor:pointer;" data-method="Paused"><?php _e('Paused'); ?></div>
				<div class="chkbox_action" style="cursor:pointer;" data-method="Pending"><?php _e('Pending'); ?></div>
			</div>
		</li>
		<!-- Are there any additional buttons? -->
		<!-- Every toolbar has a delete button (initDeleteButton) -->
		<?php
		if (!$buttonsOff) {
		?>
			<li class="toolbarItem">
				<div class="redButtonBg" style="margin-top: 0px;" id="delete-playlist">
					<div class="delButtonSmall"></div>
				</div>
			</li>
		<?php } ?>
	</ul>

	<div id="site-search-box">
		<div class="searchBox search-box" style="margin-top: 0px;">

			<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="PlaylistIndexForm" data-loadintodivclass="bp_list_items" method="post" accept-charset="utf-8">
				<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
				<div style="width:auto;float:left;padding:0px;margin:0px; padding-top:5px;">
				</div>
				<div style="width:150px;float:left;padding-top:2px;margin:0px;">
					<div class="input text">
						<input name="data[Playlist][search]" data-offset="2" value="<?php echo $search; ?>" style="font-size:13px;" default-value="Search Playlist" class="inputSearch" autocomplete="off" type="text" id="PlaylistSearch">
					</div>
				</div>

				<div class="searchButtonWrapper">
					<div class="searchButton" id="button-search-Playlist"></div>
				</div>
			</form>
		</div>

		<script>
			var searchObj = {
				className: '.inputSearch', //Class of the input field that is used for serach, required
				model: 'Playlist', //Model required
				buttons: buttonsOff
			};
			$Brid.init([
				['Html.Search', searchObj]
			]); //searchObj sent to configure Search
		</script>
	</div>

</div>

<?php

if (!empty($playlists->data)) {
?>
	<div class="bp_list_items" id="playlist-list">
		<div class="mainWrapper mainWrap" data-title="unified items.ctp">

			<table class="list-table">
				<?php
				$paginationOrder = '';
				$direction = '';
				$field = '';
				$pagination = array();
				if (!empty($playlists->paging->Playlist)) {
					$pagination = $playlists->paging->Playlist;
				}
				if (isset($pagination->options->order)) {
					foreach ($pagination->options->order as $k => $v) {
						$paginationOrder = 'sort:' . $k . '/direction:' . $v . '/';
						$direction = $v;
						$field = $k;
					}
				}
				$paginationFields = array(
					'Playlist' => array('class' => 'tableTitle', 'field' => 'Playlist.name'),
					'Published' => array('class' => 'tableCreated', 'field' => 'Playlist.publish')
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
										<a href="#" class="pagination-link <?php echo $css; ?>" data-page="1" data-order="sort:<?php echo $v['field']; ?>/direction:"><?php echo $k; ?></a>
									</div>
								</div>
							<?php

							} ?>
						</th>
					</tr>
					<?php foreach ($playlists->data as $k => $v) { ?>
						<tr id="video-row-<?php echo $v->Playlist->id; ?>" data-id="<?php echo $v->Playlist->id; ?>" class="partnerTr">
							<td style="vertical-align: top;">
								<div class="tableRowContent" id="tableRowContent<?php echo $v->Playlist->id; ?>" style="position:relative">
									<div class="tableRow" id="tableRow<?php echo $v->Playlist->id; ?>">
										<div class="videoContent" id="videoContnet<?php echo $v->Playlist->id; ?>">
											<div class="checkboxRow" style="">
												<div id="checkbox-playlist-id-<?php echo $v->Playlist->id; ?>" class="bridCheckbox clearfix" data-method="toggleTopMenu" data-name="playlist">
													<div class="checkboxContent"><img src="<?php echo BRID_PLUGIN_URL; ?>img/checked.png" class="checked" style="display:none" alt="">
														<input type="hidden" name="data[Playlist][id]" class="singleCheckbox" id="playlist-id-<?php echo $v->Playlist->id; ?>" data-value="<?php echo $v->Playlist->id; ?>" style="display:none;">
													</div>
												</div>
											</div>
											<div class="centerImg showHidden click" id="playlist-image-<?php echo $v->Playlist->id; ?>" data-id="<?php echo $v->Playlist->id; ?>" data-callback="initPlayer" data-callback-args="{&quot;id&quot;:&quot;<?= BridOptions::getOption('player') ?>&quot;,&quot;playlist&quot;:&quot;<?php echo $v->Playlist->id; ?>&quot;,&quot;width&quot;:&quot;740&quot;,&quot;height&quot;:&quot;360&quot;}" data-open="playerDiv" data-callback-before="changeOverText">
												<div class="centerImgWrapper">

													<?php
													$firstSnapshot = BRID_PLUGIN_URL . "img/thumb_404.png";

													if ($v->Playlist->is_smart == 1) {
														$firstSnapshot = BRID_PLUGIN_URL . "img/smart_pl.svg";
													} elseif (!empty($v->Video[0])) {
														if ($v->Video[0]->thumbnail != '') {
															$firstSnapshot = $v->Video[0]->thumbnail;
														}
													}

													?>
													<img src="<?php echo BRID_PLUGIN_URL; ?>img/indicator.gif" data-original="<?php echo $firstSnapshot; ?>" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;" class="lazy" width="111px" height="74px" id="partner-img-1080" alt="" style="display: inline;">
													<div class="videoPreviewBg"></div>
													<div class="videoPlay" style="left:<?php echo ($v->Playlist->is_smart == 1) ? '43' : '22' ?>px;">
														<img src="<?php echo BRID_PLUGIN_URL; ?>img/small_play.png" style="position:relative;width: 24px; height: 24px" alt="">
													</div>
												</div>
												<div id="playlist-play-all-<?php echo $v->Playlist->id; ?>" style="position: absolute; top: 0px;width: 67px;"></div>
												<?php if ($v->Playlist->is_smart != 1) : ?>
													<div class="playlist_preview">
														<div class="playlist_preview_wrapper"></div>
														<div class="playlist_count"><?php echo $v->Playlist->count; ?></div>
														<div class="playlist_count_text">videos</div>
														<div class="playlist_preview_images">
															<?php foreach ($v->Video as $key => $video) {
																if ($key > 1) break;
															?>
																<div class="preview_youtube_img_small">
																	<?php
																	$firstSnapshotSmall = BRID_PLUGIN_URL . "img/thumb_404.png";
																	if ($video->thumbnail != '') {

																		$firstSnapshotSmall = $video->thumbnail;
																	}
																	?>
																	<img src="<?php echo $firstSnapshotSmall ?>" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;" width="29px" height="15px" border="0">
																</div>
															<?php } ?>
														</div>
													</div>
												<?php endif; ?>
											</div>
											<?php
											$itemCss = '';
											$linkCss = '';
											if ($v->Playlist->status == 0) {
												$itemCss = 'turnedoff';
												$linkCss = 'videoTitleDisabled';
											}
											//turnedoff
											?>
											<div class="titleRow">
												<?php if ($v->Playlist->is_smart != 1) : ?>
													<a href="<?php echo $v->Playlist->id; ?>" class="listTitleLink  <?php echo $linkCss; ?>" id="video-title-<?php echo $v->Playlist->id; ?>"><?php echo $v->Playlist->name; ?></a>
												<?php else : ?>
													<span title="Smart playlists can be edited in CMS platform"><?php echo $v->Playlist->name; ?></span>
												<?php endif; ?>
												<div class="videoUploadedBy">
													<div class="partner-quick-menu-section">

														<ul class="partner-quick-menu visible" id="partner-options-<?php echo $v->Playlist->id; ?>">

															<li class="item <?php echo $itemCss; ?>" title="Publish/Unpublish">
																<div class="partner-qm-item video-status" data-controller="playlists" data-field="status" data-info="Playlist status published\paused" data-ajax-loaded="true" data-value="<?php echo $v->Playlist->status; ?>" data-id="<?php echo $v->Playlist->id; ?>" data-callback-after="disableVideoTitle"> </div>
															</li>

															<li class="item" title="Quick edit">
																<div class="partner-qm-item video-quickedit showHidden" data-info="Quick Edit playlist" data-ajax-loaded="true" data-open="editPlaylistDiv" data-callback-before="changeOverText" data-id="<?php echo $v->Playlist->id; ?>"></div>
															</li>

														</ul>
													</div>
												</div>
											</div>
											<div class="dateRow" title="Created on:<?php echo $v->Playlist->publish; ?>"><?php echo self::timeFormat($v->Playlist->publish); ?></div>
										</div>
									</div>
									<div class="hiddenContnet" data-id="<?php echo $v->Playlist->id; ?>">
										<div class="playerDiv" id="playerDiv<?php echo $v->Playlist->id; ?>">
											<div class="loadingPreviewPlayer"><?php _e('Loading player'); ?></div>
											<div class="playerContent brid" id="bridPlayerVideo<?php echo $v->Playlist->id; ?>"></div>
										</div>
										<div class="editPlaylistDiv">
											<div id="quickeditvideoform" class="videos formQuick" style="width:100%;float:left;position:relative; top:-11px;">

												<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="PlaylistEditQuick<?php echo $v->Playlist->id; ?>" method="post" accept-charset="utf-8">
													<div style="display:none;">
														<input type="hidden" name="id" value="<?php echo $v->Playlist->id; ?>" id="PlaylistId">
														<input type="hidden" name="insert_via" value="<?php echo $v->Playlist->insert_via; ?>" id="PlaylistInsertVia">
														<input type="hidden" name="partner_id" value="<?php echo $v->Video[0]->partner_id ?? $partner_id; ?>" id="PlaylistPartnerId">
														<input type="hidden" name="action" value="editPlaylist">
														<input type="hidden" name="_method" value="POST">
													</div>

													<table class="quickVideoSaveTable">
														<tbody>
															<tr style="background:none;">
																<td colspan="2">
																	<div class="input text required"><input name="name" value="<?php echo $v->Playlist->name; ?>" default-value="Playlist title" data-info="Playlist title" maxlength="250" type="text" id="PlaylistName" required="required"></div>
																</td>
															</tr>

															<tr style="background:none;">
																<td>
																	<table>
																		<tbody>
																			<tr style="background:none">
																				<td style="width:250px">
																					<div class="input text"><input name="publish" readonly="readonly" id="PlaylistPublish<?php echo $v->Playlist->id; ?>" value="<?php echo $v->Playlist->publish; ?>" default-value="<?php echo date('d-m-Y'); ?>" class="datepicker inputField" data-info="Publish on a date." type="text" style="margin-left:-10px"></div>
																				</td>
																				<td style="padding-left:25px;padding-top:0px;">
																					<div class="bridButton saveButton save-playlist" data-method="reloadPage" data-callback="insertContentPlaylists" data-form-id="PlaylistEditQuick<?php echo $v->Playlist->id; ?>" id="playlistSaveAdd">
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
									</div>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

		<!-- Pagination Start -->
		<div class="pagination">
			<div class="mainWrapper mwPagination">

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
					<div class="pagingInfo"><?php _e('Page'); ?> <?php echo $pagination->page; ?> of <?php echo $pagination->pageCount; ?>, showing <?php echo $pagination->current; ?> out of <?php echo $pagination->count; ?> <?php _e('total'); ?></div>

				</div>

			</div>
		</div>
		<script>
			//Used in global contentRefresh function @see default.ctp or default.js
			var page = 1;
			var quickSave = saveObj.init(); //Init all save buttons in quick edit forms
			var paginationOrder = '<?php echo $paginationOrder; ?>';

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
				$Brid.Api.call({
					data: {
						action: "playlists",
						apiQueryParams: paginationOrder + 'page:' + page,
						search: '<?= $search ?>',
						buttons: buttonsOff
					},
					callback: {
						after: {
							name: "insertContent",
							obj: jQuery("#Playlists-content")
						}
					}
				});
				return false;
			});

			//Edit playlist
			jQuery('.listTitleLink').off('click').on('click', function(e) {
				e.preventDefault();
				var id = jQuery(this).attr('href');

				$Brid.Api.call({
					data: {
						action: "editPlaylist",
						id: id
					},
					callback: {
						after: {
							name: "insertContent",
							obj: jQuery("#Playlists-content")
						}
					}
				});
			});

			//Disable quick icons for Post video screen if buttons are off
			if (buttonsOff) {
				jQuery('.partner-quick-menu-section').hide();
			}

			// Init animation to show quick edit form or to open preview player
			jQuery('.showHidden').off('click', $Brid.Html.Effect.initAnimation).on('click', $Brid.Html.Effect.initAnimation);

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

			//Post playlist
			jQuery('#postPlaylist').click(function() {

				var selectedItems = $Brid.Html.CheckboxElement.getSelectedCheckboxes('playlist-id-');

				debug.log('postPlaylist', selectedItems, selectedItems.length);

				if (selectedItems.length > 0) {
					v = jQuery('.wp-editor-area').val();
					var shortCodes = '';
					for (id in selectedItems) {
						shortCodes += '[brid playlist="' + selectedItems[id] + '" player="' + $BridWordpressConfig.Player.id + '" width="' + $BridWordpressConfig.Player.width + '" height="' + $BridWordpressConfig.Player.height + '" items="50"]';
					}
					$Brid.Util.addToPost(shortCodes);
				}

			});

			//Init delete button
			$Brid.Html.Button.initDelete({
				buttonId: 'delete-playlist',
				model: 'Playlist'
			});

			// Init image hover effect
			$Brid.Html.Effect.initImageHover();

			// Go to partner analytics web page
			jQuery('li:not(.disabled) .partner-analytics').off('click', $Brid.Util.clickUrl).on('click', $Brid.Util.clickUrl);

			// Check player width/height values
			jQuery('#PlayerWidth, #PlayerHeight').off('keypress', $Brid.Util.onlyNumbers).on('keypress', $Brid.Util.onlyNumbers);

			// End control of checkbox dropdown
			jQuery('#checkbox-video-check-all img.checked').hide();
		</script>
		<?php } else {

		if ($search == '') {
		?>
			<div class="noItems">
				You haven't added any playlists yet. Please

				<a class="various" data-action="addPlaylist" href="<?php echo admin_url('admin-ajax.php') . '?action=addPlaylist'; ?>" id="addFirstPlaylist">add a playlist</a>.

				<script>
					jQuery('#addFirstPlaylist').colorbox({
						innerWidth: 900,
						innerHeight: 780
					});
					jQuery('.list-items-menu').hide();
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
	</div> <!-- bp_list_items end -->
	<!-- Pagination End -->