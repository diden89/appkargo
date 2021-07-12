/*!
 * @package jQuery-validation
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link vendors/jquery_validation/js/validation.js
 */

(function(global, $, undefined) {
	$.validation = function(form) {
		var formDataArray = form.serializeArray();
		var validated = false;
		
		for (var idx in formDataArray) {
			var elName = formDataArray[idx].name;
			var el = $("[name='"+elName+"']");
			var elParent = el.closest('.form-group');

			if (el.parent().children('.help-block').length == 0) el.parent().append('<small class="form-text text-danger help-block"></small>');

			var elHelpBlock = elParent.find('.help-block');
			var required = el[0].required;
			var type = el[0].type;

			if (required) {
				if (el.val().length < 1 || el.val() == '' || el.val() == ' ' || el.val() == '  ') {
					elParent.addClass('has-error');
					elHelpBlock.css('display', 'block');
					elHelpBlock.html('This input cannot be empty.');
					
					return false;
				} else {
					elParent.removeClass('has-error');
					elHelpBlock.css('display', 'none');

					if (type == 'email') {
						var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

						if (re.test(String(el.val()).toLowerCase())) validated = true;
						else {
							elParent.addClass('has-error');
							elHelpBlock.css('display', 'block');
							elHelpBlock.html('Enter the email with the correct format.');
					
							return false;
						} 
					} else validated = true;
				}
			} else validated = true;
		}

		return validated;
	}
})(window, jQuery);