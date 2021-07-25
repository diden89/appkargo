<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/akuntansi/views/daftar_perkiraan_view.php
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
				<div class="row">
					<div class="col-12">
						<div class="row">
							<div class="input-group col-11">
							</div>
							<div class="col-1">
								<button id="btnAddItem" class="btn btn-lg btn-block btn-primary btn-flat" type="button" title="Add Data"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-2">
						<h4>Header Akun</h4>
						<div class="list-group" id="headerList">
							<p class="text-muted">Header akun</p>
							
						</div>
					</div>
					<div class="col-10">
						<h4>Detail akun</h4>
						<div class="excel-data-table-container">
							<form id="addAccessGroup">
							<table class="collaptable table table-striped" id="example1">
								<thead>
									<th scope="col"><a href="javascript:void(0);" class="act-button-expand" style="color: white;"><i class="fas fa-angle-double-down"></i></a></th>
									<th scope="col">Kode Akun</th>
									<th scope="col">Nama Akun</th>
									<th scope="col">Type</th>
									<th scope="col" style="text-align:center;">Action</th>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>