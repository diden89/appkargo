/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/projects/projects_data.js
 */

const _generate_menu = (data) => {
	let treeMenu = _generate_tree_menu(data, null, 0);

	// $('.collaptable').find('tbody').html('');
	$('.collaptable').find('tbody').append(treeMenu);
	$('.collaptable').aCollapTable({
		startCollapsed: true,
		addColumn: false,
		plusButton: '<span class="fas fa-plus"></span>',
		minusButton: '<span class="fas fa-minus"></span>'
	}); 
};

const _generate_sub_data = (data) => {
	let strSubData = '';

	$.each(data, (k, v) => {
		
		strSubData += '<tr>';
			strSubData += '<td><b>' + v.p_name + '</b></td>'
			strSubData += '<td><b>' + v.bt_building_type + '</b></td>'
			strSubData += '<td><b>' + v.ps_name + '</b></td>'
			strSubData += '<td style="text-align:center;">';
				strSubData += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					strSubData += '<button type="button" class="btn btn-success" data-id="' + v.ps_id + '" data-nama="' + v.ps_name + '" onclick="popup_projects_sub(\'edit\', \'Edit\',' + v.ps_id + ');"><i class="fas fa-edit"></i></button>';
					strSubData += '<button type="button" class="btn btn-danger" data-id="' + v.ps_id + '" data-nama="' + v.ps_name + '" onclick="delete_data(' + v.p_id + ',' + v.ps_id + ',\'projects_sub\');"><i class="fas fa-trash-alt"></i></button>';
				strSubData += '</div>';
			strSubData += '</td>';
			// strSubData += '<input type="hidden" value="'+ bt_id +'" name="bt_id[]">';
		strSubData += '</tr>';
	});

	$('.projects-sub').find('tbody').append(strSubData);
};

function popup_projects(mode = 'add', title = 'Add', data = false)
{
	$.popup({
		title: title + ' Projects',
		id: mode + 'ProjectsPopup',
		size: 'default',
		proxy: {
			url: siteUrl('projects/projects_data/popup_projects'),
			params: {
				action: 'popup_modal',
				mode: mode,
				data: data
			}
		},
		buttons: [{
			btnId: 'saveData',
			btnText:'Save',
			btnClass: 'info',
			btnIcon: 'fas fa-check-circle',
			onclick: function(popup) {
				var form  = popup.find('form');
				if ($.validation(form)) {
					var formData = new FormData(form[0]);
					$.ajax({
						url: siteUrl('projects/projects_data/store_data_projects'),
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

							get_data();
							loadProjectsSub(data);

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
			btnText:'Tutup',
			btnClass: 'secondary',
			btnIcon: 'fas fa-times',
			onclick: function(popup) {
				popup.close();
			}
		}],
	});
}

function popup_projects_sub(mode = 'add', title = 'Add', data = false)
{
	$.popup({
		title: title + ' Projects',
		id: mode + 'ProjectsSubPopup',
		size: 'default',
		proxy: {
			url: siteUrl('projects/projects_data/popup_projects_sub'),
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
			btnIcon: 'fas fa-check-circle',
			onclick: function(popup) {
				var form  = popup.find('form');
				if ($.validation(form)) {
					var formData = new FormData(form[0]);
					$.ajax({
						url: siteUrl('projects/projects_data/store_data_projects_sub'),
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

							loadProjectsSub(result.p_id);

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
			btnText:'Tutup',
			btnClass: 'secondary',
			btnIcon: 'fas fa-times',
			onclick: function(popup) {
				popup.close();
			}
		}],
	});
}

function loadProjectsSub(p_id) 
{
	$.ajax({
		url: siteUrl('projects/projects_data/get_sub_data'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'get_sub_data',
			p_id: p_id,
		},
		success: function (result) {
			if (result.success) {
				$('.projects-sub').find('tbody').html('');
				$('.projects-sub').find('tbody').append('<input type="hidden" value="'+p_id+'" name="p_id">');
				_generate_sub_data(result.data);
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
}

function loadData(data,callback) 
{
	$('.data-projects').find('tbody').html('');

	var listGroup = '';
	
	$.each(data, (k, v) => {
		listGroup += '<tr style="cursor:pointer;" data-id="' + v.p_id + '">';
		listGroup += '<td  class="click-list" id="' + v.p_id + '">'+ v.p_name+'</td>';
		listGroup += '<td>'+ v.p_location+'</td>';
		listGroup += '<td>';
				listGroup += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					listGroup += '<button type="button" class="btn btn-success" data-id="' + v.p_id + '" data-item="' + v.p_name + '" onclick="popup_projects(\'edit\', \'Edit\',' + v.p_id + ');"><i class="fas fa-edit"></i></button>';
					listGroup += '<button type="button" class="btn btn-danger" data-id="' + v.p_id + '" data-item="' + v.p_name + '" onclick="delete_data(' + v.p_id + ',\'\',\'projects\');"><i class="fas fa-trash-alt"></i></button>';
				listGroup += '</div>';
			listGroup += '</td>';
		listGroup += '</tr>';
	});
	
	$('.data-projects').find('tbody').append(listGroup);

	callback();
}

function get_data()
{
	$.ajax({
		url: siteUrl('projects/projects_data/get_data'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'get_data'
		},
		success: function (result) {
			if (result.success) {
				loadData(result.data, function() {
					$('.click-list').on('click', function (e) {
						e.preventDefault();
						$('.btn-sub').css('display','block');
						p_id = $(this).attr('id');
						loadProjectsSub(p_id);
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
}

function delete_data(p_id = "",ps_id = "", mode = "")
{		
// console.log(mode)					
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
				url: siteUrl('projects/projects_data/delete_data'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'delete_data',
					txt_p_id: p_id,
					txt_ps_id: ps_id,
					mode : mode

				},
				success: function(result) {
					if (result.success) {
						toastr.success("Data succesfully deleted.");
						if(mode == 'projects')
						{
							get_data();
						}
						else
						{
							loadProjectsSub(p_id);
						}
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
							
}

$(document).ready(function() {
	
	get_data();

	$('#AddData').submit(function(e){
		e.preventDefault(); 

		$.ajax({
			url: siteUrl('projects/projects_data/store_data_projects'),
			type: 'POST',
			dataType: 'JSON',
			data: new FormData(this),
			processData: false,
			contentType: false,
				cache: false,
				enctype: 'multipart/form-data',
			success: function(result) {
				if (result.success) {
					toastr.success(msgSaveOk);
					loadTreeMenuData(result.ug_id);

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
});