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
		$this->table = 'similar_words';

		if (isset($params['txt_word']) && !empty($params['txt_word'])) $this->db->like('sw_word', $params['txt_word']);

		$this->db->where('sw_is_active', 'Y');
		$this->db->where('sw_br_id IS NOT NULL', NULL, FALSE);

		$this->db->order_by('last_datetime', 'DESC');

		return $this->create_result($params);
 	}

	public function get_data_similar_word($params = array())
	{
		$this->table = 'similar_words';

		if (isset($params['txt_similar_word']) && !empty($params['txt_similar_word'])) 
		{
			$arr_similar_word = explode(',', $params['txt_similar_word']);
			$this->db->where_in('sw_id', $arr_similar_word);
		}

		if (isset($params['txt_search_word']) && !empty($params['txt_search_word'])) $this->db->like('sw_word', $params['txt_search_word']);

		$this->db->where('sw_is_active', 'Y');

		return $this->create_result($params);
	}
}