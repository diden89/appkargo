<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/models/User_model.php
 */

class User_group_model extends NOOBS_Model
{
	public function get_data($params = array())
	{
		$this->db->from('user_group');

		if (isset($params['txt_id']) && !empty($params['txt_id'])) $this->db->where('ug_id', $params['txt_id']);

		$this->db->where('ug_is_active', 'Y');

		return $this->create_result($params);
	}

	public function get_autocomplete_data($params = array())
	{
		$this->db->select("
			*,
			ug_id as id,
			ug_caption as text,
			ug_caption as full_caption
		", FALSE);

		$this->db->from('user_group');

		$this->db->where('ug_is_active', 'Y');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(ug_caption LIKE '%{$query}%' OR ug_description LIKE '%{$query}%')", NULL, FALSE);
		}

		return $this->create_autocomplete_data($params);
	}

	public function store_data($params = array())
	{
		$this->table = 'user_group';

		$new_params = array(
			'ug_caption' => $params['ug_caption'],
			'ug_description' => $params['ug_description']
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "ug_id = {$params['ug_id']}");
	}

	public function delete_data($params = array())
	{
		$this->table = 'user_group';
		$new_params = array(
			'ug_is_active' => 'N'
		);
		
		return $this->edit($new_params, "ug_id = {$params['ug_id']}");
	}
}