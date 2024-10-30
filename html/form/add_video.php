<div class="mainWrapper mainWrap" style='padding-top:10px;'>
	<div class="videos form mainWrap">
		<form class="brid-video-form" action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" data-redirect="/videos/index" accept-charset="utf-8">
			<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
			<table class="form-table" style="display:block">
				<tbody>
					<tr>
						<td>
							<div class="formWrapper videoAddFormWrapper" style="margin-top:0px">

								<div id="mainAdd">
									<input type="hidden" name="action" value="addVideo">
									<input type="hidden" name="insert_via" value="2">
									<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
									<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
									<input type="hidden" name="id" id="VideoId">
									<input type="hidden" name="upload_form" value="0" id="VideoUploadForm">

									<input type="hidden" name="default_tab" value="" id="VideoDefaultTab">
									<input type="hidden" name="external_id" id="VideoExternalId">
									<input type="hidden" name="encoding_setup_finished" id="VideoEncodingSetupFinished">
									<input type="hidden" name="width" id="VideoWidth">
									<input type="hidden" name="height" id="VideoHeight">
									<input type="hidden" name="size" id="VideoSize">
									<input type="hidden" name="video_codec" id="VideoVideoCodec">
									<input type="hidden" name="video_bitrate" id="VideoVideoBitrate">
									<input type="hidden" name="external_service" id="VideoExternalService">
									<input type="hidden" name="external_type" id="VideoExternalType">
									<input type="hidden" name="IsFamilyFriendly" id="VideoIsFamilyFriendly">
									<input type="hidden" name="duration" id="VideoDuration">
									<input type="hidden" name="autosave" id="VideoAutosave" value="0">
									<input type="hidden" name="tagsAlert" id="tagsAlert" class="tagsAlert" value="<?php echo $tagsAlert ?>">
									<input type="hidden" name="external_url" default-value="External URL" data-info="External URL" id="VideoExternalUrl"> <!-- Youtube/Vimeo Form -->

									<!-- MAIN FORM -->

									<div class="mainDataAdd" id="mainData" style="">
										<table style="border-spacing: 0px;">
											<tbody>
												<tr>
													<td style="width:576px; padding-top: 10px;">
														<div class="input text required">
															<label for="VideoName"><?php _e('Video title'); ?></label>
															<input name="name" default-value="Video title" data-info="Video title" tabindex="1" maxlength="250" type="text" id="VideoName" required="required">
														</div>
													</td>
													<td style="padding:0px; padding-top: 10px; vertical-align:top; padding-left: 10px;">
														<div class="fixDate" style="float:left; position:relative; width:249px;">
															<div class="input text">
																<label for="VideoName"><?php _e('Publish on a date'); ?></label>
																<input name="publish" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" default-value="<?php echo date('d-m-Y'); ?>" class="datepicker inputField" data-info="Publish on a date." type="text" id="VideoPublish">
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td colspan="2">
														<div class="input textarea">
															<label for="VideoName"><?php _e('Video description'); ?></label>
															<textarea name="description" default-value="Video description" style="height:100px;" data-info="Video description" tabindex="2" cols="30" rows="6" id="VideoDescription" data-ajax-loaded="true"></textarea>
														</div>
													</td>
												</tr>

												<input type="hidden" name="channel_id" value="18">

												<tr>
													<td colspan="2">
														<div class="input select" tabindex="3" style="width:200px">
															<label for="VideoName"><?php _e('IAB Content Taxonomy'); ?></label>
															<select class="chzn-select" multiple="multiple" name="tags_taxonomies[]" id="TagsTaxonomyId">
																<?php foreach ($tagsTaxonomies as $value => $text) : ?>
																	<option value="<?php echo $value ?>"><?php echo $text ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</td>
												</tr>
												<tr>
													<td colspan="2">
														<div class="input select" tabindex="3" style="width:200px">
															<label for="VideoName"><?php _e('Syndication Rule'); ?></label>
															<select name="exchange_rule_id" id="VideoExchangeRuleId">
																<?php
																foreach ($exchangeRules as $k => $v) :
																	$selected = '';
																	if ($v['ExchangeRule']['id'] == $default_exchange_rule) {
																		$selected = 'selected="selected"';
																	}
																?> <option value="<?php echo $v['ExchangeRule']['id']; ?>" <?php echo $selected; ?>><?php echo $v['ExchangeRule']['name']; ?></option>
																<?php endforeach; ?>
															</select>
														</div>
													</td>
												</tr>
												<tr>
													<td colspan="2">
														<div class="input select required" tabindex="3" style="max-width:150px">
															<label><?php _e('Age restriction'); ?></label>
															<select name="age_gate_id">
																<option value="1"><?php _e('Everyone'); ?></option>
																<option value="2">17+ (<?php _e('ESRB - Mature rated'); ?>)</option>
																<option value="3">18+ (<?php _e('ESRB - Adults only'); ?>)</option>
															</select>

														</div>
													</td>

												</tr>
												<tr>
													<td colspan="2">
														<div class="input text">
															<label for="VideoName"><?php _e('Tags'); ?></label>
															<input name="tags" default-value="Tags" tabindex="4" type="text" id="VideoTags">
														</div>
													</td>
												</tr>

												<tr>
													<td colspan="2">
														<table>
															<tr>
																<td>
																	<input type="hidden" name="thumbnail" id="VideoThumbnail">
																	<div class="input text">
																		<label for="VideoName"><?php _e('Snapshot Url'); ?></label>
																		<input name="image" default-value="Snapshot URL" data-info="Provide URL to the snapshot image" tabindex="5" maxlength="300" type="text" id="VideoImage" value="<?php echo BridOptions::getOption('video_image'); ?>">
																	</div>
																</td>
																<td style="width:120px">
																	<div class="bridBrowseLibary fixBrowseLibary" data-field="VideoImage" data-uploader_button_text="Add Snapshot" data-uploader_title="Browse from Media Library"><?php _e('BROWSE LIBRARY'); ?></div>
																</td>
															</tr>
														</table>


													</td>
												</tr>

												<tr>
													<td colspan="2">
														<table>
															<tr>
																<td>
																	<div class="input text required">
																		<label for="VideoName"><?php _e('Video file (MP4 Standard Definiton 360p)'); ?></label>
																		<input name="mp4" default-value="Enter .mp4 video file URL, or one of the supported streaming files (.m3u8, .mpd)" data-info="Enter .mp4 video file URL, or one of the supported streaming files (.m3u8, .mpd)" tabindex="6" maxlength="300" type="text" id="VideoMp4" required="required" data-ajax-loaded="true">
																	</div>
																</td>
																<td style="width:120px">
																	<div class="bridBrowseLibary fixBrowseLibary" data-field="VideoMp4" data-uploader_button_text="Add Video" uploader_title="Browse from Media Library"><?php _e('BROWSE LIBRARY'); ?></div>
																</td>
															</tr>
														</table>
													</td>
												</tr>

												<tr>
													<td colspan="2">
														<table>
															<tr>
																<td>
																	<div class="input text required">
																		<label for="VideoName"><?php _e('MP4 Low Definition - 240p'); ?></label>
																		<input name="mp4_ld" default-value="MP4 LD URL" data-info="MP4 Low Definition URL Source" tabindex="6" maxlength="300" type="text" id="VideoMp4Ld" data-ajax-loaded="true">
																	</div>
																</td>
																<td style="width:120px">
																	<div class="bridBrowseLibary fixBrowseLibary" data-field="VideoMp4Ld" data-uploader_button_text="Add Video" uploader_title="Browse from Media Library"><?php _e('BROWSE LIBRARY'); ?></div>
																</td>
															</tr>
														</table>
													</td>
												</tr>

												<tr>
													<td colspan="2">
														<table>
															<tr>
																<td>
																	<div class="input text required">
																		<label for="VideoName"><?php _e('MP4 High Standard Definition - 480p'); ?></label>
																		<input name="mp4_hsd" default-value="MP4 HSD URL" data-info="MP4 High Standard Definition URL Source" tabindex="6" maxlength="300" type="text" id="VideoMp4Hsd" data-ajax-loaded="true">
																	</div>
																</td>
																<td style="width:120px">
																	<div class="bridBrowseLibary fixBrowseLibary" data-field="VideoMp4Hsd" data-uploader_button_text="Add Video" uploader_title="Browse from Media Library"><?php _e('BROWSE LIBRARY'); ?></div>
																</td>
															</tr>
														</table>
													</td>
												</tr>

												<tr>
													<td colspan="2">
														<table>
															<tr>
																<td>
																	<div class="input text required">
																		<label for="VideoName"><?php _e('MP4 High Definition - 720p'); ?></label>
																		<input name="mp4_hd" default-value="MP4 HD URL" data-info="MP4 High Definition URL Source" tabindex="6" maxlength="300" type="text" id="VideoMp4Hd" data-ajax-loaded="true">
																	</div>
																</td>
																<td style="width:120px">
																	<div class="bridBrowseLibary fixBrowseLibary" data-field="VideoMp4Hd" data-uploader_button_text="Add Video" uploader_title="Browse from Media Library"><?php _e('BROWSE LIBRARY'); ?></div>
																</td>
															</tr>
														</table>
													</td>
												</tr>

												<tr>
													<td colspan="2">
														<table>
															<tr>
																<td>
																	<div class="input text required">
																		<label for="VideoName"><?php _e('MP4 Full High Definition - 1080pp'); ?></label>
																		<input name="mp4_fhd" default-value="MP4 FHD URL" data-info="MP4 Full High Definition URL Source" tabindex="6" maxlength="300" type="text" id="VideoMp4Fhd" data-ajax-loaded="true">
																	</div>
																</td>
																<td style="width:120px">
																	<div class="bridBrowseLibary fixBrowseLibary" data-field="VideoMp4Fhd" data-uploader_button_text="Add Video" uploader_title="Browse from Media Library"><?php _e('BROWSE LIBRARY'); ?></div>
																</td>
															</tr>
														</table>
													</td>
												</tr>

											</tbody>
										</table>

										<div class="mainButtonsMenu" style="padding-left: 0px;">
											<div class="bridButton saveButton disabled" id="videoSaveAdd" data-method="onVideoSave" data-form-bind="0" data-form-req="0">
												<div class="buttonLargeContent"><?php _e('SAVE'); ?></div>
											</div>
											<div id="autoSaving"><?php _e('Autosaving'); ?><span class="fDot">.</span><span class="sDot">.</span><span class="tDot">.</span></div>
											<div class="bridButton add-video" data-href="#" id="addVideo">
												<div class="buttonLargeContent"><?php _e('ADD ANOTHER VIDEO'); ?></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</form>

	</div>

</div>
<script>
	var allowedImageExtensions = ["jpg", "jpeg", "png", "gif"];
	var amIEncoded = 0; //force 0
	var typingTimer; //timer identifier
	var doneTypingInterval = 600; //time in ms, 5 second for example
	var defaultTab = 'video';
	var currentView = 'add-video'; //This simulates tab switch for buttons, and currently selected service (youtube, vimeo)

	var clickedAddButton; //Stores ADD button object we clicked

	//Init save object
	var save = saveObj.init();

	/**
	 * Save button on click
	 */
	jQuery("#videoSaveAdd").click(function(e) {
		if (!jQuery(this).hasClass('disabled') && !jQuery("#videoSaveAdd").hasClass('inprogress')) {

			jQuery("#videoSaveAdd").addClass('inprogress');
			save.save('VideoAddForm');
		} else {
			//Is save in progress?
			if (jQuery("#videoSaveAdd").hasClass('inprogress')) {
				$Brid.Util.openDialog('Save error', 'Save already in progress');

			}
			//CheckFields (true) will display openDialog message
			if (checkFields(true)) {

				save.openRequiredDialog('VideoAddForm', '<b>Please check following:</b><br/><br/> 1.) Are required fields empty?<br/> 2.) Are fields values in valid format?', 'Save is disabled');
				console.error('[Error from custom video save function] Save is disabled. Check mandatory fileds.');
				jQuery('.saveButton').addClass('disabled');
			}
		}

	});
	//Call Enable save button function on change
	jQuery('#VideoName, #VideoImage').input(function() {
		checkFields();
		enableSave();
	});

	//Grab additional info and check codec of the provided Mp4 Url (on success call enableSave();)
	jQuery("#VideoMp4").input(function() {
		checkFields();
		getFfmpegInfo();
		enableSave();
	});

	jQuery('#fetchUrl').keyup(function(e) {
		if (e.which == 13) {
			$Brid.Fetch.fetchUrl();
		}
	});

	jQuery('.fetchDivWrapper .input').prepend('<span class="fetchDivHSpan">http://</span>');

	jQuery("#fetchUrl").bind('paste', function(event) {
		var _this = this;
		// Short pause to wait for paste to complete
		setTimeout(function() {
			var url = jQuery(_this).val();

			url = url.replace(/(https?:\/\/)/, '');
			jQuery(_this).val(url);
			if (url.match(/^(rtmp:\/\/)/)) {
				jQuery('.fetchDivHSpan').hide();
			}
		}, 100);
	});

	jQuery('#goFetchUrl').click(function() {
		$Brid.Fetch.fetchUrl();
	});
	jQuery('#fetchUrl').on('input', $Brid.Fetch.checkFetchUrl);

	var browse = jQuery('.bridBrowseLibary');

	if (browse.length > 0) {
		browse.on('click', function() {
			var fieldName = jQuery(this).attr("data-field");
			var field = jQuery('#' + fieldName);
			var title = jQuery('#VideoName');
			var desc = jQuery('#VideoDescription');
			var tags = jQuery('#VideoTags');

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: jQuery(this).data('uploader_title'),
				button: {
					text: jQuery(this).data('uploader_button_text'),
				},
				multiple: false // Set to true to allow multiple files to be selected
			});

			// When an image is selected, run a callback.
			file_frame.on('select', function() {
				// We set multiple to false so only get one image from the uploader
				attachment = file_frame.state().get('selection').first().toJSON();

				field.val(attachment.url);
				jQuery('#checkbox-mp4_hd_on').removeClass('disabledCheckbox');

				jQuery('#default-value-' + fieldName).hide();

				if (title.val() == '') {
					title.val(attachment.title);
					desc.val(attachment.title);
					jQuery('#default-value-VideoName').hide();
					jQuery('#default-value-VideoDescription').hide();
				}

				if (tags.val() == '') {
					var str = attachment.title;
					str = str.replace(/[^a-zA-Z-_, ]/g, "");
					str = str.replace(/[^a-zA-Z-_,]/g, ",") //replace space with comma
					str = str.replace(/[^a-zA-Z-,]/g, ",") //replace underscore with comma
					str = str.replace(/[^a-zA-Z,]/g, ",") //replace dash with comma
					tags.val(str);
					jQuery('#default-value-VideoTags').hide();

				}

				enableSave();
			});

			// Finally, open the modal
			file_frame.open();
		});


	}
	initBridMain();

	jQuery('#addVideo').off('click').on('click', function() {
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