<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/akuntansi/models/Kas_masuk_model.php
 */

class Kas_masuk_model extends NOOBS_Model
{
	public function load_data_kas_masuk($params = array())
	{
		// print_r($params);exit;
		$this->db->select('*');
		$this->db->from('cash_in as ci');
		// $this->db->join('cash_in_detail as cid','ci.ci_no_trx = cid.cid_ci_no_trx','LEFT');
		$this->db->join('user_detail as ud','ud.ud_id = ci.last_user','LEFT');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = ci.ci_rad_id','LEFT');
		
		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->like('UPPER(ci.ci_no_trx)', strtoupper($params['no_trx']));
		}

		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(ci.ci_no_trx)', strtoupper($params['txt_item']));
			$this->db->or_like('UPPER(ci.ci_keterangan)', strtoupper($params['txt_item']));
			$this->db->or_like('UPPER(rad.rad_name)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('ci.ci_id', strtoupper($params['txt_id']));
		}

		if (isset($params['date_range1']) && ! empty($params['date_range1']))
		{
			$this->db->where('ci.ci_created_date >=', $params['date_range1']);
			$this->db->where('ci.ci_created_date <=', $params['date_range2']);
		}

		$this->db->where('ci.ci_is_active', 'Y');
		$this->db->order_by('ci.ci_created_date', 'DESC');
		$this->db->order_by('ci.ci_id', 'DESC');

		return $this->db->get();
 	}

 	public function get_data_cash_in_detail($params = array())
	{
		$this->db->select('*');
		$this->db->from('cash_in_detail as cid');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = cid.cid_rad_id','LEFT');

		if (isset($params['cid_ci_no_trx']) && ! empty($params['cid_ci_no_trx']))
		{
			$this->db->where('cid.cid_ci_no_trx', strtoupper($params['cid_ci_no_trx']));
		}
	
		$this->db->where('cid.cid_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function get_last_notrx()
	{
		$this->db->select('LEFT(ci_no_trx,4) as notrx');
		$this->db->order_by('ci_id', 'DESC');
		$this->db->limit('1');
		
		return $this->db->get('cash_in');
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

 	public function get_amount_kas($params = array(),$set)
	{
		$this->db->select('sum(trx_total) as amount');

		if (isset($set) && ! empty($set))
		{
			$this->db->where($set);
		}
	
		// $this->db->where('month(trx_created_date) >=', date('n'));
		if (isset($params['date_range1']))
		{
			$this->db->where('month(trx_created_date) >=', date('n',strtotime($params['date_range1'])));
			$this->db->where('month(trx_created_date) <=',date('n',strtotime($params['date_range2'])));
			$this->db->where('year(trx_created_date) >=', date('Y',strtotime($params['date_range1'])));
			$this->db->where('year(trx_created_date) <=', date('Y',strtotime($params['date_range2'])));
			$this->db->where($set);
		}
		else
		{
			$this->db->where('month(trx_created_date) >=', '1');
			$this->db->where('month(trx_created_date) <=', '12');
			$this->db->where('year(trx_created_date) <=', date('Y'));
		}
		
		return $this->db->get('ref_transaksi');
 	}

 	public function total_amount_detail_cash_in($params = array())
	{
		$this->db->select('sum(cid_total) as total_amount');
		$this->db->from('cash_in_detail');

		if (isset($params['ci_no_trx']) && ! empty($params['ci_no_trx']))
		{
			$this->db->where('cid_ci_no_trx', strtoupper($params['ci_no_trx']));
		}
		$this->db->where('cid_is_active', 'Y');
		
		return $this->db->get();
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

 	public function load_data_cash_in_detail($params = array())
	{
		$this->db->select('*');
		$this->db->from('cash_in_detail as cid');
		$this->db->join('ref_transaksi as trx','trx.trx_key_lock = cid.cid_key_lock','LEFT');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = cid.cid_rad_id','LEFT');
		
		if (isset($params['cid_ci_no_trx']) && ! empty($params['cid_ci_no_trx']))
		{
			$this->db->where('cid.cid_ci_no_trx', strtoupper($params['cid_ci_no_trx']));
		}
		if (isset($params['ci_rad_id']) && ! empty($params['ci_rad_id']))
		{
			$this->db->where('trx.trx_rad_id_to', strtoupper($params['ci_rad_id']));
		}

		$this->db->where('cid.cid_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function get_cash_in_detail($params = array())
	{
		$this->db->select('*');
		$this->db->from('cash_in_detail as cid');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = cid.cid_rad_id','LEFT');
		
		if (isset($params['cid_ci_no_trx']) && ! empty($params['cid_ci_no_trx']))
		{
			$this->db->where('cid.cid_ci_no_trx', strtoupper($params['cid_ci_no_trx']));
		}
	
		$this->db->where('cid.cid_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function cek_cash_in_detail($params = array())
	{
		// print_r($params);exit;
		$this->db->select('max(cid_key_lock) as max');
		$this->db->from('cash_in_detail');
		
		if (isset($params['cid_no_trx']) && ! empty($params['cid_no_trx']))
		{
			$this->db->where('cid_ci_no_trx', strtoupper($params['cid_no_trx']));
		}

		$this->db->where('cid_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function cek_ref_transaksi($key_lock = '')
	{		
		if (isset($key_lock) && ! empty($key_lock))
		{
			$this->db->where('trx_key_lock', strtoupper($key_lock));
		}

		$this->db->where('trx_is_active', 'Y');
		
		return $this->db->get('ref_transaksi');
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

		return $this->get_data_cash_in_detail(array('cid_ci_no_trx' => $params['cid_no_trx']));
	}

	public function store_data_kas_masuk($params = array())
	{
		$this->table = 'cash_in';

		$new_params = array(
			'ci_rad_id' => $params['ci_rad_id'],
			'ci_no_trx' => $params['ci_no_trx_temp'],
			'ci_keterangan' => $params['ci_keterangan'],
			'ci_total' => str_replace(',','',$params['ci_total']),
			'ci_created_date' => $params['ci_created_date'],
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "ci_id = {$params['ci_id']}");

		return $this->load_data_kas_masuk($params);
	}

	public function store_data_ref_trx($params = array(),$cond = array())
	{
		// print_r($params);exit;
		$this->table = 'ref_transaksi';

		if ($cond['mode'] == 'add') return $this->add($params, TRUE);
		else return $this->edit($params, "trx_id = '{$cond['trx_id']}'");

		// return $this->load_data_kas_masuk();
	}

	public function delete_temp_data($params = array())
	{
		$this->table = 'cash_in_detail';

		return $this->delete('cid_ci_no_trx',$params['last_notrx']);	
		
	}

	public function delete_data_cash_in($params = array())
	{
		$this->table = 'cash_in';

		$this->delete('ci_no_trx',$params['no_trx']);
		
		unset($params['no_trx']);

		return $this->load_data_kas_masuk($params);
	}

	public function delete_data_cash_in_detail($params = array())
	{
		$this->table = 'cash_in_detail';

		if (isset($params['key_lock']) && ! empty($params['key_lock']))
		{
			return $this->delete('cid_key_lock',$params['key_lock']);
		}
		else
		{
			return $this->delete('cid_ci_no_trx',$params['no_trx']);
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
			return $this->delete('trx_no_trx',$params['no_trx']);
		}
	}

}