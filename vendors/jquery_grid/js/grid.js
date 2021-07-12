/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/vendors/jquery_grid/js/grid.js
 */

(function (global, $, undefined) {
	$.fn.grid = function (options) {

		var that;

		var oriTable;

		if (this[0].tagName !== 'TABLE') {
			if (this[0].tagName == 'DIV') {
				var id = this.attr('id');
				this.removeAttr('id');
				this.addClass('data-table-container');
				var table = $('<table/>')
				table.attr('id', id);
				table.css('width', '100%');
				this.append(table);
				that = table;
				oriTable = table;
			}
		} else {
			if (typeof ($('.data-table-container')) == 'undefined') {
				var div = $('<div/>');
				div.addClass('data-table-container');
				this.wrap(div);
			}

			that = this;
			oriTable = this;
		}

		var newOptions = typeof (options) !== 'undefined' ? options : {};

		var settings = $.extend(true, {
			class: typeof (newOptions.class) !== 'undefined' ? newOptions.class : 'table table-hover',
			striped: false,
			serverSide: typeof (newOptions.serverSide) !== 'undefined' ? true : false,
			columns: typeof (newOptions.columns) !== 'undefined' ? newOptions.columns : false,
			proxy: {
				url: '',
				method: 'post',
				data: {
					action: ''
				},
			},
			listeners: {
				onclick: function (row, rowData, idx) {},
				ondblclick: function (row, rowData, idx) {}
			}
		}, newOptions);

		$.extend($.fn.dataTable.defaults, {
			processing: true,
			serverSide: settings.serverSide,
			searching: true,
			pageLength: typeof (newOptions.pageLength) !== 'undefined' ? newOptions.pageLength : 25,
			responsive: true,
			// scrollY: '50vh',
			// scrollX: true,
			scrollCollapse: true,
			autoWidth: false,
			dom: 'ltpri',
			lengthMenu: [ 5, 10, 25, 50, 100, 250, 500 ]
			// language: {
			// 	processing: "Sedang memproses...",
			// 	search: "Cari&nbsp;:",
			// 	lengthMenu: "Tampilkan _MENU_ entri",
			// 	info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
			// 	infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
			// 	infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
			// 	infoPostFix: "",
			// 	loadingRecords: "Memuat data...",
			// 	zeroRecords: "Tidak ditemukan data yang sesuai",
			// 	emptyTable: "Tidak ada data yang tersedia pada tabel ini",
			// 	paginate: {
			// 		first: "Pertama",
			// 		previous: "Sebelumnya",
			// 		next: "Selanjutnya",
			// 		last: "Terakhir"
			// 	}
			// },
		});

		if (settings.serverSide === true) {

			var columns = createColumnsData(settings.columns);

			$.extend($.fn.DataTable.defaults, {
				ajax: settings.proxy,
				columns: columns
			});
		}

		that.addClass(settings.class);

		if (settings.striped === true) that.addClass('table-striped');

		var noobGrid = that.dataTable({
			destroy: true,
			headerCallback: function (thead, data, start, end, display) {
				var columns = $(thead).find('th');

				columns.each(function (idx, obj) {
					var column = $(obj);

					if (settings.columns !== false) {
						var css = settings.columns[idx].css;

						if (typeof (css) !== 'undefined') {
							var tmpArr = Object.entries(css);
							for (var x in tmpArr) {
								var tmpObj = tmpArr[x];
								column.css(tmpObj[0], tmpObj[1]);
							}
						}
					}
				});
			},
			rowCallback: function (row, data) {

				var columns = $(row).find('td');

				columns.each(function (idx, obj) {
					var column = $(obj);

					if (settings.columns !== false) {
						var css = settings.columns[idx].css;
						if (typeof (css) !== 'undefined') {
							var tmpArr = Object.entries(css);
							for (var x in tmpArr) {
								var tmpObj = tmpArr[x];
								column.css(tmpObj[0], tmpObj[1]);
							}
						}

						if (typeof (settings.columns[idx].afterInsert) !== 'undefined') {
							if ($.isFunction(settings.columns[idx].afterInsert)) {
								settings.columns[idx].afterInsert.call(this, column, data);
							}
						}
					}
				});
			},
			createdRow: function (row, rowData, index) {
				$(row).click(function (e) {
					e.preventDefault();
					settings.listeners.onclick.call(this, row, rowData, index);
				});

				$(row).dblclick(function (e) {
					e.preventDefault();
					settings.listeners.ondblclick.call(this, row, rowData, index);
				});

				var cols = $(row).children();

				cols.each(function(idx, obj) {
					
					var buttons = $(obj).find('.merekdagang-grid-btn');
					var colsNum = idx;

					if (typeof (buttons) !== 'undefined') {
						buttons.each(function (idx, obj) {
							var newButton = $(this);
							newButton.click(function (e) {
								e.preventDefault();
								settings.columns[colsNum].content[idx].click(newButton, rowData);
							});
						});
					}

				});
			}
		});

		function createColumnsData(columns) {
			var newColumns = [];
			for (var x in columns) {
				var tmpData = columns[x];
				if (typeof (tmpData.content) !== 'undefined') {
					var newObj = {}
					newObj.title = tmpData.title;
					newObj.data = null;
					newObj.searchable = false;
					newObj.orderable = false;
					newObj.defaultContent = generateContent(tmpData.content, tmpData.group, tmpData.size);
					newColumns.push(newObj);
				} else newColumns.push(tmpData);
			}

			return newColumns;
		}

		function generateContent(content, group = false, size = 'normal') {

			var html = '';

			var marginCLass = 'btn-grid-merekdagang-margin';

			if (group) {
				html += '<div class="btn-group" role="group" aria-label="RAB Button Group">';
				marginCLass = '';
			}

			var btnSizeClass = '';

			switch (size) {
				case 'small':
					btnSizeClass = 'btn-xs';
					break;
				case 'medium':
					btnSizeClass = 'btn-sm';
					break;
				case 'large':
					btnSizeClass = 'btn-lg';
					break;
				default:
					btnSizeClass = '';
			}

			for (var x in content) {
				tmpContent = content[x];

				html += '<button type="button" id="' + tmpContent.id + '" class="btn ' + marginCLass + ' merekdagang-grid-btn ' + tmpContent.class + ' ' + btnSizeClass + '"><i class="' + tmpContent.icon + '"></i> ' + tmpContent.text + '</button>';
			}

			if (group) {
				html += '</div>';
			}

			return html;
		}

		noobGrid.reloadData = function (params) {
			if (typeof (params) !== 'undefined') {

				oriTable.DataTable().clear().destroy();

				params.action = options.proxy.data.action;

				options.proxy.data = params;

				oriTable.grid(options);

			} else noobGrid.ajax.reload(null, false);
		}

		return noobGrid;
	}
}(window, jQuery));