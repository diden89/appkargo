/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/settings/user.js
 */

function show_modal(data,title,mode){
    $.popup({
		title: title + ' Menu',
		id: mode + 'MenuPopup',
		size: 'medium',
		proxy: {
			url: siteUrl('settings/menu/popup_modal'),
			params: {
				action: 'popup_modal',
				mode: mode,
				id: data
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
										_generate_menu(result.data);
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
		}]
	});
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
					rm_id: data
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
								_generate_menu(result.data);
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

const _generate_menu = (data) => {
	let treeMenu = _generate_tree_menu(data, null, 0);

	$('.collaptable').find('tbody').html(treeMenu);
	 $('.collaptable').aCollapTable({
		startCollapsed: true,
		addColumn: false,
		plusButton: '<span class="fas fa-plus"></span>',
		minusButton: '<span class="fas fa-minus"></span>'
	}); 
};

const _generate_tree_menu = (datas, parentId, idx) => {
	let strMenu = '';

	if (parentId == null || parentId == '' || parentId == ' ' || parentId == 0) {
		parentId = null;
	}

	idx++;

	$.each(datas, (k, v) => {
		if (v.rm_parent_id == parentId) {
			// console.log(parentId);
			let children = _generate_tree_menu(datas, v.rm_id, idx);

			if (children != '') {
				strMenu += '<tr data-id="' + v.rm_id + '" data-parent="' + v.rm_parent_id + '">';
					strMenu += '<td></td>';
					strMenu += '<td id="captionMenu"><b>' + v.rm_caption + '</b></td>';
					strMenu += '<td>' + v.rm_url + '</td>';
					strMenu += '<td>' + v.rm_icon + '</td>';
					strMenu += '<td>' + v.rm_description + '</td>';
					strMenu += '<td>' + v.rm_sequence + '</td>';
					strMenu += '<td style="text-align:center;">';
						strMenu += '<div class="btn-group" role="group" aria-label="RAB Button Group">'; 
							strMenu += '<button id="btnEdit" class="btn merekdagang-grid-btn btn-success btn-sm" onClick=show_modal(' + v.rm_id +',"Edit","edit")><i class="fas fa-edit"></i> Edit</button>';
							strMenu += '<button id="btnDelete" class="btn merekdagang-grid-btn btn-danger btn-sm " onClick=delete_data(' + v.rm_id +') ><i class="fas fa-trash-alt"></i> Delete</button >';
						strMenu += '</div>';
						strMenu += '</td >';
				strMenu += '</tr>';

				if (idx > 0) {
					strMenu += children;
				}
			} else {
				if (parentId != null && parentId != '') {
					strMenu += '<tr data-id="' + v.rm_id + '" data-parent="' + v.rm_parent_id + '">';
						strMenu += '<td><i class="fas fa-angle-double-right"></i></td>';
						strMenu += '<td id="captionMenu">' + v.rm_caption + '</td>';
						strMenu += '<td>' + v.rm_url + '</td>';
						strMenu += '<td>' + v.rm_icon + '</td>';
						strMenu += '<td>' + v.rm_description +'</td>';
						strMenu += '<td>' + v.rm_sequence + '</td>';
						strMenu += '<td style="text-align:center;">';
						strMenu += '<div class="btn-group" role="group" aria-label="RAB Button Group">'; 
							strMenu += '<button id="btnEdit" class="btn merekdagang-grid-btn btn-success btn-sm" onClick=show_modal(' + v.rm_id +',"Edit","edit")><i class="fas fa-edit"></i> Edit</button>';
							strMenu += '<button id="btnDelete" class="btn merekdagang-grid-btn btn-danger btn-sm" onClick=delete_data(' + v.rm_id +') ><i class="fas fa-trash-alt"></i> Delete</button >';
						strMenu += '</div>';
						strMenu += '</td >';
					strMenu += '</tr >';
				} else {
					strMenu += '<tr data-id="' + v.rm_id + '" data-parent="">';
						strMenu += '<td><i class="fas fa-angle-double-right"></i></td>';
						strMenu += '<td id="captionMenu"><b>' + v.rm_caption + '</b></td>';
						strMenu += '<td>' + v.rm_url + '</td>';
						strMenu += '<td>' + v.rm_icon + '</td>';
						strMenu += '<td>' + v.rm_description + '</td>';
						strMenu += '<td>' + v.rm_sequence + '</td>';
						strMenu += '<td style="text-align:center;">';
						strMenu += '<div class="btn-group" role="group" aria-label="RAB Button Group">'; 
							strMenu += '<button id="btnEdit" class="btn merekdagang-grid-btn btn-success btn-sm" onClick=show_modal(' + v.rm_id +',"Edit","edit")><i class="fas fa-edit"></i> Edit</button>';
							strMenu += '<button id="btnDelete" class="btn merekdagang-grid-btn btn-danger btn-sm" onClick=delete_data(' + v.rm_id +') ><i class="fas fa-trash-alt"></i> Delete</button >';
						strMenu += '</div>';
						strMenu += '</td >';
					strMenu += '</tr >';
				}
			}
		}
	});

	return strMenu;
};

$(document).ready(function() {
	$.ajax({
		url: siteUrl('settings/menu/get_menu_data'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'get_menu_data'
		},
		success: function (result) {
			if (result.success) {
				_generate_menu(result.data);
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

	
});