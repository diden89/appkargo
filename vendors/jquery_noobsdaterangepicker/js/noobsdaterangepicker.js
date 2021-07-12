/*!
 * @package jQuery-noobsdaterangepicker
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /D/PROJECTS/WEB/GLOBAL/merekdagang/vendors/jquery_noobsdaterangepicker/js/noobsdaterangepicker.js
 */


(function (global, $, undefined) {
	$.fn.noobsdaterangepicker = function (options) {

		var newOptions = typeof(options) !== 'undefined' ? options : {};

		var settings = $.extend(true, {
			locale: {
		        format: "DD-MM-YYYY",
		        separator: " - ",
		        // applyLabel: "Terapkan",
		        // cancelLabel: "Batal",
		        // fromLabel: "Dari",
		        // toLabel: "Sampai",
		        // customRangeLabel: "Custom",
		        // weekLabel: "M",
		        // daysOfWeek: [
		        //     "M",
		        //     "S",
		        //     "S",
		        //     "R",
		        //     "K",
		        //     "J",
		        //     "S"
		        // ],
		        // monthNames: [
		        //     "Januari",
		        //     "Februari",
		        //     "Maret",
		        //     "April",
		        //     "Mei",
		        //     "Juni",
		        //     "Juli",
		        //     "Agustus",
		        //     "September",
		        //     "Oktober",
		        //     "November",
		        //     "Desember"
		        // ],
		        firstDay: 1
		    },
		}, newOptions);

		var that = this;
		var oriEl = this;

		that.daterangepicker(settings);

		if (typeof(settings.autoUpdateInput) !== 'undefined' && settings.autoUpdateInput == false) {
			if (typeof(settings.singleDatePicker) !== 'undefined' && settings.singleDatePicker == true) {
				that.on('apply.daterangepicker', function (ev, picker) {
		            $(this).val(picker.startDate.format('L'));
		        });

		        that.on('cancel.daterangepicker', function (ev, picker) {
		            $(this).val('');
		        });
			} else {
				that.on('apply.daterangepicker', function(ev, picker) {
					$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
				});

				that.on('cancel.daterangepicker', function(ev, picker) {
					$(this).val('');
				});
			}
		}
	}
})(window, jQuery);