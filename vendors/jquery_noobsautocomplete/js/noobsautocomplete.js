/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/vendors/jquery_noobsautocomplete/js/noobsautocomplete.js
 */

(function(global, $, undefined) {
	$.fn.noobsautocomplete = function(options) {

		var newOptions = typeof(options) !== 'undefined' ? options : {};

		var settings = $.extend(true, {
			remote: false,
			placeholder: '',
			minimumInputLength: 1,
			proxy: {
				url: '',
				method: 'post',
				data: {
					action: ''
				},
			},
			useTemplate: false,
			templateFormat: function(repo) {
			},
			listeners : {
				onselect: function(data) {},
				onclear: function(obj) {}
			}
		}, newOptions);

		var that = this;
		var oriEl = this;

		// $.fn.select2.defaults.set('language', {
		// 	errorLoading: function () {
		// 		return 'Terjadi kesalahan pada saat memuat data.';
		// 	},
		// 	inputTooLong: function (args) {
		// 		return "Kata yang anda masukkan terlalu panjang.";
		// 	},
		// 	inputTooShort: function (args) {
		// 		return "Input minimal " + settings.minimumInputLength + " karakter untuk mulai pencarian.";
		// 	},
		// 	loadingMore: function () {
		// 		return "Memuat lebih banyak data...";
		// 	},
		// 	maximumSelected: function (args) {
		// 		return "Maksimum data yang terpilih.";
		// 	},
		// 	noResults: function () {
		// 		return "Tidak ada data yang di temukan.";
		// 	},
		// 	searching: function () {
		// 		return "Mencari...";
		// 	}
		// });

		if (settings.useTemplate === true) {
			$.fn.select2.defaults.set('templateResult', formatRepo);
		}

		if (that.data('select2')) that.select2('destroy');

		that.select2({
			ajax: {
				url: settings.proxy.url,
				dataType: 'json',
				method: 'post',
				delay: 250,
				beforeSend: function() {},
				complete: function() {},
				data: function (params) {

					var newParams = $.extend(true, {
						query: params.term,
						page: params.page
					}, settings.proxy.data);

					return newParams;
				},
				processResults: function (data, params) {
					params.page = params.page || 1;
					return {
						results: data.items,
						pagination: {
          					more: (params.page * 30) < data.total_count
        				}
					};
				},
				cache: true
			},
			allowClear: true,
		  	placeholder: settings.placeholder,
		  	minimumInputLength: settings.minimumInputLength,
		  	templateSelection: formatRepoSelection
		});

		that.on('select2:select', function (e) {
			e.preventDefault();

			var data = e.params.data;
			var newData = {
				id: data.id, 
				text: data.text
			}
			
			settings.listeners.onselect.call(this, newData);
		});

		that.on('select2:clear', function (e) {
			oriEl.select2('close');
			settings.listeners.onclear.call(this, e.currentTarget);
		});

		function formatRepo (repo) {
			return settings.templateFormat.call(that, repo);
		}

		function formatRepoSelection (repo) {
  			return repo.full_name || repo.text;
		}

		function destroy() {
			$('#mySelect2').select2('destroy');
		}
	}
}(window, jQuery))