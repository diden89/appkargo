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
	<input type="hidden" name="mode" value="<?=$mode?>">
	<input type="hidden" name="last_notrx" value="<?php echo $mode == 'add' ?  $last_notrx.'/SO/'.date('Ymd') : $data->so_no_trx; ?>">
	<input type="hidden" name="sod_id" value="" id="sod_id">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	<div class="row">		
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">No Transaksi</label>
				<div class="col-sm-8">
					<input type="text" name="so_no_trx" class="form-control" id="no_trx_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->so_no_trx : $last_notrx.'/SO/'.date('Ymd'); ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?> disabled>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">No Transaksi SO</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="txt_so" id="txt_so">
						<option value="">-Select-</option>
						<?php
							foreach($sales_order as $k => $v)
							{
								echo '<option value="'.$v->so_id.'" '.(($data->sod_no_trx == $v->so_no_trx) ? 'selected':"").'>'.$v->so_no_trx.'</option>';
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
		<!-- <div class="col-md-6">
			<div class="form-group row district">
				<label for="url" class="col-sm-4 col-form-label">Kabupaten/Kota</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="txt_region" id="txt_region" disabled>
						<option value="">Pilih Provinsi</option>
					</select>
				</div>
			</div>
		</div> -->
	</div>
	<div class="row">
		<!-- <div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Vendor</label>
				<div class="col-sm-8">
				<select class="form-control select2"  name="v_vendor_id" id="v_vendor_id">
					<option value="">-Select-</option>
					<?php
						// foreach($vendor as $k => $v)
						// {
						// 	echo '<option value="'.$v->v_id.'" '.(($data->so_vendor_id == $v->v_id) ? 'selected':"").'>'.$v->v_vendor_name.'</option>';
						// }
					?>
				</select>
				</div>
			</div>
		</div> -->
	</div>
	<hr>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Detail SO</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="detail_so" id="detail_so" disabled="disabled">
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Nama Item</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="il_id" id="il_id" disabled="disabled">
						<!-- <option value="">-Select-</option> -->
						<?php
							// foreach($item_list as $k => $v)
							// {
							// 	echo '<option value="'.$v->il_id.'" >'.$v->il_item_name.'</option>';
							// }
						?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">No Trx DO</label>
				<div class="col-sm-8">
					<input type="text" name="no_trx_do" class="form-control" id="no_trx_do" value="" >
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Berat / Kg</label>
				<div class="col-sm-8">
					<input type="text" name="sod_qty" class="form-control" id="sod_qty" value="" >
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
					<button id="btnAddDetail" class="btn btn-primary btn-flat" type="button" title="Add Data"><i class="fas fa-plus"></i> Add</button>
				</div>
			</div>
		</div>	
		<div class="col-md-8">
			<div class="excel-data-table-container">
				<table id="temporaryDataTable" style="width:  1480px;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="wordDataTable_info">
					<thead>
						<tr role="row">
							<th width="150">No Trx</th>
							<th width="150">Nama Pelanggan</th>
							<th width="120">Nama Barang</th>
							<th width="200">Pengemudi / Kendaraan</th>
							<th width="300">Alamat Pengiriman</th>
							<th width="150">Berat / Kg</th>
							<th width="50">Biaya</th>
							<th width="200">Tanggal Pengiriman</th>
							<th width="100">Status</th>
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