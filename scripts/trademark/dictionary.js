/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/trademark/dictionary.js
 */

$(document).ready(function() {
	DICTIONARY = {
		dataTableDictionary: [],
		selectedWordId: '',
		selectedSimilarWord: '',
		getData: function(selectID = false) {

			DICTIONARY.dataTableDictionary = [];
			DICTIONARY.selectedWordId = '';
			DICTIONARY.selectedSimilarWord = '';

			$('#dictionaryDataTable tbody').html('');

			$.ajax({
				url: siteUrl('trademark/dictionary/get_data'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'get_data',
					txt_word: $('#txtWord').val()
				},
				success: function(result) {
					if (result.success) {
						var data = result.data;

						DICTIONARY.loadData(data, function() {
							$('#listWord a').on('click', function (e) {
								e.preventDefault();

								DICTIONARY.selectedWordId = $(this).attr('data-id');
								DICTIONARY.selectedSimilarWord = $(this).attr('data-similiar-word');

								DICTIONARY.loadSimilarWord();

								DICTIONARY.initAutoComplete();

								$('#txtWordAddFromData').attr('disabled', false);
							});

							if (selectID !== false) {
								var wordSelected = $('#listWord').find("[data-id= '" + selectID + "']");

								wordSelected.trigger('click');
							}
						});
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
		},
		loadData: function(data, callback) {
			var listWord = $('#listWord');

			listWord.html('');

			for (var x in data) {
				var newData = data[x];

				listWord.append('<a class="list-group-item list-group-item-action" id="list-profile-list-' + newData.d_id + '" data-toggle="list" href="#" aria-controls="profile" data-id="' + newData.d_id + '" data-similiar-word="' + newData.d_similar_word + '">' + newData.d_word + '</a>');
			}

			callback();
		},
		loadSimilarWord: function() {
			$.ajax({
				url: siteUrl('trademark/dictionary/get_data_similar_word'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'get_data_similar_word',
					txt_similar_word: DICTIONARY.selectedSimilarWord
				},
				success: function(result) {
					if (result.success) {
						var data = result.data;

						DICTIONARY.dataTableDictionary = data;
						
						DICTIONARY.loadTableDictionary();
					} else if (typeof(result.msg) !== 'undefined') {

						DICTIONARY.dataTableDictionary = [];
						DICTIONARY.loadTableDictionary();
						
						toastr.error(result.msg);
					} else {
						toastr.error(msgErr);
					}
				},
				error: function(error) {
					toastr.error(msgErr);
				}
			});
		},
		loadTableDictionary: function() {
			var dictionaryDataTableBody = $('#dictionaryDataTable tbody');
			
			dictionaryDataTableBody.html('');

			var html = '';
			var no = 1;

			if (DICTIONARY.dataTableDictionary.length > 0) {
				for (var x in DICTIONARY.dataTableDictionary) {
					var newData = DICTIONARY.dataTableDictionary[x];
					var tr = $('<tr/>');

					tr.html(`
						<td>` + no + `</td>
						<td>` + newData.d_word + `</td>
						<td>
							<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
								<button type="button" class="btn btn-success btn-edit"><i class="far fa-edit"></i></button>
								<button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
							</div>
						</td>
					`);

					no++;

					dictionaryDataTableBody.append(tr);
				}

				$('.btn-delete').each(function(idx, obj) {
					var btnDelete = $(obj);

					btnDelete.click(function(e) {
						DICTIONARY.deleteData(DICTIONARY.dataTableDictionary[idx]);
					});
				});

				$('.btn-edit').each(function(idx, obj) {
					var btnEdit = $(obj);

					btnEdit.click(function(e) {
						DICTIONARY.popup('edit', 'Edit', DICTIONARY.dataTableDictionary[idx]);
					});
				});
			}
			else {
				dictionaryDataTableBody.html(`
					<tr><td colspan="3">Data Not Found!</td></tr>
				`);
			}
		},
		storeData: function(mode, txtNewSimilarWordId = '') {
			if (DICTIONARY.selectedWordId == '') {
				toastr.error('Select word first to add similar word!');
			} else {
				$.ajax({
					url: siteUrl('trademark/dictionary/store_data'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'store_data',
						mode: mode,
						txt_d_id: DICTIONARY.selectedWordId,
						txt_new_similar_word_id: txtNewSimilarWordId,
						txt_new_word: $('#txtNewWord').val(),
						txt_d_similar_word: DICTIONARY.selectedSimilarWord
					},
					success: function(result) {
						if (result.success) {
							toastr.success(msgSaveOk);
							DICTIONARY.getData(DICTIONARY.selectedWordId);
							$('#txtNewWord').val('');
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
		},
		initAutoComplete: function() {
			$('#txtWordAddFromData').noobsautocomplete({
				remote: true,
				placeholder: 'Find word to add in dictionary.',
				proxy: {
					url: siteUrl('trademark/dictionary/get_autocomplete_data'),
					method: 'post',
					data: {
						action: 'get_autocomplete_data',
						txt_d_id: DICTIONARY.selectedWordId,
						txt_d_similar_word: DICTIONARY.selectedSimilarWord
					},
				},
				listeners: {
					onselect: function(data) {
						DICTIONARY.storeData('edit', data.id);
					}
				}
			});
		},
		popup: function(mode = 'add', title = 'Add', data = false) {
			$.popup({
				title: title + ' Word',
				id: mode + 'Word',
				size: 'small',
				proxy: {
					url: siteUrl('trademark/dictionary/popup_modal'),
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
								url: siteUrl('trademark/dictionary/edit_data'),
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

									popup.close();

									DICTIONARY.getData(DICTIONARY.selectedWordId);
								},
								error: function(error) {
									toastr.error(msgErr);
									popup.close();
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
				listeners: {
				}
			});
		},
		deleteData: function(data) {
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
						url: siteUrl('trademark/dictionary/delete_data'),
						type: 'POST',
						dataType: 'JSON',
						data: {
							action: 'delete_data',
							d_id: data.d_id,
							d_similar_word: data.d_similar_word
						},
						success: function(result) {
							if (result.success) {
								toastr.success("Data succesfully deleted.");
								DICTIONARY.getData(DICTIONARY.selectedWordId);
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
	};

	$('#txtWordAddFromData').noobsautocomplete();

	$('#btnSearch').click(function(e) {
		e.preventDefault();

		DICTIONARY.getData();
	});

	$('#txtWord').keydown(function(e) {
    	var keyCode = (e.keyCode ? e.keyCode : e.which);
	    if (keyCode == 13) {
	        $('#btnSearch').trigger('click');
	    }
	});

	$('#btnAddNewWord').click(function(e) {
		e.preventDefault();

		DICTIONARY.storeData('add');
	});
});