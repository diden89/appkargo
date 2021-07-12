/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/vendors/jquery_treegrid/js/treegrid.js
 */

var countTreeGrid = 0;

(function(global, $, undefined) {
	$.fn.TreeGrid = function(options) {
		if (this.length > 1) {
			this.each(function() {
				$(this).TreeGrid(options);
			});

			return this;
		}

		var settings = $.extend(true, {
			tree: false,
			showLimit: [10, 25, 50, 100],
			columns: [],
			stripRows: true,
			proxy: {
				url: '',
				method: 'post',
				params: {
					limit: 10,
					page: 1,
					start: 0
				},
				autoLoad: true
			},
			onLoad: function() {}
		}, options);

		var _generateGridHeader = function(obj, data) {
			var $this = $(obj);
			var thead = $this.append('<thead>');
			var gridStr = '';

			gridStr += '<tr>';

			if (settings.columns.length > 0) {
				for (var y in settings.columns) {
					var tmpY = settings.columns[y];

					gridStr += '<th';

					if (typeof(tmpY['styleHeader']) !== 'undefined') {
						gridStr += ' style="'+tmpY['styleHeader']+'"';
					}

					gridStr += '><div>'+tmpY['header']+'</div></th>';
				}
			}

			gridStr += '</tr>';

			$this.find('thead').html(gridStr);
		};

		var _generateGridBody = function(obj, data) {
			var $this = $(obj);
			var tbody = $this.append('<tbody>');
			var gridStr = '';
			var gridData = [];

			if (settings.tree !== false && typeof(data.rows.root) !== 'undefined') {
				gridStr = _generateGridBodyEl(data.rows.root, 0, true);
			} else {
				gridStr = _generateGridBodyEl(data.rows, 0, false);
			}

			$this.find('tbody').html(gridStr);
			$('.treegrid .treegrid-container-middle table tbody tr td').click(function(){
				var $this = $(this);

				$this.parent('tr').children().each(function(){
					var $this = $(this);

					$this.addClass('treegrid-row-click');
				});
			});
		};

		var _generateGridBodyEl = function(gridData, idx, isTree) {
			var gridStr = '';

			for (var x in gridData) {
				var tmpX = gridData[x];

				gridStr += '<tr>';

				if (settings.columns.length > 0) {
					for (var y in settings.columns) {
						var tmpY = settings.columns[y];
						var dataIndex = tmpY['dataIndex'];
						var style = '';
						var cls = [];
						var empty = [];

						if (typeof(tmpY['styleBody']) !== 'undefined') {
							style = tmpY['styleBody'];
						}

						if (idx > 0 && y == 0) {
							for (var z = 0; z <= idx; z++) {
								empty.push('<span class="treegrid-cell-empty"></span>')
							}
						}

						gridStr += '<td style="'+style+'"><div class="">'+empty.join('')+'<span class="treegrid-cell-content">'+tmpX[dataIndex]+'</span></div></td>';
					}
				}

				gridStr += '</tr>';

				if (isTree !== false && typeof(tmpX['children']) === 'object') {
					idx++;

					gridStr += _generateGridBodyEl(tmpX['children'], idx, isTree);
				}
			}

			return gridStr;
		};

		var info = {
			id: 'TreeGrid_0',
			version: 'v1.0',
			author: {
				leader: 'Sikelopes'
			}
		};

		this.init = function() {
			var containerStr = '';

			this.id = 'TreeGrid_' + countTreeGrid;
			countTreeGrid++

			var id = this.id;

			containerStr += '<div id="top_' + id + '" class="row treegrid-container-top">';
			containerStr += '<div id="topLeft_' + id + '" class="col-sm-12 col-md-6 treegrid-container"><table id="topLeftToolbar_' + id + '" class="treegrid-toolbar"><tr>';

			if (settings.showLimit !== false) {
				var showLimit = settings.showLimit;

				containerStr += '<td class="treegrid-limit"><label>Limit:</label> <select class="custom-select custom-select-sm form-control form-control-sm">';

				for (var x in showLimit) {
					containerStr += '<option value="' + showLimit[x] + '">' + showLimit[x] + '</option>';
				}

				containerStr += '</select></td>';
			}

			containerStr += '</tr></table></div>';
			containerStr += '<div id="topRight_' + id + '" class="col-sm-12 col-md-6"><table id="topRightToolbar_' + id + '" class="treegrid-toolbar"><tr></tr></table></div>';
			containerStr += '</div>'
			containerStr += '<div id="middle_' + id + '" class="row treegrid-container-middle"><table id="table_' + id + '" class="table table-bordered table-hover"></table></div>';
			containerStr += '<div id="bottom_' + id + '" class="row treegrid-container-bottom"></div>';

			var parentContainer = $('<div>').attr('id', 'parent_' + id).addClass('treegrid');

			$(this).prepend(parentContainer);
			parentContainer.html(containerStr);

			this.table = $('#table_' + id);

			if (settings.stripRows !== false) {
				this.table.addClass('table-striped');
			}

			if (settings.proxy.autoLoad !== false) {
				this.load();
			}
		};

		this.load = function() {
			var method = settings.proxy.method;
			var that = this;

			if (typeof(msgErr) === 'undefined' || typeof(msgErr) === 'null' || msgErr == '') {
				msgErr = 'Something wrong. Please contact the administrators.';
			}

			$.ajax({
				dataType: 'json',
				url: settings.proxy.url,
				method: method.toUpperCase(),
				data: settings.proxy.params,
				success: function(json) {
					_generateGridHeader(that.table, json);
					_generateGridBody(that.table, json);

					if ($.isFunction(settings.onLoad)) {
						settings.onLoad.call(that);
					}
				},
				error: function() {
					Swal.fire({
						type: 'error',
						html: msgErr
					});
				}
			});
		};

		return this.init();
	};
}(window, jQuery));