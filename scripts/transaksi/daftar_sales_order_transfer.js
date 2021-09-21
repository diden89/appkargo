/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/transaksi/daftar_sales_order.js
 */


const daftarSalesOrderTransferList = {
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

		$('#btnRekap').click(function(e) {
			e.preventDefault();
			me.rekapTagihan(this);
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
		console.log($('#range2').val())
		$.ajax({
			url: siteUrl('transaksi/daftar_sales_order_transfer/load_data_daftar_sales_order_transfer'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_daftar_sales_order_transfer',
				txt_item: $('#txtList').val(),
				date_range1: $('#range1').val(),
				date_range2: $('#range2').val(),
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
	loadDataItemTemporary: function(el) {
		const me = this;
		const $this = $(el);
		
		$.ajax({
			url: siteUrl('transaksi/daftar_sales_order_transfer/load_data_temporary_detail_sot'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_temporary_detail_sot',
				txt_item: $('#txtList').val(),
				no_trx:$('#no_trx_id').val()
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
			body += '<td>' + item.no + '</td>';
			body += '<td>' + item.sot_no_trx + '</td>';
			body += '<td>' + item.v_vendor_name + '</td>';
			body += '<td>' + item.sot_qty + ' Kg</td>';
			body += '<td><b>' + item.tot_prog + ' Kg</b></td>';
			body += '<td><b>' + item.tot_prog_dos + ' Kg</b></td>';
			body += '<td>' + item.sot_total_amount + '</td>';
			body += '<td>' + item.rd_name + '</td>';
			body += '<td>' + item.sot_created_date + '</td>';
			body += '<td><div class="progress progress-sm">';
			body += '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="' + item.progress + '" aria-valuemin="0" aria-valuemax="' + item.total + '" style="width:' + item.total_progress +'%;">';
			body += '</div></div><small>' + item.total_progress + '% Completed</small><br><b>' + item.sot_is_status + '</b></td>';

			body += '<td>' + item.paying + '</td>';

			body += '<td><div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
				body += '<button type="button" class="btn btn-success" data-id="' + item.sot_id + '" data-no_trx="' + item.sot_no_trx + '" data-rd_id="' + item.rd_id + '" data-rp_id="' + item.rd_province_id + '" onclick="daftarSalesOrderTransferList.showItem(this, \'edit\');"><i class="fas fa-edit"></i></button>';
				body += '<button type="button" class="btn btn-danger" data-id="' + item.sot_id + '"  data-no_trx="' + item.sot_no_trx + '" onclick="daftarSalesOrderTransferList.deleteDataItem(this);"><i class="fas fa-trash-alt"></i></button>';
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
			// body += '<td>' + item.no + '</td>';
			body += '<td>' + item.il_item_name + '</td>';
			body += '<td>' + item.sotd_qty + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.sotd_id + '" data-no_trx="' + item.sot_no_trx + '" data-il_id="' + item.il_id + '" data-v_id="' + item.sot_vendor_id + '" data-sotd_qty="' + item.sotd_qty + '" onclick="daftarSalesOrderTransferList.editDetailSO(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.sotd_id + '" data-no_trx="' + item.sotd_no_trx + '" onclick="daftarSalesOrderTransferList.deleteDataTemp(this);"><i class="fas fa-trash-alt"></i></button>';
				body += '</div>';
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	editDetailSO: function(el) {
		const me = this;
		id = $(el).data('id');
		v_id = $(el).data('v_id');
		il_id = $(el).data('il_id');
		sotd_qty = $(el).data('sotd_qty');

		me.generateItemList(v_id,il_id);
		$('#sotd_qty').val(sotd_qty);
		$('#sotd_id').val(id);
	},
	rekapTagihan: function(el) {
		var url = 'daftar_sales_order_transfer/rekap_tagihan'
		window.open(url);
	},
	showItem: function(el, mode) {
		const me = this;
		let params = {action: 'load_daftar_sales_order_transfer_form'};
	

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
			title: title + ' Sales Order Transfer',
			id: 'showItem',
			size: 'large',
			proxy: {
				url: siteUrl('transaksi/daftar_sales_order_transfer/load_daftar_sales_order_transfer_form'),
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
							url: siteUrl('transaksi/daftar_sales_order_transfer/store_data_daftar_sales_order_transfer'),
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
			listeners: {
				onshow: function(popup) {
					if (mode == 'edit') {
						daftarSalesOrderTransferList.generateRegion($('#txt_province').val(),$(el).data('rd_id'));
						daftarSalesOrderTransferList.loadDataItemTemporary();
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
					
					// $('#sot_no_trx').val($('#last_notrx').val());

					$('#btnAddDetail').click(function(){
						var qty = $('#sotd_qty').val();
							il_id = $('#il_id').val();
							no_trx = $('#no_trx_id').val();
							sot_id = $('#sotd_id').val();

							
							if(no_trx == "")
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
									url: siteUrl('transaksi/daftar_sales_order_transfer/store_data_temporary'),
									type: 'POST',
									dataType: 'JSON',
									data: {
										action: 'insert_temporary_data',
										sotd_qty: qty,
										sotd_item_id: il_id,
										sotd_no_trx: no_trx,
										sot_id: sot_id,
										mode : mode
									},
									success: function(result) {
										if (result.success) {
											toastr.success("Data succesfully added.");
											daftarSalesOrderTransferList._generateTemporaryDataTable(result.data);

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
					$('#created_date').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
						$('#created_date').noobsdaterangepicker({
							parentEl: "#" + popup[0].id + " .modal-body",
							showDropdowns: true,
							singleDatePicker: true,
							locale: {
								format: 'DD-MM-YYYY'
							}
						});
					$('#v_vendor_id').change(function() {
						var me = $(this);

						if (me.val() !== '') {
							
							daftarSalesOrderTransferList.generateItemList(me.val());

						} else {
							$('#il_id').html($('<option>', {
								value: '',
								text: 'Item Barang'
							}));

							$('#il_id').attr('disabled', true);
						}
					});

					if($('#v_vendor_id').val() !== "") {
						var val = $('#v_vendor_id').val();
						console.log(val)
						if (val !== '') {
							
							daftarSalesOrderTransferList.generateItemList(val);

						} else {
							$('#il_id').html($('<option>', {
								value: '',
								text: 'Item Barang'
							}));

							$('#il_id').attr('disabled', true);
						}
					}

					$('#il_id').change(function() {
						
						$('#sotd_qty').val('');
						$('#sotd_id').val('');
						
					});
					$('#txt_province').change(function() {
						var me = $(this);
						// console.log(me.val())

							if (me.val() !== '') {
								
								daftarSalesOrderTransferList.generateRegion(me.val());

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
						// console.log(me)

							if (me.val() !== '') {
								
								daftarSalesOrderTransferList.generateDistrict(me.val());

							} else {
								$('#txt_district').html($('<option>', {
									value: '',
									text: 'Pilih Kabupaten/Kota'
								}));

								$('#txt_district').attr('disabled', true);
							}
					});

					$('#sotd_qty').keyup(function(event) {

					  // skip for arrow keys
					  if(event.which >= 37 && event.which <= 40) return;

					  // format number
					  $(this).val(function(index, value) {
					    return value
					    .replace(/\D/g, "")
					    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
					    ;
					  });
					});

									
				}
			}
		});

	},
	generateItemList: function(vendor_id, il_id = false) {
		var itemList = $('#il_id');
			// console.log(provinceId)
			$.ajax({
				url: siteUrl('transaksi/daftar_sales_order_transfer/get_item_list_option'),
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
			console.log(regionId)
			$.ajax({
				url: siteUrl('transaksi/daftar_sales_order_transfer/get_region_option'),
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
				url: siteUrl('transaksi/daftar_sales_order_transfer/get_district_option'),
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
					url: siteUrl('transaksi/daftar_sales_order_transfer/delete_data_item'),
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
			url: siteUrl('transaksi/daftar_sales_order_transfer/delete_data_temp'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'delete_data_temp',
				id: $this.data('id'),
				sotd_no_trx: $this.data('no_trx')
			},
			success: function(result) {
				$('#temporaryDataTable tbody').html('');

				if (result.success) {
					 daftarSalesOrderTransferList._generateTemporaryDataTable(result.data);
				}
				else if (result.success == false)
				{
					daftarSalesOrderTransferList._generateTemporaryDataTable(result.data);
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
	
};

$(document).ready(function() {
	daftarSalesOrderTransferList.init();
});