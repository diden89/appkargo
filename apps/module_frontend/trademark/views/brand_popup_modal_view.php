<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/views/brand_popup_modal_view.php
 */
?>

<form role="form" id="storeDataPopup" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="br_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_id'] : '' ?>">

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="appNumber" class="col-sm-4 col-form-label">Application number</label>
				<div class="col-sm-8">
					<input type="text" name="br_app_number" class="form-control" id="appNumber" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_app_number'] : '' ?>" required="required">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="receiveDate" class="col-sm-4 col-form-label">Receive date</label>
				<div class="col-sm-8">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" name="br_receive_date" class="form-control" id="receiveDate" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_receive_date_new'] : '' ?>">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="brandName" class="col-sm-4 col-form-label">Brand</label>
				<div class="col-sm-8">
					<input type="text" name="br_name" class="form-control" id="brandName" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_name'] : '' ?>" required="required">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="priority" class="col-sm-4 col-form-label">Priority</label>
				<div class="col-sm-8">
					<input type="text" name="br_priority" class="form-control" id="priority" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_priority'] : '' ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="ownerName" class="col-sm-4 col-form-label">Owner name</label>
				<div class="col-sm-8">
					<input type="text" name="br_owner_name" class="form-control" id="ownerName" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_owner_name'] : '' ?>" required="required">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="lawyerName" class="col-sm-4 col-form-label">Lawyer name</label>
				<div class="col-sm-8">
					<input type="text" name="br_lawyer_name" class="form-control" id="lawyerName" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_lawyer_name'] : '' ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="ownerAddress" class="col-sm-4 col-form-label">Owner address</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="br_owner_address" class="form-control" id="ownerAddress" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['br_owner_address'] : '' ?></textarea>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="lawyerAddress" class="col-sm-4 col-form-label">Lawyer address</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="br_lawyer_address" class="form-control" id="lawyerAddress" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['br_lawyer_address'] : '' ?></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="classOfGoodOrServices" class="col-sm-4 col-form-label">Class of goods/services</label>
				<div class="col-sm-8">
					<input type="text" name="br_class_of_good_or_services" class="form-control" id="classOfGoodOrServices" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_class_of_good_or_services'] : '' ?>">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="brandStatus" class="col-sm-4 col-form-label">Status</label>
				<div class="col-sm-8">
					<input type="text" name="br_status" class="form-control" id="brandStatus" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_status'] : '' ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="descOfGoodOrServices" class="col-sm-4 col-form-label">Description goods/services</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="br_desc_of_good_or_services" class="form-control" id="descOfGoodOrServices" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['br_desc_of_good_or_services'] : '' ?></textarea>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="colorDescription" class="col-sm-4 col-form-label">Color Description</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="br_color_description" class="form-control" id="colorDescription" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['br_color_description'] : '' ?></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="brandReminder" class="col-sm-4 col-form-label">Reminder</label>
				<div class="col-sm-8">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" name="br_reminder" class="form-control" id="brandReminder" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_reminder_new'] : '' ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="regNumber" class="col-sm-4 col-form-label">Registration Number</label>
				<div class="col-sm-8">
					<input type="text" name="br_reg_number" class="form-control" id="regNumber" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_reg_number'] : '' ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="expiryDate" class="col-sm-4 col-form-label">Expiry Date</label>
				<div class="col-sm-8">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" name="br_expiry_date" class="form-control" id="expiryDate" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_expiry_date_new'] : '' ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="contactPerson" class="col-sm-4 col-form-label">Contact Person</label>
				<div class="col-sm-8">
					<input type="text" name="br_contact_person" class="form-control" id="contactPerson" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_contact_person'] : '' ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="brandDesxription" class="col-sm-4 col-form-label">Description</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="br_description" class="form-control" id="brandDesxription" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['br_description'] : '' ?></textarea>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="historyStatus" class="col-sm-4 col-form-label">History Status</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="br_history_status" class="form-control" id="historyStatus" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['br_history_status'] : '' ?></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="lastClientUpdate" class="col-sm-4 col-form-label">last Client Update</label>
				<div class="col-sm-8">
					<input type="text" name="br_last_client_update" class="form-control" id="lastClientUpdate" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_last_client_update'] : '' ?>">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="historyClientUpdate" class="col-sm-4 col-form-label">History Client Update</label>
				<div class="col-sm-8">
					<textarea class="form-control" name="br_history_client_update" class="form-control" id="historyClientUpdate" rows="3"><?php echo $mode == 'edit' && $data !== FALSE ? $data['br_history_client_update'] : '' ?></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="brandFee" class="col-sm-4 col-form-label">Fee</label>
				<div class="col-sm-8">
					<input type="text" name="br_fee" class="form-control" id="brandFee" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_fee'] : '' ?>">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="brandBill" class="col-sm-4 col-form-label">Bill</label>
				<div class="col-sm-8">
					<input type="text" name="br_bill" class="form-control" id="brandBill" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_bill'] : '' ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="paymentStatus" class="col-sm-4 col-form-label">Payment Status</label>
				<div class="col-sm-8">
					<input type="text" name="br_payment_status" class="form-control" id="paymentStatus" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_payment_status'] : '' ?>">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="brandImg" class="col-sm-4 col-form-label">Logo</label>
				<div class="col-sm-8">
					<input type="text" name="br_img" class="form-control" id="brandImg" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_img'] : '' ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label for="brandDocument" class="col-sm-4 col-form-label">Document</label>
		<div class="col-sm-8">
			<input type="text" name="br_document" class="form-control" id="brandDocument" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_document'] : '' ?>">
		</div>
	</div>

	<div class="form-group row">
		<label for="additionalDocument" class="col-sm-4 col-form-label">Additional Document</label>
		<div class="col-sm-8">
			<input type="text" name="br_additional_document" class="form-control" id="additionalDocument" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_additional_document'] : '' ?>">
		</div>
	</div>

	<div class="form-group row">
		<label for="brandCertificate" class="col-sm-4 col-form-label">Certificate</label>
		<div class="col-sm-8">
			<input type="text" name="br_certificate" class="form-control" id="brandCertificate" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_certificate'] : '' ?>">
		</div>
	</div>

	<div class="form-group row">
		<label for="meaningOfLanguange" class="col-sm-4 col-form-label">Meaning of foreign languages/Letters/Numbers</label>
		<div class="col-sm-8">
			<input type="text" name="br_meaning_of_language" class="form-control" id="meaningOfLanguange" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['br_meaning_of_language'] : '' ?>">
		</div>
	</div>
</form>