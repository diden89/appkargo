<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/report/models/Report_cash_out_model.php
 */

class Report_cash_out_model extends NOOBS_Model
{
	public function load_data_kas_masuk($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*');
		$this->db->from('cash_out as co');
		// $this->db->join('cash_out_detail as cid','co.co_no_trx = cid.cid_co_no_trx','LEFT');
		$this->db->join('user_detail as ud','ud.ud_id = co.last_user','LEFT');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = co.co_rad_id','LEFT');
		
		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->like('UPPER(co.co_no_trx)', strtoupper($params['no_trx']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('co.co_id', strtoupper($params['txt_id']));
		}

		if (isset($params['date_range_1']) && ! empty($params['date_range_1']))
		{
			$this->db->where('co.co_created_date >=', date('Y-m-d', strtotime($params['date_range_1'])));
			$this->db->where('co.co_created_date <=', date('Y-m-d', strtotime($params['date_range_2'])));
		}

		$this->db->where('co.co_is_active', 'Y');
		$this->db->order_by('co.co_created_date', 'DESC');
		$this->db->order_by('co.co_id', 'DESC');

		return $this->db->get();
 	}

 	public function load_data_kas_masuk_detail($params = array())
	{
		$this->db->select('*');
		$this->db->from('cash_out_detail as cod');
		$this->db->join('user_detail as ud','ud.ud_id = cod.last_user','LEFT');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = cod.cod_rad_id','LEFT');
		
		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->like('UPPER(cod.cod_co_no_trx)', strtoupper($params['no_trx']));
		}

		$this->db->where('cod.cod_is_active', 'Y');
		$this->db->order_by('cod.cod_id', 'DESC');

		return $this->db->get();
 	}
}