<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/transaksi/views/daftar_delivery_order_form_view.php
 */
?>

<form role="form" id="addDaftarSalesOrder" autocomplete="off">
	<input type="hidden" name="action" value="store_data_daftar_sales_order">
	<input type="hidden" name="mode" value="<?=$mode?>" id="mode">
	<input type="hidden" name="last_notrx" value="<?php echo $mode == 'add' ?  $last_notrx.'/SO/'.date('Ymd') : $data->so_no_trx; ?>">
	<input type="hidden" name="sod_id" value="" id="sod_id">
	<input type="hidden" name="so_id" value="" id="so_id">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
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
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Transportasi</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="dod_vehicle_id" id="dod_vehicle_id" disabled="disabled">
						<option value="">-Select-</option>
						<?php
							foreach($vehicle as $k => $v)
							{
								echo '<option value="'.$v->ve_id.'" '.(($dod_vehicle_id == $v->ve_id) ? 'selected':"").'>'.$v->ve_license_plate.'</option>';
							}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		
		<div class="col-md-6">
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">No Transaksi SO</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="txt_sales_order" id="txt_sales_order">
						<option value="">-Select-</option>
						<?php
							foreach($sales_order as $k => $v)
							{
								echo '<option value="'.$v->so_id.'" '.(($so_no_trx == $v->so_no_trx) ? 'selected':"").'>'.$v->so_no_trx.'</option>';
							}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Pengemudi</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="dod_driver_id" id="dod_driver_id" disabled="disabled">
						<option value="">-Select-</option>
						<?php
							foreach($driver as $k => $v)
							{
								echo '<option value="'.$v->d_id.'" '.(($dod_driver_id == $v->d_id) ? 'selected':"").'>'.$v->d_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">No Trx DO</label>
				<div class="col-sm-8">
					<input type="text" name="no_trx_do" class="form-control" id="no_trx_do" value="" disabled="disabled">
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Detail SO</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="detail_sales_order" id="detail_sales_order" disabled="disabled">
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Nama Pelanggan</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="c_id" id="c_id" disabled="disabled">
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Berat / Kg</label>
				<div class="col-sm-4">
					<input type="text" name="sod_shipping_qty" class="form-control" id="sod_shipping_qty" value="" >
				</div>
				<div class="col-sm-1">
					/
				</div>
				<div class="col-sm-3">
					<input type="text" name="sod_qty" class="form-control" id="sod_qty" value="" disabled="disabled">
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Ongkir</label>
				<div class="col-sm-8">
					<input type="text"  class="form-control" id="dod_ongkir_temp" value="" disabled="disabled">
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Total Ongkir</label>
				<div class="col-sm-8">
					<input type="text" name="dod_ongkir" class="form-control" id="dod_ongkir" value="" >
					<input type="hidden"  class="form-control" id="dod_ongkir_temp2" value="">
				</div>
			</div>
			<!-- <div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Keterangan</label>
				<div class="col-sm-8">
					<textarea name="c_address" class="form-control" placeholder="Enter content"><?php echo (isset($data->c_address)) ? $data->c_address : ""; ?></textarea>
				</div>
			</div> -->
			
			<div class="form-group row">
				<div class="col-sm-8">
					<button id="btnAddDetail" class="btn btn-primary btn-flat" type="button" title="Add Data" disabled="disabled"><i class="fas fa-plus"></i> Add</button>
				</div>
			</div>
		</div>	
		<div class="col-md-8">
			<div class="excel-data-table-container">
				<table id="temporaryDataTable" style="width:  200%;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="wordDataTable_info">
					<thead>
						<tr role="row">
							<th width="10">No</th>
							<th>No Transaksi</th>
							<th>Nama Pelanggan</th>
							<th>Nama Barang</th>
							<th>Pengemudi / Kendaraan</th>
							<th >Alamat Pengiriman</th>
							<th>Berat / Kg</th>
							<th>Biaya</th>
							<th>Tanggal Pengiriman</th>
							<th>Status</th>
							<th width="100">Action</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>	
	</div>
</form>