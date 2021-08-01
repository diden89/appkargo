<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/models/User_model.php
 */

class Tarif_ekspedisi_model extends NOOBS_Model
{
	public function get_provinsi($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rp_name','ASC');
		return $this->db->get('ref_province');
	}

	public function get_district($where=array())
	{
		$this->db->select('*');
		$this->db->from('ref_district rd');
		$this->db->join('ref_province rp','rp.rp_id = rd.rd_province_id','LEFT');
		$this->db->where($where);
		$this->db->order_by('rd_name','ASC');
		return $this->db->get();
	}

	public function get_kec_data($where=array())
	{
		$this->db->where($where);
		$this->db->order_by('rsd_name','ASC');
		return $this->db->get('ref_sub_district');
	}

	public function cek_access_user($params=array())
	{
		$this->db->where($params);

		return $this->db->get('shipping');
	}

	public function delete_shipping_cost($params=array())
	{
		$this->db->where('sh_id',$params['sh_id']);
		
		if(isset($params['rsd_id'])){
			$this->db->where_not_in('sh_rsd_id',$params['rsd_id']);
		}

		return $this->db->delete('shipping');
	}
	
	public function get_shipping_data($where=array())
	{
		$this->db->where($where);
		return $this->db->get('shipping');
	}

	public function store_data($params = array())
	{
		$this->table = 'shipping';
		$new_params = array(
			'mau_user_id' => $params['mau_user_id'],
			'mau_menu_id' => $params['mau_menu_id'],
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "mau_id = {$params['mau_id']}");
	}
}