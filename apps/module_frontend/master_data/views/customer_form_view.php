<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/master_data/views/customer_form_view.php
 */
?>

<form role="form" id="addCustomer" autocomplete="off">
	<input type="hidden" name="action" value="store_data_customer">
	<input type="hidden" name="mode" value="add">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="mode" value="edit">
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Nama Pelanggan</label>
				<div class="col-sm-8">
					<input type="text" name="c_name" class="form-control" id="vendor_name" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->c_name : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Provinsi</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="txt_province" id="txt_province">
						<option value="">-Select-</option>
						<?php
							foreach($province as $k => $v)
							{
								echo '<option value="'.$v->rp_id.'" '.(($data->rp_id == $v->rp_id) ? 'selected':"").'>'.$v->rp_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group row district">
				<label for="url" class="col-sm-4 col-form-label">Kabupaten/Kota</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="txt_region" id="txt_region" disabled>
						<option value="">Pilih Provinsi</option>
					</select>
				</div>
			</div>

			<div class="form-group row district">
				<label for="url" class="col-sm-4 col-form-label">Kecamatan</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="c_district_id" id="txt_district" disabled>
						<option value="">Pilih Kabupaten / Kota</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Alamat</label>
				<div class="col-sm-8">
					<textarea name="c_address" class="form-control" placeholder="Enter content"><?php echo (isset($data->c_address)) ? $data->c_address : ""; ?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Telpon</label>
				<div class="col-sm-8">
					<input type="text" name="c_phone" class="form-control" id="vendor_phone" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->c_phone : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Email</label>
				<div class="col-sm-8">
					<input type="text" name="c_email" class="form-control" id="vendor_email" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->c_email : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
		</div>		
	</div>
</form>