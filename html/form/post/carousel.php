<?php
$carousel_statuses = array_flip([
	'new/pending' => 0,		//To be created
	'active' => 1,			//Done
	'fetch' => 2,			//Fetch images or xml or both
	'error' => 3,			//Error
	'pending' => 4,			//Waiting for queue
	'started' => 5,			//Encoding in progress
]);
?>

<div class="mainWrapper" style="padding-top: 0px; width: auto; position: absolute; left: 0px; top: 0px; bottom: 0px; right: 0px;">

	<div style="padding: 20px 0 0 15px; box-sizing: border-box;">
		<select id="postCarouselSelected" class="chzn-select" style="width: 100%;">
			<?php
			foreach ($carousels as $carousel) {
				$selected = "";
				if ($carousel['Carousel']['id'] == $selectedCarousel) {
					$selected = "selected";
				}
				$status = isset($carousel_statuses[$carousel['Carousel']['status']]) ? $carousel_statuses[$carousel['Carousel']['status']] : 'status unknown';

				echo '<option value="' . $carousel['Carousel']['id'] . '" ' . $selected . '>' . $carousel['Carousel']['name'] . ' - ' . $status . '</option>';
			}
			?>
		</select>
	</div>
</div>

<script type="text/javascript">
	var carouselsJson = <?php echo json_encode($carousels); ?>;
	console.log(carouselsJson);
	var carousels = [];
	for (var i in carouselsJson) {
		if (typeof i != 'function' && i.length <= 2) {
			carousels[carouselsJson[i].Carousel.id] = carouselsJson[i].Carousel;
		}
	}
	console.log(carousels);

	jQuery(".chzn-select").chosen();

	jQuery("#carouselSaveAdd").unbind('click');

	jQuery("#carouselSaveAdd").on('click.PostCarousel', postCarousel);

	function postCarousel() {

		var selectedCarouselId = parseInt(jQuery('#postCarouselSelected').val());
		console.log(jQuery('#postCarouselSelected').val(), selectedCarouselId);
		var code = $Brid.Util.shortCodeCarousel(carousels[selectedCarouselId]);
		var raw_embed = <?php echo BridOptions::getOption('raw_embed'); ?>;
		if (raw_embed) {
			jQuery.ajax({
					method: "POST",
					url: "<?php echo admin_url('admin-ajax.php') . '?action=getRawEmbed' ?>",
					data: {
						shortcode: code
					}
				})
				.done(function(msg) {
					code = msg;
					jQuery("#brid_shortcode").show();
					jQuery("#brid_shortcode").val(code);
					var copyText = jQuery("#brid_shortcode").select();
					document.execCommand("copy");
					jQuery("#brid_shortcode").hide();
					jQuery.colorbox.close();
				});
		} else {
			jQuery("#brid_shortcode").show();
			jQuery("#brid_shortcode").val(code);
			var copyText = jQuery("#brid_shortcode").select();
			document.execCommand("copy");
			jQuery("#brid_shortcode").hide();
			jQuery.colorbox.close();
		}
	}
</script>