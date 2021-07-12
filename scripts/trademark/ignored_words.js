/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/trademark/similar_letters.js
 */

const similarWords = {
	selectedWord: '',
	init: function() {
		const me = this;

		$('#btnSearchWord').click(function(e) {
			e.preventDefault();
			me.loadDataWord(this);
		});

		$('#txtWord').keydown(function(e) {
			const keyCode = (e.keyCode ? e.keyCode : e.which);

			if (keyCode == 13) {
				$('#btnSearchWord').trigger('click');
			}
		});

		$('#btnAddWord').click(function(e) {
			e.preventDefault();
			me.showWord(this);
		});
	},
	loadDataWord: function(el) {
		const me = this;
		const $this = $(el);

		$.ajax({
			url: siteUrl('trademark/ignored_words/load_data_word'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load_data_word',
				txt_word: $('#txtWord').val()
			},
			success: function(result) {
				$('#ignoredWordsDataTable tbody').html('');

				if (result.success !== false) me._generateWordDataTable(result.data);
				else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
				else toastr.error(msgErr);
			},
			error: function(error) {
				toastr.error(msgErr);
			}
		});
	},
	_generateWordDataTable: (data) => {
		const $this = $('#ignoredWordsDataTable tbody');

		$this.html('');

		let body = '';

		$.each(data, (idx, item) => {
			body += '<tr>';
			body += '<td>' + item.no + '</td>';
			body += '<td>' + item.words + '</td>';
			body += '<td>';
				body += '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">';
					body += '<button type="button" class="btn btn-success" data-id="' + item.id + '" data-words="' + item.words + '" onclick="similarWords.showWord(this, \'edit\');"><i class="fas fa-edit"></i></button>';
					body += '<button type="button" class="btn btn-danger" data-id="' + item.id + '" data-words="' + item.words + '" onclick="similarWords.deleteDataWord(this);"><i class="fas fa-trash-alt"></i></button>';
				body += '</div>';
			body += '</td>';
			body += '</tr>';
		});

		$this.html(body);
	},
	showWord: function(el, mode) {
		const me = this;
		let params = {action: 'load_word_form'};
		let title = 'Add new';

		if (typeof(mode) !== 'undefined') {
			params.mode = mode;
			title = 'Edit';
			params.txt_word = $(el).data('words');
			params.txt_id = $(el).data('id');
		}

		$.popup({
			title: title + ' Words',
			id: 'showWord',
			size: 'small',
			proxy: {
				url: siteUrl('trademark/ignored_words/load_word_form'),
				params: params
			},
			buttons: [{
				btnId: 'saveData',
				btnText:'Save',
				btnClass: 'info',
				btnIcon: 'far fa-check-circle',
				onclick: function(popup) {
					const form  = popup.find('form');

					if ($.validation(form)) {
						const formData = new FormData(form[0]);

						$.ajax({
							url: siteUrl('trademark/ignored_words/store_data_word'),
							type: 'POST',
							dataType: 'JSON',
							data: formData,
							processData: false,
							contentType: false,
	         				cache: false,
							success: function(result) {
								if (result.success) {
									toastr.success(msgSaveOk);
									me._generateWordDataTable(result.data);
								} else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
								else toastr.error(msgErr);

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
			}]
		});
	},
	deleteDataWord: function(el) {
		const me = this;
		const $this = $(el);

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
					url: siteUrl('trademark/ignored_words/delete_data_word'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data_word',
						txt_id: $this.data('id')
					},
					success: function(result) {
						$('#ignoredWordsDataTable tbody').html('');
						
						if (result.success) me._generateWordDataTable(result.data);
						else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
						else toastr.error(msgErr);
					},
					error: function(error) {
						toastr.error(msgErr);
					}
				});
			}
		});
	}
};

$(document).ready(function() {
	similarWords.init();
});