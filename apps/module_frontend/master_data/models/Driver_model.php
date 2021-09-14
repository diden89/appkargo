<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/models/Driver_model.php
 */

class Driver_model extends NOOBS_Model
{
	public function load_data_driver($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*,rp.rp_id,rd.rd_id,rsd.rsd_name,ud.ud_username');
		$this->db->from('driver as d');
		$this->db->join('ref_sub_district as rsd','rsd.rsd_id = d.d_district_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = rsd.rsd_district_id','LEFT');
		$this->db->join('ref_province as rp','rp.rp_id = rd.rd_province_id','LEFT');
		$this->db->join('user_detail as ud','ud.ud_id = d.d_ud_id','LEFT');

		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(d.d_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('d.d_id', strtoupper($params['txt_id']));
		}

		$this->db->where('d.d_is_active', 'Y');
		$this->db->order_by('d.d_name', 'ASC');

		return $this->create_result($params);
 	}

	public function store_data($params = array())
	{
		$this->table = 'driver';
		// print_r($params);exit;
		$new_params = array(
			'd_name' => $params['d_name'],
			'd_address' => $params['d_address'],
			'd_phone' => $params['d_phone'],
			'd_email' => $params['d_email'],
			'd_district_id' => $params['d_district_id'],
			'd_ud_id' => $params['txt_user_id']
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "d_id = {$params['txt_id']}");
	}

	// public function delete_data_driver($params = array())
	// {
	// 	$this->table = 'driver';

	// 	$this->edit(['d_is_active' => 'N'], "d_id = {$params['txt_id']}");
		
	// 	return $this->load_data_driver();
	// }

	public function load_data($params = array())
	{
		// print_r($params);exit;
		$this->db->select('d.*,rp.rp_id,rd.rd_id,rsd.rsd_name,ud.ud_username');
		$this->db->from('driver as d');
		$this->db->join('ref_sub_district as rsd','rsd.rsd_id = d.d_district_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = rsd.rsd_district_id','LEFT');
		$this->db->join('ref_province as rp','rp.rp_id = rd.rd_province_id','LEFT');
		$this->db->join('user_detail as ud','ud.ud_id = d.d_ud_id','LEFT');

		if (isset($params['d_id']) && ! empty($params['d_id']))
		{
			$this->db->where('d.d_id', strtoupper($params['d_id']));
		}

		$this->db->where('d.d_is_active', 'Y');
		$this->db->order_by('d.d_name', 'ASC');

		return $this->db->get();
 	}

 	public function get_autocomplete_data($params = array())
	{
		// print_r($params);exit;
		$this->db->select('d.*,rp.rp_id,rd.rd_id,rsd.rsd_name,ud.ud_username,d_id as id,
			d_name as text,
			d_name as full_name');
		$this->db->from('driver as d');
		$this->db->join('ref_sub_district as rsd','rsd.rsd_id = d.d_district_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = rsd.rsd_district_id','LEFT');
		$this->db->join('ref_province as rp','rp.rp_id = rd.rd_province_id','LEFT');
		$this->db->join('user_detail as ud','ud.ud_id = d.d_ud_id','LEFT');

		if (isset($params['d_id']) && ! empty($params['d_id']))
		{
			$this->db->where('d.d_id', strtoupper($params['d_id']));
		}

		$this->db->where('d.d_is_active', 'Y');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(d.d_name LIKE '%{$query}%' OR d.d_address LIKE '%{$query}%')", NULL, FALSE);
		}

		return $this->create_autocomplete_data($params);
	}

 	public function get_option_province()
	{
		$this->db->order_by('rp_name', 'ASC');
		
		return $this->db->get('ref_province');
 	}

 	public function get_region_option($params)
	{
		$this->db->where('rd_province_id', $params['prov_id']);
		$this->db->order_by('rd_name', 'ASC');
		
		return $this->db->get('ref_district');
 	}

 	public function get_option_user_detail($id = "")
	{
		$this->db->from('user_detail');
		$this->db->where('ud_id not in
		(select d_ud_id from driver where d_ud_id is not null and d_ud_id not in ("'.$id.'"))');
		$this->db->order_by('ud_fullname', 'ASC');
		
		return $this->db->get();
 	}

 	public function get_district_option($params)
	{
		$this->db->where('rsd_district_id', $params['district_id']);
		$this->db->order_by('rsd_name', 'ASC');
		
		return $this->db->get('ref_sub_district');
 	}
	public function get_option_driver()
	{
		$this->db->where('d_is_active', 'Y');
		$this->db->order_by('d_name', 'ASC');

		return $this->db->get('driver');
 	}

	public function delete_data($params = array())
	{
		$this->table = 'driver';

		return $this->edit(['d_is_active' => 'N'], "d_id = {$params['txt_id']}");
	
	}
}