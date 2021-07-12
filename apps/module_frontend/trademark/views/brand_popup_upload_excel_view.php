<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/views/brand_popup_upload_excel_view.php
 */
?>

<form role="form" id="uploadFileForm" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="action" value="upload_file_excel">
	<div class="form-group row">
		<div class="col-sm-12">
			<button type="button" id="btnSelectFile" class="btn btn-info btn-sm"><i class="fas fa-file-excel"></i> Choose File</button>
			<span class="text-success info-text" id="infoText"></span>
			<input type="file" name="file" class="form-control d-none" id="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
		</div>
	</div>
</form>
<hr>
<div class="col-12">
	<div class="progress">
		<div id="uploadProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="percentText"></span></div>
	</div>
</div>
<div class="col-12">
	<div class="excel-data-table-container">
		<table id="excelDataTable" style="width: 100%;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="excelDataTable_info">
			<thead>
				<tr role="row">
					<th>No</th>
					<th>App No</th>
					<th>Receive Date</th>
					<th>Priority</th>
					<th>Owner</th>
					<!-- <th>Owner Address</th> -->
					<th>Lawyer</th>
					<!-- <th>Lawyer Address</th> -->
					<th>Brand</th>
					<!-- <th>Meaning of foreign languages/Letters/Numbers</th> -->
					<!-- <th>Color Desc</th> -->
					<th>Class</th>
					<!-- <th>Description of goods/services</th> -->
					<th>Detail</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>