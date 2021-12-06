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
					data: 'doc_so_no_trx',
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
							class: 'btn-warning',
							id: 'btnView',
							icon: 'fas fa-eye',
							click: function(row, rowData) {
								// console.log(rowData)
								ORDERCOST.popup('view', 'View', rowData);
							}
						},
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
			$.popup({
				title: 'Form Biaya Operasional DO',
				id: mode + 'OrderCostPopup',
				size: 'large',
				proxy: {
					url: siteUrl('transaksi/delivery_order_cost/load_delivery_order_cost_form'),
					params: {
						action: 'load_delivery_order_cost_form',
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
						// ORDERCOST.generateAkunHeader();
						ORDERCOST.generateAkunDetail('4');
						$('#created_date').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
						$('#created_date').noobsdaterangepicker({
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

						$('#btnAddDetail').click(function(){

							var so_no_trx = $('#txt_sales_order').val();
								akun_detail = $('#akun_detail').val();
								total = $('#total').val();
								keterangan = $('#keterangan').val();
								
							$.ajax({
								url: siteUrl('transaksi/delivery_order_cost/store_data_temporary'),
								type: 'POST',
								dataType: 'JSON',
								data: {
									action: 'insert_temporary_data',
									so_no_trx: so_no_trx,
									akun_detail: akun_detail,
									total: total,
									keterangan: keterangan,
									mode : mode
								},
								success: function(result) {
									if (result.success) {
										toastr.success("Data succesfully added.");
										ORDERCOST._generateTemporaryDataTable(result.data);

										$('#akun_header').prop('selectedIndex',0);
										$('#akun_detail').prop('selectedIndex',0);
										$('#cid_keterangan').val('');
										$('#cid_total').val('');
										$('#cid_id').val('');
										$('#key_lock').val('');
										
										ORDERCOST.getTotalAmount(ci_no_trx);

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
								
						});

						$('#txt_sales_order').change(function() {
							var me = $(this);
								
								$('#btnAddDetail').attr('disabled', false);
							
								if (me.val() !== '') {
									
									ORDERCOST.generateVehicle(me.val());

								} else {
									$('#vehicle_id').html($('<option>', {
										value: '',
										text: 'Pilih Kendaraan'
									}));

									$('#vehicle_id').attr('disabled', true);
								}
						});	

						$('#total').on('keyup',function(event) {
							if(Number.isInteger($('#total').val()))
							{
								Swal.fire({
									title: 'Maaf !!',
									text: "Jumlah dan total dana harus sama nilainya",
									type: 'warning',
									showCancelButton: false,
									confirmButtonColor: '#17a2b8',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Close!'
								})
							}
							else
							{	
								// skip for arrow keys
								if(event.which >= 37 && event.which <= 40) return;

								// format number
								$(this).val(function(index, value) {
								return value
								.replace(/\D/g, "")
								.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
								;
								});
							}
						});

						// $('#vehicle_id').change(function() {
						// 	var me = $(this);
						// 		if (me.val() !== '') {
									
						// 			ORDERCOST.generateVehicle(me.val());

						// 		} else {
						// 			$('#vehicle_id').html($('<option>', {
						// 				value: '',
						// 				text: 'Pilih Kendaraan'
						// 			}));

						// 			$('#vehicle_id').attr('disabled', true);
						// 		}
								
						// });	

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

						// $('#akun_header').change(function() {
						// 	var me = $(this);
							
						// 	if (me.val() !== '') {
								
						// 		ORDERCOST.generateAkunDetail(me.val());

						// 	} else {
						// 		$('#akun_detail').html($('<option>', {
						// 			value: '',
						// 			text: '--Akun Detail--'
						// 		}));

						// 		$('#akun_detail').attr('disabled', true);
						// 	}
						// });	
					}
				}
			});
		},
		generateVehicle: function(no_trx, ve_id = false) {
		var vehicle = $('#vehicle_id');
			// console.log(provinceId)
			$.ajax({
				url: siteUrl('transaksi/delivery_order_cost/get_vehicle_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_vehicle_option',
					no_trx: no_trx
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						vehicle.attr('disabled', false);

						vehicle.html($('<option>', {
							value: '',
							text: '--Pilih Kendaraan--'
						}));
						
						data.forEach(function (newData) {
							vehicle.append($('<option>', {
								value: newData.vehicle_id,
								text: newData.vehicle_plate
							}));
						});

						if (ve_id !== false) vehicle.val(ve_id);

					} else {

						vehicle.html($('<option>', {
							value: '',
							text: 'Kendaraan tidak ditemukan!'
						}));
					}
				},
				error: function (error) {
					toastr.error(msgErr);
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
		generateAkunHeader: function(rah_id = false) {
			var akun_header = $('#akun_header');

			$.ajax({
				url: siteUrl('transaksi/delivery_order_cost/get_akun_header_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_akun_header_option'
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						akun_header.attr('disabled', false);

						akun_header.html($('<option>', {
							value: '',
							text: '--Akun Detail--'
						}));
						
						data.forEach(function (newData) {
							akun_header.append($('<option>', {
								value: newData.rah_id,
								text: newData.rah_name
							}));
						});

						if (rah_id !== false) akun_header.val(rah_id);

					} else {

						akun_header.html($('<option>', {
							value: '',
							text: 'Akun Detail Tidak Ditemukan!'
						}));
					}
				},
				error: function (error) {
					toastr.error(msgErr);
				}
			});
		},
		generateAkunDetail: function(rah_id, rad_id = false) {
		var akun_detail = $('#akun_detail');

		$.ajax({
			url: siteUrl('transaksi/delivery_order_cost/get_akun_detail_option'),
			type: 'POST',
			dataType: 'JSON',
			beforeSend: function() {},
			complete: function() {},
			data: {
				action: 'get_akun_detail_option',
				rah_id: rah_id
			},
			success: function (result) {
				if (result.success) {
					var data = result.data;

					akun_detail.attr('disabled', false);

					akun_detail.html($('<option>', {
						value: '',
						text: '--Akun Detail--'
					}));
					
					data.forEach(function (newData) {
						akun_detail.append($('<option>', {
							value: newData.rad_id,
							text: newData.rad_name
						}));
					});

					if (rad_id !== false) akun_detail.val(rad_id);

				} else {

					akun_detail.html($('<option>', {
						value: '',
						text: 'Akun Detail Tidak Ditemukan!'
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