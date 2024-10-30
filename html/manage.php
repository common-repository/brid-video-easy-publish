<script>
	$BridWordpressConfig = {};
	$BridWordpressConfig.pluginUrl = '<?php echo BRID_PLUGIN_URL; ?>';
	var currentDivView = 'Videos-content';
</script>

<div class="mainWrapper" style="width:auto;position:relative; margin-right:10px;">

	<i class="fa fa-spinner fa-pulse fa-2x fa-fw preloader" id="bridSpiner" style="display: none;"></i>

	<div class="mainWrapper mainWrap">

		<?php require_once('form/overage_notice.php'); ?>

		<!-- Tabs start -->
		<div style="padding-top:10px;" class="tabs withArrow" id="libraryTabs">
			<div id="Videos" class="tab" style="width: 50%;"><?php _e('VIDEOS'); ?></div>
			<div id="Playlists" class="tab-inactive" style="margin-right: 0px; width: 50%;"><?php _e('PLAYLISTS'); ?></div>
		</div>
		<!-- Tabs end -->

		<!-- videos tab start -->
		<div id="Videos-content" style=" float:left;width:100%;">
			<?php require_once(BRID_PLUGIN_DIR . '/html/list/library/videos.php'); ?>
		</div>
		<!-- videos tab end -->

		<!-- Playlists tab start -->
		<div id="Playlists-content" style="display:none; float:left;width:100%"></div>
		<!-- Playlists tab end -->
	</div>
</div>
<script>
	//Used in global contentRefresh function @see default.ctp or default.js

	jQuery(document).ready(function() {
		// Tooltip for Geo
		jQuery(".geoStatus.on").tooltip({
			position: {
				my: "center bottom", // the "anchor point" in the tooltip element
				at: "center top-10", // the position of that anchor point relative to selected element
			}
		});

		jQuery('#wpbody-content').css('float', 'none');
		jQuery('html, body').css('background', '#fff');

		initBridMain();

		jQuery(".tab, .tab-inactive").off('click.TabsApiLoad').on("click.TabsApiLoad", function() {

			var div = jQuery(this);
			divId = div.attr("id"), intoDiv = jQuery("#" + divId + '-content');
			intoDiv.hide();
			if (divId == 'Videos') {
				jQuery('#Videos').removeClass('tab-inactive').addClass('tab');
				jQuery('#Playlists').removeClass('tab').addClass('tab-inactive');
				jQuery('#Playlists-content').css('opacity', '0.1');
			} else {
				jQuery('#Videos').removeClass('tab').addClass('tab-inactive');
				jQuery('#Playlists').removeClass('tab-inactive').addClass('tab');
				jQuery('#Videos-content').css('opacity', '0.1');
			}
			try {
				$bp('wp_edit_video').destroy();
			} catch (error) {
				debug.error('No wp_edit_video player.');
			}

			$Brid.Api.call({
				data: {
					action: divId.toLowerCase()
				},
				callback: {
					after: {
						name: "insertContent",
						obj: intoDiv
					}
				}
			});

		});

	});
</script>
<script src="//use.fontawesome.com/f8ff95fdc4.js" async></script>