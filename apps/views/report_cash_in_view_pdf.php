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
	<style>
		#customers {
		  font-family: Arial, Helvetica, sans-serif;
		  border-collapse: collapse;
		  width: 100%;
		}

		#customers td, #customers th {
		  border: 1px solid #ddd;
		  padding: 8px;
		}

		#customers tr:nth-child(even){background-color: #f2f2f2;}

		#customers tr:hover {background-color: #ddd;}

		#customers th {
		  padding-top: 12px;
		  padding-bottom: 12px;
		  text-align: left;
		  background-color: #04AA6D;
		  color: white;
		}
	</style>
</head>
<body>
	<table id="customers">		
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

