<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/views/dictionary_popup_modal_view.php
 */
?>

<form role="form" id="storeDataPopup" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="action" value="edit_data">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="d_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['d_id'] : '' ?>">

	<div class="form-group row">
		<label for="word" class="col-sm-4 col-form-label">Word</label>
		<div class="col-sm-8">
			<input type="text" name="d_word" class="form-control" id="word" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['d_word'] : '' ?>" required="required">
		</div>
	</div>
</form>