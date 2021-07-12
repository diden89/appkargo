<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/views/user_popup_modal_view.php
 */
?>

<form role="form" id="storeDataPopup" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="ud_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ud_id'] : '' ?>">
	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="username" class="col-sm-4 col-form-label">Username</label>
				<div class="col-sm-8">
					<input type="text" name="ud_username" class="form-control" id="username" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ud_username'] : '' ?>" required="required" <?php echo $mode == 'edit' ? 'readonly' : ''; ?>>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="userPassword" class="col-sm-4 col-form-label">Password</label>
				<div class="col-sm-8">
					<input type="password" name="ud_password" class="form-control" id="userPassword" <?php echo $mode == 'add' ? `required="required"` : ''; ?>>
					<?php if ($mode == 'edit'): ?>
						<small class="form-text text-success help-block">Biarkan kosong jika tidak ada perubahan</small>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label for="userFullname" class="col-sm-2 col-form-label">Name</label>
		<div class="col-sm-10">
			<input type="text" name="ud_fullname" class="form-control" id="userFullname" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ud_fullname'] : '' ?>" required="required">
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="userBirthday" class="col-sm-4 col-form-label">Birthday</label>
				<div class="col-sm-8">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" name="ud_dob_new" class="form-control" id="userBirthday" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ud_dob_new'] : '' ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="userBirthPlace" class="col-sm-4 col-form-label">Place of birth</label>
				<div class="col-sm-8">
					<input type="text" name="ud_pob" class="form-control" id="userBirthPlace" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ud_pob'] : '' ?>">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="userEmail" class="col-sm-4 col-form-label">Email</label>
				<div class="col-sm-8">
					<input type="email" name="ud_email" class="form-control" id="userEmail" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['ud_email'] : '' ?>"  required="required">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="notifFlag" class="col-sm-4 col-form-label">Notification</label>
				<div class="col-sm-8">
					<select name="ud_notif_flag" id="notifFlag" class="form-control">
						<option value="Y" <?php echo $mode == 'edit' && $data !== FALSE && $data['ud_notif_flag'] == 'Y' ? 'selected' : '' ?>>Yes</option>
						<option value="N" <?php echo $mode == 'edit' && $data !== FALSE && $data['ud_notif_flag'] == 'N' ? 'selected' : '' ?>>No</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="form-group row">
		<div class="col-md-6">
			<div class="row">
				<label for="userGroup" class="col-sm-4 col-form-label">Access Group</label>
				<div class="col-sm-8">
					<select name="usg_group" id="userGroup" class="form-control">
						<option value="">Select Group</option>
						<?php foreach ($user_group as $k => $v): ?>
							<?php 
								$selected = '';
								if ($mode == 'edit' && $data !== FALSE && $v->ug_id == $data['usg_group']) $selected = 'selected';
							?>
							<option value="<?= $v->ug_id ?>" <?php echo $selected; ?>><?= $v->ug_caption ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<label for="userSubGroup" class="col-sm-4 col-form-label">Access Sub Group</label>
				<div class="col-sm-8">
					<select name="ud_sub_group" id="userSubGroup" class="form-control" disabled required="required">
						<option value="">Select Sub Group First</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label for="userEmail" class="col-sm-2 col-form-label">Avatar</label>
		<div class="col-sm-10">
			<div class="input-group">
				<div class="custom-file">
					<input type="file" class="custom-file-input" id="fileAvatar" name="file_avatar">
					<label class="custom-file-label" for="fileAvatar"><?php echo $mode == 'edit' && $data !== FALSE ? $data['ud_img_ori'] : 'Choose Image' ?></label>
				</div>
			</div>
			<small class="text-danger font-italic">Leave blank when no changes are made.</small>
		</div>
	</div>
</form>