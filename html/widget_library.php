<div class="media-frame wp-core-ui" id="__wp-uploader-id-128228282889">
	<div class="media-frame-menu">
		<div class="media-menu">
			<a href="#" class="media-menu-item active media-brid-action" data-action="video_library"><?php _e('Manage videos'); ?></a>
			<a href="#" class="media-menu-item media-brid-action" data-action="playlist_library"><?php _e('Manage playlists'); ?></a>
			<a href="#" class="media-menu-item media-brid-action" data-action="widget_library"><?php _e('Post widget'); ?></a>
			<div class="separator"></div>
		</div>
	</div>
	<div class="media-frame-title">
		<h1><?php _e('Post widget'); ?></h1>
	</div>
	<div class="media-frame-router">

	</div>
	<span class="spinner" id="bridSpin" style="display: none;top: 50%; position: absolute;left: 50%;z-index: 9999999;"></span>
	<div class="media-frame-content" id="brid-content">
		<?php _e('Widget form content'); ?>
	</div>

	<div class="media-frame-toolbar">
		<div class="media-toolbar media-brid-toolbar">

			<div class="media-toolbar-primary">
				<div class="mainWrapper" style='padding-top:0px;width:auto'>

					<div class="bridButton saveButton disabled" id="videoSaveAdd" data-method="onVideoSave" data-form-bind="0" data-form-req="0" style="position: absolute; right: 20px; top: 5px;">
						<div class="buttonLargeContent" id="videoSaveAddText"><?php _e('POST'); ?></div>
					</div>

					<div class="bridButton saveButton disabled" data-redirect="off" data-colorbox-close="0" id="updateBridItem" data-method="onVideoUpdate" data-form-bind="0" data-form-req="0" style="position: absolute; right: 120px; top: 5px; display:none;">
						<div class="buttonLargeContent" id="videoSaveAddText"><?php _e('UPDATE'); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>