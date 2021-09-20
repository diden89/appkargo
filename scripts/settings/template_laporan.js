/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/settings/template.js
 */

$(document).ready(function() {

	var TEMPLATE = {
		gridTemplateLaporan : $('#gridTemplateLaporan').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('settings/template_laporan/load_data'),
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
					},
					width: 10
				},
				{	
					title: 'Vendor Name', 
					data: 'v_vendor_name',
				},
				{	
					title: 'Template', 
					data: 'tl_name',
				},
				{	
					title: 'Template File', 
					data: 'tl_file_template',
				},
				{
					title: 'Action',
					size: 'medium',
					type: 'buttons',
					group: true,
					css: {
						'text-align' : 'center',
						'width' : '150px'
					},
					content: [
						{
							text: '',
							class: 'btn-success',
							id: 'btnEdit',
							icon: 'far fa-edit',
							click: function(row, rowData) {
								TEMPLATE.popup('edit', 'Edit', rowData);
							}
						},
						// {
						// 	text: '',
						// 	class: 'btn-danger',
						// 	id: 'btnDelete',
						// 	icon: 'far fa-trash-alt',
						// 	click: function(row, rowData) {
						// 		Swal.fire({
						// 			title: 'Are you sure?',
						// 			text: "Data that has been deleted cannot be restored!",
						// 			type: 'warning',
						// 			showCancelButton: true,
						// 			confirmButtonColor: '#17a2b8',
						// 			cancelButtonColor: '#d33',
						// 			confirmButtonText: 'Yes, delete this data!'
						// 		}).then((result) => {
						// 			if (result.value) {
						// 				$.ajax({
						// 					url: siteUrl('settings/template_laporan/delete_data'),
						// 					type: 'POST',
						// 					dataType: 'JSON',
						// 					data: {
						// 						action: 'delete_data',
						// 						txt_id: rowData.v_id
						// 					},
						// 					success: function(result) {
						// 						if (result.success) {
						// 							toastr.success("Data succesfully deleted.");
						// 						} else if (typeof(result.msg) !== 'undefined') {
						// 							toastr.error(result.msg);
						// 						} else {
						// 							toastr.error(msgErr);
						// 						}
												
						// 						TEMPLATE.gridTemplateLaporan.reloadData({
						// 							txt_id: $('#txtName').val()
						// 						});
						// 					},
						// 					error: function(error) {
						// 						toastr.error(msgErr);
						// 					}
						// 				});
						// 			}
						// 		});
						// 	}
						// },
					],
				}
			],
			listeners: {
				ondblclick: function(row, rowData, idx) {
					TEMPLATE.popup('edit', 'Edit', rowData);
				}
			}
		}),
		popup: function(mode = 'add', title= 'Add', data = false)
		{
			$.popup({
				title: title + ' Template Laporan',
				id: mode + 'UserPopup',
				size: 'medium',
				proxy: {
					url: siteUrl('settings/template_laporan/template_laporan_form'),
					params: {
						action: 'template_laporan_form',
						mode: mode,
						data: data
					}
				},
				buttons: [{
					btnId: 'saveData',
					btnText:'Save',
					btnClass: 'info',
					btnIcon: 'far fa-check-circle',
					onclick: function(popup) {
						var form  = popup.find('form');
						if ($.validation(form)) {
							var formData = new FormData(form[0]);
							$.ajax({
								url: siteUrl('settings/template_laporan/store_data'),
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

									TEMPLATE.gridTemplateLaporan.reloadData({
										txt_id: $('#txtName').val()
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
					btnText:'Close',
					btnClass: 'secondary',
					btnIcon: 'fas fa-times',
					onclick: function(popup) {
						popup.close();
					}
				}]
			});
		}
	};

	$('#btnAdd').click(function(e) {
		e.preventDefault();

		TEMPLATE.popup();
	});

	$('#txtName').noobsautocomplete({
		remote: true,
		placeholder: 'Find data.',
		proxy: {
			url: siteUrl('settings/template_laporan/get_autocomplete_data'),
			method: 'post',
			data: {
				action: 'get_autocomplete_data'
			},
		},
		listeners: {
			onselect: function(data) {
				TEMPLATE.gridTemplateLaporan.reloadData({
					txt_id: $('#txtName').val()
				});
			},
			onclear: function(obj) {
				TEMPLATE.gridTemplateLaporan.reloadData({});
			}
		}
	});

});