<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package Merk Dagang
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /merkdagang/apps/module_frontend/settings/views/user_popup_modal_view.php
 */
?>
<form role="form" id="storeDataPopup" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="txt_id_menu" id="txt_id_menu" value="<?php echo (isset($data->rm_id)) ? $data->rm_id : ""; ?>">
	<input type="hidden" name="txt_id_parent" id="txt_id_parent" value="<?php echo (isset($data->rm_parent_id)) ? $data->rm_parent_id : ""; ?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Caption</label>
				<div class="col-sm-8">
					<input type="text" name="rm_caption" class="form-control" id="caption" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->rm_caption : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="description" class="col-sm-4 col-form-label">Description</label>
				<div class="col-sm-8">
					<textarea name="rm_description" class="form-control" placeholder="Enter content"><?php echo (isset($data->rm_description)) ? $data->rm_description : ""; ?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">URL</label>
				<div class="col-sm-8">
					<input type="text" name="rm_url" class="form-control" id="url" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->rm_url : '' ?>" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>		
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="icon" class="col-sm-4 col-form-label">Icon</label>
				<div class="col-sm-8">
					<input type="text" name="rm_icon" class="form-control" id="icon" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->rm_icon : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="sequence" class="col-sm-4 col-form-label">Sequence</label>
				<div class="col-sm-8">
					<input type="text" name="rm_sequence" class="form-control" id="sequence" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->rm_sequence : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="parent_menu" class="col-sm-4 col-form-label">Parent Menu</label>
				<div class="col-sm-8">
					<select class="form-control select2 "  name="txt_parent_id" id="txt_parent_id">
						<option value="">--Please Select Menu--</option>
						<?=$option?>
					</select>
				</div>
			</div>		
		</div>			
	</div>
</form>