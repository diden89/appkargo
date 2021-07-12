<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/models/Brand_gov_model.php
 */

class Brand_gov_model extends NOOBS_Model
{
	public function get_data($params = array())
	{
		$this->db->select("
			b.*,
			bp.bp_filename,
			bp.bp_brm_num,
			IFNULL(DATE_FORMAT(bp.bp_brm_published_date_start, '%d-%m-%Y'), '') as bp_brm_published_date_start_new,
			IFNULL(DATE_FORMAT(bp.bp_brm_published_date_end,, '%d-%m-%Y'), '') as bp_brm_published_date_end_new,
			IFNULL(DATE_FORMAT(b.b_receipt_date, '%d-%m-%Y'), '') as b_receipt_date_new
		");

		$this->db->from('brm b');
		$this->db->join('brm_properties bp', 'b.b_bp_id = bp.bp_id');

		if (isset($params['txt_brand_name']) && !empty($params['txt_brand_name'])) $this->db->like('b.b_brand', $params['txt_brand_name']);
		if (isset($params['txt_receive_date']) && !empty($params['txt_receive_date'])) 
		{
			$tmp_date = explode(' - ', $params['txt_receive_date']);
			
			$date_from = date('Y-m-d', strtotime($tmp_date[0]));
			$date_to = date('Y-m-d', strtotime($tmp_date[1]));
			
			$this->db->where("b.b_receipt_date BETWEEN '{$date_from}' AND '{$date_to}'", NULL , FALSE);
		}

		return $this->create_result($params);
	}
}