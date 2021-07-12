<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/views/invented_brand_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">List of Findings</h3>
			</div>
			<div class="card-body">
				<form id="formInventedInventedBrand">
					<div class="form-row">
						<div class="col-md-10 form-search">
							<div class="row form-group">
								<label for="txtInventedBrandName" class="col-md-2 col-form-label">Similar Trademarks</label>
								<div class="col-md-4">
									<input type="text" name="txt_brand_name" class="form-control" id="txtInventedBrandName" placeholder="insert client’s trademark"> 
								</div>
								<label for="txtReceiveDate" class="col-md-2 col-form-label">Findings date</label>
								<div class="col-md-4">
									<input type="text" name="txt_receive_date" class="form-control" id="txtReceiveDate">
								</div>
							</div>
							<div class="row form-group form-search">
								<label for="txtStatus" class="col-md-2 col-form-label">Status</label>
								<div class="col-md-4">
									<select name="txt_status" id="txtStatus" class="form-control">
										<?php foreach ($findings_status as $k => $v): ?>
											<option value="<?= $v->code ?>"><?= $v->value ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<label for="txtRegistredBrand" class="col-md-2 col-form-label">View Registered Brand</label>
								<div class="col-md-4">
									<input type="checkbox" id="txtRegistredBrand" name="txt_view_registered" data-bootstrap-switch data-off-color="danger" data-on-color="success">
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<button type="button" id="btnSearch" class="btn btn-lg btn-block btn-info btn-flat"><i class="fas fa-search"></i> Search</button>
						</div>
					</div>
				</form>
				<hr>
				<div id="gridInventedBrand"></div>
			</div>
		</div>
	</div>
</div>