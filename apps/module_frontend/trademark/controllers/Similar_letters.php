<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/controllers/Similar_letters.php
 */

class Similar_letters extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('trademark/similar_letters_model', 'db_similar_letters');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Similar Letters and/or Numbers';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home')/* ,
			array('trademark/similar_letters', 'Similar Letters') */
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/trademark/similar_letters.js').'"></script>'
		);

		$this->view('similar_letters_view');
	}

	public function load_letter_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_letter_form')
		{
			$post = $this->input->post(NULL, TRUE);

			$this->_view('similar_letters_form_letter_view', $post);
		}
		else $this->show_404();
	}

	public function load_data_letter()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_letter')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_letter = $this->db_similar_letters->load_data_letter($post);

			if ($load_data_letter->recordsTotal > 0) 
			{
				$number = 1;

				foreach ($load_data_letter->data as $k => $v)
				{
					$v->no = $number;

					$number++;
				}
			}

			echo json_encode($load_data_letter);
		}
		else $this->show_404();
	}

	public function store_data_letter()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_letter')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_letter = $this->db_similar_letters->load_data_letter($post);

			if ($load_data_letter->recordsTotal > 0) 
			{
				echo json_encode(array('success' => FALSE, 'msg' => 'Letter already exist.'));
			}
			else
			{
				$store_data_letter = $this->db_similar_letters->store_data_letter($post);

				echo json_encode(array('success' => $store_data_letter));
			}
		}
		else $this->show_404();
	}

	public function delete_data_letter()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_letter')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_letter = $this->db_similar_letters->delete_data_letter($post);

			echo json_encode(array('success' => $delete_data_letter));
		}
		else $this->show_404();
	}

	public function load_data_similar_letter()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_similar_letter')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_similar_letter = $this->db_similar_letters->load_data_similar_letter($post);

			if ($load_data_similar_letter->recordsTotal > 0) 
			{
				$number = 1;

				foreach ($load_data_similar_letter->data as $k => $v)
				{
					$v->no = $number;

					$number++;
				}
			}

			echo json_encode($load_data_similar_letter);
		}
		else $this->show_404();
	}

	public function load_similar_letter_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_similar_letter_form')
		{
			$post = $this->input->post(NULL, TRUE);

			$this->_view('similar_letters_form_similar_letter_view', $post);
		}
		else $this->show_404();
	}

	public function delete_data_similar_letter()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_similar_letter')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_similar_letter = $this->db_similar_letters->delete_data_similar_letter($post);

			echo json_encode(array('success' => $delete_data_similar_letter));
		}
		else $this->show_404();
	}

	public function store_data_similar_letter()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_similar_letter')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_similar_letter = $this->db_similar_letters->load_data_similar_letter([
				'txt_letter' => $post['txt_similar_letter'],
				'txt_id_letter' => $post['txt_id_letter']
			]);

			if ($load_data_similar_letter->recordsTotal > 0) 
			{
				echo json_encode(array('success' => FALSE, 'msg' => 'Similar letter already exist.'));
			}
			else
			{
				$store_data_similar_letter = $this->db_similar_letters->store_data_similar_letter($post);

				echo json_encode(array('success' => $store_data_similar_letter));
			}
		}
		else $this->show_404();
	}
}