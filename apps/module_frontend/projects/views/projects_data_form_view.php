<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/views/similar_letters_form_letter_view.php
 */
?>

<form role="form" id="AddData" autocomplete="off">
	<input type="hidden" name="action" value="store_data_projects">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="p_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->p_id : '' ?>">
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Projects Name</label>
				<div class="col-sm-8">
					<input type="text" name="p_name" class="form-control" id="p_name" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->p_name : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Location</label>
				<div class="col-sm-8">
					<input type="text" name="p_location" class="form-control" id="p_location" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->p_location : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>	
		</div>		
	</div>
</form>