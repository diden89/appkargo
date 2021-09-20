/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/transaksi/daftar_penerimaan.js
 */

$(document).ready(function() {

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

	var PENERIMAAN = {
		gridPenerimaan : $('#gridPenerimaan').grid({
			serverSide: true,
			striped: true,
			pageLength : 10,
			proxy: {
				url: siteUrl('transaksi/daftar_penerimaan/load_data'),
				method: 'post',
				data: {
					action: 'load_data'
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
				{	
					title: 'No Transaksi', 
					data: 'dod_no_trx',
				},
				{	
					title: 'Nama Pelanggan', 
					data: 'c_name',
				},
				{	
					title: 'Nama Barang', 
					data: 'il_item_name',
				},
				{	
					title: 'Pengemudi / Kendaraan', 
					data: 'd_name_pengemudi',
				},
				{	
					title: 'Alamat Pengiriman', 
					data: 'd_address_area',
				},{	
					title: 'Total Kirim', 
					data: 'dod_shipping_qty',
				},{	
					title: 'Total terima', 
					data: 'dos_filled',
				},{	
					title: 'Biaya',
					id : 'biaya', 
					data: 'new_ongkir'
				},{	
					title: 'Tanggal Pengiriman', 
					data: 'dos_created_date',
				},{	
					title: 'Status', 
					data: 'dod_is_status',
				},{	
					title: 'Keterangan', 
					data: 'dos_keterangan',
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
							text: 'Finish',
							class: 'btn-success',
							id: 'btnEdit',
							icon: 'fas fa-check-double',
							click: function(row, rowData) {
								PENERIMAAN.updateStatus('edit', 'Edit', rowData);
							}
						}
					],
				}
			],
			listeners: {
				ondblclick: function(row, rowData, idx) {
					PENERIMAAN.popup('edit', 'Edit', rowData);
				},

			}
		}),
		updateStatus: function(mode = 'add', title= 'Add', data = false)
		{	
			$.popup({
				title: 'Form Status Pengiriman',
				id: 'showItem',
				size: 'medium',
				proxy: {
					url: siteUrl('transaksi/daftar_penerimaan/load_update_status_form'),
					params: {

						action: 'load_update_status_form',
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
						const form  = popup.find('form');

						if ($.validation(form)) {
							const formData = new FormData(form[0]);
							var order = $('#total_order_hidden').val();
								filled =  $('#total_terpenuhi').val();
								console.log(order)
							if(filled > order) 
							{
								Swal.fire({
									title: 'Total Tidak Sesuai',
									text: "Total tidak sesuai dengan jumlah order, periksa kembali!",
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
										} else if (typeof(result.msg) !== 'undefined') {
											toastr.error(result.msg);
										} else {
											toastr.error(msgErr);
										}

										PENERIMAAN.gridPenerimaan.reloadData({
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
					}
				},
				{
					btnId: 'closePopup',
					btnText:'Close',
					btnClass: 'secondary',
					btnIcon: 'fas fa-times',
					onclick: function(popup) {
						popup.close();
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
		}
	};

	$('#daterangedata').on('click',function() {
		PENERIMAAN.gridPenerimaan.reloadData({
			date_range1: $('#range1').val(),
			date_range2: $('#range2').val(),
		});

	});

	$('#txtList').keyup(function() {
		PENERIMAAN.gridPenerimaan.reloadData({
			txt_item: $('#txtList').val(),			
		});

	});

	$('#btnReloadItem').on('click',function() {
		$('#txtList').val('');
		PENERIMAAN.gridPenerimaan.reloadData({});

	});
	console.log($('#biaya').css())

});