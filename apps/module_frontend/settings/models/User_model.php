<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/models/User_model.php
 */

class User_model extends NOOBS_Model
{
	public function get_data($params = array())
	{
		$this->db->select("
			ud.*,
			IFNULL(DATE_FORMAT(ud.ud_dob, '%d-%m-%Y'), '') as ud_dob_new,
			usg.usg_group
		");

		$this->db->from('user_detail ud');
		$this->db->join('user_sub_group usg', 'ud.ud_sub_group = usg.usg_id', 'LEFT');

		if (isset($params['txt_id']) && !empty($params['txt_id'])) $this->db->where('ud_id', $params['txt_id']);

		$this->db->where('ud_is_active', 'Y');

		return $this->create_result($params);
	}

	public function get_autocomplete_data($params = array())
	{
		$this->db->select("
			ud.*,
			ud_id as id,
			ud_fullname as text,
			ud_fullname as full_name
		", FALSE);

		$this->db->from('user_detail ud');

		$this->db->where('ud_is_active', 'Y');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(ud.ud_username LIKE '%{$query}%' OR ud.ud_fullname LIKE '%{$query}%')", NULL, FALSE);
		}

		return $this->create_autocomplete_data($params);
	}

	public function store_data($params = array())
	{
		$this->table = 'user_detail';

		$ud_password = isset($params['ud_password']) && !empty($params['ud_password']) ? sha1(strtoupper($params['ud_username'] . ':' . $params['ud_password'])) : '';

		$new_params = array(
			'ud_username' => $params['ud_username'],
			'ud_fullname' => $params['ud_fullname'],
			'ud_dob' => $params['ud_dob_new'],
			'ud_pob' => $params['ud_pob'],
			'ud_email' => $params['ud_email'],
			'ud_sub_group' => $params['ud_sub_group'],
			'ud_notif_flag' => $params['ud_notif_flag']
		);

		if (!empty($ud_password)) $new_params['ud_password'] = $ud_password;

		if (isset($params['upload_data']))
		{
			$new_params['ud_img_filename'] = $params['upload_data']['file_name'];
			$new_params['ud_img_ori'] = $params['upload_data']['orig_name'];
		}

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "ud_id = {$params['ud_id']}");
	}

	public function delete_all_menu($ud_id)
	{
		$this->table = 'access_menu';
		return $this->delete('am_user_id', $ud_id);
	}

	public function get_menu_access_sub_group($ud_id)
	{
		$this->db->select("ud.ud_id, asg.asg_rm_id");

		$this->db->from('access_sub_group asg');
		$this->db->join('user_detail ud', 'asg.asg_ug_id = ud.ud_sub_group', 'LEFT');

		$this->db->where('ud.ud_id', $ud_id);
		$this->db->where('asg.asg_is_active', 'Y');

		return $this->db->get();
	}

	public function store_menu_access($params = array())
	{
		$this->table = 'access_menu';

		$new_params = array(
			'am_user_id' => $params['ud_id'],
			'am_menu_id' => $params['asg_rm_id']
		);

		return $this->add($new_params);
	}

	public function delete_data($params = array())
	{
		$this->table = 'user_detail';
		$new_params = array(
			'ud_is_active' => 'N'
		);
		
		return $this->edit($new_params, "ud_id = {$params['ud_id']}");
	}

	public function get_user_group()
	{
		$this->db->where('ug_is_active', 'Y');

		return $this->db->get('user_group');
	}

	public function get_user_sub_group($params = array())
	{
		$this->db->where('usg_is_active', 'Y');

		$this->db->where('usg_group', $params['usg_group']);

		return $this->db->get('user_sub_group');
	}
}