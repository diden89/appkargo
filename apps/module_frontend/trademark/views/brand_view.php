<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/views/brand_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">List of Trademarks</h3>
			</div>
			<div class="card-body">
				<form id="formBrand" target="_blank" method="post">
					<div class="form-row">
						<div class="col-md-8 form-search">
							<div class="row form-group">
								<label for="txtBrandName" class="col-md-3 col-form-label">Client’s Trademarks</label>
								<div class="col-md-9">
									<input type="text" name="txt_brand_name" class="form-control" id="txtBrandName" placeholder="insert client’s trademark"> 
								</div>
							</div>
							<div class="row form-group form-search">
								<label for="txtReceiveDate" class="col-md-3 col-form-label">Receive date</label>
								<div class="col-md-7">
									<input type="text" name="txt_receive_date" class="form-control" id="txtReceiveDate">
								</div>
								<div class="col-md-2">
									<button type="button" id="btnSearch" class="btn btn-lg btn-block btn-info btn-flat"><i class="fas fa-search"></i> Search</button>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="btn-group btn-block btn-group-lg" role="group" arial-label="Upload Download Group Button">
								<button type="button" id="btnDownloadExcel" class="btn btn-warning btn-flat"><i class="fas fa-file-excel"></i> Download</button>
							    <button type="button" id="btnUploadExcel" class="btn btn-success btn-flat"><i class="fas fa-file-excel"></i> Upload</button>
							    <!-- <button type="button" id="btnUploadPdf" class="btn btn-danger btn-flat"><i class="fas fa-file-pdf"></i> Upload</button> -->
							</div>
							<button type="button" id="btnAdd" class="btn btn-lg btn-block btn-primary btn-flat"><i class="fas fa-plus"></i> Add</button>
						</div>
					</div>
					<hr>
					<div id="gridBrand"></div>
				</form>
			</div>
		</div>
	</div>
</div>