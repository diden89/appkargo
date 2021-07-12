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
		selectedSimilarWord: '',
		gridWords : $('#gridWords').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('trademark/similar_words/get_data'),
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
						'text-align': 'center',
						'width': '50px'
					}
				},
				{
					title: 'Word',
					data: 'sw_word'
				},
				{
					title: 'Action',
					size: 'medium',
					type: 'buttons',
					group: true,
					css: {
						'text-align' : 'center',
						'width' : '200px'
					},
					content: [
						{
							text: 'View',
							class: 'btn-warning btn-sm',
							id: 'btnView',
							icon: 'far fa-eye',
							click: function(row, rowData) {
								// $('#txtSImilarWord').val('');
								// $('#txtSImilarWord').attr('disabled', false);

								SIMILAR_WORDS.selectedSimilarWord = rowData.sw_similar_word;

								SIMILAR_WORDS.gridSimilarWords.reloadData({
									txt_similar_word: rowData.sw_similar_word,
									txt_search_word: $('#txtSImilarWord').val()
								});
							}
						}
					]
				}
			]
		}),
		gridSimilarWords : $('#gridSimilarWords').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('trademark/similar_words/get_data_similar_word'),
				method: 'post',
				data: {
					action: 'get_data_similar_word',
					load: false
				},
			},
			columns: [
				{
					title: 'No', 
					data: 'no',
					searchable: false,
					orderable: false,
					width: 15
				},
				{
					title: 'Word',
					data: 'sw_word'
				}
			]
		})
	};

	$('#btnSearch').click(function(e) {
		e.preventDefault();

		SIMILAR_WORDS.gridWords.reloadData({
			txt_word: $('#txtWord').val()
		});

		SIMILAR_WORDS.gridSimilarWords.reloadData({
			load: false
		});
	});

	$('#txtWord').keydown(function(e) {
    	var keyCode = (e.keyCode ? e.keyCode : e.which);
	    if (keyCode == 13) {
	        $('#btnSearch').trigger('click');
	    }
	});


	$('#btnSearchSimilarWord').click(function(e) {
		e.preventDefault();

		SIMILAR_WORDS.gridSimilarWords.reloadData({
			txt_similar_word: SIMILAR_WORDS.selectedSimilarWord,
			txt_search_word: $('#txtSImilarWord').val()
		});
	});

	$('#txtSImilarWord').keydown(function(e) {
    	var keyCode = (e.keyCode ? e.keyCode : e.which);
	    if (keyCode == 13) {
	        $('#btnSearchSimilarWord').trigger('click');
	    }
	});
});