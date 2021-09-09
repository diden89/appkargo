<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/controllers/Item_list.php
 */

class Item_list extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master_data/item_list_model', 'db_item_list');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Daftar Item';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('master_data/item_list', 'Daftar Item')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/master_data/item_list.js').'"></script>',
		);

		$this->store_params['item'] = [];

		$load_data_item_list = $this->db_item_list->load_data_item_list();

		if ($load_data_item_list->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_item_list->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
			}

			$this->store_params['item'] = $result;
		}

		$this->view('item_list_view');
	}

	public function load_item_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_item_form')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$post['option'] = $this->db_item_list->get_option_unit()->result();
			$post['vendor'] = $this->db_item_list->get_option_vendor()->result();
			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_item_list->load_data_item_list($post)->row();
			}
	
			$this->_view('item_list_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_data_item_list()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_item_list')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_item_list = $this->db_item_list->load_data_item_list($post);
			// print_r($_POST);exit;
			if ($load_data_item_list->num_rows() > 0) 
			{
				$result = $load_data_item_list->result();
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

	public function store_data_item()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_item')
		{
			$post = $this->input->post(NULL, TRUE);
			$store_data_item = $this->db_item_list->store_data_item($post);

			if ($store_data_item->num_rows() > 0) 
			{
				$result = $store_data_item->result();
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

	public function delete_data_item()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_item = $this->db_item_list->delete_data_item($post);

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