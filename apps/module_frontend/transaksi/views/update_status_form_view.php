<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/transaksi/views/update_status_form_view.php
 */
?>

<form role="form" id="addDaftarSalesOrder" autocomplete="off">
	<input type="hidden" name="action" value="store_update_status">
	<input type="hidden" name="mode" value="<?=$mode?>" id="mode">
	<input type="hidden" name="dod_id" value="<?=$data->dod_id?>" id="dod_id" >
	<input type="hidden" name="no_trx" value="<?=$data->dod_no_trx?>" id="no_trx_dod">
	<input type="hidden" name="so_id" value="<?=$data->so_id?>" id="so_id">
	<input type="hidden" name="so_no_trx" value="<?=$data->so_no_trx?>" id="so_no_trx">
	<input type="hidden" name="shipping" value="<?=$data->c_shipping_area?>" id="shipping">
	<input type="hidden" name="total_ongkir_upd_hidden" value="<?=$data->dos_ongkir?>" id="total_ongkir_upd_hidden">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	<div class="row">		
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-md-4 col-form-label">No Trx</label>
				<div class="input-group col-md-8">

					<input type="text" name="no_trx" class="form-control" id="no_trx" disabled="disabled" value="<?=$data->dod_no_trx?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-md-4 col-form-label">Total Order</label>
				<div class="input-group col-md-8">
					<input type="text" name="total_order" class="form-control" id="total_order" disabled="disabled" value="<?=number_format($data->dod_shipping_qty)?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-md-4 col-form-label">Jumlah Terima</label>
				<div class="input-group col-md-8">
					<input type="text" name="total_terpenuhi" class="form-control" id="total_terpenuhi" required>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-md-4 col-form-label">Total Ongkir</label>
				<div class="input-group col-md-8">
					<input type="text" name="total_ongkir_upd" class="form-control" id="total_ongkir_upd" disabled>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-md-4 col-form-label">Keterangan</label>
				<div class="input-group col-md-8">
					<textarea name="keterangan" class="form-control" placeholder="Enter content"></textarea>
				</div>
			</div>
		</div>
	</div>
</form>