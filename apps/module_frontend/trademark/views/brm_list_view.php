<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/views/brm_list_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">BRM List Data</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h4>BRM</h4>
						<div class="row form-group">
							<label for="txtBrandName" class="col-md-1 col-form-label">Search : </label>
							<div class="input-group col-11">
								<input type="text" id="txtBrm" class="form-control" placeholder="Search ..." aria-describedby="btnSearchBrm">
								<div class="input-group-append">
									<button id="btnSearchBrm" class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label for="txtBrandName" class="col-md-1 col-form-label">Month : </label>
							<div class="input-group col-5">
								<select class="form-control" name="bp_month" id="bp_month"> 
									<option value="">-- Select Month --</option>
									<?php for($i=1;$i<=12;$i++){ ?>
										<option value=<?=$i ?>><?= $i ?></option>
									<?php } ?>
									?>
								</select>
								
							</div>
							<label for="txtBrandName" class="col-md-1 col-form-label">Years : </label>
							<div class="input-group col-5">
								<select class="form-control" name="bp_year" id="bp_year"> 
									<option value="">-- Select Years --</option>
									<?php for($i=date('Y')-5;$i<=date('Y');$i++){ ?>
										<option value=<?=$i ?>><?= $i ?></option>
									<?php } ?>
									?>
								</select>
							</div>
						</div>
						<hr />
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="excel-data-table-container">
							<table id="brmListDataTable" style="width: 100%;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="wordDataTable_info">
								<thead>
									<tr role="row">
										<th width="10">No</th>
										<th>BRM Number</th>
										<th>Caption</th>
										<th>Website</th>
										<th>Link</th>
										<th>Month</th>
										<th>Year</th>
										<th>Start Date</th>
										<th>End Date Date</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($brm as $k => $v): ?>
										<tr>
											<td><?php echo $v->num; ?></td>
											<td><?php echo $v->bp_brm_num; ?></td>
											<td><?php echo $v->bp_caption; ?></td>
											<td><a href="<?php echo $v->bp_website; ?>" target="_blank"><?php echo $v->bp_website; ?></a></td>
											<td><a href="<?php echo $v->bp_link; ?>" target="_blank"><?php echo $v->bp_link; ?></a></td>
											<td><?php echo date('F', strtotime($v->bp_month)); ?></td>
											<td><?php echo $v->bp_year; ?></td>
											<td><?php echo $v->start_date; ?></td>
											<td><?php echo $v->end_date; ?></td>
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

