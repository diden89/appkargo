<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/models/Delivery_order_cost_model.php
 */

class Delivery_order_cost_model extends NOOBS_Model
{
	public function load_data($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*');
		$this->db->from('delivery_order_cost as doc');
		$this->db->join('delivery_order_cost_detail as docd','doc.doc_so_no_trx = docd.docd_doc_so_no_trx','LEFT');
		$this->db->join('vehicle as v','v.ve_id = doc.doc_vehicle_id','LEFT');
		// $this->db->join('driver as d','d.d_id = ','LEFT');

		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(doc.doc_so_no_trx)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('doc.doc_id', $params['txt_id']);
		}

		$this->db->where('doc.doc_is_active', 'Y');
		$this->db->order_by('doc.doc_so_no_trx', 'ASC');

		return $this->create_result($params);
 	}

 	public function get_autocomplete_data($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*');
		$this->db->from('delivery_order_cost as doc');
		$this->db->join('delivery_order_cost_detail as docd','doc.doc_id = docd.docd_doc_id','LEFT');
		$this->db->join('vehicle as v','v.ve_id = doc.doc_vehicle_id','LEFT');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(doc.doc_so_no_trx LIKE '%{$query}%' OR v.ve_license_plate LIKE '%{$query}%')", NULL, FALSE);
		}

		$this->db->where('doc.doc_is_active', 'Y');
		$this->db->order_by('doc.doc_so_no_trx', 'ASC');

		return $this->create_autocomplete_data($params);
 	}

 	public function get_kas_bank()
	{
		$this->db->where('rad_is_bank', 'Y');
		$this->db->where('rad_is_active', 'Y');
		$this->db->where('rad_type', 'D');
		$this->db->order_by('rad_seq', 'ASC');
		
		return $this->db->get('ref_akun_detail');
 	}

 	public function get_akun_header()
	{
		$this->db->where('rah_is_active', 'Y');
		$this->db->order_by('rah_seq', 'ASC');
		
		return $this->db->get('ref_akun_header');
 	}

 	public function get_akun_detail_option($params)
	{
		$this->db->select('*');
		$this->db->from('ref_akun_detail as rad');
		$this->db->join('ref_akun_header as rah','rah.rah_id = rad.rad_akun_header_id','LEFT');

		if (isset($params['rah_id']) && ! empty($params['rah_id']))
		{
			$this->db->where('rad.rad_akun_header_id', strtoupper($params['rah_id']));
		}

		$this->db->where('rad.rad_type', 'D');
		$this->db->where('rad.rad_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function get_vehicle_option($params)
	{
		$this->db->select('DISTINCT(dod_vehicle_id) as vehicle_id,ve.ve_license_plate as vehicle_plate');
		$this->db->from('delivery_order_detail as dod');
		$this->db->join('sales_order_detail as sod','dod.dod_sod_id = sod.sod_id','LEFT');
		$this->db->join('sales_order as so','so.so_no_trx = sod.sod_no_trx','LEFT');
		$this->db->join('vehicle as ve','ve.ve_id = dod_vehicle_id','LEFT');

		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->where('so.so_id', strtoupper($params['no_trx']));
		}

		// $this->db->where('rad.rad_type', 'D');
		// $this->db->where('rad.rad_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function store_temporary_data($params = array())
	{
		$this->table = 'cash_in_detail';
		// print_r($params);exit;
		$new_params = array(
			'cid_ci_no_trx' => $params['cid_no_trx'],
			'cid_rad_id' => $params['akun_detail'],
			'cid_keterangan' => $params['cid_keterangan'],
			'cid_total' => str_replace(',','',$params['cid_total']),
			'cid_key_lock' => $params['cid_key_lock'],
		);
		if ($params['cid_id'] == false) 
		{
			$this->add($new_params, TRUE);
		}
		elseif (isset($params['cid_id']) && ! empty($params['cid_id'])) 
		{
			$this->edit($new_params, "cid_id = {$params['cid_id']}");

		}
		else
		{
			$this->add($new_params, TRUE);
		}

		return $this->load_data_cash_in_detail(array('cid_ci_no_trx' => $params['cid_no_trx']));
	}

	public function store_data_customer($params = array())
	{
		$this->table = 'customer';

		$new_params = array(
			'c_name' => $params['c_name'],
			'c_address' => $params['c_address'],
			'c_phone' => $params['c_phone'],
			'c_email' => $params['c_email'],
			'c_district_id' => $params['c_district_id'],
			'c_shipping_area' => $params['c_shipping_area'],
			'c_shipping_area_transfer' => $params['c_shipping_area_transfer'],
			'c_distance_area' => $params['c_distance_area']
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "c_id = {$params['txt_id']}");

		// return $this->load_data();
	}

	public function delete_data_customer($params = array())
	{
		$this->table = 'customer';

		$this->edit(['c_is_active' => 'N'], "c_id = {$params['txt_id']}");
		
		return $this->load_data();
	}

	public function load_data_($params = array())
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

 	public function get_option_no_trx()
	{
		$query = $this->db->query(
			'
			select * from sales_order where so_no_trx not in (select doc_so_no_trx from delivery_order_cost where doc_is_active = "Y")
			and so_is_active = "Y"
			'
		);
		
		
		return $query;
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
	public function get_option_customer()
	{
		$this->db->where('c_is_active', 'Y');
		$this->db->order_by('c_name', 'ASC');

		return $this->db->get('customer');
 	}

	public function delete_data($params = array())
	{
		$this->table = 'customer';

		return $this->edit(['c_is_active' => 'N'], "c_id = {$params['txt_id']}");
		
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