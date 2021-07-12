<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/models/Brand_model.php
 */

class Brand_model extends NOOBS_Model
{
	public function get_data($params = array())
	{
		$this->db->select("
			br.*,
			IFNULL(DATE_FORMAT(br.br_receive_date, '%d-%m-%Y'), '') as br_receive_date_new
		");

		$this->db->from('brand br');

		if (isset($params['txt_brand_name']) && !empty($params['txt_brand_name'])) $this->db->like('br.br_name', $params['txt_brand_name']);
		if (isset($params['txt_receive_date']) && !empty($params['txt_receive_date'])) 
		{
			$tmp_date = explode(' - ', $params['txt_receive_date']);
			
			$date_from = date('Y-m-d', strtotime($tmp_date[0]));
			$date_to = date('Y-m-d', strtotime($tmp_date[1]));
			
			$this->db->where("br.br_receive_date BETWEEN '{$date_from}' AND '{$date_to}'", NULL , FALSE);
		}
		
		$this->db->where('br.br_is_active', 'Y');

		return $this->create_result($params);
	}

	public function store_data($params = array())
	{
		$this->table = 'brand';
		$new_params = array(
			'br_app_number' => $params['br_app_number'],
			'br_receive_date' => $params['br_receive_date'],
			'br_priority' => $params['br_priority'],
			'br_owner_name' => $params['br_owner_name'],
			'br_owner_address' => $params['br_owner_address'],
			'br_lawyer_name' => $params['br_lawyer_name'],
			'br_lawyer_address' => $params['br_lawyer_address'],
			'br_name' => $params['br_name'],
			'br_meaning_of_language' => $params['br_meaning_of_language'],
			'br_color_description' => $params['br_color_description'],
			'br_class_of_good_or_services' => $params['br_class_of_good_or_services'],
			'br_desc_of_good_or_services' => $params['br_desc_of_good_or_services']
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "br_id = {$params['br_id']}");
	}

	public function delete_data($params = array())
	{
		$this->table = 'brand';
		$new_params = array(
			'br_is_active' => 'N'
		);
		
		return $this->edit($new_params, "br_id = {$params['br_id']}");
	}

	public function get_data_to_export($params = array())
	{
		$this->db->select("
			br.*,
			IFNULL(DATE_FORMAT(br.br_receive_date, '%d-%m-%Y'), '') as br_receive_date_new
		");

		$this->db->from('brand br');

		if (isset($params['txt_brand_name']) && !empty($params['txt_brand_name'])) $this->db->like('br.br_name', $params['txt_brand_name']);
		if (isset($params['txt_receive_date']) && !empty($params['txt_receive_date'])) 
		{
			$tmp_date = explode(' - ', $params['txt_receive_date']);
			
			$date_from = date('Y-m-d', strtotime($tmp_date[0]));
			$date_to = date('Y-m-d', strtotime($tmp_date[1]));
			
			$this->db->where("br.br_receive_date BETWEEN '{$date_from}' AND '{$date_to}'", NULL , FALSE);
		}
		
		$this->db->where('br.br_is_active', 'Y');

		return $this->db->get();
	}

	public function insert_word_to_dictionary($br_id, $word)
	{
		$this->table = 'dictionary';

		$new_params = array(
			'd_br_id' => $br_id,
			'd_word' => $word
		);

		return $this->add($new_params, TRUE);
	}

	public function edit_word_in_dictionary($br_id, $word)
	{
		$this->table = 'dictionary';

		$new_params = array(
			'd_word' => $word
		);

		return $this->edit($new_params, "d_br_id = {$br_id}");
	}
}