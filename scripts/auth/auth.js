/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/auth/auth.js
 */

$(document).ready(function() {
	$('#txtUsername').focus();
	$('#formLogin').submit(function(e){
		e.preventDefault();

		var $this = $(this);
		var formData = $this.serializeArray();
		var data = {};
		var dataStr = '';

		for (x in formData) {
			var temp = formData[x]
			var name = temp['name'];
			var value = temp['value'];

			data[name] = value;
		}

		dataStr = JSON.stringify(data);

		$.ajax({
			url: siteUrl('auth/do_login'),
			method: 'post',
			dataType: 'json',
			data: {
				action: 'do_login',
				data: dataStr
			},
			success: function(json) {
				if (json.success) {
					document.location.href = BASE_URL;
				} else {
					if (typeof(json.msg) !== 'undefined' && json.msg != '') {
						Swal.fire({
							type: 'warning',
							html: json.msg
						});
					} else {
						Swal.fire({
							type: 'error',
							html: msgErr
						});
					}
				}
			},
			error: function() {
				Swal.fire({
					type: 'error',
					html: msgErr
				});
			}
		});
	});
});