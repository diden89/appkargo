<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/settings/models/Template_laporan_model.php
 */

class Template_laporan_model extends NOOBS_Model
{
	public function load_data($params = array())
	{
		$this->db->select('*');
		$this->db->from('template_laporan as tl');
		$this->db->join('vendor as v','v.v_id = tl.tl_vendor_id','LEFT');

		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(tl.tl_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('tl.tl_id', strtoupper($params['txt_id']));
		}


		$this->db->where('tl.tl_is_active', 'Y');
		$this->db->order_by('tl.tl_id', 'DESC');

		return $this->create_result($params);
 	}

 	public function get_data($params = array())
	{
		$this->db->select('*');
		$this->db->from('template_laporan as tl');
		$this->db->join('vendor as v','v.v_id = tl.tl_vendor_id','LEFT');

		if (isset($params['tl_id']) && ! empty($params['tl_id']))
		{
			$this->db->where('tl.tl_id', strtoupper($params['tl_id']));
		}
		$this->db->where('tl.tl_is_active', 'Y');
		$this->db->order_by('tl.tl_id', 'DESC');

		return $this->db->get();
 	}

 	public function vendor_option()
	{	
		$this->db->where('v_is_active', 'Y');
		$this->db->order_by('v_vendor_name', 'ASC');

		return $this->db->get('vendor');
 	}

 	public function get_autocomplete_data($params = array())
	{
		$this->db->select("
			*,
			tl_id as id,
			tl_name as text,
			tl_name as full_name
		", FALSE);

		$this->db->from('template_laporan');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(tl_name LIKE '%{$query}%' OR tl_file_template LIKE '%{$query}%')", NULL, FALSE);
		}

		$this->db->where('tl_is_active', 'Y');
		$this->db->order_by('tl_name', 'ASC');

		return $this->create_autocomplete_data($params);
	}

	public function store_data($params = array())
	{
		$this->table = 'vendor';

		$new_params = array(
			'v_name' => $params['v_name'],
			'v_add' => $params['v_add'],
			'v_phone' => $params['v_phone'],
			'v_email' => $params['v_email'],
			'v_user_access' => $params['v_akses'],
			'v_unique_access_key' => $params['v_unique_akses'],
			'v_code' => $params['v_code']
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
		$this->db->where($initial.'_id', $params['txt_id']);

		return $this->db->get($table);
	}

	public function get_user_akses($params = array())
	{
		$this->db->where('ud_is_active', 'Y');

		return $this->db->get('user_detail');
	}

}