<div class="mainWrapper" style="width:100%;overflow:hidden">

	<div class="formWrapper" id="userUpload">
		<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="PartnerUserUploadForm" method="post" accept-charset="utf-8">
			<div style="display:none;">
				<input type="hidden" name="_method" value="POST">
				<input type="hidden" name="action" value="askQuestion">
				<input type="hidden" name="insert_via" value="2">
			</div>

			<table class="form-table" style="width:90%; margin:0px auto;">
				<tr>
					<td colspan="2">
						<h4 style="margin-top:0px;font-size: 22px; font-weight: bold; color: #000000; text-transform:uppercase; text-align:left;"><?php _e('Request for a Brid.tv Enterprise plan'); ?>.</h4>

					</td>
				</tr>
				<tr>
					<td style="width:50%; padding-right:1rem;">

						<div class="input text form">
							<label>
								<span style="float:left;"><?php _e('First Name'); ?></span>

								<input type="text" name="first_name" value="<?php echo $current_user->user_firstname; ?>" required placeholder="John" />

							</label>
						</div>

					</td>
					<td>
						<div class="input text form">
							<label>
								<span style="float:left;"><?php _e('Last Name'); ?></span>

								<input type="text" name="last_name" value="<?php echo $current_user->user_lastname; ?>" required placeholder="Smith" />

							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td style="padding-right:1rem;">
						<div class="input text form">
							<label>
								<span style="float:left;"><?php _e('Email'); ?></span>

								<input type="text" name="email" value="<?php echo $current_user->user_email; ?>" required placeholder="johnsmith@gmail.com" />

							</label>
						</div>
					</td>
					<td>
						<div class="input text form">
							<label>
								<span style="float:left;"><?php _e('Company'); ?></span>

								<input type="text" name="company" value="" placeholder="Company name" />

							</label>
						</div>

					</td>
				</tr>
				<tr>
					<td style="padding-right:1rem;">

						<div class="input text form">
							<label>
								<span style="float:left;"><?php _e('Website'); ?></span>

								<input type="text" name="website" value="<?php echo get_site_url(); ?>" required placeholder="Website" />

							</label>
						</div>

					</td>
					<td>
						<div class="input text form">
							<label>
								<span style="float:left;"><?php _e('Video views'); ?> (<?php _e('monthly'); ?>)</span>

								<input type="text" name="video_views" value="" required placeholder="1.000" />

							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td style="padding-right:1rem;">
						<div class="input text form">
							<label>
								<span style="float:left;margin-top:10px;"><?php _e('Tell us how you heard about us'); ?></span>

							</label>
						</div>

						<div style="position:relative; width:100%">
							<select id="heard" name="heard" class="chzn-select2" style="width:100%;">
								<option value="0">Search(Google, Yahoo, Bing..)</option>
								<option value="1">LinkedIn Ad</option>
								<option value="2">Facebook</option>
								<option value="3">Twitter</option>
								<option value="4">Email</option>
								<option value="5">Press</option>
								<option value="6">Another Publisher</option>
								<option value="7">Other</option>
							</select>
						</div>

					</td>
					<td>
						<div class="input text form">
							<label>
								<span style="float:left;margin-top:10px;"><?php _e('Video content type'); ?></span>

							</label>
						</div>
						<select id="content" name="content" class="chzn-select2" style="width:100%;">
							<option value="long"><?php _e('Long content'); ?></option>
							<option value="short"><?php _e('Short content'); ?></option>
							<option value="both"><?php _e('Both'); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-top:15px;">
						<div class="input text form">
							<label>
								<span style="float:left;"><?php _e('Comment'); ?></span>

								<textarea name="comment" placeholder="Comment"></textarea>

							</label>
						</div>
					<td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="checkboxRow" style='top:5px;margin-bottom:20px;font-family: Arial; margin-left:2px; color: #000000; font-weight: bold;'>
							<div id="checkbox-user_upload" class="bridCheckbox" data-method="toggleTopMenu" data-name="user_upload">
								<div class="checkboxContent" style='margin-right:10px;'>
									<img src="<?php echo BRID_PLUGIN_URL ?>img/checked.png" class="checked" style="display:block" alt="">
									<input type="hidden" name="premiumPlanCheckbox" class="singleCheckbox" id="premiumPlanCheckbox" data-value="1" style="display:none;">
								</div>
							</div><?php _e('I AGREE WITH BRID.TV TERMS AND SERVICES POLICY'); ?>
						</div>

					<td>
				</tr>
				<tr>
					<td colspan="2" style="padding-top:10px;text-align:left;">
						<div class="bridButton">
							<input type="submit" class="buttonLargeContent" id="submitEnterprise" value="SUBMIT" />
						</div>
					<td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script>
	var save = saveObj.init();
	$Brid.Html.CheckboxElement.init();

	jQuery(".chzn-select2").chosen();


	jQuery('#submitEnterprise').on('click', function(e) {

		e.preventDefault();
		//askQuestion
		var data = jQuery('#PartnerUserUploadForm').serialize();

		jQuery.ajax({
			url: ajaxurl, //'/videos/check_url/.json',
			data: data,
			type: 'POST' //,
			//context: {action:askQuestion, insert_via:2}
		}).done(function(responseData) {
			if (responseData.success) {
				jQuery.colorbox.close();
				jQuery('.bridNotice').hide();
			}
		});

	});
</script>