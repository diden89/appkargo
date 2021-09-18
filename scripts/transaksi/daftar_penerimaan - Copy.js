/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/transaksi/daftar_penerimaan.js
 */

const daftarDeliveryOrderList = {
	selectedData: '',
	init: function() {
		const me = this;

		$('#btnSearchItem').click(function(e) {
			e.preventDefault();
			daftarDeliveryOrderList.loadDataDo(this);
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
	loadDataDo: function(el) {
		const me = this;
		const $this = $(el);

		src = $('#txtList').val();

		$.ajax({
			url: siteUrl('transaksi/daftar_penerimaan/load_data_daftar_penerimaan'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_daftar_penerimaan',
				so_no_trx: el.so_no_trx,
				txt_item: src,
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
			body += '<td>' + item.num + '</td>';
			body += '<td>' + item.dod_no_trx + '</td>';
			body += '<td>' + item.c_name + '</td>';
			body += '<td>' + item.il_item_name + '</td>';
			body += '<td>' + item.d_name + ' / ' + item.ve_license_plate + '</td>';
			body += '<td>' + item.c_address + '<br>' + item.rsd_name + '</td>';
			body += '<td>' + item.dod_shipping_qty + '</td>';
			body += '<td>' + item.dos_filled + '</td>';
			body += '<td>' + item.new_ongkir + '</td>';
			body += '<td>' + item.dod_created_date + '</td>';
			body += '<td>' + item.dos_keterangan + '</td>';
			body += '<td>' + item.dod_is_status + '</td>';
			body += '<td>';			
			body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
				body += '<button type="button" class="btn btn-success" data-id="' + item.dod_id + '" data-no_trx="' + item.dod_no_trx + '" data-is_status="' + item.dod_is_status + '" data-so_id="' + item.so_id + '" data-so_no_trx="' + item.so_no_trx + '" onclick="daftarDeliveryOrderList.updateStatus(this, \'edit\');"><i class="fas fa-check-double"></i> Finish</button>';
			body += '</div>';
		
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	updateStatus: function(el, mode) {
		
		const me = this;
		let params = {action: 'load_update_status_form'};
	

		if (mode == 'edit') {
			params.mode = mode;
			title = 'Edit';
			params.txt_id = $(el).data('id');
			// params.no_trx = $(el).data('no_trx');
			// params.dod_is_status = $(el).data('is_status');
			// params.so_id = $(el).data('so_id');
			// params.so_no_trx = $(el).data('so_no_trx');
			// params.rsd_id = $(el).data('rsd_id');
		}
		else
		{
			params.mode = 'add';
			title = 'Add';
		}

		$.popup({
			title: 'Form Status Pengiriman',
			id: 'showItem',
			size: 'medium',
			proxy: {
				url: siteUrl('transaksi/daftar_penerimaan/load_update_status_form'),
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
						var order = $('#total_order').val();
							filled =  $('#total_terpenuhi').val();
							// console.log(order)
						// if(filled > order) 
						// {
						// 	Swal.fire({
						// 		title: 'Total Tidak Sesuai',
						// 		text: "Total tidak sesuai dengan jumlah order, periksa kembali!",
						// 		type: 'warning',
						// 		showCancelButton: false,
						// 		confirmButtonColor: '#17a2b8',
						// 		cancelButtonColor: '#d33',
						// 		confirmButtonText: 'Close!'
						// 	})
						// }
						// else
						// {
							$.ajax({
								url: siteUrl('transaksi/daftar_penerimaan/store_update_status'),
								type: 'POST',
								dataType: 'JSON',
								data: formData,
								processData: false,
								contentType: false,
		         				cache: false,
								success: function(result) {
									if (result.success) {
										toastr.success(msgSaveOk);
										// $('#ignoredItemDataTable').DataTable().draw();
										me._generateItemDataTable(result.data);
									} else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
									else toastr.error(msgErr);

									popup.close();

								},
								error: function(error) {
									toastr.error(msgErr);
								}
							});							
						// }

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
						url: siteUrl('transaksi/daftar_penerimaan/load_do_data'),
						type: 'POST',
						dataType: 'JSON',
						data: {
							action : 'load_data_daftar_penerimaan'
						},
						success: function(result) {
							if (result.success) {
								// toastr.success('msgSaveOk');
								// oTable.draw();
								me._generateItemDataTable(result.data);
							} else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
							else toastr.error(msgErr);

							popup.close();

						},
						error: function(error) {
							toastr.error(msgErr);
						}
					});
					// oTable.draw();
					// popup.close();
				}
			}],
			listeners : {
				onshow: function(popup) {
					$('#total_terpenuhi').keyup(function(event) {
						var  ttl = $('#total_terpenuhi').val();
							 shp = $('#shipping').val();
					  		new_ttl = ttl.replace(',','');
					  	
					  	var formatter = new Intl.NumberFormat();
					  	console.log(new_ttl)
						ongkir = formatter.format(new_ttl * shp);
					  $('#total_ongkir_upd').val(ongkir);
					  $('#total_ongkir_upd_hidden').val(new_ttl * shp);
					});

					$('#total_terpenuhi').keyup(function(event) {
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
					url: siteUrl('transaksi/daftar_penerimaan/delete_data'),
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
	}
	
};


$(document).ready(function() {
	daftarDeliveryOrderList.init();

});