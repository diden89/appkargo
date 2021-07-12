/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/trademark/brm_list.js
 */

const brmList = {
	init: function() {
		const me = this;

		$('#btnSearchBrm').click(function(e) {
			e.preventDefault();
			me.loadDataBrm(this);
		});

		$('#txtBrm').keydown(function(e) {
			const keyCode = (e.keyCode ? e.keyCode : e.which);

			if (keyCode == 13) {
				$('#btnSearchBrm').trigger('click');
			}
		});

		$('#bp_month').on('change',function(e){
			$.ajax({
				url: siteUrl('trademark/brm_list/load_data_brm'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'load_data_brm',
					txt_year: $('#bp_year').val(),
					txt_month: $('#bp_month').val()
				},
				success: function(result) {
					$('#brmListDataTable tbody').html('');

					if (result.success !== false) me._generateBrmDataTable(result.data);
					else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
					else toastr.error(msgErr);
				},
				error: function(error) {
					toastr.error(msgErr);
				}
			});
		});
		$('#bp_year').on('change',function(e){
			$.ajax({
				url: siteUrl('trademark/brm_list/load_data_brm'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'load_data_brm',
					txt_year: $('#bp_year').val(),
					txt_month: $('#bp_month').val(),
				},
				success: function(result) {
					$('#brmListDataTable tbody').html('');

					if (result.success !== false) me._generateBrmDataTable(result.data);
					else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
					else toastr.error(msgErr);
				},
				error: function(error) {
					toastr.error(msgErr);
				}
			});
		});
	},
	loadDataBrm: function(el) {
		const me = this;
		const $this = $(el);

		$.ajax({
			url: siteUrl('trademark/brm_list/load_data_brm'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_brm',
				txt_brm: $('#txtBrm').val()
			},
			success: function(result) {
				$('#brmListDataTable tbody').html('');

				if (result.success !== false) me._generateBrmDataTable(result.data);
				else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
				else toastr.error(msgErr);
			},
			error: function(error) {
				toastr.error(msgErr);
			}
		});
	},
	_generateBrmDataTable: (data) => {
		const $this = $('#brmListDataTable tbody');

		$this.html('');

		let body = '';

		$.each(data, (idx, item) => {
			body += '<tr>';
			body += '<td>' + item.no + '</td>';
			body += '<td>' + item.bp_brm_num + '</td>';
			body += '<td>' + item.bp_caption + '</td>';
			body += '<td>' + item.bp_website + '</td>';
			body += '<td>' + item.bp_link + '</td>';
			body += '<td>' + item.bp_month + '</td>';
			body += '<td>' + item.bp_year + '</td>';
			body += '<td>' + item.start_date + '</td>';
			body += '<td>' + item.end_date + '</td>';
			body += '</tr>';
		});

		$this.html(body);
	}
};

$(document).ready(function() {
	brmList.init();
});