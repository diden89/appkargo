/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/akuntansi/kas_keluar.js
 */

const daftarCashOutList = {
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
			url: siteUrl('akuntansi/kas_keluar/load_data_kas_keluar'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_kas_keluar',
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
	loadDataItemTemporary: function(el) {
		const me = this;
		const $this = $(el);
		
		$.ajax({
			url: siteUrl('akuntansi/kas_keluar/load_data_cash_out_detail'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_cash_out_detail',
				txt_item: $('#txtList').val(),
				cod_co_no_trx:$('#no_trx_id').val(),
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
			body += '<td>' + item.co_no_trx + '</td>';
			body += '<td>' + item.co_created_date + '</td>';
			body += '<td>' + item.rad_name + '</td>';
			body += '<td>' + item.co_keterangan + '</td>';
			body += '<td>' + item.co_total + '</td>';
			body += '<td>' + item.ud_fullname + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.co_id + '" data-no_trx="' + item.co_no_trx + '" data-ud_id="' + item.ud_id + '" data-rad_id="' + item.rad_id + '" onclick="daftarCashOutList.showItem(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.so_id + '"  data-no_trx="' + item.co_no_trx + '" onclick="daftarCashOutList.deleteDataItem(this);"><i class="fas fa-trash-alt"></i></button>';
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
			body += '<td>' + item.no + '</td>';
			body += '<td>' + item.rad_kode_akun + '</td>';
			body += '<td>' + item.rad_name + '</td>';
			body += '<td>' + item.cod_keterangan + '</td>';
			body += '<td>' + item.cod_total + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.cod_id + '" data-cod_rad_id="' + item.cod_rad_id + '" data-header_id="' + item.rad_akun_header_id + '" data-cod_keterangan="' + item.cod_keterangan + '" data-cod_total="' + item.cod_total + '" data-key_lock="' + item.cod_key_lock + '" onclick="daftarCashOutList.editDetailSO(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.cod_id + '" data-key_lock="' + item.cod_key_lock + '" data-no_trx="' + item.cod_co_no_trx + '" onclick="daftarCashOutList.deleteDataTemp(this);"><i class="fas fa-trash-alt"></i></button>';
				body += '</div>';
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	editDetailSO: function(el) {
		const me = this;
		cod_id = $(el).data('id');
		cod_rad_id = $(el).data('cod_rad_id');
		header_id = $(el).data('header_id');
		cod_keterangan = $(el).data('cod_keterangan');
		cod_total = $(el).data('cod_total');
		key_lock = $(el).data('key_lock');

		daftarCashOutList.generateAkunHeader(header_id);
		daftarCashOutList.generateAkunDetail(header_id,cod_rad_id);
		$('#cod_id').val(cod_id);
		$('#cod_keterangan').val(cod_keterangan);
		$('#cod_total').val(cod_total);
		$('#key_lock').val(key_lock);
	},
	showItem: function(el, mode) {
		console.log(mode)
		const me = this;
		let params = {action: 'load_kas_keluar_form'};
	

		if (mode == 'edit') {
			params.mode = mode;
			title = 'Edit';
			params.id = $(el).data('id');
			params.no_trx = $(el).data('no_trx');
			params.ud_id = $(el).data('ud_id');
			params.rad_id = $(el).data('rad_id');
			// params.key_lock = $(el).data('key_lock');
		}
		else
		{
			params.mode = 'add';
			title = 'Add';
		}

		$.popup({
			title: title + ' Kas Keluar',
			id: 'showItem',
			size: 'large',
			proxy: {
				url: siteUrl('akuntansi/kas_keluar/load_kas_keluar_form'),
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

						co_total = $('#co_total').val();
						total_amount = $('#total_amount').html();

						if(co_total !== total_amount) {
							Swal.fire({
								title: 'Maaf !!',
								text: "Jumlah dan total dana harus sama nilainya",
								type: 'warning',
								showCancelButton: false,
								confirmButtonColor: '#17a2b8',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Close!'
							});
						}
						else {
							$.ajax({
								url: siteUrl('akuntansi/kas_keluar/store_data_kas_keluar'),
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
					daftarCashOutList.generateAkunHeader();
					if (mode == 'edit') {
						daftarCashOutList.loadDataItemTemporary();

						co_rad_id = $('#co_rad_id').val();
						co_no_trx = $('#co_no_trx').val();
						$.ajax({
							url: siteUrl('akuntansi/kas_keluar/get_amount_kas'),
							type: 'POST',
							dataType: 'JSON',
							data: {
								action: 'get_amount_kas',
								co_rad_id: co_rad_id
							},
							success: function(result) {
								if (result.success) {
									$('#temp_akun').val(result.amount);
								}
								
							},
							error: function(error) {
								toastr.error(msgErr);
							}
						});

						$.ajax({
							url: siteUrl('akuntansi/kas_keluar/total_amount_detail_cash_out'),
							type: 'POST',
							dataType: 'JSON',
							data: {
								action: 'total_amount_detail_cash_out',
								co_no_trx: co_no_trx
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
					
					// $('#so_no_trx').val($('#last_notrx').val());

					$('#btnAddDetail').click(function(){
						var akun_header = $('#akun_header').val();
							akun_detail = $('#akun_detail').val();
							cod_keterangan = $('#cod_keterangan').val();
							cod_total = $('#cod_total').val();							
							co_no_trx = $('#co_no_trx_temp').val();		
							cod_id = $('#cod_id').val();
							key_lock = $('#key_lock').val();		
							
						$.ajax({
							url: siteUrl('akuntansi/kas_keluar/store_data_temporary'),
							type: 'POST',
							dataType: 'JSON',
							data: {
								action: 'insert_temporary_data',
								akun_header: akun_header,
								akun_detail: akun_detail,
								cod_keterangan: cod_keterangan,
								cod_total: cod_total,
								cod_no_trx: co_no_trx,
								cod_id: cod_id,
								key_lock: key_lock,
								mode : mode
							},
							success: function(result) {
								if (result.success) {
									toastr.success("Data succesfully added.");
									daftarCashOutList._generateTemporaryDataTable(result.data);

									$('#akun_header').prop('selectedIndex',0);
									$('#akun_detail').prop('selectedIndex',0);
									$('#cod_keterangan').val('');
									$('#cod_total').val('');
									$('#cod_id').val('');
									$('#key_lock').val('');
									
									daftarCashOutList.getTotalAmount(co_no_trx);

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

					$('#created_date').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
						$('#created_date').noobsdaterangepicker({
							parentEl: "#" + popup[0].id + " .modal-body",
							showDropdowns: true,
							singleDatePicker: true,
							locale: {
								format: 'DD-MM-YYYY'
							}
						});

					$('#co_total').on('keyup',function(event) {
						if(Number.isInteger($('#co_total').val()))
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

					$('#cod_total').on('keyup',function(event) {
						if(Number.isInteger($('#cod_total').val()))
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

					$('#akun_header').change(function() {
						var me = $(this);
						
						if (me.val() !== '') {
							
							daftarCashOutList.generateAkunDetail(me.val());

						} else {
							$('#akun_detail').html($('<option>', {
								value: '',
								text: '--Akun Detail--'
							}));

							$('#akun_detail').attr('disabled', true);
						}
					});	

					$('#co_rad_id').change(function() {

						var me = $(this);
						co_rad_id = $('#co_rad_id').val();
						
						$.ajax({
							url: siteUrl('akuntansi/kas_keluar/get_amount_kas'),
							type: 'POST',
							dataType: 'JSON',
							data: {
								action: 'get_amount_kas',
								co_rad_id: co_rad_id
							},
							success: function(result) {
								if (result.success) {
									$('#temp_akun').val(result.amount);
								}
								
							},
							error: function(error) {
								toastr.error(msgErr);
							}
						});
					});	
				
				}
			}
		});

	},
	generateAkunHeader: function(rah_id = false) {
		var akun_header = $('#akun_header');

		$.ajax({
			url: siteUrl('akuntansi/kas_keluar/get_akun_header_option'),
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
	getTotalAmount: function(no_trx = false) {
		$.ajax({
			url: siteUrl('akuntansi/kas_keluar/total_amount_detail_cash_out'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'total_amount_detail_cash_out',
				co_no_trx: no_trx
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
	generateAkunDetail: function(rah_id, rad_id = false) {
		var akun_detail = $('#akun_detail');

		$.ajax({
			url: siteUrl('akuntansi/kas_keluar/get_akun_detail_option'),
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
	addCommas: function(nStr) {
	    nStr += ''; 
	    x = nStr.split('.');
	    x1 = x[0];
	    x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
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
					url: siteUrl('akuntansi/kas_keluar/delete_data_item'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data_item',
						no_trx: $this.data('no_trx')
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
			url: siteUrl('akuntansi/kas_keluar/delete_data_temp'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'delete_data_temp',
				id: $this.data('id'),
				key_lock: $this.data('key_lock'),
				cod_co_no_trx: $this.data('no_trx')
			},
			success: function(result) {
				$('#temporaryDataTable tbody').html('');

				if (result.success) {
					 daftarCashOutList._generateTemporaryDataTable(result.data);
					 daftarCashOutList.getTotalAmount($this.data('no_trx'));

					$('#akun_header').prop('selectedIndex',0);
					$('#akun_detail').prop('selectedIndex',0);
					$('#cod_keterangan').val('');
					$('#cod_total').val('');
					$('#cod_id').val('');
					$('#key_lock').val('');
				}
				else if (result.success == false)
				{
					daftarCashOutList._generateTemporaryDataTable(result.data);
					daftarCashOutList.getTotalAmount($this.data('no_trx'));
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
	daftarCashOutList.init();
});