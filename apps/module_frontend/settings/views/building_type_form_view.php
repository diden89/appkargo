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

<form role="form" id="addBuilding" autocomplete="off">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="txt_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['bt_id'] : '' ?>">
	
	<div class="form-group row">
		<label for="caption" class="col-5 col-form-label">Building Type</label>
		<div class="col-7">
			<input type="text" id="txtBuildingType" name="txt_building_type" class="form-control" required="required" value="<?php echo isset($data['bt_building_type']) ? $data['bt_building_type'] : ''; ?>">
		</div>
	</div>
</form>