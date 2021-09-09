<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/models/Customer_model.php
 */

class Customer_model extends NOOBS_Model
{
	public function load_data_customer($params = array())
	{
		// print_r($params);exit;
		$this->db->select('c.*,rp.rp_id,rd.rd_id,rsd.rsd_name,rsd.rsd_id');
		$this->db->from('customer as c');
		$this->db->join('ref_sub_district as rsd','rsd.rsd_id = c.c_district_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = rsd.rsd_district_id','LEFT');
		$this->db->join('ref_province as rp','rp.rp_id = rd.rd_province_id','LEFT');

		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(c.c_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('c.c_id', strtoupper($params['txt_id']));
		}

		$this->db->where('c.c_is_active', 'Y');
		$this->db->order_by('c.c_name', 'ASC');

		return $this->create_result($params);
 	}

 	public function get_autocomplete_data($params = array())
	{
		// print_r($params);exit;
		$this->db->select('c.*,rp.rp_id,rd.rd_id,rsd.rsd_name,c.c_name as text, c.c_name as full_name,c.c_id as id');
		$this->db->from('customer as c');
		$this->db->join('ref_sub_district as rsd','rsd.rsd_id = c.c_district_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = rsd.rsd_district_id','LEFT');
		$this->db->join('ref_province as rp','rp.rp_id = rd.rd_province_id','LEFT');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(c.c_name LIKE '%{$query}%' OR c.c_address LIKE '%{$query}%')", NULL, FALSE);
		}

		$this->db->where('c.c_is_active', 'Y');
		$this->db->order_by('c.c_name', 'ASC');

		return $this->create_autocomplete_data($params);
 	}

	public function store_data_customer($params = array())
	{
		$this->table = 'customer';

		$new_params = array(
			'c_name' => $params['c_name'],
			'c_address' => $params['c_address'],
			'c_phone' => $params['c_phone'],
			'c_email' => $params['c_email'],
			'c_district_id' => $params['c_district_id'],
			'c_shipping_area' => $params['c_shipping_area'],
			'c_distance_area' => $params['c_distance_area']
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "c_id = {$params['txt_id']}");

		// return $this->load_data_customer();
	}

	public function delete_data_customer($params = array())
	{
		$this->table = 'customer';

		$this->edit(['c_is_active' => 'N'], "c_id = {$params['txt_id']}");
		
		return $this->load_data_customer();
	}

	public function load_data($params = array())
	{
		$this->db->where('il_item', strtoupper($params['txt_item']));
		$this->db->where('il_is_active', 'Y');

		return $this->db->get('customer');
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

 	public function get_district_option($params)
	{
		$this->db->where('rsd_district_id', $params['district_id']);
		$this->db->order_by('rsd_name', 'ASC');
		
		return $this->db->get('ref_sub_district');
 	}
	public function get_option_customer()
	{
		$this->db->where('c_is_active', 'Y');
		$this->db->order_by('c_name', 'ASC');

		return $this->db->get('customer');
 	}

	public function delete_data($params = array())
	{
		$this->table = 'customer';

		return $this->edit(['c_is_active' => 'N'], "c_id = {$params['txt_id']}");
		
	}

	public function store_data($params = array())
	{
		$this->table = 'customer';

		$this->db->where('il_item_name', $params['txt_item']);

		$qry = $this->db->get($this->table);

		if ($qry->num_rows() > 0)
		{
			$row = $qry->row();

			$this->edit(['il_similar_letter' => $row->il_similar_letter.';'.$params['txt_similar_letter']], "il_id = {$row->il_id}");

			return $this->load_data(['txt_item' => $row->il_item]);
		}
		return FALSE;
	}
}