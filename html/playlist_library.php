<?php $button = 'COPY SHORTCODE'; ?>
<div class="media-frame wp-core-ui" id="__wp-uploader-id-12822828287779">
	<div class="media-frame-menu">
		<div class="media-menu">
			<a href="#" class="media-menu-item media-brid-action" data-action="video_library"><?php _e('Manage videos'); ?></a>
			<?php if (!BridOptions::getOption('hide_manage_playlist')) : ?>
				<a href="#" class="media-menu-item media-brid-action active" data-action="playlist_library"><?php _e('Manage playlists'); ?></a>
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
		<h1><?php _e('Post Playlist'); ?></h1>
	</div>
	<?php
	$overageCss = 'brid-overage-post';
	require_once('form/overage_notice.php');
	?>
	<div class="media-frame-router">
		<div class="media-router">
			<a href="#" data-id="addPlaylistPost" data-playlistType="0" class="media-menu-item"><?php _e('Add Playlist'); ?></a>
			<a href="#" data-id="playlistLibraryPost" class="media-menu-item active"><?php _e('Playlist Library'); ?></a>
		</div>
	</div>
	<span class="spinner" id="bridSpin" style="visibility: hidden; top: 50%; position: absolute;left: 50%;z-index: 9999999;"></span>

	<div class="media-frame-content" id="brid-content">
		<?php echo BridQuickPost::playlistLibraryPost(true); ?>
	</div>

	<div class="media-frame-toolbar">
		<div class="media-toolbar media-brid-toolbar">
			<div class="media-toolbar-secondary">
				<div class="media-selection" id="bridSelected">
					<div class="selection-info">
						<span class="count">0 <?php _e('selected'); ?></span>
						<a class="clear-selection" href="javascript:clearSelectedVideos()"><?php _e('Clear'); ?></a>
					</div>
					<div class="selection-view">
						<ul class="attachments ui-sortable" id="__attachments-view-73"></ul>
					</div>
				</div>
			</div>
			<input type="text" id="brid_shortcode" style="width: 100px;height: 100px;display: none;" />
			<div class="media-toolbar-primary">
				<div class="mainWrapper" style='padding-top:0px;width:auto'>
					<div class="bridButton" data-redirect="off" data-colorbox-close="0" id="copy_shortcode" data-method="onPlaylistUpdate" data-form-bind="0" data-form-req="0" style="position: absolute; right: 20px; top: 5px; display:none;">
						<div class="buttonLargeContent" id="videoSaveAddText"><?php _e('COPY SHORTCODE'); ?></div>
					</div>

					<div class="bridButton saveButton disabled" id="playlistSaveAdd" data-method="onPlaylistSave" data-form-bind="0" data-form-req="0" style="position: absolute; right: 20px; top: 5px;">
						<div class="buttonLargeContent" data-clipboard-action="copy" id="videoSaveAddText111"><?php _e('SAVE'); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery('#copy_shortcode').on('click', function(e) {
		jQuery("#brid_shortcode").show();
		var copyText = jQuery("#brid_shortcode").select();
		var exec = document.execCommand("copy");
		jQuery("#brid_shortcode").hide();
		jQuery.colorbox.close();
	});
</script>