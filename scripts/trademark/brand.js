/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/trademark/brand.js
 */

$(document).ready(function() {
	var BRAND = {
		dataToUpload: false,
		gridBrand : $('#gridBrand').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('trademark/brand/get_data'),
				method: 'post',
				data: {
					action: 'get_data'
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
				// {
				// 	title: 'Date Submit',
				// 	data: 'created_date',
				// },
				// {
				// 	title: 'Date Update',
				// 	data: 'updated_date',
				// },
				// {
				// 	title: 'User Add',
				// 	data: 'created_user',
				// },
				// {
				// 	title: 'User Update',
				// 	data: 'updated_user',
				// },
				{
					title: 'Application Number',
					data: 'br_app_number'
				},
				// {
				// 	title: 'Receive Date',
				// 	data: 'br_receive_date_new'
				// },
				// {
				// 	title: 'Description',
				// 	data: 'br_description'
				// },
				// {
				// 	title: 'Reminder',
				// 	data: 'br_reminder'
				// },
				{
					title: 'Reg Number',
					data: 'br_reg_number'
				},
				{
					title: 'Status',
					data: 'br_status'
				},
				{
					title: 'Brand',
					data: 'br_name'
				}, 
				{
					title: 'Class',
					data: 'br_class_of_good_or_services'
				},
				{
					title: 'Client',
					data: 'br_owner_name',
				},
				// {
				// 	title: 'Expiry Date',
				// 	data: 'br_expiry_date_new'
				// },
				// {
				// 	title: 'History Status',
				// 	data: 'br_history_status'
				// },
				// {
				// 	title: 'Contact Person',
				// 	data: 'br_contact_person'
				// },
				// {
				// 	title: 'Last Client Update',
				// 	data: 'br_last_client_update'
				// },
				// {
				// 	title: 'Last Client Update',
				// 	data: 'br_last_client_update'
				// },
				// {
				// 	title: 'History Client Update',
				// 	data: 'br_history_client_update'
				// },
				// {
				// 	title: 'Fee',
				// 	data: 'br_fee'
				// },
				// {
				// 	title: 'Bill',
				// 	data: 'br_bill'
				// },
				// {
				// 	title: 'Payment Status',
				// 	data: 'br_payment_status'
				// },
				// {
				// 	title: 'Document',
				// 	data: 'br_document'
				// },
				// {
				// 	title: 'Additional Document',
				// 	data: 'br_additional_document'
				// },
				// {
				// 	title: 'Certificate',
				// 	data: 'br_certificate'
				// },
				// {
				// 	title: 'Logo',
				// 	data: 'br_img'
				// },
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
								BRAND.popup('edit', 'Edit', rowData);
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
											url: siteUrl('trademark/brand/delete_data'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'delete_data',
												br_id: rowData.br_id
											},
											success: function(result) {
												if (result.success) {
													toastr.success("Data succesfully deleted.");
												} else if (typeof(result.msg) !== 'undefined') {
													toastr.error(result.msg);
												} else {
													toastr.error(msgErr);
												}
												
												BRAND.gridBrand.reloadData({
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
					BRAND.popup('edit', 'Edit', rowData);
				}
			}
		}),
		popup: function(mode = 'add', title = 'Add', data = false) {
			$.popup({
				title: title + ' Brand',
				id: mode + 'BrandPopup',
				size: 'large',
				proxy: {
					url: siteUrl('trademark/brand/popup_modal'),
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
					btnIcon: 'far fa-check-circle',
					onclick: function(popup) {
						var form  = popup.find('form');
						if ($.validation(form)) {
							var formData = new FormData(form[0]);
							$.ajax({
								url: siteUrl('trademark/brand/store_data'),
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

									BRAND.gridBrand.reloadData({
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
				listeners: {
					onshow: function(popup) {
						$('#receiveDate').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
						$('#receiveDate').noobsdaterangepicker({
							parentEl: "#" + popup[0].id + " .modal-body",
							showDropdowns: true,
							singleDatePicker: true
						});

						$('#brandReminder').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
						$('#brandReminder').noobsdaterangepicker({
							parentEl: "#" + popup[0].id + " .modal-body",
							showDropdowns: true,
							singleDatePicker: true
						});

						$('#expiryDate').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
						$('#expiryDate').noobsdaterangepicker({
							parentEl: "#" + popup[0].id + " .modal-body",
							showDropdowns: true,
							singleDatePicker: true
						});
					}
				}
			});
		},
		popupUploadExcel: function() {
			$.popup({
				title: 'Upload Brand File',
				id: 'uplodaBrandData',
				size: 'large',
				closeButton: false,
				proxy: {
					url: siteUrl('trademark/brand/popup_upload_excel'),
					params: {
						action: 'popup_upload_excel'
					}
				},
				buttons: [{
					btnId: 'uploadData',
					btnText:'Upload',
					btnClass: 'info',
					btnIcon: 'far fa-check-circle',
					onclick: function(popup) {
						Swal.fire({
							title: 'Are you sure?',
							text: "This process cannot be reversed!",
							type: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#17a2b8',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Yes, upload this data!'
						}).then((result) => {
							if (result.value) {
								$("#btnSelectFile").prop('disabled', true);
								$("#uploadData").prop('disabled', true); 
								$("#closePopupUploadData").prop('disabled', true);

								var total = BRAND.dataToUpload.length;
								var percent = 100 / parseInt(total);

								BRAND.processDataExcel(percent, percent, 0);
							}
						});
					}
				}, {
					btnId: 'closePopupUploadData',
					btnText:'Close',
					btnClass: 'secondary',
					btnIcon: 'fas fa-times',
					onclick: function(popup) {
						popup.close();
					}
				}],
				listeners: {
					onshow: function(popup) {
						$('#btnSelectFile').click(function(e) {
							e.preventDefault();
							$("#file").trigger('click');
						});

						$('#file').change(function() {
							$('#infoText').html('');
							$('#infoText').html(this.files[0].name);

							var form  = popup.find('form');
							if ($.validation(form)) {
								var formData = new FormData(form[0]);
								$.ajax({
									url: siteUrl('trademark/brand/upload_file_excel'),
									type: 'POST',
									dataType: 'JSON',
									data: formData,
									processData: false,
									contentType: false,
			         				cache: false,
			         				enctype: 'multipart/form-data',
									success: function(result) {
										if (result.success) {
											BRAND.dataToUpload = result.data;
											BRAND.generateExcelDataTable();
										} else if (typeof(result.msg) !== 'undefined') {
											toastr.error(result.msg);
										} else {
											toastr.error(msgErr);
										}
									},
									error: function(error) {
										toastr.error(msgErr);
									}
								});
							}
						});
					},
					onclose: function(popup) {
						BRAND.gridBrand.reloadData({
							txt_brand_name: $('#txtBrandName').val(),
							txt_receive_date: $('#txtReceiveDate').val()
						});
					}
				}
			});
		},
		generateExcelDataTable: function() {
			var excelDataTableBody = $('#excelDataTable tbody');
			
			excelDataTableBody.html('');

			var html = '';
			var no = 1;

			if (BRAND.dataToUpload.length > 0) {
				for (var x in BRAND.dataToUpload) {
					var newData = BRAND.dataToUpload[x];
					var tr = $('<tr/>');

					tr.html(`
						<td>` + no + `</td>
						<td>` + newData.br_app_number + `</td>
						<td>` + newData.br_receive_date + `</td>
						<td>` + newData.br_priority + `</td>
						<td>` + newData.br_owner_name + `</td>
						<td>` + newData.br_lawyer_name + `</td>
						<td>` + newData.br_name + `</td>
						<td>` + newData.br_class_of_good_or_services + `</td>
						<td><button type="button" class="btn btn-warning btn-sm btn-view-detail"><i class="fas fa-eye"></i></button></td>
					`);

					no++;

					excelDataTableBody.append(tr);
				}
					/*Additional Column if needed*/
					// <td>` + newData.br_owner_address + `</td>
					// <td>` + newData.br_lawyer_address + `</td>
					// <td>` + newData.br_meaning_of_language + `</td>
					// <td>` + newData.br_color_description + `</td>
					// <td>` + newData.br_desc_of_good_or_services + `</td>
			}

			$('.btn-view-detail').each(function(idx, obj) {
				var btnViewDetail = $(obj);

				btnViewDetail.click(function(e) {
					e.preventDefault();
					BRAND.viewPopupItemDetail(BRAND.dataToUpload[idx]);
				});
			});
		},
		viewPopupItemDetail: function(data) {
			$.popup({
				title: 'Data Detail',
				id: 'dataDetailPopup',
				size: 'large',
				proxy: {
					url: siteUrl('trademark/brand/popup_item_detail'),
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
		},
		processDataExcel: function(step, percent, idx) {

			var uploadProgressBar = $('#uploadProgressBar');
			var percentText = $('#percentText');

			if (percent > 100) {
				uploadProgressBar.css('width', 100 + '%');
				uploadProgressBar.attr('aria-valuenow', 100);
				percentText.html(100 + '% Completed');
				
				toastr.success('Upload data completed.');

				$("#closePopupUploadData").prop('disabled', false);

			} else {
				var params = BRAND.dataToUpload[idx];

				params.action = 'store_data';
				params.mode = 'upload';

				$.ajax({
					url: siteUrl('trademark/brand/store_data'),
					type: 'POST',
					dataType: 'JSON',
					data: params,
					beforeSend: function() {},
					complete: function() {},
					success: function(result) {
						if (result.success) {
							roundPercent = Math.round(percent);

							uploadProgressBar.css('width', roundPercent + '%');
							uploadProgressBar.attr('aria-valuenow', roundPercent);
							percentText.html(roundPercent + '%');

							percent = percent + step;
							idx++;

							BRAND.processDataExcel(step, percent, idx);

						} else if (typeof(result.msg) !== 'undefined') {
							toastr.error(result.msg);
						} else {
							toastr.error(msgErr);
						}
					},
					error: function(error) {
						toastr.error(msgErr);
					}
				});
			}
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

		BRAND.popup();
	});

	$('#btnSearch').click(function(e) {
		e.preventDefault();

		BRAND.gridBrand.reloadData({
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

		BRAND.popupUploadExcel();
	});

	$('#btnDownloadExcel').click(function(e) {
		e.preventDefault();
		
		var cols = JSON.stringify({
			colsIdx: [
				'created_date',
				'updated_date',
				'created_user',
				'updated_user',
				'br_app_number',
				'br_receive_date_new',
				'br_priority',
				'br_owner_name',
				'br_owner_address',
				'br_lawyer_name',
				'br_lawyer_address',
				'br_name',
				'br_meaning_of_language',
				'br_color_description',
				'br_class_of_good_or_services',
				'br_desc_of_good_or_services',
				'br_status',
				'br_description',
				'br_reminder_new',
				'br_reg_number',
				'br_expiry_date_new',
				'br_history_status',
				'br_contact_person',
				'br_last_client_update',
				'br_history_client_update',
				'br_fee',
				'br_bill',
				'br_payment_status',
				'br_document',
				'br_additional_document',
				'br_certificate',
				'br_img'

			],
			colsName: [
				'Date Submit',
				'Date Update',
				'User Add',
				'User Update',
				'Application number',
				'Receive date',
				'Priority',
				'Owner name',
				'Owner address',
				'Lawyer name',
				'Lawyer address',
				'Brand',
				'Meaning of foreign languages/Letters/Numbers',
				'Color description',
				'Class of goods/services',
				'Description of goods/services',
				'Status',
				'Description',
				'Reminder',
				'Reg Number',
				'Expire Date',
				'History Status',
				'Contact Person',
				'Last Client Update',
				'History Client Update',
				'Fee',
				'Bill',
				'Payment Status',
				'Document',
				'Additional Document',
				'Certificate',
				'Logo'

			]
		});

		$('<input />').attr('type', 'hidden')
            .attr('name', 'cols')
            .attr('value', cols)
            .appendTo('#formBrand');

        $('<input />').attr('type', 'hidden')
            .attr('name', 'action')
            .attr('value', 'export_to_excel')
            .appendTo('#formBrand');

        var form = $('#formBrand');

        form.attr('action', siteUrl('trademark/brand/export_to_excel'));
		
		form.submit();
	});
});