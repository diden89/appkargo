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
		$this->db->select('*,(select sum(docd_amount) from delivery_order_cost_detail as docd where docd.docd_doc_no_trx = doc.doc_no_trx) as total');
		$this->db->from('delivery_order_cost as doc');
		$this->db->join('sales_order as so','doc.doc_so_no_trx = so.so_no_trx','LEFT');
		$this->db->join('vendor as v','so.so_vendor_id = v.v_id','LEFT');
		$this->db->join('ref_district as rd','so_district_id = rd.rd_id','LEFT');
	
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(doc.doc_no_trx)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('doc.doc_id', $params['txt_id']);
		}

		if (isset($params['from_date']) && ! empty($params['from_date']))
		{
			$this->db->where('doc.doc_created_date >=', date('Y-m-d h:i:s', strtotime($params['from_date'])));
			$this->db->where('doc.doc_created_date <=', date('Y-m-d h:i:s', strtotime($params['to_date'])));
		}


		$this->db->where('doc.doc_is_active', 'Y');
		$this->db->order_by('doc.doc_no_trx', 'ASC');

		return $this->create_result($params);
 	}

 	public function load_data_temporary($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*');
		$this->db->from('delivery_order_cost_detail as docd');
		$this->db->join('delivery_order_cost as doc','doc.doc_no_trx = docd.docd_doc_no_trx','LEFT');
		$this->db->join('ref_akun_detail as rad','docd.docd_rad_id = rad.rad_id','LEFT');
		$this->db->join('vehicle as v','v.ve_id = docd.docd_vehicle_id','LEFT');
		// $this->db->join('driver as d','d.d_id = ','LEFT');

		if (isset($params['so_no_trx']) && ! empty($params['so_no_trx']))
		{
			$this->db->where('docd.docd_doc_no_trx', $params['doc_no_trx']);
			// $this->db->where('docd.docd_vehicle_id', $params['vehicle_id']);
		}

		$this->db->where('docd.docd_is_active', 'Y');
		// $this->db->group_by('docd.docd_vehicle_id');
		$this->db->order_by('docd.docd_doc_no_trx', 'ASC');

		return $this->db->get();
 	}

 	public function get_last_notrx()
	{
		$this->db->select('LEFT(doc_no_trx,4) as notrx');
		$this->db->order_by('doc_id', 'DESC');
		$this->db->limit('1');
		
		return $this->db->get('delivery_order_cost');
 	}

 	public function get_autocomplete_data($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*,
			doc.doc_id as id,
			doc.doc_no_trx as text,
			');
		$this->db->from('delivery_order_cost as doc');
		$this->db->join('vehicle as v','v.ve_id = docd.docd_vehicle_id','LEFT');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(doc.doc_no_trx LIKE '%{$query}%' OR v.ve_license_plate LIKE '%{$query}%')", NULL, FALSE);
		}

		$this->db->where('doc.doc_is_active', 'Y');
		$this->db->order_by('doc.doc_no_trx', 'ASC');

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
			$this->db->where('so.so_no_trx', strtoupper($params['no_trx']));
		}

		// $this->db->where('rad.rad_type', 'D');
		// $this->db->where('rad.rad_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function cek_order_cost($params)
	{
		$this->db->select('*');
		$this->db->from('delivery_order_cost as doc');

		if (isset($params['doc_no_trx']) && ! empty($params['doc_no_trx']))
		{
			$this->db->where('doc.doc_no_trx', strtoupper($params['doc_no_trx']));
		}

		return $this->db->get();
 	}
	public function cek_order_cost_detail($params)
	{
		$this->db->select('count(docd_id) + 1 as count_id');
		$this->db->from('delivery_order_cost_detail as docd');

		if (isset($params['doc_no_trx']) && ! empty($params['doc_no_trx']))
		{
			$this->db->where('docd.docd_doc_no_trx', strtoupper($params['doc_no_trx']));
		}

		return $this->db->get();
 	}

 	public function store_data($params = array())
	{
		$this->table = 'delivery_order_cost';
		// print_r($params);exit;
		$new_params = array(
			'doc_so_no_trx' => $params['so_no_trx'],
			'doc_no_trx' => $params['doc_no_trx'],
			'doc_created_date' => date('Y-m-d h:i:s',strtotime($params['created_date'])),
			
		);
		if ($params['doc_id'] == 'undefined') 
		{
			$this->add($new_params, TRUE);
		}
		elseif (isset($params['doc_id']) && ! empty($params['doc_id'])) 
		{
			$this->edit($new_params, "doc_id = {$params['doc_id']}");

		}
		else
		{
			$this->add($new_params, TRUE);
		}

		// return $this->load_data_temporary(array('docd_doc_no_trx' => $params['docd_doc_no_trx']));
	}

	public function store_temporary_data($params = array())
	{
		$this->table = 'delivery_order_cost_detail';
		// print_r($params);exit;
		$new_params = array(
			'docd_vehicle_id' => $params['vehicle_id'],
			'docd_doc_no_trx' => $params['doc_no_trx'],
			'docd_lock_ref' => $params['docd_lock_ref'],
			'docd_rad_id' => $params['akun_detail'],
			'docd_amount' => str_replace(',','',$params['total']),
			'docd_keterangan' => $params['keterangan']
		);
		if (empty($params['docd_id'])) 
		{
			$this->add($new_params, TRUE);
		}
		elseif (isset($params['docd_id']) && ! empty($params['docd_id'])) 
		{
			$this->edit($new_params, "docd_id = {$params['docd_id']}");

		}
		else
		{
			$this->add($new_params, TRUE);
		}

		return $this->load_data_temporary(array('doc_no_trx' => $params['doc_no_trx']));
	}

	public function store_data_ref_trx($params = array())
	{
		$this->table = 'ref_transaksi';
		// print_r($params);exit;
		$new_params = array(
			'trx_no_trx' => $params['doc_no_trx'],
			'trx_key_lock' => $params['docd_lock_ref'],
			'trx_rad_id_from' => $params['trx_rad_id_from'],
			'trx_rad_id_to' => $params['akun_detail'],
			'trx_total' => str_replace(',','',$params['total']),
			'trx_created_date' =>  date('Y-m-d h:i:s',strtotime($params['created_date']))
		);

		if (! empty($params['docd_id'])) 
		{
			$this->edit($new_params, "trx_key_lock = '{$params['docd_lock']}'");
		}
		else
		{
			$this->add($new_params, TRUE);
		}

	}

	public function delete_data_ref_transaksi($params = array())
	{
		$this->table = 'ref_transaksi';

		if (isset($params['key_lock']) && ! empty($params['key_lock']))
		{
			return $this->delete('trx_key_lock',$params['key_lock']);
		}
		else
		{
			return $this->delete('trx_no_trx',$params['doc_no_trx']);
		}
	}

	public function delete_data_temp($params = array())
	{
		$this->table = 'delivery_order_cost_detail';

		if (isset($params['docd_id']) && ! empty($params['docd_id']))
		{
			$this->delete('docd_id',$params['docd_id']);
		}

		return $this->load_data_temporary(array('doc_no_trx' => $params['doc_no_trx']));
	}

	public function total_amount_detail($params = array())
	{
		$this->db->select('sum(docd_amount) as total_amount');
		$this->db->from('delivery_order_cost_detail');

		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->where('docd_doc_no_trx', strtoupper($params['no_trx']));
		}
		$this->db->where('docd_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function get_option_no_trx($mode)
	{
		
		$this->db->from('sales_order');

		if($mode == 'add')
		{
			$this->db->where('so_no_trx not in (select doc_so_no_trx from delivery_order_cost where doc_is_active = "Y")');
		}

		$this->db->where('so_is_active' , 'Y');
		$this->db->where('so_is_status !=' , 'SELESAI');
		
		return $this->db->get();
		// return $query;
 	}

	public function delete_data_order_cost($params = array())
	{
		$this->table = 'delivery_order_cost';

		return $this->delete('doc_no_trx',$params['doc_no_trx']);
		
	}

	public function delete_data_order_cost_detail($params = array())
	{
		$this->table = 'delivery_order_cost_detail';

		return $this->delete('docd_doc_no_trx',$params['doc_no_trx']);
	}


	

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