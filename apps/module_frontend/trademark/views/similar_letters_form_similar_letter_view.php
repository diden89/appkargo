<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/views/similar_letters_form_similar_letter_view.php
 */
?>

<form role="form" id="formSimilarLetter" autocomplete="off">
	<input type="hidden" name="action" value="store_data_similar_letter">
	<input type="hidden" name="txt_id_letter" value="<?php echo $txt_id_letter; ?>">

	<?php if (isset($mode) && $mode == 'edit'): ?>
		<input type="hidden" name="mode" value="edit">
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	<div class="form-group row">
		<label for="caption" class="col-5 col-form-label">Similar Letter</label>
		<div class="col-7">
			<input type="text" id="txtSimilarLetterForm" name="txt_similar_letter" class="form-control" required="required" value="<?php echo (isset($txt_letter) ? $txt_letter : ''); ?>">
		</div>
	</div>
</form>