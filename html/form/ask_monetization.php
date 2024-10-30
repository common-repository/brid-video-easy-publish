<div style="width:860px; margin:0px auto;">
	<?php if (!$applyForAdProgram) { ?>
		<div class="small-12 columns">
			<div class="formWrapper" id='addWebsite'>
				<h3 class="lined"><span>BRID.TV <?php _e('PARTNER PROGRAM TERMS'); ?></span></h3>
			</div>

			<p style="font-size:12px;font-family: Arial; line-height: 1.2;"><?php _e('Together with the'); ?> <a href="https://cms.brid.tv/pages/terms-conditions" target="_blank" class="blue_link">Brid.tv <?php _e('Terms of Service'); ?></a> <?php _e('and the'); ?> <a href="https://cms.brid.tv/pages/privacy" target="_blank" class="blue_link">Brid.tv <?php _e('Partner Program Policies'); ?></a> (<?php _e('each of which may be updated from time to time and are incorporated herein by reference'); ?>), <?php _e('the following Brid.tv Partner Program Terms apply to your participation in the Brid.tv Partner Program (the "Terms"). Please read the Terms carefully. If you do not understand or accept any part of these Terms, you should not upload Content for monetization on'); ?> Brid.tv.
			</p>

			<dl class="faq">
				<dt><?php _e('Advertising Revenues. Brid.tv will pay you 60% of net revenues recognized by Brid.tv from ads displayed or streamed by Brid.tv or an authorized third party on your Content watch pages or in or on the Brid.tv video player in conjunction with the streaming of your Content. Brid.tv is not obligated to display any advertisements alongside your videos and may determine the type and format of ads available on the Brid.tv Service. For clarity, Brid.tv reserves the right to retain all other revenues derived from the Brid.tv service'); ?>.
				</dt>

				<dt>Payment Terms, Limitations and Taxes. Brid.tv will pay you for any revenues due within approximately sixty (60) days after the end of any calendar month, so long as your earned balance is at least US $100 (or its equivalent in local currency) at the time payment is due. You are not entitled to earn or receive any revenues in connection with your Content in any of the following circumstances: (a) if one or more third parties claim rights to certain elements of your Content except in cases where Brid.tv’s policies or systems support sharing a portion of the revenues with you, as determined by Brid.tv; (b) if monetization is disabled on your Content by either you or Brid.tv; or (c) your participation in the Brid.tv Partner Program is suspended or terminated pursuant to Section 4 below. Brid.tv will use reasonable efforts to notify you if any of these circumstances should occur.
				</dt>
				<dt>Termination. Either party may terminate these Terms for convenience with 30 days prior written notice to the other (including via electronic means). Brid.tv may either suspend or terminate your participation in the Brid.tv Partner Program immediately upon written notice (including via electronic means) if Brid.tv reasonably determines or suspects that you have violated these Terms. For clarity, in the event of any termination of these Terms the Brid.tv Terms of Service will survive and continue to apply to your use of the Brid.tv service.
				</dt>
				<dt>Governing Law. The governing law and dispute resolution provisions of the Brid.tv Terms of Service will also apply to these Terms.
				</dt>
				<dt>Miscellaneous. Capitalized terms used but not defined in these Terms will have the meanings given to such terms in the Brid.tv Terms of Service. These Terms replace all previous or current agreements between you and Brid.tv relating to the Brid.tv Partner Program, including any prior monetization agreements that are in effect between you and Brid.tv as of the effective date. Except as modified by these Terms, the Brid.tv Terms of Service remain in full force and effect. Brid.tv’s right to modify or revise the Terms of Service (as described in the Brid.tv Terms of Service) will also apply to these Terms.
				</dt>
			</dl>
		</div>
		<div style="position:relative;width:100%; float:left;margin-bottom:20px;">
			<div id="checkbox-terms" class="bridCheckbox" data-method="toggleApplyForAdProgram" data-name="terms" style="left:1px;">
				<div class="checkboxContent">
					<img src="<?php echo BRID_PLUGIN_URL; ?>/img/checked.png" class="checked" style="display:block" alt="">
					<input type="hidden" name="data[][terms]" value="1" class="singleCheckbox checked" id="terms" data-value="1" style="display:none;" checked="checked" data-display="block">
				</div>
				<div class="checkboxText" id="checkbox-terms" data-ajax-loaded="true">I HAVE READ AND AGREE TO THE TERMS ABOVE</div>
			</div>
		</div>
		<div class="small-12 columns" style="padding-top:1rem;">
			<div class="buttonLargeContent" id="applySubmit" style="font-family: 'Fjalla One' Arial;">SUBMIT</div>
		</div>
	<?php } else { ?>
		<div class="small-12 columns">
			<div class="formWrapper" id='addWebsite'>
				<h3 class="lined"><span>BRID.TV PARTNER PROGRAM TERMS</span></h3>

				<p style="font-size:12px;">You have already applied for the Brid.tv monetization plan. An account manager will get back to you at their earliest convenience.
				</p>
				<p style="font-size:12px;">If you have any other questions or concerns, please contact us at: <a href="mailto:contact@brid.tv" class="blue_link">contact@brid.tv</a>.
				</p>
			</div>
		</div>

	<?php } ?>
</div>
<script>
	initBridMain();
	jQuery('#applySubmit').off('click').on('click', function(e) {

		if (!jQuery(this).hasClass('disabled')) {

			jQuery.ajax({
				url: ajaxurl,
				type: 'POST',
				data: 'insert_via=2&action=askMonetize',
				success: function(data) {
					jQuery.colorbox.close();
					alert('Thank you for apply to Brid.tv monetization program. An account manager will get back to you within the next two business days.');
				},
				error: function() {

				}

			});
		} else {
			alert('You need to read and agree with the Brid.tv partner program terms.');
		}

	});
</script>