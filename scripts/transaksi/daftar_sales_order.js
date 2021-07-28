/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/transaksi/pelanggan.js
 */

const daftarSalesOrderList = {
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
			me.showItem(this);
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
			url: siteUrl('transaksi/daftar_sales_order/load_data_daftar_sales_order'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_daftar_sales_order',
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
	_generateItemDataTable: (data) => {
		const $this = $('#ignoredItemDataTable tbody');

		$this.html('');

		let body = '';

		$.each(data, (idx, item) => {
			body += '<tr>';
			body += '<td>' + item.no + '</td>';
			body += '<td>' + item.c_name + '</td>';
			body += '<td>' + item.c_address + '</td>';
			body += '<td>' + item.c_phone + '</td>';
			body += '<td>' + item.c_email + '</td>';
			body += '<td>' + item.rsd_name + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.c_id + '" data-rd_id="' + item.rd_id + '" data-rsd_id="' + item.c_district_id + '" data-item="' + item.c_name + '" onclick="daftarSalesOrderList.showItem(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.c_id + '" data-item="' + item.c_name + '" onclick="daftarSalesOrderList.deleteDataItem(this);"><i class="fas fa-trash-alt"></i></button>';
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
			body += '<td>' + item.qty + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.qty + '" data-idx="' + item.idx + '" onclick="daftarSalesOrderList.deleteDataTemp(this);"><i class="fas fa-trash-alt"></i></button>';
				body += '</div>';
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	showItem: function(el, mode) {
		const me = this;
		let params = {action: 'load_daftar_sales_order_form'};
		let title = 'Add New';

		if (typeof(mode) !== 'undefined') {
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
		}

		$('#txt_province').on('select',function(){
		});

		$.popup({
			title: title + ' Sales Order',
			id: 'showItem',
			size: 'large',
			proxy: {
				url: siteUrl('transaksi/daftar_sales_order/load_daftar_sales_order_form'),
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
							url: siteUrl('transaksi/daftar_sales_order/store_data_daftar_sales_order'),
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
						daftarSalesOrderList.generateRegion($('#txt_province').val(),$(el).data('rd_id'));
						daftarSalesOrderList.generateDistrict($(el).data('rd_id'),$(el).data('rsd_id'));
					}

					$('#btnAddDetail').click(function(){
						var qty = $('#sod_qty').val();
							il_id = $('#il_id').val();
							no_trx = $('#so_no_trx').val();

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
									url: siteUrl('transaksi/daftar_sales_order/store_data_temporary'),
									type: 'POST',
									dataType: 'JSON',
									data: {
										action: 'insert_temporary_data',
										qty: qty,
										il_id: il_id
									},
									success: function(result) {
										if (result.success) {
											toastr.success("Data succesfully added.");
											daftarSalesOrderList._generateTemporaryDataTable(result.data);

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
					$('#txt_province').change(function() {
						var me = $(this);
						// console.log(me.val())

							if (me.val() !== '') {
								
								daftarSalesOrderList.generateRegion(me.val());

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
								
								daftarSalesOrderList.generateDistrict(me.val());

							} else {
								$('#txt_district').html($('<option>', {
									value: '',
									text: 'Pilih Kabupaten/Kota'
								}));

								$('#txt_district').attr('disabled', true);
							}
					});

					// console.log(mode)				
				}
			}
		});

	},
	generateRegion: function(provinceId, regionId = false) {
		var region = $('#txt_region');
			// console.log(provinceId)
			$.ajax({
				url: siteUrl('transaksi/daftar_sales_order/get_region_option'),
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
				url: siteUrl('transaksi/daftar_sales_order/get_district_option'),
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
					url: siteUrl('transaksi/daftar_sales_order/delete_data_item'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data_item',
						txt_id: $this.data('id')
					},
					success: function(result) {
						$('#ignoredItemDataTable tbody').html('');
						
						if (result.success) me._generateItemDataTable(result.data);
						else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
						else toastr.error(msgErr);
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
		// console.log('lai')
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
					url: siteUrl('transaksi/daftar_sales_order/delete_data_temp'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data_temp',
						idx: $this.data('idx')
					},
					success: function(result) {
						$('#ignoredItemDataTable tbody').html('');
						
						if (result.success) daftarSalesOrderList._generateTemporaryDataTable(result.data);
						else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
						else toastr.error(msgErr);
					},
					error: function(error) {
						toastr.error(msgErr);
					}
				});
			}
		});
	}
};

$(document).ready(function() {
	daftarSalesOrderList.init();
});