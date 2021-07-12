/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/projects/material_consumption.js
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

function load_data_material(p_id,ps_id,years,month)
{
	$.ajax({
		url: siteUrl('projects/material_consumption/show_material'),
		type: 'POST',
		dataType: 'JSON',
		data: {
			action: 'show_material',
			p_id: p_id,
			ps_id: ps_id,
			years: years,
			month: month,
		},
		success: function (result) {
			if (result.success) {
				loadDataMaterial(result.data);
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
function popup_material_consumption(mode = 'add', title = 'Add', data = false)
{
	var date = new Date();
		p_id = $('#p-id').val();
		ps_id = $('#ps-id').val();
		years = date.getFullYear();
		month = date.getMonth() + 1;

	$.popup({
		title: title + ' Material Consumption',
		id: mode + 'MaterialConsPopup',
		size: 'medium',
		proxy: {
			url: siteUrl('projects/material_consumption/popup_material'),
			params: {
				action: 'popup_modal',
				mode: mode,
				id: data,
				p_id : p_id,
				ps_id : ps_id
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
						url: siteUrl('projects/material_consumption/store_data_material'),
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

							load_data_material(p_id,ps_id,years,month)

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
		listeners : {
			onshow : function(popup){
				
				// $('#dateOrder').inputmask('dd-mm-yyyy h:i:s', { 'placeholder': 'DD-MM-YYYY' });
				// $('#dateOrder').noobsdaterangepicker({
				// 	parentEl: "#" + popup[0].id + " .modal-body",
				// 	showDropdowns: true,
				// 	singleDatePicker: true,
				// 	locale: {
				// 		format: 'DD-MM-YYYY'
				// 	}
				// });

				$('.form_datetime').datetimepicker({
			        //language:  'fr',
			        weekStart: 1,
			        todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					forceParse: 0,
			        showMeridian: 1,
			        pickerPosition: "bottom-left"
			    });

				$('input.number').keyup(function(event) {
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

				$('#mc-quantity').keyup(function(event) {

				  	var price = $('#mc-price').val().replace(',','');
				   		qty = $('#mc-quantity').val().replace(',','');
				   		total = $('#mc-total').val(addCommas(qty * price));

				});

				$('#mc-price').keyup(function(event) {
				  	var price = $('#mc-price').val().replace(',','');
				   		qty = $('#mc-quantity').val().replace(',','');
				   		total = $('#mc-total').val(addCommas(qty * price));
				});
			}
		}
	});
}

function loadDataMaterial(data) 
{
	$('.material-consumption').find('tbody').html('');

	var listGroup = '';
	
	$.each(data, (k, v) => {
		listGroup += '<tr>';
		listGroup += '<td>'+ v.num+'</td>';
		listGroup += '<td>'+ v.p_name+'</td>';
		listGroup += '<td>'+ v.ps_name+'</td>';
		listGroup += '<td>'+ v.mc_date_order+'</td>';
		listGroup += '<td>'+ v.il_item_name+'</td>';
		listGroup += '<td>'+ addCommas(v.mc_price)+'</td>';
		listGroup += '<td>'+ addCommas(v.mc_quantity)+'</td>';
		listGroup += '<td>'+ v.un_name+'</td>';
		listGroup += '<td>'+ addCommas(v.mc_total)+'</td>';
		listGroup += '<td>';
				listGroup += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					listGroup += '<button type="button" class="btn btn-success" data-id="' + v.p_id + '" data-item="' + v.p_name + '" onclick="popup_projects(\'edit\', \'Edit\',' + v.p_id + ');"><i class="fas fa-edit"></i></button>';
					listGroup += '<button type="button" class="btn btn-danger" data-id="' + v.p_id + '" data-item="' + v.p_name + '" onclick="delete_data(' + v.p_id + ',\'\',\'projects\');"><i class="fas fa-trash-alt"></i></button>';
				listGroup += '</div>';
			listGroup += '</td>';
		listGroup += '</tr>';
	});
	
	$('.material-consumption').find('tbody').append(listGroup);

}

function load_projects_sub(data)
{
	$('.ps-id').html('');
	// $('.ps_id').find('option').append('');
	var listGroup = '<option value="">-Select-</option>';
	
	$.each(data, (k, v) => {
		listGroup += '<option value="'+v.ps_id+'">'+ v.ps_name+'</option>';
	});
	
	$('.ps-id').append(listGroup);
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
				url: siteUrl('projects/material_consumption/delete_data'),
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


	$('#p-id').on('change',function(){
		var p_id = $('#p-id').val();

		$.ajax({
			url: siteUrl('projects/material_consumption/get_projects_sub'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'get_sub_data',
				p_id : p_id
			},
			success: function (result) {
				if (result.success) {
					load_projects_sub(result.data);	
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

	$('#showMaterial').submit(function(e){
		e.preventDefault(); 

		$.ajax({
			url: siteUrl('projects/material_consumption/show_material'),
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
					loadDataMaterial(result.data);
					$('.btn-sub').css('display','block');

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