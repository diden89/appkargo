<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/views/customer_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?=$header_title?></h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h4>No Transaksi</h4>
						<div class="row">
							<div class="input-group col-9">
								<select  id="txtName" class="form-control"></select>
							</div>
							<div class="col-3">
								<button id="btnAdd" class="btn btn-lg btn-block btn-primary btn-flat" type="button" title="Add Data"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="input-group col-5">
								<!-- <label for="caption" class="col-sm-4 col-form-label">Dari Tanggal : </label> -->
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
									<input type="text" name="from_date" class="form-control" id="from_date" required="required" data-date-format="dd-mm-yyyy hh:ii:ss" data-link-field="dtp_input1">
								</div>
							</div>
							<div class="input-group col-5">
							<!-- <label for="caption" class="col-sm-4 col-form-label">s/d :</label> -->
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
									<input type="text" name="to_date" class="form-control" id="to_date" required="required" data-date-format="dd-mm-yyyy hh:ii:ss" data-link-field="dtp_input1">
								</div>
							</div>
							<div class="col-2">
								<button id="rangeDate" class="btn btn-lg btn-block btn-primary btn-flat" type="button" title="Filter"><i class="fas fa-search"></i> Filter</button>
							</div>
						</div>
						<hr />
						<div id="gridDeliveryOrderCost"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

