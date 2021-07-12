<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/projects/models/Projects_data_model.php
 */

class Projects_data_model extends NOOBS_Model
{
	public function get_data($where=array())
	{
		$this->db->where($where);
		$this->db->where('p_is_active','Y');
		return $this->db->get('projects');
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

	public function store_data_projects($params = array())
	{
		$this->table = 'projects';
		$new_params = array(
			'p_name' => $params['p_name'],
			'p_location' => $params['p_location'],
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "p_id = {$params['p_id']}");
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

	public function get_option_unit($where = array(), $table = "")
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