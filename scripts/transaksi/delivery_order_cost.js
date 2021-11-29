/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/transaksi/delivery_order_cost.js
 */

$(document).ready(function() {
	var ORDERCOST = {
		gridDeliveryOrderCost : $('#gridDeliveryOrderCost').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('transaksi/delivery_order_cost/load_data'),
				method: 'post',
				data: {
					action: 'load_data'
				},
			},
			columns: [
				{
					title: 'No', 
					data: 'num',
					searchable: false,
					orderable: false,
					css: {
						'text-align': 'center'
					},
					width: 10
				},
				{	
					title: 'No Transaksi', 
					data: 'doc_so_no_trx',
				},
				{	
					title: 'Kendaraan', 
					data: 've_license_plate',
				},
				{	
					title: 'Pengemudi', 
					data: 'd_name',
				},
				{	
					title: 'Total', 
					data: 'doc_amount',
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
							icon: 'fas fa-edit',
							click: function(row, rowData) {
								// console.log(rowData)
								ORDERCOST.popup('edit', 'Edit', rowData);
							}
						},
						{
							text: '',
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
											url: siteUrl('transaksi/delivery_order_cost/delete_data'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'delete_data',
												txt_id: rowData.c_id
											},
											success: function(result) {
												if (result.success) {
													toastr.success("Data succesfully deleted.");
												} else if (typeof(result.msg) !== 'undefined') {
													toastr.error(result.msg);
												} else {
													toastr.error(msgErr);
												}
												
												ORDERCOST.gridDeliveryOrderCost.reloadData({
													txt_id: $('#txtName').val()
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
					],
				}
			],
			listeners: {
				ondblclick: function(row, rowData, idx) {
					ORDERCOST.popup('edit', 'Edit', rowData);
				}
			}
		}),
		popup: function(mode = 'add', title= 'Add', data = false)
		{
			console.log(data.c_distance_area)
			$.popup({
				title: title + ' Pelanggan',
				id: mode + 'CustomerPopup',
				size: 'medium',
				proxy: {
					url: siteUrl('transaksi/delivery_order_cost/load_customer_form'),
					params: {
						action: 'load_customer_form',
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
								url: siteUrl('transaksi/delivery_order_cost/store_data_customer'),
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

									ORDERCOST.gridDeliveryOrderCost.reloadData({
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
				}],
				listeners: {
					onshow: function(popup) {
						$('#userBirthday').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
						$('#userBirthday').noobsdaterangepicker({
							parentEl: "#" + popup[0].id + " .modal-body",
							showDropdowns: true,
							singleDatePicker: true,
							locale: {
								format: 'DD-MM-YYYY'
							}
						});

						if (mode == 'edit') {
							// ORDERCOST.generateUserSubGroup($('#userGroup').val(), data.ud_sub_group);
							ORDERCOST.generateRegion($('#txt_province').val(),data.rd_id);
							ORDERCOST.generateDistrict(data.rd_id,data.rsd_id);
						}

						$('#txt_province').change(function() {
						var me = $(this);
						
							if (me.val() !== '') {
								
								ORDERCOST.generateRegion(me.val());

							} else {
								$('#txt_region').html($('<option>', {
									value: '',
									text: 'Pilih Provinsi'
								}));

								$('#txt_region').attr('disabled', true);
							}
							$('#txt_district').attr('disabled', true);
							$('#txt_district').html($('<option>', {
								value: '',
								text: '--Pilih Kabupaten / Kota--'
							}));
						});	

						$('#txt_region').change(function() {
							var me = $(this);
						

								if (me.val() !== '') {
									
									ORDERCOST.generateDistrict(me.val());

								} else {
									$('#txt_district').html($('<option>', {
										value: '',
										text: 'Pilih Kabupaten/Kota'
									}));

									$('#txt_district').attr('disabled', true);
								}
						});

						$('#fileAvatar').change(function(a){
							var $this = $(this);
							var $next = $this.next();

							$next.html($this[0].files[0].name);
						});
					}
				}
			});
		},
		generateRegion: function(provinceId, regionId = false) {
		var region = $('#txt_region');
			// console.log(provinceId)
			$.ajax({
				url: siteUrl('transaksi/delivery_order_cost/get_region_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_region_option',
					prov_id: provinceId
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						region.attr('disabled', false);

						region.html($('<option>', {
							value: '',
							text: '--Pilih Kabupaten / Kota--'
						}));
						
						data.forEach(function (newData) {
							region.append($('<option>', {
								value: newData.rd_id,
								text: newData.rd_name
							}));
						});

						if (regionId !== false) region.val(regionId);

					} else {

						region.html($('<option>', {
							value: '',
							text: 'Kabupaten tidak ditemukan!'
						}));
					}
				},
				error: function (error) {
					toastr.error(msgErr);
				}
			});
		},
		generateDistrict: function(regionId, districtId = false) {
			var district = $('#txt_district');
				
				$.ajax({
					url: siteUrl('transaksi/delivery_order_cost/get_district_option'),
					type: 'POST',
					dataType: 'JSON',
					beforeSend: function() {},
					complete: function() {},
					data: {
						action: 'get_district_option',
						district_id: regionId
					},
					success: function (result) {
						if (result.success) {
							var data = result.data;

							district.attr('disabled', false);

							district.html($('<option>', {
								value: '',
								text: '--Pilih Kecamatan--'
							}));
							
							data.forEach(function (newData) {
								district.append($('<option>', {
									value: newData.rsd_id,
									text: newData.rsd_name
								}));
							});

							if (districtId !== false) district.val(districtId);

						} else {

							district.html($('<option>', {
								value: '',
								text: 'Kecamatan tidak ditemukan!'
							}));
						}
					},
					error: function (error) {
						toastr.error(msgErr);
					}
				});
		}
	};

	$('#btnAdd').click(function(e) {
		e.preventDefault();

		ORDERCOST.popup();
	});

	$('#txtName').noobsautocomplete({
		remote: true,
		placeholder: 'Find data.',
		proxy: {
			url: siteUrl('transaksi/delivery_order_cost/get_autocomplete_data'),
			method: 'post',
			data: {
				action: 'get_autocomplete_data'
			},
		},
		listeners: {
			onselect: function(data) {
				ORDERCOST.gridDeliveryOrderCost.reloadData({
					txt_id: $('#txtName').val()
				});
			},
			onclear: function(obj) {
				ORDERCOST.gridDeliveryOrderCost.reloadData({});
			}
		}
	});
});