<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/views/similar_words_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Similar Words Data</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-6">
						<h4>List of words</h4>
						<div class="input-group">
							<input type="text" id="txtWord" class="form-control" placeholder="Search word." aria-describedby="btnSearch">
							<div class="input-group-append">
								<button id="btnSearch" class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</div>

					<div class="col-6">
						<h4>Similar words</h4>
						<div class="input-group">
							<input type="text" id="txtSImilarWord" class="form-control" placeholder="Search similar word." aria-describedby="btnSearchSimilarWord">
							<div class="input-group-append">
								<button id="btnSearchSimilarWord" class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-6">
						<div id="gridWords"></div>
						<!-- <div class="list-group" id="listWord">
							<p class="text-muted">Find word in similar words first.</p>
						</div> -->
					</div>
					<div class="col-6">
						<div id="gridSimilarWords"></div>
						<!-- <div class="excel-data-table-container">
							<table id="similarWordsDataTable" style="width: 100%;" class="table table-hover table-striped no-footer" role="grid" aria-describedby="similarWordsDataTable_info">
								<thead>
									<tr role="row">
										<th width="10">No</th>
										<th>Word</th>
										<th width="100">Action</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

