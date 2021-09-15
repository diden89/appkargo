<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/views/daftar_penerimaan_view.php
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
						<h4>Delivery Order</h4>
						<div class="row">
							<div class="input-group col-md-9">
								<input type="text" id="txtList" class="form-control" placeholder="Search data..." aria-describedby="btnSearchWord">
								<div class="input-group-append">
									<button id="btnSearchItem" class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
									<button id="btnReloadItem" class="btn btn-success" type="button"><i class="fas fa-sync-alt"></i></button>
								</div>
							</div>							
							<div class="col-md-3">
								<button id="btnAddItem" class="btn btn-lg btn-block btn-primary btn-flat" type="button" title="Add Data"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div><br/>
						<div class="row">
							<div class="input-group col-md-6">
								<label for="caption" class="col-sm-3 col-form-label">Periode</label>
								<div class="col-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">

												<i class="far fa-calendar-alt"></i>
											</span>
										</div>
										<input type="text" name="ud_dob_new" class="form-control" id="range1" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
									</div>
								</div>
							</div>
							<div class="input-group col-md-6">
								<label for="caption" class="col-sm-3 col-form-label">S/d</label>
								<div class="col-9">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="far fa-calendar-alt"></i>
											</span>
										</div>
										<input type="text" name="ud_dob_new" class="form-control" id="range2" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
									</div>
								</div>
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
										<th>No Transaksi SO</th>
										<th>No Transaksi</th>
										<th>Nama Pelanggan</th>
										<th>Nama Barang</th>
										<th>Pengemudi / Kendaraan</th>
										<th >Alamat Pengiriman</th>
										<th>Total Kirim</th>
										<th>Total terima</th>
										<th>Biaya</th>
										<th>Tanggal Pengiriman</th>
										<th>Status</th>
										<th width="100">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($item as $k => $v): ?>
										<tr>
											<td><?php echo $v->num; ?></td>
											<td><?php echo $v->so_no_trx; ?></td>
											<td><?php echo $v->dod_no_trx; ?></td>
											<td><?php echo $v->c_name; ?></td>
											<td><?php echo $v->il_item_name; ?></td>
											<td><?php echo $v->d_name.' / '.$v->ve_license_plate; ?></td>
											<td><?php echo $v->c_address.'<br>Kec. '.$v->rsd_name; ?></td>
											<td><?php echo number_format($v->dod_shipping_qty); ?></td>
											<td><?php echo number_format($v->dos_filled); ?></td>
											<td id="biaya"><?php echo number_format($v->dod_ongkir); ?></td>
											<td><?php echo date('d-m-Y',strtotime($v->dod_created_date)); ?></td>
											<td><?php echo $v->dod_is_status; ?></td>
											<td>
												<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
													<?php if($v->dod_is_status !== 'SELESAI') { ?>
														<button type="button" class="btn btn-success" data-id="<?php echo $v->dod_id; ?>" data-no_trx="<?php echo $v->dod_no_trx; ?>" data-is_status="<?php echo $v->dod_is_status; ?>" data-so_id="<?php echo $v->so_id; ?>"  data-so_no_trx="<?php echo $v->so_no_trx; ?>"onclick="daftarDeliveryOrderList.updateStatus(this, 'edit');" title="Update Status"><i class="fas fa-check-double"></i> Finish</button>
													<?php }?>
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

