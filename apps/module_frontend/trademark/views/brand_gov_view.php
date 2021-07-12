<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/views/brand_gov_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">List of BRM</h3>
				<span class="float-right">
					<span>Unchecked BRM?</span>
					<button type="button" id="btnUpload" class="btn btn-lg btn-primary btn-flat"><i class="far fa-file-pdf"></i> Upload</button>
				</span>
			</div>
			<div class="card-body">
				<form id="formBrandGov">
					<div class="form-row">
						<div class="col-md-10 form-search">
							<div class="row form-group">
								<label for="txtBrandGovName" class="col-md-3 col-form-label">Client’s Trademarks</label>
								<div class="col-md-9">
									<input type="text" name="txt_brand_name" class="form-control" id="txtBrandGovName" placeholder="insert client’s trademark"> 
								</div>
							</div>
							<div class="row form-group form-search">
								<label for="txtReceiveDate" class="col-md-3 col-form-label">Filing date</label>
								<div class="col-md-9">
									<input type="text" name="txt_receive_date" class="form-control" id="txtReceiveDate" placeholder="Receive Date">
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<button type="button" id="btnSearch" class="btn btn-lg btn-block btn-info btn-flat"><i class="fas fa-search"></i> Search</button>
							<!-- <button type="button" id="btnUpload" class="btn btn-lg btn-block btn-primary btn-flat"><i class="far fa-file-pdf"></i> Upload</button> -->
						</div>
					</div>
				</form>
				<hr>
				<div id="gridBrandGov"></div>
			</div>
		</div>
	</div>
</div>