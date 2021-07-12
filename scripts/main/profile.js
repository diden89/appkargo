/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/main/main.js
 */

$(document).ready(function() {
	$('#txtDob').noobsdaterangepicker({
		singleDatePicker: true,
		showDropdowns: true
	});

	$('#fileAvatar').change(function(a){
		var $this = $(this);
		var $next = $this.next();

		$next.html($this[0].files[0].name);
	});

	$('#form1').submit(function(e){
		e.preventDefault();

		var $this = $(this);
		var formData = new FormData($this[0]);

		$.ajax({
			type: $this.attr('method'),
			enctype: 'multipart/form-data',
			url: $this.attr('action'),
			data: formData,
			processData: false,
			contentType: false,
			cache: false,
			dataType: 'json',
			success: function(data) {
				if (data.success) {
					toastr.success(msgSaveOk);
				} else if (typeof(data.msg) !== 'undefined') {
					toastr.error(data.msg);
				} else {
					toastr.error(msgErr);
				}
			},
			error: function(e) {
				toastr.error(msgErr);
			}
		});
	});

	$('#form2').submit(function(e){
		e.preventDefault();

		var $this = $(this);
		var formData = new FormData($this[0]);

		$.ajax({
			type: $this.attr('method'),
			url: $this.attr('action'),
			data: formData,
			processData: false,
			contentType: false,
			cache: false,
			dataType: 'json',
			success: function(data) {
				if (data.success) {
					toastr.success(msgSaveOk);
				} else if (typeof(data.msg) !== 'undefined') {
					toastr.error(data.msg);
				} else {
					toastr.error(msgErr);
				}
			},
			error: function(e) {
				toastr.error(msgErr);
			}
		});
	});
});