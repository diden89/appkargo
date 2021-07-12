<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/models/Similar_words_model.php
 */

class Similar_words_model extends NOOBS_Model
{
	public function get_data($params = array())
	{
		if (isset($params['txt_word']) && !empty($params['txt_word'])) $this->db->like('sw_word', $params['txt_word']);

		$this->db->where('sw_is_active', 'Y');
		$this->db->where('sw_br_id IS NOT NULL', NULL, FALSE);

		$this->db->order_by('last_datetime', 'DESC');

		$this->db->limit(30);

		return $this->db->get('similar_words');
 	}

	public function get_autocomplete_data($params = array())
	{
		$this->db->select("
			sw.*,
			sw_id as id,
			sw_word as text,
			sw_word as full_name
		", FALSE);

		$this->db->from('similar_words sw');

		$this->db->where('sw_is_active', 'Y');
		$this->db->where('sw_similar_word IS NULL', NULL, FALSE);

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(d.sw_word LIKE '%{$query}%')", NULL, FALSE);
		}

		if (isset($params['txt_sw_similar_word']) && !empty($params['txt_sw_similar_word'])) 
		{
			$arr_similar_word = explode(',', $params['txt_sw_similar_word']);

			$this->db->where_not_in('sw_id', $arr_similar_word);
		}

		if (isset($params['txt_sw_id']) && !empty($params['txt_sw_id'])) $this->db->where_not_in('sw_id', array($params['txt_sw_id']));

		return $this->create_autocomplete_data($params);
	}

	public function get_data_similar_word($params = array())
	{
		$arr_similar_word = explode(',', $params['txt_similar_word']);

		$this->db->where_in('sw_id', $arr_similar_word);

		if (isset($params['txt_search_word']) && !empty($params['txt_search_word'])) $this->db->like('sw_word', $params['txt_search_word']);

		$this->db->where('sw_is_active', 'Y');

		return $this->db->get('similar_words');
	}

	public function check_worsw_available($word)
	{
		$this->db->where('sw_word', $word);
		$this->db->where('sw_is_active', 'Y');

		return $this->db->get('similar_words');
	}

	public function store_new_word($word)
	{
		$this->table = 'similar_words';

		$new_params = array(
			'sw_word' => $word
		);

		return $this->add($new_params, TRUE);
	}

	public function edit_data($params = array())
	{
		$this->table = 'similar_words';

		$new_params = array(
			'sw_word' => $params['sw_word']
		);

		return $this->edit($new_params, "sw_id = {$params['sw_id']}");
	}

	public function edit_similar_words($txt_sw_id, $arr_similar_word)
	{
		$this->table = 'similar_words';

		$txt_similar_word = implode(',', $arr_similar_word);

		$new_params = array(
			'sw_similar_word' => $txt_similar_word
		);

		return $this->edit($new_params, "sw_id = {$txt_sw_id}");
	}

	public function check_arr_similar_word_by_sw_id($txt_sw_id)
	{
		$this->db->where('sw_id', $txt_sw_id);
		$this->db->where('sw_is_active', 'Y');

		return $this->db->get('similar_words');
	}

	public function delete_data($params = array())
	{
		$this->table = 'similar_words';
		$new_params = array(
			'sw_is_active' => 'N'
		);
		
		return $this->edit($new_params, "sw_id = {$params['sw_id']}");
	}
}