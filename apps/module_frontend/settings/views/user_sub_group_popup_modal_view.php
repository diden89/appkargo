<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/views/user_popup_modal_view.php
 */
?>

<form role="form" id="storeDataPopup" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<?php if ($mode == 'edit'): ?>		
		<input type="hidden" name="usg_id" class="form-control" id="userGroupId" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['usg_id'] : '' ?>" readonly>			
	<?php endif ?>
	<div class="form-group row">
		<label for="userSubGroup" class="col-sm-4 col-form-label">User Group</label>
		<div class="col-sm-8">
			<select name="ug_id" id="group" class="form-control">
				<option value="">-- Select Group --</option>
				<?php foreach ($user_group as $k => $v): ?>
					
					<?php 
						$selected = '';
						if ($mode == 'edit' && $data !== FALSE && $v->ug_id == $data['usg_group']) $selected = 'selected';
						// if ($mode == 'add' && $v->ug_id == 3) $selected = 'selected';
					?>

					<option value="<?= $v->ug_id ?>" <?php echo $selected; ?>><?= $v->ug_caption ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="caption" class="col-sm-4 col-form-label">User Sub Group</label>
		<div class="col-sm-8">
			<input type="text" name="usg_caption" class="form-control" id="caption" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['usg_caption'] : '' ?>" required="required">
		</div>
	</div>

	<div class="form-group row">
		<label for="desription" class="col-sm-4 col-form-label">Description</label>
		<div class="col-sm-8">
			<textarea name="usg_description" class="textarea" placeholder="Enter content" style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $mode == 'edit' && $data !== FALSE ? $data['usg_description'] : '' ?></textarea>
		
		</div>
	</div>
</form>