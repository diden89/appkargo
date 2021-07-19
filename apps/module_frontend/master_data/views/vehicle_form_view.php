<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/master_data/views/vehicle_form_view.php
 */
?>

<form role="form" id="addVehicle" autocomplete="off">
	<input type="hidden" name="action" value="store_data_vehicle">
	<input type="hidden" name="mode" value="add">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="mode" value="edit">
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Plat Nomor Kendaraan</label>
				<div class="col-sm-8">
					<input type="text" name="ve_license_plate" class="form-control" id="license_plate" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->ve_license_plate : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Jenis Kendaraan</label>
				<div class="col-sm-8">
					<textarea name="ve_name" class="form-control" placeholder="Enter content"><?php echo (isset($data->ve_name)) ? $data->ve_name : ""; ?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Status Kepemilikan</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="il_vendor_id" id="txt_unit">
						<option value="">-Select-</option>
						<?php
							// foreach($status as $k => $v)
							// {
							// 	echo '<option value="'.$v->v_id.'" '.(($data->il_vendor_id == $v->v_id) ? 'selected':"").'>'.$v->v_vendor_name.'</option>';
							// }
						?>
						<option value='1'>Milik Sendiri</option>
						<option value='2'>Rekanan</option>
					</select>
				</div>
			</div>
		</div>		
	</div>
</form>