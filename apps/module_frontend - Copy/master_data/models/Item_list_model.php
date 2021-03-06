<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/models/item_list_model.php
 */

class Item_list_model extends NOOBS_Model
{
	public function load_data_item_list($params = array())
	{
		$this->db->select("*, il.il_id as id", FALSE);
		$this->db->from("item_list il");
		$this->db->join("unit un","il.il_un_id = un.un_id","LEFT");
		$this->db->join("vendor v","v_id = il.il_vendor_id","LEFT");
		$this->db->where('il.il_is_active', 'Y');
		
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(il.il_item_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('il.il_id', $params['txt_id']);
		}

		$this->db->order_by('il.il_item_name', 'ASC');

		return $this->db->get();
 	}

	public function store_data_item($params = array())
	{
		$this->table = 'item_list';

		$new_params = array(
			'il_item_name' => $params['il_item_name'],
			'il_item_code' => $params['il_item_code'],
			'il_vendor_id' => $params['il_vendor_id'],
			'il_un_id' => $params['il_un_id']
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "il_id = {$params['txt_id']}");

		return $this->load_data_item_list();
	}

	public function delete_data_item($params = array())
	{
		$this->table = 'item_list';

		$this->edit(['il_is_active' => 'N'], "il_id = {$params['txt_id']}");
		
		return $this->load_data_item_list();
	}

	public function load_data($params = array())
	{
		$this->db->where('il_item', strtoupper($params['txt_item']));
		$this->db->where('il_is_active', 'Y');

		return $this->db->get('item_list');
 	}

 	public function get_option_unit()
	{
		$this->db->where('un_is_active', 'Y');
		$this->db->order_by('un_name', 'ASC');

		return $this->db->get('unit');
 	}
	public function get_option_vendor()
	{
		$this->db->where('v_is_active', 'Y');
		$this->db->order_by('v_vendor_name', 'ASC');

		return $this->db->get('vendor');
 	}

	public function delete_data($params = array())
	{
		$this->table = 'item_list';

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
		$this->table = 'item_list';

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