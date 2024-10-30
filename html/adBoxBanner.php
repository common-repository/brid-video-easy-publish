<?php

$id = '';
$iterator = isset($iterator) ? $iterator : null;
$type = 'video';
$adTypesFlipped = array_flip($ad_types);

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
			<div class="ad-type-header-row-title">300x250 <?php echo $adType; ?></div>
			<div class="ad-type-header-row-delete brid-box-remove" data-iterator="<?php echo $iterator; ?>" id="brid-box-remove-<?php echo $iterator; ?>" data-id="<?php echo $id; ?>" data-type="<?php echo $adType; ?>">
				<img src="<?php echo BRID_PLUGIN_URL; ?>/img/delete_ad.png" />
			</div>
		</div>

		<div id="banner-<?php echo $iterator; ?>-settings" class="ad-box-midroll">
			<div>Timeout: </div>
			<div style="margin-left: 20px;">
				<input type="text" id="AdBannerDuration" name="Ad[<?php echo $iterator; ?>][overlayDuration]" value="" style="width:60px;height:22px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;" />
			</div>
		</div>

		<div style="border-bottom: 1px solid #dadadb;"></div>

		<div>
			<div class="ad-waterfall-container">
				<div>300x250 banner code</div>
			</div>

			<div style="padding: 1px 10px 0 10px;">
				<input type="text" placeholder="Paste your 300x250 banner code" id="AdAdTagUrl" name="Ad[<?php echo $iterator; ?>][adTagUrl]" value="" maxlength="1024" />
			</div>

			<div class="flashFalbackWarring msgAdBox">
				Provide an 300x250 banner code from your advertising partner.
				<a href="https://brid.zendesk.com/hc/en-us/sections/200105421" target="_blank">Learn more</a>.
			</div>
		</div>
	</div>
</div>