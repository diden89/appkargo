<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/models/Daftar_penerimaan_model.php
 */

class Daftar_penerimaan_model extends NOOBS_Model
{
	public function load_data_daftar_penerimaan($params = array())
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
			$this->db->where('dod.dod_created_date >=', $params['date_range1']);
			$this->db->where('dod.dod_created_date <=', $params['date_range2']);
		}

		$this->db->where('dod.dod_is_active', 'Y');
		// $this->db->where('dod.dod_is_status !=', 'SELESAI');
		$this->db->order_by('dod.dod_id', 'DESC');
		// $this->db->order_by('il.il_item_name', 'ASC');

		return $this->db->get();
 	}

	public function cek_driver_akses($params = array())
	{
		if (isset($params['user_id']) && ! empty($params['user_id']))
		{
			$this->db->where('d_ud_id', strtoupper($params['user_id']));
		}

		return $this->db->get('driver');
 	}

 	public function load_data_detail_do($params = array())
	{
		$this->db->select('*');
		$this->db->from('sales_order_detail as sod');
		$this->db->join('sales_order as so','sod.sod_no_trx = so.so_no_trx','LEFT');
		$this->db->join('item_list as il','sod.sod_item_id = il.il_id','LEFT');
		// $this->db->join('customer as c','c.c_id = dod.dod_customer_id','LEFT');
		

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}

		$this->db->where('sod.sod_is_active', 'Y');
		$this->db->order_by('sod.last_datetime', 'ASC');

		return $this->db->get();
 	}

	public function store_data_daftar_penerimaan($params = array()) //dipakai
	{
		$this->table = 'delivery_order_detail';
		
		$new_params = array(
			'dod_no_trx' => $params['no_trx'],
			'dod_sod_id' => $params['dod_sod_id'],
			'dod_driver_id' => $params['dod_driver_id'],
			'dod_customer_id' => $params['dod_customer_id'],
			'dod_vehicle_id' => $params['dod_vehicle_id'],
			'dod_shipping_qty' => $params['dod_shipping_qty'],
			'dod_ongkir' => str_replace(',','',$params['dod_ongkir']),
			'dod_is_status' => 'MUAT',
			'dod_created_date' => date('Y-m-d H:i:s', strtotime($params['dod_created_date'])),
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "dod_id = {$params['dod_id']}");

		return $this->load_data_daftar_penerimaan();
	}


	public function get_quantity($params = array()) //dipakai
	{
		if (isset($params['dod_sod_id']) && ! empty($params['dod_sod_id']))
		{
			$this->db->where('sod_id', strtoupper($params['dod_sod_id']));
		}
		
		return $this->db->get('sales_order_detail');
 	}

 	public function get_total_qty($params = array(),$select = '') //dipakai
	{
		$this->db->select($select);
		$this->db->from('delivery_order_detail');

		if (isset($params['dod_sod_id']) && ! empty($params['dod_sod_id']))
		{
			$this->db->where('dod_sod_id', strtoupper($params['dod_sod_id']));
		}
		
		return $this->db->get();
 	}

 	public function get_total_amount($params = array(),$select = '') //dipakai
	{
		$this->db->select($select);
		$this->db->from('delivery_order_detail as dod');
		$this->db->join('sales_order_detail as sod','dod.dod_sod_id = sod.sod_id', 'LEFT');
		$this->db->join('sales_order as so','so.so_no_trx = sod.sod_no_trx', 'LEFT');

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}
		
		return $this->db->get();
 	}

 	public function get_total_do($params = array(),$total = false) //dipakai
	{
		$this->db->select('SUM(dod.dod_shipping_qty) as total_order');
		// $this->db->from('delivery_order_status as dos');
		$this->db->from('delivery_order_detail as dod');
		$this->db->join('sales_order_detail as sod','dod.dod_sod_id = sod.sod_id','LEFT');

		if ($total == 'total')
		{
			$this->db->where('dod_is_status', strtoupper($params['dod_is_status']));
		}
		
		$this->db->where('sod.sod_no_trx', $params['so_no_trx']);
		
		return $this->db->get();
 	}
 	public function get_total_sod_total($params = array()) //dipakai
	{
		$this->db->select('SUM(sod.sod_qty) as total_sod');
		$this->db->from('sales_order_detail as sod');
		
		$this->db->where('sod.sod_no_trx', $params['so_no_trx']);
		
		return $this->db->get();
 	}

	public function store_penerimaan_status($params = array()) //dipakai
	{
		$this->table = 'delivery_order_status';

		$new_params = array(
			'dos_date' => date('Y-m-d'),
			'dos_dod_id' => $params['dod_id'],
			'dos_filled' => $params['total_terpenuhi'],
			'dos_ongkir' => $params['total_ongkir_upd_hidden'],
			'dos_created_date' => date('Y-m-d H:i:s'),
			'dos_keterangan' => $params['keterangan'],
			'dos_status' => $params['dod_is_status']

		);
		// print_r($params);exit;
		// return $this->add($new_params, TRUE);

		// return $this->load_data_daftar_penerimaan();

		if (empty($params['dos_id'])) return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "dos_id = {$params['dos_id']}");
	}

	public function update_quantity_sales_order_detail($params = array()) //dipakai
	{
		$this->table = 'sales_order_detail';

		$new_params = array(
			'sod_realisasi' => $params['new_qty']

		);

		$this->edit($new_params, "sod_id = {$params['dod_sod_id']}");

		return $this->load_data_daftar_penerimaan();
	}

	public function update_amount_sales_order_detail($params = array()) //dipakai
	{
		$this->table = 'sales_order';

		$new_params = array(
			'so_total_amount' => $params['total_amount']

		);

		$this->edit($new_params, "so_id = {$params['so_id']}");

		return $this->load_data_daftar_penerimaan();
	}

	public function store_update_status_penerimaan($params = array()) //dipakai
	{
		$this->table = 'delivery_order_detail';

		$new_params = array(
			'dod_is_status' => $params['dod_is_status']

		);

		$this->edit($new_params, "dod_id = {$params['dod_id']}");

		return $this->load_data_daftar_penerimaan();
	}

	public function store_update_status_sales_order($params = array()) //dipakai
	{
		$this->table = 'sales_order';

		$new_params = array(
			'so_is_status' => $params['is_status']

		);

		return $this->edit($new_params, "so_id = {$params['so_id']}");

		// return $this->load_data_daftar_penerimaan();
	}

	public function update_status_sales_order_detail($params = array()) //dipakai
	{
		$this->table = 'sales_order';

		$new_params = array(
			'so_is_status' => $params['new_qty']
		);

		return $this->edit($new_params, "sod_id = {$params['dod_sod_id']}");

		// return $this->load_data_daftar_penerimaan();
	}

	// public function store_detail_do($params = array())
	// {
	// 	$this->table = 'delivery_order_detail';

	// 	$new_params = array(
	// 		'sod_no_trx' => $params['sod_no_trx'],
	// 		'sod_qty' => $params['sod_qty'],
	// 		'sod_item_id' => $params['sod_item_id']
	// 	);

	// 	if(! empty($params['so_id'])) {
	// 		$mode = $params['mode'];
	// 	}
	// 	else {
	// 		$mode = 'add';
	// 	}

	// 	if ($mode == 'add') $this->add($new_params, TRUE);
	// 	else $this->edit($new_params, "sod_id = {$params['so_id']}");

	// 	return $this->load_data_detail_do(array('no_trx' => $params['sod_no_trx']));
	// }

	public function delete_data_daftar_penerimaan($params = array()) //di pakai
	{
		$this->table = 'delivery_order_detail';

		$this->edit(['dod_is_active' => 'N'], "dod_id = {$params['txt_id']}");
		
		return $this->load_data_daftar_penerimaan();
	}

	public function load_data($params = array())
	{
		$this->db->where('il_item', strtoupper($params['txt_item']));
		$this->db->where('il_is_active', 'Y');

		return $this->db->get('customer');
 	}

 	public function get_last_notrx()
	{
		$this->db->select('LEFT(so_no_trx,4) as notrx');
		$this->db->order_by('so_id', 'DESC');
		$this->db->limit('1');
		
		return $this->db->get('sales_order');
 	}

	public function get_detail_so_option($params) //dipakai
	{
		$this->db->select('*');
		$this->db->from('sales_order_detail as sod');
		$this->db->join('sales_order as so','sod.sod_no_trx = so.so_no_trx','LEFT');
		$this->db->join('item_list as il','il.il_id = sod.sod_item_id','LEFT');

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}

		$this->db->where('sod.sod_flag', 'N');
		$this->db->where('sod_is_active', 'Y');
		if (isset($params['mode']) && ! $params['mode'] == 'add')
		{
			$this->db->where('sod_qty != sod_realisasi');
		}
		
		$this->db->order_by('sod.sod_id', 'ASC');
		
		return $this->db->get();
 	}

 	public function get_option_so()//dipakai
	{
		$this->db->select('*');
		$this->db->from('sales_order as so');
		$this->db->join('vendor as v','v.v_id = so.so_vendor_id','LEFT');
		
		$this->db->where('so.so_is_status', 'ORDER');
		$this->db->where('so.so_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function get_realisasi_qty($params)//dipakai
	{
		// $this->db->select('*,sod.sod_qty - (select sum(dod_shipping_qty) from delivery_order_detail where dod_sod_id = sod.sod_id) as qty_real');
		$this->db->select('*,(sod.sod_qty - sod.sod_realisasi) as qty_real');
		$this->db->from('sales_order_detail as sod');
		$this->db->where('sod.sod_is_active', 'Y');

		if (isset($params['sod_id']) && ! empty($params['sod_id']))
		{
			$this->db->where('sod.sod_id', strtoupper($params['sod_id']));
		}

		return $this->db->get();
 	}

 	public function get_ongkir_district($params)//dipakai
	{

		$this->db->where('c_is_active', 'Y');
		
		if (isset($params['c_id']) && ! empty($params['c_id']))
		{
			$this->db->where('c_id', strtoupper($params['c_id']));
		}

		return $this->db->get('customer');
 	}

 	public function get_option_customer()//dipakai
	{
		$this->db->where('c_is_active', 'Y');
		
		return $this->db->get('customer');
 	}

 	public function get_option_vehicle()//dipakai
	{
		$this->db->where('ve_is_active', 'Y');
		
		return $this->db->get('vehicle');
 	}

 	public function get_option_driver()//dipakai
	{
		$this->db->where('d_is_active', 'Y');
		
		return $this->db->get('driver');
 	}

 	public function get_region_option($params)
	{
		$this->db->where('rd_province_id', $params['prov_id']);
		$this->db->order_by('rd_name', 'ASC');
		
		return $this->db->get('ref_district');
 	}

 	public function get_item_list_option($params)
	{
		$this->db->select('*');
		$this->db->from('item_list as il');
		$this->db->join('vendor as v','il.il_vendor_id = v.v_id','LEFT');

		if (isset($params['vendor_id']) && ! empty($params['vendor_id']))
		{
			$this->db->where('il.il_vendor_id', strtoupper($params['vendor_id']));
		}

		$this->db->where('il.il_is_active', 'Y');
		$this->db->order_by('il.last_datetime', 'ASC');

		return $this->db->get();
 	}

 	public function get_district_option($params)
	{
		$this->db->where('rsd_district_id', $params['district_id']);
		$this->db->order_by('rsd_name', 'ASC');
		
		return $this->db->get('ref_sub_district');
 	}

 	public function get_customer_option($params) //dipakai
	{
		$query = "select * from customer where c_district_id in (select rsd.rsd_id from ref_sub_district as rsd left join sales_order as so on rsd.rsd_district_id = so.so_district_id where so.so_id = {$params['so_id']} order by c_name ASC)";
		
		return $this->db->query($query);
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

	public function delete_data_so_detail($params = array()) //di pakai
	{
		$this->table = 'sales_order_detail';

		$this->delete('sod_id',$params['id']);
		
		return $this->load_data_detail_do(array('no_trx' => $params['sod_no_trx']));
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