<div class="videos formVideo mainWrap">
	<?php if ($permissions['replace_video']) : ?>
		<script>
			var uploaderOptions = {
				uploadLimit: '<?php echo $upload_limit; ?>',
				path: '<?= $upload_path; ?>',
				accessKeyId: '<?= $aws_credentials['accessKeyId']; ?>',
				secretAccessKey: '<?= $aws_credentials['secretAccessKey']; ?>',
				sessionToken: '<?= $aws_credentials['sessionToken']; ?>',
				reUpload: true,
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
	<?php endif; ?>
	<!-- Edit video form start -->
	<form class="brid-video-form" action="<?= admin_url('admin-ajax.php'); ?>" id="VideoEditForm" method="post" data-redirect="/videos/index" accept-charset="utf-8">
		<input type="hidden" name="_method" value="PUT">
		<input type="hidden" name="tagsAlert" id="tagsAlert" class="tagsAlert" value="<?php echo $tagsAlert ?>">
		<?php BridForm::drawForm('Video', $descriptors); ?>
		<!-- Edit video form end -->
		<div class="bridButton saveButton save-video lightboxSave" id="videoSaveEdit" data-form-id="VideoEditForm" data-form-bind="0" data-form-req="0" data-method="reloadPage" style="margin-top:30px;margin-left:10px;">
			<div class="buttonLargeContent"><?php _e('SAVE'); ?></div>
		</div>
		<div class="propagate">
			<div><?php _e('Please allow up to 3 minutes for changes to propagate'); ?>.</div>
		</div>
	</form>
</div>
<script>
	<?php if ($permissions['upload']) : ?>
		// snapshot uploader
		function makeid(length) {
			var result = '';
			var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			var charactersLength = characters.length;
			for (var i = 0; i < length; i++) {
				result += characters.charAt(Math.floor(Math.random() * charactersLength));
			}
			return result;
		}

		setTimeout(() => {
			var field = 'upload_snapshot';
			var upload_name = 'UPLOAD FROM FILE';
			var path = '<?= $upload_path_snapshot; ?>';
			var img_path = '<?= UGC; ?>partners/<?= $partner->Partner->id; ?>/snapshot/';
			var video_id = <?= $video->Video->id; ?>;
			var filename = '';
			var bucket = 'brid-videos'; //'<?= $video->Video->bucket; ?>';
			var region = 'us-west-2'; //'<?= $video->Video->region; ?>';

			var params = {
				Body: null,
				Key: path,
				Bucket: bucket,
				ACL: "public-read",
				StorageClass: "REDUCED_REDUNDANCY",
			};

			this.options = {
				maxFileSize: 5 * 1024 * 1024,
				allowedExtensions: ['png', 'jpg', 'jpeg'],
				bucket: bucket,
				region: region
			};

			var credentials = {};
			credentials.region = region;
			credentials.accessKeyId = '<?= $aws_credentials['accessKeyId']; ?>';
			credentials.secretAccessKey = '<?= $aws_credentials['secretAccessKey']; ?>';
			credentials.sessionToken = '<?= $aws_credentials['sessionToken']; ?>';

			AWS.config.update(credentials);

			var bucket = new AWS.S3({
				params: params
			});

			jQuery('#upload_snapshot').on('change', () => {
				var file = document.getElementById('upload_snapshot').files[0];
				var ext = file['name'].split('.').pop();
				filename = video_id + "_s_" + jQuery.now() + "." + ext;
				params.Body = file;
				params.Key += filename;

				bucket.putObject(params, (err, data) => {
					if (err) jQuery('.tab-panel-snap-uploadt p').html('Something whent wrong.');
					jQuery('#VideoImage').val(img_path + filename);
					// call new snapshot api
					jQuery.ajax({
						url: 'admin-ajax.php?action=new_snapshot',
						data: 'action=new_snapshot&Video[id]=' + video_id + '&Video[upload_snapshot]=' + filename +
							'&Video[path]=' + img_path + '&Video[field]=' + field + '&Partner[id]=<?= $partner->Partner->id; ?>',
						type: 'POST',
						success: function(data) {
							jQuery('.tab-panel-snap-upload p').html('New snapshot successfully uploaded.');
						},
						error: function() {
							jQuery('.seek-snapshot p').html('Something whent wrong.');
						}
					});

					enableSave();
				});
			});

			jQuery('#upload_snapshot_button').on('click', () => {
				jQuery('#upload_snapshot').click();
			});
		}, 1000);


		jQuery('#seekSnapshot').val('<?= $video->Video->id; ?>');

		<?php if ($video->Video->duration) : ?>

			var end_of_video = '<?= $video->Video->duration; ?>';

			jQuery('#videoRangeSlider').attr('max', end_of_video);
			jQuery('#videoRangeSlider').rangeslider({
				onSlide: function(position, value) {
					debug.log(position, value);
				}
			});

			jQuery('#videoRangeSlider').on('input', () => {
				var value_from_slider = jQuery('#videoRangeSlider').val();

				$bp('wp_edit_video').setVolume(0);
				$bp('wp_edit_video').play();
				$bp('wp_edit_video').currentTime(value_from_slider);
				$bp('wp_edit_video').pause();
				$bp('wp_edit_video').setVolume(0.5);
			});

			jQuery('#seekSnapshot').on('click touch', () => {
				var videoId = <?= $video->Video->id; ?>;
				var value_from_slider = jQuery('#videoRangeSlider').val();

				jQuery.ajax({
					url: 'admin-ajax.php?action=seek_snapshot',
					data: 'action=seek_snapshot&Video[id]=' + videoId + '&Video[time_from_video]=' + value_from_slider + '&Partner[id]=<?= $partner->Partner->id; ?>',
					type: 'POST',
					success: function(data) {
						jQuery('.seek-snapshot p').html('New snapshot queued for processing. Please allow some time before your new snapshot becomes available.');
					},
					error: function() {
						jQuery('.seek-snapshot p').html('Something whent wrong.');
					}
				});
			});
		<?php endif; ?>

	<?php endif; ?>

	<?php if ($permissions['captions']) : ?>
		// cc uploader
		setTimeout(() => {
			var field = 'upload_cc';
			var upload_name = 'UPLOAD FROM FILE';
			var path = '<?= $upload_path_cc; ?>';
			var vtt_path = '<?= UGC; ?>partners/<?= $partner->Partner->id; ?>/vtt/';
			var video_id = <?= $video->Video->id; ?>;
			var filename = makeid(8) + ".vtt";
			var bucket = '<?= $video->Video->bucket; ?>';
			var region = '<?= $video->Video->region; ?>';
			var params = {
				Body: null,
				Key: path,
				Bucket: bucket,
				ACL: "public-read",
				StorageClass: "REDUCED_REDUNDANCY",
			};

			this.options = {
				maxFileSize: 5 * 1024 * 1024,
				allowedExtensions: ['vtt'],
				bucket: bucket,
				region: region
			};

			var credentials = {};
			credentials.region = region;
			credentials.accessKeyId = '<?= $aws_credentials['accessKeyId']; ?>';
			credentials.secretAccessKey = '<?= $aws_credentials['secretAccessKey']; ?>';
			credentials.sessionToken = '<?= $aws_credentials['sessionToken']; ?>';

			AWS.config.update(credentials);

			var bucket = new AWS.S3({
				params: params
			});

			jQuery('#upload_cc').on('change', () => {
				var file = document.getElementById('upload_cc').files[0];
				params.Body = file;
				params.Key += filename;

				bucket.putObject(params, (err, data) => {
					if (err) jQuery('#upload_cc_container p').html('Something whent wrong.');
					data = {
						action: "uploaded_cc",
						partner_id: <?= $partner->Partner->id ?>,
						id: <?= $video->Video->id ?>,
						cc: filename
					};
					jQuery.ajax({
						url: 'admin-ajax.php?action=uploaded_cc',
						data: data,
						type: 'POST',
						success: function(data) {
							jQuery('#upload_cc_button').hide();
							jQuery('#remove_cc_button').show();
						},
						error: function() {
							jQuery('#upload_cc_container p').html('Something whent wrong.');
						}
					});
					enableSave();
				});
			});

			jQuery('#upload_cc_button').on('click', () => {
				console.log('click', jQuery('#upload_cc'));
				jQuery('#upload_cc').click();
			});

			jQuery('#remove_cc_button').on('click', () => {
				data = {
					action: "remove_cc",
					partner_id: <?= $partner->Partner->id ?>,
					id: <?= $video->Video->id ?>
				};
				jQuery.ajax({
					url: 'admin-ajax.php?action=remove_cc',
					data: data,
					type: 'POST',
					success: function(data) {
						jQuery('#remove_cc_button').hide();
						jQuery('#upload_cc_button').show();
					},
					error: function() {
						jQuery('#upload_cc_container p').html('Something whent wrong.');
					}
				});
			});

		}, 1000);
		<?php if ($cc) : ?>
			jQuery('#upload_cc_button').hide();
			jQuery('#remove_cc_button').show();
		<?php else : ?>
			jQuery('#remove_cc_button').hide();
			jQuery('#upload_cc_button').show();
		<?php endif; ?>
	<?php endif; ?>
</script>

<script type="text/javascript">
	$bp("wp_edit_video", {
		id: '<?= BridOptions::getOption('player'); ?>',
		video: '<?= $video->Video->id; ?>',
		width: '276',
		height: '166'
	});
</script>

<script>
	jQuery('#monetAdvancedTitle').on('click', function(e) {

		jQuery('#monetAdvanced').fadeToggle(400, function() {

			if (jQuery('#monetAdvanced').is(':visible')) {
				jQuery('.closeAlertDivButton').addClass('closeAlertDivButtonRot');
			} else {
				jQuery('.closeAlertDivButton').removeClass('closeAlertDivButtonRot');
			}
		});

	});

	// hidden fields
	jQuery('#brid-id-action').val('editVideo');
	jQuery('#brid-id-id').val('<?= $video->Video->id; ?>');
	jQuery('#brid-id-insert_via').val('<?= $video->Video->insert_via; ?>');
	jQuery('#brid-id-partner_id').val('<?= $partner->Partner->id; ?>');
	jQuery('#brid-id-width').val('<?= $video->Video->width; ?>');
	jQuery('#brid-id-height').val('<?= $video->Video->height; ?>');
	jQuery('#brid-id-size').val('<?= $video->Video->size; ?>');
	jQuery('#brid-id-video_codec').val('<?= $video->Video->video_codec; ?>');
	jQuery('#brid-id-video_bitrate').val('<?= $video->Video->video_bitrate; ?>');
	jQuery('#brid-id-duration').val('<?= $video->Video->duration; ?>');
	//
	jQuery('#brid-id-name').val("<?= addslashes(trim($video->Video->name)); ?>");
	jQuery('#brid-id-description').val(`<?= addcslashes(trim($video->Video->description), '\\'); ?>`);
	// jQuery('#brid-id-description').val('Some multi \n line text.');
	jQuery('#brid-id-clickthroughUrl').val("<?= addslashes(trim($video->Video->clickthroughUrl)); ?>");

	jQuery('#brid-id-publish').val('<?= $video->Video->publish; ?>');
	jQuery('#brid-id-mp4').val('<?= $video->Video->source->sd; ?>');
	jQuery('#brid-id-age_gate_id').val('<?= $video->Video->age_gate_id; ?>');

	jQuery('#brid-id-mp4_ld').val('<?= $video->Video->source->ld; ?>');
	jQuery('#brid-id-mp4_hsd').val('<?= $video->Video->source->hsd; ?>');
	jQuery('#brid-id-mp4_hd').val('<?= $video->Video->source->hd; ?>');
	jQuery('#brid-id-mp4_fhd').val('<?= $video->Video->source->fhd; ?>');

	jQuery('#VideoImage').val('<?= $video->Video->image; ?>');
	jQuery('#brid-id-channel_id').val('<?= $video->Video->channel_id; ?>');
	jQuery('#brid-id-exchange_rule_id').val('<?= $video->ExchangeRule->id ?? '0'; ?>');

	<?php
	$tags_taxonomies = array_map(function ($item) {
		return $item->id;
	}, $video->IabCategories);

	$tags_taxonomies = json_encode($tags_taxonomies);
	?>
	jQuery('#brid-id-tags_taxonomies').val(<?= $tags_taxonomies ?>);

	// If nothing is selected, to trigger validation message from CMS we need to pass 0 as empty field
	jQuery('#brid-id-tags_taxonomies').on('change', function() {
		if (jQuery(this).val() == "") {
			jQuery(this).val([0]);
		}
	});

	var tagsRaw = JSON.parse('<?= json_encode($video->Tag) ?>');
	var tagsCsv = tagsRaw.map(tag => tag.title).join(", ");
	jQuery('#brid-id-tags').val(tagsCsv);

	var uploadUrl = '<?= OAUTH_PROVIDER; ?>';

	var amIYoutube = <?php if (isset($video->Video->external_type) && $video->Video->external_type) echo $video->Video->external_type;
						else echo 0; ?>;
	var allowedImageExtensions = ["jpg", "jpeg", "png", "gif"];
	var amIEncoded = <?= $amIEncoded; ?>;
	var typingTimer; //timer identifier
	var doneTypingInterval = 600; //time in ms, 5 second for example
	var defaultTab = 'video';
	var currentView = 'add-video'; //This simulates tab switch for buttons, and currently selected service (youtube, vimeo)

	var clickedAddButton; //Stores ADD button object we clicked
	var selectBoxTitle = 'Select category <img class="arrowDownJs" src="<?= BRID_PLUGIN_URL; ?>/img/arrow_down.png" width="8" height="4" alt="Click to open submenu" />';

	jQuery(document).ready(function($) {
		if (amIEncoded) {
			jQuery('.brid-input-item-mp4_hd').remove();
			jQuery('.brid-input-item-mp4').remove();
			jQuery('.brid-input-item-mp4_hsd').remove();
			jQuery('.brid-input-item-mp4_ld').remove();
			jQuery('.brid-input-item-mp4_fhd').remove();
		}
	});

	//Init save object
	var save = saveObj.init();
	initBridMain();
	$Brid.init(['Html.Tabs']);

	/**
	 * Save button on click
	 */
	jQuery("#videoSaveEdit").click(function(e) {
		if (!jQuery(this).hasClass('disabled') && !jQuery("#videoSaveEdit").hasClass('inprogress')) {

			jQuery("#videoSaveEdit").addClass('inprogress');
			save.save('VideoEditForm');
		} else {
			//Is save in progress?
			if (jQuery("#videoSaveEdit").hasClass('inprogress')) {
				$Brid.Util.openDialog('Save error', 'Save already in progress');

			}
			//CheckFields (true) will display openDialog message
			if (checkFields(true)) {

				save.openRequiredDialog('VideoEditForm', '<b>Please check following:</b><br/><br/> 1.) Are required fields empty?<br/> 2.) Are fields values in valid format?', 'Save is disabled');
				console.error('[Error from custom video save function] Save is disabled. Check mandatory fileds.');
				jQuery('.saveButton').addClass('disabled');
			}

		}

	});
	if (!amIYoutube) {
		//Call Enable save button function on change
		jQuery('#VideoName, #VideoImage, #VideoMp4Hd').input(function() {
			if (jQuery('#VideoName').hasClass("disabled")) {
				enableSave(); //@see bridWordpress.js line 3648
			}
		});
		//Grab additional info and check codec of the provided Mp4 Url (on success call enableSave();)
		jQuery("#VideoMp4").input(function() {
			getFfmpegInfo();
		});
	}
	jQuery('#VideoChannelId').change(function() {
		enableSave();
	});

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

			});

			// Finally, open the modal
			file_frame.open();
		});


	}
	enableSave(); //@see bridWordpress.js line 3648
</script>