<script>
	var brid_callbacks = [];
</script>
<?php
$unlimited = '<span class="nolimit" title="Unlimited">&infin;</span>';

$plan = $user['Plan'];

// prebid fix
foreach ($players as $key => $player) {
	if (!$player['Player']['prebid_enabled']) {
		$players[$key]['Player']['bid_platform'] = 0;
	}
}
?>
<div class="brid-wp-content">

	<script>
		var siteNum = <?php echo count($sites); ?>;
	</script>

	<?php if (empty($sites)) { ?>

		<div style="margin-top:20px;">
			<p><?php _e('No sites, please visit our'); ?> <a href="https://target-video.com/" target="_blank">CMS</a> <?php _e('and add website'); ?>.</p>
			<p><?php _e('Please'); ?> <a href="#" class="unauthorizeBrid" style="color:#000; font-size:14px;"><?php _e('Unauthorize account'); ?></a> <?php _e('and try again'); ?></p>

		</div>
		<script>
			//Used in callback on save -> partnerCreateSnapshot
			var settingsUrl = "<?php echo admin_url('options-general.php?page=brid-video-config'); ?>"
		</script>

	<?php } else { ?>

		<div id="settings_header_wrapper">
			<?php require_once('overage_notice.php'); ?>
			<div id="logo">
				<div id="clickLogo" title="Go to Target-Video.com"></div>
				<div></div>
			</div>

			<?php if (!$premium) : ?>
				<div class="upgrade">
					<a href="<?php echo "https://cms.target-video.com/users/login/?redirect=order"; ?>" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="74px" height="18px" viewBox="0 0 74 18" enable-background="new 0 0 74 18" xml:space="preserve">
							<g>
								<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="9" x2="74" y2="9">
									<stop offset="0" stop-color="#FF3B00" />
									<stop offset="1" stop-color="#FF2A5E" />
								</linearGradient>
								<path fill="url(#SVGID_1_)" d="M74 12.7c0 2.9-2.4 5.3-5.4 5.3H5.4c-3 0-5.4-2.4-5.4-5.3V5.3C0 2.4 2.4 0 5.4 0h63.2c3 0 5.4 2.4 5.4 5.3V12.7z" />
								<g>
									<path fill="#FFFFFF" d="M22.6 4.1v5.1c0 1.9 0.9 2.7 2 2.7 1.3 0 2.1-0.8 2.1-2.7V4.1h1.1v5c0 2.6-1.4 3.7-3.3 3.7 -1.8 0-3.1-1-3.1-3.7v-5H22.6z" />
									<path fill="#FFFFFF" d="M29.8 8.6c0-0.8 0-1.4-0.1-2h1l0.1 1.1h0c0.5-0.8 1.2-1.2 2.2-1.2 1.5 0 2.7 1.3 2.7 3.1 0 2.2-1.4 3.3-2.8 3.3 -0.8 0-1.6-0.4-1.9-1h0v3.3h-1.1V8.6zM30.9 10.2c0 0.2 0 0.3 0.1 0.5 0.2 0.8 0.9 1.3 1.7 1.3 1.2 0 1.9-1 1.9-2.4 0-1.2-0.7-2.3-1.9-2.3 -0.8 0-1.5 0.5-1.7 1.4 0 0.1-0.1 0.3-0.1 0.5V10.2z" />
									<path fill="#FFFFFF" d="M42.6 6.6c0 0.4-0.1 0.9-0.1 1.7v3.6c0 1.4-0.3 2.3-0.9 2.8 -0.6 0.6-1.5 0.7-2.3 0.7 -0.8 0-1.6-0.2-2.1-0.5l0.3-0.9c0.4 0.3 1.1 0.5 1.8 0.5 1.2 0 2-0.6 2-2.1v-0.7h0c-0.3 0.6-1 1-2 1 -1.6 0-2.7-1.3-2.7-3 0-2.1 1.4-3.3 2.8-3.3 1.1 0 1.7 0.6 2 1.1h0l0.1-0.9H42.6zM41.4 9c0-0.2 0-0.4-0.1-0.5 -0.2-0.6-0.8-1.2-1.6-1.2 -1.1 0-1.9 0.9-1.9 2.3 0 1.2 0.6 2.2 1.8 2.2 0.7 0 1.3-0.4 1.6-1.1 0.1-0.2 0.1-0.4 0.1-0.6V9z" />
									<path fill="#FFFFFF" d="M44.3 8.5c0-0.7 0-1.3-0.1-1.9h1l0 1.2h0.1c0.3-0.8 1-1.3 1.7-1.3 0.1 0 0.2 0 0.3 0v1.1c-0.1 0-0.2 0-0.4 0 -0.8 0-1.4 0.6-1.5 1.4 0 0.2-0.1 0.3-0.1 0.5v3.3h-1.1V8.5z" />
									<path fill="#FFFFFF" d="M52 12.7l-0.1-0.8h0c-0.3 0.5-1 0.9-1.9 0.9 -1.3 0-1.9-0.9-1.9-1.8 0-1.5 1.3-2.3 3.8-2.3V8.7c0-0.5-0.1-1.4-1.4-1.4 -0.6 0-1.2 0.2-1.6 0.5L48.5 7c0.5-0.3 1.3-0.5 2.1-0.5 1.9 0 2.4 1.3 2.4 2.5v2.3c0 0.5 0 1.1 0.1 1.5H52zM51.8 9.6c-1.2 0-2.7 0.2-2.7 1.4 0 0.7 0.5 1.1 1.1 1.1 0.8 0 1.3-0.5 1.5-1 0-0.1 0.1-0.2 0.1-0.4V9.6z" />
									<path fill="#FFFFFF" d="M60.1 3.7v7.4c0 0.5 0 1.2 0.1 1.6h-1l-0.1-1.1h0c-0.3 0.7-1.1 1.2-2.1 1.2 -1.5 0-2.7-1.3-2.7-3.1 0-2 1.3-3.3 2.8-3.3 1 0 1.6 0.4 1.9 0.9h0V3.7H60.1zM59 9.1c0-0.1 0-0.3-0.1-0.5 -0.2-0.7-0.8-1.3-1.6-1.3 -1.2 0-1.9 1-1.9 2.4 0 1.2 0.6 2.3 1.9 2.3 0.8 0 1.5-0.5 1.7-1.3 0-0.2 0.1-0.3 0.1-0.5V9.1z" />
									<path fill="#FFFFFF" d="M62.7 9.8c0 1.5 1 2.1 2.1 2.1 0.8 0 1.3-0.1 1.7-0.3l0.2 0.8c-0.4 0.2-1.1 0.4-2.1 0.4 -1.9 0-3.1-1.2-3.1-3.1 0-1.9 1.1-3.3 2.9-3.3 2 0 2.6 1.8 2.6 2.9 0 0.2 0 0.4 0 0.5H62.7zM66 9c0-0.7-0.3-1.8-1.6-1.8 -1.2 0-1.7 1-1.7 1.8H66z" />
								</g>
								<path fill="#FFFFFF" d="M17.3 9.7c-0.1 0-0.2 0-0.3-0.1l-5.2-5.1L6.5 9.6c-0.2 0.2-0.4 0.2-0.6 0C5.8 9.5 5.8 9.2 5.9 9l5.5-5.4c0.2-0.2 0.4-0.2 0.6 0L17.6 9c0.2 0.2 0.2 0.4 0 0.6C17.5 9.7 17.4 9.7 17.3 9.7z" />
								<path fill="#FFFFFF" d="M6.2 13.7c-0.1 0-0.2 0-0.3-0.1 -0.2-0.2-0.2-0.4 0-0.6l5.5-5.4c0.2-0.2 0.4-0.2 0.6 0l5.5 5.4c0.2 0.2 0.2 0.4 0 0.6 -0.2 0.2-0.4 0.2-0.6 0l-5.2-5.1 -5.2 5.1C6.4 13.7 6.3 13.7 6.2 13.7z" />
							</g>
						</svg>
					</a>
				</div>
			<?php endif; ?>


		</div> <!-- #settings_header_wrapper -->


		<!-- Check Curl -->
		<?php if (!function_exists('curl_version')) : ?>
			<div class="mainWrapper" style="width:75%;">
				<p class="bridNotice">
					<img src="<?php echo BRID_PLUGIN_URL . '/img/warn.png'; ?>" style="position: relative; top: 1px; margin-right: 5px;" alt="Warning" /> <?php _e('Your webserver is not properly configured to use the Brid plugin. Please install/enable cURL on your server before proceeding'); ?>.

				</p>
			</div>
		<?php endif; ?>


		<!-- Start tabs -->
		<div class="brid-tabs">
			<ul class="wp-tab-bar">
				<li class="wp-tab-active"><a href="#tabs-1" id="tab-settings"><?php _e('Settings'); ?></a></li>
				<?php if ($user['group_id'] != 11) { ?>
					<li><a href="#tabs-2" id="tab-player"><?php _e('Players'); ?></a></li>

					<li><a href="#tabs-3" id="tab-unit"><?php _e('Outstream units'); ?></a></li>

					<li><a href="#tabs-4" id="tab-carousel"><?php _e('Video carousels'); ?></a></li>
				<?php } ?>
			</ul>
			<div class="wp-tab-panel" id="tabs-1">
				<form method="post" action="admin.php?page=brid-video-config" id="bridSettingsForm">
					<?php settings_fields('brid_options');
					?>
					<input type="hidden" name="brid_options[oauth_token]" value="<?php echo $oAuthToken; ?>" />
					<input type="hidden" name="brid_options[user_id]" value="<?php echo $user_id; ?>" />
					<input type="hidden" id="width" name="brid_options[width]" value="<?php echo $width; ?>" />
					<input type="hidden" id="height" name="brid_options[height]" value="<?php echo $height; ?>" />
					<input type="hidden" id="autoplay" name="brid_options[autoplay]" value="<?php echo $autoplay; ?>" />
					<input type="hidden" id="PartnerId" name="Partner[id]" value="<?php echo $partnerId; ?>" />
					<div class="brid-table" id="settings-table">
						<!--General  -->
						<div style="width:500px;float:left">
							<h3 class="brid-section-title"><i class="fa fa-cog player-icon" aria-hidden="true"></i> <?php _e('GENERAL'); ?></h3>
							<table style="width:auto">
								<tr>
									<td style="width:500px"><?php _e('Choose site'); ?></td>
									<td style="width:200px">
										<div id="siteList">
											<select id="sites" name="brid_options[site]" class="chzn-select" style="width:200px;">
												<?php
												if (!empty($sites)) {

													foreach ($sites as $k => $v) {
														$s = '';
														if ($k == $partnerId) {
															$s = 'SELECTED';
														}
														echo '<option value="' . $k . '" ' . $s . '>' . $v . '</option>';
													}
												}
												?>
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2" class="with-notice">
										<small class="brid-notice"><?php _e('All your content on TargetVideo platform will be managed under this site/account'); ?>.<br /> <?php _e('To add more sites, please'); ?> <a href="https://cms.target-video.com/" target="_blank"><?php _e('login to TargetVideo'); ?></a>.</small>
									</td>
								</tr>

								<input type="hidden" name="brid_options[default_channel]" value="18">

								<tr>
									<td><?php _e('Default Syndication Rule'); ?></td>
									<td>
										<div id="defaultExchangeRuleId">

											<select id="defaultExchangeRuleSelect" name="brid_options[default_exchange_rule]" class="chzn-select" style="width:200px;">
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
										<?php _e('Default snapshot url'); ?><br />
										<input type="hidden" name="thumbnail" id="VideoThumbnail">

										<input placeholder="Snapshot URL" data-info="Provide URL to the snapshot image" type="text" id="VideoImage" name="brid_options[video_image]" value="<?php echo $video_image; ?>">

										<div class="button brid-browse-media-library" data-field="VideoImage" data-uploader_button_text="Add Snapshot" data-uploader_title="Browse from Media Library"><?php _e('BROWSE LIBRARY'); ?></div>
									</td>
								</tr>
								<?php if (($user["Plan"]["id"] != 25) && ($user["Plan"]["id"] != 1)) { ?>
									<tr>
										<td colspan="2">
											<?php _e('Enter player onReady callback method name'); ?><br />
											<input placeholder="Default method name" data-info="Provide a function name that will be called by the player onReady" type="text" id="OnReady" name="brid_options[onready]" value="<?php echo $onready; ?>">
										</td>
									</tr>
									<tr>
										<td colspan="2" class="with-notice">
											<small class="brid-notice"><?php _e('Use carefuly. All your players will call this function once ready and loaded'); ?>.<br /> <?php _e('Please read this link to learn more - '); ?> <a href="https://brid.zendesk.com/hc/en-us/articles/360026462653" target="_blank"><?php _e('Learn More'); ?></a>.</small>
										</td>
									</tr>
								<?php } ?>

							</table>

							<!-- Widget settings -->
							<h3 class="brid-section-title" style="margin-top:20px;"><i class="fa fa-cog player-icon" aria-hidden="true"></i> <?php _e('WIDGET OPTIONS'); ?></h3>
							<!-- Widget shortcode options -->
							<div class="brid-sub-section" id="brid-subsection-options">
								<h4 class="brid-sub-section-title"><i class="fa fa-angle-double-right" aria-hidden="true"></i> SHORTCODE OPTIONS</h4>
								<table style="width:auto">
									<tr>
										<td colspan="2" class="with-notice">
											<small class="brid-notice"><?php _e('All your content on TargetVideo platform will be managed under this site/account'); ?>.<br /> <?php _e('To add more sites, please'); ?> <a href="https://cms.target-video.com/" target="_blank"><?php _e('login to TargetVideo'); ?></a>.</small>
										</td>
									</tr>
									<?php if ($wp_ver < 5) { ?>
										<tr>
											<td><?php _e('Replace default player with BridTv player'); ?></td>
											<td><?php BridForm::drawField('ovr_def', ['inputName' => 'brid_options[ovr_def]', 'type' => 'radio', 'label' => 'off']); ?></td>
										</tr>
									<?php } ?>

									<tr>
										<td><?php _e('Raw embed code'); ?></td>
										<td><?php BridForm::drawField('raw_embed', ['inputName' => 'brid_options[raw_embed]', 'type' => 'radio', 'label' => 'off']); ?></td>
									</tr>
									<tr>
										<td colspan="2" class="with-notice">
											<small class="brid-notice"><?php _e('Embed codes generated will be raw js embed codes instead of wp shortcodes'); ?>.</small>
										</td>
									</tr>

									<tr>
										<td><?php _e('Asynchronous embed code'); ?></td>
										<td><?php BridForm::drawField('async_embed', ['inputName' => 'brid_options[async_embed]', 'type' => 'radio', 'label' => 'off']); ?></td>
									</tr>
									<tr>
										<td colspan="2" class="with-notice">
											<small class="brid-notice"><?php _e('TargetVideo players will load asynchronously on your web pages'); ?>.</small>
										</td>
									</tr>

									<tr>
										<td><?php _e('Google Structured data'); ?></td>
										<td><?php BridForm::drawField('google_seo', ['inputName' => 'brid_options[google_seo]', 'type' => 'radio', 'label' => 'off']); ?></td>
									</tr>
									<tr>
										<td colspan="2" class="with-notice">
											<small class="brid-notice"><?php _e('Include Google structured data in your embed codes'); ?>.</small>
										</td>
									</tr>

									<tr>
										<td style="width:500px"><?php _e('Disable shortcode if video is not encoded'); ?></td>
										<td style="width:200px">
											<div id="siteList">
												<select id="disable_shortcode" name="brid_options[disable_shortcode]" class="chzn-select" style="width:200px;">
													<?php
													foreach ($disable_shortcode_selectbox as $k => $v) {
														$s = '';
														if ($k == $disable_shortcode) {
															$s = 'SELECTED';
														}
														echo '<option value="' . $k . '" ' . $s . '>' . $v . '</option>';
													}
													?>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="2" class="with-notice">
											<small class="brid-notice"><?php _e('Button "Copy Shortcode" will be disabled untill video is done encoding'); ?>.</small>
										</td>
									</tr>
								</table>
							</div>

							<!-- Widget display options -->
							<div class="brid-sub-section brid-widget-display-section" id="brid-subsection-options">
								<h4 class="brid-sub-section-title">
									<i class="fa fa-angle-double-right" aria-hidden="true"></i> DISPLAY OPTIONS &nbsp;
									<span class="brid-notice permission-required" style="display:none;"><i>Permission required</i></span>
								</h4>
								<div class="brid-section-content">
									<div class="<?php echo ($permissions['upload'] == 0) ? 'brid-input-disabled brid-notice' : ''; ?>">
										<?php BridForm::drawField('hide_upload_video', ['inputName' => 'brid_options[hide_upload_video]', 'type' => 'radio', 'label' => 'Hide "Upload Video" Tab']); ?>
									</div>

									<div class="<?php echo ($permissions['disable_external_url'] == 1) ? 'brid-input-disabled brid-notice' : ''; ?>">
										<?php BridForm::drawField('hide_add_video', ['inputName' => 'brid_options[hide_add_video]', 'type' => 'radio', 'label' => 'Hide "Add Video" Tab']); ?>
									</div>

									<div class="<?php echo ($permissions['youtube'] == 0) ? 'brid-input-disabled brid-notice' : ''; ?>">
										<?php BridForm::drawField('hide_yt_video', ['inputName' => 'brid_options[hide_yt_video]', 'type' => 'radio', 'label' => 'Hide "Add Youtube" Tab']); ?>
									</div>

									<div class="">
										<?php BridForm::drawField('hide_manage_playlist', ['inputName' => 'brid_options[hide_manage_playlist]', 'type' => 'radio', 'label' => 'Hide "Manage playlists" Tab']); ?>
									</div>

									<div class="<?php echo ($permissions['outstream'] == 0) ? 'brid-input-disabled brid-notice' : ''; ?>">
										<?php BridForm::drawField('hide_manage_outstream', ['inputName' => 'brid_options[hide_manage_outstream]', 'type' => 'radio', 'label' => 'Hide "Manage outstream units" Tab']); ?>
									</div>

									<div class="<?php echo ($permissions['carousel'] == 0) ? 'brid-input-disabled brid-notice' : ''; ?>">
										<?php BridForm::drawField('hide_manage_carousels', ['inputName' => 'brid_options[hide_manage_carousels]', 'type' => 'radio', 'label' => 'Hide "Manage carousels" Tab']); ?>
									</div>
								</div>
							</div>
						</div>

						<!-- Account -->
						<?php if ($user['owner']) { ?>
							<div style="width:500px;padding-left:50px;float:left">

								<h3 class="brid-section-title"><i class="fa fa-user player-icon" aria-hidden="true"></i> TARGET-VIDEO <?php _e('ACCOUNT'); ?></h3>
								<table style="width:100%">
									<tr>
										<td><?php _e('Plan'); ?></td>
										<td style="text-align: right;"><?php echo $user["Plan"]['name'] ?> (<?php echo BridForm::file_size(round($user["Plan"]['bandwidth'], 2)) ?>)</td>
									</tr>
									<tr>
										<td><?php _e('Storage'); ?></td>
										<td style="text-align: right;">
											<?php

											if ($user["Plan"]['bandwidth'] != '') {
												echo  BridForm::file_size($user['storage'] / (1024 * 1024 * 1024));


											?> / <?php echo $user["Plan"]['free'] == true ?  'None' : $unlimited;
												} else {
													echo 'None';
												}
													?>
										</td>
									</tr>
									<?php if ($plan['charge_by']['bandwidth'] && isset($user['plan_overage']) && $user['plan_overage'] > 0) { ?>
										<tr>
											<td>Bandwidth / Limit / <span class="error-color">Overage</span></td>
											<td style="text-align: right;">
												<?php
												if ($plan['bandwidth'] != '' && $plan['bandwidth']) {
													echo  BridForm::file_size(abs(($user['plan_usage_monthly'])));
												} else {
													echo 'None';
												}

												?> /

												<?php if ($plan['bandwidth']) {
													echo  BridForm::file_size(abs(($plan['bandwidth'])));
												} else {
													echo 'None';
												}
												?>

												<span class="error-color">
													<?php
													echo '(' . BridForm::file_size(abs(($user['plan_overage']))) . ')';
													?></span>
											</td>
										</tr>
									<?php } else { ?>
										<tr>
											<td>Bandwidth / Limit</td>
											<td style="text-align: right;">
												<?php
												if ($plan['bandwidth'] != '' && $plan['bandwidth']) {
													echo  BridForm::file_size(abs(($user['plan_usage_monthly'])));
												} else {
													echo 'None';
												}
												?> /
												<?php if ($plan['bandwidth']) {
													echo  BridForm::file_size(abs(($plan['bandwidth'])));
												} else {
													echo 'None';
												}
												?>
											</td>
										</tr>
									<?php } ?>

									<?php if ($plan['charge_by']['player_ad_impressions'] && $plan['ad_impressions'] != 0 && isset($user['player_ad_impressions_overage']) && $user['player_ad_impressions_overage'] > 0) { ?>
										<tr>
											<td>Player ad imp. / Limit / <span class="error-color">Overage</span></td>
											<td style="text-align: right;">
												<?php
												if ($plan['ad_impressions'] != '') {
													echo BridForm::numberFormat($user['player_ad_impressions']); ?> / <?php echo $plan['ad_impressions'] != 0 ? BridForm::numberFormat($plan['ad_impressions']) : $unlimited ?> /
													<span class="error-color">
														<?php
														echo '(' . BridForm::numberFormat($user['player_ad_impressions_overage']) . ')';
														?></span><?php
																} else {

																	echo 'None';
																}

																	?>
											</td>
										</tr>
									<?php } else { ?>
										<tr>
											<td>Player ad imp. / Limit</td>
											<td style="text-align: right;">
												<?php
												if ($user['player_ad_impressions'] != '') {
													echo BridForm::numberFormat($user['player_ad_impressions'] + $user['player_ad_impressions_overage']); ?> / <?php echo $plan['ad_impressions'] != 0 ? BridForm::numberFormat($plan['ad_impressions']) : $unlimited;
																																							} else {
																																								echo 'None';
																																							}

																																								?>
											</td>
										</tr>
									<?php } ?>

									<?php if ($plan['charge_by']['outstream_ad_impressions'] && $plan['outstream_ad_impressions'] != 0 && isset($user['outstream_ad_impressions_overage']) && $user['outstream_ad_impressions_overage'] > 0) { ?>
										<tr>
											<td>Outstream ad imp. / Limit / <span class="error-color">Overage</span></td>
											<td style="text-align: right;">
												<?php
												if ($user['outstream_ad_impressions'] != '') {
													echo BridForm::numberFormat($user['outstream_ad_impressions']); ?> /
													<?php echo $plan['outstream_ad_impressions'] != 0 ? BridForm::numberFormat($plan['outstream_ad_impressions']) : $unlimited; ?> /
													<span class="error-color">
														<?php
														echo '(' . BridForm::numberFormat($user['outstream_ad_impressions_overage']) . ')';
														?></span><?php
																} else {
																	echo 'None';
																}

																	?>
											</td>
										</tr>
									<?php } else { ?>
										<tr>
											<td>Outstream ad imp. / Limit</td>
											<td style="text-align: right;">
												<?php
												if ($user['outstream_ad_impressions'] != '') {
													echo BridForm::numberFormat($user['outstream_ad_impressions'] + $user['outstream_ad_impressions_overage']); ?> / <?php echo $plan['outstream_ad_impressions'] != 0 ? BridForm::numberFormat($plan['outstream_ad_impressions']) : $unlimited;
																																									} else {
																																										echo 'None';
																																									}

																																										?>
											</td>
										</tr>
									<?php } ?>

									<?php if ($plan['charge_by']['ad_requests'] && $plan['ad_requests'] != 0 && isset($user['ad_requests']) && $user['ad_requests_overage'] > 0) { ?>
										<tr>
											<td>Ad req. used / Limit / <span class="error-color">Overage</span></td>
											<td style="text-align: right;">
												<?php
												if ($plan['ad_requests'] != '') {
													echo BridForm::numberFormat($user['ad_requests']); ?> / <?php echo $plan['ad_requests'] != 0 ? BridForm::numberFormat($plan['ad_requests']) : $unlimited; ?>
													<span class="error-color">
														<?php echo '(' . BridForm::numberFormat($user['ad_requests_overage']) . ')'; ?>
													</span><?php
														} else {

															echo 'None';
														}

															?>
											</td>
										</tr>
									<?php } else { ?>
										<tr>
											<td>Ad req. used / Limit</td>
											<td style="text-align: right;">
												<?php
												if ($user['ad_requests'] != '') {
													echo BridForm::numberFormat($user['ad_requests'] + $user['ad_requests_overage']); ?> / <?php echo $plan['ad_requests'] != 0 ? BridForm::numberFormat($plan['ad_requests']) : $unlimited;
																																		} else {

																																			echo 'None';
																																		}

																																			?>
											</td>
										</tr>
									<?php } ?>

									<?php if (isset($plan['charge_by']['player_banner_impressions']) && $plan['charge_by']['player_banner_impressions'] == 1) : ?>
										<tr>
											<td class="<?php echo ($user['player_banner_impressions'] >= $plan['player_banner_impressions'] && $plan['player_banner_impressions'] != 0) ? 'error-color' : ''; ?>">Player Banners used / Limit</td>
											<td class="<?php echo ($user['player_banner_impressions'] >= $plan['player_banner_impressions'] && $plan['player_banner_impressions'] != 0) ? 'error-color' : ''; ?>" style="text-align: right;">
												<?php
												if ($plan['player_banner_impressions'] != '') {
													echo BridForm::numberFormat($user['player_banner_impressions'] + $user['player_banner_impressions_overage']); ?> / <?php echo  $plan['player_banner_impressions'] != 0 ? BridForm::numberFormat($plan['player_banner_impressions']) : $unlimited;
																																									} else {
																																										echo 'None';
																																									}
																																										?>
											</td>
										</tr>
									<?php endif; ?>
									<?php if (isset($plan['charge_by']['outstream_banner_impressions']) && $plan['charge_by']['outstream_banner_impressions'] == 1) : ?>
										<tr>
											<td class="<?php echo ($user['outstream_banner_impressions'] >= $plan['outstream_banner_impressions'] && $plan['outstream_banner_impressions'] != 0) ? 'error-color' : ''; ?>">Outstream Banners used / Limit</td>
											<td class="<?php echo ($user['outstream_banner_impressions'] >= $plan['outstream_banner_impressions'] && $plan['outstream_banner_impressions'] != 0) ? 'error-color' : ''; ?>" style="text-align: right;">
												<?php
												if ($plan['outstream_banner_impressions'] != '') {
													echo BridForm::numberFormat($user['outstream_banner_impressions'] + $user['outstream_banner_impressions_overage']); ?> / <?php echo  $plan['outstream_banner_impressions'] != 0 ? BridForm::numberFormat($plan['outstream_banner_impressions']) : $unlimited;
																																											} else {
																																												echo 'None';
																																											}
																																												?>
											</td>
										</tr>
									<?php endif; ?>
									<tr>
										<td class="<?php echo ($user['video_plays'] >= $plan['video_plays'] && $plan['video_plays'] != 0) ? 'error-color' : ''; ?>">Video plays used / Limit</td>
										<td class="<?php echo ($user['video_plays'] >= $plan['video_plays'] && $plan['video_plays'] != 0) ? 'error-color' : ''; ?>" style="text-align: right;">
											<?php
											if ($plan['video_plays'] != '') {
												echo BridForm::numberFormat($user['video_plays'] + $user['video_plays_overage']); ?> / <?php echo $plan['video_plays'] != 0 ? BridForm::numberFormat($plan['video_plays']) : $unlimited;
																																	} else {
																																		echo 'None';
																																	}
																																		?>
										</td>
									</tr>
									<tr>
										<td class="<?php echo ($user['encoding'] >= $plan['encoding'] && $plan['encoding'] != 0) ? 'error-color' : ''; ?>">Encoding used / Limit</td>
										<td class="<?php echo ($user['encoding'] >= $plan['encoding'] && $plan['encoding'] != 0) ? 'error-color' : ''; ?>" style="text-align: right;">
											<?php
											if ($plan['encoding'] != '') {
												echo round(($user['encoding'] + $user['encoding_overage']) / 60, 2) . ' min.'; ?> / <?php echo $plan['encoding'] != 0 ? round(($plan['encoding'] / 60), 2) . ' min.' : $unlimited;
																																} else {
																																	echo 'None';
																																}
																																	?>
										</td>
									</tr>
								</table>
							</div>
						<?php } ?>
						<div style="width:99%;float:left">
							<input type="submit" name="submit" id="save-settings" class="button button-primary  brid-save-button" value="Save Changes">
						</div>

						<div class="propagate">
							<div><?php _e('Please allow up to 3 minutes for changes to propagate'); ?>.</div>
							<?php if (!empty($user)) { ?>
								<a href="#" class="unauthorizeBrid"><?php _e('Unauthorize account'); ?> (<?php echo $user['username']; ?>)</a>
							<?php } ?>
						</div>

					</div><!-- End settings-table -->
				</form><!-- End settings-from -->
			</div><!-- End tab 1 -->
			<div class="wp-tab-panel" id="tabs-2" style="display: none;">
				<div class="mainWrapper" style="width:100%; float:left;">
					<form method="post" action="admin.php?page=brid-video-config" id="brid-player-form">
						<input type="hidden" name="action" value="update_player">
						<!-- Player list start -->
						<div class="brid-table with-hover" id="player-list">
							<table>
								<?php foreach ($players as $k => $v) {

								?>
									<tr>
										<td>
											<a href="#" class="brid-player-edit" data-player="<?php echo htmlspecialchars(json_encode($v), ENT_QUOTES, 'UTF-8'); ?>"><?php echo $v['Player']['name']; ?></a><br />
											<small>Size: <?php echo $v['Player']['width']; ?> x <?php echo $v['Player']['height']; ?>
												<?php if (!empty($v['Ad'])) {
													foreach ($v['Ad'] as $key => $val) {
														echo '<div class="small-ad-badge small-' . $adTypes[$val['adType']] . '">' . $adTypes[$val['adType']] . '</div>';
													}
												} ?>
											</small>
										</td>
										<td width="20%">
											<?php if ($v['Player']['id'] == $playerSelected) { ?>

												<a href="#" class="set-as-default-player default" data-model="player" data-id="<?php echo $v['Player']['id']; ?>">Default</a>

											<?php } else { ?>

												<a href="#" class="set-as-default-player" data-model="player" data-id="<?php echo $v['Player']['id']; ?>">Set as WP default</a>

											<?php } ?>
										</td>
									</tr>
								<?php } ?>
							</table>
						</div>
						<!-- Player list end -->

						<div class="brid-form" style="display:none" id="player-edit-form">

							<div class="brid-form-left">
								<!-- Edit player form start -->
								<?php BridForm::drawForm('Player', $descriptors); ?>
								<!-- Edit player form end -->
							</div>

							<?php if ($permissions['ad_schedule'] == 0) : ?>
								<div class="brid-form-right">
									<?php require_once('help_monetize.php'); ?>
									<div class="add-ad-container">
										<div class="add-ad" data-type="preroll">
											<div class="bridButton add-preroll-ad" id="add-preroll-ad">
												<div class="buttonLargeContent add-ad-box" data-product="player" data-model="player" data-pod="0" data-type="preroll" id="add-preroll-button">PRE-ROLL</div>
											</div>
										</div>

										<div class="add-ad" id="add-ad-midroll" data-type="midroll">
											<div class="bridButton add-midroll-ad" id="add-midroll-ad">
												<div class="buttonLargeContent add-ad-box" data-product="player" data-model="player" data-pod="0" data-type="midroll" id="add-midroll-button">MID-ROLL</div>
											</div>
										</div>

										<div class="add-ad" data-type="overlay">
											<div class="bridButton add-overlay-ad" id="add-overlay-ad">
												<div class="buttonLargeContent add-ad-box" data-product="player" data-model="player" data-pod="0" data-type="overlay" id="add-overlay-button">OVERLAY</div>
											</div>
										</div>

										<div class="add-ad" data-type="postroll">
											<div class="bridButton add-postroll-ad" id="add-postroll-ad">
												<div class="buttonLargeContent add-ad-box" data-product="player" data-model="player" data-pod="0" data-type="postroll" id="add-postroll-button">POSTROLL</div>
											</div>
										</div>

										<div class="add-ad" data-type="banner">
											<div class="bridButton add-banner-ad" id="add-banner-ad">
												<div class="buttonLargeContent add-ad-box" data-product="banner" data-model="player" data-pod="0" data-type="banner" id="add-banner-button">300x250 BANNER</div>
											</div>
										</div>

									</div>

									<!-- Content div for ads -->
									<div id="brid-boxes-content-player"></div>
								</div>
							<?php endif; ?>

						</div>
						<!-- Save player -->
						<div style="width:100%; float:left;">
							<input type="submit" name="submit" id="save-player" class="button button-primary brid-save-button" value="Save Changes" style="display:none">
						</div>
					</form>
				</div>
			</div><!-- End players tab -->
			<div class="wp-tab-panel" id="tabs-3" style="display: none;">
				<div class="mainWrapper" style="width:100%; float:left;">

					<!-- Outstream list start -->
					<div class="brid-table with-hover" id="unit-list">
						<?php if (!empty($units)) { ?>
							<table>
								<?php foreach ($units as $k => $v) {

								?>
									<tr>
										<td>
											<a href="#" class="brid-unit-edit" data-unit="<?php echo htmlspecialchars(json_encode($v), ENT_QUOTES, 'UTF-8'); ?>"><?php echo $v['Unit']['name']; ?></a><br />
											<small>Size: <?php echo $v['Unit']['width']; ?> x <?php echo $v['Unit']['height']; ?>
												<?php if (!empty($v['Ad'])) {
													foreach ($v['Ad'] as $key => $val) {
														echo '<div class="small-ad-badge small-' . $adTypes[$val['adType']] . '">' . $adTypes[$val['adType']] . '</div>';
													}
												} ?>
											</small>
										</td>
										<td width="20%">
											<?php if ($v['Unit']['id'] == $unitSelected) { ?>

												<a class="set-as-default-unit default" data-model="unit" data-id="<?php echo $v['Unit']['id']; ?>"><?php _e('Default'); ?></a>

											<?php } else { ?>

												<a href="#" class="set-as-default-unit" data-model="unit" data-id="<?php echo $v['Unit']['id']; ?>"><?php _e('Set as WP default'); ?></a>

											<?php } ?>
										</td>
									</tr>
								<?php } ?>
							</table>
						<?php } else { ?>

							<div style="display:inline-block;width:100%;margin-bottom:2em">
								<div style="display:inline-block;width: 70%;float: left;">
									<h1><?php _e('IN CONTENT'); ?></h1>


									<p><?php _e('The BRID.TV In-Content outstream unit is an innovative format which positions video advertising within the heart of editorial content. Viewable by design, the format launches when in view on the screen, pausing when less than 50% visible and merging seamlessly back into the page once the view has been completed. It has capabilities to run across all devices, browsers and operating systems without any limitations'); ?>.</p>
									<h4><?php _e('MAIN FEATURES'); ?></h4>
									<p><?php _e('Places video ads within the heart of editorial content Opens up greater levels of premium video inventory Viewable by design on any screen, any device, anywhere Only loads if ad exists, therefore will not disrupt user experience'); ?></p>
									<p><a href="https://cms.brid.tv/users/login/?redirect=order" target="_blank" class="button button-primary"><i class="fa fa-arrow-up icon-yellow" aria-hidden="true"></i> <?php _e('UPGRADE NOW'); ?></a></p>
								</div>
								<div style="display:inline-block;width: 30%;float: left;">
									<img src="//<?php echo CDN_STATIC; ?>/img/upgrade/In-Content_final.gif" style="width: 90%;padding-left: 2em;padding-top: 1.5em;">
								</div>
							</div>
							<div style="display:inline-block;width:100%;margin-bottom:2em">
								<div style="display:inline-block;width: 70%;float: left;">
									<h1><?php _e('IN SLIDE'); ?></h1>
									<p><?php _e('The BRID.TV In-Slide outstream unit enters from a user-designated corner of a page and remains statically in view until the ad is completed. When the video ends, the player slides out of the page, returning the viewer to their browsing experience. It has capabilities to run across all devices, browsers and operating systems without any limitations'); ?>.</p>
									<h4><?php _e('MAIN FEATURES'); ?></h4>
									<p><?php _e('Opens up more premium video inventory Viewable by design on any screen, any device, anywhere Only loads if ad exists, therefore will not disrupt user experience'); ?></p>
									<p><a href="https://cms.brid.tv/users/login/?redirect=order" target="_blank" class="button button-primary"><i class="fa fa-arrow-up icon-yellow" aria-hidden="true"></i> <?php _e('UPGRADE NOW'); ?></a></p>
								</div>
								<div style="display:inline-block;width: 30%;float: left;">
									<img src="//<?php echo CDN_STATIC; ?>/img/upgrade/In-Slide_final.gif" style="width: 90%;padding-left: 2em;padding-top: 1.5em;">
								</div>
							</div>
							<div style="display:inline-block;width:100%">
								<div style="display:inline-block;width: 70%;float: left;">
									<h1><?php _e('IN VIDEO'); ?></h1>
									<p><?php _e('The BRID.TV In-Video outstream unit is a brand-new format to the market, opening up new monetization options for publishers. We will check to see if any video ad inventory is available. If not, we\'ll load your 300x250 banner tag on a timeout message, the duration of which is publisher-controlled. In this way you are greatly increasing the fill rate for your video ad inventory. It has capabilities to run across all devices, browsers and operating systems without any limitations'); ?>.</p>
									<h4><?php _e('MAIN FEATURES'); ?></h4>
									<p><?php _e('Adds possibility to additionally monetize without the need for VAST/VPAID ads Greatly helps your ad fill rate for video Only loads if ad exists therefore not disrupting user experience'); ?></p>
									<p><a href="https://cms.brid.tv/users/login/?redirect=order" target="_blank" class="button button-primary"><i class="fa fa-arrow-up icon-yellow" aria-hidden="true"></i> <?php _e('UPGRADE NOW'); ?></a></p>
								</div>
								<div style="display:inline-block;width: 30%;float: left;">
									<img src="//<?php echo CDN_STATIC; ?>/img/upgrade/In-Video_final.gif" style="width: 90%;padding-left: 2em;padding-top: 1.5em;">
								</div>
							</div>

						<?php } ?>
					</div>
					<!-- Outstream list end -->

					<form method="post" action="admin.php?page=brid-video-config" id="brid-unit-form">
						<input type="hidden" name="action" value="update_unit">

						<div class="brid-form" style="display:none" id="unit-edit-form">

							<div class="brid-form-left">
								<!-- Edit unit form start -->
								<?php BridForm::drawForm('Unit', $descriptors); ?>
								<!-- Edit unit form end -->

							</div>

							<?php if ($permissions['ad_schedule'] == 0) : ?>
								<div class="brid-form-right">
									<?php require('help_monetize.php'); ?>
									<div class="add-ad-container">
										<div class="add-ad" data-type="preroll">
											<div class="bridButton add-preroll-ad" id="add-preroll-ad">
												<div class="buttonLargeContent add-ad-box" data-product="unit" data-model="unit" data-type="preroll" data-pod="0" id="add-preroll-button">PRE-ROLL</div>
											</div>
										</div>

										<div class="add-ad" data-type="banner">
											<div class="bridButton add-banner-ad" id="add-banner-ad">
												<div class="buttonLargeContent add-ad-box" data-product="banner" data-model="unit" data-type="banner" data-pod="0" id="add-banner-button">DISPLAY BANNER | ANY-AD&trade;</div>
											</div>
										</div>

									</div>

									<!-- Content div for ads -->
									<div id="brid-boxes-content-unit"></div>
								</div>
							<?php endif; ?>



						</div>

						<!-- Save unit -->
						<div style="width:100%; float:left;">
							<input type="submit" name="submit" id="save-unit" class="button button-primary brid-save-button" value="Save Changes" style="display:none">
						</div>

					</form>
				</div>
			</div><!-- End unit tab -->
			<div class="wp-tab-panel" id="tabs-4" style="display: none;">
				<div class="mainWrapper" style="width:100%; float:left;">
					<!-- Carousel list start -->
					<div class="brid-table with-hover" id="carousel-list">
						<?php if ($permissions['carousel']) : ?>
							<button class="button-primary" type="button" id="add-carousel-slides">Create carousel from custom urls</button>
							<button class="button-primary" type="button" id="add-carousel-rss">Create carousel from rss feed</button>
						<?php else : ?>
							<a href="<?= CMS_ROOT_URL ?>/users/upgrade/<?= $user_id ?>" target="_blank" class="button radius" data-reveal-id="myModal" style="margin-top: 25px;margin-left: 40px; position: absolute;"> <i class="fa fa-arrow-up icon-yellow" aria-hidden="true"></i> UPGRADE NOW</a>
						<?php endif; ?>
						<div style="width: 100%; height: 1rem;"></div>
						<?php if (!empty($carousels)) { ?>
							<table>
								<?php foreach ($carousels as $k => $v) { ?>
									<tr>
										<td>
											<a href="#" class="brid-carousel-edit" data-carousel="<?php echo htmlspecialchars(json_encode($v), ENT_QUOTES, 'UTF-8'); ?>"><?php echo $v['Carousel']['name']; ?></a><br />
											<small>Synced: <?php echo empty($v['Carousel']['lastSync']) ? 'never' : $v['Carousel']['lastSync']; ?></small>
										</td>
										<td width="20%">
											<?php echo !isset($v['Carousel']['status']) ? 'not available' : $carousel_statuses[$v['Carousel']['status']]; ?>
										</td>
									</tr>
								<?php } ?>
							</table>
						<?php } else { ?>
							<div id="CAROUSEL-content" class="tab-content border" style="display:block; padding-top:0px;">
								<div class="row collapse" style=" margin-bottom: 30px;padding:1em;">
									<div class="small-6 columns" style="padding:2em;">
										<p class="text-left p-desc">
											Easily monetize existing content and engage readers with immersive video formats.
										</p>
										<p class="text-left p-desc">
											Turn existing articles into high impact video formats that drive reader engagement, increase page views, and create new revenue streams.
										</p>
										<div style="font-size: 14px;color: #4a4a4a;font-style: italic;font-family: Arial;">
											<h4>FEATURES:</h4>
											<p class="text-left p-desc">
											<ul style="font-size: 14px;">
												<li>Use an RSS feed or custom URL's to build your video carousel.</li>
												<li>Set specific durations for your slides.</li>
												<li>Set up custom click-through URL's for your video slides.</li>
												<li>Set up automatic sync options so your videos get refreshed with new content automatically.</li>
												<li>Add a custom "Read More" button to the bottom of the unit as a call to action button.</li>
											</ul>
											</p>
										</div>
									</div>
									<div class="small-6 columns" style="padding:2em;">
										<img src="//<?php echo CDN_STATIC; ?>/img/upgrade/carousel_description.jpg">
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<!-- Carousel list end -->
					<form method="post" action="admin.php?page=brid-video-config" id="brid-carousel-form">
						<input type="hidden" name="action" value="update_carousel">
						<input type="hidden" name="partner_id" value="<?php echo $partnerId; ?>">
						<div class="brid-form" style="display:none" id="carousel-edit-form">
							<div class="add-slide-container" style="display:none">
								<input type="input" name="url" id="carousel-slide-url" placeholder="url">
								<input type="input" name="new_custom_slide_img" id="carousel-slide-new_custom_slide_img" placeholder="image url">
								<button type="button" name="slide" class="button button-primary brid-save-button carousel-add-slide">Add slide</button>
							</div>
							<div class="brid-form-" style="width: 62%;">
								<!-- Edit carousel form start -->
								<?php BridForm::drawForm('Carousel', $descriptors); ?>
								<!-- Edit carousel form end -->
							</div>
						</div>
						<!-- Save/resync carousel -->
						<div style="width:100%; float:left;">
							<input type="submit" name="submit" id="save-carousel" class="button button-primary brid-save-button" value="Save Changes" style="display:none">
						</div>
					</form>
				</div>
			</div><!-- End carousel tab -->
		</div>
		<!-- End tabs -->
		<script>
			if (jQuery(".brid-widget-display-section").find(".brid-input-disabled.brid-notice").length > 0) {
				jQuery(".permission-required").show();
			}
			var partnerData = <?php echo json_encode($partnerData); ?>;
			var permissions = <?php echo json_encode($permissions); ?>;
			var file_frame = null;
			var adTypes = ['preroll', 'midroll', 'postroll', 'overlay', 'banner'];
			debug.log("permissions", permissions);
			for (var i in permissions) {
				permissions[i] = parseInt(permissions[i]);
			}
			jQuery('.brid-tooltip-click').on('click', function(e) {

				jQuery(this).pointer({
					content: jQuery(this).data('tooltip'),
					position: 'left',
					close: function() {
						// This function is fired when you click the close button
					}
				}).pointer('open');
			})

			function populateSettingsForm() {
				// Widget Shortcode options
				var ovr_def = <?php echo (int)$ovr_def ? 1 : 0; ?>;
				var async_embed = <?php echo (int)$async_embed ? 1 : 0; ?>;
				var google_seo = <?php echo (int)$google_seo ? 1 : 0; ?>;
				var raw_embed = <?php echo (int)$raw_embed ? 1 : 0; ?>;
				var disable_shortcode = <?php echo (int)$disable_shortcode ? 1 : 0; ?>;

				jQuery("input.brid-ovr_def[value='" + ovr_def + "']").prop("checked", true);
				jQuery("input.brid-async_embed[value='" + async_embed + "']").prop("checked", true);
				jQuery("input.brid-google_seo[value='" + google_seo + "']").prop("checked", true);
				jQuery("input.brid-raw_embed[value='" + raw_embed + "']").prop("checked", true);
				jQuery("input.brid-disable_shortcode[value='" + disable_shortcode + "']").prop("checked", true);

				// Widget Display Options
				var hide_upload_video = <?php echo (int)$hide_upload_video ? 1 : 0; ?>;
				var hide_add_video = <?php echo (int)$hide_add_video ? 1 : 0; ?>;
				var hide_yt_video = <?php echo (int)$hide_yt_video ? 1 : 0; ?>;
				var hide_manage_playlist = <?php echo (int)$hide_manage_playlist ? 1 : 0; ?>;
				var hide_manage_outstream = <?php echo (int)$hide_manage_outstream ? 1 : 0; ?>;
				var hide_manage_carousels = <?php echo (int)$hide_manage_carousels ? 1 : 0; ?>;

				jQuery("input.brid-hide_upload_video[value='" + hide_upload_video + "']").prop("checked", true);
				jQuery("input.brid-hide_add_video[value='" + hide_add_video + "']").prop("checked", true);
				jQuery("input.brid-hide_yt_video[value='" + hide_yt_video + "']").prop("checked", true);
				jQuery("input.brid-hide_manage_playlist[value='" + hide_manage_playlist + "']").prop("checked", true);
				jQuery("input.brid-hide_manage_outstream[value='" + hide_manage_outstream + "']").prop("checked", true);
				jQuery("input.brid-hide_manage_carousels[value='" + hide_manage_carousels + "']").prop("checked", true);
			}
			populateSettingsForm();



			var BridToggle = {
				'Unit': {
					placeholderImg: function() {
						if (jQuery("#brid-unit-form select[name='Unit[placeholder_type]']").val() == "custom") {
							jQuery('#brid-unit-form .brid-input-item-placeholder_img').show();

						} else {
							jQuery('#brid-unit-form .brid-input-item-placeholder_img').hide();
						}
					},
					makeOutstreamSticky: function() {

						if (jQuery("#brid-unit-form input[name='Unit[slide_inview]']:checked").val() == "0") {

							jQuery('#brid-unit-form .brid-make-outstream-sticky-options').hide();

						} else {

							jQuery('#brid-unit-form .brid-input-item-inpage_mobile_clicktoplay').addClass('brid-input-disabled');

							jQuery('#brid-unit-form .brid-make-outstream-sticky-options').show();
						}
					},
					closeButtonSeconds: function() {
						if (jQuery("#brid-unit-form input[name='Unit[enable_close_button]']:checked").val() == "0") {

							jQuery('#brid-unit-form .brid-input-item-slide_inview_seconds').hide();

						} else {

							jQuery('#brid-unit-form .brid-input-item-slide_inview_seconds').show();
						}
					},
					toggleAutoPlayInView: function() {
						if (jQuery("#brid-unit-form input[name='Unit[autoplayInview]']:checked").val() == "0") {

							jQuery('#brid-unit-form .brid-input-item-pauseAdOffView').addClass('brid-input-disabled');

						} else {
							jQuery('#brid-unit-form .brid-input-item-pauseAdOffView').removeClass('brid-input-disabled');
						}
					},
					togglePlaceholder: function() {
						if (jQuery("#brid-unit-form input[name='Unit[placeholder]']:checked").val() == "0") {

							jQuery('#brid-unit-form .brid-input-item-placeholder_type').hide();

							jQuery('#brid-unit-form .brid-input-item-placeholder_img').hide();

						} else {

							jQuery('#brid-unit-form .brid-input-item-placeholder_type').show();
							if (jQuery("#brid-unit-form select[name='Unit[placeholder_type]']").val() == "custom") {
								jQuery('#brid-unit-form .brid-input-item-placeholder_img').show();
							}
						}
					},
				},
				'Player': {
					autoplay: function() {
						if (jQuery("#brid-player-form input[name='Player[autoplay]']:checked").val() == "0") {

							jQuery('#brid-player-form .brid-input-item-force_muted, #brid-player-form .brid-input-item-autoplay_on_ad, #brid-player-form .brid-input-item-autoplay_desktop, #brid-player-form .brid-input-item-autoplayInviewPct, #brid-player-form .brid-input-item-autoplayInview').addClass('brid-input-disabled');

							if (jQuery("#brid-player-form input[name='Player[slide_inview]']:checked").val() == "0") {
								jQuery('#brid-player-form .brid-input-item-inpage_mobile_clicktoplay').removeClass('brid-input-disabled');
							}

						} else {
							jQuery("#brid-player-form input.brid-inpage_mobile_clicktoplay[value='1']").prop("checked", true);
							jQuery('#brid-player-form .brid-input-item-force_muted, #brid-player-form .brid-input-item-autoplay_on_ad, #brid-player-form .brid-input-item-autoplay_desktop, #brid-player-form .brid-input-item-autoplayInviewPct, #brid-player-form .brid-input-item-autoplayInview').removeClass('brid-input-disabled');
							//Force inpage_mobile_clicktopplay
							jQuery('#brid-player-form .brid-input-item-inpage_mobile_clicktoplay').addClass('brid-input-disabled');
							jQuery("#brid-player-form input.brid-inpage_mobile_clicktoplay[value='1']").prop("checked", true);

						}

					},
					monetize: function() {
						var a = jQuery('#brid-player-form .brid-input-item-parser').parent().parent();

						if (jQuery("#brid-player-form input[name='Player[monetize]']:checked").val() == "0") {

							a.addClass('brid-input-disabled');
							jQuery('.brid-form-right').addClass('brid-input-disabled');

						} else {
							a.removeClass('brid-input-disabled');
							jQuery('.brid-form-right').removeClass('brid-input-disabled');

						}
					},
					playlistPlayback: function() {

						if (jQuery("#brid-player-form input[name='Player[playlistPlayback]']:checked").val() == "stop") {
							jQuery('#brid-player-form .brid-input-item-afterPlaylistEnd').addClass('brid-input-disabled');

						} else {
							jQuery('#brid-player-form .brid-input-item-afterPlaylistEnd').removeClass('brid-input-disabled');
						}
					},
					showInviewSeconds: function() {
						if (jQuery("#brid-player-form select[name='Player[slide_inview_show]']").val() == "custom") {
							jQuery('#brid-player-form .brid-input-item-slide_inview_seconds').css('display', 'flex');

						} else {
							jQuery('#brid-player-form .brid-input-item-slide_inview_seconds').css('display', 'none');
						}
					},
					makePlayerSticky: function() {
						if (jQuery("#brid-player-form input[name='Player[slide_inview]']:checked").val() == "0") {

							jQuery('#brid-player-form .brid-make-player-sticky-options').hide();

							if (jQuery("#brid-player-form input[name='Player[autoplay]']:checked").val() == "0") {
								jQuery('#brid-player-form .brid-input-item-inpage_mobile_clicktoplay').removeClass('brid-input-disabled');
							}

						} else {

							jQuery('#brid-player-form .brid-input-item-inpage_mobile_clicktoplay').addClass('brid-input-disabled');
							jQuery("#brid-player-form input.brid-inpage_mobile_clicktoplay[value='1']").prop("checked", true);
							jQuery('#brid-player-form .brid-make-player-sticky-options').show();
						}

					}
				}
			};



			function populateForm(item, type) {
				//Populate input fields
				for (var field in item) {

					var inputType = jQuery("#brid-" + type + "-form input.brid-" + field).attr('type'); //+"[value='"+val+"']");

					switch (inputType) {
						case 'radio':

							if (typeof item[field] == 'boolean') {
								var val = item[field] ? 1 : 0;
							} else {
								var val = item[field];
							}

							jQuery("#brid-" + type + "-form input.brid-" + field + "[value='" + val + "']").prop("checked", true);
							break;
						case 'select':
							jQuery("#brid-" + type + "-form input.brid-" + field + "[value='" + val + "']").prop("checked", true);
							break;
						case 'input':
						case 'hidden':

							jQuery("#brid-" + type + "-form #brid-id-" + field).val(item[field]);

							break;
						default:
							jQuery("#brid-" + type + "-form #brid-id-" + field).val(item[field]);
							//jQuery("input.brid-"+field+"[value='"+val+"']").prop("checked",true);
					}
				}
			}

			function populateAdBox(p, model) {

				var adbox = jQuery('#brid-boxes-content-' + model);
				adbox.html('');

				if (p.Ad != undefined) {

					for (var i in p.Ad) {

						debug.log('Ad slot:', p.Ad[i]);

						var ad = p.Ad[i],
							template = Handlebars.compile(jQuery('#ad-box-template').html()),
							adSlot = adTypes[ad.adType];
						if (typeof ad.mobile === 'undefined') {
							ad.mobile = [
								[]
							];
						}

						for (var k = 0; k < ad.mobile.length; k++) {

							var isBanner = (adSlot == 'banner') ? true : false;

							var context = {
								//model : model,
								modelName: model.charAt(0).toUpperCase() + model.slice(1),
								renderDesktopAdtags: (adSlot == 'banner') ? true : true,
								isPlayer: (model == 'player') ? true : false,
								isBanner: isBanner,
								isOverlay: (adSlot == 'overlay') ? true : false,
								isMidroll: (adSlot == 'midroll') ? true : false,
								isSeconds: (ad.adTimeType == 's') ? true : false,
								isPercentage: (ad.adTimeType == '%') ? true : false,
								overlayDuration: ad.overlayDuration,
								cuepoints: ad.cuepoints,
								permissions: permissions,
								adTimeType: ad.adTimeType,
								overlayStartAt: ad.overlayStartAt,
								product: (adSlot == 'banner') ? 'banner' : model, //player,unit,banner
								adSlot: adSlot,
								pod: k,
								podTitle: (k + 1)
							};

							debug.log('INIT AD', context, 'AD:', ad);

							html = template(context);

							if (html) {
								adbox.append(html);
							}
							// now multiple pods can be added
							jQuery('#brid-' + model + '-form #add-' + adSlot + '-button').attr('data-pod', k + 1);

							//Set selected ad tags
							if (ad.mobile != undefined && ad.mobile[k] != undefined) {
								var cnt = ad.mobile[k].length - 1;
								for (var j = cnt; j >= 0; j--) {
									var opt = jQuery('#brid-' + model + '-form #ads-list-' + adSlot + '-mobile-' + k + '-' + context.product + ' [value=' + ad.mobile[k][j].id + ']'),
										text = opt.text();
									opt.remove();
									jQuery('#brid-' + model + '-form #ads-list-' + adSlot + '-mobile-' + k + '-' + context.product).children().first().after('<option value="' + ad.mobile[k][j].id + '" selected>' + text + '</option>')
								}

							}
							if (ad.desktop != undefined && ad.desktop[k] != undefined) {

								var cnt = ad.desktop[k].length - 1;

								for (var j = cnt; j >= 0; j--) {

									var opt = jQuery('#brid-' + model + '-form #ads-list-' + adSlot + '-desktop-' + k + '-' + context.product + ' [value=' + ad.desktop[k][j].id + ']'),
										text = opt.text();
									opt.remove();
									jQuery('#brid-' + model + '-form #ads-list-' + adSlot + '-desktop-' + k + '-' + context.product).children().first().after('<option value="' + ad.desktop[k][j].id + '" selected>' + text + '</option>')
								}
							}

							//populate bids

							//remove backslashes from multiple json_encoding the string
							const regex = /\\+"/gm;

							var modelName = model.charAt(0).toUpperCase() + model.slice(1);
							for (var l in p.Adbid) {
								if (p.Adbid[l]['id'] === p[modelName].ads[adSlot][k]['bid']) {
									var cst_params = p.Adbid[l]['custom_params'].replace(regex, "\"");
									var bds = p.Adbid[l]['bids'].replace(regex, "\"");
									var mTypes = p.Adbid[l]['media_types'].replace(regex, "\"");
									jQuery('#Adbid' + adSlot + k + 'Id', '#brid-' + model + '-form').val(p.Adbid[l]['id']);
									jQuery('#Adbid' + adSlot + k + 'AdType', '#brid-' + model + '-form').val(p.Adbid[l]['adType']);
									jQuery('#Adbid' + adSlot + k + 'Iu', '#brid-' + model + '-form').val(p.Adbid[l]['iu']);
									jQuery('#Adbid' + adSlot + k + 'CustomParams', '#brid-' + model + '-form').val(cst_params);
									jQuery('#Adbid' + adSlot + k + 'MediaTypes', '#brid-' + model + '-form').val(mTypes);
									jQuery('#Adbid' + adSlot + k + 'Bids', '#brid-' + model + '-form').val(bds);
									jQuery('#Adbid' + adSlot + k + 'Adcode', '#brid-' + model + '-form').val(p.Adbid[l]['adcode']);

									jQuery('#Adbid' + adSlot + k + 'a9_slot_id', '#brid-' + model + '-form').val(p.Adbid[l]['a9_slot_id']);
									jQuery('#Adbid' + adSlot + k + 'a9_vast_tag', '#brid-' + model + '-form').val(p.Adbid[l]['a9_vast_tag']);
								}
							}
						}
					}
					initAdboxRequirements();
				}
			}

			function removefromOrder(str) {
				var val = jQuery('#brid-id-bidder_order').val();
				jQuery('#brid-id-bidder_order').val(val.replace(str, ''));
				prebid_update_orderUI();
			}

			function addToOrder(str) {
				var val = jQuery('#brid-id-bidder_order').val();
				if (typeof val === "undefined") return;
				if (val.indexOf(str) > -1) return;
				jQuery('#brid-id-bidder_order').val(val + str);
				prebid_update_orderUI();
			}

			function prebidUi() {
				if (jQuery('.wp-tab-active a')[0].id === "tab-unit") {
					var prebid_on = jQuery('input[name=Unit\\[prebid_enabled\\]]:checked').val();
				} else {
					var prebid_on = jQuery('input[name=Player\\[prebid_enabled\\]]:checked').val();
				}
				if (prebid_on === '0') {
					jQuery('.brid-input-item-prebid_js_file').hide();
					jQuery('.brid-input-item-prebid_sellers_file').hide();

					jQuery('.brid-input-item-prebid_on_page').hide();

					jQuery('.prebid_tag_data').hide();

					jQuery('.prebid_iu').hide();
					jQuery('.prebid_custom_params').hide();
					jQuery('.prebid_media_types').hide();
					jQuery('.prebid_bids').hide();
					jQuery('.prebid_code').hide();
					jQuery('.prebid_code').hide();

					jQuery('.brid-input-item-prebid_global_config').hide();
					jQuery('.brid-input-item-prebid_bidder_settings').hide();
					jQuery('.brid-input-item-prebid_waterfall').hide();
					jQuery('.brid-input-item-prebid_nonstop').hide();

					removefromOrder('p');

				} else {
					jQuery('.brid-input-item-prebid_on_page').show();
					prebidOnSiteUI();

					jQuery('.prebid_tag_data').show();

					jQuery('.brid-input-item-prebid_global_config').show();
					jQuery('.brid-input-item-prebid_bidder_settings').show();
					jQuery('.brid-input-item-prebid_waterfall').show();
					jQuery('.brid-input-item-prebid_nonstop').show();

					addToOrder('p');
				}
			}

			function prebid_nonstopUI() {
				if (jQuery('.wp-tab-active a')[0].id === "tab-unit") {
					var prebid_nonstop = jQuery('input[name=Unit\\[prebid_nonstop\\]]:checked').val();
				} else {
					var prebid_nonstop = jQuery('input[name=Player\\[prebid_nonstop\\]]:checked').val();
				}

				if (prebid_nonstop === '0') {

				} else {
					jQuery('.brid-spotx_enabled0').click();
					jQuery('.brid-a9_enabled0').click();
				}

			}

			function amazonUI() {
				if (jQuery('.wp-tab-active a')[0].id === "tab-unit") {
					var amazon_on = jQuery('input[name=Unit\\[a9_enabled\\]]:checked').val();
				} else {
					var amazon_on = jQuery('input[name=Player\\[a9_enabled\\]]:checked').val();
				}

				if (amazon_on === '0') {
					jQuery('.brid-input-item-a9_pubid').hide();
					removefromOrder('a');
					jQuery('.a9_tag_data').hide();
				} else {
					jQuery('.brid-input-item-a9_pubid').show();
					addToOrder('a');
					jQuery('.a9_tag_data').show();
				}
			}

			function spotxUI() {
				if (jQuery('.wp-tab-active a')[0].id === "tab-unit") {
					var spotx_on = jQuery('input[name=Unit\\[spotx_enabled\\]]:checked').val();
				} else {
					var spotx_on = jQuery('input[name=Player\\[spotx_enabled\\]]:checked').val();
				}

				if (spotx_on === '0') {
					jQuery('.brid-input-item-spotx_floor_price').hide();
					jQuery('.brid-input-item-spotx_channel').hide();
					removefromOrder('s');
				} else {
					jQuery('.brid-input-item-spotx_floor_price').show();
					jQuery('.brid-input-item-spotx_channel').show();
					addToOrder('s');
				}
			}

			function prebid_update_orderUI() {
				if (jQuery('.wp-tab-active a')[0].id === "tab-unit") {
					var str = jQuery('#brid-unit-form input[name=Unit\\[bidder_order\\]]').val();
					var listElement = jQuery('#brid-unit-form .bidder_order_sortable');
				} else {
					var str = jQuery('#brid-player-form input[name=Player\\[bidder_order\\]]').val();
					var listElement = jQuery('#brid-player-form .bidder_order_sortable');
				}
				if (typeof str === "undefined") {
					str = "";
				}

				var settings = {
					p: {
						bidder: 'prebid',
						'name': 'Prebid'
					},
					s: {
						bidder: 'spotx',
						'name': 'SpotX'
					},
					a: {
						bidder: 'a9',
						'name': 'Amazon'
					}
				};
				listElement.html('');
				// var str = jQuery('#brid-id-bidder_order').val();
				console.log('%c bidder order:  ' + str, 'background: #000; color: #0f0; font-weight: bold;font-size: 12px');
				console.log(listElement);
				if (str.length == 0) {
					jQuery('.brid-input-item-bidder_order_sortable').hide();
				} else {
					jQuery('.brid-input-item-bidder_order_sortable').show();

					for (var i = 0; i < str.length; i++) {
						var bidder = settings[str.charAt(i)];
						listElement.append('<li data-bidder="' + bidder.bidder + '">' + bidder.name + '</li>');
					}
				}
			}

			function prebidOnSiteUI() {
				// bepending on what tab is active get prebid_on_page val
				if (jQuery('.wp-tab-active a')[0].id === "tab-unit") {
					var prebidOnPage = jQuery('input[name=Unit\\[prebid_on_page\\]]:checked').val();
				} else {
					var prebidOnPage = jQuery('input[name=Player\\[prebid_on_page\\]]:checked').val();
				}

				if (prebidOnPage === '0') {
					jQuery('.brid-input-item-prebid_js_file').show();
					jQuery('.brid-input-item-prebid_sellers_file').show();
					jQuery('.brid-input-item-prebid_global_config').show();
					jQuery('.brid-input-item-prebid_bidder_settings').show();
					jQuery('.brid-input-item-prebid_waterfall').show();
					jQuery('.brid-input-item-prebid_nonstop').show();

					jQuery('.prebid_iu').show();
					jQuery('.prebid_custom_params').show();
					jQuery('.prebid_media_types').show();
					jQuery('.prebid_bids').show();
					jQuery('.prebid_code').show();
					jQuery('.prebid_code').hide();
				} else {
					jQuery('.brid-input-item-prebid_js_file').hide();
					jQuery('.brid-input-item-prebid_sellers_file').hide();
					jQuery('.brid-input-item-prebid_global_config').hide();
					jQuery('.brid-input-item-prebid_bidder_settings').hide();
					jQuery('.brid-input-item-prebid_waterfall').hide();
					jQuery('.brid-input-item-prebid_nonstop').hide();

					jQuery('.prebid_iu').hide();
					jQuery('.prebid_custom_params').hide();
					jQuery('.prebid_media_types').hide();
					jQuery('.prebid_bids').hide();
					jQuery('.prebid_code').hide();
					jQuery('.prebid_code').show();
				}
			}

			function initBridEvents() {
				jQuery('.brid-event').each(function(k, v) {

					var data = jQuery(v).data('options');

					//debug.log('options', data)

					jQuery(v).find('input,select').off(data.e).on(data.e, function(e) {

						if (BridToggle[data.m][data.f] != undefined) {
							BridToggle[data.m][data.f].apply();
						}
					})

				});
			}

			function initUnitForm(u) {

				debug.log('Unit', u);

				var unit = u.Unit;

				initBridEvents();

				jQuery('#brid-unit-form .brid-input-item').show();
				jQuery('#brid-unit-form .brid-input-item-native_type').hide();
				jQuery('#brid-unit-form .brid-input-item-inslide_direction').hide();

				var placeholder = jQuery('#brid-unit-form .brid-input-item-placeholder').parent().parent();
				placeholder.show();
				debug.log("unit type", unit.type);

				switch (unit.type) {

					case "incontent":
						// jQuery('#brid-unit-form #add-banner-ad').hide();
						jQuery('#brid-unit-form .brid-input-item-inslide_direction').hide();
						break;
					case "invideo":
						jQuery('#brid-unit-form #add-banner-ad').hide();
						jQuery('#brid-unit-form #add-banner-ad').show();
						placeholder.show();
						break;
					case "inslide":
						// jQuery('#brid-unit-form #add-banner-ad').hide();
						jQuery('#brid-unit-form .brid-input-item-autoplayInviewPct').hide();
						jQuery('#brid-unit-form .brid-input-item-autoplayInview').hide();
						jQuery('#brid-unit-form .brid-input-item-pauseAdOffView').hide();
						jQuery('#brid-unit-form .brid-input-item-viewability').hide();
						jQuery('#brid-unit-form .brid-input-item-slide_inview').hide();
						jQuery('#brid-unit-form .brid-input-item-inslide_direction').show();
						placeholder.hide();
						break;
					case "native":
						jQuery('#brid-unit-form #add-banner-ad').hide();
						jQuery('#brid-unit-form #add-preroll-ad').hide();
						jQuery('#brid-unit-form .brid-input-item-native_type').show();
						jQuery('#brid-unit-form .brid-input-item-enable_close_button').hide();
						jQuery('#brid-unit-form #brid-section-monetization').hide();
						jQuery('#brid-unit-form #brid-section-_monetization').hide();
						placeholder.hide();
						break;
					default:
						jQuery('#brid-unit-form #add-banner-ad').show();
						jQuery('#brid-unit-form .brid-input-item-inslide_direction').hide();
						placeholder.hide();
						break;
				}

				populateForm(unit, 'unit');

				for (var ftion in BridToggle['Unit']) {

					debug.log('Execute', ftion);
					if (BridToggle['Unit'][ftion] != undefined) {
						BridToggle['Unit'][ftion].apply();
					}
				}

				populateAdBox(u, 'unit');

				jQuery('.brid-bid_platform').each((index, element) => {
					prebidUi();
					jQuery(element).change(prebidUi);
				});

				jQuery('.brid-prebid_on_page0').change(prebidOnSiteUI);
				jQuery('.brid-prebid_on_page1').change(prebidOnSiteUI);

				jQuery('.brid-prebid_enabled0').change(prebidUi);
				jQuery('.brid-prebid_enabled1').change(prebidUi);

				jQuery('.brid-a9_enabled0').change(amazonUI);
				jQuery('.brid-a9_enabled1').change(amazonUI);

				jQuery('.brid-spotx_enabled0').change(spotxUI);
				jQuery('.brid-spotx_enabled1').change(spotxUI);

				jQuery('.brid-prebid_nonstop0').change(prebid_nonstopUI);
				jQuery('.brid-prebid_nonstop1').change(prebid_nonstopUI);

				prebid_update_orderUI();
				prebidUi();
				amazonUI();
				spotxUI();

				// Unit Template
				jQuery("#unit-edit-form select[name='Unit[unit_template_id]']").val(unit.unit_template_id);

				if (unit.type == "incontent") {
					jQuery('#brid-unit-form .brid-input-item-unit_template_id_inslide').hide().find("select").attr("disabled", true);
					jQuery('#brid-unit-form .brid-input-item-unit_template_id_incontent').show().find("select").removeAttr("disabled");
				}
				if (unit.type == "inslide") {
					jQuery('#brid-unit-form .brid-input-item-unit_template_id_incontent').hide().find("select").attr("disabled", true);
					jQuery('#brid-unit-form .brid-input-item-unit_template_id_inslide').show().find("select").removeAttr("disabled");
				}

				// Show or hide fields, depend on is template selected or not
				jQuery(document).on("change", "#brid-unit-form select[name='Unit[unit_template_id]']", function(item) {
					// if (jQuery("#brid-id-player_template_id").length > 0 && player.player_template_id != null) {
					if (jQuery(this).val() != "") {
						jQuery("#brid-unit-form #brid-subsection-options").hide();
						jQuery("#brid-unit-form #brid-subsection-placeholder").hide();
						jQuery('#brid-unit-form div[id^="brid-subsection-controls"]').hide();
						jQuery("#brid-unit-form #brid-section-_monetization").hide();
						jQuery(".brid-form-right").hide();

					} else {
						jQuery("#brid-unit-form #brid-subsection-options").show();
						jQuery("#brid-unit-form #brid-subsection-placeholder").show();
						jQuery('#brid-unit-form div[id^="brid-subsection-controls"]').show();
						jQuery("#brid-unit-form #brid-section-_monetization").show();
						jQuery(".brid-form-right").show();
					}
				});

				// Init check is template selected or not
				jQuery("#brid-unit-form select[name='Unit[unit_template_id]']").trigger("change");



			}

			function updateSlideId(key, id, inputClass) {
				var InputName = jQuery('#slide-wrapper-' + key + inputClass).attr('name');
				if (InputName === undefined) return;
				var InputNameId = InputName.replace('SLIDE_ID', id);
				jQuery('#slide-wrapper-' + key + inputClass).attr('name', InputNameId);
			}

			function addSlide(carousel_id, partner_id) {
				var slideForm = jQuery(".slide-wrapper:hidden:first");
				var no = slideForm.attr('id').slice(-1);
				//slideForm.show();

				var slide_url = jQuery('#carousel-slide-url').val();
				var slide_custom_img = jQuery('#carousel-slide-new_custom_slide_img').val();
				jQuery.ajax({
					url: 'admin-ajax.php?action=carousel_parse_url',
					data: 'action=carousel_parse_url&Slide[url]=' + slide_url + '&Slide[custom_slide_img]=' + slide_custom_img,
					type: 'POST',
					success: function(data) {
						data.carousel_id = carousel_id;
						data.partner_id = partner_id;
						data.id = '';
						populateSlide(no, data, data, {
							[no - 1]: slide_url
						});
						jQuery('#carousel-slide-url').val('');
						jQuery('#carousel-slide-new_custom_slide_img').val('');
					},
					error: function() {
						debug.error("carousel parse url api call error");
					}
				});
			}

			function populateSlide(key, data, data_ent, urls) {
				jQuery('#slide-wrapper-' + key + ' .slide-info-img-' + key).attr('src', data_ent.img);

				updateSlideId(key, data.id, ' .slide-title input');
				jQuery('#slide-wrapper-' + key + ' .slide-title input').val(data.title);


				updateSlideId(key, data.id, ' .slide-click-through input');
				jQuery('#slide-wrapper-' + key + ' .slide-click-through input').val(data.url);

				updateSlideId(key, data.id, ' .slide-img input');
				jQuery('#slide-wrapper-' + key + ' .slide-img input').val(data_ent.img);
				jQuery('#slide-wrapper-' + key + ' .CarouselUrls' + key).val(urls[key - 1]);

				jQuery('#slide-wrapper-' + key + ' .slide-info-sorce-url a').html(data.url);
				jQuery('#slide-wrapper-' + key + ' .slide-info-sorce-url a').attr('href', data.url);

				jQuery('#slide-wrapper-' + key).show();
			}

			function populateCarouselSlides(carouselData, model) {
				if (typeof carouselData.slides === 'undefined') {
					debug.log('Seelcted carousel has no slides.');
					return;
				}

				for (var slidesKey in carouselData.slides) {
					populateSlide(parseInt(slidesKey) + 1, carouselData.slides[slidesKey], carouselData.slides_ent[slidesKey]['Slide'], carouselData.urls);
				}
			}

			function initiResyncButton() {
				var resyncButton = jQuery('.resync-carousel');
				if (resyncButton === undefined) return;
				var carouselId = resyncButton.attr('data-id');
				resyncButton.on('click touch', () => {
					jQuery('.carousel-resync-message').html('Requesting resync, please wait...');
					jQuery.ajax({
						url: 'admin-ajax.php?action=resync_carousel',
						data: 'action=resync_carousel&Carousel[id]=' + carouselId,
						type: 'POST',
						success: function(data) {
							console.log('success');
							console.log(data);
							jQuery('.carousel-resync-message').html('Carousel queued for processing. Please allow some time before your new video becomes available.');
						},
						error: function() {
							console.log('error');
							jQuery('.carousel-resync-message').html('Something whent wrong.');
						}
					});
				});
			}

			function initCarouselForm(carouselData) {
				debug.log('Carousel', carouselData);
				var carousel = carouselData.Carousel;
				initBridEvents();
				populateForm(carousel, 'carousel');
				if (carousel.mrssFeed === null) {
					jQuery('.brid-input-item-mrssFeed').hide();
					jQuery('.add-slide-container').show();

				} else {
					jQuery('.brid-input-item-mrssFeed').show();
					jQuery('.add-slide-container').hide();
				}
				populateCarouselSlides(carousel, 'carousel');
				jQuery('.resync-carousel').attr('data-id', carousel.id);
				initiResyncButton();
				jQuery('#brid-carousel-form input[name=action]').val('update_carousel');
				jQuery('.carousel-add-slide').click(function() {
					console.log('SLIDE!');
					var form = jQuery(this).parents('form:first');
					var carousel_id = jQuery("[name='Carousel[id]']", form).val();

					addSlide(carousel_id, jQuery('#PartnerId').val());
				});
			}

			function initAddCarouselButtons() {
				var prestineForm = jQuery('#brid-carousel-form').html();
				jQuery('#add-carousel-slides').click(function() {
					console.log('SLIDES!');

					var obj = {
						"Carousel": {
							"id": null,
							"partner_id": jQuery('#PartnerId').val(),
							"player_id": null,
							"name": "Carousel #<?= (isset($carousels[0]['Carousel']['id'])) ? ++$carousels[0]['Carousel']['id'] : '1' ?>",
							"controls": false,
							"clickablePlayer": false,
							"readMore": false,
							"prevNext": false,
							"slideTime": 5000,
							"mrssFeed": "",
							"refreshRate": "12hours",
							"tags": "",
						}
					}
					var v = 'carousel';
					jQuery('#brid-carousel-form').html(prestineForm);
					initCarouselForm(obj, v);

					jQuery('#brid-carousel-form input[name=action]').val('add_carousel');

					jQuery('#' + v + '-list').hide();
					jQuery('.brid-input-item-mrssFeed').hide();
					jQuery('.add-slide-container').show();
					jQuery('#' + v + '-edit-form').show();
					jQuery('#brid-section-resync').hide();
					jQuery('#save-' + v).show();

				});

				jQuery('#add-carousel-rss').click(function() {
					console.log('RSS!');

					var obj = {
						"Carousel": {
							"id": null,
							"partner_id": jQuery('#PartnerId').val(),
							"player_id": null,
							"name": "Carousel #<?= (isset($carousels[0]['Carousel']['id'])) ? ++$carousels[0]['Carousel']['id'] : '2' ?>",
							"controls": false,
							"clickablePlayer": false,
							"readMore": false,
							"prevNext": false,
							"slideTime": 5000,
							"mrssFeed": "",
							"refreshRate": "12hours",
							"tags": "",
						}
					}
					var v = 'carousel';
					jQuery('#brid-carousel-form').html(prestineForm);
					initCarouselForm(obj, v);

					jQuery('#brid-carousel-form input[name=action]').val('add_carousel');

					jQuery('#' + v + '-list').hide();
					jQuery('.brid-input-item-mrssFeed').show();
					jQuery('.add-slide-container').hide();
					jQuery('#' + v + '-edit-form').show();
					jQuery('#brid-section-resync').hide();
					jQuery('#save-' + v).show();
				});
			}

			function initPlayerForm(p) {

				debug.log('Player', p);

				var player = p.Player;

				initBridEvents();

				populateForm(player, 'player');

				jQuery('.brid-bid_platform').each((index, element) => {
					prebidUi();
					jQuery(element).change(prebidUi);
				});

				jQuery('.brid-prebid_on_page0').change(prebidOnSiteUI);
				jQuery('.brid-prebid_on_page1').change(prebidOnSiteUI);

				jQuery('.brid-prebid_enabled0').change(prebidUi);
				jQuery('.brid-prebid_enabled1').change(prebidUi);

				jQuery('.brid-a9_enabled0').change(amazonUI);
				jQuery('.brid-a9_enabled1').change(amazonUI);

				jQuery('.brid-spotx_enabled0').change(spotxUI);
				jQuery('.brid-spotx_enabled1').change(spotxUI);

				jQuery('.brid-prebid_nonstop0').change(prebid_nonstopUI);
				jQuery('.brid-prebid_nonstop1').change(prebid_nonstopUI);

				prebid_update_orderUI();
				prebidUi();
				amazonUI();
				spotxUI();

				for (var ftion in BridToggle['Player']) {
					if (BridToggle['Player'][ftion] != undefined) {
						BridToggle['Player'][ftion].apply();
					}
				}

				//Build ads
				resetAdButtons();
				populateAdBox(p, 'player');
				debug.log('ADS', p.Ad);

				// Player Template
				// Show or hide fields, depend on is template selected or not
				jQuery(document).on("change", "#brid-id-player_template_id", function(item) {
					// if (jQuery("#brid-id-player_template_id").length > 0 && player.player_template_id != null) {
					if (jQuery(this).val() != "") {
						jQuery("#player-edit-form #brid-subsection-options").hide();
						jQuery("#player-edit-form #brid-subsection-playback").hide();
						jQuery("#player-edit-form #brid-section-_monetization").hide();
						jQuery('#player-edit-form div[id^="brid-section-_colors_"]').hide();
						jQuery("#player-edit-form #brid-section-_social").hide();
						jQuery("#player-edit-form #brid-section-_plugins").hide();
						jQuery(".brid-form-right").hide();
					} else {
						jQuery("#player-edit-form #brid-subsection-options").show();
						jQuery("#player-edit-form #brid-subsection-playback").show();
						jQuery("#player-edit-form #brid-section-_monetization").show();
						jQuery('#player-edit-form div[id^="brid-section-_colors_"]').show();
						jQuery("#player-edit-form #brid-section-_social").show();
						jQuery("#player-edit-form #brid-section-_plugins").show();
						jQuery(".brid-form-right").show();
					}
				});

				// Init check is template selected or not
				jQuery("#brid-id-player_template_id").trigger("change");

			}

			function resetAdButtons() {
				jQuery('#add-preroll-button').attr('data-pod', 0);
				jQuery('#add-midroll-button').attr('data-pod', 0);
				jQuery('#add-postroll-button').attr('data-pod', 0);
				jQuery('#add-banner-button').attr('data-pod', 0);
			}

			function initAdboxRequirements() {

				setTimeout(function() {
					$Brid.Html.Adtags.destroy();
					$Brid.Html.Adtags.build(permissions.waterfall);
					//jQuery(".chzn-select-adtag").trigger('chosen:updated');

				}, 100);

				//Initi delete button for each slot
				initDeleteAdTagBox();
				jQuery('input[id$="OverlayStartAt"], input[id$="OverlayDuration"]').off('keypress').on('keypress', $Brid.Util.onlyNumbers);
				jQuery('#PlayerWidth, #PlayerHeight').off('keypress').on('keypress', $Brid.Util.onlyNumbers);
			}
			/** Populate upgrade divs */
			function createUpgradeBlock(data) {
				var template = Handlebars.compile(jQuery('#brid-upgrade').html());
				var html = template(data);
				return html;
			}
			//On ad button click
			jQuery('.add-ad-box').off('click').on('click', function(e) {

				if (!jQuery(this).hasClass('ad-disabled')) {

					var adSlot = jQuery(this).data('type');

					var type = jQuery(this).data('product');

					var model = jQuery(this).data('model');

					var pod = parseInt(jQuery(this).attr('data-pod'));

					if (adSlot == 'banner' && !permissions.banner) {

						$Brid.Util.openDialog('300x250 Banners are available for paid plans only. <a href="https://cms.brid.tv/users/login/?redirect=order" target="_blank">Upgrade now</a>', 'Plan limit reached');

						return false;
					}

					if (adSlot == 'banner' && pod >= 1) {
						$Brid.Util.openDialog('Only one banner is allowed.', 'Banner limit reached');
						return false;
					}

					var adType = adTypes.indexOf(adSlot); //int

					var template = Handlebars.compile(jQuery('#ad-box-template').html());

					var context = {
						//model : model, //Player, Unit
						modelName: model.charAt(0).toUpperCase() + model.slice(1),
						renderDesktopAdtags: (adSlot == 'banner') ? true : true,
						isPlayer: (model == 'player') ? true : false,
						isBanner: (adSlot == 'banner') ? true : false,
						isOverlay: (adSlot == 'overlay') ? true : false,
						isMidroll: (adSlot == 'midroll') ? true : false,
						isSeconds: true,
						isPercentage: false,
						overlayDuration: 0,
						cuepoints: 0,
						adTimeType: 's',
						overlayStartAt: 0,
						product: type,
						adSlot: adSlot, //ad slot type
						pod: pod,
						podTitle: (pod + 1)
					};

					debug.log('Context', context);

					html = template(context);

					var adbox = jQuery('#brid-boxes-content-' + model);
					//adbox.html('');

					if (html) {
						adbox.append(html);
					}

					initAdboxRequirements();

					var formId = jQuery(this).closest("form").attr('id');

					jQuery(this).attr('data-pod', (pod + 1));
				}

			})


			//Click on player title in player list to edit the player
			jQuery(['player', 'unit', 'carousel']).each(function(k, v) {
				var prestineForm = jQuery('#brid-carousel-form').html();
				jQuery('.brid-' + v + '-edit').on('click', function(e) {

					e.preventDefault();
					var obj = jQuery(this).data(v); //player or unit
					console.log(obj);
					if (v == 'player') {
						initPlayerForm(obj, v);
					} else if (v === 'unit') {
						//populate unit
						initUnitForm(obj, v);
					} else {
						//populate carousel
						jQuery('#brid-carousel-form').html(prestineForm);
						initCarouselForm(obj, v);
						jQuery('#brid-section-resync').show();
					}
					jQuery('#' + v + '-list').hide();
					jQuery('#' + v + '-edit-form').show();
					jQuery('#save-' + v).show();

				});

				//Toggle players list on Player tab
				jQuery('#tab-' + v).on('click.Brid', function(e) {
					jQuery('#save-' + v).hide();
					jQuery('.brid-form').hide();
					jQuery('#' + v + '-list').show();
					jQuery('.add-ad-box').removeClass('ad-disabled');
				});

			});


			//Init tabs
			jQuery(document).ready(function($) {

				//Apply brid callbacks
				for (var i in brid_callbacks) {
					brid_callbacks[i].apply(brid_callbacks);
				}

				jQuery('.wp-tab-bar a').click(function(event) {
					event.preventDefault();

					// Limit effect to the container element.
					var context = jQuery(this).closest('.wp-tab-bar').parent();
					jQuery('.wp-tab-bar li', context).removeClass('wp-tab-active');
					jQuery(this).closest('li').addClass('wp-tab-active');
					jQuery('.wp-tab-panel', context).hide();
					jQuery(jQuery(this).attr('href'), context).show();
				});

				// Make setting wp-tab-active optional.
				jQuery('.wp-tab-bar').each(function() {
					if (jQuery('.wp-tab-active', this).length)
						jQuery('.wp-tab-active', this).click();
					else
						jQuery('a', this).first().click();
				});

				jQuery('.set-as-default-player, .set-as-default-unit').on('click', function(e) {

					var _self = jQuery(this);
					e.preventDefault();
					var type = _self.data('model');
					var id = _self.data('id');


					if (!_self.hasClass('default')) {
						$Brid.Api.call({
							dataType: 'json',
							data: {
								action: "setBridProductDefault",
								"id": id,
								"type": type
							},
							//callback : { after : { name : "bridPlayerList"} }
							callback: {
								before: function() {

									jQuery('.set-as-default-' + type).removeClass('default');
									jQuery('.set-as-default-' + type).text('Set as WP default');
									_self.text('Default');
									_self.addClass('default');

								}
							}
						});
					}

				});
				initAddCarouselButtons();
			});
		</script>

		<?php require_once('adBox.php'); ?>

	<?php } ?>

</div>

<script type="text/javascript">
	initBridMain();

	jQuery('.unauthorizeBrid').on('click', function(e) {
		e.preventDefault();
		if (confirm("You will not be able to use the BridTv plugin anymore.\nAre you sure you want to unauthorize?")) {
			$Brid.Api.call({
				data: {
					action: "unauthorizeBrid"
				},
				callback: {
					after: function() {


						window.location = window.location;

					}
				}
			});
		}

	});

	jQuery("#sites").on("change", function() {
		var v = jQuery(this).val();
		jQuery('#PartnerId').val(v)
	});

	//Load first time

	jQuery('.bridBrowseLibary').on('click', function() {
		// If the media frame already exists, reopen it.
		if (file_frame) {
			file_frame.open();
			return;
		}

		var field = jQuery('#IntroVideo');

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

			if ($Brid.Util.checkExtension(attachment.url, $Brid.Util.allowedIntroUrlExtensions)) {
				field.val(attachment.url);

				field.parent().find('.errorMsg').remove();
				field.parent().removeClass('inputError');

			} else {
				alert('Invalid url extension. Video extension required:' + $Brid.Util.allowedIntroUrlExtensions.join(','));
			}

		});

		// Finally, open the modal
		file_frame.open();
	});

	jQuery('.bridBrowseLibary').on('click', function() {
		// If the media frame already exists, reopen it.
		if (file_frame) {
			file_frame.open();
			return;
		}

		var field = jQuery('#IntroVideo');

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

			if ($Brid.Util.checkExtension(attachment.url, $Brid.Util.allowedIntroUrlExtensions)) {
				field.val(attachment.url);

				field.parent().find('.errorMsg').remove();
				field.parent().removeClass('inputError');

			} else {
				alert('Invalid url extension. Video extension required:' + $Brid.Util.allowedIntroUrlExtensions.join(','));
			}


		});

		// Finally, open the modal
		file_frame.open();
	});
	jQuery('.bridBrowseLibaryImg, .brid-browse-media-library').on('click', function() {
		// If the media frame already exists, reopen it.
		if (file_frame) {
			file_frame.open();
			return;
		}

		var field = jQuery('#VideoImage');

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

			field.parent().find('.errorMsg').remove();
			field.parent().removeClass('inputError');

		});

		// Finally, open the modal
		file_frame.open();
	});

	// for defaultChannel and defaultSnapshot
	jQuery("#authPlugin").click(function() {

		var def = jQuery("#defaultChannelSelect").val();
		debug.log("def", def);
		jQuery("#defaultChannelHidden").val(def);

		var snap = jQuery("#VideoImage").val();
		jQuery("#videoImageHidden").val(snap);

	});

	//Delete ad slot box
	function initDeleteAdTagBox() {
		jQuery('.ad-box-remove-tag').off('click').on('click', function(e) {
			var type = jQuery(this).data('type');
			var pod = jQuery(this).attr('data-pod');
			jQuery('#bridad-box-container-' + type + '-' + pod).remove();

			jQuery('#add-' + type + '-button').removeClass('ad-disabled');
		});
	}
	<?php if (!empty($_GET['code'])) { ?>
		var url = window.location.href;
		url = url.slice(0, url.lastIndexOf('&'));
		url = url.slice(0, url.lastIndexOf('&'));
		window.history.pushState({
			brid: 'yes'
		}, 'Brid.tv plugin', url);
	<?php } ?>
</script>
<script src="//use.fontawesome.com/f8ff95fdc4.js" async></script>