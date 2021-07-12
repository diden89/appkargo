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
	<input type="hidden" name="action" value="store_data_projects_sub">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="ps_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->ps_id : '' ?>">
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Projects</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="ps_p_id" id="txt_unit">
						<option value="">-Select-</option>
						<?php
							foreach($projects as $k => $v)
							{
								echo '<option value="'.$v->p_id.'" '.(($data->ps_p_id == $v->p_id) ? 'selected':"").'>'.$v->p_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>	
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Building Type</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="ps_bt_id" id="txt_unit">
						<option value="">-Select-</option>
						<?php
							foreach($building as $k => $v)
							{
								echo '<option value="'.$v->bt_id.'" '.(($data->ps_bt_id == $v->bt_id) ? 'selected':"").'>'.$v->bt_building_type.'</option>';
							}
						?>
					</select>
				</div>
			</div>	
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Projects Sub</label>
				<div class="col-sm-8">
					<input type="text" name="ps_name" class="form-control" id="ps_name" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->ps_name : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>	
		</div>		
	</div>
</form>