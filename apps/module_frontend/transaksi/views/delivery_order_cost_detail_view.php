<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/master_data/views/customer_form_view.php
 */
?>

<form role="form" id="addDaftarSalesOrder" autocomplete="off">
	<input type="hidden" name="action" value="store_data_delivery_order_cost">
	<input type="hidden" name="mode" value="<?=$mode?>" id="mode">
	<input type="hidden" name="docd_id" id="docd_id">
	<input type="hidden" name="docd_lock" id="docd_lock">

	<?php 
	if ($mode == 'edit'): ?>
		<input type="hidden" name="doc_id" id="doc_id" value="<?php echo $data['doc_id'];?>">
	<?php endif; ?>
	<div class="row">
		<div class="col-md-12">
			<div class="excel-data-table-container">
				<table id="DetailDataTable"  class="table table-hover table-striped no-footer" role="grid" aria-describedby="wordDataTable_info">
					<thead>
						<tr role="row">
							<th width="10">No</th>
							<th>Tanggal Transaksi</th>
							<th>No Transaksi</th>
							<th>No Trx Order</th>
							<th>Kendaraan</th>
							<th>Kode Akun</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach($result as $k => $v)
						{
							?>
							<tr>
								<td><?php echo $v->no ;?></td>
								<td><?php echo $v->doc_created_date ;?></td>
								<td><?php echo $v->doc_no_trx ;?></td>
								<td><?php echo $v->doc_so_no_trx ;?></td>
								<td><?php echo $v->ve_license_plate ;?></td>
								<td><?php echo $v->rad_name ;?></td>
								<td><?php echo $v->docd_amount ;?></td>
							</tr>
							<?php
						}
					?>					
					</tbody>
					<tfoot>
						<th colspan="6">Total</th>
						<th colspan="1" id="total_amount"></th>
					</tfoot>
				</table>
			</div>
		</div>	
	</div>
</form>