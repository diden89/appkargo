/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/master_data/vendor.js
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
			url: siteUrl('master_data/vendor/load_data_vendor'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_vendor',
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
			body += '<td>' + item.v_vendor_name + '</td>';
			body += '<td>' + item.v_vendor_add + '</td>';
			body += '<td>' + item.v_vendor_phone + '</td>';
			body += '<td>' + item.v_vendor_email + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.v_id + '" data-item="' + item.v_vendor_name + '" onclick="itemList.showItem(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.v_id + '" data-item="' + item.v_vendor_name + '" onclick="itemList.deleteDataVendor(this);"><i class="fas fa-trash-alt"></i></button>';
				body += '</div>';
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	showItem: function(el, mode) {
		
		const me = this;
		let params = {action: 'load_vendor_form'};
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
			title: title + ' Vendor',
			id: 'showItem',
			size: 'medium',
			proxy: {
				url: siteUrl('master_data/vendor/load_vendor_form'),
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
							url: siteUrl('master_data/vendor/store_data_vendor'),
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
			}],
			listeners : {
				onShow : function(popup) {
					$('#check_vendor').on('click',function() {
						var check = $('#check_vendor').is(':checked');
							akses = $('#select-meal-type');
							console.log(akses)
						if(check == true)
						{
							akses.attr('disabled', false);
						}
						else
						{
							akses.attr('disabled', true);
						}
					});
				}
			}
		});
	},
	deleteDataVendor: function(el) {
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
					url: siteUrl('master_data/vendor/delete_data_vendor'),
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