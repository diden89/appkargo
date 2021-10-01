/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/report/report_delivery.js
 */

const reportDelivery = {
	selectedData: '',
	init: function() {
		const me = this;

		
		$('#date_range_1').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
		$('#date_range_1').noobsdaterangepicker({
			// parentEl: "#" + popup[0].id + " .modal-body",
			showDropdowns: true,
			singleDatePicker: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});
		$('#date_range_2').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
		$('#date_range_2').noobsdaterangepicker({
			// parentEl: "#" + popup[0].id + " .modal-body",
			showDropdowns: true,
			singleDatePicker: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});
	}
	
};

$(document).ready(function() {
	reportDelivery.init();
});