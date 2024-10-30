<?php $button = 'COPY SHORTCODE'; ?>
<div class="media-frame wp-core-ui" id="__wp-uploader-id-12822828287780">
	<div class="media-frame-menu">
		<div class="media-menu">
			<a href="#" class="media-menu-item media-brid-action" data-action="video_library"><?php _e('Manage videos'); ?></a>
			<?php if (!BridOptions::getOption('hide_manage_playlist')) : ?>
				<a href="#" class="media-menu-item media-brid-action" data-action="playlist_library"><?php _e('Manage playlists'); ?></a>
			<?php endif; ?>
			<?php if ($user['permissions']['outstream'] == 1 && !BridOptions::getOption('hide_manage_outstream')) : ?>
				<a href="#" class="media-menu-item media-brid-action active" data-action="unit_library"><?php _e('Manage outstream units'); ?></a>
			<?php endif; ?>
			<?php if ($user['permissions']['carousel'] && !BridOptions::getOption('hide_manage_carousels')) : ?>
				<a href="#" class="media-menu-item media-brid-action" data-action="carousel_library"><?php _e('Manage carousels'); ?></a>
			<?php endif; ?>
			<div class="separator"></div>
		</div>
	</div>

	<div class="media-frame-title">
		<h1><?php _e('Post Outstream Unit'); ?></h1>
	</div>
	<?php
	$overageCss = 'brid-overage-post';
	require_once('form/overage_notice.php');
	?>
	<div class="media-frame-router">
		<div class="media-router">
			<a href="#" data-id="unitLibraryPost" class="media-menu-item active"><?php _e('Unit Library'); ?></a>
		</div>
	</div>
	<span class="spinner" id="bridSpin" style="visibility: hidden; top: 50%; position: absolute; left: 50%; z-index: 9999999;"></span>

	<div class="media-frame-content" id="brid-content">
		<?php echo BridQuickPost::addUnitPost(true); ?>
	</div>

	<div class="media-frame-toolbar">
		<div class="media-toolbar media-brid-toolbar">
			<div class="media-toolbar-secondary">
				<div class="media-selection empty">
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
				<div class="mainWrapper" style="padding-top: 0px ;width: auto">
					<div class="bridButton disabled" data-redirect="off" data-colorbox-close="0" id="updateBridItem" data-method="onUnitUpdate" data-form-bind="0" data-form-req="0" style="position: absolute; right: 120px; top: 5px; display:none;">
						<div class="buttonLargeContent" id="videoSaveAddText"><?php _e('UPDATE'); ?></div>
					</div>
					<div class="bridButton saveButton" id="unitSaveAdd" data-method="onUnitSave" data-form-bind="0" data-form-req="0" style="position: absolute; right: 20px; top: 5px;">

						<div class="buttonLargeContent" id="unitSaveAddText"><?= $button; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>