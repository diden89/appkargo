<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/models/Vendor_model.php
 */

class Vendor_model extends NOOBS_Model
{
	public function load_data_vendor($params = array())
	{
		$this->db->select('*');
		$this->db->from('vendor');

		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(v_vendor_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('v_id', strtoupper($params['txt_id']));
		}

		// if (isset($params['date_range1']) && ! empty($params['date_range1']))
		// {
		// 	$this->db->where('last_datetime >=', $params['date_range1']);
		// 	$this->db->where('last_datetime <=', $params['date_range2']);
		// }

		$this->db->where('v_is_active', 'Y');
		$this->db->order_by('v_vendor_name', 'ASC');

		return $this->create_result($params);
 	}

 	public function get_data_vendor($params = array())
	{
		$this->db->select('*');
		$this->db->from('vendor');

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('v_id', strtoupper($params['txt_id']));
		}

		$this->db->where('v_is_active', 'Y');
		$this->db->order_by('v_vendor_name', 'ASC');

		return $this->db->get();
 	}

 	public function get_autocomplete_data($params = array())
	{
		$this->db->select("
			*,
			v_id as id,
			v_vendor_name as text,
			v_vendor_name as full_name
		", FALSE);

		$this->db->from('vendor');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(v_vendor_name LIKE '%{$query}%' OR v_vendor_email LIKE '%{$query}%')", NULL, FALSE);
		}

		$this->db->where('v_is_active', 'Y');
		$this->db->order_by('v_vendor_name', 'ASC');

		return $this->create_autocomplete_data($params);
	}

	public function store_data($params = array())
	{
		$this->table = 'vendor';

		$new_params = array(
			'v_vendor_name' => $params['v_vendor_name'],
			'v_vendor_add' => $params['v_vendor_add'],
			'v_vendor_phone' => $params['v_vendor_phone'],
			'v_vendor_email' => $params['v_vendor_email'],
			'v_user_access' => $params['v_akses'],
			'v_unique_access_key' => $params['v_unique_akses']
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "v_id = {$params['txt_id']}");
	}

	public function delete_data($params = array())
	{
		$this->table = 'vendor';

		return $this->edit(['v_is_active' => 'N'], "v_id = {$params['txt_id']}");
	}

	public function cek_before_delete($params = array(),$table,$initial)
	{
		$this->db->where($initial.'_vendor_id', $params['txt_id']);

		return $this->db->get($table);
	}

	public function get_user_akses($params = array())
	{
		$this->db->where('ud_is_active', 'Y');

		return $this->db->get('user_detail');
	}

}