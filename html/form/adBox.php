<div id="ad-box-template" style="display:none">
	<?php
	$saved_ads = isset($saved_ads) ? $saved_ads : [];
	?>

	<div class="bridad-box-container" id="bridad-box-container-{{adSlot}}-{{pod}}">
		<table class="bridad-box-{{adSlot}}-{{pod}}">
			<tr style="background-color:#fff;">
				<td width="20" style="padding:5px; font-size:21px; padding-left:10px; padding-top: 10px;">
					<i class="fa fa-circle icon-type-{{adSlot}}" aria-hidden="true"></i>
				</td>
				<td style="padding:5px; font-family:'Fjalla One', Arial; font-size:21px; color:#000000; padding-top: 11px; padding-left: 0px;text-transform:uppercase;">{{#if isBanner}}DISPLAY BANNER | ANY-AD&trade;{{else}} {{adSlot}} {{/if}} {{#if pod}} #{{podTitle}}{{else}} {{/if}}</td>
				<td style="padding:5px; padding-top: 8px;">
					<a style="float: right; text-decoration: none;padding-top:2px;margin-right:15px;" class="button radius tiny ad-box-remove-tag" href="#" id="ad-box-remove-tag-{{adSlot}}-{{pod}}" data-type="{{adSlot}}" data-pod="{{pod}}"><i class="fa fa-trash" aria-hidden="true" style="font-size: 14px;padding-right:5px"></i> DELETE</a>
				</td>
			</tr>
			<tr style="background-color:#fff;">
				<td colspan="3">
					<div style="border-bottom:1px solid #dadadb;width:100%; float:right;">
				</td>
			</tr>
			<tr style="background-color:#fff;">
				<td colspan="3" style="padding: 10px;">
					<div class="form-new" style="display:block; position: relative; width: 100%;">

						{{#if isBanner}}
							<div id="banner-settings" class="ad-box-midroll">
								<div>Timeout: </div>
								<div style="margin-left: 20px;">
									<input type="text" id="AdBannerDuration-{{pod}}" name="{{modelName}}[ads][{{adSlot}}][{{pod}}][overlayDuration]" value="{{overlayDuration}}" style='width:60px;height:22px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;' />
								</div>
							</div>
						{{/if}}

						{{#if isMidroll}}
							<div id="midroll-settings" class="ad-box-midroll">
								<div id="1-start">Cuepoints</div>
								<div id="1-start-at" class="ad-box-midroll-input-div">
									<input type="text" id="AdCuepoints-{{pod}}" placeholder="Comma separated values" name="{{modelName}}[ads][{{adSlot}}][{{pod}}][cuepoints]" value="{{cuepoints}}" style="width: 250px; height: 28px;" />
								</div>
								<div class="input select" style="margin-left: 20px;margin-top:15px;">
									<select name="{{modelName}}[ads][{{adSlot}}][{{pod}}][adTimeType]" id="AdAdTimeType">
										{{#if isSeconds}}
											<option value="s" selected>Seconds</option>
										{{else}}
											<option value="s">Seconds</option>
										{{/if}}
										{{#if isPercentage}}
											<option value="%" selected>Percentage</option>
										{{else}}
											<option value="%">Percentage</option>
										{{/if}}
									</select>
								</div>
							</div>
						{{/if}}

						{{#if isOverlay}}
							<div id="overlay-{{iterator}}-settings" class="ad-box-midroll">
								<div>Start At:</div>
								<div style="margin-left: 20px;">
									<input type="text" id="AdOverlayStartAt-{{pod}}" name="{{modelName}}[ads][{{adSlot}}][{{pod}}][overlayStartAt]" value="{{overlayStartAt}}" style='width:60px;height:22px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;' />
								</div>
								<div style="margin-left: 20px;">Duration: </div>
								<div style="margin-left: 20px;">
									<input type="text" id="AdOverlayDuration-{{pod}}" name="{{modelName}}[ads][{{adSlot}}][{{pod}}][overlayDuration]" value="{{overlayDuration}}" style='width:60px;height:22px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;' />
								</div>
							</div>
						{{/if}}

						<!-- chozen fields should be in separate DIVS -->
						<div>
							<label style="font-size:13px;">
								<i class="fa fa-mobile" aria-hidden="true"></i> Desktop &amp; Mobile Ad Tags
							</label>

							{{#if isBanner}}
								<select id="ads-list-{{adSlot}}-mobile-{{pod}}-{{product}}" name="{{modelName}}[ads][{{adSlot}}][{{pod}}][mobile][id][]" data-placeholder="Select or add new ad tags" style="width:100%;" multiple class="chzn-select-adtag chzn-sortable chzn-select-adtag-{{product}}">
									<option value="0" class="add-new-ad-tag ignore-click">ADD NEW AD TAG</option>
									<?php foreach ($adTags as $k => $adtag) { ?>
										<?php if ($adtag['Adtag']['type'] == 'banner') { ?>
											<option value="<?php echo $adtag['Adtag']['id']; ?>"><?php echo $adtag['Adtag']['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							{{else}}

								<select id="ads-list-{{adSlot}}-mobile-{{pod}}-{{product}}" name="{{modelName}}[ads][{{adSlot}}][{{pod}}][mobile][id][]" data-placeholder="Select or add new ad tags" style="width:100%;" multiple class="chzn-select-adtag chzn-sortable chzn-select-adtag-{{product}}">

									<option value="0" class="add-new-ad-tag ignore-click">ADD NEW AD TAG</option>
									{{#if isPlayer}}
										<?php foreach ($adTags as $k => $adtag) { ?>

											<?php if ($adtag['Adtag']['type'] == 'player') { ?>
												<option value="<?php echo $adtag['Adtag']['id']; ?>"><?php echo $adtag['Adtag']['name']; ?></option>
											<?php } ?>
										<?php } ?>
									{{else}}
										<?php foreach ($adTags as $k => $adtag) { ?>

											<?php if ($adtag['Adtag']['type'] == 'outstream') { ?>
												<option value="<?php echo $adtag['Adtag']['id']; ?>"><?php echo $adtag['Adtag']['name']; ?></option>
											<?php } ?>
										<?php } ?>
									{{/if}}
								</select>

							{{/if}}

						</div>
						{{#if renderDesktopAdtags}}
							<div>
								<label style="font-size:13px;"><i class="fa fa-desktop" aria-hidden="true" style="margin-top: 10px;"></i> Desktop-only Ad Tags</label>
								{{#if isBanner}}
									<select id="ads-list-{{adSlot}}-desktop-{{pod}}-{{product}}" name="{{modelName}}[ads][{{adSlot}}][{{pod}}][desktop][id][]" data-placeholder="Select or add new ad tags" style="max-width:100%;min-width:500px;" multiple class="chzn-select-adtag chzn-sortable chzn-select-adtag-{{product}}">
										<option value="0" class="add-new-ad-tag ignore-click">ADD NEW AD TAG</option>
										<?php foreach ($adTags as $k => $adtag) { ?>
											<?php if ($adtag['Adtag']['type'] == 'banner') { ?>
												<option value="<?php echo $adtag['Adtag']['id']; ?>"><?php echo $adtag['Adtag']['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								{{else}}

									<select id="ads-list-{{adSlot}}-desktop-{{pod}}-{{product}}" name="{{modelName}}[ads][{{adSlot}}][{{pod}}][desktop][id][]" data-placeholder="Select or add new ad tags" style="max-width:100%;min-width:500px;" multiple class="chzn-select-adtag chzn-sortable chzn-select-adtag-{{product}}">

										<option value="0" class="add-new-ad-tag ignore-click">ADD NEW AD TAG</option>
										{{#if isPlayer}}
											<?php foreach ($adTags as $k => $adtag) { ?>
												<?php if ($adtag['Adtag']['type'] == 'player') { ?>
													<option value="<?php echo $adtag['Adtag']['id']; ?>"><?php echo $adtag['Adtag']['name']; ?></option>
												<?php } ?>
											<?php } ?>
										{{else}}
											<?php foreach ($adTags as $k => $adtag) { ?>

												<?php if ($adtag['Adtag']['type'] == 'outstream') { ?>
													<option value="<?php echo $adtag['Adtag']['id']; ?>"><?php echo $adtag['Adtag']['name']; ?></option>
												<?php } ?>
											<?php } ?>
										{{/if}}
									</select>

								{{/if}}
								{{#if isBanner}}
									<!--			no prebid for banners				-->
								{{else}}
									<div class="prebid_tag_data">
										<label style="font-weight: bold;"><i class="fa fa-object-group"></i> PREBID SETUP</label>
										<input type="hidden" name="Adbid[{{adSlot}}][{{pod}}][id]" id="Adbid{{adSlot}}{{pod}}Id">
										<input type="hidden" name="Adbid[{{adSlot}}][{{pod}}][adType]" id="Adbid{{adSlot}}{{pod}}AdType">
										<input type="hidden" name="{{modelName}}[ads][{{adSlot}}][{{pod}}][pod]" id="Adbid{{adSlot}}{{pod}}AdType" value="{{pod}}">
										<div class="prebid_full" style="padding-top: 2rem; padding-left: 2rem;">
											<div class="prebid_iu" style="padding-bottom: 1rem; padding-left: 2rem;">
												<div>
													DFP ad unit ID
												</div>
												<div>
													<div>
														<input name="Adbid[{{adSlot}}][{{pod}}][iu]" style="width: 100%" maxlength="128" type="text" id="Adbid{{adSlot}}{{pod}}Iu">
													</div>
												</div>
											</div>

											<div class="prebid_custom_params" style="padding-bottom: 1rem; padding-left: 2rem;">
												<div>
													Custom Params
												</div>
												<div>
													<textarea name="Adbid[{{adSlot}}][{{pod}}][custom_params]" style="height:60px; width: 100%;" class="prebid_custom_params" id="Adbid{{adSlot}}{{pod}}CustomParams"></textarea>
												</div>
											</div>

											<div class="prebid_media_types" style="padding-bottom: 1rem; padding-left: 2rem;">
												<div>
													Video mediaTypes
												</div>
												<div class="small-7 columns text-right">
													<textarea name="Adbid[{{adSlot}}][{{pod}}][media_types]" style="height:40px; width: 100%;" class="prebid_media_types" id="Adbid{{adSlot}}{{pod}}MediaTypes"></textarea>
												</div>
											</div>

											<div class="prebid_bids" style="padding-bottom: 1rem; padding-left: 2rem;">
												<div>
													Bids
												</div>
												<div class="small-7 columns text-right">
													<textarea name="Adbid[{{adSlot}}][{{pod}}][bids]" style="height:160px; width: 100%;" class="prebid_bids" id="Adbid{{adSlot}}{{pod}}Bids"></textarea>
												</div>
											</div>

										</div>

										<div class="prebid_code" style="display:none;">
											<div>
												<div>
													AdUnit Code
												</div>
												<div style="padding-bottom: 1rem; padding-left: 2rem;">
													<div class="input text">
														<input name="Adbid[{{adSlot}}][{{pod}}][adcode]" style="text-align: right; width: 100%;" maxlength="64" type="text" id="Adbid{{adSlot}}{{pod}}Adcode">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="a9_tag_data">
										<label style="font-weight: bold;"><i class="fa fa-object-group"></i> AMAZON BIDDING SETUP</label>

										<div class="a9_full" style="padding-top: 2rem; padding-left: 2rem;">
											<div class="prebid_a9_slot_id" style="padding-bottom: 1rem; padding-left: 2rem;">
												<div>
													Slot ID
												</div>
												<div>
													<div>
														<input name="Adbid[{{adSlot}}][{{pod}}][a9_slot_id]" style="width: 100%" maxlength="128" type="text" id="Adbid{{adSlot}}{{pod}}a9_slot_id">
													</div>
												</div>
											</div>
											<div class="prebid_a9_vast_tag" style="padding-bottom: 1rem; padding-left: 2rem;">
												<div>
													VAST Tag
												</div>
												<div>
													<div>
														<input name="Adbid[{{adSlot}}][{{pod}}][a9_vast_tag]" style="width: 100%" maxlength="128" type="text" id="Adbid{{adSlot}}{{pod}}a9_vast_tag">
													</div>
												</div>
											</div>
										</div>
									</div>
								{{/if}}
								<div style="padding-bottom:12px;margin-left:2px;margin-top: 10px;font: 12px Arial; color: #939598;">
									<div>
										<div style="color: red;">*</div> These AdTags will be forced to play on Desktop. If left empty "Destop & Mobile Ad Tags" will be used for both Mobile & Desktop devices.
									</div>
								</div>
							</div>
						{{/if}}
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<div id="brid-upgrade" style="display:none">
	<div class="brid-upgrade" style="text-align:center" id="brid-upgrade-{{id}}">
		<img class="s6" src="//<?php echo CDN_STATIC; ?>/img/upgrade/{{img}}.svg" style="width:170px">
		<p style="text-align:left">{{text}}</p>
		<a href="https://cms.brid.tv/users/login/?redirect=order" target="_blank" class="button button-primary"><i class="fa fa-arrow-up icon-yellow" aria-hidden="true"></i> UPGRADE NOW</a>
	</div>
</div>