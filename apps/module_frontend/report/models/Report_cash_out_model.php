<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/report/models/Report_cash_in_model.php
 */

class Report_cash_in_model extends NOOBS_Model
{
	public function load_data_kas_masuk($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*');
		$this->db->from('cash_in as ci');
		// $this->db->join('cash_in_detail as cid','ci.ci_no_trx = cid.cid_ci_no_trx','LEFT');
		$this->db->join('user_detail as ud','ud.ud_id = ci.last_user','LEFT');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = ci.ci_rad_id','LEFT');
		
		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->like('UPPER(ci.ci_no_trx)', strtoupper($params['no_trx']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('ci.ci_id', strtoupper($params['txt_id']));
		}

		if (isset($params['date_range_1']) && ! empty($params['date_range_1']))
		{
			$this->db->where('ci.ci_created_date >=', date('Y-m-d', strtotime($params['date_range_1'])));
			$this->db->where('ci.ci_created_date <=', date('Y-m-d', strtotime($params['date_range_2'])));
		}

		$this->db->where('ci.ci_is_active', 'Y');
		$this->db->order_by('ci.ci_created_date', 'DESC');
		$this->db->order_by('ci.ci_id', 'DESC');

		return $this->db->get();
 	}

 	public function load_data_kas_masuk_detail($params = array())
	{
		$this->db->select('*');
		$this->db->from('cash_in_detail as cid');
		$this->db->join('user_detail as ud','ud.ud_id = cid.last_user','LEFT');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = cid.cid_rad_id','LEFT');
		
		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->like('UPPER(cid.cid_ci_no_trx)', strtoupper($params['no_trx']));
		}

		$this->db->where('cid.cid_is_active', 'Y');
		$this->db->order_by('cid.cid_id', 'DESC');

		return $this->db->get();
 	}
}