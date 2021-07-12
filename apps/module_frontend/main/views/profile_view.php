<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/main/views/profile_view.php
 */
?>
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Biodata</h3>
			</div>
			<form role="form" id="form1" action="<?php echo site_url('main/profile_store_data/1'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
				<div class="card-body">
					<div class="form-group">
						<label for="txtFullname">Fullname</label>
						<input type="text" class="form-control" name="txt_fullname" id="txtFullname" placeholder="Write full name" required="required" value="<?php echo $data['ud_fullname']; ?>">
					</div>
					<div class="form-group">
						<label for="txtPob">Place of birth</label>
						<input type="text" class="form-control" name="txt_pob" id="txtPob" placeholder="Write the place of birth" required="required" value="<?php echo $data['ud_pob']; ?>">
					</div>
					<div class="form-group">
						<label for="txtDob">Birthday</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="far fa-calendar-alt"></i>
								</span>
							</div>
							<input type="text" class="form-control float-right" name="txt_dob" id="txtDob" required="required" value="<?php echo $data['ud_dob_new']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="txtEmail">Email</label>
						<input type="email" class="form-control" name="txt_email" id="txtEmail" placeholder="Enter an email address" value="<?php echo $data['ud_email']; ?>">
					</div>
					<div class="form-group">
						<label for="fileAvatar">Avatar</label>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="fileAvatar" name="file_avatar">
								<label class="custom-file-label" for="fileAvatar"><?php echo empty($data['ud_img_filename']) ? 'Choose Image' : $data['ud_img_ori']; ?></label>
							</div>
						</div>
						<small class="text-danger font-italic">Leave blank when no changes are made.</small>
					</div>
				</div>
				<div class="card-footer">
					<input type="hidden" name="action" value="1">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Login access</h3>
			</div>
			<form role="form" id="form2" action="<?php echo site_url('main/profile_store_data/2'); ?>" method="post" autocomplete="off">
				<div class="card-body">
					<div class="form-group">
						<label for="txtUsername">Username</label>
						<input type="text" class="form-control" name="txt_username" id="txtUsername" placeholder="Write username" required="required" value="<?php echo $this->session->userdata('username'); ?>" readonly="readonly" disabled="disabled">
					</div>
					<div class="form-group">
						<label for="txtPassword1">Password</label>
						<input type="password" class="form-control" name="txt_password_1" id="txtPassword1" placeholder="Write Password" required="required">
					</div>
					<div class="form-group">
						<label for="txtPassword2">Confirm password</label>
						<input type="password" class="form-control" name="txt_password_2" id="txtPassword2" placeholder="Write a password confirmation" required="required">
					</div>
				</div>
				<div class="card-footer">
					<input type="hidden" name="action" value="2">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>