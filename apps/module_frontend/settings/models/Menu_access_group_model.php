<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/models/User_model.php
 */

class Menu_access_group_model extends NOOBS_Model
{
	public function get_user_group($where=array())
	{
		$this->db->where($where);
		return $this->db->get('user_group');
	}

	public function get_access_group($where=array())
	{
		$this->db->where($where);
		return $this->db->get('menu_access_group');
	}

	public function cek_access_group($params=array())
	{
		$this->db->where($params);

		return $this->db->get('menu_access_group');
	}

	public function delete_access_group($params=array())
	{
		$this->db->where('mag_ug_id',$params['ug_id']);
		if(isset($params['rm_id']))
		{
			$this->db->where_not_in('mag_rm_id',$params['rm_id']);
		}

		return $this->db->delete('menu_access_group');
	}
	
	public function get_menu($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rm_sequence', 'asc');
		return $this->db->get('ref_menu');
	}

	public function store_data($params = array())
	{
		$this->table = 'menu_access_group';
		$new_params = array(
			'mag_ug_id' => $params['mag_ug_id'],
			'mag_rm_id' => $params['mag_rm_id'],
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "mag_id = {$params['mag_id']}");
	}
}