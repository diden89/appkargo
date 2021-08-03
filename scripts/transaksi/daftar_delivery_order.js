/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/transaksi/daftar_delivery_order.js
 */

const daftarDeliveryOrderList = {
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
			me.showItem(this,'add');
		});

		$('#range1').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
		$('#range1').noobsdaterangepicker({
			// parentEl: "#" + popup[0].id + " .modal-body",
			showDropdowns: true,
			singleDatePicker: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});
		$('#range2').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
		$('#range2').noobsdaterangepicker({
			// parentEl: "#" + popup[0].id + " .modal-body",
			showDropdowns: true,
			singleDatePicker: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});
	},
	loadDataItem: function(el) {
		const me = this;
		const $this = $(el);

		$.ajax({
			url: siteUrl('transaksi/daftar_delivery_order/load_data_daftar_delivery_order'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_daftar_delivery_order',
				txt_item: $('#txtList').val()
			},
			success: function(result) {
				$('#ignoredItemDataTable tbody').html('');

				if (result.success !== false) me._generateItemDataTable(result.data);
				else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
				else toastr.error(msgErr);
			},
			error: function(error) {
				toastr.error(msgErr);
			}
		});
	},
	loadDataItemDelivery: function(el) {
		const me = this;
		const $this = $(el);
		
		$.ajax({
			url: siteUrl('transaksi/daftar_delivery_order/load_data_delivery_detail_do'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_delivery_detail_do',
				so_id:$('#txt_so').val()
			},
			success: function(result) {
				$('#deliveryDataTable tbody').html('');

				if (result.success !== false) me._generateDeliveryDataTable(result.data);
				else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
				else toastr.error(msgErr);
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
			body += '<td>' + item.num + '</td>';
			body += '<td>' + item.dod_no_trx + '</td>';
			body += '<td>' + item.c_name + '</td>';
			body += '<td>' + item.il_item_name + '</td>';
			body += '<td>' + item.d_name + ' / ' + item.ve_license_plate + '</td>';
			body += '<td>' + item.c_address + '<br>' + item.rsd_name + '</td>';
			body += '<td>' + item.dod_shipping_qty + '</td>';
			body += '<td>' + item.dod_ongkir + '</td>';
			body += '<td>' + item.dod_created_date + '</td>';
			body += '<td>' + item.dod_is_status + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.dod_id + '" data-no_trx="' + item.dod_no_trx + '" onclick="daftarDeliveryOrderList.showItem(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.dod_id + '"  data-no_trx="' + item.dod_no_trx + '" onclick="daftarDeliveryOrderList.deleteDataItem(this);"><i class="fas fa-trash-alt"></i></button>';
				body += '</div>';
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	_generateTemporaryDataTable: (data) => {
		const $this = $('#temporaryDataTable tbody');

		$this.html('');

		let body = '';

		$.each(data, (idx, item) => {
			body += '<tr>';
			body += '<td>' + item.num + '</td>';
			body += '<td>' + item.dod_no_trx + '</td>';
			body += '<td>' + item.c_name + '</td>';
			body += '<td>' + item.il_item_name + '</td>';
			body += '<td>' + item.d_name + ' / ' + item.ve_license_plate + '</td>';
			body += '<td>' + item.c_address + '<br>' + item.rsd_name + '</td>';
			body += '<td>' + item.dod_shipping_qty + '</td>';
			body += '<td>' + item.dod_ongkir + '</td>';
			body += '<td>' + item.dod_created_date + '</td>';
			body += '<td>' + item.dod_is_status + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.dod_id + '" data-no_trx="' + item.dod_no_trx + '" onclick="daftarDeliveryOrderList.showItem(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.dod_id + '"  data-no_trx="' + item.dod_no_trx + '" onclick="daftarDeliveryOrderList.deleteDataItem(this);"><i class="fas fa-trash-alt"></i></button>';
				body += '</div>';
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	showItem: function(el, mode) {
		
		const me = this;
		let params = {action: 'load_daftar_delivery_order_form'};
	

		if (mode == 'edit') {
			params.mode = mode;
			title = 'Edit';
			params.txt_item = $(el).data('item');
			params.txt_id = $(el).data('id');
			params.rd_id = $(el).data('rd_id');
			params.rsd_id = $(el).data('rsd_id');
		}
		else
		{
			params.mode = 'add';
			title = 'Add';
		}

		$('#txt_province').on('select',function(){
		});

		$.popup({
			title: title + ' Delivery Order',
			id: 'showItem',
			size: 'large',
			proxy: {
				url: siteUrl('transaksi/daftar_delivery_order/load_daftar_delivery_order_form'),
				params: params
			},
			buttons: [
			{
				btnId: 'closePopup',
				btnText:'Close',
				btnClass: 'secondary',
				btnIcon: 'fas fa-times',
				onclick: function(popup) {

					$.ajax({
						url: siteUrl('transaksi/daftar_delivery_order/load_do_data'),
						type: 'POST',
						dataType: 'JSON',
						data: {
							action : 'load_data_daftar_delivery_order'
						},
						success: function(result) {
							if (result.success) {
								// toastr.success('msgSaveOk');
								me._generateItemDataTable(result.data);
							} else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
							else toastr.error(msgErr);

							popup.close();

						},
						error: function(error) {
							toastr.error(msgErr);
						}
					});
					// popup.close();
				}
			}],
			listeners: {
				onshow: function(popup) {
					
					if (mode == 'edit') {
						daftarDeliveryOrderList.loadDataItemDelivery();
					}

					if (typeof(mode) !== 'undefined') {
						mode = mode;
					}
					else
					{
						mode = 'add';
					}

					var today = new Date();
					var dd = String(today.getDate()).padStart(2, '0');
					var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
					var yyyy = today.getFullYear();

					today = yyyy+mm+dd;
					
					$('#created_date').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
					$('#created_date').noobsdaterangepicker({
						parentEl: "#" + popup[0].id + " .modal-body",
						showDropdowns: true,
						singleDatePicker: true,
						locale: {
							format: 'DD-MM-YYYY'
						}
					});

					// $('#so_no_trx').val($('#last_notrx').val());

					$('#btnAddDetail').click(function(){

						let params = {action: 'insert_delivery_order'};

							params.qty = $('#sod_qty').val();
							params.dod_sod_id = $('#detail_sales_order').val();
							params.dod_customer_id = $('#c_id').val();
							params.dod_vehicle_id = $('#dod_vehicle_id').val();
							params.dod_driver_id = $('#dod_driver_id').val();
							params.dod_shipping_qty = $('#sod_shipping_qty').val();
							params.dod_ongkir = $('#dod_ongkir').val();
							params.no_trx = $('#no_trx_do').val();
							params.dod_created_date = $('#created_date').val();
							params.mode = $('#mode').val();
							
							
							if(params.dod_ongkir == "")
							{
								Swal.fire({
									title: 'No Transaksi Tidak Ditemukan',
									text: "Nomor Transaksi Tidak Ditemukan, input Nomor Transaksi Terlebih Dahulu!",
									type: 'warning',
									showCancelButton: false,
									confirmButtonColor: '#17a2b8',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Close!'
								})
							}
							else
							{
								$.ajax({
									url: siteUrl('transaksi/daftar_delivery_order/store_data_detail_delivery_order'),
									type: 'POST',
									dataType: 'JSON',
									data : params,
									success: function(result) {
										if (result.success) {
											toastr.success("Data succesfully added.");
											daftarDeliveryOrderList._generateTemporaryDataTable(result.data);

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


					// $('#v_vendor_id').change(function() {
					// 	var me = $(this);

					// 	if (me.val() !== '') {
							
					// 		daftarDeliveryOrderList.generateItemList(me.val());

					// 	} else {
					// 		$('#il_id').html($('<option>', {
					// 			value: '',
					// 			text: 'Item Barang'
					// 		}));

					// 		$('#il_id').attr('disabled', true);
					// 	}
					// });

					$('#txt_sales_order').change(function() {
						var me = $(this);

						if (me.val() !== '') {
							
							// $('#detail_sales_order').attr('disabled', true);
							daftarDeliveryOrderList.generateDetailSO(me.val());

						} else {
							$('#detail_sales_order').attr('disabled', true);
							$('#detail_sales_order').html($('<option>', {
								value: '',
								text: '--Detail SO ikonyo--'
							}));

						}
					});

					$('#detail_sales_order').change(function() {
						
						sod_id = $('#detail_sales_order').val();

						$.ajax({
							url: siteUrl('transaksi/daftar_delivery_order/get_realisasi_qty'),
							type: 'POST',
							dataType: 'JSON',
							beforeSend: function() {},
							complete: function() {},
							data: {
								action: 'get_realisasi_qty',
								sod_id: sod_id
							},
							success: function (result) {
								if (result.success) {
									
									 $('#sod_qty').val(result.qty_real);

								} 
							},
							error: function (error) {
								toastr.error(msgErr);
							}
						});	
						
					}); 

					$('#sod_shipping_qty').on('keyup',function() {
						sod_shipp = $('#sod_shipping_qty').val();
						ongkir_temp = $('#dod_ongkir_temp').val();

						var formatter = new Intl.NumberFormat();

						ongkir = formatter.format(sod_shipp*ongkir_temp);

						$('#dod_ongkir').val(ongkir);
					});

					$('#c_id').change(function() {
						
						c_id = $('#c_id').val();

						$.ajax({
							url: siteUrl('transaksi/daftar_delivery_order/get_ongkir_district'),
							type: 'POST',
							dataType: 'JSON',
							beforeSend: function() {},
							complete: function() {},
							data: {
								action: 'get_ongkir_district',
								c_id: c_id
							},
							success: function (result) {
								if (result.success) {
									
									$('#dod_ongkir_temp').val('');
									$('#dod_ongkir_temp').val(result.ongkir_temp);

								}
								else
								{
									$('#dod_ongkir_temp').val(result.ongkir_temp);
								}
							},
							error: function (error) {
								toastr.error(msgErr);
							}
						});
						
					});
					

					// $('#txt_region').change(function() {
					// 	var me = $(this);
					// 	// console.log(me)

					// 		if (me.val() !== '') {
								
					// 			daftarDeliveryOrderList.generateDistrict(me.val());

					// 		} else {
					// 			$('#txt_district').html($('<option>', {
					// 				value: '',
					// 				text: 'Pilih Kabupaten/Kota'
					// 			}));

					// 			$('#txt_district').attr('disabled', true);
					// 		}
					// });

					// console.log(mode)				
				}
			}
		});

	},
	generateDetailSO: function(so_id, sod_id = false) {
		var detailSO = $('#detail_sales_order');
			
			$.ajax({
				url: siteUrl('transaksi/daftar_delivery_order/get_detail_so_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_detail_so_option',
					so_id: so_id
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						detailSO.attr('disabled', false);
						 $('#c_id').attr('disabled', false);
						 $('#no_trx_do').attr('disabled', false);
						 $('#dod_vehicle_id').attr('disabled', false);
						 $('#dod_driver_id').attr('disabled', false);

						detailSO.html($('<option>', {
							value: '',
							text: '--Pilih Data--'
						}));
						
						data.forEach(function (newData) {
							detailSO.append($('<option>', {
								value: newData.sod_id,
								text: newData.il_item_name
							}));
						});

						$('#temporaryDataTable tbody').html('');

						$.ajax({
							url: siteUrl('transaksi/daftar_delivery_order/load_do_data'),
							type: 'POST',
							dataType: 'JSON',
							data : {
								action : 'load_data_daftar_delivery_order',
								so_id : so_id
							},
							success: function(result) {
								if (result.success) {
									toastr.success("Data succesfully added.");
									daftarDeliveryOrderList._generateTemporaryDataTable(result.data);

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


						if (sod_id !== false) detailSO.val(sod_id);

					} else {

						$('#temporaryDataTable tbody').html('');
						
						detailSO.html($('<option>', {
							value: '',
							text: 'Data tidak ditemukan!'
						}));
					}
				},
				error: function (error) {
					toastr.error(msgErr);
				}
			});
	},
	generateItemList: function(vendor_id, il_id = false) {
		var itemList = $('#il_id');
			// console.log(provinceId)
			$.ajax({
				url: siteUrl('transaksi/daftar_delivery_order/get_item_list_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_item_list_option',
					vendor_id: vendor_id
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						itemList.attr('disabled', false);

						itemList.html($('<option>', {
							value: '',
							text: '--Pilih Item--'
						}));
						
						data.forEach(function (newData) {
							itemList.append($('<option>', {
								value: newData.il_id,
								text: newData.il_item_name
							}));
						});

						if (il_id !== false) itemList.val(il_id);

					} else {

						itemList.html($('<option>', {
							value: '',
							text: 'Item Barang Tidak Ditemukan!'
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
			// console.log(regionId)
			$.ajax({
				url: siteUrl('transaksi/daftar_delivery_order/get_region_option'),
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
				url: siteUrl('transaksi/daftar_delivery_order/get_district_option'),
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
	},
	generateCustomer: function(c_id = false) {
		var customer = $('#txt_pelanggan');
			
			$.ajax({
				url: siteUrl('transaksi/daftar_delivery_order/get_customer_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_customer_option'
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						customer.html($('<option>', {
							value: '',
							text: '--Pilih Pelanggan--'
						}));
						
						data.forEach(function (newData) {
							customer.append($('<option>', {
								value: newData.c_id,
								text: newData.c_name
							}));
						});

						if (c_id !== false) customer.val(c_id);

					} else {

						customer.html($('<option>', {
							value: '',
							text: 'Pelanggan tidak ditemukan!'
						}));
					}
				},
				error: function (error) {
					toastr.error(msgErr);
				}
			});
	},
	deleteDataItem: function(el) {
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
					url: siteUrl('transaksi/daftar_delivery_order/delete_data_item'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data_item',
						txt_id: $this.data('id')
					},
					success: function(result) {
						$('#ignoredItemDataTable tbody').html('');
						
						if (result.success) {
							 me._generateItemDataTable(result.data);
						}						
						else if (typeof(result.msg) !== 'undefined') {						
							toastr.error(result.msg);
						}
						else {							
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
	deleteDataTemp: function(el) {
		const me = this;
		const $this = $(el);
			
		$.ajax({
			url: siteUrl('transaksi/daftar_delivery_order/delete_data_temp'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'delete_data_temp',
				id: $this.data('id'),
				sod_no_trx: $this.data('no_trx')
			},
			success: function(result) {
				$('#deliveryDataTable tbody').html('');

				if (result.success) {
					 daftarDeliveryOrderList._generateDeliveryDataTable(result.data);
				}
				else if (result.success == false)
				{
					daftarDeliveryOrderList._generateDeliveryDataTable(result.data);
				}
				else if (typeof(result.msg) !== 'undefined') {
					$('#deliveryDataTable tbody').html('');
					toastr.error(result.msg);
				}
				else {
					$('#deliveryDataTable tbody').html('');
					toastr.error(msgErr);
				}

			},
			error: function(error) {
				toastr.error(msgErr);
			}
		});
	}
	
};

$(document).ready(function() {
	daftarDeliveryOrderList.init();
});