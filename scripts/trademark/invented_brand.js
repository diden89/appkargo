/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/trademark/invented_brand.js
 */

$(document).ready(function() {
	const INVENTED_BRAND = {
		viewSkipped: 'N',
		viewRegistered: 'N',
		gridInventedBrand : $('#gridInventedBrand').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('trademark/invented_brand/get_data'),
				method: 'post',
				data: {
					action: 'get_data',
					txt_view_registered: 'N'
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
				// {
				// 	title: 'BRM Number',
				// 	data: 'bp_brm_num'
				// },
				// {
				// 	title: 'Publish Date',
				// 	data: 'bp_brm_published_date'
				// },
				{
					title: 'Application Number',
					data: 'b_application_number'
				},
				{
					title: 'Filling Date',
					data: 'b_receipt_date_new'
				},
				{
					title: 'Class',
					data: 'b_class'
				},
				{
					title: 'Trademark Findings',
					data: 'b_brand'
				},
				{
					title: "Client's Trademarks",
					data: 'br_name'
				},
				{
					title: "Client's Application Number",
					data: 'b_application_number'
				},
				{
					title: 'Websited',
					data: 'bp_website'
				},
				// {
				// 	title: 'Status',
				// 	data: 'status'
				// },
				{
					title: 'Tanggal Publikasi BRM',
					data: 'publish_date'
				},
				// {
				// 	title: 'Year',
				// 	data: 'bp_year'
				// },
				{
					title: 'File',
					size: 'medium',
					type: 'buttons',
					group: true,
					css: {
						'text-align' : 'center',
						'width' : '200px'
					},
					content: [
						{
							text: 'View File',
							class: 'btn-info btn-sm',
							id: 'btnFile',
							icon: 'far fa-file-pdf',
							click: function(row, rowData) {
								window.open(rowData.file_link, '_blank');
							}
						}
					]
				},
				{
					title: 'Change Status',
					size: 'medium',
					type: 'buttons',
					group: true,
					css: {
						'text-align' : 'center',
						'width' : '200px'
					},
					content: [
						{
							text: 'Hold',
							class: 'btn-secondary',
							id: 'btnHold',
							icon: 'fas fa-pause',
							click: function(row, rowData) {
								Swal.fire({
									title: 'Are you sure?',
									text: "Data that has been hold cannot be restored!",
									type: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#17a2b8',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Yes, hold this data!'
								}).then((result) => {
									if (result.value) {
										$.ajax({
											url: siteUrl('trademark/invented_brand/hold_data'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'hold_data',
												ib_id: rowData.ib_id
											},
											success: function(result) {
												if (result.success) {
													toastr.success("Data succesfully holded.");
												} else if (typeof(result.msg) !== 'undefined') {
													toastr.error(result.msg);
												} else {
													toastr.error(msgErr);
												}
												
												INVENTED_BRAND.gridInventedBrand.reloadData({
													txt_brand_name: $('#txtInventedBrandName').val(),
													txt_receive_date: $('#txtReceiveDate').val(),
													txt_status: $('#txtStatus').val(),
													// txt_view_skipped: INVENTED_BRAND.viewSkipped,
													txt_view_registered: INVENTED_BRAND.viewRegistered
												});
											},
											error: function(error) {
												toastr.error(msgErr);
											}
										});
									}
								});
							}
						}, 
						{
							text: 'Skip',
							class: 'btn-success',
							id: 'btnSkip',
							icon: 'fas fa-check',
							click: function(row, rowData) {
								Swal.fire({
									title: 'Are you sure?',
									text: "Data that has been skipped cannot be restored!",
									type: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#17a2b8',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Yes, skip this data!'
								}).then((result) => {
									if (result.value) {
										$.ajax({
											url: siteUrl('trademark/invented_brand/skip_data'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'skip_data',
												ib_id: rowData.ib_id
											},
											success: function(result) {
												if (result.success) {
													toastr.success("Data succesfully skipped.");
												} else if (typeof(result.msg) !== 'undefined') {
													toastr.error(result.msg);
												} else {
													toastr.error(msgErr);
												}
												
												INVENTED_BRAND.gridInventedBrand.reloadData({
													txt_brand_name: $('#txtInventedBrandName').val(),
													txt_receive_date: $('#txtReceiveDate').val(),
													txt_status: $('#txtStatus').val(),
													// txt_view_skipped: INVENTED_BRAND.viewSkipped,
													txt_view_registered: INVENTED_BRAND.viewRegistered
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
			]
		}),
		popup: function(mode = 'add', title = 'Add', data = false) {
			$.popup({
				title: title + ' Invented Brand',
				id: mode + 'InventedBrandPopup',
				size: 'large',
				proxy: {
					url: siteUrl('trademark/invented_brand/popup_modal'),
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
								url: siteUrl('trademark/invented_brand/store_data'),
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

									INVENTED_BRAND.gridInventedBrand.reloadData({
										txt_brand_name: $('#txtInventedBrandName').val(),
										txt_receive_date: $('#txtReceiveDate').val(),
										txt_view_skipped: INVENTED_BRAND.viewSkipped,
										txt_view_registered: INVENTED_BRAND.viewRegistered
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
					}
				}
			});
		},
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

		INVENTED_BRAND.popup();
	});

	$('#btnSearch').click(function(e) {
		e.preventDefault();

		INVENTED_BRAND.gridInventedBrand.reloadData({
			txt_brand_name: $('#txtInventedBrandName').val(),
			txt_receive_date: $('#txtReceiveDate').val(),
			txt_status: $('#txtStatus').val(),
			// txt_view_skipped: INVENTED_BRAND.viewSkipped,
			txt_view_registered: INVENTED_BRAND.viewRegistered
		});
	});

	$('#txtInventedBrandName').keydown(function(e) {
    	var keyCode = (e.keyCode ? e.keyCode : e.which);
	    if (keyCode == 13) {
	        $('#btnSearch').trigger('click');
	    }
	});

	$('#txtStatus').change(function() {
		$('#btnSearch').trigger('click');
	});

	// $('#txtSkippedStatus').bootstrapSwitch({
	// 	onText: 'YES',
	// 	offText: 'NO',
	// 	onSwitchChange: function(e, state) {
	// 		if (state == true) INVENTED_BRAND.viewSkipped = 'Y';
	// 		else INVENTED_BRAND.viewSkipped = 'N';
			
	// 		INVENTED_BRAND.gridInventedBrand.reloadData({
	// 			txt_brand_name: $('#txtInventedBrandName').val(),
	// 			txt_receive_date: $('#txtReceiveDate').val(),
	// 			txt_view_skipped: INVENTED_BRAND.viewSkipped,
	// 			txt_view_registered: INVENTED_BRAND.viewRegistered
	// 		});
	// 	}
	// });

	$('#txtRegistredBrand').bootstrapSwitch({
		onText: 'YES',
		offText: 'NO',
		onSwitchChange: function(e, state) {
			if (state == true) INVENTED_BRAND.viewRegistered = 'Y';
			else INVENTED_BRAND.viewRegistered = 'N';

			INVENTED_BRAND.gridInventedBrand.reloadData({
				txt_brand_name: $('#txtInventedBrandName').val(),
				txt_receive_date: $('#txtReceiveDate').val(),
				txt_status: $('#txtStatus').val(),
				// txt_view_skipped: INVENTED_BRAND.viewSkipped,
				txt_view_registered: INVENTED_BRAND.viewRegistered
			});
		}
	});
});
