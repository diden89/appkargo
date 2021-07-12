<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab/apps/module_frontend/master_data/controllers/Item_rab.php
 */

class Item_rab extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master_data/item_rab_model', 'db_item_rab');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Item RAB';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('master_data/item_rab', 'Item RAB')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/master_data/item_rab.js').'"></script>',
		);

		$this->store_params['item'] = [];

		// $load_data_item_rab = $this->db_item_rab->load_data_item_rab();

		// if ($load_data_item_rab->num_rows() > 0)
		// {
		// 	$num = 0;
		// 	$result = $load_data_item_rab->result();

		// 	foreach ($result as $k => $v)
		// 	{
		// 		$num++;

		// 		$v->num = $num;
		// 	}

		// 	$this->store_params['item'] = $result;
		// }

		$this->view('item_rab_view');
	}

	public function popup_modal()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);
			$post['option'] = $this->db_item_rab->get_option_unit()->result();
			$this->_view('item_rab_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_data_item_rab()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_item_rab')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_item_rab = $this->db_item_rab->load_data_item_rab($post);

			$number = 1;

			foreach ($load_data_item_rab->data as $k => $v)
			{
				$v->no = $number;

				$number++;
			}
			
			echo json_encode($load_data_item_rab);
		}
		else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

			$store_data = $this->db_item_rab->store_data_item($post);

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

			$delete_data = $this->db_item_rab->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

	public function delete_data_item()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_item = $this->db_item_rab->delete_data_item($post);

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