/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/master_data/driver.js
 */

$(document).ready(function() {
	var DRIVER = {
		gridDriver : $('#gridDriver').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('master_data/driver/get_data'),
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
					title: 'User Login', 
					data: 'ud_username',
				},
				{	
					title: 'Nama Lengkap', 
					data: 'd_name',
				},
				{	
					title: 'Alamat', 
					data: 'd_address',
				},
				{	
					title: 'Telp', 
					data: 'd_phone',
				},
				{	
					title: 'Email', 
					data: 'd_email',
				},
				{	
					title: 'Area', 
					data: 'rsd_name',
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
							icon: 'far fa-edit',
							click: function(row, rowData) {
								DRIVER.popup('edit', 'Edit', rowData);
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
											url: siteUrl('master_data/driver/delete_data'),
											type: 'POST',
											dataType: 'JSON',
											data: {
												action: 'delete_data',
												txt_id: rowData.d_id
											},
											success: function(result) {
												if (result.success) {
													toastr.success("Data succesfully deleted.");
												} else if (typeof(result.msg) !== 'undefined') {
													toastr.error(result.msg);
												} else {
													toastr.error(msgErr);
												}
												
												DRIVER.gridDriver.reloadData({
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
					DRIVER.popup('edit', 'Edit', rowData);
				}
			}
		}),
		popup: function(mode = 'add', title= 'Add', data = false)
		{
			$.popup({
				title: title + ' Driver',
				id: mode + 'DriverPopup',
				size: 'medium',
				proxy: {
					url: siteUrl('master_data/driver/load_driver_form'),
					params: {
						action: 'load_driver_form',
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
								url: siteUrl('master_data/driver/store_data'),
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

									DRIVER.gridDriver.reloadData({
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

						if (mode == 'edit') {
							DRIVER.generateRegion($('#txt_province').val(),data.rd_id);
							DRIVER.generateDistrict(data.rd_id,data.d_district_id);
						}

						$('#txt_province').change(function() {
							var me = $(this);
							// console.log(me.val())

								if (me.val() !== '') {
									
									driverList.generateRegion(me.val());

								} else {
									$('#txt_region').html($('<option>', {
										value: '',
										text: 'Pilih Provinsi'
									}));

									$('#txt_region').attr('disabled', true);
								}
								$('#txt_district').attr('disabled', true);
								$('#txt_district').html($('<option>', {
									value: '',
									text: '--Pilih Kabupaten / Kota--'
								}));
						});	

						$('#txt_region').change(function() {
							var me = $(this);
							// console.log(me)

								if (me.val() !== '') {
									
									driverList.generateDistrict(me.val());

								} else {
									$('#txt_district').html($('<option>', {
										value: '',
										text: 'Pilih Kabupaten/Kota'
									}));

									$('#txt_district').attr('disabled', true);
								}
						});
					}
				}
			});
		},
		generateRegion: function(provinceId, regionId = false) {
			var region = $('#txt_region');
				// console.log(provinceId)
				$.ajax({
					url: siteUrl('master_data/driver/get_region_option'),
					type: 'POST',
					dataType: 'JSON',
					beforeSend: function() {},
					complete: function() {},
					data: {
						action: 'get_region_option',
						prov_id: provinceId
					},
					success: function (result) {
						if (result.success) {
							var data = result.data;

							region.attr('disabled', false);

							region.html($('<option>', {
								value: '',
								text: '--Pilih Kabupaten / Kota--'
							}));
							
							data.forEach(function (newData) {
								region.append($('<option>', {
									value: newData.rd_id,
									text: newData.rd_name
								}));
							});

							if (regionId !== false) region.val(regionId);

						} else {

							region.html($('<option>', {
								value: '',
								text: 'Kabupaten tidak ditemukan!'
							}));
						}
					},
					error: function (error) {
						toastr.error(msgErr);
					}
				});
		},
		generateDistrict: function(regionId, districtId = false) {
			var district = $('#txt_district');
				
				$.ajax({
					url: siteUrl('master_data/driver/get_district_option'),
					type: 'POST',
					dataType: 'JSON',
					beforeSend: function() {},
					complete: function() {},
					data: {
						action: 'get_district_option',
						district_id: regionId
					},
					success: function (result) {
						if (result.success) {
							var data = result.data;

							district.attr('disabled', false);

							district.html($('<option>', {
								value: '',
								text: '--Pilih Kecamatan--'
							}));
							
							data.forEach(function (newData) {
								district.append($('<option>', {
									value: newData.rsd_id,
									text: newData.rsd_name
								}));
							});

							if (districtId !== false) district.val(districtId);

						} else {

							district.html($('<option>', {
								value: '',
								text: 'Kecamatan tidak ditemukan!'
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

		DRIVER.popup();
	});

	$('#txtName').noobsautocomplete({
		remote: true,
		placeholder: 'Find data.',
		proxy: {
			url: siteUrl('master_data/driver/get_autocomplete_data'),
			method: 'post',
			data: {
				action: 'get_autocomplete_data'
			},
		},
		listeners: {
			onselect: function(data) {
				DRIVER.gridDriver.reloadData({
					txt_id: $('#txtName').val()
				});
			},
			onclear: function(obj) {
				DRIVER.gridDriver.reloadData({});
			}
		}
	});
});