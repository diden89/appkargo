/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/master_data/vehicle.js
 */

const itemList = {
	selectedData: '',
	init: function() {
		const me = this;

		$('#btnSearchItem').click(function(e) {
			e.preventDefault();
			me.loadDataItem(this);
		});
		$('#btnReloadItem').click(function(e) {
			$('#txtList').val('')
			e.preventDefault();
			me.loadDataItem(this);
		});

		$('#txtList').keydown(function(e) {
			const keyCode = (e.keyCode ? e.keyCode : e.which);

			if (keyCode == 13) {
				$('#btnSearchItem').trigger('click');
			}
		});

		$('#btnAddItem').click(function(e) {
			e.preventDefault();
			me.showItem(this);
		});
	},
	loadDataItem: function(el) {
		const me = this;
		const $this = $(el);

		$.ajax({
			url: siteUrl('master_data/vehicle/load_data_vehicle'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_vehicle',
				txt_item: $('#txtList').val()
			},
			success: function(result) {
				$('#ignoredItemDataTable tbody').html('');
				
				if (result.success !== false)
				{
					if(result.msg !== undefined) toastr.info(result.msg);
					me._generateItemDataTable(result.data);
				} 
				else if (typeof(result.msg) !== 'undefined')
				{
					toastr.error(result.msg);
				} 
				else
				{
					toastr.error(msgErr);
				} 

			},
			error: function(error) {
				toastr.error(msgErr);
			}
		});
	},
	_generateItemDataTable: (data) => {
		const $this = $('#ignoredItemDataTable tbody');

		$this.html('');

		let body = '';

		$.each(data, (idx, item) => {
			body += '<tr>';
			body += '<td>' + item.no + '</td>';
			body += '<td>' + item.ve_license_plate + '</td>';
			body += '<td>' + item.ve_name + '</td>';
			body += '<td>' + item.ve_status + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.ve_id + '" data-item="' + item.ve_name + '" onclick="itemList.showItem(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.ve_id + '" data-item="' + item.ve_name + '" onclick="itemList.deleteDataVehicle(this);"><i class="fas fa-trash-alt"></i></button>';
				body += '</div>';
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	showItem: function(el, mode) {
		console.log(el)
		const me = this;
		let params = {action: 'load_vehicle_form'};
		let title = 'Add New';

		if (typeof(mode) !== 'undefined') {
			params.mode = mode;
			title = 'Edit';
			params.txt_item = $(el).data('item');
			params.txt_id = $(el).data('id');
		}
		else
		{
			params.mode = 'add';
		}

		$.popup({
			title: title + ' Vehicle',
			id: 'showItem',
			size: 'medium',
			proxy: {
				url: siteUrl('master_data/vehicle/load_vehicle_form'),
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
							url: siteUrl('master_data/vehicle/store_data_vehicle'),
							type: 'POST',
							dataType: 'JSON',
							data: formData,
							processData: false,
							contentType: false,
	         				cache: false,
							success: function(result) {
								if (result.success) {
									toastr.success(msgSaveOk);
									me._generateItemDataTable(result.data);
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
	deleteDataVehicle: function(el) {
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
					url: siteUrl('master_data/vehicle/delete_data_vehicle'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data_item',
						txt_id: $this.data('id')
					},
					success: function(result) {
						$('#ignoredItemDataTable tbody').html('');
						
						if (result.success !== false)
						{
							toastr.info(result.msg);
							me._generateItemDataTable(result.data);
						} 
						else if (typeof(result.msg) !== 'undefined')
						{
							toastr.error(result.msg);
						} 
						else
						{
							toastr.error(msgErr);
						} 
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
	itemList.init();
});