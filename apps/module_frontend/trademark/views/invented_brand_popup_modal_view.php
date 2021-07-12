<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/views/invented_brand_popup_modal_view.php
 */
?>

<form role="form" id="storeDataPopup" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="ib_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_id'] : '' ?>">

	<!-- <?php if ($mode == 'edit'): ?>
		<div class="form-group row">
			<label for="InventedBrandId" class="col-sm-4 col-form-label">Id</label>
			<div class="col-sm-8">
				<input type="text" name="ib_id" class="form-control" id="InventedBrandId" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_id'] : '' ?>" readonly>
			</div>
		</div>
	<?php endif ?> -->

	<div class="form-group row">
		<label for="appNumber" class="col-sm-4 col-form-label">Application number</label>
		<div class="col-sm-8">
			<input type="text" name="ib_app_number" class="form-control" id="appNumber" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_app_number'] : '' ?>" required="required">
		</div>
	</div>

	<div class="form-group row">
		<label for="receiveDate" class="col-sm-4 col-form-label">Receive date</label>
		<div class="col-sm-8">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">
						<i class="far fa-calendar-alt"></i>
					</span>
				</div>
				<input type="text" name="ib_receive_date" class="form-control" id="receiveDate" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_receive_date_new'] : '' ?>">
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label for="priority" class="col-sm-4 col-form-label">Priority</label>
		<div class="col-sm-8">
			<input type="text" name="ib_priority" class="form-control" id="priority" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_priority'] : '' ?>">
		</div>
	</div>

	<div class="form-group row">
		<label for="ownerName" class="col-sm-4 col-form-label">Owner name</label>
		<div class="col-sm-8">
			<input type="text" name="ib_owner_name" class="form-control" id="ownerName" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_owner_name'] : '' ?>" required="required">
		</div>
	</div>

	<div class="form-group row">
		<label for="ownerAddress" class="col-sm-4 col-form-label">Owner address</label>
		<div class="col-sm-8">
			<textarea class="form-control" name="ib_owner_address" class="form-control" id="ownerAddress" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_owner_address'] : '' ?></textarea>
		</div>
	</div>

	<div class="form-group row">
		<label for="lawyerName" class="col-sm-4 col-form-label">Lawyer name</label>
		<div class="col-sm-8">
			<input type="text" name="ib_lawyer_name" class="form-control" id="lawyerName" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_lawyer_name'] : '' ?>">
		</div>
	</div>

	<div class="form-group row">
		<label for="lawyerAddress" class="col-sm-4 col-form-label">Lawyer address</label>
		<div class="col-sm-8">
			<textarea class="form-control" name="ib_lawyer_address" class="form-control" id="lawyerAddress" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_lawyer_address'] : '' ?></textarea>
		</div>
	</div>

	<div class="form-group row">
		<label for="InventedBrandName" class="col-sm-4 col-form-label">Brand</label>
		<div class="col-sm-8">
			<input type="text" name="ib_name" class="form-control" id="InventedBrandName" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_name'] : '' ?>" required="required">
		</div>
	</div>

	<div class="form-group row">
		<label for="meaningOfLanguange" class="col-sm-4 col-form-label">Meaning of foreign languages/Letters/Numbers</label>
		<div class="col-sm-8">
			<input type="text" name="ib_meaning_of_language" class="form-control" id="meaningOfLanguange" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_meaning_of_language'] : '' ?>">
		</div>
	</div>

	<div class="form-group row">
		<label for="colorDescription" class="col-sm-4 col-form-label">Color Description</label>
		<div class="col-sm-8">
			<textarea class="form-control" name="ib_color_description" class="form-control" id="colorDescription" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_color_description'] : '' ?></textarea>
		</div>
	</div>

	<div class="form-group row">
		<label for="classOfGoodOrServices" class="col-sm-4 col-form-label">Class of goods/services</label>
		<div class="col-sm-8">
			<input type="text" name="ib_class_of_good_or_services" class="form-control" id="classOfGoodOrServices" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_class_of_good_or_services'] : '' ?>">
		</div>
	</div>

	<div class="form-group row">
		<label for="descOfGoodOrServices" class="col-sm-4 col-form-label">Description of goods/services</label>
		<div class="col-sm-8">
			<textarea class="form-control" name="ib_desc_of_good_or_services" class="form-control" id="descOfGoodOrServices" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['ib_desc_of_good_or_services'] : '' ?></textarea>
		</div>
	</div>
</form>