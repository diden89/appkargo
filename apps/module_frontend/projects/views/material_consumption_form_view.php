<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/views/similar_letters_form_letter_view.php
 */
?>

<form role="form" id="AddData" autocomplete="off">
	<input type="hidden" name="action" value="store_data_material">
	<input type="hidden" name="mode" value="<?= $mode ?>">
	<input type="hidden" name="mc_id" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->ps_id : '' ?>">
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<!-- <label for="userBirthday" class="col-sm-4 col-form-label">Date Order</label>
				<div class="col-sm-8">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
						</div>
						<input type="text" name="mc_date_order" class="form-control" id="dateOrder" required="required" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask value="<?php //echo $mode == 'edit' && $data !== FALSE ? $data->mc_date_order : '' ?>">
					</div>
				</div> -->

				<label for="dtp_input1" class="col-sm-4 col-form-label">DateTime Picking</label>
                <div class="input-group date form_datetime col-md-8"  data-date-format="dd-MM-yyyy HH:ii p" data-link-field="dtp_input1">
                    <input class="form-control" size="16" name="mc_date_order" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
				<input type="hidden" id="dtp_input1" value="" /><br/>

			</div>	
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Projects</label>
				<div class="col-sm-8">
					<input type="text" name="p_name" class="form-control" id="p_name" value="<?php echo $projects->p_name ; ?>" required="required" readOnly>
					<input type="hidden" name="p_id" value="<?php echo $projects->p_id ; ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Projects Sub</label>
				<div class="col-sm-8">
					<input type="text" name="ps_name" class="form-control" id="ps_name" value="<?php echo $projects_sub->ps_name ; ?>" required="required" readOnly>
					<input type="hidden" name="ps_id" value="<?php echo $projects_sub->ps_id ; ?>">
				</div>
			</div>	
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Material</label>
				<div class="col-sm-8">
					<select class="form-control select2"  name="il_id" id="txt_il_id">
						<option value="">-Select-</option>
						<?php
							foreach($material as $k => $v)
							{
								echo '<option value="'.$v->il_id.'" '.(($data->il_id == $v->il_id) ? 'selected':"").'>'.$v->il_item_name.'</option>';
							}
						?>
					</select>
				</div>
			</div>	
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Price</label>
				<div class="col-sm-8">
					<input type="text" name="mc_price" class="form-control number" id="mc-price" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->mc_price : '' ?>" required="required">
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Quantity</label>
				<div class="col-sm-8">
					<input type="text" name="mc_quantity" class="form-control mc-quantity number" id="mc-quantity" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->mc_price : '' ?>" required="required">
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-sm-4 col-form-label">Total Price</label>
				<div class="col-sm-8">
					<input type="text" name="mc_total" class="form-control mc-total" id="mc-total" value="<?php echo $mode == 'edit' && $data !== FALSE ? $data->mc_total : '' ?>" required="required" readOnly>
				</div>
			</div>
		</div>		
	</div>
</form>