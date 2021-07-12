<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab/apps/module_frontend/trademark/models/Rab_list_model.php
 */

class Rab_list_model extends NOOBS_Model
{
	public function load_data($params = array())
	{
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->where('ir.ir_item_name', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('rl.rl_id', strtoupper($params['txt_id']));
		}

		$this->db->select("rl.rl_id as id,rl.rl_ir_id,rl.rl_il_id, ir.ir_un_id as ir_un_id,il.il_un_id as il_un_id,rl.rl_volume as volume,il.il_item_name as material, ir.ir_item_name as work, un_rl.un_name as unit_rab,un_il.un_name as unit_item,rl.rl_un_id", FALSE);
		$this->db->from("rab_list rl");
		$this->db->join("item_rab ir","ir.ir_id = rl.rl_ir_id","LEFT");
		$this->db->join("item_list il","il.il_id = rl.rl_il_id","LEFT");
		$this->db->join("unit un_rl","ir.ir_un_id = un_rl.un_id","LEFT");
		$this->db->join("unit un_il","un_il.un_id = rl.rl_un_id","LEFT");
		$this->db->where('rl.rl_is_active', 'Y');
		// $this->db->where('un_rl.un_is_active', 'Y');
		$this->db->order_by('ir.ir_seq', 'ASC');

		return $this->create_result($params);
 	}

	public function store_data_item($params = array())
	{
		$this->table = 'rab_list';

		$new_params = array(
			'rl_ir_id' => $params['rl_ir_id'],
			'rl_il_id' => $params['rl_il_id'],
			'rl_un_id' => $params['rl_un_id'],
			'rl_volume' => $params['rl_volume']
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "rl_id = {$params['txt_id']}");

		return $this->load_data();
	}

	public function delete_data($params = array())
	{
		$this->table = 'rab_list';

		$this->edit(['rl_is_active' => 'N'], "rl_id = {$params['txt_id']}");
		
		return $this->load_data();
	}

	public function load_data1($params = array())
	{
		$this->db->where('rl_item', strtoupper($params['txt_item']));
		$this->db->where('rl_is_active', 'Y');

		return $this->db->get('rab_list');
 	}

 	public function get_option_unit($where = array(), $table = "")
	{
		$this->db->where($where);

		return $this->db->get($table);
 	}
}