/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/master_data/brand.js
 */

$(document).ready(function() {
	var RAB = {
		gridRabItem : $('#gridRab').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('master_data/rab_list/load_data'),
				method: 'post',
				data: {
					action: 'load_data'
				},
			},
			columns: [
				{
					title: 'No', 
					data: 'no',
					searchable: false,
					orderable: false,
					css: {
						'text-align': 'center'
					}
				},
				{
					title: 'Item Name',
					data: 'work'
				},
				{
					title: 'RAB Unit',
					data: 'unit_rab'
				},
				{
					title: 'Material',
					data: 'material'
				},
				{
					title: 'Volume',
					data: 'volume'
				},
				{
					title: 'Unit',
					data: 'unit_item'
				},
				{
					title: 'Action',
					size: 'medium',
					type: 'buttons',
					group: true,
					css: {
						'text-align' : 'center',
						'width' : '200px'
					},
					content: [
						{
							text: 'Edit',
							class: 'btn-success',
							id: 'btnEdit',
							icon: 'far fa-edit',
							click: function(row, rowData) {
								RAB.popup('edit', 'Edit', rowData);
							}
						},
						{
							text: 'Delete',
							class: 'btn-danger',
							id: 'btnDelete',
							icon: 'far fa-trash-alt',
							click: function(row, rowData) {
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
											url: siteUrl('master_data/rab_list/delete_data'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'delete_data',
												txt_id: rowData.id
											},
											success: function(result) {
												if (result.success) {
													toastr.success("Data succesfully deleted.");
												} else if (typeof(result.msg) !== 'undefined') {
													toastr.error(result.msg);
												} else {
													toastr.error(msgErr);
												}
												
												RAB.gridRabItem.reloadData({
													txt_brand_name: $('#txtBrandName').val(),
													txt_receive_date: $('#txtReceiveDate').val()
												});
											},
											error: function(error) {
												toastr.error(msgErr);
											}
										});
									}
								});
							}
						}
					]
				}
			],
			listeners: {
				ondblclick: function(row, rowData, idx) {
					RAB.popup('edit', 'Edit', rowData);
				}
			}
		}),
		popup: function(mode = 'add', title = 'Add', data = false) {
			$.popup({
				title: title + ' RAB List',
				id: mode + 'RabPopup',
				size: 'medium',
				proxy: {
					url: siteUrl('master_data/rab_list/popup_modal'),
					params: {
						action: 'popup_modal',
						mode: mode,
						data: data
					}
				},
				buttons: [{
					btnId: 'saveData',
					btnText:'Save',
					btnClass: 'info',
					btnIcon: 'fas fa-check-circle',
					onclick: function(popup) {
						var form  = popup.find('form');
						if ($.validation(form)) {
							var formData = new FormData(form[0]);
							$.ajax({
								url: siteUrl('master_data/rab_list/store_data'),
								type: 'POST',
								dataType: 'JSON',
								data: formData,
								processData: false,
								contentType: false,
		         				cache: false,
		         				enctype: 'multipart/form-data',
								success: function(result) {
									if (result.success) {
										toastr.success(msgSaveOk);
									} else if (typeof(result.msg) !== 'undefined') {
										toastr.error(result.msg);
									} else {
										toastr.error(msgErr);
									}

									RAB.gridRabItem.reloadData({
										txt_brand_name: $('#txtBrandName').val(),
										txt_receive_date: $('#txtReceiveDate').val()
									});

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
					btnText:'Tutup',
					btnClass: 'secondary',
					btnIcon: 'fas fa-times',
					onclick: function(popup) {
						popup.close();
					}
				}],
			});
		},
		viewPopupItemDetail: function(data) {
			$.popup({
				title: 'Data Detail',
				id: 'dataDetailPopup',
				size: 'large',
				proxy: {
					url: siteUrl('master_data/rab_list/popup_item_detail'),
					params: {
						action: 'popup_item_detail',
						mode: 'view',
						data: data
					}
				},
				buttons: [{
					btnId: 'closePopup',
					btnText:'Tutup',
					btnClass: 'secondary',
					btnIcon: 'fas fa-times',
					onclick: function(popup) {
						popup.close();
					}
				}]
			});
		}
	};

	$('#txtReceiveDate').noobsdaterangepicker({
		showDropdowns: true,
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});

	$('#btnAdd').click(function(e) {
		e.preventDefault();

		RAB.popup();
	});

	$('#btnSearch').click(function(e) {
		e.preventDefault();

		RAB.gridRabItem.reloadData({
			txt_brand_name: $('#txtBrandName').val(),
			txt_receive_date: $('#txtReceiveDate').val()
		});
	});

	$('#txtBrandName').keydown(function(e) {
    	var keyCode = (e.keyCode ? e.keyCode : e.which);
	    if (keyCode == 13) {
	        $('#btnSearch').trigger('click');
	    }
	});

	$('#btnUploadExcel').click(function(e) {
		e.preventDefault();

		RAB.popupUploadExcel();
	});

});