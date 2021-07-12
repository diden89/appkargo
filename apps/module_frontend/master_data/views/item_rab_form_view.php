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
	<input type="hidden" name="txt_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ir_id'] : '' ?>">
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Item Name</label>
				<div class="col-sm-8">
					<input type="text" name="ir_item_name" class="form-control" id="item_name" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ir_item_name'] : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Sequence</label>
				<div class="col-sm-8">
					<input type="text" name="ir_seq" class="form-control" id="seq" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ir_seq'] : '' ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Unit</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="ir_un_id" id="txt_unit">
						<option value="">-Select-</option>
						<?php
							foreach($option as $k => $v)
							{
								echo '<option value="'.$v->un_id.'" '.(($data['ir_un_id'] == $v->un_id) ? 'selected':"").'>'.$v->un_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>		
		</div>		
	</div>
</form>