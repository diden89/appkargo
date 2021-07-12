<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/models/Rab_building_model.php
 */

class Rab_building_model extends NOOBS_Model
{
	public function get_data($where=array())
	{
		$this->db->where($where);
		return $this->db->get('building_type');
	}

	public function get_all_rab()
	{
		$this->db->select("rl.rl_id as id,rl.rl_ir_id,rl.rl_il_id, ir.ir_un_id as ir_un_id,il.il_un_id as il_un_id,rl.rl_volume as volume,il.il_item_name as material, ir.ir_item_name as work, un_rl.un_name as unit_rab,un_il.un_name as unit_item,rl.rl_un_id", FALSE);
		$this->db->from("rab_list rl");
		$this->db->join("item_rab ir","ir.ir_id = rl.rl_ir_id","LEFT");
		$this->db->join("item_list il","il.il_id = rl.rl_il_id","LEFT");
		$this->db->join("unit un_rl","ir.ir_un_id = un_rl.un_id","LEFT");
		$this->db->join("unit un_il","un_il.un_id = rl.rl_un_id","LEFT");
		// $this->db->join("rab_building rb","rb.rb_rl_id = rl.rl_id","LEFT");
		$this->db->where('rl.rl_is_active', 'Y');
		// $this->db->where('un_rl.un_is_active', 'Y');
		$this->db->order_by('ir.ir_seq', 'ASC');

		return $this->db->get();
	}

	public function get_rab_building($where = array())
	{
		$this->db->select("rl.rl_id as id,rb.rb_id as rb_id,rl.rl_ir_id,rl.rl_il_id, ir.ir_un_id as ir_un_id,il.il_un_id as il_un_id,rl.rl_volume as volume,il.il_item_name as material, ir.ir_item_name as work, un_rl.un_name as unit_rab,un_il.un_name as unit_item,rl.rl_un_id,rb.rb_measure,rb.rb_summary", FALSE);
		$this->db->from("rab_list rl");
		$this->db->join("item_rab ir","ir.ir_id = rl.rl_ir_id","LEFT");
		$this->db->join("item_list il","il.il_id = rl.rl_il_id","LEFT");
		$this->db->join("unit un_rl","ir.ir_un_id = un_rl.un_id","LEFT");
		$this->db->join("unit un_il","un_il.un_id = rl.rl_un_id","LEFT");
		$this->db->join("rab_building rb","rb.rb_rl_id = rl.rl_id","LEFT");
		$this->db->where('rl.rl_is_active', 'Y');

		$this->db->where($where);
		$this->db->order_by('ir.ir_seq', 'ASC');

		return $this->db->get();
	}

	public function cek_access_group($params=array())
	{
		$this->db->where($params);

		return $this->db->get('menu_access_group');
	}

	public function delete_rab_building($params=array())
	{
		// $this->db->where('rb_id',$params['rb_id']);
		if(isset($params['rb_id']))
		{
			$this->db->where_not_in('rb_id',$params['rb_id']);
		}

		return $this->db->delete('menu_access_group');
	}
	
	public function get_menu($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rm_sequence', 'asc');
		return $this->db->get('ref_menu');
	}

	public function store_data($params = array(),$nParams = array())
	{
		$this->table = 'rab_building';

		if ($nParams['mode'] == 'add') return $this->add($params, TRUE);
		else return $this->edit($params, "rb_id = {$nParams['id']}");
	}
}