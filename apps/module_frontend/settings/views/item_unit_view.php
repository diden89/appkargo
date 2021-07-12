<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/views/similar_letters_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Item Unit Data</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h4>Unit</h4>
						<div class="row">
							<div class="input-group col-9">
								<input type="text" id="txtUnit" class="form-control" placeholder="Search..." aria-describedby="btnSearchUnit">
								<div class="input-group-append">
									<button id="btnSearchUnit" class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
								</div>
							</div>
							<div class="col-3">
								<button id="btnAddUnit" class="btn btn-block btn-lg btn-primary btn-flat" type="button" title="Add Unit"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
						<hr />
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="excel-data-table-container">
							<table id="itemUnitDataTable" style="width: 100%;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="unitDataTable_info">
								<thead>
									<tr role="row">
										<th width="10">No</th>
										<th>Unit</th>
										<th width="100">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($unit as $k => $v): ?>
										<tr>
											<td><?php echo $v->num; ?></td>
											<td><?php echo $v->un_name; ?></td>
											<td>
												<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
													<button type="button" class="btn btn-success" data-id="<?php echo $v->id; ?>" data-unit="<?php echo $v->un_name; ?>" onclick="itemUnit.showUnit(this, 'edit');" title="Edit Unit"><i class="fas fa-edit"></i></button>
													<button type="button" class="btn btn-danger" data-id="<?php echo $v->id; ?>" data-unit="<?php echo $v->un_name; ?>" onclick="itemUnit.deleteDataUnit(this);" title="Delete Unit"><i class="fas fa-trash-alt"></i></button>
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

