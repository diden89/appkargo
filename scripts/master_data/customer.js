/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/settings/customer.js
 */

$(document).ready(function() {
	var CUSTOMER = {
		gridCustomer : $('#gridCustomer').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('master_data/customer/load_data_customer'),
				method: 'post',
				data: {
					action: 'load_data_customer'
				},
			},
			columns: [
				{
					title: 'No', 
					data: 'num',
					searchable: false,
					orderable: false,
					css: {
						'text-align': 'center'
					},
					width: 10
				},
				{	
					title: 'Nama Pelanggan', 
					data: 'c_name',
				},
				{	
					title: 'Alamat', 
					data: 'c_address',
				},
				{	
					title: 'No Telp', 
					data: 'c_phone',
				},
				{	
					title: 'Email', 
					data: 'c_email',
				},
				{	
					title: 'Area', 
					data: 'rsd_name',
				},
				{	
					title: 'Ongkir Area', 
					data: 'c_shipping_area',
				},
				{	
					title: 'Jarak Dari Gudang', 
					data: 'c_distance_area',
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
							text: '',
							class: 'btn-success',
							id: 'btnEdit',
							icon: 'fas fa-edit',
							click: function(row, rowData) {
								// console.log(rowData)
								CUSTOMER.popup('edit', 'Edit', rowData);
							}
						},
						{
							text: '',
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
											url: siteUrl('settings/user/delete_data'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'delete_data',
												ud_id: rowData.ud_id
											},
											success: function(result) {
												if (result.success) {
													toastr.success("Data succesfully deleted.");
												} else if (typeof(result.msg) !== 'undefined') {
													toastr.error(result.msg);
												} else {
													toastr.error(msgErr);
												}
												
												CUSTOMER.gridCUSTOMER.reloadData({
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
					CUSTOMER.popup('edit', 'Edit', rowData);
				}
			}
		}),
		popup: function(mode = 'add', title= 'Add', data = false)
		{
			$.popup({
				title: title + ' Pelanggan',
				id: mode + 'CustomerPopup',
				size: 'medium',
				proxy: {
					url: siteUrl('master_data/customer/load_customer_form'),
					params: {
						action: 'load_customer_form',
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
								url: siteUrl('settings/user/store_data'),
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

									CUSTOMER.gridCUSTOMER.reloadData({
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
						$('#userBirthday').noobsdaterangepicker({
							parentEl: "#" + popup[0].id + " .modal-body",
							showDropdowns: true,
							singleDatePicker: true,
							locale: {
								format: 'DD-MM-YYYY'
							}
						});

						if (mode == 'edit') {
							CUSTOMER.generateUserSubGroup($('#userGroup').val(), data.ud_sub_group);
						}

						$('#userGroup').change(function() {
							var me = $(this);

							if (me.val() !== '') {
								
								CUSTOMER.generateUserSubGroup(me.val());

							} else {
								$('#userSubGroup').html($('<option>', {
									value: '',
									text: 'Select Sub Group First'
								}));

								$('#userSubGroup').attr('disabled', true);
							}
						});

						$('#fileAvatar').change(function(a){
							var $this = $(this);
							var $next = $this.next();

							$next.html($this[0].files[0].name);
						});
					}
				}
			});
		},
		generateUserSubGroup: function(groupId, subGroupId = false) {
			var userSubGroup = $('#userSubGroup');
			
			$.ajax({
				url: siteUrl('settings/user/get_user_sub_group'),
				type: 'POST',
				dataType: 'JSON',
				beforeSend: function() {},
				complete: function() {},
				data: {
					action: 'get_user_sub_group',
					usg_group: groupId
				},
				success: function (result) {
					if (result.success) {
						var data = result.data;

						userSubGroup.attr('disabled', false);

						userSubGroup.html('');
						
						data.forEach(function (newData) {
							userSubGroup.append($('<option>', {
								value: newData.usg_id,
								text: newData.usg_caption
							}));
						});

						if (subGroupId !== false) userSubGroup.val(subGroupId);

					} else {

						userSubGroup.html($('<option>', {
							value: '',
							text: 'Sub Group Not Found!'
						}));
					}
				},
				error: function (error) {
					toastr.error(msgErr);
				}
			});
		}
	};

	$('#btnAdd').click(function(e) {
		e.preventDefault();

		CUSTOMER.popup();
	});

	$('#txtName').noobsautocomplete({
		remote: true,
		placeholder: 'Find data.',
		proxy: {
			url: siteUrl('master_data/customer/get_autocomplete_data'),
			method: 'post',
			data: {
				action: 'get_autocomplete_data'
			},
		},
		listeners: {
			onselect: function(data) {
				CUSTOMER.gridCustomer.reloadData({
					txt_id: $('#txtName').val()
				});
			},
			onclear: function(obj) {
				CUSTOMER.gridCustomer.reloadData({});
			}
		}
	});
});