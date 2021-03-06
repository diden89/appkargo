<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/models/Daftar_pembayaran_sales_order_model.php
 */

class Daftar_pembayaran_sales_order_model extends NOOBS_Model
{
	public function load_data_daftar_pembayaran_sales_order($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*,(CASE 
			WHEN so.so_is_pay = "BL" THEN "BELUM LUNAS"
			WHEN so.so_is_pay = "LN" THEN "LUNAS"
			ELSE "BELUM LENGKAP" END) as paying,DATE_FORMAT(so.so_created_date, "%d-%m-%Y") as date_create');
		$this->db->from('sales_order_payment as sop');
		$this->db->join('sales_order as so','so.so_no_trx = sop.sop_so_no_trx','LEFT');
		$this->db->join('vendor as v','v.v_id = so.so_vendor_id','LEFT');
		// $this->db->join('ref_district as rd','rd.rd_id = so.so_district_id','LEFT');
		
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(sop.sop_no_trx)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('sop.sop_id', strtoupper($params['txt_id']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('sop.sop_created_date >=', $params['date_range1']);
			$this->db->where('sop.sop_created_date <=', $params['date_range2']);
		}
		else
		{
			$this->db->where('month(sop.sop_created_date) >=', date('n'));
			$this->db->where('year(sop.sop_created_date) >=', date('Y'));
		}

		$this->db->where('sop.sop_is_active', 'Y');
		$this->db->order_by('sop.sop_created_date', 'DESC');
		$this->db->order_by('sop.sop_id', 'DESC');

		return $this->db->get();
 	}

 	public function get_kas_bank_option()
	{
		$this->db->where('rad_is_bank', 'Y');
		$this->db->where('rad_is_active', 'Y');
		$this->db->where('rad_type', 'D');
		$this->db->order_by('rad_seq', 'ASC');
		
		return $this->db->get('ref_akun_detail');
 	}

 	public function get_vendor_option()
	{		
		$this->db->where('v_is_active', 'Y');
		$this->db->order_by('v_vendor_name', 'ASC');

		return $this->db->get('vendor');
 	}

 	public function get_last_notrx()
	{
		$this->db->select('LEFT(sop_no_trx,4) as notrx');
		$this->db->order_by('sop_id', 'DESC');
		$this->db->limit('1');
		
		return $this->db->get('sales_order_payment');
 	}

 	public function get_sales_order_data($params = array())
	{
		$this->db->select('so.*,rd.*,v.*, (select sum(sod_qty) as so_qty from sales_order_detail where sod_no_trx = so.so_no_trx) as so_qty,
			(CASE 
			WHEN so_is_pay = "BL" THEN "BELUM LUNAS"
			WHEN so_is_pay = "LN" THEN "LUNAS"
			ELSE "BELUM LENGKAP" END) as paying, DATE_FORMAT(so.so_created_date, "%d-%m-%Y") as date_create');
		$this->db->from('sales_order as so');
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
		
		if (isset($params['so_vendor_id']) && ! empty($params['so_vendor_id']))
		{
			$this->db->where('so.so_vendor_id', strtoupper($params['so_vendor_id']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('so.so_created_date >=', $params['date_range1']);
			$this->db->where('so.so_created_date <=', $params['date_range2']);
		}

		$this->db->where('so.so_is_active', 'Y');
		$this->db->where('so.so_is_pay', 'BL');
		$this->db->order_by('so.so_created_date', 'DESC');
		$this->db->order_by('so.so_id', 'DESC');

		return $this->db->get();
 	}

 	public function store_data_daftar_pembayaran_sales_order($params = array())
	{
		$this->table = 'sales_order_payment';


		if ($params['mode'] == 'add') return $this->add($params, TRUE);
		else return $this->edit($new_params, "sop_id = {$params['sop_id']}");

		// return $this->load_data_daftar_pembayaran_sales_order();
	}

	public function update_status_sales_order($params = array()) //dipakai
	{
		$this->table = 'sales_order';

		$new_params = array(
			'so_is_pay' => $params['so_is_pay']

		);

		$no_trx = $params['so_no_trx'];

		return $this->edit($new_params, "so_no_trx = \"{$no_trx}\" ");

		// return $this->load_data_daftar_delivery_order();
	}

	public function store_data_ref_trx($params = array(),$cond = array())
	{
		// print_r($params);exit;
		$this->table = 'ref_transaksi';

		if ($cond['mode'] == 'add') return $this->add($params, TRUE);
		else return $this->edit($params, "trx_key_lock = '{$cond['trx_key_lock']}'");

		// return $this->load_data_kas_masuk();
	}

	// public function get_progress_so($params = array())
	// {
	// 	$this->db->select('count(dod.dod_id) as progress');
	// 	$this->db->from('delivery_order_detail as dod');
	// 	$this->db->join('sales_order_detail as sod','sod.sod_id = dod.dod_sod_id','LEFT');
	// 	$this->db->join('sales_order as so','so.so_no_trx = sod.sod_no_trx','LEFT');

	// 	if (isset($params['so_id']) && ! empty($params['so_id']))
	// 	{
	// 		$this->db->where('so.so_id', strtoupper($params['so_id']));
	// 	}

	// 	if (isset($params['dod_is_status']) && ! empty($params['dod_is_status']))
	// 	{
	// 		$this->db->where('dod.dod_is_status', $params['dod_is_status']);
	// 	}
		
	// 	$this->db->where('dod.dod_is_active', 'Y');

	// 	return $this->db->get();
 // 	}


	

	// public function store_detail_so($params = array())
	// {
	// 	$this->table = 'sales_order_detail';

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

	// 	return $this->load_data_detail_so(array('no_trx' => $params['sod_no_trx']));
	// }

	// public function delete_data_daftar_pembayaran_sales_order($params = array())
	// {
	// 	$this->table = 'customer';

	// 	$this->edit(['c_is_active' => 'N'], "c_id = {$params['txt_id']}");
		
	// 	return $this->load_data_daftar_pembayaran_sales_order();
	// }

	// public function load_data($params = array())
	// {
	// 	$this->db->where('il_item', strtoupper($params['txt_item']));
	// 	$this->db->where('il_is_active', 'Y');

	// 	return $this->db->get('customer');
 // 	}

 	

	// public function get_option_province()
	// {
	// 	$this->db->order_by('rp_name', 'ASC');
		
	// 	return $this->db->get('ref_province');
 // 	}

 // 	public function get_region_option($params)
	// {
	// 	$this->db->where('rd_province_id', $params['prov_id']);
	// 	$this->db->order_by('rd_name', 'ASC');
		
	// 	return $this->db->get('ref_district');
 // 	}

 // 	public function get_item_list_option($params)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('item_list as il');
	// 	$this->db->join('vendor as v','il.il_vendor_id = v.v_id','LEFT');

	// 	if (isset($params['vendor_id']) && ! empty($params['vendor_id']))
	// 	{
	// 		$this->db->where('il.il_vendor_id', strtoupper($params['vendor_id']));
	// 	}

	// 	$this->db->where('il.il_is_active', 'Y');
	// 	$this->db->order_by('il.last_datetime', 'ASC');

	// 	return $this->db->get();
 // 	}

 // 	public function get_district_option($params)
	// {
	// 	$this->db->where('rsd_district_id', $params['district_id']);
	// 	$this->db->order_by('rsd_name', 'ASC');
		
	// 	return $this->db->get('ref_sub_district');
 // 	}
	

 // 	public function get_option_item_list($params = array())
	// {

	// 	if(isset($params['il_id']) && ! empty($params['il_id']))
	// 	{
	// 		$this->db->where('il_id', $params['il_id']);
	// 	}

	// 	$this->db->where('il_is_active', 'Y');
	// 	$this->db->order_by('il_item_name', 'ASC');

	// 	return $this->db->get('item_list');
 // 	}

	// public function delete_data_so_detail($params = array())
	// {
	// 	$this->table = 'sales_order_detail';

	// 	$this->delete('sod_id',$params['id']);
		
	// 	return $this->load_data_detail_so(array('no_trx' => $params['sod_no_trx']));
	// }

	// public function store_data($params = array())
	// {
	// 	$this->table = 'customer';

	// 	$this->db->where('il_item_name', $params['txt_item']);

	// 	$qry = $this->db->get($this->table);

	// 	if ($qry->num_rows() > 0)
	// 	{
	// 		$row = $qry->row();

	// 		$this->edit(['il_similar_letter' => $row->il_similar_letter.';'.$params['txt_similar_letter']], "il_id = {$row->il_id}");

	// 		return $this->load_data(['txt_item' => $row->il_item]);
	// 	}
	// 	return FALSE;
	// }
}