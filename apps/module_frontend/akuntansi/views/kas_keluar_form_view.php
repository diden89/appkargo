<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/transaksi/views/kas_keluar_form_view.php
 */
?>
<?php 
// print_r($data);exit;
// echo $data->co_id 	;exit;
?>
<form role="form" id="addKasKeluar" autocomplete="off">
	<input type="hidden" name="action" value="store_data_kas_keluar">
	<input type="hidden" name="mode" id="mode" value="<?=$mode?>">
	<input type="hidden" name="last_notrx" value="<?php echo $mode == 'add' ?  $last_notrx : $data->co_no_trx; ?>">
	<input type="hidden" name="key_lock" id="key_lock" value="">
	<input type="hidden" name="cod_id_edt" value="" id="cod_id_edt">
	<input type="hidden" name="co_id" id="co_id" value="<?php echo $mode == 'add' ?  '' : $data->co_id; ?>">
	<input type="hidden" name="cod_id" id="cod_id" value="">

	<?php if (isset($txt_id)): ?>
		<input type="hidden" name="cod_id" value="<?php echo $cod_id; ?>">
	<?php endif; ?>
	<div class="row">		
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">No Transaksi</label>
				<div class="col-sm-8">
					<input type="text" name="co_no_trx" class="form-control" id="no_trx_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->co_no_trx : $last_notrx; ?>" required="required" <?php echo $mode == 'edit' ? '' : ''; ?> disabled>
					<input type="hidden" name="co_no_trx_temp" class="form-control" id="co_no_trx_temp" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->co_no_trx : $last_notrx; ?>">
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Keluar Dari Akun</label>
				<div class="col-sm-4">
					<select class="form-control select2"  name="co_rad_id" id="co_rad_id">
						<option value="">-Select-</option>
						<?php
							foreach($kas_bank as $k => $v)
							{
								echo '<option value="'.$v->rad_id.'" '.(($data->co_rad_id == $v->rad_id) ? 'selected':"").'>'.get_content($v->rad_name).'</option>';
							}
						?>
					</select>
				</div>
				<div class="col-sm-4">
					<input type="text" name="temp_akun" class="form-control" id="temp_akun" value="" disabled="disabled" >
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Tanggal</label>
				<div class="input-group col-8">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" name="co_created_date" class="form-control" id="created_date" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group row district">
				<label for="url" class="col-sm-4 col-form-label">Jumlah</label>
				<div class="col-sm-8">
					<input type="text" name="co_total" class="form-control" id="co_total" value="<?php echo $mode == 'edit' && $data !== FALSE ? number_format($data->co_total) : '' ?>" >
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			
		</div>
		<div class="col-md-6">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Keterangan</label>
				<div class="col-sm-8">
				<textarea name="co_keterangan" id="co_keterangan" class="textarea" placeholder="Enter content" style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $mode == 'edit' && $data !== FALSE ? $data->co_keterangan : '' ?></textarea>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Akun header</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="akun_header" id="akun_header">
						<option value="">--Akun Header--</option>
						<!-- <?php
							// foreach($akun_header as $k => $v)
							// {
							// 	echo '<option value="'.$v->rah_id.'" '.(($data->rd_province_id == $v->rah_id) ? 'selected':"").'>'.htmlspecialchars($v->rah_name).'</option>';
							// }
						?> -->
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Akun detail</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="akun_detail" id="akun_detail" disabled="disabled">
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Rincian</label>
				<div class="col-sm-8">
					<textarea name="cod_keterangan" id="cod_keterangan" class="form-control" placeholder="Enter content"><?php echo (isset($data->cod_keterangan)) ? $data->cod_keterangan : ""; ?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label for="caption" class="col-sm-4 col-form-label">Total</label>
				<div class="col-sm-8">
					<input type="text" name="cod_total" class="form-control" id="cod_total" value="" >
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-sm-8">
					<button id="btnAddDetail" class="btn btn-primary btn-flat" type="button" title="Add Data"><i class="fas fa-plus"></i> Add</button>
				</div>
			</div>
		</div>	
		<div class="col-md-8">
			<div class="excel-data-table-container">
				<table id="temporaryDataTable" style="width: 100%;" class="table table-hover table-striped" role="grid" aria-describedby="wordDataTable_info">
					<thead>
						<tr role="row">
							<th width="10">No</th>
							<th>Kode Akun</th>
							<th>Nama Akun</th>
							<th>Keterangan</th>
							<th>Total</th>
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