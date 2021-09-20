<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/settings/views/template_laporan_form_view.php
 */
?>

<form role="form" id="addVendor" autocomplete="off">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="add">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="mode" value="edit">
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">					
				<label for="userFullname" class="col-sm-4 col-form-label">Vendor</label>
				<div class="col-sm-8">
					<select name="v_id" class="form-control">
					    <?php foreach ($vendor as $k => $v){ 
					    	$sel = ($temp->tl_vendor_id == $v->v_id) ? 'selected' : '';
					    	?>
							<option value="<?=$v->v_id ?>" <?=$sel?>><?=$v->v_vendor_name ?></option>
						<?php } ?>
					</select>
				</div>
			</div>	
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Nama Template</label>
				<div class="col-sm-8">
					<input type="text" name="tl_name" class="form-control" id="tl_name" value="<?php echo $mode == 'edit' && $temp !== FALSE ? $temp->tl_name : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Template File</label>
				<div class="col-sm-8">
					<input type="text" name="tl_file_template" class="form-control" id="tl_file_template" value="<?php echo $mode == 'edit' && $temp !== FALSE ? $temp->tl_file_template : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?> disabled>
				</div>
			</div>
		</div>
	</div>
</form>