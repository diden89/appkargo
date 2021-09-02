<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/views/kas_masuk_view.php
 */
?>
<!-- 
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?=$header_title?></h3>
			</div>
			<div class="card-body">				
				<div class="row">
					<div class="col-12">
						<div class="excel-data-table-container">
							<table id="ignoredItemDataTable" style="width: 100%;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="wordDataTable_info">
								<thead>
									<tr role="row">
										<th width="10">No</th>
										<th>No Transaksi</th>
										<th>Tanggal</th>
										<th>Keluar Dari Akun</th>
										<th>Keterangan</th>
										<th>Total</th>
										<th>User Buat</th>
									</tr>
								</thead>
								<tbody>
									<?php// foreach ($item as $k => $v): ?>
										<tr>
											<td><?php //echo $v->num; ?></td>
											<td><?php //echo $v->ci_no_trx; ?></td>
											<td><?php //echo date('d-m-Y',strtotime($v->ci_created_date)); ?></td>
											<td><?php //echo $v->rad_name; ?></td>
											<td><?php// echo $v->ci_keterangan; ?></td>
											<td><?php //echo $v->ci_total; ?></td>
											<td><?php //echo $v->ud_fullname; ?></td>
										</tr>
									<?php //endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> -->
<<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<table>
		<tr>
			<td rowspan="4">
				<img src="<?php echo base_url('images/0b30659b-8f94-4d5f-9695-a8a3441d376a.jpg'); ?>" width="100px">
			</td>
			<td>
				<h3>Laporan Kas Masuk</h3>
			</td>
		</tr>
		<tr>
			<td>
				Bintang Ekspedisi
			</td>
		</tr><tr>
			<td>
				Perumahan Citra Berlindo
			</td>
		</tr><tr>
			<td>
				0812-6666-7778
			</td>
		</tr>
	</table>
	<hr>
	<table style="border-collapse:collapse;">		
		<tr>
			<th width="10">No</th>
			<th>No Transaksi</th>
			<th>Tanggal</th>
			<th>Keluar Dari Akun</th>
			<th>Keterangan</th>
			<th>Total</th>
			<th>User Buat</th>
		</tr>
	
		<?php foreach ($item as $k => $v): ?>
			<tr>
				<td><?php echo $v->num; ?></td>
				<td><?php echo $v->ci_no_trx; ?></td>
				<td><?php echo date('d-m-Y',strtotime($v->ci_created_date)); ?></td>
				<td><?php echo $v->rad_name; ?></td>
				<td><?php echo $v->ci_keterangan; ?></td>
				<td><?php echo $v->ci_total; ?></td>
				<td><?php echo $v->ud_fullname; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</body>
</html>

