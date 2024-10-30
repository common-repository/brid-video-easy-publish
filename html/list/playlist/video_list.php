<!-- Used in playlist pagination and search for video search -->
<script>
	playlistType = '<?php echo $playlistType; ?>';
</script>
<?php if (!empty($videosDataset->data)) {
	$pagination = $videosDataset->paging->Video;
?>
	<ul class="attachments ui-sortable ui-sortable-disabled" style="overflow-y: scroll!important;">

		<?php foreach ($videosDataset->data as $k => $v) { ?>
			<li class="attachment save-ready bridItem" data-video-index="<?php echo $k; ?>" id="brid-video-item-<?php echo $v->Video->id; ?>">
				<div class="attachment-preview type-video subtype-mp4 landscape" style="width:100%; height:135px">
					<?php
					$poster = $v->Video->thumbnail;
					if ($v->Video->thumbnail == '') {
						$poster = BRID_PLUGIN_URL . 'img/thumb_404.png';
					}
					?>
					<img src="<?php echo $poster; ?>" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;" class="icon" draggable="false" style="width:100%; height:100%;padding-top:0px">
					<div class="filename">
						<div><?php echo $v->Video->name; ?></div>
					</div>

					<a class="check" href="#" title="Deselect">
						<div class="media-modal-icon"></div>
					</a>

				</div>

			</li>

		<?php } ?>
	</ul>
	<div class="pagination" style="position:absolute;right:300px; left:0px; width:auto; bottom:25px;margin-bottom:0px">
		<div class="mainWrapper" style="width:auto">

			<div class="paging">
				<?php if ($pagination->pageCount > 1) { ?>
					<span class="first"><a href="#" class="pagination-link" data-page="1" rel="first"> </a></span>
					<span class="prev"><a href="#" class="pagination-link" data-page="<?php echo $pagination->prevPage; ?>" rel="prev"> </a></span>
					<?php
					if ($pagination->page < 5) {
						$pageFrom = 1;
					} else {
						$pageFrom = $pagination->page - 4;
					}
					if (($pagination->page + 4) > $pagination->pageCount) {
						$pageTo = $pagination->pageCount;
					} else {
						$pageTo = $pagination->page + 4;
					}
					for ($i = $pageFrom; $i <= $pageTo; $i++) {

						if ($i == $pagination->page) {
					?>
							<span class="current"><?php echo $i; ?></span>&nbsp;
						<?php
						} else {
						?>
							<span><a href="#" data-page="<?php echo $i; ?>" class="pagination-link"><?php echo $i; ?></a></span>&nbsp;
					<?php
						}
					}
					?>
					<span class="next"><a href="#" class="pagination-link" data-page="<?php echo $pagination->nextPage; ?>" rel="next"> </a></span>
					<span class="last"><a href="#" class="pagination-link" data-page="<?php echo $pagination->pageCount; ?>" rel="last"> </a></span>
				<?php } ?>
				<div class="pagingInfo">Page <?php echo $pagination->page; ?> of <?php echo $pagination->pageCount; ?>, showing <?php echo $pagination->current; ?> out of <?php echo $pagination->count; ?> total</div>

			</div>
		</div>
	</div>
<?php } ?>

<!-- SIde bar -->
<div class="media-sidebar">

	<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">

		<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
		<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
		<input type="hidden" name="ids" id="VideoIds">
		<input type="hidden" name="playlistType" value="<?php echo $playlistType; ?>">
		<input type="hidden" name="action" value="addPlaylist">
		<input type="hidden" name="insert_via" id="VideoInsertVia" value="2">

		<div class="attachment-info save-ready" id="bridVideoDetails" style="display:block;">

			<div id="video-embed" style="margin-top:10px;"></div>
			<h3>
				<?php _e('Playlist Details'); ?>
				<span class="settings-save-status">
					<span class="spinner"></span>
					<span class="saved" style="display:none;"><?php _e('Saved'); ?>.</span>
				</span>
			</h3>
			<div class="separator" style="border-bottom: 1px solid #ddd;margin-bottom:10px;"></div>

			<label class="setting" data-setting="title">
				<span><?php _e('Playlist Title'); ?></span>
				<input name="name" maxlength="250" type="text" placeholder="Playlist title" id="PlaylistName" required="required">
			</label>


		</div>

	</form>
</div>
<script>
	var brid_video_item = null;

	var brid_videos = <?php echo json_encode($videosDataset->data); ?>;
</script>