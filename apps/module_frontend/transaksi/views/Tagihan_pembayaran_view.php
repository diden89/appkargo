<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/transaksi/views/tagihan_pembayaran_view.php
 */
?>

	<div class="card col-md-4">
		<div class="card-header">
			<!-- <h3 class="card-title"><?=$pages_title?></h3> -->
			<h3 class="card-title">Laporan</h3>
		</div>
		<div class="card-body">
		<form action="tagihan_pembayaran/print_pdf" method="post">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">Tanggal Penagihan</label>
						<div class="input-group col-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">
										<i class="far fa-calendar-alt"></i>
									</span>
								</div>
								<input type="text" name="tanggal_penagihan" class="form-control" id="tanggal_penagihan" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
							</div>
						</div>
					</div>
				</div>
			</div>			
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">No Tagihan</label>
						<div class="input-group col-8">
							<input type="text" name="no_tagihan" class="form-control" id="no_tagihan" required="required">
						</div>
					</div>
				</div>
			</div>
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
						<label for="caption" class="col-sm-4 col-form-label">Vendor</label>
						<div class="input-group col-8">
							<select name="vendor" class="form-control">
								<option value="">-- Select --</option>
								<?php foreach($vendor as $k => $v) {?>
									<option value="<?=$v->v_id?>"><?=$v->v_vendor_name?></option>
								<?php }?>
								
								
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-md-4 col-form-label">Tipe SO</label>
					<div class="input-group col-md-8">
						<select name="tipe_so" id="tipe_so" class="form-control">
							<option value="so">ORDER BARU</option>
							<option value="tf">TRANSFER</option>
						</select>
					</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">Catatan</label>
						<div class="input-group col-8">
							<textarea name="note" class="form-control"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">Setting Manual</label>
						<div class="input-group col-8">
							<input type="checkbox" id="setting_manual">
						</div>
						*<i>Jika ingin setting manual, centang ini</i>
					</div>
				</div>
			</div>
			<div class="row" id="company_name" hidden>
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">Nama Perusahaan</label>
						<div class="input-group col-8">
							<input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan">
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="owner" hidden>
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">Pimpinan</label>
						<div class="input-group col-8">
							<input type="text" name="pimpinan" class="form-control" id="pimpinan">
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="phone" hidden>
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">No Telp</label>
						<div class="input-group col-8">
							<input type="text" name="no_telp" class="form-control" id="no_telp">
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="add_company" hidden>
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">Alamat Perusahaan</label>
						<div class="input-group col-8">
							<textarea name="alamat_perusahaan" id="alamat_perusahaan" class="form-control"></textarea>
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