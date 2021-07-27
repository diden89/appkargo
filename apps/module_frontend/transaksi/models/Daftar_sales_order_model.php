<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/models/Daftar_sales_order_model.php
 */

class Daftar_sales_order_model extends NOOBS_Model
{
	public function load_data_daftar_sales_order($params = array())
	{
		// print_r($params);exit;
		$this->db->select('so.*,rd.rd_name,v.v_vendor_name, (select sum(sod_qty) as so_qty from sales_order_detail where sod_so_id = so.so_id) as so_qty');
		$this->db->from('sales_order as so');
		// $this->db->join('sales_order_detail as sod','sod.sod_so_id = so.so_id','LEFT');
		$this->db->join('vendor as v','v.v_id = so.so_vendor_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = so.so_district_id','LEFT');
		
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(so.so_no_trx)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['txt_id']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('so.so_created_date >=', $params['date_range1']);
			$this->db->where('so.so_created_date <=', $params['date_range2']);
		}

		$this->db->where('so.so_is_active', 'Y');
		$this->db->order_by('so.so_created_date', 'ASC');

		return $this->db->get();
 	}

	public function store_data_daftar_sales_order($params = array())
	{
		$this->table = 'customer';

		$new_params = array(
			'c_name' => $params['c_name'],
			'c_address' => $params['c_address'],
			'c_phone' => $params['c_phone'],
			'c_email' => $params['c_email'],
			'c_district_id' => $params['c_district_id']
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "c_id = {$params['txt_id']}");

		return $this->load_data_daftar_sales_order();
	}

	public function delete_data_daftar_sales_order($params = array())
	{
		$this->table = 'customer';

		$this->edit(['c_is_active' => 'N'], "c_id = {$params['txt_id']}");
		
		return $this->load_data_daftar_sales_order();
	}

	public function load_data($params = array())
	{
		$this->db->where('il_item', strtoupper($params['txt_item']));
		$this->db->where('il_is_active', 'Y');

		return $this->db->get('customer');
 	}

 	public function get_option_province()
	{
		$this->db->order_by('rp_name', 'ASC');
		
		return $this->db->get('ref_province');
 	}

 	public function get_region_option($params)
	{
		$this->db->where('rd_province_id', $params['prov_id']);
		$this->db->order_by('rd_name', 'ASC');
		
		return $this->db->get('ref_district');
 	}

 	public function get_district_option($params)
	{
		$this->db->where('rsd_district_id', $params['district_id']);
		$this->db->order_by('rsd_name', 'ASC');
		
		return $this->db->get('ref_sub_district');
 	}
	public function get_option_vendor()
	{		
		$this->db->where('v_is_active', 'Y');
		$this->db->order_by('v_vendor_name', 'ASC');

		return $this->db->get('vendor');
 	}

 	public function get_option_item_list($params = array())
	{

		if(isset($params['il_id']) && ! empty($params['il_id']))
		{
			$this->db->where('il_id', $params['il_id']);
		}

		$this->db->where('il_is_active', 'Y');
		$this->db->order_by('il_item_name', 'ASC');

		return $this->db->get('item_list');
 	}

	public function delete_data_item($params = array())
	{
		$this->table = 'customer';

		$this->edit(['c_is_active' => 'N'], "c_id = {$params['txt_id']}");
		
		return $this->load_data_daftar_sales_order();
	}

	public function store_data($params = array())
	{
		$this->table = 'customer';

		$this->db->where('il_item_name', $params['txt_item']);

		$qry = $this->db->get($this->table);

		if ($qry->num_rows() > 0)
		{
			$row = $qry->row();

			$this->edit(['il_similar_letter' => $row->il_similar_letter.';'.$params['txt_similar_letter']], "il_id = {$row->il_id}");

			return $this->load_data(['txt_item' => $row->il_item]);
		}
		return FALSE;
	}
}