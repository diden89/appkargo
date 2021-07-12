/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/trademark/similar_words.js
 */

$(document).ready(function() {
	SIMILAR_WORDS = {
		dataTableSimilarWords: [],
		selectedWordId: '',
		selectedSimilarWord: '',
		getData: function(selectID = false) {

			SIMILAR_WORDS.dataTableSimilarWords = [];
			SIMILAR_WORDS.selectedWordId = '';
			SIMILAR_WORDS.selectedSimilarWord = '';

			$('#similarWordsDataTable tbody').html('');

			$.ajax({
				url: siteUrl('trademark/similar_words/get_data'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'get_data',
					txt_word: $('#txtWord').val()
				},
				success: function(result) {
					if (result.success) {
						var data = result.data;

						SIMILAR_WORDS.loadData(data, function() {
							$('#listWord a').on('click', function (e) {
								e.preventDefault();

								$('#txtSImilarWord').val('');
								$('#txtSImilarWord').attr('disabled', false);

								SIMILAR_WORDS.selectedWordId = $(this).attr('data-id');
								SIMILAR_WORDS.selectedSimilarWord = $(this).attr('data-similiar-word');

								SIMILAR_WORDS.loadSimilarWord();

								SIMILAR_WORDS.initAutoComplete();

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

				listWord.append('<a class="list-group-item list-group-item-action" id="list-profile-list-' + newData.sw_id + '" data-toggle="list" href="#" aria-controls="profile" data-id="' + newData.sw_id + '" data-similiar-word="' + newData.sw_similar_word + '">' + newData.sw_word + '</a>');
			}

			callback();
		},
		loadSimilarWord: function() {
			$.ajax({
				url: siteUrl('trademark/similar_words/get_data_similar_word'),
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'get_data_similar_word',
					txt_similar_word: SIMILAR_WORDS.selectedSimilarWord,
					txt_search_word: $('#txtSImilarWord').val()
				},
				success: function(result) {
					if (result.success) {
						var data = result.data;

						SIMILAR_WORDS.dataTableSimilarWords = data;
						
						SIMILAR_WORDS.loadTableDictionary();
					} else if (typeof(result.msg) !== 'undefined') {

						SIMILAR_WORDS.dataTableSimilarWords = [];
						SIMILAR_WORDS.loadTableDictionary();
						
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
			var similarWordsDataTableBody = $('#similarWordsDataTable tbody');
			
			similarWordsDataTableBody.html('');

			var html = '';
			var no = 1;

			if (SIMILAR_WORDS.dataTableSimilarWords.length > 0) {
				for (var x in SIMILAR_WORDS.dataTableSimilarWords) {
					var newData = SIMILAR_WORDS.dataTableSimilarWords[x];
					var tr = $('<tr/>');

					tr.html(`
						<td>` + no + `</td>
						<td>` + newData.sw_word + `</td>
						<td>
							<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
								<button type="button" class="btn btn-success btn-edit"><i class="far fa-edit"></i></button>
								<button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
							</div>
						</td>
					`);

					no++;

					similarWordsDataTableBody.append(tr);
				}

				$('.btn-delete').each(function(idx, obj) {
					var btnDelete = $(obj);

					btnDelete.click(function(e) {
						SIMILAR_WORDS.deleteData(SIMILAR_WORDS.dataTableSimilarWords[idx]);
					});
				});

				$('.btn-edit').each(function(idx, obj) {
					var btnEdit = $(obj);

					btnEdit.click(function(e) {
						SIMILAR_WORDS.popup('edit', 'Edit', SIMILAR_WORDS.dataTableSimilarWords[idx]);
					});
				});
			}
			else {
				similarWordsDataTableBody.html(`
					<tr><td colspan="3">Data Not Found!</td></tr>
				`);
			}
		},
		storeData: function(mode, txtNewSimilarWordId = '') {
			if (SIMILAR_WORDS.selectedWordId == '') {
				toastr.error('Select word first to add similar word!');
			} else {
				$.ajax({
					url: siteUrl('trademark/similar_words/store_data'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'store_data',
						mode: mode,
						txt_sw_id: SIMILAR_WORDS.selectedWordId,
						txt_new_similar_worsw_id: txtNewSimilarWordId,
						txt_new_word: $('#txtNewWord').val(),
						txt_sw_similar_word: SIMILAR_WORDS.selectedSimilarWord
					},
					success: function(result) {
						if (result.success) {
							toastr.success(msgSaveOk);
							SIMILAR_WORDS.getData(SIMILAR_WORDS.selectedWordId);
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
				placeholder: 'Find word to add in similar_words.',
				proxy: {
					url: siteUrl('trademark/similar_words/get_autocomplete_data'),
					method: 'post',
					data: {
						action: 'get_autocomplete_data',
						txt_sw_id: SIMILAR_WORDS.selectedWordId,
						txt_sw_similar_word: SIMILAR_WORDS.selectedSimilarWord
					},
				},
				listeners: {
					onselect: function(data) {
						SIMILAR_WORDS.storeData('edit', data.id);
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
					url: siteUrl('trademark/similar_words/popup_modal'),
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
								url: siteUrl('trademark/similar_words/edit_data'),
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

									SIMILAR_WORDS.getData(SIMILAR_WORDS.selectedWordId);
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
						url: siteUrl('trademark/similar_words/delete_data'),
						type: 'POST',
						dataType: 'JSON',
						data: {
							action: 'delete_data',
							sw_id: data.sw_id,
							sw_similar_word: data.sw_similar_word
						},
						success: function(result) {
							if (result.success) {
								toastr.success("Data succesfully deleted.");
								SIMILAR_WORDS.getData(SIMILAR_WORDS.selectedWordId);
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

	SIMILAR_WORDS.getData();

	$('#txtWordAddFromData').noobsautocomplete();

	$('#btnSearch').click(function(e) {
		e.preventDefault();

		SIMILAR_WORDS.getData();
	});

	$('#txtWord').keydown(function(e) {
    	var keyCode = (e.keyCode ? e.keyCode : e.which);
	    if (keyCode == 13) {
	        $('#btnSearch').trigger('click');
	    }
	});

	$('#btnAddNewWord').click(function(e) {
		e.preventDefault();

		SIMILAR_WORDS.storeData('add');
	});

	$('#btnSearchSimilarWord').click(function(e) {
		e.preventDefault();

		SIMILAR_WORDS.loadSimilarWord();
	});
});