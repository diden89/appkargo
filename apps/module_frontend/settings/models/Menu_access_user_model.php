<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/models/User_model.php
 */

class Menu_access_user_model extends NOOBS_Model
{
	public function get_user_group($where=array())
	{
		$this->db->where($where);
		return $this->db->get('user_group');
	}

	public function get_user_detail($where=array())
	{
		$this->db->select('
			ud.*,ug.ug_id,usg.usg_id
			');
		$this->db->from('user_detail ud');
		$this->db->join('user_sub_group usg','usg.usg_id = ud.ud_sub_group','LEFT');
		$this->db->join('user_group ug','usg.usg_group = ug.ug_id','LEFT');
		$this->db->where($where);
		return $this->db->get();
	}

	public function get_access_user($where=array())
	{
		$this->db->where($where);
		return $this->db->get('menu_access_user');
	}

	public function cek_access_user($params=array())
	{
		$this->db->where($params);

		return $this->db->get('menu_access_user');
	}

	public function delete_access_user($params=array())
	{
		$this->db->where('mau_user_id',$params['ud_id']);
		
		if(isset($params['rm_id'])){
			$this->db->where_not_in('mau_menu_id',$params['rm_id']);
		}

		return $this->db->delete('menu_access_user');
	}
	
	public function get_menu($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rm_sequence', 'asc');
		return $this->db->get('ref_menu');
	}

	public function store_data($params = array())
	{
		$this->table = 'menu_access_user';
		$new_params = array(
			'mau_user_id' => $params['mau_user_id'],
			'mau_menu_id' => $params['mau_menu_id'],
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "mau_id = {$params['mau_id']}");
	}
}