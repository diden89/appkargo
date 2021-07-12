<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab/apps/module_frontend/trademark/views/item_list_view.php
 */
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Building Type Data</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-6">
						<div class="row">
							<div class="col-12">
								<!-- <h4>Building Type</h4> -->
								<div class="row">
									<div class="input-group col-9">
										<input type="text" id="txtList" class="form-control" placeholder="Search data..." aria-describedby="btnSearchType">
										<div class="input-group-append">
											<button id="btnSearchItem" class="btn btn-block btn-info btn-flat" type="button"><i class="fas fa-search"></i></button>
										</div>
									</div>
									<div class="col-3">
										<button id="btnAdd" class="btn btn-lg btn-block btn-primary btn-flat" type="button" title="Add word"><i class="fas fa-plus"></i> Add</button>
									</div>
								</div>
								<hr />
							</div>
						</div>
						<div class="row">
							<div id="gridBuilding"></div>
						</div>						
					</div>
					<div class="col-6"></div>					
				</div>
			</div>
		</div>
	</div>
</div>

