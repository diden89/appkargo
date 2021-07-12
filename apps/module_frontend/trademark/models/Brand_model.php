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
			IFNULL(DATE_FORMAT(br.br_receive_date, '%d-%m-%Y'), '') as br_receive_date_new,
			IFNULL(DATE_FORMAT(br.br_expiry_date, '%d-%m-%Y'), '') as br_expiry_date_new,
			IFNULL(DATE_FORMAT(br.br_reminder, '%d-%m-%Y'), '') as br_reminder_new,
			ud1.ud_fullname as created_user,
			ud2.ud_fullname as updated_user,
			IFNULL(DATE_FORMAT(br.first_datetime, '%d-%m-%Y'), '') as created_date,
			IFNULL(DATE_FORMAT(br.last_datetime, '%d-%m-%Y'), '') as updated_date
		");

		$this->db->from('brand br');
		$this->db->join('user_detail ud1', 'br.first_user = ud1.ud_id', 'LEFT');
		$this->db->join('user_detail ud2', 'br.first_user = ud2.ud_id', 'LEFT');

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
			'br_desc_of_good_or_services' => $params['br_desc_of_good_or_services'],
			'br_status' => $params['br_status'],
			'br_description' => $params['br_description'],
			'br_reminder' => $params['br_reminder'],
			'br_reg_number' => $params['br_reg_number'],
			'br_expiry_date' => $params['br_expiry_date'],
			'br_history_status' => $params['br_history_status'],
			'br_contact_person' => $params['br_contact_person'],
			'br_last_client_update' => $params['br_last_client_update'],
			'br_history_client_update' => $params['br_history_client_update'],
			'br_fee' => $params['br_fee'],
			'br_bill' => $params['br_bill'],
			'br_payment_status' => $params['br_payment_status'],
			'br_document' => $params['br_document'],
			'br_additional_document' => $params['br_additional_document'],
			'br_certificate' => $params['br_certificate'],
			'br_img' => $params['br_img']
		);

		$decrypt_token = $this->decrypt_token();
	
		if ($params['mode'] == 'add') {
			$this->db->set('first_user', $decrypt_token['ud_id']);
			$this->db->set('first_datetime', 'NOW()', FALSE);
		}

		if ($params['mode'] == 'upload') {

			if (!empty($params['first_datetime'])) {
				$first_datetime = $params['first_datetime'];
				$new_value = date('Y-m-d H:i:s', strtotime($first_datetime));
				$this->db->set('first_datetime', "DATE_FORMAT('{$new_value}', '%Y-%m-%d %H:%i:%s')", FALSE);
			} 
			else $this->db->set('first_datetime', 'NOW()', FALSE);

			if (!empty($params['last_datetime'])) {
				$last_datetime = $params['last_datetime'];
				$new_value = date('Y-m-d H:i:s', strtotime($last_datetime));
				$this->db->set('last_datetime', "DATE_FORMAT('{$new_value}', '%Y-%m-%d %H:%i:%s')", FALSE);
			}
			else $this->db->set('last_datetime', 'NOW()', FALSE);

			if (!empty($params['first_user'])) $this->db->set('first_user', $params['first_user']);
			else $this->db->set('first_user', $decrypt_token['ud_id']);

			if (!empty($params['last_user'])) $this->db->set('last_user', $params['last_user']);
			else $this->db->set('last_user', $decrypt_token['ud_id']);
		}

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		elseif ($params['mode'] == 'upload') return $this->add($new_params, TRUE, TRUE);
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
			br.*,
			IFNULL(DATE_FORMAT(br.br_receive_date, '%d-%m-%Y'), '') as br_receive_date_new,
			IFNULL(DATE_FORMAT(br.br_expiry_date, '%d-%m-%Y'), '') as br_expiry_date_new,
			IFNULL(DATE_FORMAT(br.br_reminder, '%d-%m-%Y'), '') as br_reminder_new,
			ud1.ud_fullname as created_user,
			ud2.ud_fullname as updated_user,
			IFNULL(DATE_FORMAT(br.first_datetime, '%d-%m-%Y'), '') as created_date,
			IFNULL(DATE_FORMAT(br.last_datetime, '%d-%m-%Y'), '') as updated_date
		");

		$this->db->from('brand br');
		$this->db->join('user_detail ud1', 'br.first_user = ud1.ud_id', 'LEFT');
		$this->db->join('user_detail ud2', 'br.first_user = ud2.ud_id', 'LEFT');

		if (isset($params['txt_brand_name']) && !empty($params['txt_brand_name'])) $this->db->like('br.br_name', $params['txt_brand_name']);
		if (isset($params['txt_receive_date']) && !empty($params['txt_receive_date'])) 
		{
			$tmp_date = explode(' - ', $params['txt_receive_date']);
			
			$date_from = date('Y-m-d', strtotime($tmp_date[0]));
			$date_to = date('Y-m-d', strtotime($tmp_date[1]));
			
			$this->db->where("br.br_receive_date BETWEEN '{$date_from}' AND '{$date_to}'", NULL , FALSE);
		}
		
		$this->db->where('br.br_is_active', 'Y');

		if (isset($params['gridBrand_length']) && !empty($params['gridBrand_length'])) $this->db->limit($params['gridBrand_length']);
		
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

	public function get_user_id($ud_fullname)
	{
		$this->db->where('ud_fullname', $ud_fullname);
		$this->db->where('ud_is_active', 'Y');

		return $this->db->get('user_detail');
	}
}