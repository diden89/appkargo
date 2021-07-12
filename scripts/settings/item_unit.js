/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/settings/similar_letters.js
 */

const itemUnit = {
	init: function() {
		const me = this;

		$('#btnSearchUnit').click(function(e) {
			e.preventDefault();
			me.loadDataUnit(this);
		});

		$('#txtUnit').keydown(function(e) {
			const keyCode = (e.keyCode ? e.keyCode : e.which);

			if (keyCode == 13) {
				$('#btnSearchUnit').trigger('click');
			}
		});

		$('#btnAddUnit').click(function(e) {
			e.preventDefault();
			me.showUnit(this);
		});
	},
	loadDataUnit: function(el) {
		const me = this;
		const $this = $(el);

		$.ajax({
			url: siteUrl('settings/item_unit/load_data_item_unit'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_item_unit',
				txt_unit: $('#txtUnit').val()
			},
			success: function(result) {
				$('#itemUnitDataTable tbody').html('');

				if (result.success !== false) me._generateUnitDataTable(result.data);
				else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
				else toastr.error(msgErr);
			},
			error: function(error) {
				toastr.error(msgErr);
			}
		});
	},
	_generateUnitDataTable: (data) => {
		const $this = $('#itemUnitDataTable tbody');

		$this.html('');

		let body = '';

		$.each(data, (idx, item) => {
			body += '<tr>';
			body += '<td>' + item.no + '</td>';
			body += '<td>' + item.un_name + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.id + '" data-unit="' + item.unit + '" onclick="itemUnit.showUnit(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.id + '" data-unit="' + item.unit + '" onclick="itemUnit.deleteDataUnit(this);"><i class="fas fa-trash-alt"></i></button>';
				body += '</div>';
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	showUnit: function(el, mode) {
		const me = this;
		let params = {action: 'load_item_unit_form'};
		let title = 'Add new';

		if (typeof(mode) !== 'undefined') {
			params.mode = mode;
			title = 'Edit';
			params.txt_unit = $(el).data('unit');
			params.txt_id = $(el).data('id');
		}

		$.popup({
			title: title + ' Unit',
			id: 'showUnit',
			size: 'small',
			proxy: {
				url: siteUrl('settings/item_unit/load_item_unit_form'),
				params: params
			},
			buttons: [{
				btnId: 'saveData',
				btnText:'Save',
				btnClass: 'info',
				btnIcon: 'far fa-check-circle',
				onclick: function(popup) {
					const form  = popup.find('form');

					if ($.validation(form)) {
						const formData = new FormData(form[0]);

						$.ajax({
							url: siteUrl('settings/item_unit/store_data_item_unit'),
							type: 'POST',
							dataType: 'JSON',
							data: formData,
							processData: false,
							contentType: false,
	         				cache: false,
							success: function(result) {
								if (result.success) {
									toastr.success(msgSaveOk);
									me._generateUnitDataTable(result.data);
								} else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
								else toastr.error(msgErr);

								popup.close();

							},
							error: function(error) {
								toastr.error(msgErr);
							}
						});
					}
				}
			}, {
				btnId: 'closePopup',
				btnText:'Close',
				btnClass: 'secondary',
				btnIcon: 'fas fa-times',
				onclick: function(popup) {
					popup.close();
				}
			}]
		});
	},
	deleteDataUnit: function(el) {
		const me = this;
		const $this = $(el);

		Swal.fire({
			title: 'Are you sure?',
			text: "Data that has been deleted cannot be restored!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#17a2b8',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete this data!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: siteUrl('settings/item_unit/delete_data_item_unit'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data_item_unit',
						txt_id: $this.data('id')
					},
					success: function(result) {
						$('#itemUnitDataTable tbody').html('');
						
						if (result.success) me._generateUnitDataTable(result.data);
						else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
						else toastr.error(msgErr);
					},
					error: function(error) {
						toastr.error(msgErr);
					}
				});
			}
		});
	}
};

$(document).ready(function() {
	itemUnit.init();
});