<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/models/Daftar_sales_order_transfer_model.php
 */

class Daftar_sales_order_transfer_model extends NOOBS_Model
{
	public function load_data_daftar_sales_order_transfer($params = array())
	{
		// print_r($params);exit;
		$this->db->select('sot.*,rd.*,v.v_vendor_name, (select sum(sotd_qty) as sotd_qty from sales_order_transfer_detail where sotd_no_trx = sot.sot_no_trx) as sotd_qty,
			(CASE 
			WHEN sot_is_pay = "BL" THEN "BELUM LUNAS"
			WHEN sot_is_pay = "LN" THEN "LUNAS"
			ELSE "BELUM LENGKAP" END) as paying, DATE_FORMAT(sot.sot_created_date, "%d-%m-%Y") as date_create');
		$this->db->from('sales_order_transfer as sot');
		// $this->db->join('sales_order_transfer_detail as sotd','sotd.sotd_no_trx = sot.sot_id','LEFT');
		$this->db->join('vendor as v','v.v_id = sot.sot_vendor_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = sot.sot_district_id','LEFT');
		
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(sot.sot_no_trx)', strtoupper($params['txt_item']),'both');
			$this->db->or_like('UPPER(v.v_vendor_name)', strtoupper($params['txt_item']),'both');
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('sot.sot_id', strtoupper($params['txt_id']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('sot.sot_created_date >=', date('Y-m-d',strtotime($params['date_range1'])));
			$this->db->where('sot.sot_created_date <=', date('Y-m-d',strtotime($params['date_range2'])));
		}

		$this->db->where('sot.sot_is_active', 'Y');
		// $this->db->or_where('sot.sot_is_pay', 'BL');
		$this->db->like('v.v_unique_access_key', md5($this->session->userdata('user_id')));
		$this->db->order_by('sot.sot_created_date', 'DESC');
		$this->db->order_by('sot.sot_id', 'DESC');

		return $this->db->get();
 	}
	public function get_progress_sot($params = array())
	{
		$this->db->select('count(dotd.dotd_id) as progress');
		$this->db->from('delivery_order_transfer_detail as dotd');
		$this->db->join('sales_order_transfer_detail as sotd','sotd.sotd_id = dotd.dotd_sotd_id','LEFT');
		$this->db->join('sales_order_transfer as sot','sot.sot_no_trx = sotd.sotd_no_trx','LEFT');

		if (isset($params['sot_id']) && ! empty($params['sot_id']))
		{
			$this->db->where('sot.sot_id', strtoupper($params['sot_id']));
		}

		if (isset($params['dotd_is_status']) && ! empty($params['dotd_is_status']))
		{
			$this->db->where('dotd.dotd_is_status', $params['dotd_is_status']);
		}
		
		$this->db->where('dotd.dotd_is_active', 'Y');

		return $this->db->get();
 	}

 	public function get_progress_do($params = array())
	{
		$this->db->select('sum(dotd.dotd_shipping_qty) as total_progress');
		$this->db->from('delivery_order_transfer_detail as dotd');
		$this->db->join('sales_order_transfer_detail as sotd','sotd.sotd_id = dotd.dotd_sotd_id','LEFT');
		$this->db->join('sales_order_transfer as sot','sot.sot_no_trx = sotd.sotd_no_trx','LEFT');

		if (isset($params['sot_id']) && ! empty($params['sot_id']))
		{
			$this->db->where('sot.sot_id', strtoupper($params['sot_id']));
		}

		if (isset($params['dotd_is_status']) && ! empty($params['dotd_is_status']))
		{
			$this->db->where('dotd.dotd_is_status', $params['dotd_is_status']);
		}
		
		$this->db->where('dotd.dotd_is_active', 'Y');

		return $this->db->get();
 	}

 	public function get_progress_dots($params = array())
	{
		$this->db->select($params['sel']);
		$this->db->from('delivery_order_transfer_status as dots');
		$this->db->join('delivery_order_transfer_detail as dotd','dots.dots_dotd_id = dotd.dotd_id','LEFT');
		$this->db->join('sales_order_transfer_detail as sotd','sotd.sotd_id = dotd.dotd_sotd_id','LEFT');
		$this->db->join('sales_order_transfer as sot','sot.sot_no_trx = sotd.sotd_no_trx','LEFT');

		if (isset($params['sot_id']) && ! empty($params['sot_id']))
		{
			$this->db->where('sot.sot_id', strtoupper($params['sot_id']));
		}

		if (isset($params['dotd_is_status']) && ! empty($params['dotd_is_status']))
		{
			$this->db->where('dotd.dotd_is_status', $params['dotd_is_status']);
		}
		
		$this->db->where('dotd.dotd_is_active', 'Y');

		return $this->db->get();
 	}

 	public function load_data_detail_sot($params = array())
	{
		$this->db->select('*');
		$this->db->from('sales_order_transfer_detail as sotd');
		$this->db->join('sales_order_transfer as sot','sotd.sotd_no_trx = sot.sot_no_trx','LEFT');
		$this->db->join('item_list as il','sotd.sotd_item_id = il.il_id','LEFT');
		

		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->where('sotd.sotd_no_trx', strtoupper($params['no_trx']));
		}

		$this->db->where('sotd.sotd_is_active', 'Y');
		$this->db->order_by('sotd.last_datetime', 'ASC');

		return $this->db->get();
 	}

	public function store_data_daftar_sales_order_transfer($params = array())
	{
		$this->table = 'sales_order_transfer';

		$new_params = array(
			'sot_vendor_id' => $params['v_vendor_id'],
			'sot_district_id' => $params['txt_region'],
			'sot_no_trx' => $params['last_notrx'],
			// 'sot_is_status' => 'ORDER',
			'sot_created_date' => date('Y-m-d H:i:s', strtotime($params['sot_created_date'])),
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "sot_id = {$params['txt_id']}");

		unset($params['txt_id']);

		return $this->load_data_daftar_sales_order_transfer($params);
	}

	public function store_detail_sot($params = array())
	{
		$this->table = 'sales_order_transfer_detail';

		$new_params = array(
			'sotd_no_trx' => $params['sotd_no_trx'],
			'sotd_qty' => $params['sotd_qty'],
			'sotd_item_id' => $params['sotd_item_id']
		);

		if(! empty($params['sot_id'])) {
			$mode = $params['mode'];
		}
		else {
			$mode = 'add';
		}

		if ($mode == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "sotd_id = {$params['sot_id']}");

		return $this->load_data_detail_sot(array('no_trx' => $params['sotd_no_trx']));
	}

	public function delete_data_daftar_sales_order_transfer($params = array())
	{
		$this->table = 'customer';

		$this->edit(['c_is_active' => 'N'], "c_id = {$params['txt_id']}");
		
		return $this->load_data_daftar_sales_order_transfer();
	}

	public function load_data($params = array())
	{
		$this->db->where('il_item', strtoupper($params['txt_item']));
		$this->db->where('il_is_active', 'Y');

		return $this->db->get('customer');
 	}

 	public function get_last_notrx()
	{
		$this->db->select('LEFT(sot_no_trx,4) as notrx');
		$this->db->order_by('sot_id', 'DESC');
		$this->db->limit('1');
		
		return $this->db->get('sales_order_transfer');
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
		$this->db->like('v.v_unique_access_key', md5($this->session->userdata('user_id')));
		$this->db->order_by('il.last_datetime', 'ASC');

		return $this->db->get();
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
		$this->db->like('v_unique_access_key', md5($this->session->userdata('user_id')));
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

	public function delete_data_sot_detail($params = array())
	{
		$this->table = 'sales_order_transfer_detail';

		$this->delete('sotd_id',$params['id']);
		
		return $this->load_data_detail_sot(array('no_trx' => $params['sotd_no_trx']));
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

	public function load_data_rekap_tagihan($params = array())
	{
		$this->db->select('sot.*,rd.*,v.v_vendor_name, (select sum(sotd_qty) as sot_qty from sales_order_transfer_detail where sotd_no_trx = sot.sot_no_trx) as sot_qty,
			(CASE 
			WHEN sot_is_pay = "BL" THEN "BELUM LUNAS"
			WHEN sot_is_pay = "LN" THEN "LUNAS"
			ELSE "BELUM LENGKAP" END) as paying, DATE_FORMAT(sot.sot_created_date, "%d-%m-%Y") as date_create');
		$this->db->from('sales_order_transfer as sot');
		$this->db->join('vendor as v','v.v_id = sot.sot_vendor_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = sot.sot_district_id','LEFT');
		
		// if (isset($params['date_range1']) && ! empty($params['date_range1']))
		// {
		// 	$this->db->where('sot.sot_created_date >=', date('Y-m-d',strtotime($params['date_range1'])));
		// 	$this->db->where('sot.sot_created_date <=', date('Y-m-d',strtotime($params['date_range2'])));
		// }

		$this->db->where('sot.sot_is_active', 'Y');
		$this->db->or_where('sot.sot_is_pay', 'BL');
		$this->db->or_where('sot.sot_is_status', 'SELESAI');
		$this->db->like('v.v_unique_access_key', md5($this->session->userdata('user_id')));
		$this->db->order_by('sot.sot_created_date', 'DESC');
		$this->db->order_by('sot.sot_id', 'DESC');

		return $this->db->get();
 	}
}