<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/transaksi/views/Daftar_pembayaran_sales_order_form_view.php
 */
?>

<form role="form" id="addDaftarSalesOrder" autocomplete="off">
	<input type="hidden" name="action" value="store_data_daftar_pembayaran_sales_order">
	<input type="hidden" name="mode" value="<?=$mode?>">
	<input type="hidden" name="last_notrx" value="<?php echo $mode == 'add' ?  $last_notrx : $data->so_no_trx; ?>">
	<input type="hidden" name="total_amount_st" id="total_amount_st">
	
	<?php if (isset($sop_id)): ?>
		<input type="hidden" name="sop_id" value="<?php echo $sop_id; ?>">
	<?php endif; ?>
	<div class="row">		
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">No Transaksi</label>
				<div class="col-sm-8">
					<input type="text" name="so_no_trx" class="form-control" id="no_trx_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->so_no_trx : $last_notrx; ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?> disabled>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Kode Akun</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="co_rad_id" id="co_rad_id" required="required">
						<option value="">-Select-</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Tanggal</label>
				<div class="input-group col-8">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" name="so_created_date" class="form-control" id="created_date" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row district">
				<label for="url" class="col-sm-4 col-form-label">Cara Bayar</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="sop_type_pay" id="sop_type_pay" required="required">
						<option value="">--Cara Bayar--</option>
						<option value="TUNAI">TUNAI</option>
						<option value="TRANSFER">TRANSAFER</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Vendor</label>
				<div class="col-sm-8">
				<select class="form-control select2"  name="v_vendor_id" id="v_vendor_id">
					<option value="">-Select-</option>
				</select>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table id="temporaryDataTable" style="width: 100%;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="wordDataTable_info">
				<thead>
					<tr role="row">
						<th width="10">No</th>
						<th>No Transaksi</th>
						<th>Nama Vendor</th>
						<th>Berat / Kg</th>
						<th>Total Ongkir</th>
						<th></th>
						<th>Total Bayar</th>
						<th>Tujuan</th>
						<th>Tanggal Pengiriman</th>
						<!-- <th width="100">Action</th> -->
					</tr>
				</thead>
				<tbody>
					
				</tbody>
				<tfoot>
					<th colspan="6">Total :</th>
					<th id="total_amount"></th>
				</tfoot>
			</table>
		</div>	
	</div>
</form>