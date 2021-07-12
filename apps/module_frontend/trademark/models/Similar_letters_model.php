<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/models/Similar_letters_model.php
 */ 

class Similar_letters_model extends NOOBS_Model
{
	public function load_data_letter($params = [])
	{
		$this->table = 'similar_letters';

		if (isset($params['txt_letter']) && ! empty($params['txt_letter']))
		{
			$this->db->like('sl_letter', strtoupper($params['txt_letter']), 'both');
		}

		if (isset($params['txt_letter']) && $params['txt_letter'] == '0')
		{
			$this->db->like('sl_letter', strtoupper($params['txt_letter']), 'both');
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('sl_id', strtoupper($params['txt_id']));
		}

		$this->db->select("sl_id AS id, sl_letter AS letter", FALSE);
		$this->db->where('sl_is_active', 'Y');
		$this->db->where('sl_similar_letter', NULL);
		$this->db->order_by('sl_letter', 'ASC');

		return $this->create_result($params);
 	}

	public function store_data_letter($params = [])
	{
		$this->table = 'similar_letters';

		if (isset($params['mode']) && $params['mode'] == 'edit')
		{
			$id = $params['txt_id'];

			return $this->edit(['sl_letter' => strtoupper($params['txt_letter']), 'sl_length' => strlen($params['txt_letter'])], "sl_id = {$id}");
		}
		else return $this->add(['sl_letter' => strtoupper($params['txt_letter']), 'sl_length' => strlen($params['txt_letter'])]);
	}

	public function delete_data_letter($params = [])
	{
		$this->table = 'similar_letters';

		return $this->edit(['sl_is_active' => 'N'], "sl_id = {$params['txt_id']}");
	}

	public function load_data_similar_letter($params = [])
	{
		$this->table = 'similar_letters';

		if (isset($params['txt_letter']) && ! empty($params['txt_letter']))
		{
			$txt_letter = $this->db->escape_str($params['txt_letter']);
			
			$this->db->where("BINARY sl_letter = '{$txt_letter}'", NULL, FALSE);
		}
		elseif (isset($params['txt_similar_letter']) && ! empty($params['txt_similar_letter']))
		{
			$this->db->like('sl_letter', $params['txt_similar_letter'], 'both');
		}

		if (isset($params['txt_id_letter']) && ! empty($params['txt_id_letter']))
		{
			$this->db->where('sl_similar_letter', $params['txt_id_letter']);
		}
		elseif (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('sl_similar_letter', $params['txt_id']);
		}

		$this->db->select("sl_id AS id, sl_letter AS letter", FALSE);
		$this->db->where('sl_is_active', 'Y');
		$this->db->order_by('sl_letter', 'ASC');

		return $this->create_result($params);
 	}

	public function store_data_similar_letter($params = [])
	{
		$this->table = 'similar_letters';
		$id_letter = $params['txt_id_letter'];

		if (isset($params['mode']) && $params['mode'] == 'edit')
		{
			$id = $params['txt_id'];

			return $this->edit(['sl_letter' => strtoupper($params['txt_similar_letter']), 'sl_length' => strlen($params['txt_similar_letter'])], "sl_id = {$id}");
		}
		else return $this->add(['sl_letter' => strtoupper($params['txt_similar_letter']), 'sl_similar_letter' => $id_letter, 'sl_length' => strlen($params['txt_similar_letter'])]);
	}

	public function delete_data_similar_letter($params = [])
	{
		$this->table = 'similar_letters';

		return $this->edit(['sl_is_active' => 'N'], "sl_id = {$params['txt_id']}");
	}
}