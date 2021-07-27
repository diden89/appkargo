<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/views/customer_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?=$header_title?></h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h4>Sales Order</h4>
						<div class="row">
							<div class="input-group col-6">
								<input type="text" id="txtList" class="form-control" placeholder="Search data..." aria-describedby="btnSearchWord">
								<div class="input-group-append">
									<button id="btnSearchItem" class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
									<button id="btnReloadItem" class="btn btn-success" type="button"><i class="fas fa-sync-alt"></i></button>
								</div>
							</div>
							<div class="input-group col-2">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
									<input type="text" name="ud_dob_new" class="form-control" id="range1" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
								</div>
							</div>
							<div class="input-group col-2">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
									<input type="text" name="ud_dob_new" class="form-control" id="range2" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
								</div>
							</div>
							<div class="col-2">
								<button id="btnAddItem" class="btn btn-lg btn-block btn-primary btn-flat" type="button" title="Add Data"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
						<hr />
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="excel-data-table-container">
							<table id="ignoredItemDataTable" style="width: 100%;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="wordDataTable_info">
								<thead>
									<tr role="row">
										<th width="10">No</th>
										<th>No Transaksi</th>
										<th>Nama Vendor</th>
										<th>Berat / Kg</th>
										<th>Tujuan</th>
										<th>Tanggal</th>
										<th>Status</th>
										<th width="100">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($item as $k => $v): ?>
										<tr>
											<td><?php echo $v->num; ?></td>
											<td><?php echo $v->so_no_trx; ?></td>
											<td><?php echo $v->v_vendor_name; ?></td>
											<td><?php echo $v->so_qty; ?></td>
											<td><?php echo $v->rd_name; ?></td>
											<td><?php echo date('d-m-Y H:i:s',strtotime($v->so_created_date)); ?></td>
											<td><?php echo $v->so_is_status; ?></td>
											<td>
												<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
													<button type="button" class="btn btn-success" data-id="<?php echo $v->so_id; ?>" onclick="customerList.showItem(this, 'edit');" title="Edit Word"><i class="fas fa-edit"></i></button>
													<button type="button" class="btn btn-danger" data-id="<?php echo $v->so_id; ?>" onclick="customerList.deleteDataItem(this);" title="Delete Word"><i class="fas fa-trash-alt"></i></button>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

