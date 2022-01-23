<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/models/Daftar_rekanan_model.php
 */

class Daftar_rekanan_model extends NOOBS_Model
{
	public function load_data_rekanan($params = array())
	{
		$this->db->from('partner as pr');
		// $this->db->join('partner_detail as prd','prd.prd_pr_id = pr.pr_id','LEFT');
		// $this->db->join('vehicle as ve','ve.ve_id = prd.prd_vehicle_id','LEFT');
	
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->like('UPPER(pr.pr_name)', strtoupper($params['txt_item']));
			$this->db->like_or('UPPER(pr.pr_code)', strtoupper($params['txt_item']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('pr.pr_id', strtoupper($params['txt_id']));
		}

		$this->db->where('pr.pr_is_active', 'Y');
		$this->db->order_by('pr.pr_name', 'ASC');

		return $this->create_result($params);
 	}

 
 	public function get_data_rekanan($params = array())
	{
		$this->db->select('*');
		$this->db->from('partner');

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('pr_id', strtoupper($params['txt_id']));
		}

		$this->db->where('pr_is_active', 'Y');
		$this->db->order_by('pr_code', 'ASC');

		return $this->db->get();
 	}

	public function get_partner_detail($params = array())
	{
		$this->db->select('*');
		$this->db->from('partner_detail');

		if (isset($params['data']['pr_id']) && ! empty($params['data']['pr_id']))
		{
			$this->db->where('prd_pr_id', strtoupper($params['data']['pr_id']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('prd_pr_id', strtoupper($params['txt_id']));
		}

		$this->db->where('prd_is_active', 'Y');
		$this->db->order_by('prd_id', 'ASC');

		return $this->db->get();
 	}

 	public function get_autocomplete_data($params = array())
	{
		$this->db->select("
			*,
			pr_id as id,
			pr_name as text,
			pr_name as full_name
		", FALSE);

		$this->db->from('partner');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(pr_name LIKE '%{$query}%' OR pr_code LIKE '%{$query}%')", NULL, FALSE);
		}

		$this->db->where('pr_is_active', 'Y');
		$this->db->order_by('pr_name', 'ASC');

		return $this->create_autocomplete_data($params);
	}

	public function store_data($params = array())
	{
		$this->table = 'partner';

		$new_params = array(
			'pr_code' => $params['kode_rekanan'],
			'pr_name' => $params['rekanan_name'],
			'pr_phone' => $params['pr_phone'],
			'pr_email' => $params['pr_email'],
			// 'pr_vehicle_id' => $params['pr_vehicle_id'],
			'pr_ud_id' => $params['txt_user_id']
		);

		if ($params['mode'] == 'add') 
		{
			$insert_id =  $this->add($new_params, TRUE);

			$params['ins_id'] = $insert_id;

			$del = $this->delete_partner_detail($params);

			foreach($params['pr_vehicle_id'] as $val)
			{
				$data = array(
					'prd_pr_id' => $insert_id,
					'prd_vehicle_id' => $val
				);

				$this->store_data_detail($data);

			}
		}
		else
		{
			$edit =  $this->edit($new_params, "pr_id = {$params['txt_id']}");

			$params['ins_id'] = $params['txt_id'];

			$del = $this->delete_partner_detail($params);

			foreach($params['pr_vehicle_id'] as $val)
			{
				$data = array(
					'prd_pr_id' => $params['txt_id'],
					'prd_vehicle_id' => $val
				);

				$this->store_data_detail($data);

			}
		} 
	}

	public function store_data_detail($params = array())
	{
		$this->table = 'partner_detail';

		$new_params = array(
			'prd_pr_id' => $params['prd_pr_id'],
			'prd_vehicle_id' => $params['prd_vehicle_id']
		);

		return $this->add($new_params, TRUE);

	}

	public function delete_partner_detail($params = array())
	{
		$this->table = 'partner_detail';
	
		return $this->delete('prd_pr_id', $params['ins_id']);
	}

	public function delete_data($params = array())
	{
		$this->table = 'partner';

		return $this->edit(['pr_is_active' => 'N'], "pr_id = {$params['txt_id']}");
	}

	public function cek_before_delete($params = array(),$table,$initial)
	{
		$this->db->where($initial.'_vendor_id', $params['txt_id']);

		return $this->db->get($table);
	}

	public function get_vehicle($params = array())
	{
		$this->db->where('ve_is_active', 'Y');
		$this->db->where('ve_status', '2');
		
		if($params['mode'] == 'add')
		{
			$this->db->where('ve_id not in (select prd_vehicle_id from partner_detail where prd_is_active = "Y")');
		}

		if($params['mode'] == 'edit')
		{
			$this->db->where('ve_id not in (select prd_vehicle_id from partner_detail where prd_is_active = "Y")');
			$this->db->or_where("ve_id in (select prd_vehicle_id from partner_detail where prd_is_active = 'Y' and prd_pr_id = {$params['data']['pr_id']})");
		}

		if (isset($params['ve_id']) && ! empty($params['ve_id']))
		{
			$this->db->where('ve_id', strtoupper($params['ve_id']));
		}

		return $this->db->get('vehicle');
	}

	public function get_vehicle_detail($params = array())
	{
		$this->db->from('partner_detail as prd');
		$this->db->join('vehicle as ve','prd.prd_vehicle_id = ve.ve_id','LEFT');

		$this->db->where('ve.ve_is_active', 'Y');

		if (isset($params['data']['pr_id']) && ! empty($params['data']['pr_id']))
		{
			$this->db->where('prd.prd_pr_id', strtoupper($params['data']['pr_id']));
		}

		return $this->db->get();
	}

	public function get_user_login($params = array())
	{
		$this->db->where('ud_is_active', 'Y');

		if($params['mode'] == 'add')
		{
			$this->db->where('ud_id not in (select pr_ud_id from partner where pr_is_active = "Y" and pr_ud_id is not null)');
		}	

		if($params['mode'] == 'view' )
		{
			$this->db->where('ud_id',$params['data']['pr_ud_id']);
		}

		return $this->db->get('user_detail');
	}

}