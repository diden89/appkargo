<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/models/Item_unit_model.php
 */

class Item_unit_model extends NOOBS_Model
{
	public function load_data_item_unit($params = array())
	{
		if (isset($params['txt_unit']) && ! empty($params['txt_unit']))
		{
			$this->db->like('un_name', strtoupper($params['txt_unit']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('un_id', strtoupper($params['txt_id']));
		}

		$this->db->select("un_id AS id, un_name", FALSE);
		$this->db->where('un_is_active', 'Y');
		$this->db->order_by('un_name', 'ASC');

		return $this->db->get('unit');
 	}

	public function store_data_item_unit($params = array())
	{
		$this->table = 'unit';

		if (isset($params['mode']) && $params['mode'] == 'edit')
		{
			$id = $params['txt_id'];

			$this->edit(['un_name' => $params['txt_unit']], "un_id = {$id}");
		}
		else $this->add(['un_name' => $params['txt_unit']]);

		return $this->load_data_item_unit();
	}

	public function delete_data_item_unit($params = array())
	{
		$this->table = 'unit';

		$this->edit(['un_is_active' => 'N'], "un_id = {$params['txt_id']}");
		
		return $this->load_data_item_unit();
	}

	public function load_data($params = array())
	{
		$this->db->where('un_name', strtoupper($params['txt_unit']));
		$this->db->where('un_is_active', 'Y');

		return $this->db->get('unit');
 	}

	public function delete_data($params = array())
	{
		$this->table = 'unit';

		$this->db->where('un_id', $params['txt_id']);

		$qry = $this->db->get($this->table);

		if ($qry->num_rows() > 0)
		{
			$row = $qry->row();

			$exp = explode(';', $row->un_similar_letter);
			$data = [];

			foreach ($exp as $k => $v)
			{
				if ($v == $params['txt_unit']) continue;

				$data[] = $v;
			}

			$this->edit(['un_similar_letter' => implode(';', $data)], "un_id = {$params['txt_id']}");

			return $this->load_data(['txt_unit' => $row->un_name]);
		}
		return FALSE;
	}

	public function store_data($params = array())
	{
		$this->table = 'unit';

		$this->db->where('un_name', $params['txt_unit']);

		$qry = $this->db->get($this->table);

		if ($qry->num_rows() > 0)
		{
			$row = $qry->row();

			$this->edit(['un_similar_letter' => $row->un_similar_letter.';'.$params['txt_similar_letter']], "un_id = {$row->un_id}");

			return $this->load_data(['txt_unit' => $row->un_name]);
		}
		return FALSE;
	}
}