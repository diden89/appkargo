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
						<h4>Group List</h4>
						<div class="list-group" id="listGroup">
							<p class="text-muted">Menu Access Group</p>
						</div>
					</div>
					<div class="col-8">
						<h4>Menu Access</h4>
						<div class="excel-data-table-container">
							<form id="addAccessGroup">
							<table class="collaptable table table-striped" id="example1">
								<thead>
									<th scope="col"><a href="javascript:void(0);" class="act-button-expand" style="color: white;"><i class="fas fa-angle-double-down"></i></a></th>
									<th scope="col">Caption</th>
									<th scope="col" style="text-align:center;">Action</th>
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