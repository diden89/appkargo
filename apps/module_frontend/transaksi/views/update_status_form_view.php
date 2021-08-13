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
	<input type="hidden" name="dod_id" value="" id="dod_id">
	<input type="hidden" name="no_trx" value="" id="no_trx_dod">
	<input type="hidden" name="so_id" value="" id="so_id">
	<input type="hidden" name="so_no_trx" value="" id="so_no_trx">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	<div class="row">		
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">No Trx</label>
				<div class="input-group col-8">
					<input type="text" name="no_trx" class="form-control" id="no_trx" disabled="disabled">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Update Status</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="dod_is_status" id="dod_is_status">
						<option value="">-Select-</option>
						<?php echo $sel = ($dod_is_status == 'ORDER') ? 'selected' : ''; ?>
						<option value="ORDER" <?php echo $sel = ($dod_is_status == 'ORDER') ? 'selected' : ''; ?>>ORDER</option>
						<option value="MUAT" <?php echo $sel = ($dod_is_status == 'MUAT') ? 'selected' : ''; ?>>MUAT</option>
						<option value="SELESAI" <?php echo $sel = ($dod_is_status == 'SELESAI') ? 'selected' : ''; ?>>SELESAI</option>						
					</select>
				</div>
			</div>
		</div>
	</div>
</form>