<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab_frontend/apps/module_frontend/settings/controllers/Item_unit.php
 */

class Item_unit extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('settings/item_unit_model', 'db_item_unit');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Item Unit';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('settings/item_unit', 'Item Unit')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/settings/item_unit.js').'"></script>'
		);

		$this->store_params['unit'] = [];

		$load_data_item_unit = $this->db_item_unit->load_data_item_unit();

		if ($load_data_item_unit->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_item_unit->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
			}

			$this->store_params['unit'] = $result;
		}

		$this->view('item_unit_view');
	}

	public function load_item_unit_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_item_unit_form')
		{
			$post = $this->input->post(NULL, TRUE);

			$this->_view('item_unit_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_data_item_unit()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_item_unit')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_item_unit = $this->db_item_unit->load_data_item_unit($post);

			if ($load_data_item_unit->num_rows() > 0) 
			{
				$result = $load_data_item_unit->result();
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

	public function store_data_item_unit()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_item_unit')
		{
			$post = $this->input->post(NULL, TRUE);
			$store_data_item_unit = $this->db_item_unit->store_data_item_unit($post);

			if ($store_data_item_unit->num_rows() > 0) 
			{
				$result = $store_data_item_unit->result();
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

	public function delete_data_item_unit()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item_unit')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_item_unit = $this->db_item_unit->delete_data_item_unit($post);

			if ($delete_data_item_unit->num_rows() > 0) 
			{
				$result = $delete_data_item_unit->result();
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