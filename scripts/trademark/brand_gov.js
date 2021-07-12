/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/trademark/brand_gov.js
 */

$(document).ready(function() {
	const BRAND_GOV = {
		gridBrandGov : $('#gridBrandGov').grid({
			serverSide: true,
			striped: true,
			proxy: {
				url: siteUrl('trademark/brand_gov/get_data'),
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
						'text-align': 'center'
					},
					width: 10
				},
				{
					title: 'BRM Number',
					data: 'bp_brm_num'
				},
				{
					title: 'Publish Date',
					data: 'bp_brm_published_date'
				},
				{
					title: 'Application Number',
					data: 'b_application_number'
				},
				{
					title: 'Filling Date',
					data: 'b_receipt_date_new'
				},
				{
					title: 'Class',
					data: 'b_class'
				},
				{
					title: 'Trademark',
					data: 'b_brand'
				},
				{
					title: 'File',
					size: 'medium',
					type: 'buttons',
					group: true,
					css: {
						'text-align' : 'center',
						'width' : '200px'
					},
					content: [
						{
							text: 'View File',
							class: 'btn-info btn-sm',
							id: 'btnFile',
							icon: 'far fa-file-pdf',
							click: function(row, rowData) {
								window.open(rowData.file_link, '_blank');
							}
						}
					]
				},
			],
		}),
		uploadPopup: function() {
			$.popup({
				title: 'Upload File',
				id: 'uploadFilePopup',
				size: 'medium',
				content: `
					<form id="forBrandGovUploadData" enctype="multipart/form-data">
						<input type="hidden" name="action" value="upload_file">
						<input type="submit" id="btnSubmit" name="submit" class="sr-only"/>
						<div class="form-group row">
							<label for="txtMonth" class="col-sm-2 col-form-label">Month</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="txt_month" id="txtMonth" data-inputmask-alias="datetime" data-inputmask-inputformat="mm" data-mask>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtYear" class="col-sm-2 col-form-label">Year</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="txt_year" id="txtYear" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy" data-mask>
							</div>
						</div>
						<div class="form-group row">
							<label for="filePdf" class="col-sm-2 col-form-label">File</label>
							<div class="col-sm-10">
								<input type="file" name="file_pdf" class="form-control" id="filePdf" accept="application/pdf">
							</div>
						</div>
						<div class="progress">
							<div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="percentText"></span></div>
						</div>
					</form>
				`,
				buttons: [{
					btnId: 'uploadData',
					btnText:'Upload',
					btnClass: 'info',
					btnIcon: 'fas fa-upload',
					onclick: function(popup) {
						$('#btnSubmit').trigger('click');
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
					onshow: function(popup) {
						var form  = popup.find('form');
						var progressBar = $('#progressBar');
                        var percentText = $('#percentText');

                        $('#txtMonth').inputmask('mm', { 'placeholder': 'MM' });
                        $('#txtYear').inputmask('yyyy', { 'placeholder': 'YYYY' });

						form.on('submit', function(e) {
							e.preventDefault();
							$.ajax({
								xhr: function() {
					                var xhr = new window.XMLHttpRequest();
					                xhr.upload.addEventListener("progress", function(evt) {
					                    if (evt.lengthComputable) {
					                        var percentComplete = Math.round(((evt.loaded / evt.total) * 100));

					                        var progressBar = $('#progressBar');
					                        var percentText = $('#percentText');

					                        progressBar.css('width', percentComplete + '%');
											progressBar.attr('aria-valuenow', percentComplete);
											percentText.html(percentComplete + '%');
					                    }

					                }, false);

					                return xhr;
					            },
					            type: 'POST',
					            url: siteUrl('trademark/brand_gov/upload_file'),
					            dataType: 'JSON',
					            data: new FormData(this),
					            contentType: false,
					            cache: false,
					            processData:false,
					            beforeSend: function() {
					            	progressBar.css('width', '0%');
									progressBar.attr('aria-valuenow', 0);
									percentText.html('0%');
					            },
					            error:function(error) {
					                toastr.error(result.msg);
					            },
					            success: function(result) {
					                if (result.success) {
						        		toastr.success('Upload file complete.');
						        		BRAND_GOV.gridBrandGov.reloadData({
											txt_brand_name: $('#txtBrandGovName').val(),
											txt_receive_date: $('#txtReceiveDate').val()
										});
										$('#uploadData').addClass('d-none');
						        	} else if (typeof(result.msg) !== 'undefined') {
										toastr.error(result.msg);
									} else {
										toastr.error(msgErr);
									}
					            }
							});
						});
					}
				}
			});
		}
	};

	$('#txtReceiveDate').noobsdaterangepicker({
		showDropdowns: true,
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});

	$('#btnSearch').click(function(e) {
		e.preventDefault();

		BRAND_GOV.gridBrandGov.reloadData({
			txt_brand_name: $('#txtBrandGovName').val(),
			txt_receive_date: $('#txtReceiveDate').val()
		});
	});

	$('#txtBrandGovName').keydown(function(e) {
    	var keyCode = (e.keyCode ? e.keyCode : e.which);
	    if (keyCode == 13) {
	        $('#btnSearch').trigger('click');
	    }
	});

	$('#btnUpload').click(function(e) {
		e.preventDefault();
		BRAND_GOV.uploadPopup();
	});
});