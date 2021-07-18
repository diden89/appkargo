<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/master_data/views/item_list_form_view.php
 */
?>

<form role="form" id="addItem" autocomplete="off">
	<input type="hidden" name="action" value="store_data_item">
	<input type="hidden" name="mode" value="add">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="mode" value="edit">
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Kode Item</label>
				<div class="col-sm-8">
					<input type="text" name="il_item_code" class="form-control" id="item_code" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->il_item_code : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Nama Item</label>
				<div class="col-sm-8">
					<input type="text" name="il_item_name" class="form-control" id="item_name" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->il_item_name : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Vendor</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="il_vendor_id" id="txt_unit">
						<option value="">-Select-</option>
						<?php
							foreach($vendor as $k => $v)
							{
								echo '<option value="'.$v->v_id.'" '.(($data->il_vendor_id == $v->v_id) ? 'selected':"").'>'.$v->v_vendor_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Unit</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="il_un_id" id="txt_unit">
						<option value="">-Select-</option>
						<?php
							foreach($option as $k => $v)
							{
								echo '<option value="'.$v->un_id.'" '.(($data->il_un_id == $v->un_id) ? 'selected':"").'>'.$v->un_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>		

		</div>		
	</div>
</form>