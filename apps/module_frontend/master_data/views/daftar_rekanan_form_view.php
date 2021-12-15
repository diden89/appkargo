<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/master_data/views/daftar_rekanan_form_view.php
 */
?>

<form role="form" id="addRekanan" autocomplete="off">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="add">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="mode" value="edit">
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Kode Rekanan</label>
				<div class="col-sm-8">
					<input type="text" name="kode_rekanan" class="form-control" id="kode_rekanan" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->pr_code : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Nama Rekanan</label>
				<div class="col-sm-8">
					<input type="text" name="rekanan_name" class="form-control" id="rekanan_name" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->pr_name : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Telpon</label>
				<div class="col-sm-8">
					<input type="text" name="pr_phone" class="form-control" id="pr_phone" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->pr_phone : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Email</label>
				<div class="col-sm-8">
					<input type="email" name="pr_email" class="form-control" id="pr_email" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->pr_email : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Kendaraan</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="pr_vehicle_id" id="pr_vehicle_id">
						<option value="">-Select-</option>
						<?php
							foreach($vehicle as $k => $v)
							{
								echo '<option value="'.$v->ve_id.'" '.(($data->pr_vehicle_id) == $v->ve_id ? 'selected':"").'>'.$v->ve_license_plate.'</option>';
							}
						?>
					</select>
				</div>
			</div>	
			<hr>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">User Login</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="txt_user_id" id="txt_user_id">
						<option value="">-Select-</option>
						<?php
							foreach($user_detail as $k => $v)
							{
								echo '<option value="'.$v->ud_id.'" '.(($data->pr_ud_id) == $v->ud_id ? 'selected':"").'>'.$v->ud_username.'</option>';
							}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>	
</form>