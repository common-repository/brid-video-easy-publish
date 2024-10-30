<div class="mainWrapper" style='padding-top:0px;width:auto'>
	<div class="formWrapper form videoAddFormWrapper" style="width:90%; margin:0px;">
		<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">
			<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
			<table class="form-table" style="display:block">
				<tbody>
					<tr>
						<td>
							<div class="formWrapper">

								<div id="mainAdd">
									<input type="hidden" name="action" value="addVideo">
									<input type="hidden" name="insert_via" value="2">
									<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
									<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
									<input type="hidden" name="upload_form" value="0" id="VideoUploadForm">
									<input type="hidden" name="default_tab" value="youtube" id="VideoDefaultTab">
									<input type="hidden" name="external_id" id="VideoExternalId">
									<input type="hidden" name="encoding_setup_finished" id="VideoEncodingSetupFinished">
									<input type="hidden" name="width" id="VideoWidth">
									<input type="hidden" name="height" id="VideoHeight">
									<input type="hidden" name="size" id="VideoSize">
									<input type="hidden" name="video_codec" id="VideoVideoCodec">
									<input type="hidden" name="video_bitrate" id="VideoVideoBitrate">
									<input type="hidden" name="external_service" id="VideoExternalService" value="">
									<input type="hidden" name="external_type" id="VideoExternalType" value="">
									<input type="hidden" name="IsFamilyFriendly" id="VideoIsFamilyFriendly">
									<input type="hidden" name="duration" id="VideoDuration">
									<input type="hidden" name="external_url" default-value="External URL" data-info="External URL" id="VideoExternalUrl" value=""> <!-- Youtube/Vimeo Form -->

									<div class="mainDataAdd" id="externalForm">

										<!-- YOUTUBE SEARCH FORM -->

										<div style="padding:0px;position:relative" id="youtubeSearch">

											<div class="input text required">
												<label class="setting" data-setting="title">
													<span><?php _e('Enter video URL'); ?></span>

													<input name="youtube_search" maxlength="300" style="width:100%" placeholder="Enter video URL" type="text" id="VideoYoutubeSearch" data-ajax-loaded="true">

												</label>
											</div>
										</div>
										<div class="msgAdBox" style="position:relative; top: -10px;"><?php _e('By clicking "ADD" you confirm that you own all copyrights in this video or have authorization to upload and use it'); ?>.</div>

										<!-- YOUTUBE CHANNELS -->
										<input type="hidden" name="channel_id_youtube" value="18">

										<!-- YOUTUBE IAB TAXONOMY -->
										<div id="add-youtube-channel-container" class="ytCont">
											<div id="add-youtube-channel">
												<div style="display: flex;">
													<div>
														<select class="chzn-select" multiple="multiple" name="tags_taxonomies[]" id="TagsTaxonomyIdYoutube">
															<?php foreach ($tagsTaxonomies as $value => $text) : ?>
																<option value="<?php echo $value ?>"><?php echo $text ?></option>
															<?php endforeach; ?>
														</select>
													</div>

													<div class="bridButton saveButton" data-form-bind="0" data-form-req="0">
														<div class="buttonLargeContent">SAVE</div>
													</div>
												</div>
											</div>
										</div>

										<div id="externalServiceLoading"><?php _e('Searching'); ?>...</div>
										<table id="youtubeContent"></table>
									</div>

									<!-- MAIN FORM -->

									<div class="mainDataAdd" id="mainData" style="display: none;">
										<table style="border-spacing: 0px;">

											<tbody>
												<tr>
													<td style="width:576px; padding-top: 10px;">
														<div class="input text required"><input name="name" default-value="Video title" data-info="Video title" tabindex="1" maxlength="250" type="text" id="VideoName" required="required">
															<div class="defaultInputValue" data-info="Video title" style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoName" data-position="true"><?php _e('Video title'); ?></div>
														</div>
													</td>
													<td style="padding:0px; padding-top: 10px; vertical-align:top; padding-left: 10px;">
														<div style="float:right; position:relative;">

															<div class="input text"><input name="publish" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" default-value="<?php echo date('d-m-Y'); ?>" class="datepicker inputField hasDatepicker" data-info="Publish on a date." type="text" id="VideoPublish"></div>
														</div>
													</td>
												</tr>


												<tr>
													<td colspan="2">
														<div class="input textarea"><textarea name="description" default-value="Video description" style="height:100px;" data-info="Video description" tabindex="2" cols="30" rows="6" id="VideoDescription"></textarea>
															<div class="defaultInputValue defaultValueIndent" data-info="Video description" style="padding-top: 8px; display: block; top: 6px; padding-left: 5px; font-size: 16px;" id="default-value-VideoDescription" data-position="true"><?php _e('Video description'); ?></div>
														</div>
													</td>
												</tr>

												<input type="hidden" name="channel_id" value="18">

												<tr>
													<td colspan="2">

														<div class="input text">
															<input name="tags" default-value="Tags" tabindex="4" data-info="Input Tag values as Comma-Separated Values (CSV) if you wish to display related videos when this video ends." type="text" id="VideoTags">
															<div class="defaultInputValue defaultValueIndent" data-info="Input Tag values as Comma-Separated Values (CSV) if you wish to display related videos when this video ends." style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoTags" data-position="true"><?php _e('Tags'); ?></div>
														</div>
													</td>

												</tr>
												<tr>
													<td colspan="2">
														<input type="hidden" name="thumbnail" id="VideoThumbnail">
														<div class="input text"><input name="image" default-value="Snapshot URL" data-info="Provide URL to the snapshot image" tabindex="5" maxlength="300" type="text" id="VideoImage">
															<div class="defaultInputValue defaultValueIndent" data-info="Provide URL to the snapshot image" style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoImage" data-position="true"><?php _e('Snapshot URL'); ?></div>
														</div>
													</td>
												</tr>

												<tr>
													<td colspan="2">
														<div class="input text"><input name="mp4" default-value="MP4 or WEBM" data-info="Add MP4, WEBM or streaming video file URL" tabindex="6" maxlength="300" type="text" id="VideoMp4" required="required">
															<div class="defaultInputValue defaultValueIndent" data-info="Add MP4, WEBM or streaming video file URL" style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoMp4" data-position="true"><?php _e('MP4 or WEBM'); ?></div>
														</div>
													</td>
												</tr>

												<tr>
													<td colspan="2">
														<div id="checkbox-mp4_hd_on" class="bridCheckbox disabledCheckbox" data-method="toggleVideoField" data-name="mp4_hd_on" style="top:4px;left:1px;">
															<div class="checkboxContent"><img src="<?php echo BRID_PLUGIN_URL; ?>img/checked.png" class="checked" style="display:none" alt=""><input type="hidden" name="mp4_hd_on" class="singleCheckbox" id="mp4_hd_on" data-value="0" style="display:none;"></div>
															<div class="checkboxText"><?php _e('Add HD Version'); ?></div>
														</div>

													</td>
												</tr>
												<tr>
													<td colspan="2">
														<div class="input text invisibleDiv"><input name="mp4_hd" default-value="MP4 or WEBM HD URL" data-info="MP4 High Definition URL Source" maxlength="300" type="text" id="VideoMp4Hd">
															<div class="defaultInputValue defaultValueIndent" data-info="MP4 High Definition URL Source" style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoMp4Hd" data-position="true"><?php _e('MP4 or WEBM HD URL'); ?></div>
														</div>
													</td>
												</tr>
											</tbody>
										</table>


									</div>
								</div>

							</div>

						</td>
					</tr>
				</tbody>
			</table>

		</form>

		<table id="oneRowTempalte" style="display:none">
			<tbody>
				<tr id="video-row-{{id}}" data-id="{{id}}" class="partnerTr" style="background-color:{{bgColor}}">
					<td style="width:10px;"></td>
					<td class="imgTable">
						<div class="centerImg centerImgFix">
							<div class="centerImgWrapper">
								<a href="{{providerUrl}}{{id}}" title="View on {{service}}: {{title}}" target="_blank">
									<img src="{{image}}" class="thumb" width="111px" height="82px" id="video-img-{{id}}" alt="" style="display: inline;">
								</a>
							</div>
							<div class="time" id="video-duration-{{id}}">{{duration}}</div>
						</div>
					</td>
					<td class="videoTitleTable">
						<div style="float:left;width:100%;">
							<a href="{{providerUrl}}{{id}}" id="video-title-{{id}}" class="listTitleLink" title="View on {{service}}: {{title}}" target="_blank">{{title}}</a>
							<div class="videoUploadedBy">
								<div class="siteVideosNum">
									<?php _e('By'); ?>: {{author}} &nbsp;&nbsp;
									<span style="color:#b5b5b5"><?php _e('Published'); ?>: {{published}}</span>
									<br><br>
									<span id="VideoStatusWrap" style="display:none">
										<?php _e('Status:'); ?>: <span id="VideoStatus" class="color-danger">Uploading in progress</span>
									</span>
								</div>
							</div>
							<div>

							</div>
						</div>
					</td>
					<td align="right" id="td{{id}}">
						<div class="bridButton youtube_add" data-id="{{id}}" style="display: block; opacity: 1;">
							<div class="buttonLargeContent"><?php _e('ADD'); ?></div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script>
	//Array of destination objects

	// Allowed image extensions
	var allowedImageExtensions = ["jpg", "jpeg", "png", "gif"];
	var amIEncoded = 0;
	var typingTimer; //timer identifier
	var doneTypingInterval = 600; //time in ms, 5 second for example
	var defaultTab = 'youtube';
	var currentView = 'add-video'; //This simulates tab switch for buttons, and currently selected service (youtube, vimeo)

	var clickedAddButton; //Stores ADD button object we clicked
	var selectBoxTitle = 'Select category <img class="arrowDownJs" src="<?php echo BRID_PLUGIN_URL; ?>img/arrow_down.png" width="8" height="4" alt="Click to open submenu" />';

	//JS Templating system @see http://handlebarsjs.com/
	var template = Handlebars.compile(jQuery('#oneRowTempalte').html());
	//Init save object
	var save = saveObj.init();

	jQuery('#copy_shortcode,#videoSaveAdd').css('display', 'none');


	//Init main functions
	initBridMain();

	jQuery('#monetYt').click(function(e) {
		e.preventDefault();
		$Brid.Api.call({
			data: {
				action: "updatePartnerField",
				"name": "intro_video",
				"value": 1
			},
			callback: {
				after: {
					name: "refreshAddYoutube",
					obj: jQuery("#Videos-content")
				}
			}
		});
	});

	function addVideoFromSearch(val, text) {
		jQuery('#add-youtube-channel, #add-vimeo-channel').hide(); // Hide category dropdown
		var dataId = clickedAddButton.attr('data-id'); // Prepare data and call save function
		var serviceUrl = (currentView == 'add-vimeo') ? 'http://www.vimeo.com/' : 'http://www.youtube.com/watch?v=';
		clickedAddButton.remove();
		debug.log('addVideoFromSearch', serviceUrl + dataId);
		populateDataAndSave(serviceUrl + dataId, dataId);

		//Take back add-{currentView}-channel to the container div, so on next contnet display (search) we can show it again
		//If we do not do this, on ADD button click, add-{currentView}-channel will be moved to the Youtube list so user can add it to category
		//But next search query in input field will override Youtube list and add-{currentView}-channel will be lost, so on add
		//we move it back to its parent container
		jQuery('#' + currentView + '-channel-container').append(jQuery('#' + currentView + '-channel').detach());

	}

	jQuery(document).off("click").on("click", ".saveButton", function() {
		addVideoFromSearch("", "");
	})

	function showEditLine(id) {
		var td = jQuery("td#td" + id);
		td.find('.videoAdded').fadeOut('fast', function() {
			td.find('.videoAdded2').fadeIn('fast', function() {

				jQuery(this).find('a').click(function(e) {
					e.preventDefault();

					var id = jQuery(this).attr('data-id'); //Populated in brid.save.js
					if (id != undefined)
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

				});
			});
		});

	}

	//Ajax : Check Youtube url and populate form, and call save
	var populateDataAndSave = function(youtubeUrl, dataId) { //Check Youtube/Vimeo Url

		jQuery("td#td" + dataId).append('<img src="<?php echo BRID_PLUGIN_URL; ?>img/adding_external_video.gif" style="padding-right: 25px" />');
		jQuery.ajax({
			url: ajaxurl, //'/videos/check_url/.json',
			data: 'action=checkUrl&external_url=' + youtubeUrl,
			type: 'POST',
			context: {
				id: dataId
			}
		}).done(function(responseData) {

			if (typeof responseData == 'object' && responseData.length != 0) {
				debug.log('Objekat moj:', responseData, 'id:', this.id);

				for (var a in responseData) { //Populate form data

					if (jQuery('#Video' + a).length > 0) {
						jQuery('#default-value-Video' + a).hide();
						jQuery('#Video' + a).val(responseData[a]);
					}
				}

				jQuery("td#td" + this.id + ' img').remove();
				jQuery("td#td" + this.id).append('<div class="videoAdded">VIDEO ADDED!</div><div class="videoAdded2"><a href="#">EDIT IT HERE</a></div>');


				debug.log('SAVE...');
				save.save('VideoAddForm');

			}
		}).fail(function(e, t, i) {
			$Brid.Util.openDialog('Please reload the page', "Something went wrong")
		});

	}

	/**
	 * Show content of youtube/vimeo search results
	 */
	function showContent(arrayData) {

		var youtubeContent = jQuery('#youtubeContent');
		var contnet = '';
		jQuery(arrayData).each(function(k, v) {

			if (v.title != undefined) {
				var decoded = jQuery('<div></div>').html(v.title).text();
				v.title = decoded;
				v.bgColor = '#f7f7f7';
				if (k % 2 == 0) {
					v.bgColor = '#fff';
				}
				contnet += template(v);
			}

		});

		youtubeContent.append(contnet);

		jQuery('.youtube_add').click(function(e) {
			clickedAddButton = jQuery(this);

			var parentTD = clickedAddButton.closest('td');
			var sBoxId = '#' + currentView + '-channel';

			jQuery('.youtube_add').show(); // First show all add buttons

			jQuery(sBoxId + ' .textButtonSmallJs').html(selectBoxTitle); // Initialize drop down box
			jQuery(sBoxId + ' .gdrop_down').hide();

			parentTD.append(jQuery(sBoxId).detach()); // Put it into TD (absolute positioning doesn't work because of sticky nav)

			debug.log('sBoxId', parentTD.attr('id'), jQuery(sBoxId));

			jQuery(sBoxId).show(); // Show drop box and hide add button
			jQuery(this).hide();

		});
	}


	jQuery(function() {
		/**
		 * Youtube search field
		 */
		jQuery('#VideoYoutubeSearch').keyup(function() { //on keyup, start the countdown
			jQuery('#externalServiceLoading').fadeIn();
			clearTimeout(typingTimer);
			typingTimer = setTimeout(getYoutube, doneTypingInterval);

		}).keydown(function() { //on keydown, clear the countdown
			clearTimeout(typingTimer);
		});


		/**
		 * Save button on click
		 */
		jQuery("#videoSaveAdd").unbind('click');
		jQuery("#videoSaveAdd").off('click.PostBrid').on('click.AddPostBrid', function(e) {

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

		function resetFetchedFields() {

			//Reset Youtube fields
			var youtubeFields = ['VideoTags', 'VideoImage', 'VideoName', 'VideoMp4', 'VideoWebmOgg', 'VideoUniqueid', 'VideoSource', 'VideoExternalUrl', 'VideoExternalType', 'VideoExternalService']; //['VideoTags', 'VideoImage', 'VideoTitle', 'VideoExternalUrl', 'VideoUniqueid'];

			jQuery(youtubeFields).each(function(a, b) {

				jQuery('#default-value-' + b).show();
				jQuery('#' + b).val('');

			});

		}
		//Generate form view depending of the defaultTab value
		if (defaultTab == 'vimeo' || defaultTab == 'youtube') {
			//Youtube
			if (defaultTab == 'youtube') {
				addYoutubeProcessor();
			}
			//Vimeo - disabled
			if (defaultTab == 'vimeo') {
				addVimeoProcessor();
			}
		} else {
			//Classic video
			addVideoProcessor();
		}
		/**/
		// Init preview of the Youtube Form (Search)
		function addYoutubeProcessor() {
			resetFetchedFields();

			if (currentView != 'add-youtube') {
				jQuery('#formName').html('Add YouTube Video');

				jQuery('#externalForm, #youtubeSearch').fadeIn();

				//Empty youtubeContnet div (if someone searched Vimeo first)
				jQuery('#youtubeContent').html('');
				jQuery('#VideoVimeoSearch').val('');

				jQuery('#vimeoSearch, #mainData, #add-vimeo-channel').hide(); //, #mainData

				jQuery('#VideoExternalUrl').val('');
				//Remove this if you want save to work
				jQuery('#VideoMp4').parent().removeClass('required');

				currentView = 'add-youtube';

			}

		}

		// Init preview of the Classic Video Input
		function addVideoProcessor() {
			jQuery('#videoSaveAdd, #mainData').fadeIn();
			//If external Url is provided
			if (jQuery('#VideoExternalUrl').val() != '') {
				resetFetchedFields();
			}

			if (currentView != 'add-video') {
				jQuery('#VideoMp4').parent().addClass('required');
				jQuery('#VideoYoutubeSearch, #VideoVimeoSearch').val(''); //remove all from youtube and vimeo search
				jQuery('#default-value-VideoYoutubeSearch, #default-value-VideoVimeoSearch').show();
				jQuery('#formName').html('Add Video');
				jQuery('#videoSaveAdd, #mainData').fadeIn();
				jQuery('#externalForm').hide();
				currentView = 'add-video';

			}

		}

	});
</script>