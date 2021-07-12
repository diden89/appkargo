/*!
 * @package jQuery-popup
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/vendors/jquery_popup/js/popup.js
 */

(function (global, $, undefined) {
	$.popup = function (options) {
		this.settings = $.extend(true, {
			title: 'Trademark Popup',
			id: '',
			size: '',
			closeButton: true,
			keyboard: false,
			autoShow: true,
			content: false,
			proxy: {
				url: '',
				method: 'post',
				params: {}
			},
			buttons: [],
			listeners: {
				onshow: function () {},
				onclose: function () {}
			}
		}, options);

		this.version = 'v1.0';
		this.author = {
			Leader: 'Andy1t'
		};

		var that = this;

		var modalSize = '';

		switch (that.settings.size) {
			case 'small':
				modalSize = 'modal-sm';
				break;
			case 'medium':
				modalSize = 'modal-lg';
				break;
			case 'large':
				modalSize = 'modal-xl';
				break;
			default:
				modalSize = '';
				break;
		};

		var bModal = $('<div />').attr('id', that.settings.id).attr('role', 'dialog').attr('tabindex', '-1').addClass('modal fade');
		var bModalDialog = $('<div />').addClass('modal-dialog modal-dialog-centered').addClass(modalSize).attr('role', 'document');
		var bModalContent = $('<div />').addClass('modal-content');
		var bModalHeader = $('<div />').addClass('modal-header');
		var bBtnDismiss = $('<button />').addClass('close').attr('type', 'button').attr('aria-label', 'Close');
		var bBtnDismissSpan = $('<span />').attr('aria-hidden', 'true');
		var bModalTitle = $('<h5 />').addClass('modal-title');
		var bModalBody = $('<div />').addClass('modal-body');
		var bModalFooter = $('<div />').addClass('modal-footer');

		bModal.append(bModalDialog);
		bModalDialog.append(bModalContent);
		bModalContent.append(bModalHeader);
		bModalHeader.append(bModalTitle);

		if (that.settings.closeButton) {
			bModalHeader.append(bBtnDismiss);
			bBtnDismiss.append(bBtnDismissSpan);
			bBtnDismiss.html('&times;');
		}

		bModalTitle.html(this.settings.title);
		bModalContent.append(bModalBody);

		bModal.modal({
			keyboard: false,
			backdrop: 'static'
		});


		bModal.close = function () {
			close();
		}

		bBtnDismiss.click(function (e) {
			e.preventDefault();
			close();
		});

		that.show = show();

		bModal.on('shown.bs.modal', function (event) {
			event.preventDefault();
			event.stopPropagation();
			that.settings.listeners.onshow.call(this, bModal, event);
		});

		function show() {

			var htmlBody = '';

			if (that.settings.content == false && that.settings.proxy.url !== '') {
				$.ajax({
					method: that.settings.proxy.method,
					url: that.settings.proxy.url,
					data: that.settings.proxy.params,
					cache: false,
					beforeSend: function() {},
					complete: function() {},
					success: function (response) {
						htmlBody = response;
						setModalContent(htmlBody)
					},
					error: function (error) {
						console.log(error);
					}
				});
			} else {
				htmlBody = that.settings.content;
				setModalContent(htmlBody)
			}
		}

		function setModalContent(htmlBody) {
			bModalBody.html(htmlBody);
			bModalContent.append(bModalFooter);
			if (that.settings.buttons.length > 0) {
				for (var i = 0; i < that.settings.buttons.length; i++) {
					(function (btn) {
						var bFooterBtn = $('<button />').addClass('btn btn-flat btn-' + btn.btnClass).addClass(btn.class)
							.attr('id', btn.btnId)
							.attr('type', 'button')
							.click(function () {
								btn.onclick(bModal, bFooterBtn);
							});

						if (typeof (btn.btnIcon) !== 'undefined') {
							var bFooterBtnIcon = '<i class="' + btn.btnIcon + '"></i> ';
							bFooterBtn.append(bFooterBtnIcon);
						}

						bFooterBtn.append(btn.btnText);

						bModalFooter.prepend(bFooterBtn);

					})(that.settings.buttons[i]);
				}
			}

			bModal.modal('show');
		}

		function close() {
			bModal.modal("hide").data('bs.modal', null);
			that.settings.listeners.onclose.call(this, bModal);
			setTimeout(function () {
				bModal.remove();
				bModal.empty().remove();
				$("body").removeClass("modal-open");
			}, 500);
		}

		return this.each(function () {
			var $this = $(this);

			if (that.settings.autoShow !== false) {
				show();
			}
		});
	};
})(window, jQuery);