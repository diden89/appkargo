<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/akuntansi/models/Daftar_perkiraan_model.php
 */

class Daftar_perkiraan_model extends NOOBS_Model
{

	public function get_daftar_perkiraan($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rm_sequence', 'asc');
		return $this->db->get('ref_daftar_perkiraan');
	}

	public function get_akun_header($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rah_seq','ASC');

		return $this->db->get('ref_akun_header');
	}

	public function get_akun_detail($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rad_seq','ASC');
		
		return $this->db->get('ref_akun_detail');
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
		
		return $this->db->get('ref_daftar_perkiraan');
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
		
		return $this->db->get('ref_daftar_perkiraan');
	}

	public function get_daftar_perkiraan_option($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rm_id','ASC');
		
		return $this->db->get('ref_daftar_perkiraan');
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
		$this->table = 'ref_akun_detail';

		$new_params = array(
			'rad_type' => (isset($params['rad_type'])) ? $params['rad_type'] : 'D',
			'rad_akun_header_id' => $params['txt_header'],
			'rad_parent_id' => (isset($params['txt_posisi'])) ? $params['txt_posisi'] : '',
			'rad_kode_akun' => $params['txt_header'].'-'.$params['code'],
			'rad_name' => $params['rad_name'],
			'rad_is_bank' => (isset($params['is_bank'])) ? $params['is_bank'] : 'N',
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "rad_id = {$params['txt_detail_id']}");
	}

	public function delete_all_daftar_perkiraan($ud_id)
	{
		$this->table = 'access_daftar_perkiraan';
		return $this->delete('am_user_id', $ud_id);
	}

	public function get_daftar_perkiraan_access_group($ud_id)
	{
		$this->db->select("ud.ud_id, ag.ag_rm_id");

		$this->db->from('access_group ag');
		$this->db->join('user_detail ud', 'ag.ag_usg_id = ud.ud_sub_group', 'LEFT');

		$this->db->where('ud.ud_id', $ud_id);
		$this->db->where('ag.ag_is_active', 'Y');

		return $this->db->get();
	}

	public function store_daftar_perkiraan_access($params = array())
	{
		$this->table = 'access_daftar_perkiraan';

		$new_params = array(
			'am_user_id' => $params['ud_id'],
			'am_daftar_perkiraan_id' => $params['ag_rm_id']
		);

		return $this->add($new_params);
	}

	public function delete_data($params = array())
	{
		$this->table = 'ref_daftar_perkiraan';
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