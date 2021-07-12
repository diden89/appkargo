<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/trademark/controllers/Ignored_words.php
 */

class Ignored_words extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('trademark/ignored_words_model', 'db_ignored_words');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Ignored Words';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('trademark/ignored_words', 'Ignored Words')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/trademark/ignored_words.js').'"></script>'
		);

		$this->store_params['words'] = [];

		$load_data_word = $this->db_ignored_words->load_data_word();

		if ($load_data_word->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_word->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
			}

			$this->store_params['words'] = $result;
		}

		$this->view('ignored_words_view');
	}

	public function load_word_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_word_form')
		{
			$post = $this->input->post(NULL, TRUE);

			$this->_view('ignored_words_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_data_word()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_word')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_word = $this->db_ignored_words->load_data_word($post);

			if ($load_data_word->num_rows() > 0) 
			{
				$result = $load_data_word->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;

					$number++;
				}

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function store_data_word()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_word')
		{
			$post = $this->input->post(NULL, TRUE);
			$store_data_word = $this->db_ignored_words->store_data_word($post);

			if ($store_data_word->num_rows() > 0) 
			{
				$result = $store_data_word->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;

					$number++;
				}

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function delete_data_word()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_word')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_word = $this->db_ignored_words->delete_data_word($post);

			if ($delete_data_word->num_rows() > 0) 
			{
				$result = $delete_data_word->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}
}