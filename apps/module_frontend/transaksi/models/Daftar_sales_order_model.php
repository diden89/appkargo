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

		$this->db->select('so.*,rd.*,v.v_vendor_name, (select sum(sod_qty) as so_qty from sales_order_detail where sod_no_trx = so.so_no_trx) as so_qty,
			(CASE 
			WHEN so_is_pay = "BL" THEN "BELUM LUNAS"
			WHEN so_is_pay = "LN" THEN "LUNAS"
			ELSE "BELUM LENGKAP" END) as paying, DATE_FORMAT(so.so_created_date, "%d-%m-%Y") as date_create');
		$this->db->from('sales_order as so');
		// $this->db->join('sales_order_detail as sod','sod.sod_no_trx = so.so_id','LEFT');
		$this->db->join('vendor as v','v.v_id = so.so_vendor_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = so.so_district_id','LEFT');
		

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['txt_id']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('so.so_created_date >=', date('Y-m-d',strtotime($params['date_range1'])));
			$this->db->where('so.so_created_date <=', date('Y-m-d',strtotime($params['date_range2'])));
		}

		$this->db->where('so.so_is_active', 'Y');
		
		if (!isset($params['mode']))
		{
			$this->db->or_where('so.so_is_status !=', 'SELESAI');
		}
		
		$this->db->like('v.v_unique_access_key', md5($this->session->userdata('user_id')));

		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(so.so_no_trx)', strtoupper($params['txt_item']),'both');
			$this->db->or_like('UPPER(v.v_vendor_name)', strtoupper($params['txt_item']),'both');
		}
		$this->db->order_by('so.so_created_date', 'DESC');
		$this->db->order_by('so.so_id', 'DESC');

		return $this->db->get();
 	}
	public function get_progress_so($params = array())
	{
		$this->db->select('count(dod.dod_id) as progress');
		$this->db->from('delivery_order_detail as dod');
		$this->db->join('sales_order_detail as sod','sod.sod_id = dod.dod_sod_id','LEFT');
		$this->db->join('sales_order as so','so.so_no_trx = sod.sod_no_trx','LEFT');

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}

		if (isset($params['dod_is_status']) && ! empty($params['dod_is_status']))
		{
			$this->db->where('dod.dod_is_status', $params['dod_is_status']);
		}
		
		$this->db->where('dod.dod_is_active', 'Y');

		return $this->db->get();
 	}

 	public function get_progress_so_transfer($params = array())
	{
		$this->db->select('count(dotd.dotd_id) as progress');
		$this->db->from('delivery_order_transfer_detail as dotd');
		$this->db->join('sales_order_detail as sod','sod.sod_id = dotd.dotd_sod_id','LEFT');
		$this->db->join('sales_order as so','so.so_no_trx = sod.sod_no_trx','LEFT');

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
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
		$this->db->select('sum(dod.dod_shipping_qty) as total_progress');
		$this->db->from('delivery_order_detail as dod');
		$this->db->join('sales_order_detail as sod','sod.sod_id = dod.dod_sod_id','LEFT');
		$this->db->join('sales_order as so','so.so_no_trx = sod.sod_no_trx','LEFT');

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}

		if (isset($params['dod_is_status']) && ! empty($params['dod_is_status']))
		{
			$this->db->where('dod.dod_is_status', $params['dod_is_status']);
		}
		
		$this->db->where('dod.dod_is_active', 'Y');

		return $this->db->get();
 	}

 	public function get_progress_dos($params = array())
	{
		$this->db->select($params['sel']);
		$this->db->from('delivery_order_status as dos');
		$this->db->join('delivery_order_detail as dod','dos.dos_dod_id = dod.dod_id','LEFT');
		$this->db->join('sales_order_detail as sod','sod.sod_id = dod.dod_sod_id','LEFT');
		$this->db->join('sales_order as so','so.so_no_trx = sod.sod_no_trx','LEFT');

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}

		if (isset($params['dod_is_status']) && ! empty($params['dod_is_status']))
		{
			$this->db->where('dod.dod_is_status', $params['dod_is_status']);
		}
		
		$this->db->where('dod.dod_is_active', 'Y');

		return $this->db->get();
 	}

 	public function get_progress_do_transfer($params = array())
	{
		$this->db->select('sum(dotd.dotd_shipping_qty) as total_progress');
		$this->db->from('delivery_order_transfer_detail as dotd');
		$this->db->join('sales_order_detail as sod','sod.sod_id = dotd.dotd_sod_id','LEFT');
		$this->db->join('sales_order as so','so.so_no_trx = sod.sod_no_trx','LEFT');

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}

		if (isset($params['dotd_is_status']) && ! empty($params['dotd_is_status']))
		{
			$this->db->where('dotd.dotd_is_status', $params['dotd_is_status']);
		}
		
		$this->db->where('dotd.dotd_is_active', 'Y');

		return $this->db->get();
 	}

 	public function get_progress_dos_transfer($params = array())
	{
		$this->db->select($params['sel']);
		$this->db->from('delivery_order_transfer_status as dots');
		$this->db->join('delivery_order_transfer_detail as dotd','dots.dots_dotd_id = dotd.dotd_id','LEFT');
		$this->db->join('sales_order_detail as sod','sod.sod_id = dotd.dotd_sod_id','LEFT');
		$this->db->join('sales_order as so','so.so_no_trx = sod.sod_no_trx','LEFT');

		if (isset($params['so_id']) && ! empty($params['so_id']))
		{
			$this->db->where('so.so_id', strtoupper($params['so_id']));
		}

		if (isset($params['dotd_is_status']) && ! empty($params['dotd_is_status']))
		{
			$this->db->where('dotd.dotd_is_status', $params['dotd_is_status']);
		}
		
		$this->db->where('dotd.dotd_is_active', 'Y');

		return $this->db->get();
 	}

 	public function load_data_detail_so($params = array())
	{
		$this->db->select('*');
		$this->db->from('sales_order_detail as sod');
		$this->db->join('sales_order as so','sod.sod_no_trx = so.so_no_trx','LEFT');
		$this->db->join('item_list as il','sod.sod_item_id = il.il_id','LEFT');
		

		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->where('sod.sod_no_trx', strtoupper($params['no_trx']));
		}

		$this->db->where('sod.sod_is_active', 'Y');
		$this->db->order_by('sod.last_datetime', 'ASC');

		return $this->db->get();
 	}

	public function store_data_daftar_sales_order($params = array())
	{
		$this->table = 'sales_order';

		$new_params = array(
			'so_vendor_id' => $params['v_vendor_id'],
			'so_district_id' => $params['txt_region'],
			'so_no_trx' => $params['last_notrx'],
			'so_tipe' => $params['tipe_so'],
			'so_created_date' => date('Y-m-d H:i:s', strtotime($params['so_created_date'])),
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "so_id = {$params['txt_id']}");

		unset($params['txt_id']);
		unset($params['mode']);

		return $this->load_data_daftar_sales_order($params);
	}

	public function store_detail_so($params = array())
	{
		$this->table = 'sales_order_detail';

		$new_params = array(
			'sod_no_trx' => $params['sod_no_trx'],
			'sod_qty' => $params['sod_qty'],
			'sod_item_id' => $params['sod_item_id']
		);

		if(! empty($params['so_id'])) {
			$mode = $params['mode'];
		}
		else {
			$mode = 'add';
		}

		if ($mode == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "sod_id = {$params['so_id']}");

		return $this->load_data_detail_so(array('no_trx' => $params['sod_no_trx']));
	}

	public function delete_data_item($params = array()) //di pakai
	{

		$this->table = 'sales_order';
		$this->delete('so_no_trx',$params['no_trx']);

		return $this->delete_data_item_detail($params);
	}

	public function delete_data_item_detail($params = array()) //di pakai
	{

		$this->table = 'sales_order_detail';
		$this->delete('sod_no_trx',$params['no_trx']);

		return $this->load_data_daftar_sales_order($params);
		
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

 	public function get_last_notrx()
	{
		$this->db->select('LEFT(so_no_trx,4) as notrx');
		$this->db->order_by('so_id', 'DESC');
		$this->db->limit('1');
		
		return $this->db->get('sales_order');
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

	public function delete_data_so_detail($params = array())
	{
		$this->table = 'sales_order_detail';

		$this->delete('sod_id',$params['id']);
		
		return $this->load_data_detail_so(array('no_trx' => $params['sod_no_trx']));
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
		$this->db->select('so.*,rd.*,v.v_vendor_name, (select sum(sod_qty) as so_qty from sales_order_detail where sod_no_trx = so.so_no_trx) as so_qty,
			(CASE 
			WHEN so_is_pay = "BL" THEN "BELUM LUNAS"
			WHEN so_is_pay = "LN" THEN "LUNAS"
			ELSE "BELUM LENGKAP" END) as paying, DATE_FORMAT(so.so_created_date, "%d-%m-%Y") as date_create');
		$this->db->from('sales_order as so');
		$this->db->join('vendor as v','v.v_id = so.so_vendor_id','LEFT');
		$this->db->join('ref_district as rd','rd.rd_id = so.so_district_id','LEFT');
		
		// if (isset($params['date_range1']) && ! empty($params['date_range1']))
		// {
		// 	$this->db->where('so.so_created_date >=', date('Y-m-d',strtotime($params['date_range1'])));
		// 	$this->db->where('so.so_created_date <=', date('Y-m-d',strtotime($params['date_range2'])));
		// }

		$this->db->where('so.so_is_active', 'Y');
		$this->db->or_where('so.so_is_pay', 'BL');
		$this->db->or_where('so.so_is_status', 'SELESAI');
		$this->db->like('v.v_unique_access_key', md5($this->session->userdata('user_id')));
		$this->db->order_by('so.so_created_date', 'DESC');
		$this->db->order_by('so.so_id', 'DESC');

		return $this->db->get();
 	}
}