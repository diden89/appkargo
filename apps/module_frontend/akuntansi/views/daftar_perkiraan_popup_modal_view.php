<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package App Kargo
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /appkargo/apps/module_frontend/akuntansi/views/daftar_perkiraan_popup_modal_view.php
 */
?>
<form role="form" id="storeDataPopup" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="action" value="store_data">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="txt_detail_id" id="txt_detail_id" value="<?php echo (isset($data->rad_id)) ? $data->rad_id : ""; ?>">
	<input type="hidden" name="txt_parent_id" id="txt_parent_id" value="<?php echo (isset($data->rad_parent_id)) ? $data->rad_parent_id : ""; ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label for="type_perkiraan" class="col-sm-4 col-form-label">Tipe Perkiraan</label>
				<div class="col-sm-8">					
                        <div class="form-check">
                          <input class="form-check-input" name="rad_type" type="radio" value="H" <?php echo (isset($data->rad_type) && $data->rad_type == 'H') ? 'checked' : ''; ?>>
                          <label class="form-check-label">Header</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" name="rad_type" <?php echo (isset($data->rad_type) && $data->rad_type == 'D') ? 'checked' : ''; ?> type="radio" value="D">
                          <label class="form-check-label">Detail</label>
                        </div>      
				</div>
			</div>
			<div class="form-group row">
				<label for="header" class="col-sm-4 col-form-label">Header</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="txt_header" id="txt_header">
						<option value="">-Select-</option>
						<?php
							foreach($header as $k => $v)
							{
								echo '<option value="'.$v->rah_id.'" '.(($header_id == $v->rah_id) ? 'selected':"").'>'.strtoupper($v->rah_name).'</option>';
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="posisi" class="col-sm-4 col-form-label">Posisi dibawah</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="txt_posisi" id="txt_posisi" disabled>
						<option value="">-Select-</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="kode_perkiraan" class="col-sm-4 col-form-label">Kode Perkiraan</label>
				<div class="col-sm-1">
					<input type="text" name="header_code" class="form-control" id="header_code" value="<?php echo (isset($rah_code) && $rah_code !== '') ? $rah_code : '' ; ?>" disabled>
				</div>
				<div class="col-sm-1">
					<label for="kode_perkiraan" class="col-sm-4 col-form-label">-</label>
				</div>
				<div class="col-sm-6">
					<input type="text" name="code" class="form-control" id="code" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->kode_akun : '' ?>" <?php echo $mode == 'edit' ? '' : ''; ?>>
				</div>
			</div>
			<div class="form-group row">
				<label for="description" class="col-sm-4 col-form-label">Nama</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="rad_name" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->rad_name : '' ?>" <?php echo $mode == 'edit' ? '' : ''; ?>">
				</div>
			</div>	
			<div class="form-group row">
				<label for="description" class="col-sm-4 col-form-label">Kas / Bank</label>
				<div class="col-sm-8">
					<input type="checkbox"  name="is_bank" value="Y" <?php echo (isset($data->rad_is_bank) && $data->rad_is_bank == 'Y') ? 'checked' : ''; ?>>
				</div>
			</div>	
	</div>
</form>