<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/controllers/Brm_list.php
 */

class Brm_list extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('trademark/brm_list_model', 'db_brm_list');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'BRM List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('trademark/brm_list', 'BRM List')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/trademark/brm_list.js').'"></script>'
		);

		$this->store_params['brm'] = [];

		$load_data_brm = $this->db_brm_list->load_data_brm();

		if ($load_data_brm->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_brm->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
			}

			$this->store_params['brm'] = $result;
		}

		$this->view('brm_list_view');
	}

	public function load_data_brm()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_brm')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_brm = $this->db_brm_list->load_data_brm($post);

			if ($load_data_brm->num_rows() > 0) 
			{
				$result = $load_data_brm->result();
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