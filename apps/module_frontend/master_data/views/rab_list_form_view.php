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

<form role="form" id="addItem" autocomplete="off">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="txt_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['id'] : '' ?>">
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Work</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="rl_ir_id" id="txt_work">
						<option value="">-Select-</option>
						<?php
							foreach($option_rab as $k => $v)
							{
								echo '<option value="'.$v->ir_id.'" '.(($data['rl_ir_id'] == $v->ir_id) ? 'selected':"").'>'.$v->ir_item_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>	
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Material</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="rl_il_id" id="txt_material">
						<option value="">-Select-</option>
						<?php
							foreach($option_item as $k => $v)
							{
								echo '<option value="'.$v->il_id.'" '.(($data['rl_il_id'] == $v->il_id) ? 'selected':"").'>'.$v->il_item_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>	
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Volume</label>
				<div class="col-sm-8">
					<input type="text" name="rl_volume" class="form-control" id="vol" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['volume'] : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Unit</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="rl_un_id" id="txt_unit">
						<option value="">-Select-</option>
						<?php
							foreach($option_unit as $k => $v)
							{
								echo '<option value="'.$v->un_id.'" '.(($data['rl_un_id'] == $v->un_id) ? 'selected':"").'>'.$v->un_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>		
		</div>		
	</div>
</form>