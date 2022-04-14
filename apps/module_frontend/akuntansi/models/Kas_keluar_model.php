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
		// $this->db->join('cash_out_detail as cod','co.co_no_trx = cod.cod_co_no_trx','LEFT');
		$this->db->join('user_detail as ud','ud.ud_id = co.last_user','LEFT');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = co.co_rad_id','LEFT');
		
		if (isset($params['no_trx']) && ! empty($params['no_trx']))
		{
			$this->db->like('UPPER(co.co_no_trx)', strtoupper($params['no_trx']));
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

 	public function total_amount_detail_cash_out($params = array())
	{
		$this->db->select('sum(cod_total) as total_amount');
		$this->db->from('cash_out_detail');

		if (isset($params['co_no_trx']) && ! empty($params['co_no_trx']))
		{
			$this->db->where('cod_co_no_trx', strtoupper($params['co_no_trx']));
		}
		$this->db->where('cod_is_active', 'Y');
		
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

 	public function load_data_cash_out_detail($params = array())
	{
		$this->db->select('*');
		$this->db->from('cash_out_detail as cod');
		$this->db->join('ref_transaksi as trx','trx.trx_key_lock = cod.cod_key_lock','LEFT');
		$this->db->join('ref_akun_detail as rad','rad.rad_id = cod.cod_rad_id','LEFT');
		
		if (isset($params['cod_co_no_trx']) && ! empty($params['cod_co_no_trx']))
		{
			$this->db->where('cod.cod_co_no_trx', strtoupper($params['cod_co_no_trx']));
		}

		$this->db->where('cod.cod_is_active', 'Y');
		
		return $this->db->get();
 	}

 	public function cek_cash_out_detail($params = array())
	{
		// print_r($params);exit;
		$this->db->select('max(cod_key_lock) as max');
		$this->db->from('cash_out_detail');
		
		if (isset($params['cod_no_trx']) && ! empty($params['cod_no_trx']))
		{
			$this->db->where('cod_co_no_trx', strtoupper($params['cod_no_trx']));
		}

		$this->db->where('cod_is_active', 'Y');
		
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
		$this->table = 'cash_out_detail';
		// print_r($params);exit;
		$new_params = array(
			'cod_co_no_trx' => $params['cod_no_trx'],
			'cod_rad_id' => $params['akun_detail'],
			'cod_keterangan' => $params['cod_keterangan'],
			'cod_total' => str_replace(',','',$params['cod_total']),
			'cod_key_lock' => $params['cod_key_lock'],
		);
		if ($params['cod_id'] == false) 
		{
			$this->add($new_params, TRUE);
		}
		elseif (isset($params['cod_id']) && ! empty($params['cod_id'])) 
		{
			$this->edit($new_params, "cod_id = {$params['cod_id']}");

		}
		else
		{
			$this->add($new_params, TRUE);
		}

		return $this->load_data_cash_out_detail(array('cod_co_no_trx' => $params['cod_no_trx']));
	}

	public function store_data_kas_keluar($params = array())
	{
		$this->table = 'cash_out';

		$new_params = array(
			'co_rad_id' => $params['co_rad_id'],
			'co_no_trx' => $params['co_no_trx_temp'],
			'co_keterangan' => $params['co_keterangan'],
			'co_total' => str_replace(',','',$params['co_total']),
			'co_created_date' => $params['co_created_date'],
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "co_id = {$params['co_id']}");

		return $this->load_data_kas_keluar();
	}

	public function store_data_ref_trx($params = array(),$cond = array())
	{
		// print_r($params);exit;
		$this->table = 'ref_transaksi';

		if ($cond['mode'] == 'add') return $this->add($params, TRUE);
		else return $this->edit($params, "trx_key_lock = '{$cond['trx_key_lock']}'");

		// return $this->load_data_kas_keluar();
	}

	public function delete_temp_data($params = array())
	{
		$this->table = 'cash_out_detail';

		return $this->delete('cod_co_no_trx',$params['last_notrx']);	
		
	}

	public function delete_data_cash_out($params = array())
	{
		$this->table = 'cash_out';

		$this->delete('co_no_trx',$params['cod_co_no_trx']);
		
		return $this->load_data_kas_keluar($params);
	}

	public function delete_data_cash_out_detail($params = array())
	{
		$this->table = 'cash_out_detail';

		if (isset($params['key_lock']) && ! empty($params['key_lock']))
		{
			return $this->delete('cod_key_lock',$params['key_lock']);
		}
		else
		{
			return $this->delete('cod_co_no_trx',$params['cod_co_no_trx']);
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
			return $this->delete('trx_no_trx',$params['cod_co_no_trx']);
		}
	}

}