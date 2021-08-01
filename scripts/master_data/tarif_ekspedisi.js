/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/master_data/tarif_ekspedisi.js
 */

const _generate_shipping = (data) => {
	let dataShipping = _generate_shipping_cost(data);

	// $('.collaptable').find('tbody').html('');
	$('.collaptable').find('tbody').append(dataShipping);
};

const _generate_shipping_cost = (datas) => {
	let strMenu = '';

	$.each(datas, (k, v) => {
		if(v.sh_cost == false) {
			cost = '';
		}
		else {
			cost = v.sh_cost;
		}
		strMenu += '<tr data-id="' + v.rsd_id + '">';
			strMenu += '<td></td>';
			strMenu += '<td><b>' + v.rsd_name.toUpperCase() + '</b></td>'
			strMenu += '<td style="text-align:center;">';
				if(v.sh_id != '')
				{
					strMenu += '<input name="sh_id[]" type="hidden" value="'+v.sh_id+'">';
				}

				strMenu += '<input name="sh_cost[]" type="text" class="form-control" value="'+cost+'">';
				strMenu += '<input name="rsd_id[]" type="hidden" class="form-control" value="'+v.rsd_id+'">';
			strMenu += '</td >';
		strMenu += '</tr>';

	});

	return strMenu;
};

function loadTarifKecData(rd_id) 
{
	$.ajax({
		url: siteUrl('master_data/tarif_ekspedisi/get_kec_data'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'get_kec_data',
			rd_id: rd_id
		},
		success: function (result) {
			if (result.success) {
				$('.collaptable').find('tbody').html('');
				$('.collaptable').find('tbody').append('<input type="hidden" value="'+rd_id+'" name="rd_id">');
				// $('.collaptable').find('tbody').append('<input type="hidden" value="'+rsd_id+'" name="rsd_id[]">');
				_generate_shipping(result.data);
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
	if(data != undefined)
	{
		for (var x in data) {
			var newData = data[x];

			listGroup.append('<a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#" aria-controls="profile" data-rd_id="' + newData.rd_id + '">' + newData.rd_name + '</a>');
		}		
	}
	else
	{
		listGroup.html('<p class="text-muted">Kab / Kota Tidak Ditemukan!!</p>');
	}
	callback();
}


$(document).ready(function() {
	$.ajax({
		url: siteUrl('master_data/tarif_ekspedisi/get_provinsi'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'get_provinsi'
		},
		success: function (result) {
			if (result.success) {
				$('#txt_provinsi_id').append(result.data);

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
	$('#txt_provinsi_id').on('change',function(e){
		var sel = $('#txt_provinsi_id').val();	

		$('.collaptable').find('tbody').html('');
		$('#btnSave').attr('disabled', true);

		$.ajax({
			url: siteUrl('master_data/tarif_ekspedisi/get_district'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'get_district',
				rp_id : sel
			},
			success: function (result) {
				if (result.success) {
					loadData(result.data, function() {
						$('#listGroup a').on('click', function (e) {
							e.preventDefault();
							$('#btnSave').attr('disabled', false);
							rd_id = $(this).attr('data-rd_id');
							loadTarifKecData(rd_id);
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
	});
	$('#addDataTable').submit(function(e){
		e.preventDefault(); 

		$.ajax({
			url: siteUrl('master_data/tarif_ekspedisi/store_data'),
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
					loadTarifKecData(result.rd_id);

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