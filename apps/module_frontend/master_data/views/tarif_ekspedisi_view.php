<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/masterd_data/views/tarif_ekspedisi_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?=$pages_title?></h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-4">						
						<h4>Provinsi</h4>
						<select class="form-control select2 "  name="txt_provinsi_id" id="txt_provinsi_id">
							<option value="">--Pilih Provinsi--</option>
						</select>
						<div class="list-group" id="listGroup">
							<p class="text-muted">Kab / Kota</p>
						</div>
					</div>
					<div class="col-8">
						<h4>Kecamatan</h4>
						<form id="addDataTable">
						<div class="excel-data-table-container" style="height:100%;">
							<table class="collaptable table table-striped" id="example1">
								<thead>
									<th scope="col"><a href="javascript:void(0);" class="act-button-expand" style="color: white;"></a></th>
									<th scope="col">Caption</th>
									<th scope="col" style="text-align:center;">Tarif</th>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<div class="btn-group"  aria-label="RAB Button Group">
							<input type="hidden" name="action" value="store_data">
							<button type="submit" id="btnSave" class="btn merekdagang-grid-btn btn-primary btn-md" disabled on><i class="fas fa-save"></i> Save</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>