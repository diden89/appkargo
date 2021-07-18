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
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(v_vendor_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('v_id', strtoupper($params['txt_id']));
		}

		$this->db->where('v_is_active', 'Y');
		$this->db->order_by('v_vendor_name', 'ASC');

		return $this->db->get('vendor');
 	}

	public function store_data_vendor($params = array())
	{
		$this->table = 'vendor';

		$new_params = array(
			'v_vendor_name' => $params['v_vendor_name'],
			'v_vendor_add' => $params['v_vendor_add'],
			'v_vendor_phone' => $params['v_vendor_phone'],
			'v_vendor_email' => $params['v_vendor_email']
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "v_id = {$params['txt_id']}");

		return $this->load_data_vendor();
	}

	public function delete_data_vendor($params = array())
	{
		$this->table = 'vendor';

		$this->edit(['v_is_active' => 'N'], "v_id = {$params['txt_id']}");
		
		return $this->load_data_vendor();
	}
	public function cek_before_delete($params = array(),$table,$initial)
	{
		$this->db->where($initial.'_vendor_id', $params['txt_id']);

		$this->db->get($table);

		return $this->load_data_vendor();
	}

	public function load_data($params = array())
	{
		$this->db->where('il_item', strtoupper($params['txt_item']));
		$this->db->where('il_is_active', 'Y');

		return $this->db->get('vendor');
 	}

	public function delete_data($params = array())
	{
		$this->table = 'vendor';

		$this->db->where('il_id', $params['txt_id']);

		$qry = $this->db->get($this->table);

		if ($qry->num_rows() > 0)
		{
			$row = $qry->row();

			$exp = explode(';', $row->il_similar_letter);
			$data = [];

			foreach ($exp as $k => $v)
			{
				if ($v == $params['txt_item']) continue;

				$data[] = $v;
			}

			$this->edit(['il_similar_letter' => implode(';', $data)], "il_id = {$params['txt_id']}");

			return $this->load_data(['txt_item' => $row->il_item]);
		}
		return FALSE;
	}

	public function store_data($params = array())
	{
		$this->table = 'vendor';

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