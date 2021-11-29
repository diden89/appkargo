<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/transaksi/models/Tagihan_pembayaran_model.php
 */

class Tagihan_pembayaran_model extends NOOBS_Model
{

	public function load_vendor() // di pakai
	{		
		$this->db->where('v_is_active', 'Y');
		$this->db->like('v_unique_access_key', md5($this->session->userdata('user_id')));
		$this->db->order_by('v_vendor_name', 'ASC');

		return $this->db->get('vendor');
 	}

 	public function load_template_laporan($params) // di pakai
	{		
		$this->db->where('tl_is_active', 'Y');
		$this->db->where('tl_vendor_id', $params['vendor']);
		$this->db->where('tl_so_tipe', $params['tipe_so']);
		
		return $this->db->get('template_laporan');
 	}

	public function load_data_rekap_tagihan($params = array())
	{
		// print_r($params);exit;
		// $this->db->select('*,(select (dod.dod_shipping_qty * sh_cost) as cost from shipping where sh_rsd_id = c.c_district_id) as ongkir');
		$this->db->select('*');
		$this->db->from('delivery_order_detail as dod');
		$this->db->join('customer as c','c.c_id = dod.dod_customer_id','LEFT');
		$this->db->join('sales_order_detail as sod','sod.sod_id = dod.dod_sod_id','LEFT');
		$this->db->join('sales_order as so','sod.sod_no_trx = so.so_no_trx','LEFT');
		$this->db->join('ref_sub_district as rsd','rsd.rsd_id = c.c_district_id','LEFT');
		$this->db->join('vehicle as ve','ve.ve_id = dod.dod_vehicle_id','LEFT');
		$this->db->join('driver as d','d.d_id = dod.dod_driver_id','LEFT');
		$this->db->join('item_list as il','il.il_id = sod.sod_item_id','LEFT');
		$this->db->join('delivery_order_status as dos','dos.dos_dod_id = dod.dod_id','LEFT');
		
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(dod.dod_no_trx)', strtoupper($params['txt_item']));
			$this->db->or_like('UPPER(c.c_name)', strtoupper($params['txt_item']));
			$this->db->or_like('UPPER(il.il_item_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('dod.dod_id', strtoupper($params['txt_id']));
		}

		if (isset($params['so_no_trx']) && ! empty($params['so_no_trx']))
		{
			$this->db->where('so.so_no_trx', strtoupper($params['so_no_trx']));
		}

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}

		if (isset($params['vendor']) && ! empty($params['vendor']))
		{
			$this->db->where('so.so_vendor_id', strtoupper($params['vendor']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('dod.dod_created_date >=', $params['date_range1']);
			$this->db->where('dod.dod_created_date <=', $params['date_range2']);
		}

		$this->db->where('dod.dod_is_active', 'Y');
		$this->db->where('so.so_is_pay', 'BL');
		$this->db->where('so.so_is_status', 'SELESAI');
		// $this->db->where('dod.dod_is_status !=', 'SELESAI');
		$this->db->order_by('so.so_created_date', 'ASC');
		// $this->db->order_by('il.il_item_name', 'ASC');

		return $this->db->get();
 	}

 	public function load_data_rekap_tagihan_transfer($params = array())
	{
		// print_r($params);exit;
		// $this->db->select('*,(select (dod.dod_shipping_qty * sh_cost) as cost from shipping where sh_rsd_id = c.c_district_id) as ongkir');
		$this->db->select('*,
			dotd.dotd_shipping_qty as dod_shipping_qty, 
			dots.dots_filled as dos_filled, 
			dotd.dotd_created_date as dod_created_date, 
			dots.dots_created_date as dos_created_date, 
			dots.dots_ongkir as dos_ongkir, 
			dots.dots_status as dos_status, 
			dotd.dotd_is_status as dod_is_status, 
			dotd.dotd_no_trx as dod_no_trx, 
			c.c_name as c_name_from, 
			c2.c_shipping_area_transfer as c_transfer, 
			c2.c_name as c_name_to'
		);
		$this->db->from('delivery_order_transfer_detail as dotd');
		$this->db->join('customer as c','c.c_id = dotd.dotd_customer_id_from','LEFT');
		$this->db->join('customer as c2','c2.c_id = dotd.dotd_customer_id_to','LEFT');
		$this->db->join('sales_order_detail as sod','sod.sod_id = dotd.dotd_sod_id','LEFT');
		$this->db->join('sales_order as so','sod.sod_no_trx = so.so_no_trx','LEFT');
		$this->db->join('ref_sub_district as rsd','rsd.rsd_id = c.c_district_id','LEFT');
		$this->db->join('vehicle as ve','ve.ve_id = dotd.dotd_vehicle_id','LEFT');
		$this->db->join('driver as d','d.d_id = dotd.dotd_driver_id','LEFT');
		$this->db->join('item_list as il','il.il_id = sod.sod_item_id','LEFT');
		$this->db->join('delivery_order_transfer_status as dots','dots.dots_dotd_id = dotd.dotd_id','LEFT');
		
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(dotd.dotd_no_trx)', strtoupper($params['txt_item']));
			$this->db->or_like('UPPER(c.c_name)', strtoupper($params['txt_item']));
			$this->db->or_like('UPPER(il.il_item_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('dotd.dotd_id', strtoupper($params['txt_id']));
		}

		if (isset($params['so_no_trx']) && ! empty($params['so_no_trx']))
		{
			$this->db->where('so.so_no_trx', strtoupper($params['so_no_trx']));
		}

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}

		if (isset($params['vendor']) && ! empty($params['vendor']))
		{
			$this->db->where('so.so_vendor_id', strtoupper($params['vendor']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('dotd.dotd_created_date >=', $params['date_range1']);
			$this->db->where('dotd.dotd_created_date <=', $params['date_range2']);
		}

		$this->db->where('dotd.dotd_is_active', 'Y');
		$this->db->where('so.so_is_pay', 'BL');
		$this->db->where('so.so_is_status', 'SELESAI');
		// $this->db->where('dotd.dotd_is_status !=', 'SELESAI');
		$this->db->order_by('so.so_created_date', 'ASC');
		// $this->db->order_by('il.il_item_name', 'ASC');

		return $this->db->get();
 	}
}