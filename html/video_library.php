<div class="media-frame wp-core-ui" id="__wp-uploader-id-128228282889">
	<div class="media-frame-menu">
		<div class="media-menu">
			<a href="#" class="media-menu-item media-brid-action active" data-action="video_library"><?php _e('Manage videos'); ?></a>
			<?php if (!BridOptions::getOption('hide_manage_playlist')) : ?>
				<a href="#" class="media-menu-item media-brid-action" data-action="playlist_library"><?php _e('Manage playlists'); ?></a>
			<?php endif; ?>
			<?php if ($user['permissions']['outstream'] == 1 && !BridOptions::getOption('hide_manage_outstream')) : ?>
				<a href="#" class="media-menu-item media-brid-action" data-action="unit_library"><?php _e('Manage outstream units'); ?></a>
			<?php endif; ?>
			<?php if ($user['permissions']['carousel'] && !BridOptions::getOption('hide_manage_carousels')) : ?>
				<a href="#" class="media-menu-item media-brid-action" data-action="carousel_library"><?php _e('Manage carousels'); ?></a>
			<?php endif; ?>
			<div class="separator"></div>
		</div>
	</div>

	<div class="media-frame-title">
		<h1><?php _e('Post Video'); ?></h1>
	</div>
	<?php
	$overageCss = 'brid-overage-post';
	require_once('form/overage_notice.php');
	?>
	<div class="media-frame-router">
		<div class="media-router">
			<?php if ($upload && !BridOptions::getOption('hide_upload_video')) { ?>
				<a href="#" data-id="uploadVideoPost" class="media-menu-item"><?php _e('Upload Video'); ?></a>
			<?php } ?>
			<?php if ($user['permissions']['disable_external_url'] == 0 && !BridOptions::getOption('hide_add_video')) : ?>
				<a href="#" data-id="addVideoPost" class="media-menu-item"><?php _e('Add Video'); ?></a>
			<?php endif; ?>
			<?php if ($user['permissions']['youtube'] == 1 && !BridOptions::getOption('hide_yt_video')) : ?>
				<a href="#" data-id="addYoutubePost" class="media-menu-item"><?php _e('Add Youtube'); ?></a>
			<?php endif; ?>
			<a href="#" data-id="videoLibraryPost" class="media-menu-item active"><?php _e('Video Library'); ?></a>
		</div>
	</div>
	<span class="spinner" id="bridSpin" style="visibility: hidden; top: 50%; position: absolute;left: 50%;z-index: 9999999;"></span>
	<div class="media-frame-content" id="brid-content">
		<?php
		// echo BridQuickPost::addVideoPost(true); 
		echo BridQuickPost::videoLibraryPost(true);
		?>
	</div>

	<div class="media-frame-toolbar">
		<div class="media-toolbar media-brid-toolbar">
			<div class="media-toolbar-secondary">
				<div class="media-selection empty">
					<div class="selection-info">
						<span class="count">0 <?php _e('selected'); ?></span>
						<a class="edit-selection" href="#"><?php _e('Edit'); ?></a>
						<a class="clear-selection" href="#"><?php _e('Clear'); ?></a>

					</div>
					<div class="selection-view">
						<ul class="attachments ui-sortable" id="__attachments-view-73"></ul>
					</div>
				</div>
			</div>
			<input type="text" id="brid_shortcode" style="width: 100px;height: 100px;display: none;" />
			<div class="media-toolbar-primary">
				<div class="mainWrapper" style='padding-top:0px;width:auto; position: absolute; right: 0px;top: 5px;width: 100%;text-align: right;'>

					<div class="bridButton disabled" id="copy_shortcode" data-form-bind="0" data-form-req="0" style="display: none; position: absolute;right: 0px;">
						<div class="buttonLargeContent"><?php _e('COPY SHORTCODE'); ?></div>
					</div>

					<div class="spinner" style="position: absolute;right: 100px;top: 5px;"></div>

					<div class="bridButton saveButton disabled" data-redirect="off" data-colorbox-close="0" id="videoSaveAdd" data-method="onVideoSave" data-form-bind="0" data-form-req="0" style="position: relative;right: 260px;">
						<div class="buttonLargeContent" id="videoSaveAddText"><?php _e('SAVE'); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	document.RAW_EMBED = <?php echo BridOptions::getOption('raw_embed'); ?>;
	$Brid.Html.QuickLibrary.init();
	$Brid.Html.PostVideo.init();

	jQuery('#copy_shortcode').on('click', function(e) {
		jQuery("#brid_shortcode").show();
		var copyText = jQuery("#brid_shortcode").select();
		var exec = document.execCommand("copy");
		jQuery("#brid_shortcode").hide();
		jQuery.colorbox.close();
	});
</script>