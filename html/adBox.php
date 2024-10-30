<?php
$id = '';
$iterator = isset($iterator) ? $iterator : null;
$type = 'video';
$adTypesFlipped = array_flip($ad_types);

$api = new BridAPI();
$user = $api->userinfo(true);
$paid = $user->Plan->permissions->waterfall == 1 ? true : false;
$showMobileAddWatefall = $adObject->adTagUrlSec == "" ? true : false;
$showDesktopAddWatefall = $adObject->flashAdTagUrlSec == "" ? true : false;

?>
<div class="brid-box-container">
	<div id="brid-box-<?php echo $iterator; ?>" data-type="<?php echo $adType; ?>" data-iterator="<?php echo $iterator; ?>" class="brid-box-<?php echo $adType; ?>">
		<?php
		if ($adObject != null)
			$id = $adObject->id;

		$cuepointType = '';
		if ($adObject != null)
			$cuepointType = $adObject->adTimeType;
		$cuepointType = $cuepointType != '' ? $cuepointType : 's';
		if ($adObject != null) {

		?>
			<input type="hidden" id="AdId" name="Ad[<?php echo $iterator; ?>][id]" value="<?php echo $adObject->id; ?>" />
		<?php
		}
		?>
		<input type="hidden" id="AdAdType" name="Ad[<?php echo $iterator; ?>][adType]" value="<?php echo $adTypesFlipped[$adType]; ?>" />
		<div class="ad-type-header-row">
			<div class="ad-type-header-row-title"><?php echo $adType; ?></div>
			<div class="ad-type-header-row-delete brid-box-remove" data-iterator="<?php echo $iterator; ?>" id="brid-box-remove-<?php echo $iterator; ?>" data-id="<?php echo $id; ?>" data-type="<?php echo $adType; ?>">
				<img src="<?php echo BRID_PLUGIN_URL; ?>/img/delete_ad.png" />
			</div>
		</div>

		<?php if ($adType == 'midroll') : ?>
			<div id="midroll-<?php echo $iterator; ?>-settings" class="ad-box-midroll">
				<div id="1-<?php echo $iterator; ?>-start">Cuepoints</div>
				<div id="1-<?php echo $iterator; ?>-start-at" class="ad-box-midroll-input-div">
					<input type="text" id="AdCuepoints" placeholder="Comma separated values" name="Ad[<?php echo $iterator; ?>][cuepoints]" value="" style="width: 250px; height: 28px;" />
				</div>
				<div class="input select" style="margin-left: 20px;">
					<select name="Ad[<?php echo $iterator; ?>][adTimeType]" id="AdAdTimeType">
						<?php foreach ($midroll_type as $k => $v) {
							$selected = '';
							if ($v == $cuepointType) {
								$selected = 'selected="selected"';
							}
						?>
							<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>
						<?php
						} ?>
					</select>
				</div>
			</div>
		<?php endif; ?>

		<?php if ($adType == 'overlay') : ?>
			<div id="overlay-<?php echo $iterator; ?>-settings" class="ad-box-midroll">
				<div>Start At:</div>
				<div style="margin-left: 20px;">
					<input type="text" id="AdOverlayStartAt" name="Ad[<?php echo $iterator; ?>][overlayStartAt]" value="" style="width:60px;height:22px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;" />
				</div>
				<div style="margin-left: 20px;">Duration: </div>
				<div style="margin-left: 20px;">
					<input type="text" id="AdOverlayDuration" name="Ad[<?php echo $iterator; ?>][overlayDuration]" value="" style="width:60px;height:22px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;" />
				</div>
			</div>
		<?php endif; ?>

		<div style="border-bottom: 1px solid #dadadb;"></div>

		<!-- TABS -->
		<div style="padding: 10px;">
			<div id="tab-container-<?php echo $iterator; ?>" class="tab-container">
				<div id="mobile-<?php echo $iterator; ?>" class="ad-tab ad-tab-active" data-type="mobile">Desktop &amp; Mobile</div>
				<div id="desktop-<?php echo $iterator; ?>" class="ad-tab ad-tab-inactive" data-type="desktop">Desktop-only</div>
			</div>
		</div>

		<!-- MOBILE TAGS -->
		<div class="mobile-tags-<?php echo $iterator; ?>">

			<!-- PRIMARY TAG MOBILE -->
			<?php if ($paid) : ?>
				<div class="ad-waterfall-container">
					<div>Primary Ad Tag Url</div>
					<div id="AdTagSecondary-mobile-<?php echo $iterator; ?>-1" data-open="1" class="ad-waterfall">+ Add waterfall</div>
				</div>
			<?php else : ?>
				<div class="ad-waterfall-container" style="flex-direction: row-reverse;">
					<a href="<?php echo OAUTH_PROVIDER . "/users/login/?redirect=order"; ?>" target="_blank" class="ad-waterfall-link">Upgrade for ad waterfall</a>
				</div>
			<?php endif; ?>


			<div style="padding: 1px 10px 0 10px;">
				<input type="text" placeholder="Desktop & Mobile Ad Tag Url" id="AdAdTagUrl" name="Ad[<?php echo $iterator; ?>][adTagUrl]" value="" maxlength="1024" />
			</div>

			<div class="flashFalbackWarring msgAdBox">
				Provide an Ad Tag URL <a href="https://brid.zendesk.com/hc/en-us/articles/200294282" target="_blank">(VAST compatible)</a> from your advertising partner.
				<a href="https://brid.zendesk.com/hc/en-us/sections/200105421" target="_blank">Learn more</a>.
			</div>
			<!-- PRIMARY TAG MOBILE -->

			<?php if ($paid) : ?>

				<!-- SECONDARY TAG MOBILE -->
				<div class="ad-mobile-<?php echo $iterator; ?>-1 hide-ad-tag">
					<div class="ad-waterfall-container">
						<div>Secondary Ad Tag Url</div>
						<div>
							<div id="AdTagSecondary-mobile-<?php echo $iterator; ?>-2" data-open="2" class="ad-waterfall">+ Add waterfall</div>
							<div id="RemoveAdTagSecondary-mobile-<?php echo $iterator; ?>-1" data-close="1" class="ad-waterfall-remove">- Remove Ad Tag</div>
						</div>
					</div>

					<div style="padding: 1px 10px 0 10px;">
						<input type="text" placeholder="Desktop & Mobile Ad Tag Url" id="AdAdTagUrl-1" name="Ad[<?php echo $iterator; ?>][adTagUrlSec]" value="" maxlength="1024" />
					</div>

					<div class="flashFalbackWarring msgAdBox">
						Provide an Ad Tag URL <a href="https://brid.zendesk.com/hc/en-us/articles/200294282" target="_blank">(VAST compatible)</a> from your advertising partner.
						<a href="https://brid.zendesk.com/hc/en-us/sections/200105421" target="_blank">Learn more</a>.
					</div>
				</div>
				<!-- SECONDARY TAG MOBILE -->

				<!-- THIRD TAG MOBILE -->
				<div class="ad-mobile-<?php echo $iterator; ?>-2 hide-ad-tag">
					<div class="ad-waterfall-container">
						<div>Third Ad Tag Url</div>
						<div>
							<div id="AdTagSecondary-mobile-<?php echo $iterator; ?>-3" data-open="3" class="ad-waterfall">+ Add waterfall</div>
							<div id="RemoveAdTagSecondary-mobile-<?php echo $iterator; ?>-2" data-close="2" class="ad-waterfall-remove">- Remove Ad Tag</div>
						</div>
					</div>

					<div style="padding: 1px 10px 0 10px;">
						<input type="text" placeholder="Desktop & Mobile Ad Tag Url" id="AdAdTagUrl-2" name="Ad[<?php echo $iterator; ?>][adTagUrlThird]" value="" maxlength="1024" />
					</div>

					<div class="flashFalbackWarring msgAdBox">
						Provide an Ad Tag URL <a href="https://brid.zendesk.com/hc/en-us/articles/200294282" target="_blank">(VAST compatible)</a> from your advertising partner.
						<a href="https://brid.zendesk.com/hc/en-us/sections/200105421" target="_blank">Learn more</a>.
					</div>
				</div>
				<!-- THIRD TAG MOBILE -->

				<!-- FOURTH TAG MOBILE -->
				<div class="ad-mobile-<?php echo $iterator; ?>-3 hide-ad-tag">
					<div class="ad-waterfall-container">
						<div>Fourth Ad Tag Url</div>
						<div>
							<div id="RemoveAdTagSecondary-mobile-<?php echo $iterator; ?>-3" data-close="3" class="ad-waterfall-remove">- Remove Ad Tag</div>
						</div>
					</div>

					<div style="padding: 1px 10px 0 10px;">
						<input type="text" placeholder="Desktop & Mobile Ad Tag Url" id="AdAdTagUrl-3" name="Ad[<?php echo $iterator; ?>][adTagUrlFourth]" value="" maxlength="1024" />
					</div>

					<div class="flashFalbackWarring msgAdBox">
						Provide an Ad Tag URL <a href="https://brid.zendesk.com/hc/en-us/articles/200294282" target="_blank">(VAST compatible)</a> from your advertising partner.
						<a href="https://brid.zendesk.com/hc/en-us/sections/200105421" target="_blank">Learn more</a>.
					</div>
				</div>
				<!-- FOURTH TAG MOBILE -->

			<?php endif; ?>

		</div>
		<!-- MOBILE TAGS -->

		<!-- DESKTOP TAGS -->
		<div class="desktop-tags-<?php echo $iterator; ?>" style="display: none;">

			<!-- PRIMARY TAG DESKTOP -->
			<?php if ($paid) : ?>
				<div class="ad-waterfall-container">
					<div>Primary Ad Tag Url</div>
					<div id="AdTagSecondary-desktop-<?php echo $iterator; ?>-1" data-open="1" class="ad-waterfall">+ Add waterfall</div>
				</div>
			<?php else : ?>
				<div class="ad-waterfall-container" style="flex-direction: row-reverse;">
					<a href="<?php echo OAUTH_PROVIDER . "/users/login/?redirect=order"; ?>" target="_blank" class="ad-waterfall-link">Upgrade for ad waterfall</a>
				</div>
			<?php endif; ?>

			<div style="padding: 1px 10px 0 10px;">
				<input type="text" placeholder="Desktop-only Ad Tag Url" id="AdFlashAdTagUrl" name="Ad[<?php echo $iterator; ?>][flashAdTagUrl]" value="<?php echo ($adObject != null) ? $adObject->flashAdTagUrl : ''; ?>" maxlength="1024" />
			</div>

			<div class="flashFalbackWarring msgAdBox">
				Provide an Ad Tag URL <a href="https://brid.zendesk.com/hc/en-us/articles/200294282" target="_blank">(VAST compatible)</a> from your advertising partner.
				<a href="https://brid.zendesk.com/hc/en-us/sections/200105421" target="_blank">Learn more</a>.
			</div>
			<div class="flashFalbackWarring msgAdBox">
				These AdTags will be forced to play on Desktop. If left empty Mobile AdTags will be used for both Mobile &amp; Desktop devices.
			</div>
			<!-- PRIMARY TAG DESKTOP -->

			<?php if ($paid) : ?>

				<!-- SECONDARY TAG DESKTOP -->
				<div class="ad-desktop-<?php echo $iterator; ?>-1 hide-ad-tag">
					<div class="ad-waterfall-container">
						<div>Secondary Ad Tag Url</div>
						<div>
							<div id="AdTagSecondary-desktop-<?php echo $iterator; ?>-2" data-open="2" class="ad-waterfall">+ Add waterfall</div>
							<div id="RemoveAdTagSecondary-desktop-<?php echo $iterator; ?>-1" data-close="1" class="ad-waterfall-remove">- Remove Ad Tag</div>
						</div>
					</div>

					<div style="padding: 1px 10px 0 10px;">
						<input type="text" placeholder="Desktop-only Ad Tag Url" id="AdFlashAdTagUrl-1" name="Ad[<?php echo $iterator; ?>][flashAdTagUrlSec]" value="" maxlength="1024" />
					</div>

					<div class="flashFalbackWarring msgAdBox">
						Provide an Ad Tag URL <a href="https://brid.zendesk.com/hc/en-us/articles/200294282" target="_blank">(VAST compatible)</a> from your advertising partner.
						<a href="https://brid.zendesk.com/hc/en-us/sections/200105421" target="_blank">Learn more</a>.
					</div>
					<div class="flashFalbackWarring msgAdBox">
						These AdTags will be forced to play on Desktop. If left empty Mobile AdTags will be used for both Mobile &amp; Desktop devices.
					</div>
				</div>
				<!-- SECONDARY TAG DESKTOP -->

				<!-- THIRD TAG DESKTOP -->
				<div class="ad-desktop-<?php echo $iterator; ?>-2 hide-ad-tag">
					<div class="ad-waterfall-container">
						<div>Third Ad Tag Url</div>
						<div>
							<div id="AdTagSecondary-desktop-<?php echo $iterator; ?>-3" data-open="3" class="ad-waterfall">+ Add waterfall</div>
							<div id="RemoveAdTagSecondary-desktop-<?php echo $iterator; ?>-2" data-close="2" class="ad-waterfall-remove">- Remove Ad Tag</div>
						</div>
					</div>

					<div style="padding: 1px 10px 0 10px;">
						<input type="text" placeholder="Desktop-only Ad Tag Url" id="AdFlashAdTagUrl-2" name="Ad[<?php echo $iterator; ?>][flashAdTagUrlThird]" value="" maxlength="1024" />
					</div>

					<div class="flashFalbackWarring msgAdBox">
						Provide an Ad Tag URL <a href="https://brid.zendesk.com/hc/en-us/articles/200294282" target="_blank">(VAST compatible)</a> from your advertising partner.
						<a href="https://brid.zendesk.com/hc/en-us/sections/200105421" target="_blank">Learn more</a>.
					</div>
					<div class="flashFalbackWarring msgAdBox">
						These AdTags will be forced to play on Desktop. If left empty Mobile AdTags will be used for both Mobile &amp; Desktop devices.
					</div>
				</div>
				<!-- THIRD TAG DESKTOP -->

				<!-- FOURTH TAG DESKTOP -->
				<div class="ad-desktop-<?php echo $iterator; ?>-3 hide-ad-tag ">
					<div class="ad-waterfall-container">
						<div>Fourth Ad Tag Url</div>
						<div>
							<div id="RemoveAdTagSecondary-desktop-<?php echo $iterator; ?>-3" data-close="3" class="ad-waterfall-remove">- Remove Ad Tag</div>
						</div>
					</div>

					<div style="padding: 1px 10px 0 10px;">
						<input type="text" placeholder="Desktop-only Ad Tag Url" id="AdFlashAdTagUrl-3" name="Ad[<?php echo $iterator; ?>][flashAdTagUrlFourth]" value="" maxlength="1024" />
					</div>

					<div class="flashFalbackWarring msgAdBox">
						Provide an Ad Tag URL <a href="https://brid.zendesk.com/hc/en-us/articles/200294282" target="_blank">(VAST compatible)</a> from your advertising partner.
						<a href="https://brid.zendesk.com/hc/en-us/sections/200105421" target="_blank">Learn more</a>.
					</div>
					<div class="flashFalbackWarring msgAdBox">
						These AdTags will be forced to play on Desktop. If left empty Mobile AdTags will be used for both Mobile &amp; Desktop devices.
					</div>
				</div>
				<!-- FOURTH TAG DESKTOP -->

			<?php endif; ?>
		</div>
		<!-- DESKTOP TAGS -->

	</div>
</div>