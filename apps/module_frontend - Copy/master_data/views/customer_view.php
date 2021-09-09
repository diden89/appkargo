<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/views/customer_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?=$header_title?></h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<h4>Nama Pelanggan</h4>
						<div class="row">
							<div class="input-group col-9">
								<select  id="txtName" class="form-control"></select>
							</div>
							<div class="col-3">
								<button id="btnAdd" class="btn btn-lg btn-block btn-primary btn-flat" type="button" title="Add Data"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
						<hr />
						<div id="gridCustomer"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

