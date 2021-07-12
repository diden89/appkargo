<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab/apps/module_frontend/trademark/models/Building_type_model.php
 */

class Building_type_model extends NOOBS_Model
{
	public function load_data_building_type($params = array())
	{
		if (isset($params['txt_item']) && ! empty($params['txt_item']))
		{
			$this->db->where('bt.bt_building_type', strtoupper($params['txt_building_type']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('bt.bt_id', strtoupper($params['txt_id']));
		}

		$this->db->select("*");
		$this->db->from("building_type bt");
		$this->db->where('bt.bt_is_active', 'Y');

		return $this->create_result($params);
 	}

	public function store_data_item($params = array())
	{
		$this->table = 'building_type';

		$new_params = array(
			'bt_building_type' => $params['txt_building_type']
		);

		if ($params['mode'] == 'add') $this->add($new_params, TRUE);
		else $this->edit($new_params, "bt_id = {$params['txt_id']}");

		return $this->load_data_building_type();
	}

	public function delete_data($params = array())
	{
		$this->table = 'building_type';

		$this->edit(['bt_is_active' => 'N'], "bt_id = {$params['txt_id']}");
		
		return $this->load_data_building_type();
	}

	public function load_data($params = array())
	{
		$this->db->where('bt_building_type', strtoupper($params['txt_building_type	']));
		$this->db->where('bt_is_active', 'Y');

		return $this->db->get('building_type');
 	}

}