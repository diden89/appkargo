<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/views/vendor_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?=$header_title?></h3>
			</div>
			<div class="card-body">
				<div class="form-row">
					<div class="col-sm-10">
						<select  id="txtName" class="form-control"></select>
					</div>
					<div class="col-sm-2">
						<button type="button" id="btnAdd" class="btn btn-lg btn-block btn-primary btn-flat"><i class="fas fa-plus"></i> Add</button>
					</div>
				</div>
				<!-- <div class="form-row">
					<div class="input-group col-md-5">
						<label for="caption" class="col-sm-3 col-form-label">Periode</label>
						<div class="col-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">

										<i class="far fa-calendar-alt"></i>
									</span>
								</div>
								<input type="text" name="ud_dob_new" class="form-control" id="range1" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
							</div>
						</div>
					</div>
					<div class="input-group col-md-5">
						<label for="caption" class="col-sm-3 col-form-label">S/d</label>
						<div class="col-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">
										<i class="far fa-calendar-alt"></i>
									</span>
								</div>
								<input type="text" name="ud_dob_new" class="form-control" id="range2" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
							</div>
						</div>
					</div>
					<div class="input-group col-md-2">
						<button id="daterangedata" class="btn btn-info" type="button"><i class="fas fa-search"></i>Filter</button>
					</div>
				</div> -->
				<hr>
                <div id="gridVendor"></div>
			</div>
		</div>
	</div>
</div>

