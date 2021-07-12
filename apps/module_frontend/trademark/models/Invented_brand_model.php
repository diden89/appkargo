<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/models/Invented_brand_model.php
 */

class Invented_Brand_model extends NOOBS_Model
{
	public function get_data($params = array())
	{
		$this->db->select("
			ib.ib_id,
			b.b_application_number,
			b.b_receipt_date,
			b.b_class,
			b.b_brand,
			br.br_name,
			bp.bp_brm_num,
			IFNULL(DATE_FORMAT(bp.bp_brm_published_date_start, '%d-%m-%Y'), '') as bp_brm_published_date_start_new,
			IFNULL(DATE_FORMAT(bp.bp_brm_published_date_end,, '%d-%m-%Y'), '') as bp_brm_published_date_end_new,
			concat(IFNULL(DATE_FORMAT(bp.bp_brm_published_date_start, '%d-%m-%Y'), ''),IFNULL(DATE_FORMAT(bp.bp_brm_published_date_end,, '%d-%m-%Y'), '')) as publish_date,
			bp.bp_filename,
			bp.bp_website,
			bp.bp_month,
			bp.bp_year,
			b.b_application_number,
			rfc.rfc_value as status,
			IFNULL(DATE_FORMAT(b.b_receipt_date, '%d-%m-%Y'), '') as b_receipt_date_new
		");

		$this->db->from('invented_brand ib');
		$this->db->join('brm b', 'ib.ib_b_id = b.b_id', 'RIGHT');
		$this->db->join('brand br', 'ib.ib_br_id = br.br_id', 'RIGHT');
		$this->db->join('brm_properties bp', 'b.b_bp_id = bp.bp_id', 'LEFT');
		$this->db->join('ref_code rfc', 'ib.ib_status = rfc.rfc_code', 'LEFT');

		if (isset($params['txt_view_registered']) && !empty($params['txt_view_registered']) && $params['txt_view_registered'] == 'N')
		{
			$this->db->where('b.b_application_number <> br.br_app_number', NULL, FALSE);
		}

		if (isset($params['txt_brand_name']) && !empty($params['txt_brand_name'])) $this->db->like('b.b_brand', $params['txt_brand_name']);
		
		if (isset($params['txt_status']) && !empty($params['txt_status'])) {
			if ($params['txt_status'] == 'A') 
			{
				$this->db->where_in('ib.ib_status', array('N', 'H', 'S', 'A'));
			}
			else $this->db->where('ib.ib_status', $params['txt_status']);
		}
		else $this->db->where('ib.ib_status', 'N');
		
		$this->db->where('rfc.rfc_group', 'FINDINGS');
		$this->db->where('rfc.rfc_is_active', 'Y');
		$this->db->where('ib.ib_is_active', 'Y');

		return $this->create_result($params);
	}

	public function get_finding_status()
	{
		$this->db->select("
			rfc_code as code,
			rfc_value as value
		");
		
		$this->db->where('rfc_group', 'FINDINGS');
		$this->db->where('rfc_is_active', 'Y');

		return $this->db->get('ref_code');
	}

	public function store_data($params = array())
	{
		$this->table = 'invented_brand';
		$new_params = array(
			'ib_app_number' => $params['ib_app_number'],
			'ib_receive_date' => $params['ib_receive_date'],
			'ib_priority' => $params['ib_priority'],
			'ib_owner_name' => $params['ib_owner_name'],
			'ib_owner_address' => $params['ib_owner_address'],
			'ib_lawyer_name' => $params['ib_lawyer_name'],
			'ib_lawyer_address' => $params['ib_lawyer_address'],
			'ib_name' => $params['ib_name'],
			'ib_meaning_of_language' => $params['ib_meaning_of_language'],
			'ib_color_description' => $params['ib_color_description'],
			'ib_class_of_good_or_services' => $params['ib_class_of_good_or_services'],
			'ib_desc_of_good_or_services' => $params['ib_desc_of_good_or_services']
		);

		if ($params['mode'] == 'add') return $this->add($new_params);
		else return $this->edit($new_params, "ib_id = {$params['ib_id']}");
	}

	public function delete_data($params = array())
	{
		$this->table = 'invented_brand';
		$new_params = array(
			'ib_is_active' => 'N'
		);
		
		return $this->edit($new_params, "ib_id = {$params['ib_id']}");
	}

	public function skip_data($params = array())
	{
		$this->table = 'invented_brand';
		$new_params = array(
			'ib_status' => 'S'
		);
		
		return $this->edit($new_params, "ib_id = {$params['ib_id']}");
	}

	public function hold_data($params = array())
	{
		$this->table = 'invented_brand';
		$new_params = array(
			'ib_status' => 'H'
		);
		
		return $this->edit($new_params, "ib_id = {$params['ib_id']}");
	}

	public function get_data_by_id($ib_id)
	{
		$this->db->where('ib_id', $ib_id);
		$this->db->where('ib_is_active', 'Y');
		$this->db->where('ib_skip_flag', 'Y');

		return $this->db->get('invented_brand');
	}

	public function store_data_to_brand($params = array())
	{
		$this->table = 'brand';
		$new_params = array(
			'br_app_number' => $params['ib_app_number'],
			'br_receive_date' => $params['ib_receive_date'],
			'br_priority' => $params['ib_priority'],
			'br_owner_name' => $params['ib_owner_name'],
			'br_owner_address' => $params['ib_owner_address'],
			'br_lawyer_name' => $params['ib_lawyer_name'],
			'br_lawyer_address' => $params['ib_lawyer_address'],
			'br_name' => $params['ib_name'],
			'br_meaning_of_language' => $params['ib_meaning_of_language'],
			'br_color_description' => $params['ib_color_description'],
			'br_class_of_good_or_services' => $params['ib_class_of_good_or_services'],
			'br_desc_of_good_or_services' => $params['ib_desc_of_good_or_services']
		);

		return $this->add($new_params);
	}
}