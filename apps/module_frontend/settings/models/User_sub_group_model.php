<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/models/User_model.php
 */

class User_sub_group_model extends NOOBS_Model
{
	public function get_data($params = array())
	{
		$this->db->select('
			usg.*,
			usg.usg_caption,
			usg.usg_description,
			ug.ug_caption
			');
		$this->db->from('user_sub_group usg');
		$this->db->join('user_group ug','usg.usg_group = ug.ug_id','LEFT');

		if (isset($params['txt_id']) && !empty($params['txt_id'])) $this->db->where('usg.usg_id', $params['txt_id']);

		$this->db->where('usg.usg_is_active', 'Y');

		return $this->create_result($params);
	}

	public function get_autocomplete_data($params = array())
	{
		$this->db->select("
			*,
			usg_id as id,
			usg_caption as text,
			usg_caption as full_caption
		", FALSE);

		$this->db->from('user_sub_group');

		$this->db->where('usg_is_active', 'Y');

		if (isset($params['query']) && !empty($params['query'])) 
		{
			$query = $params['query'];
			$this->db->where("(usg_caption LIKE '%{$query}%' OR usg_description LIKE '%{$query}%')", NULL, FALSE);
		}

		return $this->create_autocomplete_data($params);
	}

	public function store_data($params = array())
	{
		$this->table = 'user_sub_group';

		$new_params = array(
			'usg_caption' => $params['usg_caption'],
			'usg_description' => $params['usg_description'],
			'usg_group' => $params['ug_id']
		);

		if ($params['mode'] == 'add') return $this->add($new_params, TRUE);
		else return $this->edit($new_params, "usg_id = {$params['usg_id']}");
	}

	public function delete_data($params = array())
	{
		$this->table = 'user_sub_group';
		$new_params = array(
			'usg_is_active' => 'N'
		);
		
		return $this->edit($new_params, "usg_id = {$params['usg_id']}");
	}

	public function get_user_group()
	{
		$this->db->where('ug_is_active', 'Y');

		return $this->db->get('user_group');
	}
}