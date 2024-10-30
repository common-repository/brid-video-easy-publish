<div class="mainWrapper" style="padding-top: 0px; width: auto; position: absolute; left: 0px; top: 0px; bottom: 0px; right: 0px;">

	<div style="padding: 20px 0 0 15px; box-sizing: border-box;">
		<select id="postUnitSelected" class="chzn-select" style="width: 100%;">
			<?php
			foreach ($units as $unit) {
				$selected = "";
				if ($unit['Unit']['id'] == $selectedUnit) {
					$selected = "selected";
				}

				echo '<option value="' . $unit['Unit']['id'] . '" ' . $selected . '>' . $unit['Unit']['name'] . ' - ' . $unit['Unit']['width'] . ' X ' . $unit['Unit']['height'] . '</option>';
			}
			?>
		</select>
	</div>
</div>

<script type="text/javascript">
	var outstreamUnitsJson = <?php echo json_encode($units); ?>;
	var outstreamUnits = [];
	for (var i in outstreamUnitsJson) {
		if (typeof i != 'function' && i.length <= 2) {
			outstreamUnits[outstreamUnitsJson[i].Unit.id] = outstreamUnitsJson[i].Unit;
		}
	}

	jQuery(".chzn-select").chosen();

	jQuery("#unitSaveAdd").unbind('click');

	jQuery("#unitSaveAdd").on('click.PostUnit', postUnit);

	function postUnit() {

		var selectedUnitId = parseInt(jQuery('#postUnitSelected').val());

		var code = $Brid.Util.shortCodeUnit(outstreamUnits[selectedUnitId]);
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