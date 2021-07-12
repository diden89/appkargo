<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/controllers/Similar_words.php
 */

class Similar_words extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('trademark/similar_words_model', 'db_similar_words');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Similar Words';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('trademark/similar_words', 'Similar Words')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/trademark/similar_words.js').'"></script>'
		);

		$this->view('similar_words_view');
	}

	public function get_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_data')
		{
			$get_data = $this->db_similar_words->get_data($post);

			$number = 1;

			foreach ($get_data->data as $k => $v) 
			{
				$v->no = $number;

				$number++;
			}

			echo json_encode($get_data);
		}
		else $this->show_404();
	}

	public function get_data_similar_word()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_data_similar_word')
		{
			// if (isset($post['load']) && !empty($post['load']) && $post['load'] == 'false')
			// {
			// 	$result = new stdClass();
			// 	$result->success = TRUE;
			// 	$result->draw = $post['draw'];
			// 	$result->recordsTotal = 0;
			// 	$result->recordsFiltered = 0;
			// 	$result->data = array();

			// 	echo json_encode($result);
			// }
			// else
			// {
				$get_data_similar_word = $this->db_similar_words->get_data_similar_word($post);

				$number = 1;

				foreach ($get_data_similar_word->data as $k => $v) 
				{
					$v->no = $number;

					$number++;
				}

				echo json_encode($get_data_similar_word);
			// }
		}
		else $this->show_404();
	}
}