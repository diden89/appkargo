/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/transaksi/delivery_order_cost.js
 */


	const ORDERCOST = {
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
					title: 'Tanggal', 
					data: 'doc_created_date',
				},
				{	
					title: 'No Transaksi', 
					data: 'doc_no_trx',
				},
				{	
					title: 'No Transaksi Order', 
					data: 'doc_so_no_trx',
				},
				{	
					title: 'Vendor', 
					data: 'v_vendor_name',
				},
				{	
					title: 'Area', 
					data: 'rd_name',
				},
				{	
					title: 'Total', 
					data: 'total_amount',
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
								ORDERCOST.popup_view('view', 'View', rowData);
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
									title: 'Yakin Akan Menghapus Data Ini?',
									text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
									type: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#17a2b8',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Ya, Hapus Data Ini!'
								}).then((result) => {
									if (result.value) {
										$.ajax({
											url: siteUrl('transaksi/delivery_order_cost/delete_data'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'delete_data',
												doc_no_trx: rowData.doc_no_trx
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
		loadDataItemTemporary: function(el) {
			const me = this;
			const $this = $(el);
			var so_no_trx = $('#txt_sales_order').val();
			 	doc_no_trx = $('#doc_no_trx').val();

			$.ajax({
				url: siteUrl('transaksi/delivery_order_cost/load_data_temporary'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'load_data_temporary',
					so_no_trx:so_no_trx,
					doc_no_trx:doc_no_trx,
				},
				success: function(result) {
					$('#temporaryDataTable tbody').html('');

					if (result.success !== false)
					{
						me._generateTemporaryDataTable(result.data);
						ORDERCOST.getTotalAmount(doc_no_trx);
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
		_generateTemporaryDataTable: (data) => {
			const $this = $('#temporaryDataTable tbody');

			$this.html('');

			let body = '';

			$.each(data, (idx, item) => {
				body += '<tr>';
				body += '<td>' + item.no + '</td>';
				body += '<td>' + item.docd_doc_no_trx + '</td>';
				body += '<td>' + item.rad_name + '</td>';
				body += '<td>' + item.ve_license_plate + '</td>';
				body += '<td>' + item.docd_amount + '</td>';
				body += '<td>';
					body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
						body += '<button type="button" class="btn btn-success" data-docd_id="' + item.docd_id + '" data-rad_id="' + item.docd_rad_id + '" data-docd_amount="' + item.docd_amount + '" data-docd_vehicle_id="' + item.docd_vehicle_id + '" data-docd_keterangan="' + item.docd_keterangan + '" data-docd_lock_ref="' + item.docd_lock_ref + '" data-trx_rad_id_from="' + item.trx_rad_id_from + '" onclick="ORDERCOST.EditDetailCost(this, \'edit\');"><i class="fas fa-edit"></i></button>';
						body += '<button type="button" class="btn btn-danger" data-docd_id="' + item.docd_id + '" data-docd_lock_ref="' + item.docd_lock_ref + '" data-no_trx="' + item.docd_doc_no_trx + '" onclick="ORDERCOST.deleteDataTemp(this);"><i class="fas fa-trash-alt"></i></button>';
					body += '</div>';
				body += '</td>';
				body += '</tr>';
			});

			$this.html(body);
		},
		EditDetailCost : function(el, mode) {
			 var 	docd_id = $(el).data('docd_id');
			 		docd_vehicle_id = $(el).data('docd_vehicle_id');
			 		docd_keterangan = $(el).data('docd_keterangan');
			 		docd_rad_id = $(el).data('rad_id');
			 		docd_amount = $(el).data('docd_amount');
			 		docd_lock_ref = $(el).data('docd_lock_ref');
			 		trx_rad_id_from = $(el).data('trx_rad_id_from');
			 		doc_so_no_trx = $('#txt_sales_order').val();
			 		
			ORDERCOST.generateVehicle(doc_so_no_trx, docd_vehicle_id);
			ORDERCOST.generateAkunDetail('4', docd_rad_id);
			ORDERCOST.generateAkunDetailFrom('1', trx_rad_id_from);

			$('#btnAddDetail').attr('disabled', false);

			$('#total').val(docd_amount);
			$('#keterangan').val(docd_keterangan);
			$('#docd_id').val(docd_id);
			$('#docd_lock').val(docd_lock_ref);
			$('#mode').val('edit');
		},
		popup: function(mode = 'add', title= 'Add', data = false)
		{
			// console.log(data['doc_no_trx'])
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
				buttons: [
				{
					btnId: 'closePopup',
					btnText:'Close',
					btnClass: 'secondary',
					btnIcon: 'fas fa-times',
					onclick: function(popup) {
						popup.close();

						ORDERCOST.gridDeliveryOrderCost.reloadData({
							txt_id: $('#txtName').val()
						});
					}
				}],
				listeners: {
					onshow: function(popup) {
						// ORDERCOST.generateAkunHeader();
						ORDERCOST.generateAkunDetail('4');
						ORDERCOST.generateAkunDetailFrom('1');

						 $('#created_date').datetimepicker({
					        //language:  'fr',
					        weekStart: 1,
					        todayBtn:  1,
							autoclose: 1,
							todayHighlight: 1,
							startView: 2,
							forceParse: 0,
					        showMeridian: 1
					    });

						if (mode == 'edit') {
							// ORDERCOST.generateUserSubGroup($('#userGroup').val(), data.ud_sub_group);
							// ORDERCOST.generateRegion($('#txt_province').val(),data.rd_id);
							// ORDERCOST.generateDistrict(data.rd_id,data.rsd_id);
							// ORDERCOST.generateVehicle($('#txt_sales_order').val());

							ORDERCOST.loadDataItemTemporary();

							$('#txt_sales_order').attr('disabled', true);
							$('#created_date').val(data['doc_created_date']);
							// $('#txt_sales_order').val(data['so_no_trx']);

						}	

						$('#btnNewDetail').click(function(){
							$('#docd_id').val('');
							$('#docd_lock').val('');
							$('#doc_id').val('');
							$('#mode').val('add');

							$('#akun_detail').prop('selectedIndex',0);
							$('#akun_detail_from').prop('selectedIndex',0);
							$('#vehicle_id').prop('selectedIndex',0);
							$('#keterangan').val('');
							$('#total').val('');

							$('#btnAddDetail').attr('disabled', false);
							ORDERCOST.generateVehicle($('#txt_sales_order').val());
						});

						$('#btnAddDetail').click(function(){
							var so_no_trx = $('#txt_sales_order').val();
								doc_no_trx = $('#doc_no_trx').val();
								akun_detail_from = $('#akun_detail_from').val();
								akun_detail = $('#akun_detail').val();
								total = $('#total').val();
								keterangan = $('#keterangan').val();
								
								created_date = $('#created_date').val();
								vehicle_id = $('#vehicle_id').val();								
								docd_lock = $('#docd_lock').val();								
								docd_id = ( $('#docd_id').val() == undefined ) ? 'undefined' : $('#docd_id').val();								
								doc_id =  ( $('#doc_id').val() == undefined ) ? 'undefined' : $('#doc_id').val();									
								
								// if(mode == 'edit')
								// {
								// }
								// else
								// {
								// 	docd_id = 'undefined';
								// 	doc_id = 'undefined';
								// }

							$.ajax({
								url: siteUrl('transaksi/delivery_order_cost/store_data'),
								type: 'POST',
								dataType: 'JSON',
								data: {
									action: 'insert_data',
									so_no_trx: so_no_trx,
									doc_no_trx: doc_no_trx,
									created_date: created_date,
									doc_id: doc_id,
									mode : mode
								},
								success: function(result) {
									if (result.success) {
										
										$.ajax({
											url: siteUrl('transaksi/delivery_order_cost/store_data_temporary'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'insert_temporary_data',
												vehicle_id: vehicle_id,
												so_no_trx: so_no_trx,
												created_date: created_date,
												doc_no_trx: doc_no_trx,
												akun_detail_from: akun_detail_from,
												akun_detail: akun_detail,
												total: total,
												keterangan: keterangan,
												docd_id: docd_id,
												docd_lock: docd_lock,
												mode : mode
											},
											success: function(res) {
												if (res.success) {
													toastr.success("Data succesfully added.");

													ORDERCOST._generateTemporaryDataTable(res.data);

													$('#akun_detail_from').prop('selectedIndex',0);
													$('#akun_detail').prop('selectedIndex',0);
													$('#vehicle_id').prop('selectedIndex',0);
													$('#keterangan').val('');
													$('#total').val('');

													ORDERCOST.getTotalAmount(doc_no_trx);
													if(mode == 'edit')
													{
														$('#btnAddDetail').attr('disabled', true);
													}

												} else if (typeof(res.msg) !== 'undefined') {
													toastr.error(res.msg);
												} else {
													toastr.error(msgErr);
												}
												
											},
											error: function(error) {
												toastr.error(msgErr);
											}
										});	

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
								
								ORDERCOST.loadDataItemTemporary();

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

					}
				}
			});
		},
		popup_view: function(mode = 'add', title= 'Add', data = false)
		{
			$.popup({
				title: 'View Biaya Operasional DO',
				id: mode + 'OrderCostPopup',
				size: 'large',
				proxy: {
					url: siteUrl('transaksi/delivery_order_cost/load_delivery_order_cost_detail'),
					params: {
						action: 'load_delivery_order_cost_detail',
						mode: mode,
						data: data
					}
				},
				buttons: [
				{
					btnId: 'closePopup',
					btnText:'Close',
					btnClass: 'secondary',
					btnIcon: 'fas fa-times',
					onclick: function(popup) {
						popup.close();

						ORDERCOST.gridDeliveryOrderCost.reloadData({
							txt_id: $('#txtName').val()
						});
					}
				}],
				listeners: {
					onshow: function(popup) {
						// console.log(data.doc_no_trx)
						ORDERCOST.getTotalAmount(data.doc_no_trx);
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
		generateAkunHeader: function(rah_id = false, rad_id = false) {
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
		generateAkunDetailFrom: function(rah_id, rad_id = false) {
			var akun_detail_from = $('#akun_detail_from');
			
			$.ajax({
				url: siteUrl('transaksi/delivery_order_cost/get_akun_detail_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_akun_detail_option',
					rah_id: rah_id,
					rad_is_bank: 'Y'
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						akun_detail_from.attr('disabled', false);

						akun_detail_from.html($('<option>', {
							value: '',
							text: '--Akun Detail--'
						}));
						
						data.forEach(function (newData) {
							akun_detail_from.append($('<option>', {
								value: newData.rad_id,
								text: newData.rad_name
							}));
						});

						if (rad_id !== false) akun_detail_from.val(rad_id);

					} else {

						akun_detail_from.html($('<option>', {
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
		getTotalAmount: function(no_trx = false) {
			$.ajax({
				url: siteUrl('transaksi/delivery_order_cost/total_amount_detail'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'total_amount_detail',
					no_trx: no_trx
				},
				success: function(result) {
					if (result.success) {
						$('#total_amount').html(result.total_amount);
					}
					
				},
				error: function(error) {
					toastr.error(msgErr);
				}
			});
		},
		deleteDataTemp: function(el) {
			const me = this;
			const $this = $(el);

			Swal.fire({
				title: 'Yakin Akan Menghapus Data Ini?',
				text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#17a2b8',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus Data Ini!'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url: siteUrl('transaksi/delivery_order_cost/delete_data_temp'),
						type: 'POST',
						dataType: 'JSON',
						data: {
							action: 'delete_data_temp',
							key_lock: $this.data('docd_lock_ref'),
							docd_id: $this.data('docd_id'),
							doc_no_trx: $this.data('no_trx')
						},
						success: function(result) {
							$('#temporaryDataTable tbody').html('');

							if (result.success) {
								 ORDERCOST._generateTemporaryDataTable(result.data);
								 ORDERCOST.getTotalAmount($this.data('no_trx'));

								// $('#akun_header').prop('selectedIndex',0);
								// $('#akun_detail').prop('selectedIndex',0);
								// $('#cid_keterangan').val('');
								// $('#cid_total').val('');
								// $('#cid_id').val('');
								// $('#key_lock').val('');
							}
							else if (result.success == false)
							{
								ORDERCOST._generateTemporaryDataTable(result.data);
								ORDERCOST.getTotalAmount($this.data('no_trx'));
							}
							else if (typeof(result.msg) !== 'undefined') {
								$('#temporaryDataTable tbody').html('');
								toastr.error(result.msg);
							}
							else {
								$('#temporaryDataTable tbody').html('');
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

	$('#rangeDate').click(function(e){
		ORDERCOST.gridDeliveryOrderCost.reloadData({
			from_date: $('#from_date').val(),
			to_date: $('#to_date').val(),
		});
		// remote: true,
		// placeholder: 'Find data.',
		// proxy: {
		// 	url: siteUrl('transaksi/delivery_order_cost/get_autocomplete_data'),
		// 	method: 'post',
		// 	data: {
		// 		action: 'get_autocomplete_data'
		// 	},
		// },
		// listeners: {
		// 	onselect: function(data) {
		// 		ORDERCOST.gridDeliveryOrderCost.reloadData({
		// 			txt_id: $('#txtName').val()
		// 		});
		// 	},
		// 	onclear: function(obj) {
		// 		ORDERCOST.gridDeliveryOrderCost.reloadData({});
		// 	}
		// }
	});
$(document).ready(function() {

	$('#from_date').datetimepicker({
        //language:  'fr',
        dateFormat: "yy-mm-dd",
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    }).datepicker("setDate", new Date());

    $('#to_date').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
});