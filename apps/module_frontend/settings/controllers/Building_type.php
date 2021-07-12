<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab/apps/module_frontend/settings/controllers/Building_type.php
 */

class Building_type extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('settings/building_type_model', 'db_building_type');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Building Type';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('settings/building_type', 'Building Type')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/settings/building_type.js').'"></script>',
		);

		$this->store_params['item'] = [];

		$this->view('building_type_view');
	}

	public function popup_modal()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);
			$this->_view('building_type_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_data_building_type()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_building_type')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_building_type = $this->db_building_type->load_data_building_type($post);

			$number = 1;

			foreach ($load_data_building_type->data as $k => $v)
			{
				$v->no = $number;

				$number++;
			}
			
			echo json_encode($load_data_building_type);
		}
		else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

			$store_data = $this->db_building_type->store_data_item($post);

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

			$delete_data = $this->db_building_type->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

	public function delete_data_item()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_item = $this->db_building_type->delete_data_item($post);

			if ($delete_data_item->num_rows() > 0) 
			{
				$result = $delete_data_item->result();
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