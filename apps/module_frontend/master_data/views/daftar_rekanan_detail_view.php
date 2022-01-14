<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/master_data/views/daftar_rekanan_detail_view.php
 */
?>

<div class="form-group row">
	<div class="col-md-6">
		<div class="row">
			<label for="caption" class="col-sm-4 col-form-label">Kode Rekanan :</label>
			<div class="col-sm-8">
				<input type="text" class="form-control"  value="<?php echo $data->pr_code; ?>" disabled>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<label for="caption" class="col-sm-4 col-form-label">Nama Rekanan :</label>
			<div class="col-sm-8">
				<input type="text" class="form-control"  value="<?php echo $data->pr_name; ?>" disabled>
			</div>
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-md-6">
		<div class="row">
			<label for="url" class="col-sm-4 col-form-label">Telpon :</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" value="<?php echo $data->pr_phone; ?>" disabled>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<label for="url" class="col-sm-4 col-form-label">Email :</label>
			<div class="col-sm-8">
				<input type="email" class="form-control" value="<?php echo $data->pr_email; ?>" disabled>
			</div>
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-md-12">
		<div class="row">
			<label for="url" class="col-sm-2 col-form-label">User Login :</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" value="<?php echo (! empty($user_detail)) ? $user_detail->ud_username : 'User Login Tidak Ditemukan!!!'; ?>" disabled>
			</div>
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-md-12">
		<div class="row">
			<table id="ignoredItemDataTable" style="width: 100%;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="wordDataTable_info">
							<thead>
								<tr role="row">
									<th width="10">No</th>
									<th>Plat No Kendaraan</th>
									<th>Jenis Kendaraan</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($vehicle as $k => $v): ?>
									<tr>
										<td><?php echo $v->num; ?></td>
										<td><?php echo $v->ve_license_plate; ?></td>
										<td><?php echo $v->ve_name; ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
		</div>
	</div>
</div>