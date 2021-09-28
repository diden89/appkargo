<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/report/models/Report_piutang_model.php
 */

class Report_piutang_model extends NOOBS_Model
{
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

 	public function load_data_rekap_tagihan_new($params = array())
	{
		$this->db->select("
					dod.dod_id,
					dod.dod_no_trx,
					c.c_name,
					c.c_address,
					il.il_item_name,
					d.d_name,
					d.d_address,
					dod.dod_shipping_qty,
					dos.dos_filled,
					dod.dod_ongkir,
					dos.dos_ongkir,
					dos.dos_status,
					dos.dos_created_date,
					dod.dod_created_date,
					ve.ve_license_plate,
					dod.dod_is_status,
					rsd.rsd_name,
					so.so_tipe,
					dos.dos_keterangan",FALSE);

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

		if (isset($params['akses_driver']) && ! empty($params['akses_driver']))
		{
			$this->db->where('d.d_ud_id', strtoupper($params['akses_driver']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('dod.dod_created_date >=', date('Y-m-d',strtotime($params['date_range1'])));
			$this->db->where('dod.dod_created_date <=', date('Y-m-d',strtotime($params['date_range2'])));
		}
		$this->db->where('dod.dod_is_active = "Y"');
		// $this->db->where('dod.dod_is_status !=', 'SELESAI');
		$this->db->order_by('dod.dod_created_date', 'DESC');

		return $this->db->get();
	}

	public function load_data_rekap_tagihan_trf($params = array())
	{
		$this->db->select("dotd.dotd_id as dod_id,
					dotd.dotd_no_trx as dod_no_trx,
					c2.c_name,
					c2.c_address,
					il2.il_item_name,
					d2.d_name,
					d2.d_address,
					dotd.dotd_shipping_qty as dod_shipping_qty,
					dots.dots_filled as dos_filled,
					dotd.dotd_ongkir as dod_ongkir,
					dots.dots_ongkir as dos_ongkir,
					dots.dots_status as dos_status,
					dots.dots_created_date as dos_created_date,
					dotd.dotd_created_date as dod_created_date,
					ve2.ve_license_plate,
					dotd.dotd_is_status as dod_is_status,
					rsd2.rsd_name,
					so2.so_tipe,
					dots.dots_keterangan as dos_keterangan",FALSE);


		$this->db->from('delivery_order_transfer_detail as dotd');
		$this->db->join('customer as c2','c2.c_id = dotd.dotd_customer_id_from','LEFT');
		$this->db->join('sales_order_detail as sod2','sod2.sod_id = dotd.dotd_sod_id','LEFT');
		$this->db->join('sales_order as so2','sod2.sod_no_trx = so2.so_no_trx','LEFT');
		$this->db->join('ref_sub_district as rsd2','rsd2.rsd_id = c2.c_district_id','LEFT');
		$this->db->join('vehicle as ve2','ve2.ve_id = dotd.dotd_vehicle_id','LEFT');
		$this->db->join('driver as d2','d2.d_id = dotd.dotd_driver_id','LEFT');
		$this->db->join('item_list as il2','il2.il_id = sod2.sod_item_id','LEFT');
		$this->db->join('delivery_order_transfer_status as dots','dots.dots_dotd_id = dotd.dotd_id','LEFT');

		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(dotd.dotd_no_trx)', strtoupper($params['txt_item']));
			$this->db->or_like('UPPER(c2.c_name)', strtoupper($params['txt_item']));
			$this->db->or_like('UPPER(il2.il_item_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('dotd.dotd_id', strtoupper($params['txt_id']));
		}

		if (isset($params['so_no_trx']) && ! empty($params['so_no_trx']))
		{
			$this->db->where('so2.so_no_trx', strtoupper($params['so_no_trx']));
		}

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so2.so_id', strtoupper($params['so_id']));
		}

		if (isset($params['akses_driver']) && ! empty($params['akses_driver']))
		{
			$this->db->where('d2.d_ud_id', strtoupper($params['akses_driver']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('dotd.dotd_created_date >=', date('Y-m-d',strtotime($params['date_range1'])));
			$this->db->where('dotd.dotd_created_date <=', date('Y-m-d',strtotime($params['date_range2'])));
		}
		$this->db->where('dotd.dotd_is_active = "Y"');
		// $this->db->where('dotd.dotd_is_status !=', 'SELESAI');
		$this->db->order_by('dotd.dotd_created_date', 'DESC');
		$this->db->order_by('dotd.dotd_id', 'DESC');

		return $this->db->get();
 	}
}