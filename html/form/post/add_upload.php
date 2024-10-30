<?php $button = 'Upload video'; ?>
<div class="mainWrapper" style="padding-top: 10px; width: auto;">
	<?php
	$hideUploadFields = 'block';
	if ($upload) {
		$hideUploadFields = 'none';
	?>
		<div class="formUploaderWrapper" id="UploaderForm" style="width:auto;position:relative;margin-top:20px">
			<div class="mainDataAddQuick">

				<div id="uploadButtonDiv" style="text-align: center; ">
					<input type="button" id="userfileButton" class="uploadFile" autocomplete="off" style="position:static;   margin-top: 40px; float:none;" />
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

		</div>

		<div class="fetchWarring" style="left: 0px; right: 310px; height:20px;width:auto;bottom:10px;position:absolute;top:inherit">
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

	<form class="brid-video-form" action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">
		<div class="videos form">
			<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
			<table class="form-table" style="display:<?php echo $hideUploadFields; ?>">
				<tbody>
					<tr>
						<td style="width:858px">
							<div class="formWrapper videoAddFormWrapper">

								<div id="mainAdd">
									<input type="hidden" name="action" value="uploadVideoPost">
									<input type="hidden" name="insert_via" value="2">
									<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
									<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
									<input type="hidden" name="id" id="VideoId">
									<input type="hidden" name="upload_form" value="<?php echo $upload; ?>" id="VideoUploadForm">

									<input type="hidden" name="upload_in_progress" id="VideoUploadInProgress" value="0">
									<input type="hidden" name="progress_signature" id="VideoProgressSignature">
									<input type="hidden" name="original_filename" id="VideoOriginalFilename">
									<input type="hidden" name="original_file_size" id="VideoOriginalFileSize">
									<input type="hidden" name="upload_source_url" id="VideoUploadSourceUrl">
									<input type="hidden" name="xml_url" id="VideoXmlUrl">

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
									<input type="hidden" name="autosave" id="VideoAutosave" value="<?php echo $autosave ?>">
									<input type="hidden" name="tagsAlert" id="tagsAlert" class="tagsAlert" value="<?php echo $tagsAlert ?>">
									<input type="hidden" name="external_url" default-value="External URL" data-info="External URL" id="VideoExternalUrl">
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- SIde bar -->
		<div class="media-sidebar">
			<div class="attachment-details save-ready" id="postUploadQuick" style="display:none">
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
				<label class="setting" data-setting="alt">
					<span><?php _e('Tags'); ?></span>
					<input name="tags" placeholder="Comma-Separated Values" type="text" id="VideoTags">
				</label>
				<label class="setting" data-setting="description">
					<span><?php _e('Publish date'); ?></span>
					<div style="position:relative;z-index:9999;cursor:pointer">
						<input name="publish" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" default-value="<?php echo date('d-m-Y'); ?>" class="datepicker inputField" type="text" id="VideoPublish" style="cursor:pointer">
					</div>
				</label>

				<input type="hidden" name="channel_id" value="18">

				<label class="setting" data-setting="description">
					<span><?php _e('IAB Content<br>Taxonomy'); ?></span>
					<select class="chzn-select" multiple="multiple" name="tags_taxonomies[]" id="TagsTaxonomyId">
						<?php foreach ($tagsTaxonomies as $value => $text) : ?>
							<option value="<?php echo $value ?>"><?php echo $text ?></option>
						<?php endforeach; ?>
					</select>
				</label>

				<label class="setting" data-setting="description">
					<span><?php _e('Syndication<br>Rule'); ?></span>

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
				</label>

				<label class="setting" data-setting="description">
					<span><?php _e('Age gate'); ?></span>
					<select name="age_gate_id">
						<option value="1"><?php _e('Everyone'); ?></option>
						<option value="2">17+ (<?php _e('ESRB - Mature rated'); ?>)</option>
						<option value="3">18+ (<?php _e('ESRB - Adults only'); ?>)</option>
					</select>
				</label>
				<p class="setting" data-setting="status">
					<span><?php _e('Status'); ?></span>
					<span id="VideoStatus" class="color-danger">Uploading in progress</span>
				</p>
			</div>
		</div>
	</form>

	<?php /* if (!$upload) : ?>
		<div style="clear:both;"></div>
		<div style="border-top:1px solid #BCC3C3;margin-top:15px;padding-top:2px;">
			<div style="margin-left:12px;font-weight:normal;text-decoration:underline;cursor:pointer;text-weight:bold;" class="various" id="addVideoQuestion" data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php') . '?action=askQuestion'; ?>">Want us to host and encode videos for you? Upgrade to premium plan for free.</div>
			<script type="text/javascript">
				jQuery('#addVideoQuestion').colorbox({
					innerWidth: 920,
					innerHeight: 650
				});
			</script>
		</div>
	<?php endif; */ ?>
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
	var save = saveObj.init();

	initBridMain();

	/**
	 * Save button on click binded already on add_video
	 */
	jQuery('#copy_shortcode').css('display', 'none');

	jQuery('#videoSaveAdd').off('click').css('display', 'inline-block').addClass('disabled');

	jQuery("#videoSaveAdd").on('click.AddUploadPostBrid', function() {

		if (!jQuery('#videoSaveAdd').hasClass('disabled') && !jQuery('#videoSaveAdd').hasClass('inprogress')) {
			jQuery("#videoSaveAdd").addClass('disabled');
			save.save('VideoAddForm');
		} else {
			if (jQuery('#VideoXmlUrl').val() == '' && jQuery('#signature').val() != '') {
				$Brid.Util.openDialog('Upload in progress', 'Save disabled');
			}
		}
	});

	//Call Enable save button function on change
	jQuery('#VideoName').input(function() {
		if ($Brid.Html.BridUploader.finished) {
			if ($Brid.Video.checkFieldsEncodedFile()) {
				jQuery("#videoSaveAdd,#videoSaveEdit").removeClass('disabled');
			}
		}
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
</script>