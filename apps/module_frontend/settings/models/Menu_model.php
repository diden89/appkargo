<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/models/User_model.php
 */

class Menu_model extends NOOBS_Model
{

	public function get_menu($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rm_sequence', 'asc');
		return $this->db->get('ref_menu');
	}

	public function get_parent_id($where="")
	{
		if($where != null || $where != "")
		{
			$this->db->where('rm_id',$where);
		}
		else
		{
			$this->db->where('rm_parent_id',NULL);			
		}
		$this->db->where('rm_is_active','Y');
		$this->db->order_by('rm_sequence', 'DESC');
		$this->db->limit(1);
		
		return $this->db->get('ref_menu');
	}

	public function get_sequence($where="")
	{
		if($where != null || $where != "")
		{
			$this->db->where('rm_parent_id',$where);
		}
		else
		{
			$this->db->where('rm_parent_id',NULL);			
		}
		$this->db->where('rm_is_active','Y');
		$this->db->order_by('rm_sequence', 'DESC');
		$this->db->limit(1);
		
		return $this->db->get('ref_menu');
	}

	public function get_menu_option($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rm_id','ASC');
		
		return $this->db->get('ref_menu');
	}

	public function get_autocomplete_data($params = array())
	{
		$this->db->select("
			ud.*,
			ud_id as id,
			ud_fullname as text
		", FALSE);

		$this->db->from('user_detail ud');

		$this->db->where('ud_is_active', 'Y');

		return $this->create_autocomplete_data($params);
	}

	public function store_data($params = array())
	{
		$this->table = 'ref_menu';

		$new_params = array(
			'rm_caption' => $params['rm_caption'],
			'rm_description' => $params['rm_description'],
			'rm_url' => $params['rm_url'],
			'rm_icon' => $params['rm_icon'],
			'rm_parent_id' => $params['txt_parent_id'],
			'rm_sequence' => $params['rm_sequence'],
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "rm_id = {$params['txt_id_menu']}");
	}

	public function delete_all_menu($ud_id)
	{
		$this->table = 'access_menu';
		return $this->delete('am_user_id', $ud_id);
	}

	public function get_menu_access_group($ud_id)
	{
		$this->db->select("ud.ud_id, ag.ag_rm_id");

		$this->db->from('access_group ag');
		$this->db->join('user_detail ud', 'ag.ag_usg_id = ud.ud_sub_group', 'LEFT');

		$this->db->where('ud.ud_id', $ud_id);
		$this->db->where('ag.ag_is_active', 'Y');

		return $this->db->get();
	}

	public function store_menu_access($params = array())
	{
		$this->table = 'access_menu';

		$new_params = array(
			'am_user_id' => $params['ud_id'],
			'am_menu_id' => $params['ag_rm_id']
		);

		return $this->add($new_params);
	}

	public function delete_data($params = array())
	{
		$this->table = 'ref_menu';
		$new_params = array(
			'rm_is_active' => 'N'
		);
		
		return $this->edit($new_params, "rm_id = {$params['rm_id']}");
	}

	public function get_user_sub_group()
	{
		$this->db->where('usg_is_active', 'Y');

		return $this->db->get('user_sub_group');
	}
}