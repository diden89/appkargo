<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/report/views/report_piutang_view.php
 */
?>

	<div class="card col-md-4">
		<div class="card-header">
			<!-- <h3 class="card-title"><?=$pages_title?></h3> -->
			<h3 class="card-title">Laporan</h3>
		</div>
		<div class="card-body">
		<form action="report_piutang/print_pdf" method="post">			
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
								<input type="text" name="date_range_1" class="form-control" id="date_range_1" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
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
								<input type="text" name="date_range_2" class="form-control" id="date_range_2" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">Tipe Laporan</label>
						<div class="input-group col-8">
							<select name="type" class="form-control">
								<option value="rekap">Rekap</option>
								<option value="detail">Detail</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row">							
				<div class="input-group col-lg-6">
					<div class="input-group-append">
						<button class="btn btn-lg btn-block btn-warning btn-flat" type="submit" title="Add Data" formtarget="_blank"><i class="fas fa-plus"></i> Print</button>
					</div>
				</div>
			</div>
		</form>
		</div>
	</div>