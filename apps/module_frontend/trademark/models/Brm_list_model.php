<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/models/Brm_list_model.php
 */

class Brm_list_model extends NOOBS_Model
{
	public function load_data_brm($params = array())
	{
		if (isset($params['txt_brm']) && ! empty($params['txt_brm']))
		{
			$this->db->where('iw_brm', strtoupper($params['txt_brm']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('iw_id', strtoupper($params['txt_id']));
		}

		if (isset($params['txt_month']) && ! empty($params['txt_month']))
		{
			$this->db->where('bp_month', $params['txt_month']);
		}
		
		if (isset($params['txt_year']) && ! empty($params['txt_year']))
		{
			$this->db->where('bp_year', $params['txt_year']);
		}

		$this->db->select("*,
			IFNULL(DATE_FORMAT(bp_brm_published_date_start, '%d-%m-%Y'), '') as start_date,
			IFNULL(DATE_FORMAT(bp_brm_published_date_end, '%d-%m-%Y'), '') as end_date,
			", FALSE);
		$this->db->order_by('bp_caption', 'ASC');

		return $this->db->get('brm_properties');
 	}
}