<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/models/Dictionary_model.php
 */

class Dictionary_model extends NOOBS_Model
{
	public function get_data($params = array())
	{
		if (isset($params['txt_word']) && !empty($params['txt_word'])) $this->db->like('d_word', $params['txt_word']);

		$this->db->where('d_is_active', 'Y');
		$this->db->where('d_br_id IS NOT NULL', NULL, FALSE);

		$this->db->order_by('last_datetime', 'DESC');

		$this->db->limit(30);

		return $this->db->get('dictionary');
 	}

	public function get_autocomplete_data($params = array())
	{
		$this->db->select("
			d.*,
			d_id as id,
			d_word as text,
			d_word as full_name
		", FALSE);

		$this->db->from('dictionary d');

		$this->db->where('d_is_active', 'Y');
		$this->db->where('d_similar_word IS NULL', NULL, FALSE);

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(d.d_word LIKE '%{$query}%')", NULL, FALSE);
		}

		if (isset($params['txt_d_similar_word']) && !empty($params['txt_d_similar_word'])) 
		{
			$arr_similar_word = explode(',', $params['txt_d_similar_word']);

			$this->db->where_not_in('d_id', $arr_similar_word);
		}

		if (isset($params['txt_d_id']) && !empty($params['txt_d_id'])) $this->db->where_not_in('d_id', array($params['txt_d_id']));

		return $this->create_autocomplete_data($params);
	}

	public function get_data_similar_word($params = array())
	{
		$arr_similar_word = explode(',', $params['txt_similar_word']);

		$this->db->where_in('d_id', $arr_similar_word);

		$this->db->where('d_is_active', 'Y');

		return $this->db->get('dictionary');
	}

	public function check_word_available($word)
	{
		$this->db->where('d_word', $word);
		$this->db->where('d_is_active', 'Y');

		return $this->db->get('dictionary');
	}

	public function store_new_word($word)
	{
		$this->table = 'dictionary';

		$new_params = array(
			'd_word' => $word
		);

		return $this->add($new_params, TRUE);
	}

	public function edit_data($params = array())
	{
		$this->table = 'dictionary';

		$new_params = array(
			'd_word' => $params['d_word']
		);

		return $this->edit($new_params, "d_id = {$params['d_id']}");
	}

	public function edit_dictionary($txt_d_id, $arr_similar_word)
	{
		$this->table = 'dictionary';

		$txt_similar_word = implode(',', $arr_similar_word);

		$new_params = array(
			'd_similar_word' => $txt_similar_word
		);

		return $this->edit($new_params, "d_id = {$txt_d_id}");
	}

	public function check_arr_similar_word_by_d_id($txt_d_id)
	{
		$this->db->where('d_id', $txt_d_id);
		$this->db->where('d_is_active', 'Y');

		return $this->db->get('dictionary');
	}

	public function delete_data($params = array())
	{
		$this->table = 'dictionary';
		$new_params = array(
			'd_is_active' => 'N'
		);
		
		return $this->edit($new_params, "d_id = {$params['d_id']}");
	}
}