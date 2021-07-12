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

<form role="form" id="addWord" autocomplete="off">
	<input type="hidden" name="action" value="store_data_word">

	<?php if (isset($txt_word)): ?>
		<input type="hidden" name="mode" value="edit">
		<input type="hidden" name="txt_id" value="<?php echo $txt_id; ?>">
	<?php endif; ?>
	
	<div class="form-group row">
		<label for="caption" class="col-3 col-form-label">Words</label>
		<div class="col-9">
			<input type="text" id="txtWord" name="txt_word" class="form-control" required="required" value="<?php echo isset($txt_word) ? $txt_word : ''; ?>">
		</div>
	</div>
</form>