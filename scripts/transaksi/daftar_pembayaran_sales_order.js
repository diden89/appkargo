/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/transaksi/daftar_pembayaran_sales_order.js
 */
let arrZ = [];

const daftarPaySalesOrderList = {
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
			url: siteUrl('transaksi/daftar_pembayaran_sales_order/load_data_daftar_pembayaran_sales_order'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_daftar_pembayaran_sales_order',
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
	loadDataItemTemporary: function(params) {
		const me = this;
		$.ajax({
			url: siteUrl('transaksi/daftar_pembayaran_sales_order/get_sales_order_data'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'get_sales_order_data',
				so_vendor_id: params.so_vendor_id,
				mode : params.mode
			},
			success: function(result) {
				if (result.success) {
					toastr.success("Data succesfully added.");
					daftarPaySalesOrderList._generateTemporaryDataTable(result.data);
					$('#total_amount_st').val(result.amount);
					// $('#total_amount').html(result.total_amount);
					$('#total_amount').html('');

				} else if (typeof(result.msg) !== 'undefined') {
					toastr.error(result.msg);
					$('#temporaryDataTable tbody').html('');
					$('#total_amount').html('');
					$('#total_amount_st').val('');
				} else {
					toastr.error(msgErr);
				}
				
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
			body += '<td>' + item.sop_no_trx + '</td>';
			body += '<td>' + item.v_vendor_name + '</td>';
			body += '<td>' + item.so_total_amount + '</td>';
			body += '<td>' + item.sop_created_date + '</td>';
			body += '<td>' + item.paying + '</td>';
			// body += '<td><div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
			// 	body += '<button type="button" class="btn btn-success" data-id="' + item.so_id + '" data-no_trx="' + item.so_no_trx + '" data-rd_id="' + item.rd_id + '" data-rp_id="' + item.rd_province_id + '" onclick="daftarPaySalesOrderList.showItem(this, \'edit\');"><i class="fas fa-edit"></i></button>';
			// 	body += '<button type="button" class="btn btn-danger" data-id="' + item.so_id + '"  data-no_trx="' + item.so_no_trx + '" onclick="daftarPaySalesOrderList.deleteDataItem(this);"><i class="fas fa-trash-alt"></i></button>';
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
		i=0;
		$.each(data, (idx, item) => {
			body += '<tr>';
			body += '<td>' + item.no + '</td>';
			body += '<td>' + item.so_no_trx;
			body += '<input type="hidden" name="so_no_trx[]" value="'+item.so_no_trx+'"></td>';
			body += '<td>' + item.v_vendor_name + '</td>';
			body += '<td>' + item.so_qty + '</td>';
			body += '<td>' + item.so_total_amount + '</td>';
			body += '<td><button type="button" class="btn btn-warning btn-circle" data-id="' + item.so_id + '"  data-v_id="' + item.v_id + '" data-amount_'+i+'="' + item.so_total_amount_so + '" onclick="daftarPaySalesOrderList.paymentSO(this,'+i+');"><i class="fas fa-dollar-sign"></i></button></td>';
			body += '<td><input type="text" id="bayar_so_'+i+'" class="form-control" value="" disabled>';
			body += '<input type="hidden" name="bayar_so[]" id="bayar_sales_'+i+'" class="form-control" value=""></td>';
			body += '<td>' + item.rd_name + '</td>';
			body += '<td>' + item.so_created_date + '</td>';
			body += '</tr>';
			i++;
		});

		$this.html(body);
	},
	paymentSO: function(el,value) {
		const me = this;
		
		id = $(el).data('id');
		amount = $(el).data('amount_'+value);
		arrZ.push(amount);
		
		const reducer = (accumulator, curr) => accumulator + curr;
		// console.log(arr.reduce(reducer));
		// me.generateItemList(v_id,il_id);

		var formatter = new Intl.NumberFormat();
		tot_amount = 'Rp. ' +formatter.format(arrZ.reduce(reducer));
		
		$('#bayar_so_'+value).val('Rp. ' +formatter.format(amount));
		$('#bayar_sales_'+value).val(amount);
		$('#total_amount').html(tot_amount);
		$('#sod_id').val(id);
	},
	editDetailSO: function(el) {
		const me = this;
		id = $(el).data('id');
		v_id = $(el).data('v_id');
		il_id = $(el).data('il_id');
		sod_qty = $(el).data('sod_qty');

		me.generateItemList(v_id,il_id);
		$('#sod_qty').val(sod_qty);
		$('#sod_id').val(id);
	},
	showItem: function(el, mode) {
		console.log(mode)
		const me = this;
		let params = {action: 'load_daftar_pembayaran_sales_order_form'};	

		if (mode == 'edit') {
			params.mode = mode;
			title = 'Ubah';
			params.txt_item = $(el).data('item');
			params.txt_id = $(el).data('id');
			params.rd_id = $(el).data('rd_id');
			params.rsd_id = $(el).data('rsd_id');
		}
		else
		{
			params.mode = 'add';
			title = 'Tambah';
		}

		$('#txt_province').on('select',function(){
		});

		$.popup({
			title: title + ' Pembayaran Sales Order',
			id: 'showItem',
			size: 'large',
			proxy: {
				url: siteUrl('transaksi/daftar_pembayaran_sales_order/load_daftar_pembayaran_sales_order_form'),
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
							url: siteUrl('transaksi/daftar_pembayaran_sales_order/store_data_daftar_pembayaran_sales_order'),
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
					let new_params = {};
					if (mode == 'edit') {
						// daftarPaySalesOrderList.generateRegion($('#txt_province').val(),$(el).data('rd_id'));
						// daftarPaySalesOrderList.loadDataItemTemporary();

						daftarPaySalesOrderList.generateVendor(); //generate vendor
						daftarPaySalesOrderList.generateKasBank(); //generate kas dan bank
					}

					if (typeof(mode) !== 'undefined') {
						mode = mode;
					}
					else
					{
						mode = 'add';
					}
					
					daftarPaySalesOrderList.generateVendor(); //generate vendor
					daftarPaySalesOrderList.generateKasBank(); //generate kas dan bank

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
						arrZ = [];
						new_params.mode = mode;
						new_params.so_vendor_id = me.val();

						if (me.val() !== '') {
							daftarPaySalesOrderList.loadDataItemTemporary(new_params);
						}
					});
				}
			}
		});

	},
	generateVendor: function(vendor_id = false) {
		var vendor = $('#v_vendor_id');
			// console.log(provinceId)
			$.ajax({
				url: siteUrl('transaksi/daftar_pembayaran_sales_order/get_vendor_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_vendor_option',
					vendor_id: vendor_id
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						vendor.attr('disabled', false);

						vendor.html($('<option>', {
							value: '',
							text: '--Pilih Vendor--'
						}));
						
						data.forEach(function (newData) {
							vendor.append($('<option>', {
								value: newData.v_id,
								text: newData.v_vendor_name
							}));
						});

						if (vendor_id !== false) vendor.val(vendor_id);

					} else {

						vendor.html($('<option>', {
							value: '',
							text: 'Nama Vendor Tidak Ditemukan!'
						}));
					}
				},
				error: function (error) {
					toastr.error(msgErr);
				}
			});
	},
	generateKasBank: function(rad_id = false) {
		var rad = $('#co_rad_id');
			// console.log(provinceId)
			$.ajax({
				url: siteUrl('transaksi/daftar_pembayaran_sales_order/get_kas_bank_option'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_kas_bank_option',
					rad_id: rad_id
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						rad.attr('disabled', false);

						rad.html($('<option>', {
							value: '',
							text: '--Pilih Kode Akun--'
						}));
						
						data.forEach(function (newData) {
							rad.append($('<option>', {
								value: newData.rad_id,
								text: newData.rad_name
							}));
						});

						if (rad_id !== false) rad.val(rad_id);

					} else {

						rad.html($('<option>', {
							value: '',
							text: 'Kode Akun Tidak Ditemukan!'
						}));
					}
				},
				error: function (error) {
					toastr.error(msgErr);
				}
			});
	},
	generateSalesOrder: function(vendor_id, il_id = false) {
		var itemList = $('#il_id');
			// console.log(provinceId)
			$.ajax({
				url: siteUrl('transaksi/daftar_pembayaran_sales_order/get_item_list_option'),
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
					url: siteUrl('transaksi/daftar_pembayaran_sales_order/delete_data_item'),
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
			url: siteUrl('transaksi/daftar_pembayaran_sales_order/delete_data_temp'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'delete_data_temp',
				id: $this.data('id'),
				sod_no_trx: $this.data('no_trx')
			},
			success: function(result) {
				$('#temporaryDataTable tbody').html('');

				if (result.success) {
					 daftarPaySalesOrderList._generateTemporaryDataTable(result.data);
				}
				else if (result.success == false)
				{
					daftarPaySalesOrderList._generateTemporaryDataTable(result.data);
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
	daftarPaySalesOrderList.init();
});