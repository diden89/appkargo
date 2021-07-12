<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/projects/models/Projects_data_model.php
 */

class Material_consumption_model extends NOOBS_Model
{
	public function get_data_material($params = array())
	{
		$this->db->select('*');
		$this->db->from('material_consumption mc');
		$this->db->join('item_list il','mc.mc_il_id = il.il_id','LEFT');
		$this->db->join('unit un','il.il_un_id = un.un_id','LEFT');
		$this->db->join('projects_sub ps','mc.mc_ps_id = ps.ps_id','LEFT');
		$this->db->join('projects p','ps.ps_p_id = p.p_id','LEFT');
		$this->db->where('mc.mc_is_active','Y');

		if (isset($params['ps_id']) && ! empty($params['ps_id']))
		{
			$this->db->where('mc.mc_ps_id', strtoupper($params['ps_id']));
		}

		if (isset($params['years']) && ! empty($params['years']))
		{
			$this->db->where('YEAR(mc.mc_date_order)', strtoupper($params['years']));
		}

		if (isset($params['month']) && ! empty($params['month']))
		{
			$this->db->where('MONTH(mc.mc_date_order)', strtoupper($params['month']));
		}

		return $this->db->get();
	}

	public function get_sub_data($where=array())
	{
		$this->db->select('*');
		$this->db->from('projects_sub ps');
		$this->db->join('projects p','p.p_id = ps.ps_p_id','LEFT');
		$this->db->join('building_type bt','bt.bt_id = ps.ps_bt_id','LEFT');
		$this->db->where('ps.ps_is_active','Y');
		$this->db->where($where);
		return $this->db->get();
	}

	public function store_data_material($params = array())
	{
		$this->table = 'material_consumption';
		$new_params = array(
			'mc_il_id' => $params['il_id'],
			'mc_ps_id' => $params['ps_id'],
			'mc_price' => str_replace(',','',$params['mc_price']),
			'mc_quantity' => str_replace(',','',$params['mc_quantity']),
			'mc_total' => str_replace(',','',$params['mc_total']),
			'mc_date_order' => date('Y-m-d H:i:s',strtotime($params['mc_date_order'])),
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "mc_id = {$params['mc_id']}");
	}

	public function store_data_projects_sub($params = array())
	{
		$this->table = 'projects_sub';
		$new_params = array(
			'ps_p_id' => $params['ps_p_id'],
			'ps_bt_id' => $params['ps_bt_id'],
			'ps_name' => $params['ps_name'],
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "ps_id = {$params['ps_id']}");
	}

	public function get_option($where = array(), $table = "")
	{
		$this->db->where($where);

		return $this->db->get($table);
 	}

 	public function delete_data($params = array(),$table)
	{
		$this->table = $table;
		if($params['mode'] == 'projects')
		{
			return $this->edit(['p_is_active' => 'N'], "p_id = {$params['txt_p_id']}");
			// return $this->get_data();
		}
		else
		{
			return $this->edit(['ps_is_active' => 'N'], "ps_id = {$params['txt_ps_id']}");
			// return $this->get_sub_data(array());
		}
	}

}