<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/models/Vehicle_model.php
 */

class Vehicle_model extends NOOBS_Model
{
	public function load_data_vehicle($params = array())
	{
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(ve_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('ve_id', strtoupper($params['txt_id']));
		}

		$this->db->where('ve_is_active', 'Y');
		$this->db->order_by('ve_name', 'ASC');

		return $this->db->get('vehicle');
 	}

	public function store_data_vehicle($params = array())
	{
		$this->table = 'vehicle';

		$new_params = array(
			've_name' => $params['ve_name'],
			've_address' => $params['ve_add'],
			've_phone' => $params['ve_phone'],
			've_email' => $params['ve_email']
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "ve_id = {$params['txt_id']}");

		return $this->load_data_vehicle();
	}

	public function delete_data_vehicle($params = array())
	{
		$this->table = 'vehicle';

		$this->edit(['ve_is_active' => 'N'], "ve_id = {$params['txt_id']}");
		
		return $this->load_data_vehicle();
	}
	public function cek_before_delete($params = array(),$table,$initial)
	{
		$this->db->where($initial.'_vehicle_id', $params['txt_id']);

		$this->db->get($table);

		return $this->load_data_vehicle();
	}

	public function load_data($params = array())
	{
		$this->db->where('il_item', strtoupper($params['txt_item']));
		$this->db->where('il_is_active', 'Y');

		return $this->db->get('vehicle');
 	}

	public function delete_data($params = array())
	{
		$this->table = 'vehicle';

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
		$this->table = 'vehicle';

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