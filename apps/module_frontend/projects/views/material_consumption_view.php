<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/views/user_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?=$pages_title?></h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-3">
						<form role="form" id="showMaterial" autocomplete="off">
							<h4>Filter Projects</h4>
							<div class="form-group row">
								<div class="col-sm-12">
									<select class="form-control select2"  name="p_id" id="p-id" required="required">
										<option value="">-Select-</option>
										<?php
											foreach($projects as $k => $v)
											{
												echo '<option value="'.$v->p_id.'">'.$v->p_name.'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
									<select class="form-control select2 ps-id"  name="ps_id" id="ps-id" required="required">
										<option value="">-Select-</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group row">
										<div class="col-sm-12">
											<select class="form-control select2"  name="years" id="years">
												<option value="">-Years-</option>
												<?php
													for($i=date('Y')-3;$i<=date('Y');$i++)
													{
														echo '<option value="'.$i.'" '.($i == date('Y') ? 'selected':'').'>'.$i.'</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group row">
										<div class="col-sm-12">
											<select class="form-control select2"  name="month" id="month">
												<option value="">-Month-</option>
												<?php
													$bln=array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
													
													for($bulan=1; $bulan<=12; $bulan++){
														echo '<option value='.$bulan.' '.($bulan == date('n') ? "selected":"").'>'.$bln[$bulan].'</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="btn-group" role="group" aria-label="Show Material">
								<input type="hidden" name="action" value="show_material">
								<button type="submit" id="btnShow" class="btn merekdagang-grid-btn btn-warning btn-md"><i class="fas fa-eye"></i> Show</button>
							</div>
						</form>
					</div>
					<div class="col-9">
						<h4>Item List Projects</h4>
						<div class="excel-data-table-container">
							<table class="material-consumption table table-striped" id="example1">
								<thead>
									<th>No</th>
									<th>Projects</th>
									<th>Projects Sub</th>
									<th>Date Order</th>
									<th>Material</th>
									<th>Price</th>
									<th>Quantity</th>
									<th>Unit</th>									
									<th >Total</th>
									<th style="text-align:center;">Action</th>
								</thead>
								<tbody></tbody>
							</table>
							<div class="btn-group" role="group" aria-label="RAB Button Group">
								<button type="button" id="btnAdd" class="btn merekdagang-grid-btn btn-primary btn-md btn-sub" style="display: none;" onclick="popup_material_consumption()"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>