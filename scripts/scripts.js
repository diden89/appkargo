/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/scripts.js
 */

if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function (searchElement, fromIndex) {
		var k;

		if (this == null) {
			throw new TypeError('"this" is null or not defined');
		}

		var o = Object(this);
		var len = o.length >>> 0;

		if (len === 0) {
			return -1;
		}

		var n = +fromIndex || 0;

		if (Math.abs(n) === Infinity) {
			n = 0;
		}

		if (n >= len) {
			return -1;
		}

		k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

		while (k < len) {
			if (k in o && o[k] === searchElement) {
				return k;
			}

			k++;
		}

		return -1;
	};
}

if (!String.prototype.splice) {
	String.prototype.splice = function(start, delCount, newSubStr) {
		return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
	};
}

if (!String.prototype.nl2br) {
	String.prototype.nl2br = function() {
		return this.replace(/\r\n|\n\r|\r|\n/g, '<br />');
	};
}

var siteUrl = function(uri) {
	return BASE_URL + uri;
};

var baseUrl = function() {
	return BASE_URL;
};

var gTitle = function() {
	return NOOBS_TITLE;
};

var userFullname = function() {
	return USER_FULLNAME;
};

var userLocationCaption = function() {
	return USER_LOCATION_CAPTION;
};

var userLocation = function() {
	return USER_LOCATION;
};

var userIP = function() {
	return USER_IP;
};

var isJsonString = function(str) {
	try {
		JSON.parse(str);
	} catch (e) {
		return false;
	}

	if (JSON.parse(str) == null) return false;
	
	return true;
};

var getTime = function(fn) {
	var d = new Date(),
		date = d.getDate(),
		month = d.getMonth(),
		year = d.getFullYear(),
		hour = d.getHours(),
		minute = d.getMinutes(),
		second = d.getSeconds();

	month++;

	if (date < 10) date = '0' + date;
	if (month < 10) month = '0' + month;
	if (hour < 10) hour = '0' + hour;
	if (minute < 10) minute = '0' + minute;
	if (second < 10) second = '0' + second;

	var params = {
		date: date,
		month: month,
		year: year,
		hour: hour,
		minute: minute,
		second: second
	};

	fn(params);
};

var doTime = function(fn) {
	getTime(fn);
	setInterval(function() {
		getTime(fn);
	}, 1000);
};

var msgErr = 'An error occurred, please contact the admin.';
var msgSaveOk = 'Data saved successfully.';

const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 1500
});

var loadingOverlay = function(mode, el) {
	if (mode == 'start') {
		el.waitMe({
			effect: 'win8_linear',
			text: 'Please wait... Data is being processed.',
			bg: 'rgba(255,255,255,0.7)',
			color: '#000'
		});
	} else if (mode == 'hide') {
		el.waitMe('hide');
	}
};

$(document).ready(function() {
	jQuery.ajaxSetup({
		beforeSend: function() {
			if ($('.modal.show').length) loadingOverlay('start', $('.modal-body'));
			else loadingOverlay('start', $('.content'));
		},
		complete: function() {
			if ($('.modal.show').length) loadingOverlay('hide', $('.modal-body'));
			else loadingOverlay('hide', $('.content'));
		}
	});
	
	$('input').each(function(item){
		var el = this;

		InvalidInputHelper(el, {
			emptyText: 'This column cannot be empty.',
			defaultText: '',
			invalidText: function (input) {
				return 'Input "' + input.value + '" not valid.';
			}
		});
	});

	var pageActive = $('.nav-link.active');
	var pageActiveParent = pageActive.parents('.nav-item.has-treeview');
	var pageActiveLink = pageActiveParent.find('a.nav-link')[0];

	pageActiveParent.addClass('menu-open');
	$(pageActiveLink).addClass('active');
});