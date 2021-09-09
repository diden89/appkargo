<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/master_data/views/vendor_form_view.php
 */
?>

<form role="form" id="addVendor" autocomplete="off">
	<input type="hidden" name="action" value="store_data_vendor">
	<input type="hidden" name="mode" value="add">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="mode" value="edit">
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Nama Vendor</label>
				<div class="col-sm-8">
					<input type="text" name="v_vendor_name" class="form-control" id="vendor_name" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->v_vendor_name : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Alamat</label>
				<div class="col-sm-8">
					<textarea name="v_vendor_add" class="form-control" placeholder="Enter content"><?php echo (isset($data->v_vendor_add)) ? $data->v_vendor_add : ""; ?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Telpon</label>
				<div class="col-sm-8">
					<input type="text" name="v_vendor_phone" class="form-control" id="vendor_phone" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->v_vendor_phone : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Email</label>
				<div class="col-sm-8">
					<input type="text" name="v_vendor_email" class="form-control" id="vendor_email" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->v_vendor_email : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">					
				<label for="userFullname" class="col-sm-4 col-form-label">User Akses</label>
				<div class="col-sm-8">
					<select id="select-meal-type" name="v_akses[]" multiple="multiple" class="form-control">
					    <?php foreach ($user as $k => $v): ?>
							<?php 
							print_r($data->user_akses);
							if (in_array($v->ud_id, $data->user_akses))
							{
								echo 'true';
							}
							else
							{
								echo 'false';
							}
								$selected = '';
								if ($mode == 'edit' && $data !== FALSE && in_array($v->ud_id, $data->user_akses)) {;
							?>
								<option value="<?=$v->ud_id ?>" selected><?=$v->ud_fullname ?></option>
							<?php }else{ ?>
								<option value="<?=$v->ud_id ?>"><?=$v->ud_fullname ?></option>
							<?php } ?>
						<?php endforeach ?>
					</select>
				</div>
			</div>	
		</div>
	</div>
</form>