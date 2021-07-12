/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @path /rab_frontend/scripts/trademark/similar_letters.js
 */

const similarLetters = {
	selectedLetter: '',
	gridSimilarLetter: {},
	init: function() {
		const me = this;

		$('#btnSearchLetter').click(function(e) {
			me._resetSimilarLetter();
			me.gridLetter.reloadData({
				txt_letter: $('#txtLetter').val()
			});
		});

		$('#txtLetter').keydown(function(e) {
			const keyCode = (e.keyCode ? e.keyCode : e.which);

			if (keyCode == 13) {
				$('#btnSearchLetter').trigger('click');
			}
		});

		$('#btnAddLetter').click(function(e) {
			me.showLetter();
		});
	},
	gridLetter: $('#gridLetter').grid({
		serverSide: true,
		striped: true,
		proxy: {
			url: siteUrl('trademark/similar_letters/load_data_letter'),
			method: 'post',
			data: {action: 'load_data_letter'}
		},
		columns: [{
			title: 'No', 
			data: 'no',
			searchable: false,
			orderable: false,
			css: {'text-align': 'right'},
			width: 25
		}, {	
			title: 'Letters and/or Numbers', 
			data: 'letter',
		}, {
			title: 'Action',
			size: 'medium',
			type: 'buttons',
			group: true,
			css: {
				'text-align': 'center',
				'width': '100px'
			},
			content: [{
				text: '',
				class: 'btn-warning',
				id: 'btnShowSimilarLetter',
				icon: 'far fa-eye',
				click: function(el, data) {
					similarLetters.showSimilarLetterTable(el, data);
				}
			}, {
				text: '',
				class: 'btn-success',
				id: 'btnEditLetter',
				icon: 'far fa-edit',
				click: function(el, data) {
					similarLetters.showLetter(data, 'edit');
				}
			}, {
				text: '',
				class: 'btn-danger',
				id: 'btnDeleteLetter',
				icon: 'far fa-trash-alt',
				click: function(el, data) {
					similarLetters.deleteLetter(data);
				}
			}]
		}]
	}),
	showLetter: function(data, mode) {
		const me = this;
		let params = {action: 'load_letter_form'};
		let title = 'Add new';

		if (typeof(mode) !== 'undefined') {
			params.mode = mode;
			title = 'Edit';
			params.txt_letter = data.letter;
			params.txt_id = data.id;
		}

		$.popup({
			title: title + ' letter',
			id: 'showLetter',
			size: 'small',
			proxy: {
				url: siteUrl('trademark/similar_letters/load_letter_form'),
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
							url: siteUrl('trademark/similar_letters/store_data_letter'),
							type: 'POST',
							dataType: 'JSON',
							data: formData,
							processData: false,
							contentType: false,
	         				cache: false,
							success: function(result) {
								if (result.success) {
									toastr.success(msgSaveOk);
									me._resetSimilarLetter();
									me.gridLetter.reloadData({txt_letter: ''});
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
			}],
			listeners: {
				onshow: function() {
					$('#formLetter').submit(function(e) {
						e.preventDefault();
					});
				}
			}
		});
	},
	deleteLetter: function(data) {
		const me = this;

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
					url: siteUrl('trademark/similar_letters/delete_data_letter'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data_letter',
						txt_id: data.id
					},
					success: function(result) {
						if (result.success) {
							me._resetSimilarLetter();
							me.gridLetter.reloadData({txt_letter: ''});
						}
						else if (typeof(result.msg) !== 'undefined') toastr.error(result.msg);
						else toastr.error(msgErr);
					},
					error: function(error) {
						toastr.error(msgErr);
					}
				});
			}
		});
	},
	_resetSimilarLetter: () => {
		$('#txtSimilarLetter, #btnSearchSimilarLetter, #btnAddSimilarLetter').prop('disabled', true);
		$('.div-left').css('display', 'none');
		$('.div-left h4').html('');
	},
	showSimilarLetterTable: function(el, data) {
		const me = this;
		const $this = $(el);

		$('#gridLetter tbody tr').each(function() {
			if (this == $this.closest('tr')[0]) {
				$(this).find('td').each(function(idx, el){
					$(this).addClass('bg-primary');
				});
			} else {
				$(this).find('td').each(function(idx, el){
					$(this).removeClass('bg-primary');
				});
			}
		});

		me.selectedLetter = data.letter;
		me.selectedLetterId = data.id;

		$('#txtSimilarLetter, #btnSearchSimilarLetter, #btnAddSimilarLetter').prop('disabled', false);
		$('.div-left').css('display', 'block');
		$('.div-left h4').html('Similar Letters and/or Numbers for "' + me.selectedLetter + '"');

		$('#btnAddSimilarLetter').click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			e.stopImmediatePropagation();
			me.showSimilarLetter(this);
		});

		$('#btnSearchSimilarLetter').click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			e.stopImmediatePropagation();
			me.gridSimilarLetter.reloadData({
				txt_id_letter: me.selectedLetterId,
				txt_letter: $('#txtSimilarLetter').val()
			});
		});

		$('#txtSimilarLetter').keydown(function(e) {
			const keyCode = (e.keyCode ? e.keyCode : e.which);

			if (keyCode == 13) {
				$('#btnSearchSimilarLetter').trigger('click');
			}
		});

		me.gridSimilarLetter = $('#gridSimilarLetter').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('trademark/similar_letters/load_data_similar_letter'),
				method: 'post',
				data: {
					action: 'load_data_similar_letter',
					txt_id_letter: me.selectedLetterId
				}
			},
			columns: [{
				title: 'No', 
				data: 'no',
				searchable: false,
				orderable: false,
				css: {'text-align': 'right'},
				width: 25
			}, {	
				title: 'Letters and/or Numbers', 
				data: 'letter',
			}, {
				title: 'Action',
				size: 'medium',
				type: 'buttons',
				group: true,
				css: {
					'text-align': 'center',
					'width': '100px'
				},
				content: [{
					text: '',
					class: 'btn-success',
					id: 'btnEditLetter',
					icon: 'far fa-edit',
					click: function(el, data) {
						similarLetters.showSimilarLetter(data, 'edit');
					}
				}, {
					text: '',
					class: 'btn-danger',
					id: 'btnDeleteLetter',
					icon: 'far fa-trash-alt',
					click: function(el, data) {
						similarLetters.deleteSimilarLetter(data);
					}
				}]
			}]
		});
	},
	showSimilarLetter: function(data, mode) {
		const me = this;
		let params = {action: 'load_similar_letter_form'};
		let title = 'Add new similar';

		params.txt_id_letter = me.selectedLetterId;

		if (typeof(mode) !== 'undefined') {
			params.mode = mode;
			title = 'Edit similar';
			params.txt_letter = data.letter;
			params.txt_id = data.id
		}

		$.popup({
			title: title + ' letter',
			id: 'showSimilarLetter',
			size: 'small',
			proxy: {
				url: siteUrl('trademark/similar_letters/load_similar_letter_form'),
				params: params
			},
			buttons: [{
				btnId: 'saveDataSimilarLetter',
				btnText:'Save',
				btnClass: 'info',
				btnIcon: 'far fa-check-circle',
				onclick: function(popup) {
					const form  = popup.find('form');

					if ($.validation(form)) {
						const formData = new FormData(form[0]);

						$.ajax({
							url: siteUrl('trademark/similar_letters/store_data_similar_letter'),
							type: 'POST',
							dataType: 'JSON',
							data: formData,
							processData: false,
							contentType: false,
	         				cache: false,
							success: function(result) {
								if (result.success) {
									toastr.success(msgSaveOk);
									me.gridSimilarLetter.reloadData({
										txt_id_letter: me.selectedLetterId,
										txt_similar_letter: ''
									});
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
			}],
			listeners: {
				onshow: function() {
					$('#formLetter').submit(function(e) {
						e.preventDefault();
						e.stopPropagation();
						e.stopImmediatePropagation();
					});
				}
			}
		});
	},
	deleteSimilarLetter: function(data) {
		const me = this;

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
					url: siteUrl('trademark/similar_letters/delete_data_similar_letter'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'delete_data_similar_letter',
						txt_id: data.id,
						txt_id_letter: me.selectedLetterId
					},
					success: function(result) {
						if (result.success) me.gridSimilarLetter.reloadData({
							txt_id_letter: me.selectedLetterId,
							txt_similar_letter: ''
						});
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
	similarLetters.init();
});