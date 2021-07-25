/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/akuntansi/daftar_perkiraan.js
 */

const daftarPerkiraan = {
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
			me.show_modal(this);
		});
	},
	loadDataItem: function(el) {
		const me = this;
		const $this = $(el);

		$.ajax({
			url: siteUrl('akuntansi/daftar_perkiraan/get_akun_header'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'get_akun_header'
			},
			success: function (result) {
				if (result.success) {
					me.loadData(result.data, function() {
						$('#headerList a').on('click', function (e) {
							e.preventDefault();
							$('#btnSave').attr('disabled', false);
							rah_id = $(this).attr('data-id');
							$('#btnAddItem').attr('data-id', rah_id);
							me.loadTreeData(rah_id);
						});
					});

				} else if (typeof (result.msg) !== 'undefined') {
					toastr.error(result.msg);
				} else {
					toastr.error(msgErr);
				}
			},
			error: function (error) {
				toastr.error(msgErr);
			}
		});
	},
	loadData : function(data, callback) {
		var headerList = $('#headerList');

		headerList.html('');

		for (var x in data) {
			var newData = data[x];
			// console.log(newData)
			headerList.append('<a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#" aria-controls="profile" data-id="' + newData.rah_id + '">' + newData.rah_name.toUpperCase() + '</a>');
		}
		callback();
	},
	loadTreeData : function(rah_id) {

		$.ajax({
			url: siteUrl('akuntansi/daftar_perkiraan/get_akun_detail'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'get_akun_detail',
				rah_id: rah_id,
			},
			success: function (result) {
				if (result.success) {
					$('.collaptable').find('tbody').html('');
					// $('.collaptable').find('tbody').append('<input type="hidden" value="'+rah_id+'" name="rah_id">');
					daftarPerkiraan._generate_akun_detail(result.data.data);
				} else if (typeof (result.msg) !== 'undefined') {
					toastr.error(result.msg);
				} else {
					toastr.error(msgErr);
				}
			},
			error: function (error) {
				toastr.error(msgErr);
			}
		});
	},
	_generate_akun_detail : (data) => {
		let treeMenu = daftarPerkiraan._generate_tree_detail(data, null, 0);

		$('.collaptable').find('tbody').html(treeMenu);
		 $('.collaptable').aCollapTable({
			startCollapsed: true,
			addColumn: false,
			plusButton: '<span class="fas fa-plus"></span>',
			minusButton: '<span class="fas fa-minus"></span>'
		}); 
	},
	_generate_tree_detail : (datas, parentId, idx) => {
		let strMenu = '';

		if (parentId == null || parentId == '' || parentId == ' ' || parentId == 0) {
			parentId = null;
		}

		idx++;

		$.each(datas, (k, v) => {
			if (v.rad_parent_id == parentId) {
				// console.log(parentId);
				let children = daftarPerkiraan._generate_tree_detail(datas, v.rad_id, idx);

				if (children != '') {
					strMenu += '<tr data-id="' + v.rad_id + '" data-parent="' + v.rad_parent_id + '">';
						strMenu += '<td></td>';
						strMenu += '<td id="captionMenu"><b>' + v.rad_kode_akun + '</b></td>';
						strMenu += '<td>' + v.rad_name + '</td>';
						strMenu += '<td>' + v.rad_type + '</td>';
						strMenu += '<td style="text-align:center;">';
							strMenu += '<div class="btn-group" role="group" aria-label="RAB Button Group">'; 
								strMenu += '<button id="btnEdit" class="btn merekdagang-grid-btn btn-success btn-sm" onClick=daftarPerkiraan.show_modal(this,\'edit\')><i class="fas fa-edit"></i> Edit</button>';
								strMenu += '<button id="btnDelete" class="btn merekdagang-grid-btn btn-danger btn-sm " onClick=daftarPerkiraan.delete_data(' + v.rad_id +') ><i class="fas fa-trash-alt"></i> Delete</button >';
							strMenu += '</div>';
						strMenu += '</td >';
					strMenu += '</tr>';

					if (idx > 0) {
						strMenu += children;
					}
				} else {
					if (parentId != null && parentId != '') {
						strMenu += '<tr data-id="' + v.rad_id + '" data-parent="' + v.rad_parent_id + '">';
							strMenu += '<td><i class="fas fa-angle-double-right"></i></td>';
								strMenu += '<td id="captionMenu"><b>' + v.rad_kode_akun + '</b></td>';
							strMenu += '<td>' + v.rad_name + '</td>';
							strMenu += '<td>' + v.rad_type + '</td>';
							strMenu += '<td style="text-align:center;">';
							strMenu += '<div class="btn-group" role="group" aria-label="RAB Button Group">'; 
								strMenu += '<button id="btnEdit" class="btn merekdagang-grid-btn btn-success btn-sm" onClick=daftarPerkiraan.show_modal(this,\'edit\')><i class="fas fa-edit"></i> Edit</button>';
								strMenu += '<button id="btnDelete" class="btn merekdagang-grid-btn btn-danger btn-sm " onClick=daftarPerkiraan.delete_data(' + v.rad_id +') ><i class="fas fa-trash-alt"></i> Delete</button >';
							strMenu += '</div>';
						strMenu += '</td >';
						strMenu += '</tr >';
					} else {
						strMenu += '<tr data-id="' + v.rad_id + '" data-parent="">';
							strMenu += '<td><i class="fas fa-angle-double-right"></i></td>';
							strMenu += '<td id="captionMenu"><b>' + v.rad_kode_akun + '</b></td>';
							strMenu += '<td>' + v.rad_name + '</td>';
							strMenu += '<td>' + v.rad_type + '</td>';
							strMenu += '<td style="text-align:center;">';
							strMenu += '<div class="btn-group" role="group" aria-label="RAB Button Group">'; 
								strMenu += '<button id="btnEdit" class="btn merekdagang-grid-btn btn-success btn-sm" onClick=daftarPerkiraan.show_modal(this,\'edit\')><i class="fas fa-edit"></i> Edit</button>';
								strMenu += '<button id="btnDelete" class="btn merekdagang-grid-btn btn-danger btn-sm " onClick=daftarPerkiraan.delete_data(' + v.rad_id +') ><i class="fas fa-trash-alt"></i> Delete</button >';
							strMenu += '</div>';
						strMenu += '</td >';
						strMenu += '</tr >';
					}
				}
			}
		});

		return strMenu;
	},
	show_modal : function(el, mode){

		var rah_id = $('#btnAddItem').attr('data-id');

		// const me = this;
		// let params = {action: 'load_driver_form'};
		// let title = 'Add New';

		// if (typeof(mode) !== 'undefined') {
		// 	params.mode = mode;
		// 	title = 'Edit';
		// 	params.txt_item = $(el).data('item');
		// 	params.txt_id = $(el).data('id');
		// 	params.rd_id = $(el).data('rd_id');
		// 	params.rsd_id = $(el).data('rsd_id');
		// }
		// else
		// {
		// 	params.mode = 'add';
		// }

	    $.popup({
			title: title + ' Akun Perkiraan',
			id: mode + 'AkunPerkiraanPopup',
			size: 'medium',
			proxy: {
				url: siteUrl('akuntansi/daftar_perkiraan/popup_modal'),
				params: {
					action: 'popup_modal',
					mode: mode,
					id: data,
					rah_id : rah_id
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
							url: siteUrl('settings/menu/store_data'),
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

								$.ajax({
									url: siteUrl('settings/menu/get_menu_data'),
									type: 'POST',
									dataType: 'JSON',
									data: {
										action: 'get_menu_data'
									},
									success: function (result) {
										if (result.success) {
											daftarPerkiraan._generate_akun_detail(result.data);
										} else if (typeof (result.msg) !== 'undefined') {
											toastr.error(result.msg);
										} else {
											toastr.error(msgErr);
										}
									},
									error: function (error) {
										toastr.error(msgErr);
									}
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
					if (mode == 'edit') {
						// driverList.generateRegion($('#txt_province').val(),$(el).data('rd_id'));
						// driverList.generateDistrict($(el).data('rd_id'),$(el).data('rsd_id'));
					}

					$('#txt_header').change(function() {					
						var me = $(this);
						// console.log(me.val())

							if (me.val() !== '') {
								
								daftarPerkiraan.generateSubHeader(me.val());

							} else {
								$('#txt_posisi').html($('<option>', {
									value: '',
									text: '--Pilih Header--'
								}));

								$('#txt_posisi').attr('disabled', true);
							}
							// $('#txt_district').attr('disabled', true);
							// $('#txt_district').html($('<option>', {
							// 	value: '',
							// 	text: '--Pilih Kabupaten / Kota--'
							// }));
					});	

					// $('#txt_region').change(function() {
					// 	var me = $(this);
					// 	// console.log(me)

					// 		if (me.val() !== '') {
								
					// 			driverList.generateDistrict(me.val());

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
	generateSubHeader: function(rahId, radId = false) {
		var subHeader = $('#txt_posisi');
			headerCcode = $('#header_code');

			$.ajax({
				url: siteUrl('akuntansi/daftar_perkiraan/get_akun_detail'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_akun_detail',
					rah_id: rahId
				},
				success: function (result) {
					if (result.success) {
						var data = result.data.data;
						
						subHeader.attr('disabled', false);
						headerCcode.val(result.data.code);
						
						subHeader.html($('<option>', {
							value: '',
							text: '--Pilih Posisi--'
						}));
						
						data.forEach(function (newData) {
							subHeader.append($('<option>', {
								value: newData.rad_id,
								text: newData.rad_name
							}));
						});

						if (radId !== false) subHeader.val(radId);

					} else {

						headerCcode.val(result.data.code);
						subHeader.html($('<option>', {
							value: '',
							text: 'Posisi tidak ditemukan!'
						}));
					}
				},
				error: function (error) {
					toastr.error(msgErr);
				}
			});
	}


}



function delete_data(data){
	Swal.fire({
		title: 'Apakah anda yakin?',
		text: "Data yang sudah di hapus tidak bisa dikembalikan lagi!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#17a2b8',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Iya, Hapus data ini!'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: siteUrl('settings/menu/delete_data'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'delete_data',
					rad_id: data
				},
				success: function(result) {
					if (result.success) {
						toastr.success("Hapus data sukses dilakukan.");
					} else if (typeof(result.msg) !== 'undefined') {
						toastr.error(result.msg);
					} else {
						toastr.error(msgErr);
					}

					$.ajax({
						url: siteUrl('settings/menu/get_menu_data'),
						type: 'POST',
						dataType: 'JSON',
						data: {
							action: 'get_menu_data'
						},
						success: function (result) {
							if (result.success) {
								_generate_akun_detail(result.data);
							} else if (typeof (result.msg) !== 'undefined') {
								toastr.error(result.msg);
							} else {
								toastr.error(msgErr);
							}
						},
						error: function (error) {
							toastr.error(msgErr);
						}
					});
				},
				error: function(error) {
					toastr.error(msgErr);
				}
			});
		}
	});
}


$(document).ready(function() {
	daftarPerkiraan.init();
	// daftarPerkiraan.loadDataItem();
	// 

	// $('#addAccessGroup').submit(function(e){
	// 	e.preventDefault(); 

	// 	$.ajax({
	// 		url: siteUrl('settings/menu_access_group/store_data'),
	// 		type: 'POST',
	// 		dataType: 'JSON',
	// 		data: new FormData(this),
	// 		processData: false,
	// 		contentType: false,
	// 			cache: false,
	// 			enctype: 'multipart/form-data',
	// 		success: function(result) {
	// 			if (result.success) {
	// 				toastr.success(msgSaveOk);
	// 				loadTreeData(result.ug_id);

	// 			} else if (typeof(result.msg) !== 'undefined') {
	// 				toastr.error(result.msg);
	// 			} else {
	// 				toastr.error(msgErr);
	// 			}

	// 		},
	// 		error: function(error) {
	// 			toastr.error(msgErr);
	// 		}
	// 	});
	// });
});