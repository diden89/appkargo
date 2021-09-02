<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/report/views/report_cash_in_view.php
 */
?>

	<div class="card col-md-4">
		<div class="card-header">
			<!-- <h3 class="card-title"><?=$pages_title?></h3> -->
			<h3 class="card-title">**</h3>
		</div>
		<div class="card-body">			
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">Periode</label>
						<div class="input-group col-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">
										<i class="far fa-calendar-alt"></i>
									</span>
								</div>
								<input type="text" name="co_created_date_1" class="form-control" id="date_range_1" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">S/D</label>
						<div class="input-group col-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">
										<i class="far fa-calendar-alt"></i>
									</span>
								</div>
								<input type="text" name="co_created_date_2" class="form-control" id="date_range_2" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">							
				<div class="input-group col-lg-6">
					<div class="input-group-append">
						<a href="<?php echo base_url('report/report_cash_in/print_pdf'); ?>" target="_blank" class="btn btn-lg btn-block btn-warning btn-flat" type="button" title="Add Data"><i class="fas fa-plus"></i> Print</a>
					</div>
				</div>
			</div>
		</div>
	</div>