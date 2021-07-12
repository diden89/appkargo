/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/settings/user.js
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
					strMenu += '<td><b>' + v.rm_caption + '</b></td>'
					strMenu += '<td style="text-align:center;">';
						if(v.mag_id != '')
						{
							strMenu += '<input name="mag_id[]" type="hidden" value="'+v.mag_id+'">';
						}
						strMenu += '<input name="rm_id[]" type="checkbox" value="'+v.rm_id+'" '+v.checked+'>';
					strMenu += '</td >';
				strMenu += '</tr>';

				if (idx > 0) {
					strMenu += children;
				}
			} else {
				if (parentId != null && parentId != '') {
					strMenu += '<tr data-id="' + v.rm_id + '" data-parent="' + v.rm_parent_id + '">';
						strMenu += '<td><i class="fas fa-angle-double-right"></i></td>';
						strMenu += '<td>' + v.rm_caption + '</td>';
						strMenu += '<td style="text-align:center;">';
							if(v.mag_id != '')
							{
								strMenu += '<input name="mag_id[]" type="hidden" value="'+v.mag_id+'">';
							}
							strMenu += '<input name="rm_id[]" type="checkbox" value="'+v.rm_id+'" '+v.checked+'>';
						strMenu += '</td >';
					strMenu += '</tr >';
				} else {
					strMenu += '<tr data-id="' + v.rm_id + '" data-parent="">';
						strMenu += '<td><i class="fas fa-angle-double-right"></i></td>';
						strMenu += '<td><b>' + v.rm_caption + '</b></td>'
						strMenu += '<td style="text-align:center;">';
							if(v.mag_id != '')
							{
								strMenu += '<input name="mag_id[]" type="hidden" value="'+v.mag_id+'">';
							}
						strMenu += '<input name="rm_id[]" type="checkbox" value="'+v.rm_id+'" '+v.checked+'>';
						strMenu += '</td >';
					strMenu += '</tr >';
				}
			}
		}
	});

	return strMenu;
};

function loadTreeMenuData(ug_id) 
{
	$.ajax({
		url: siteUrl('settings/menu_access_group/get_menu_data'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'get_menu_data',
			ug_id: ug_id,
		},
		success: function (result) {
			if (result.success) {
				$('.collaptable').find('tbody').html('');
				$('.collaptable').find('tbody').append('<input type="hidden" value="'+ug_id+'" name="ug_id">');
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
}

function loadData(data,callback) 
{
	var listGroup = $('#listGroup');

	listGroup.html('');

	for (var x in data) {
		var newData = data[x];

		listGroup.append('<a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#" aria-controls="profile" data-id="' + newData.ug_id + '">' + newData.ug_caption + '</a>');
	}
	callback();
}


$(document).ready(function() {
	$.ajax({
		url: siteUrl('settings/menu_access_group/get_user_group'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'get_user_group'
		},
		success: function (result) {
			if (result.success) {
				loadData(result.data, function() {
					$('#listGroup a').on('click', function (e) {
						e.preventDefault();
						$('#btnSave').attr('disabled', false);
						ug_id = $(this).attr('data-id');
						loadTreeMenuData(ug_id);
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

	$('#addAccessGroup').submit(function(e){
		e.preventDefault(); 

		$.ajax({
			url: siteUrl('settings/menu_access_group/store_data'),
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