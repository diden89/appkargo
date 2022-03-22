<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/report/views/report_laba_rugi_ytd_view.php
 */
?>

	<div class="card col-md-4">
		<div class="card-header">
			<!-- <h3 class="card-title"><?=$pages_title?></h3> -->
			<h3 class="card-title">Laporan</h3>
		</div>
		<div class="card-body">
		<form action="report_laba_rugi_ytd/print_pdf" method="post">			
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group row">
						<label for="caption" class="col-sm-4 col-form-label">Periode</label>
						<div class="input-group col-8">
							<select name="month" class="form-control">
								<option value="1">Januari</option>
								<option value="2">Februari</option>
								<option value="3">Maret</option>
								<option value="4">April</option>
								<option value="5">Mei</option>
								<option value="6">Juni</option>
								<option value="7">Juli</option>
								<option value="8">Agustus</option>
								<option value="9">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
							<select name="years" class="form-control">
								<?php
								$years = date('Y');
									
								for($i = $years-4;$i <= $years;$i++)
								{
									$sel = ($i == $years) ? 'selected' : '';
									echo "<option value='".$i."' ".$sel.">".$i."</option>";
									
								}

								 ?>
							</select>
						</div>
					</div>
				</div>
			</div>	
			<div class="row">							
				<div class="input-group col-lg-6">
					<div class="input-group-append">
						<button class="btn btn-lg btn-block btn-warning btn-flat" type="submit" title="Add Data" formtarget="_blank"><i class="fas fa-plus"></i> Print</button>
					</div>
				</div>
			</div>
		</form>
		</div>
	</div>