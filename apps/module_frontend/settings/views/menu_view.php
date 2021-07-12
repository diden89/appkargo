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
<section>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?=$pages_title?></h3>
			</div>
			<div class="card-body">
				<div class="form-row">
					<div class="col-sm-2 offset-sm-10">
						<button type="button" id="btnAdd" class="btn btn-lg btn-block btn-primary btn-flat" onClick="show_modal(data = false, title= 'Add', mode = 'add')"><i class="fas fa-plus"></i> Add</button>
					</div>
				</div>
				<hr>
				<table class="collaptable table table-striped" id="example1">
					<thead>
						<th scope="col"><a href="javascript:void(0);" class="act-button-expand" style="color: white;"><i class="fas fa-angle-double-down"></i></a></th>
						<th scope="col">Caption</th>
						<th scope="col">URL</th>
						<th scope="col">Icon</th>
						<th scope="col">Description</th>
						<th scope="col">Seq</th>
						<th scope="col" style="text-align:center;">Action</th>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</section>