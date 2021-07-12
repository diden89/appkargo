<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/views/similar_letters_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Manage your Similar Letters and/or Numbers</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-6">
						<h4>Similar Letters and/or Numbers</h4>
						<div class="row">
							<div class="input-group col-9">
								<input type="text" id="txtLetter" class="form-control" placeholder="Search letter..." aria-describedby="btnSearchLetter">
								<div class="input-group-append">
									<button id="btnSearchLetter" class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
								</div>
							</div>
							<div class="col-3">
								<button id="btnAddLetter" class="btn btn-block btn-primary btn-flat" type="button" title="Add letter"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
						<hr />
					</div>
					<div class="col-6 div-left" style="display: none;">
						<h4>Similar Letters and/or Numbers for</h4>
						<div class="row">
							<div class="input-group col-9">
								<input type="text" id="txtSimilarLetter" class="form-control" placeholder="Search similar letter..." aria-describedby="btnSearchSimilarLetter" disabled="disabled">
								<div class="input-group-append">
									<button id="btnSearchSimilarLetter" class="btn btn-info" type="button" disabled="disabled"><i class="fas fa-search"></i></button>
								</div>
							</div>
							<div class="col-3">
								<button id="btnAddSimilarLetter" class="btn btn-block btn-primary btn-flat" type="button" disabled="disabled" title="Add similar letter"><i class="fas fa-plus"></i> Add</button>
							</div>
						</div>
						<hr />
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div id="gridLetter"></div>
					</div>
					<div class="col-6 div-left" style="display: none;">
						<div id="gridSimilarLetter"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

