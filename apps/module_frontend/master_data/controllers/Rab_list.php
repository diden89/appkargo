<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /rab/apps/module_frontend/master_data/controllers/Rab_list.php
 */

class Rab_list extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master_data/rab_list_model', 'db_rab_list');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'RAB List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('master_data/rab_list', 'RAB List')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/master_data/rab_list.js').'"></script>',
		);

		$this->store_params['item'] = [];

		$this->view('rab_list_view');
	}

	public function popup_modal()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);

			$post['option_rab'] = $this->db_rab_list->get_option_unit(array('ir_is_active' => 'Y'),'item_rab')->result();
			$post['option_item'] = $this->db_rab_list->get_option_unit(array('il_is_active' => 'Y'),'item_list')->result();
			$post['option_unit'] = $this->db_rab_list->get_option_unit(array('un_is_active' => 'Y'),'unit')->result();

			$this->_view('rab_list_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data = $this->db_rab_list->load_data($post);

			$number = 1;

			foreach ($load_data->data as $k => $v)
			{
				$v->no = $number;

				$number++;
			}
			
			echo json_encode($load_data);
		}
		else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

			$store_data = $this->db_rab_list->store_data_item($post);

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

			$delete_data = $this->db_rab_list->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

	public function delete_data_item()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_item = $this->db_rab_list->delete_data_item($post);

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