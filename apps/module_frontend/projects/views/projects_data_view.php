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
					<div class="col-4">
						<!-- <h4>Group List</h4>
						<div class="list-group" id="listGroup">
							<p class="text-muted">Menu Access Group</p>
						</div> -->
						<h4>Projects</h4>
						<div class="excel-data-table-container">
							<table class="data-projects table table-striped" id="example1">
								<thead>
									<th scope="col">Projects Name</th>
									<th scope="col">Location</th>
									<th scope="col" style="text-align:center;">Action</th>
								</thead>
								<tbody></tbody>
							</table>
							<div class="btn-group" role="group" aria-label="RAB Button Group">
								<button type="button" id="btnSave" onclick="popup_projects()" class="btn merekdagang-grid-btn btn-primary btn-md"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
					</div>
					<div class="col-8">
						<h4>Item List Projects</h4>
						<div class="excel-data-table-container">
							<table class="projects-sub table table-striped" id="example1">
								<thead>
									<th scope="col">Projects</th>
									<th scope="col">Building Type</th>
									<th scope="col">Projects Sub</th>
									<th scope="col" style="text-align:center;">Action</th>
								</thead>
								<tbody></tbody>
							</table>
							<div class="btn-group" role="group" aria-label="RAB Button Group">
								<input type="hidden" name="action" value="store_data">
								<button type="button" id="btnSave" class="btn merekdagang-grid-btn btn-primary btn-md btn-sub" style="display: none;" onclick="popup_projects_sub()"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>