<div style="padding:2em">
	<form method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" id="addTagsForm">
		<input type="hidden" name="_method" value="POST">
		<input type="hidden" name="action" value="<?php echo $mode == 'add' ? 'addAdTags' : 'editAdTags' ?>">
		<input type="hidden" name="id" value="<?php echo isset($adTag['Adtag']['id']) ? $adTag['Adtag']['id'] : '' ?>">
		<?php if ($mode == 'add') { ?>
			<input type="hidden" name="append_to_stack" value="<?php echo $append_to_stack; ?>">
			<input type="hidden" name="select_box_id" value="<?php echo $select_box_id; ?>">
		<?php } ?>
		<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site') ?>">
		<h1><?php echo strtoupper($mode); ?> <?php _e('AD TAG'); ?></h1>

		<div style="float:left;     width: 48%;
    padding-right: 2%;
    padding-left: 1%;">
			<h3 class="brid-section-title"><i class="fa fa-money player-icon" aria-hidden="true"></i> <?php _e('DETAILS'); ?></h3>

			<div class="brid-section-content">
				<label><?php _e('Name'); ?></label><br />
				<input type="text" placeholder="Ad tag name" name="name" value="<?php echo isset($adTag['Adtag']['name']) ? $adTag['Adtag']['name'] : '' ?>" maxlength="1024" style="width:90%">
				<br />
				<br />
				<label><?php _e('Ad Tag URL'); ?></label><br />
				<textarea name="url_secure" form="addTagsForm" placeholder="Ad tag Url" rows="6" style="width:90%" id="AdtagUrlSecure" placeholder="Ad tag URL"><?php echo isset($adTag['Adtag']['name']) ? $adTag['Adtag']['url_secure'] : '' ?></textarea>
				<br />

				<small class="brid-notice"><?php _e('Provide an Ad Tag URL'); ?> <a href="https://brid.zendesk.com/hc/en-us/articles/200294282" target="_blank">(VAST compatible)</a> <?php _e('from your advertising partner'); ?>. <a href="https://brid.zendesk.com/hc/en-us/sections/200109322--Player-monetization" target="_blank"><?php _e('Learn more'); ?></a>.</small>

				<br />
				<br />
				<label><?php _e('Macros'); ?></label><br />

				<div class=" macros" style="float:left;width:100%">
					<div data-id="[page_url]" class="button macro" title="Will replace with the page URL">page_url</div>
					<div data-id="[referrer_url]" class="button macro" title="Will replace with the referrer URL">referrer_url</div>
					<div data-id="[description_url]" class="button macro" title="Will be replaced with the description URL which should typically be the same as the referrer URL">description_url</div>
					<div data-id="[video_title]" class="button macro" title="Will replace with the title of the video">video_title</div>
					<div data-id="[description]" class="button macro" title="Will be replaced with the video's description">description</div>
					<div data-id="[video_duration]" class="button macro" title="Will replace with the video duration in seconds">video_duration</div>
					<div data-id="[video_id]" class="button macro" title="Will replace with the ID of the video">video_id</div>
					<div data-id="[autoplay]" class="button macro" title="Will return 1 or 0 depending on if the player autoplays or not">autoplay</div>
					<div data-id="[player_width]" class="button macro" title="Will return the player's width in pixels">player_width</div>
					<div data-id="[player_height]" class="button macro" title="Will return the player's height in pixels">player_height</div>
					<div data-id="[mediafile_url]" class="button macro" title="Will be replaced with the full URL to the video file">mediafile_url</div>
					<div data-id="[timestamp]" class="button macro" title="Use as a cachebuster">cachebuster</div>
					<div data-id="[user_agent]" class="button macro" title="Will be replaced with the browser user agent">user_agent</div>
					<div id="macro-ip" style="display:none;">
						<div data-id="[user_ip]" class="button macro" title="Will be replaced with the IP address of the viewer (premium plans only)">user_ip</div>
						<div data-id="[latitude]" class="button macro" title="Will be replaced with a viewers Geo latitude value (premium plans only)">latitude</div>
						<div data-id="[longitude]" class="button macro" title="Will be replaced with a viewers Geo longitude value (premium plans only)">longitude</div>
					</div>
					<div data-id="[viewability]" class="button macro" title="Will return 1 or 0 depending on if the player is in view when your ad tag gets called">viewability</div>
					<div data-id="[dnt]" class="button macro" title="A do not tack macro. Will return 0 or 1 depending on the user.">dnt</div>
					<div data-id="[gdpr]" class="button macro" title="A flag for European Union traffic consenting to advertisements.">gdpr</div>
					<div data-id="[consent]" class="button macro" title="A consent string passed from various Consent Management Platforms (CMP's).">consent</div>
					<div data-id="[uid]" class="button macro" title="Will be substituted with the session ID of a user.">uid</div>
				</div>

				<br />
				<br />
				<small class="brid-notice"><?php _e('What ad tag macros are supported'); ?>? <a href="https://brid.zendesk.com/hc/en-us/articles/201215152" target="_blank">Learn more</a>.</small>


			</div>

		</div>

		<div style="float:left; width:47%">
			<h3 class="brid-section-title"><i class="fa fa-cogs player-icon" aria-hidden="true"></i> <?php _e('SETTINGS'); ?></h3>
			<div class="brid-section-content">
				<div class="brid-input-item brid-input-item-radio  brid-input-item-adtagactive">
					<label class="brid-label brid-radio brid-label-adtagactive"><?php _e('Active'); ?></label>
					<div class="brid-input-div">
						<input class="brid-input brid-input-radio brid-adtagactive brid-adtagactive0" id="brid-id-adtagactive0" type="radio" name="status" value="0" <?php echo isset($adTag['Adtag']['status']) ? ($adTag['Adtag']['status'] == 0 ? 'checked' : '') : '' ?>> <?php _e('No'); ?> &nbsp;
						<input class="brid-input brid-input-radio brid-adtagactive brid-adtagactive1" id="brid-id-adtagactive1" type="radio" name="status" value="1" <?php echo isset($adTag['Adtag']['status']) ? ($adTag['Adtag']['status'] == 1 ? 'checked' : '') : 'checked' ?>> <?php _e('Yes'); ?>
					</div>
				</div>

				<div class="brid-input-item brid-input-item-radio  brid-input-item-adtagactive">
					<label class="brid-label brid-radio brid-label-adtag_cpm"><?php _e('CPM'); ?></label>
					<div class="brid-input-div">
						<input class="brid-input brid-input-radio" name="cpm" placeholder="0.35" step="any" type="number" value="<?php echo isset($adTag['Adtag']['cpm']) ? $adTag['Adtag']['cpm'] : '' ?>" id="AdtagCpm">
					</div>
				</div>

				<div class="brid-input-item brid-input-item-radio  brid-input-item-adtagactive" style="<?php echo ($mode == 'edit') ? 'display:none' : ''; ?>">
					<label class="brid-label brid-radio brid-label-adtag_type"><?php _e('Type'); ?></label>
					<div class="brid-input-div">
						<select name="type" style="margin: 0 !important">
							<?php foreach (['player' => 'Player', 'outstream' => 'Outstream', 'banner' => 'Banner'] as $k => $v) { ?>
								<?php
								$selected = '';

								if ((isset($adTag['Adtag']['type']) && $adTag['Adtag']['type'] == $k) || (strtolower($v) == $ad_tag_type)) {
									$selected = 'selected';
								}
								?>
								<option data-type-pre-select="<?php echo strtolower($ad_tag_type); ?>" data-type="<?php echo strtolower($v); ?>" value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>

							<?php } ?>

						</select>
					</div>
				</div>

			</div>

			<h3 class="brid-section-title"><i class="fa fa-globe player-icon" aria-hidden="true"></i> <?php _e('GEO-TARGETING'); ?></h3>

			<div class="brid-section-content" id="brid-geo" style="display:none">

				<div class="brid-input-item brid-input-item-radio  brid-input-item-adtagactive">
					<label class="brid-label brid-radio brid-label-adtagactive"><?php _e('Geo-targeting'); ?></label>
					<div class="brid-input-div">
						<input class="brid-input brid-input-radio brid-adtagactive brid-adtagactive0" id="brid-id-adtagactive0" type="radio" name="geo_on" value="0" <?php echo isset($adTag['Adtag']['geo_on']) ? ($adTag['Adtag']['geo_on'] == 0 ? 'checked' : '') : 'checked' ?>> <?php _e('No'); ?> &nbsp;
						<input class="brid-input brid-input-radio brid-adtagactive brid-adtagactive1" id="brid-id-adtagactive1" type="radio" name="geo_on" value="1" <?php echo isset($adTag['Adtag']['geo_on']) ? ($adTag['Adtag']['geo_on'] == 1 ? 'checked' : '') : '' ?>> <?php _e('Yes'); ?>
					</div>
				</div>

				<select name="geo[]" multiple="multiple" style="height: 200px;">
					<?php

					foreach (BridForm::getCountries() as $k => $v) {
						$selected = '';
						if (isset($adTag['Adtag']['geo']) && !empty($adTag['Adtag']['geo']) && in_array($k, array_values($adTag['Adtag']['geo']))) {
							$selected = 'selected="selected" ';
						}
					?>
						<option value="<?php echo $k; ?>" title="<?php echo $v; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>
					<?php } ?>
				</select>


			</div>


		</div>

		<div style="float:left;width:100%; margin-top:20px; margin-bottom:20px;">
			<input class="button button-primary submit saveButton" type="submit" name="submit" id="submitAdTag" class="button button-primary" value="<?php _e('Save Changes'); ?>" data-colorbox-close="1" data-form-id="addAdTags" data-form-bind="0" data-form-req="0" data-method="<?php echo $mode == 'add' ? 'onAdTagToChozen' : 'onEditAdTagInChozen' ?>">
		</div>

	</form>
</div>
<script>
	var save = saveObj.init();

	jQuery('#submitAdTag').click(function(e) {
		e.preventDefault();
		save.save('addTagsForm');
		jQuery.colorbox.close();
	});

	jQuery('#AdTagUrlSecure').on('click.Macro', function() {
		$Brid.Util.Macro.setActive(jQuery('#AdtagUrlSecure'));
		$Brid.Util.Macro.init();
	});
	$Brid.Util.Macro.setActive(jQuery('#AdtagUrlSecure'));
	$Brid.Util.Macro.init();

	if (permissions.geo) {
		jQuery('#brid-geo-upgrade').remove();
		jQuery('#brid-geo').css('display', 'block');

	} else {

		var html = createUpgradeBlock({
			id: 'geo',
			img: 'geo',
			text: "<?php _e("Brid.tv Geo-Targeting allows your Ad Tags to be requested in the geographic locations that you choose. Location targeting helps you focus your advertising and video strategy on the areas where you'll find the right customers, and restrict it in areas where you won't."); ?>"
		});

		if (html) {
			jQuery(html).insertBefore(jQuery('#brid-geo'));
		}
		jQuery('#brid-geo').remove();
	}

	if (permissions.ipmacro) {
		jQuery('#macro-ip').css('display', 'inline-block');

	} else {
		jQuery('#macro-ip').remove();

	}
</script>