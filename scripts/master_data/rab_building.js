/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/master_data/rab_building.js
 */
function addCommas(nStr) //format number
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function sum_rab(id,vol)
{
	var measure = $('#measure'+id).val();
		sum_total = measure * vol;
		$('#sum'+id).val(addCommas(sum_total));
}

const _generate_rab_data = (data) => {
	let strRabData = '';


	$.each(data, (k, v) => {
		var meas = addCommas(v.measure);
		var summ = addCommas(v.summary);
		if(v.rb_id !== "")
		{
			mode = 'edit';
		}
		else
		{
			mode = "add"
		}
		strRabData += '<tr>';
			strRabData += '<td><b>' + v.work + '</b></td>'
			strRabData += '<td><b>' + v.unit_rab + '</b></td>'
			strRabData += '<td><b>' + v.material + '</b></td>'
			strRabData += '<td><b>' + v.volume + '</b></td>'
			strRabData += '<td><b>' + v.unit_item + '</b></td>'
			strRabData += '<td><input type="text" width="50px" class="form-control" value="'+ meas +'" name="measure[]" id="measure'+v.id+'" onchange="sum_rab('+v.id+','+v.volume+')"></td>';
			strRabData += '<td><input type="text" readOnly width="50px" class="form-control" value="'+ summ +'" name="summary[]" id="sum'+v.id+'"></td>';
			strRabData += '<input type="hidden" value="'+ v.id +'" name="rl_id[]">';
			strRabData += '<input type="hidden" value="'+ v.rb_id +'" name="rb_id[]">';
			strRabData += '<input type="hidden" value="'+ v.rl_il_id +'" name="rl_il_id[]">';
			// strRabData += '<input type="hidden" value="'+ bt_id +'" name="bt_id[]">';
			strRabData += '<input type="hidden" value="'+ mode +'" name="mode[]">';
		strRabData += '</tr>';

		// var measure = $('measure'+v.id).val();
		// sum_total = v.measure * v.volume;
		// $('measure'+v.id).on('keydown',function(){
		// 	$('sum'+v.id).val(sum_total);
		// });
		// console.log(sum_total)
	});

	$('.rab-table').find('tbody').append(strRabData);
};

function loadDataRab(bt_id) 
{
	$.ajax({
		url: siteUrl('master_data/rab_building/get_rab_data'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'get_rab_data',
			bt_id: bt_id,
		},
		success: function (result) {
			if (result.success) {
				$('.rab-table').find('tbody').html('');
				$('.rab-table').find('tbody').append('<input type="hidden" value="'+bt_id+'" name="bt_id">');
				_generate_rab_data(result.data);
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

		listGroup.append('<a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#" aria-controls="profile" data-id="' + newData.bt_id + '">' + newData.bt_building_type + '</a>');
	}
	callback();
}


$(document).ready(function() {
	$.ajax({
		url: siteUrl('master_data/rab_building/get_data'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'get_data'
		},
		success: function (result) {
			if (result.success) {
				loadData(result.data, function() {
					$('#listGroup a').on('click', function (e) {
						e.preventDefault();
						$('#btnSave').attr('disabled', false);
						bt_id = $(this).attr('data-id');
						loadDataRab(bt_id);
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

	$('#addRabBuilding').submit(function(e){
		e.preventDefault(); 

		$.ajax({
			url: siteUrl('master_data/rab_building/store_data'),
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
					loadDataRab(result.id);

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