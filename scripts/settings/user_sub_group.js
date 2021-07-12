/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/settings/user.js
 */

$(document).ready(function() {
	var USER_SUB_GROUP = {
		gridUserSubGroup : $('#gridUserSubGroup').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('settings/user_sub_group/get_data'),
				method: 'post',
				data: {
					action: 'get_data'
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
					title: 'Group', 
					data: 'ug_caption',
				},
				{	
					title: 'Sub Group', 
					data: 'usg_caption',
				},
				{	
					title: 'Description', 
					data: 'usg_description',
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
							text: 'Edit',
							class: 'btn-success',
							id: 'btnEdit',
							icon: 'far fa-edit',
							click: function(row, rowData) {
								USER_SUB_GROUP.popup('edit', 'Edit', rowData);
							}
						},
						{
							text: 'Delete',
							class: 'btn-danger',
							id: 'btnDelete',
							icon: 'far fa-trash-alt',
							click: function(row, rowData) {
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
											url: siteUrl('settings/user_sub_group/delete_data'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'delete_data',
												usg_id: rowData.usg_id
											},
											success: function(result) {
												if (result.success) {
													toastr.success("Data succesfully deleted.");
												} else if (typeof(result.msg) !== 'undefined') {
													toastr.error(result.msg);
												} else {
													toastr.error(msgErr);
												}
												
												USER_SUB_GROUP.gridUserSubGroup.reloadData({
													txt_id: $('#txtName').val()
												});
											},
											error: function(error) {
												toastr.error(msgErr);
											}
										});
									}
								});
							}
						},
					],
				}
			],
			listeners: {
				ondblclick: function(row, rowData, idx) {
					USER_SUB_GROUP.popup('edit', 'Edit', rowData);
				}
			}
		}),
		popup: function(mode = 'add', title= 'Add', data = false)
		{
			$.popup({
				title: title + ' Sub Group',
				id: mode + 'UserPopup',
				size: 'medium',
				proxy: {
					url: siteUrl('settings/user_sub_group/popup_modal'),
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
					btnIcon: 'far fa-check-circle',
					onclick: function(popup) {
						var form  = popup.find('form');
						if ($.validation(form)) {
							var formData = new FormData(form[0]);
							$.ajax({
								url: siteUrl('settings/user_sub_group/store_data'),
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

									USER_SUB_GROUP.gridUserSubGroup.reloadData({
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
						$('#userBirthday').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' });
						$('#userBirthday').daterangepicker({
							parentEl: "#" + popup[0].id + " .modal-body",
							showDropdowns: true,
							singleDatePicker: true,
							locale: {
								format: 'DD-MM-YYYY'
							}
						});
					}
				}
			});
		}
	};

	$('#btnAdd').click(function(e) {
		e.preventDefault();

		USER_SUB_GROUP.popup();
	});

	$('#txtName').noobsautocomplete({
		remote: true,
		placeholder: 'Find data.',
		proxy: {
			url: siteUrl('settings/user_sub_group/get_autocomplete_data'),
			method: 'post',
			data: {
				action: 'get_autocomplete_data'
			},
		},
		listeners: {
			onselect: function(data) {
				USER_SUB_GROUP.gridUserSubGroup.reloadData({
					txt_id: $('#txtName').val()
				});
			},
			onclear: function(obj) {
				USER_SUB_GROUP.gridUserSubGroup.reloadData({});
			}
		}
	});
});