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

	public function cek_shipping_code($params=array())
	{
		$this->db->where($params);

		return $this->db->get('shipping');
	}

	public function delete_shipping_cost($params=array())
	{
		$this->db->where('sh_rd_id',$params['rd_id']);		
		// if(isset($params['rsd_id'])){
		// 	$this->db->where_not_in('sh_rsd_id',$params['rsd_id']);
		// }

		return $this->db->delete('shipping');
	}
	
	public function get_shipping_data($where=array())
	{
		$this->db->where($where);
		return $this->db->get('shipping');
	}

	public function store_data($params = array())
	{
		// print_r($params);exit;
		$this->table = 'shipping';
		$new_params = array(
			'sh_rsd_id' => $params['sh_rsd_id'],
			'sh_rd_id' => $params['sh_rd_id'],
			'sh_cost' => $params['sh_cost'],
		);

		return $this->add($new_params, TRUE);
		
	}
}