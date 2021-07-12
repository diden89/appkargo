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
						<h4>Building Type</h4>
						<div class="list-group" id="listGroup">
							<p class="text-muted">RAB Building List</p>
						</div>
					</div>
					<div class="col-9">
						<h4>RAB</h4>
						<div class="excel-data-table-container">
							<form id="addRabBuilding">
							<table class="rab-table table table-striped" id="example1">
								<thead>
									<th scope="col">Item Name</th>
									<th scope="col">RAB Unit</th>
									<th scope="col">Material</th>
									<th scope="col">Volume</th>
									<th scope="col">Unit</th>
									<th scope="col">Measure</th>
									<th scope="col">Summary</th>
								</thead>
								<tbody></tbody>
							</table>
							<div class="btn-group" role="group" aria-label="RAB Button Group">
								<input type="hidden" name="action" value="store_data">
								<button type="submit" id="btnSave" class="btn merekdagang-grid-btn btn-primary btn-md" disabled on><i class="fas fa-save"></i> Save</button>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>