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
			showDropdowns: true,
			singleDatePicker: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});
		$('#range2').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
		$('#range2').noobsdaterangepicker({
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
		console.log(el.so_no_trx)
		$.ajax({
			url: siteUrl('transaksi/daftar_delivery_order/load_data_daftar_delivery_order'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_daftar_delivery_order',
				so_no_trx: el.so_no_trx
			},
			success: function(result) {
				$('#temporaryDataTable tbody').html('');

				if (result.success !== false) me._generateTemporaryDataTable(result.data);
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
			body += '<td>' + item.so_no_trx + '</td>';
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
			if(item.dod_is_status !== 'SELESAI') {
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.dod_id + '" data-no_trx="' + item.dod_no_trx + '" data-so_no_trx="' + item.so_no_trx + '" data-dod_customer_id="' + item.dod_customer_id + '" data-dod_driver_id="' + item.dod_driver_id + '" data-dod_sod_id="' + item.dod_sod_id + '" data-dod_vehicle_id="' + item.dod_vehicle_id + '" data-dod_shipping_qty="' + item.dod_shipping_qty + '" onclick="daftarDeliveryOrderList.showItem(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.dod_id + '"  data-no_trx="' + item.dod_no_trx + '" onclick="daftarDeliveryOrderList.deleteDataDo(this);"><i class="fas fa-trash-alt"></i></button>';
					body += '<button type="button" class="btn btn-primary" data-id="' + item.dod_id + '" data-no_trx="' + item.dod_no_trx + '" data-is_status="' + item.dod_is_status + '" data-so_id="' + item.so_id + '" data-so_no_trx="' + item.so_no_trx + '" onclick="daftarDeliveryOrderList.updateStatus(this, \'edit\');"><i class="fas fa-exchange-alt"></i></button>';
				body += '</div>';
			}
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
				if(item.dod_is_status !== 'SELESAI') {
					body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
						body += '<button type="button" class="btn btn-success" data-id="' + item.dod_id + '" data-no_trx="' + item.dod_no_trx + '" data-so_no_trx="' + item.so_no_trx + '" data-dod_customer_id="' + item.dod_customer_id + '" data-dod_driver_id="' + item.dod_driver_id + '" data-dod_sod_id="' + item.dod_sod_id + '" data-dod_vehicle_id="' + item.dod_vehicle_id + '" data-dod_shipping_qty="' + item.dod_shipping_qty_ori + '" onclick="daftarDeliveryOrderList.editDetailDO(this, \'edit\');"><i class="fas fa-edit"></i></button>';
						body += '<button type="button" class="btn btn-danger" data-id="' + item.dod_id + '"  data-no_trx="' + item.dod_no_trx + '" onclick="daftarDeliveryOrderList.deleteDataDoDetail(this);"><i class="fas fa-trash-alt"></i></button>';
						body += '</div>';
				}
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	editDetailDO: function(el, mode) { 
		
		const me = this;
		let params = {action: 'load_daftar_delivery_order_form'};

		if (mode == 'edit') {
			params.mode = mode;
			title = 'Edit';
			params.dod_id = $(el).data('id');
			params.no_trx = $(el).data('no_trx');
			params.so_no_trx = $(el).data('so_no_trx');
			params.dod_customer_id = $(el).data('dod_customer_id');
			params.dod_vehicle_id = $(el).data('dod_vehicle_id');
			params.dod_driver_id = $(el).data('dod_driver_id');
			params.sod_id = $(el).data('dod_sod_id');
			params.dod_shipping_qty = $(el).data('dod_shipping_qty');
			// params.rsd_id = $(el).data('rsd_id');
		}
		else
		{
			params.mode = 'add';
			title = 'Add';
		}
		
		// daftarDeliveryOrderList.loadDataItem(params);

		$('#dod_vehicle_id').attr('disabled', false);
		$('#dod_driver_id').attr('disabled', false);
		$('#no_trx_do').val(params.no_trx);
		$('#sod_shipping_qty').val(params.dod_shipping_qty);
		$('#dod_id').val(params.dod_id);
		$('#mode').val(mode);

		if($('#txt_sales_order').val() !== '') {								
			// $('#detail_sales_order').attr('disabled', true);
			daftarDeliveryOrderList.generateDetailSO($('#txt_sales_order').val(),params.sod_id,'edit',params.dod_customer_id);
			$('#printDO').attr('disabled', false);							
		}

		if($('#detail_sales_order').val() !== '') {
		
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
		
		}

		if($('#c_id').val() !== '') {
		
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
						$('#dod_ongkir_temp_2').val(result.ongkir_temp);

						sod_shipp = $('#sod_shipping_qty').val();
						ongkir_temp = result.ongkir_temp;

						var formatter = new Intl.NumberFormat();

						ongkir = formatter.format(sod_shipp*ongkir_temp);

						$('#dod_ongkir').val(ongkir);

					}
					else
					{
						$('#dod_ongkir_temp').val(result.ongkir_temp);
						$('#dod_ongkir_temp_2').val(result.ongkir_temp);
					}
				},
				error: function (error) {
					toastr.error(msgErr);
				}
			});
		}
	},
	showItem: function(el, mode) {
		
		const me = this;
		let params = {action: 'load_daftar_delivery_order_form'};	

		if (mode == 'edit') {
			params.mode = mode;
			title = 'Edit';
			params.dod_id = $(el).data('id');
			params.no_trx = $(el).data('no_trx');
			params.so_no_trx = $(el).data('so_no_trx');
			params.dod_customer_id = $(el).data('dod_customer_id');
			params.dod_vehicle_id = $(el).data('dod_vehicle_id');
			params.dod_driver_id = $(el).data('dod_driver_id');
			params.sod_id = $(el).data('dod_sod_id');
			params.dod_shipping_qty = $(el).data('dod_shipping_qty');
			// params.rsd_id = $(el).data('rsd_id');
		}
		else
		{
			params.mode = 'add';
			title = 'Add';
		}

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
					daftarDeliveryOrderList.loadDataItem(this);
					popup.close();
				}

			},
			// {
			// 	btnId: 'printDO',
			// 	btnText:'Print',
			// 	btnClass: 'success',
			// 	btnIcon: 'fas fa-print',
			// 	btnDisabled: 'disabled',
			// 	onclick: function(popup) {

			// 		var so_id = $('#txt_sales_order').val();

			// 		$.ajax({
			// 			url: siteUrl('transaksi/daftar_delivery_order/print_delivery_order'),
			// 			type: 'POST',
			// 			dataType: 'JSON',
			// 			data: {
			// 				action : 'print_delivery_order',
			// 				so_id : so_id
			// 			},
			// 			success: function(result) {
			// 				if (result.success) {
			// 					// toastr.success('msgSaveOk');
			// 					me._generateItemDataTable(result.data);
			// 				} else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
			// 				else toastr.error(msgErr);

			// 				popup.close();

			// 			},
			// 			error: function(error) {
			// 				toastr.error(msgErr);
			// 			}
			// 		});
			// 		// popup.close();
			// 	}
			// },
			],
			listeners: {
				onshow: function(popup) {
					$('#btnReset').on('click',function(){
						$('#c_id').prop('selectedIndex',0);
						$('#detail_sales_order').prop('selectedIndex',0);
						$('#so_id').val('');
						$('#sod_shipping_qty').val('');
						$('#sod_qty').val('');
						$('#dod_ongkir_temp').val('');
						$('#dod_ongkir').val('');
						$('#no_trx_do').val('');
						$('#dod_id').val('');

						if(params.mode == 'edit') {
							$('#mode').val('add');
						}
					});

					if (mode == 'edit') {

						daftarDeliveryOrderList.loadDataItem(params); //load data daftar delivery

							$('#dod_vehicle_id').attr('disabled', false);
							$('#dod_driver_id').attr('disabled', false);
							$('#no_trx_do').val(params.no_trx);
							$('#sod_shipping_qty').val(params.dod_shipping_qty);
							$('#dod_id').val(params.dod_id);
						
						if($('#txt_sales_order').val() !== '') {								
							daftarDeliveryOrderList.generateDetailSO($('#txt_sales_order').val(),params.sod_id,'edit',params.dod_customer_id,params.so_no_trx); //generate detail SO
							// daftarDeliveryOrderList.generateDetailSO(params); //generate detail SO
							$('#printDO').attr('disabled', false);							
						}

						if($('#detail_sales_order').val() !== '') {
						
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
						
						}

						if($('#c_id').val() !== '') {
						
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
										$('#dod_ongkir_temp_2').val(result.ongkir_temp);

										sod_shipp = $('#sod_shipping_qty').val();
										ongkir_temp = result.ongkir_temp;

										var formatter = new Intl.NumberFormat();

										ongkir = formatter.format(sod_shipp*ongkir_temp);

										$('#dod_ongkir').val(ongkir);

									}
									else
									{
										$('#dod_ongkir_temp').val(result.ongkir_temp);
										$('#dod_ongkir_temp_2').val(result.ongkir_temp);
									}
								},
								error: function (error) {
									toastr.error(msgErr);
								}
							});
						}

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

					$('#btnAddDetail').click(function(){

						let new_params = {action: 'insert_delivery_order'};

							new_params.qty = $('#sod_qty').val();
							new_params.dod_sod_id = $('#detail_sales_order').val();
							new_params.so_id = $('#so_id').val();
							new_params.dod_customer_id = $('#c_id').val();
							new_params.dod_vehicle_id = $('#dod_vehicle_id').val();
							new_params.dod_driver_id = $('#dod_driver_id').val();
							new_params.dod_shipping_qty = $('#sod_shipping_qty').val();
							new_params.dod_ongkir = $('#dod_ongkir').val();
							new_params.no_trx = $('#no_trx_do').val();
							new_params.dod_created_date = $('#created_date').val();
							new_params.so_no_trx = params.so_no_trx;
							new_params.mode = $('#mode').val();
							
							if(new_params.mode == 'edit') {
								new_params.dod_id = $('#dod_id').val()
							}
					
							if(new_params.qty <= 0 && new_params.mode !== 'edit') {
							Swal.fire({
								title: 'Order Sudah Terpenuhi',
								text: "Anda tidak bisa menambahkan transaksi, order sudah terpenuhi!",
								type: 'warning',
								showCancelButton: false,
								confirmButtonColor: '#17a2b8',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Close!'
							})
							} 
							else if(new_params.no_trx == "" && new_params.mode !== 'edit'){
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
							else if(parseInt(new_params.dod_shipping_qty) > parseInt(new_params.qty) && new_params.mode !== 'edit'){
								Swal.fire({
									title: 'Melebihi order',
									text: "Periksa kembali orderan anda!",
									type: 'warning',
									showCancelButton: false,
									confirmButtonColor: '#17a2b8',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Close!'
								})
							}
							else if(new_params.dod_driver_id == "" && new_params.mode !== 'edit'){
								Swal.fire({
									title: 'Pengemudi / Kendaraan Kosong',
									text: "Pengemudi / Kendaraan tidak boleh kosong!",
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
									data : new_params,
									success: function(result) {
										if (result.success) {
											toastr.success("Data succesfully added.");

											$('#c_id').prop('selectedIndex',0);
											$('#detail_sales_order').prop('selectedIndex',0);
											$('#sod_shipping_qty').val('');
											$('#sod_qty').val('');
											$('#dod_ongkir_temp').val('');
											$('#dod_ongkir').val('');
											$('#no_trx_do').val('');
											$('#dod_id').val('');

											if(new_params.mode == 'edit') {
												$('#mode').val('add');
											}

											daftarDeliveryOrderList._generateTemporaryDataTable(result.data);
											// daftarDeliveryOrderList.generateDetailSO(new_params.so_id);

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


					$('#txt_sales_order').change(function() {
						var me = $(this);

						if (me.val() !== '') {
							
							// $('#detail_sales_order').attr('disabled', true);
							daftarDeliveryOrderList.generateDetailSO(me.val());
							$('#printDO').attr('disabled', false);


						} else {
							$('#detail_sales_order').attr('disabled', true);
							$('#detail_sales_order').html($('<option>', {
								value: '',
								text: '--Detail Sales Order--'
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
									 $('#sod_qty_real').val(result.qty_real);

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
				}
			}
		});

	},
	updateStatus: function(el, mode) {
		
		const me = this;
		let params = {action: 'load_update_status_form'};
	

		if (mode == 'edit') {
			params.mode = mode;
			title = 'Edit';
			params.no_trx = $(el).data('no_trx');
			params.dod_is_status = $(el).data('is_status');
			params.id = $(el).data('id');
			params.so_id = $(el).data('so_id');
			params.so_no_trx = $(el).data('so_no_trx');
			// params.rsd_id = $(el).data('rsd_id');
		}
		else
		{
			params.mode = 'add';
			title = 'Add';
		}

		$.popup({
			title: title + ' Update Status',
			id: 'showItem',
			size: 'small',
			proxy: {
				url: siteUrl('transaksi/daftar_delivery_order/load_update_status_form'),
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
							url: siteUrl('transaksi/daftar_delivery_order/store_update_status'),
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
			},
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
					$('#no_trx').val(params.no_trx);			
					$('#dod_id').val(params.id);			
					$('#no_trx_dod').val(params.no_trx);			
					$('#so_id').val(params.so_id);			
					$('#so_no_trx').val(params.so_no_trx);			
				}
			}
		});

	},
	generateDetailSO: function(so_id, sod_id = false,mode = 'add',c_id = false,so_no_trx = false) {
	// generateDetailSO: function(params) {
		// console.log(params)
		var detailSO = $('#detail_sales_order');
			
			$.ajax({
				url: siteUrl('transaksi/daftar_delivery_order/get_detail_so_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_detail_so_option',
					so_id: so_id,
					mode : mode
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						detailSO.attr('disabled', false);
						 $('#c_id').attr('disabled', false);
						 $('#no_trx_do').attr('disabled', false);
						 $('#dod_vehicle_id').attr('disabled', false);
						 $('#dod_driver_id').attr('disabled', false);
						 $('#btnAddDetail').attr('disabled', false);
						 $('#so_id').val(so_id);

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
									$('#temporaryDataTable tbody').html('');
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

						daftarDeliveryOrderList.generateCustomer(so_id,c_id)

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
	generateCustomer: function(so_id, c_id = false) {
		var customer = $('#c_id');
			
			$.ajax({
				url: siteUrl('transaksi/daftar_delivery_order/get_customer_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_customer_option',
					so_id : so_id
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
					url: siteUrl('transaksi/daftar_delivery_order/delete_data'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data',
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
	deleteDataDoDetail: function(el) {
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