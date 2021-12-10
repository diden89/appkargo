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
		<!-- <div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Tanggal</label>
				<div class="input-group col-8">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" name="so_created_date" class="form-control" id="created_date" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
					</div>
				</div>
			</div>
		</div> -->
		<div class="col-md-12">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Tanggal</label>
				<div class="input-group col-8">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" name="so_created_date" class="form-control" id="created_date" required="required" data-date="1979-09-16T05:25:07Z" data-date-format="dd-mm-yyyy hh:ii:ss" data-link-field="dtp_input1">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		
		<div class="col-md-12">
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Nomor Transaksi</label>
				<div class="col-sm-8">
					<input type="text" name="doc_no_trx" class="form-control" id="doc_no_trx" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data['doc_no_trx']: $last_notrx; ?>" disabled>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">No Transaksi SO</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="txt_sales_order" id="txt_sales_order">
						<option value="">-Select-</option>
						<?php
							foreach($sales_order as $k => $v)
							{
								echo '<option value="'.$v->so_no_trx.'" '.(($data['doc_so_no_trx'] == $v->so_no_trx) ? 'selected':"").'>'.$v->so_no_trx.' ** '.$v->v_vendor_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Kendaraan</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="ve_id" id="vehicle_id" disabled>
						<option value="">Pilih Kendaraan</option>
					</select>
				</div>
			</div>
			<!-- <div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Akun header</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="akun_header" id="akun_header">
						<option value="">--Akun Header--</option>
					</select>
				</div>
			</div> -->
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Kode Akun</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="akun_detail" id="akun_detail" >
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Jumlah</label>
				<div class="col-sm-8">
					<input type="text" name="ci_total" class="form-control" id="total" >
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Keterangan</label>
				<div class="col-sm-8">
				<textarea name="ci_keterangan" id="keterangan" class="textarea" placeholder="Enter content" style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ></textarea>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-6">
					<button id="btnAddDetail" class="btn btn-success btn-flat" type="button" title="Add Data" disabled="disabled"><i class="fas fa-plus"></i> Submit</button>
					<?php if($mode == 'edit') {?>
						<button id="btnNewDetail" class="btn btn-warning btn-flat" type="button" title="Add Data" ><i class="fas fa-file"></i>New</button>
					<?php }?>
				</div>
			</div>
		</div>	
		<div class="col-md-8">
			<div class="excel-data-table-container">
				<table id="temporaryDataTable"  class="table table-hover table-striped no-footer" role="grid" aria-describedby="wordDataTable_info">
					<thead>
						<tr role="row">
							<th width="10">No</th>
							<th>No Transaksi</th>
							<th>Kode Akun</th>
							<th>Kendaraan</th>
							<th>Jumlah</th>
							<th width="100">Action</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
					<tfoot>
						<th colspan="4">Total</th>
						<th colspan="1" id="total_amount"></th>
					</tfoot>
				</table>
			</div>
		</div>	
	</div>
</form>