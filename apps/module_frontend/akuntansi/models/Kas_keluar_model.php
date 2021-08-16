<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/akuntansi/models/Kas_keluar_model.php
 */

class Kas_keluar_model extends NOOBS_Model
{
	public function load_data_kas_keluar($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*');
		$this->db->from('cash_out as co');
		$this->db->join('cash_out_detail as cod','co.co_id = cod.cod_co_id','LEFT');
		$this->db->join('user_detail as ud','ud.ud_id = co.last_user','LEFT');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = co.co_rad_id','LEFT');
		
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(so.so_no_trx)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('co.co_id', strtoupper($params['txt_id']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('co.co_created_date >=', $params['date_range1']);
			$this->db->where('co.co_created_date <=', $params['date_range2']);
		}

		$this->db->where('co.co_is_active', 'Y');
		$this->db->order_by('co.co_created_date', 'DESC');
		$this->db->order_by('co.co_id', 'DESC');

		return $this->db->get();
 	}

 	public function get_last_notrx()
	{
		$this->db->select('LEFT(co_no_trx,4) as notrx');
		$this->db->order_by('co_id', 'DESC');
		$this->db->limit('1');
		
		return $this->db->get('cash_out');
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

 // 	public function load_data_detail_so($params = array())
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('sales_order_detail as sod');
	// 	$this->db->join('sales_order as so','sod.sod_no_trx = so.so_no_trx','LEFT');
	// 	$this->db->join('item_list as il','sod.sod_item_id = il.il_id','LEFT');
		

	// 	if (isset($params['no_trx']) && ! empty($params['no_trx']))
	// 	{
	// 		$this->db->where('sod.sod_no_trx', strtoupper($params['no_trx']));
	// 	}

	// 	$this->db->where('sod.sod_is_active', 'Y');
	// 	$this->db->order_by('sod.last_datetime', 'ASC');

	// 	return $this->db->get();
 // 	}

	// public function store_data_kas_keluar($params = array())
	// {
	// 	$this->table = 'sales_order';

	// 	$new_params = array(
	// 		'so_vendor_id' => $params['v_vendor_id'],
	// 		'so_district_id' => $params['txt_region'],
	// 		'so_no_trx' => $params['last_notrx'],
	// 		// 'so_is_status' => 'ORDER',
	// 		'so_created_date' => date('Y-m-d H:i:s', strtotime($params['so_created_date'])),
	// 	);

	// 	if ($params['mode'] == 'add') $this->add($new_params, TRUE);
	// 	else $this->edit($new_params, "so_id = {$params['txt_id']}");

	// 	return $this->load_data_kas_keluar();
	// }

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

	// public function delete_data_kas_keluar($params = array())
	// {
	// 	$this->table = 'customer';

	// 	$this->edit(['c_is_active' => 'N'], "c_id = {$params['txt_id']}");
		
	// 	return $this->load_data_kas_keluar();
	// }

	// public function load_data($params = array())
	// {
	// 	$this->db->where('il_item', strtoupper($params['txt_item']));
	// 	$this->db->where('il_is_active', 'Y');

	// 	return $this->db->get('customer');
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
	// public function get_option_vendor()
	// {		
	// 	$this->db->where('v_is_active', 'Y');
	// 	$this->db->order_by('v_vendor_name', 'ASC');

	// 	return $this->db->get('vendor');
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