<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/models/Ignored_words_model.php
 */

class Ignored_words_model extends NOOBS_Model
{
	public function load_data_word($params = array())
	{
		if (isset($params['txt_word']) && ! empty($params['txt_word']))
		{
			$this->db->where('iw_word', strtoupper($params['txt_word']));
		}

		if (isset($params['txt_id']) && ! empty($params['txt_id']))
		{
			$this->db->where('iw_id', strtoupper($params['txt_id']));
		}

		$this->db->select("iw_id AS id, iw_word AS words", FALSE);
		$this->db->where('iw_is_active', 'Y');
		$this->db->order_by('iw_word', 'ASC');

		return $this->db->get('ignored_words');
 	}

	public function store_data_word($params = array())
	{
		$this->table = 'ignored_words';

		if (isset($params['mode']) && $params['mode'] == 'edit')
		{
			$id = $params['txt_id'];

			$this->edit(['iw_word' => strtoupper($params['txt_word'])], "iw_id = {$id}");
		}
		else $this->add(['iw_word' => strtoupper($params['txt_word'])]);

		return $this->load_data_word();
	}

	public function delete_data_word($params = array())
	{
		$this->table = 'ignored_words';

		$this->edit(['iw_is_active' => 'N'], "iw_id = {$params['txt_id']}");
		
		return $this->load_data_word();
	}

	public function load_data($params = array())
	{
		$this->db->where('iw_word', strtoupper($params['txt_word']));
		$this->db->where('iw_is_active', 'Y');

		return $this->db->get('ignored_words');
 	}

	public function delete_data($params = array())
	{
		$this->table = 'ignored_words';

		$this->db->where('iw_id', $params['txt_id']);

		$qry = $this->db->get($this->table);

		if ($qry->num_rows() > 0)
		{
			$row = $qry->row();

			$exp = explode(';', $row->iw_similar_letter);
			$data = [];

			foreach ($exp as $k => $v)
			{
				if ($v == $params['txt_word']) continue;

				$data[] = $v;
			}

			$this->edit(['iw_similar_letter' => implode(';', $data)], "iw_id = {$params['txt_id']}");

			return $this->load_data(['txt_word' => $row->iw_word]);
		}
		return FALSE;
	}

	public function store_data($params = array())
	{
		$this->table = 'ignored_words';

		$this->db->where('iw_word', $params['txt_word']);

		$qry = $this->db->get($this->table);

		if ($qry->num_rows() > 0)
		{
			$row = $qry->row();

			$this->edit(['iw_similar_letter' => $row->iw_similar_letter.';'.$params['txt_similar_letter']], "iw_id = {$row->iw_id}");

			return $this->load_data(['txt_word' => $row->iw_word]);
		}
		return FALSE;
	}
}