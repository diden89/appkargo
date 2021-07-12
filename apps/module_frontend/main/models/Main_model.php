<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/main/models/Main_model.php
 */

class Main_model extends NOOBS_Model {
	public function get_profile($token = array())
	{
		$id = $token['ud_id'];
		$username = $token['ud_username'];

		$this->db->select("*, DATE_FORMAT(ud_dob, '%d-%m-%Y-%Y') as ud_dob_new", FALSE);
		$this->db->where('ud_id', $id);
		$this->db->where('ud_username', $username);
		$this->db->where('ud_is_active', 'Y');

		return $this->db->get('user_detail');
	}

	public function store_biodata($data = array())
	{
		$this->table = 'user_detail';
		$decrypt_token = $this->decrypt_token();
		$ud_id = $decrypt_token['ud_id'];

		$params = array(
			'ud_fullname' => $data['txt_fullname'],
			'ud_dob' => $data['txt_dob'],
			'ud_pob' => $data['txt_pob'],
			'ud_email' => $data['txt_email']
		);

		if (isset($data['upload_data']))
		{
			$params['ud_img_filename'] = $data['upload_data']['file_name'];
			$params['ud_img_ori'] = $data['upload_data']['orig_name'];
		}

		return $this->edit($params, "ud_id = {$ud_id}");
	}

	public function store_login_access($data = array())
	{
		$this->table = 'user_detail';
		$decrypt_token = $this->decrypt_token();
		$ud_id = $decrypt_token['ud_id'];

		$params = array(
			'ud_password' => sha1(strtoupper($this->session->userdata('username').':'.$data['txt_password_1']))
		);

		return $this->edit($params, "ud_id = {$ud_id}");
	}

	public function get_all_menu() {
		$this->db->select("
			rm_id as id,
			rm_parent_id as parent_id,
			rm_caption as caption,
			rm_description as description,
			rm_url as url,
			rm_icon as icon
		", FALSE);

		$this->db->from('ref_menu rm');
		$this->db->where('rm.rm_is_active', 'Y');
		$this->db->order_by('rm.rm_sequence', 'asc');

		return $this->db->get();
	}

	public function get_access_menu() {
		$decrypt_token = $this->decrypt_token();
		
		$ud_id = $decrypt_token['ud_id'];

		$this->db->select("mau_menu_id as id");

		$this->db->from('menu_access_user mau');
		$this->db->join('user_detail ud', 'mau.mau_user_id = ud.ud_id', 'LEFT');

		$this->db->where('ud.ud_id', $ud_id);

		$this->db->where('mau.mau_is_active', 'Y');
		$this->db->where('ud.ud_is_active', 'Y');

		$qry = $this->db->get();

		if ($qry->num_rows() > 0)
		{
			$result = $qry->result_array();
			$data = array();

			foreach ($result as $k => $v)
			{
				$data[] = $v['id'];
			}

			return $data;
		} else return FALSE;
	}

	public function get_user_group_menu() {
		$decrypt_token = $this->decrypt_token();

		$ud_id = $decrypt_token['ud_id'];

		$this->db->select("mag_rm_id as id");

		$this->db->from('menu_access_group mag');
		$this->db->join('user_sub_group usg', 'mag.mag_ug_id = usg.usg_group', 'LEFT');
		$this->db->join('user_detail ud', 'usg.usg_id = ud.ud_sub_group', 'LEFT');

		$this->db->where('ud.ud_id', $ud_id);
		$this->db->where('mag.mag_is_active', 'Y');
		$this->db->where('usg.usg_is_active', 'Y');
		$this->db->where('ud.ud_is_active', 'Y');

		$qry = $this->db->get();

		if ($qry->num_rows() > 0)
		{
			$result = $qry->result_array();
			$data = array();

			foreach ($result as $k => $v)
			{
				$data[] = $v['id'];
			}

			return $data;
		} else return FALSE;
	}

	public function get_user_sub_group_menu() {
		$decrypt_token = $this->decrypt_token();

		$ud_id = $decrypt_token['ud_id'];

		$this->db->select("masg_rm_id as id");

		$this->db->from('menu_access_sub_group masg');
		$this->db->join('user_detail ud', 'masg.masg_usg_id = ud.ud_sub_group', 'LEFT');

		$this->db->where('ud.ud_id', $ud_id);
		$this->db->where('masg.masg_is_active', 'Y');
		$this->db->where('ud.ud_is_active', 'Y');

		$qry = $this->db->get();

		if ($qry->num_rows() > 0)
		{
			$result = $qry->result_array();
			$data = array();

			foreach ($result as $k => $v)
			{
				$data[] = $v['id'];
			}

			return $data;
		} else return FALSE;
	}
}