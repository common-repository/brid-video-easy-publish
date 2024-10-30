<!-- Used in pagination and search -->
<?php if (!empty($videosDataset->data)) {
	$pagination = $videosDataset->paging->Video;
?>
	<ul class="postVideoFix attachments ui-sortable ui-sortable-disabled" style="overflow-y: scroll!important;">

		<?php foreach ($videosDataset->data as $k => $v) { ?>
			<li class="attachment save-ready bridItem" data-video-index="<?php echo $k; ?>" id="brid-video-item-<?php echo $v->Video->id; ?>">
				<div class="attachment-preview type-video subtype-mp4 landscape" style="width:100%; height:135px">
					<?php
					$get_imge = function () use ($v) {
						$v = ['Video' => (array) $v->Video];

						if (!empty($v['Video']['thumbnail'])) return $v['Video']['thumbnail'];
						if (!empty($v['Video']['image'])) return $v['Video']['image'];

						return BRID_PLUGIN_URL . 'img/' . 'thumb_404.png';
					};
					// Image source
					$video_image = $get_imge();
					?>
					<div class="icon-container">
						<img src="<?php echo $video_image; ?>" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;" class="icon" draggable="false">
					</div>
					<div class="filename">
						<div><?php echo $v->Video->name; ?></div>
					</div>

					<a class="check" href="#" title="Deselect">
						<div class="media-modal-icon"></div>
					</a>

				</div>

			</li>

		<?php }
		?>
	</ul>
	<div class="pagination" style="position:absolute;right:300px; left:0px; width:auto; bottom:25px;margin-bottom:0px">
		<div class="mainWrapper" style="width:auto">

			<div class="paging">
				<?php if ($pagination->pageCount > 1) { ?>
					<span class="first"><a href="#" class="pagination-link" data-page="1" rel="first"> </a></span>
					<span class="prev"><a href="#" class="pagination-link" data-page="<?php echo $pagination->prevPage ? $pagination->page - 1 : 1; ?>" rel="prev"> </a></span>
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
					<span class="next"><a href="#" class="pagination-link" data-page="<?php echo $pagination->nextPage ? $pagination->page + 1 : $pagination->pageCount; ?>" rel="next"> </a></span>
					<span class="last"><a href="#" class="pagination-link" data-page="<?php echo $pagination->pageCount; ?>" rel="last"> </a></span>
				<?php } ?>
				<div class="pagingInfo"><?php _e('Page'); ?> <?php echo $pagination->page; ?> <?php _e('of'); ?> <?php echo $pagination->pageCount; ?>, <?php _e('showing'); ?> <?php echo $pagination->current; ?> <?php _e('out of'); ?> <?php echo $pagination->count; ?> <?php _e('total'); ?></div>

			</div>
		</div>
	</div>
<?php } else { ?>
	<br>
	<br>
	<br>
	&nbsp;&nbsp;&nbsp;&nbsp; <?php _e('Video list empty'); ?>.
<?php  } ?>


<script>
	var brid_video_item = null;
	var brid_videos = <?php echo json_encode($videosDataset->data); ?>;

	var search_from_post = '<?= isset($_POST['search']) ? $_POST['search'] : '' ?>';
	var search_tag_from_post = '<?= isset($_POST['searchTag']) ? $_POST['searchTag'] : '' ?>';
	var search_status = '<?= isset($_POST['status']) ? $_POST['status'] : '' ?>';
	var search_carousel = '<?= isset($_POST['carouselOnly']) ? $_POST['carouselOnly'] : '' ?>';

	jQuery('#VideoSearch').val(search_from_post);
	jQuery('#VideoSearchTag').val(search_tag_from_post);
	jQuery('#VideoSearchStatus').val(search_status);
	if (search_carousel == 1) {
		jQuery('#VideoSearchCarousel').attr("checked", true);
	}

	if (search_from_post != "" || search_tag_from_post != "" || search_status != "" || search_carousel != "") {
		jQuery(".filter-button").addClass('filter-active');
	}
</script>