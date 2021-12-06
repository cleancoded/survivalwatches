/**
* BestWebsite Suppory Plugin Admin JS
*/
(function ($) {
	$(document).ready(function () {
		$('#bw_support_show_credits').trigger('change');
		$('#bw_support_show_credits').on('change', function () {
			if ($(this).val() === "yes") {
				$('#footer-credit-options').show('slow');
			} else {
				$('#footer-credit-options').hide('slow');
			}
		});
		
		$('#bw_support_credits_type').trigger('change');
		$('#bw_support_credits_type').on('change', function () {
			if ($(this).val() === "image") {		
				$('#bw_support_show_credits_logo_color').show('slow');
			} else {
				$('#bw_support_show_credits_logo_color').hide('slow');
			}
		})
	})
})(jQuery);