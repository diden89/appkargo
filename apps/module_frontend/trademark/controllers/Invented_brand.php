<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/controllers/Invented_brand.php
 */

class Invented_brand extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('trademark/Invented_brand_model', 'db_invented_brand');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Findings';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			// array('trademark/invented_brand', 'Findings')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/trademark/invented_brand.js').'"></script>'
		);

		$this->store_params['findings_status'] = $this->_get_findings_status();

		$this->view('invented_brand_view');
	}

	public function get_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_data')
		{
			$get_data = $this->db_invented_brand->get_data($post);

			$number = 1;

			foreach ($get_data->data as $k => $v) 
			{
				$v->no = $number;

				$file_link = base_url('files/' . $v->bp_filename);

				// $v->file_link = '<a href="' . $file_link . '" target="_blank">' . $v->bp_filename . '</a>';
				$v->file_link = $file_link;
				$v->bp_brm_published_date = '';

				if (!empty($v->bp_brm_published_date_start_new)) $v->bp_brm_published_date .= $v->bp_brm_published_date_start_new . ' - ';
				if (!empty($v->bp_brm_published_date_end_new)) $v->bp_brm_published_date .= $v->bp_brm_published_date_end_new;

				$number++;
			}

			echo json_encode($get_data);
		}
		else $this->show_404();
	}

	public function popup_modal()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);

			$this->_view('invented_brand_popup_modal_view', $post);
		}
		else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

			$store_data = $this->db_invented_brand->store_data($post);

			echo json_encode(array('success' => $store_data));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'delete_data')
		{
			unset($post['action']);

			$delete_data = $this->db_invented_brand->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

	public function skip_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'skip_data')
		{
			unset($post['action']);

			$skip_data = $this->db_invented_brand->skip_data($post);

			// if ($skip_data) $this->_store_data_to_brand($post['ib_id']);

			echo json_encode(array('success' => $skip_data));
		}
		else $this->show_404();
	}

	public function hold_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'hold_data')
		{
			unset($post['action']);

			$hold_data = $this->db_invented_brand->hold_data($post);

			echo json_encode(array('success' => $hold_data));
		}
		else $this->show_404();
	}

	private function _store_data_to_brand($ib_id)
	{
		$get_data_invented_brand = $this->db_invented_brand->get_data_by_id($ib_id);

		if ($get_data_invented_brand->num_rows() > 0) 
		{
			$params = $get_data_invented_brand->row_array();
			
			return $this->db_invented_brand->store_data_to_brand($params);
		}
	}

	private function _get_findings_status()
	{
		$get_finding_status = $this->db_invented_brand->get_finding_status();

		return $get_finding_status->result();
	}
}