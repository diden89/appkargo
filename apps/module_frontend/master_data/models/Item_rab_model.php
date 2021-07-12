<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab/apps/module_frontend/trademark/models/item_rab_model.php
 */

class Item_rab_model extends NOOBS_Model
{
	public function load_data_item_rab($params = array())
	{
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->where('ir.ir_item_name', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('ir.ir_id', strtoupper($params['txt_id']));
		}

		$this->db->select("*, ir.ir_id as id", FALSE);
		$this->db->from("item_rab ir");
		$this->db->join("unit un","ir.ir_un_id = un.un_id","LEFT");
		$this->db->where('ir.ir_is_active', 'Y');
		$this->db->where('un.un_is_active', 'Y');
		$this->db->order_by('ir.ir_seq', 'ASC');

		return $this->create_result($params);
 	}

	public function store_data_item($params = array())
	{
		$this->table = 'item_rab';

		$new_params = array(
			'ir_item_name' => $params['ir_item_name'],
			'ir_seq' => $params['ir_seq'],
			'ir_un_id' => $params['ir_un_id']
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "ir_id = {$params['txt_id']}");

		return $this->load_data_item_rab();
	}

	public function delete_data($params = array())
	{
		$this->table = 'item_rab';

		$this->edit(['ir_is_active' => 'N'], "ir_id = {$params['txt_id']}");
		
		return $this->load_data_item_rab();
	}

	public function load_data($params = array())
	{
		$this->db->where('ir_item', strtoupper($params['txt_item']));
		$this->db->where('ir_is_active', 'Y');

		return $this->db->get('item_rab');
 	}

 	public function get_option_unit()
	{
		$this->db->where('un_is_active', 'Y');

		return $this->db->get('unit');
 	}
}