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
				<h3 class="card-title">User Sub Group List</h3>
			</div>
			<div class="card-body">
				<div class="form-row">
					<div class="col-sm-10">
						<select  id="txtName" class="form-control"></select>
					</div>
					<div class="col-sm-2">
						<button type="button" id="btnAdd" class="btn btn-lg btn-block btn-primary btn-flat"><i class="fas fa-plus"></i> Add</button>
					</div>
				</div>
				<hr>
                <div id="gridUserSubGroup"></div>
			</div>
		</div>
	</div>
</div>