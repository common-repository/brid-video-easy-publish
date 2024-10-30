<div class="mainWrapper mainWrap" style='padding-top:10px;'>

	<?php
	$hideUploadFields = 'block';

	if ($upload) {
		$hideUploadFields = 'none';
	?>
		<div class="formUploaderWrapper widthUpload" id="UploaderForm" style="position:relative;margin-top:20px">
			<div class="mainDataAdd widthUpload">
				<div id="uploadButtonDiv">
					<input type="button" id="userfileButton" class="uploadFile" autocomplete="off" />
				</div>
				<div id="uploadInputHide">
					<input name="userfile" id="userfile" type="file" />
				</div>
				<div id="progress"></div>
				<div id="uploadCloseBtn"></div>
				<div id="uploadMsg"></div>

				<script type="text/javascript">
					var uploadUrl = '<?php echo OAUTH_PROVIDER; ?>';
				</script>
			</div>

			<div id="fetchDiv" class="form widthUpload">
				<div class="mainButtonsMenu" style="padding-left: 0px; justify-content: center; align-items: flex-end; margin: 30px 0;">
					<div class="input text">
						<span class="fetchDivHSpan">
							http://
						</span>
						<label for="fetchUrl">
							<?php _e('Alternatively, you can have us upload your video file from a URL, or enter a streaming URL here'); ?>:
						</label>
						<input name="data[fetchUrl]" style="text-indent:50px;color:#bbbdc0;" class="reqiured" type="text" id="fetchUrl">
					</div>

					<div class="bridButton go-fetch-url disabled" id="goFetchUrl" data-form-req="0" data-form-bind="0" style="margin-left: 10px;">
						<div class="buttonLargeContent"><?php _e('GO'); ?></div>
					</div>
				</div>
			</div>

		</div>
		<div class="fetchWarring widthUpload">
			<?php _e('By uploading this video to our system you confirm that you own all copyrights or have authorization to upload and use it'); ?>.
		</div>

		<script type="text/javascript">
			var uploaderOptions = {
				uploadLimit: '<?php echo $upload_limit; ?>',
				path: '<?php echo $upload_path; ?>',
				accessKeyId: '<?php echo $aws_credentials['accessKeyId']; ?>',
				secretAccessKey: '<?php echo $aws_credentials['secretAccessKey']; ?>',
				sessionToken: '<?php echo $aws_credentials['sessionToken']; ?>'
			}


			function initAwsUploader() {
				debug.log("INIT AWS UPLOADER");
				$Brid.init([
					['Html.BridUploader', uploaderOptions]
				]);
			}

			function loadAwsScript(name) {
				var js_script = document.createElement('script');
				js_script.src = name;
				js_script.type = "text/javascript";

				js_script.onload = js_script.onreadystatechange = function(e) {
					if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
						initAwsUploader();
					}
				};

				document.head.appendChild(js_script);
			}
			if (typeof AWS === "undefined") {
				loadAwsScript(["//sdk.amazonaws.com/js/aws-sdk-2.69.0.min.js"]);
			} else {
				initAwsUploader();
			}
		</script>
	<?php } ?>

	<div class="videos form" style="width:auto;">
		<form class="brid-video-form" action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" data-redirect="/videos/index" accept-charset="utf-8">
			<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
			<table class="form-table" style="display:<?php echo $hideUploadFields; ?>">
				<tbody>
					<tr>
						<td style="width:100%;">
							<div class="formWrapper videoAddFormWrapper">

								<div id="mainAdd">
									<input type="hidden" name="action" value="addVideo">
									<input type="hidden" name="insert_via" value="2">
									<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
									<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
									<input type="hidden" name="id" id="VideoId">
									<input type="hidden" name="upload_form" value="<?php echo $upload; ?>" id="VideoUploadForm">
									<?php if ($upload) : ?>

										<input type="hidden" name="upload_in_progress" id="VideoUploadInProgress" value="0">
										<input type="hidden" name="progress_signature" id="VideoProgressSignature">
										<input type="hidden" name="original_filename" id="VideoOriginalFilename">
										<input type="hidden" name="original_file_size" id="VideoOriginalFileSize">
										<input type="hidden" name="upload_source_url" id="VideoUploadSourceUrl">
										<input type="hidden" name="xml_url" id="VideoXmlUrl">

									<?php endif; ?>
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
									<input type="hidden" name="autosave" id="VideoAutosave" value="<?php echo $autosave; ?>">
									<input type="hidden" name="tagsAlert" id="tagsAlert" class="tagsAlert" value="<?php echo $tagsAlert ?>">
									<input type="hidden" name="external_url" default-value="External URL" data-info="External URL" id="VideoExternalUrl">

									<!-- Youtube/Vimeo Form -->

									<!-- MAIN FORM -->

									<div class="mainDataAdd" id="mainData">
										<table style="border-spacing: 0px;">
											<tbody>
												<tr>
													<td style="width:576px; padding-top: 10px;">
														<div class="input text required">
															<input name="name" placeholder="<?php _e('Video title'); ?>" data-info="Video title" tabindex="1" maxlength="250" type="text" id="VideoName" required="required">
														</div>
													</td>
													<td style="padding:0px; padding-top: 10px; vertical-align:top; padding-left: 10px;">
														<div class="uploadDate">
															<div class="input text">
																<input name="publish" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" default-value="<?php echo date('d-m-Y'); ?>" class="datepicker inputField" data-info="Publish on a date." type="text" id="VideoPublish">
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td colspan="2">
														<div class="input textarea">
															<textarea name="description" default-value="Video description" style="height:100px;" data-info="Video description" tabindex="2" cols="30" rows="6" id="VideoDescription" data-ajax-loaded="true"></textarea>
														</div>
													</td>
												</tr>

												<input type="hidden" name="channel_id" value="18">

												<tr>
													<td colspan="2">
														<div class="input select" tabindex="3" style="width:200px">
															<label><?php _e('IAB Content Taxonomy'); ?></label>
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
															<label><?php _e('Syndication Rule'); ?></label>
															<select name="exchange_rule_id" id="VideoExchangeRuleId">
																<?php
																foreach ($exchangeRules as $k => $v) :
																	$selected = '';
																	if ($v['ExchangeRule']['id'] == $default_exchange_rule) {
																		$selected = 'selected="selected"';
																	}
																?>
																	<option value="<?php echo $v['ExchangeRule']['id']; ?>" <?php echo $selected; ?>><?php echo $v['ExchangeRule']['name']; ?></option>
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
															<input name="tags" default-value="Tags" tabindex="4" data-info="Input Tag values as Comma-Separated Values (CSV) if you wish to display related videos when this video ends." type="text" id="VideoTags">
														</div>
													</td>
												</tr>
												<?php if ($hideUploadFields != 'none') { ?>
													<tr>
														<td colspan="2">
															<input type="hidden" name="thumbnail" id="VideoThumbnail">
															<div class="input text">
																<input name="image" default-value="Snapshot URL" data-info="Provide URL to the snapshot image" tabindex="5" maxlength="300" type="text" id="VideoImage">
															</div>
															<div class="bridBrowseLibary" data-field="VideoImage" data-uploader_button_text="Add Snapshot" uploader_title="Browse from Media Library"><?php _e('Browse Library'); ?></div>
														</td>
													</tr>

													<tr>
														<td colspan="2">
															<div class="input text required">
																<input name="mp4" default-value="MP4 or WEBM" data-info="Add MP4, WEBM or streaming video file URL" tabindex="6" maxlength="300" type="text" id="VideoMp4" required="required" data-ajax-loaded="true">
															</div>
															<div class="bridBrowseLibary" data-field="VideoMp4" data-uploader_button_text="Add Video" uploader_title="Browse from Media Library"><?php _e('Browse Library'); ?></div>
														</td>
													</tr>

													<tr>
														<td colspan="2">

															<div id="checkbox-mp4_hd_on" class="bridCheckbox disabledCheckbox" data-method="toggleVideoField" data-name="mp4_hd_on" style="top:4px;left:1px;">
																<div class="checkboxContent">
																	<img src="<?php echo BRID_PLUGIN_URL; ?>img/checked.png" class="checked" style="display:none" alt="">
																	<input type="hidden" name="mp4_hd_on" class="singleCheckbox" id="mp4_hd_on" data-value="0" style="display:none;">
																</div>
																<div class="checkboxText"><?php _e('Add HD Version'); ?></div>
															</div>
														</td>
													</tr>
													<tr>
														<td colspan="2">
															<div class="input text invisibleDiv">
																<input name="mp4_hd" default-value="MP4 or WEBM HD URL" data-info="MP4 High Definition URL Source" maxlength="300" type="text" id="VideoMp4Hd">
															</div>
														</td>
													</tr>
												<?php } ?>

											</tbody>
										</table>

										<div class="bridButton saveButton clearfix disabled" id="videoSaveAdd" data-method="onVideoSave" data-form-bind="0" data-form-req="0" style="margin-bottom:0px; margin-top:15px; float: left;">
											<div class="buttonLargeContent"><?php _e('SAVE'); ?></div>

											<div id="autoSaving" class="clearfix" style="float: left; margin-top: 15px; margin-left: 15px;">
												<?php _e('Autosaving'); ?><span class="fDot">.</span><span class="sDot">.</span><span class="tDot">.</span>
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
	<?php /* if (!$upload) {
	?>
		<div style="clear:both;"></div>
		<div style="border-top:1px solid #BCC3C3;margin-top:15px;padding-top:2px;">
			<div style="margin-left:12px;font-weight:normal;text-decoration:underline;cursor:pointer;text-weight:bold;" class="various" id="addVideoQuestion" data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php') . '?action=askQuestion'; ?>">Want us to host and encode videos for you? Upgrade to premium plan for free.</div>
			<script>
				jQuery('#addVideoQuestion').colorbox({
					innerWidth: 920,
					innerHeight: 210
				});
			</script>
		</div>
	<?php
	} */
	?>
</div>
<script type="text/javascript">
	var allowedImageExtensions = ["jpg", "jpeg", "png", "gif"];
	var amIEncoded = <?php echo $upload; ?>;
	var typingTimer; //timer identifier
	var doneTypingInterval = 600; //time in ms, 5 second for example
	var defaultTab = 'video';
	var currentView = 'add-video'; //This simulates tab switch for buttons, and currently selected service (youtube, vimeo)

	var clickedAddButton; //Stores ADD button object we clicked
	var selectBoxTitle = 'Select category <img class="arrowDownJs" src="<?php echo BRID_PLUGIN_URL; ?>/img/arrow_down.png" width="8" height="4" alt="Click to open submenu" />';

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
		}

	});
	//Call Enable save button function on change
	jQuery('#VideoName, #VideoImage, #VideoMp4Hd').input(function() {
		enableSave();
	});
	//Grab additional info and check codec of the provided Mp4 Url (on success call enableSave();)
	jQuery("#VideoMp4").input(function() {
		getFfmpegInfo();
	});
	jQuery('#ChannelIdUpload').change(function() {
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
	if (amIEncoded) {
		jQuery('#VideoName , #VideoDescription, #VideoTags, #VideoLandingPage').input($Brid.Video.checkAutosaveMessage);
	}

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

				debug.log('attachment', attachment);

				field.val(attachment.url);

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
</script>