<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/controllers/Driver.php
 */

class Driver extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master_data/driver_model', 'db_driver');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Data Pengemudi';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('master_data/driver', 'Data Pengemudi')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/master_data/driver.js').'"></script>',
		);

		$this->view('driver_view');
	}

	public function get_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_data')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_driver = $this->db_driver->load_data_driver($post);

			$result = $load_data_driver;
			$number = 1;

			foreach ($result->data as $k => $v)
			{
				$v->no = $number;

				$number++;
			}

			echo json_encode($result);
		}
		else $this->show_404();
	}


	public function load_driver_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_driver_form')
		{
			$post = $this->input->post(NULL, TRUE);

			$params = array(
				'table' => 'province'
			);

			$post['province'] = $this->db_driver->get_option_province()->result();
			$post['vendor'] = $this->db_driver->get_option_driver()->result();
			if($post['mode'] == 'edit')
			{
				$post['driver'] = $this->db_driver->load_data($post['data'])->row();
				$post['user_detail'] = $this->db_driver->get_option_user_detail($post['data']['d_ud_id'])->result();
				
			}
			else
			{
				$post['user_detail'] = $this->db_driver->get_option_user_detail()->result();
			}
			// print_r($post);exit;
	
			$this->_view('driver_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_region_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_region_option')
		{
			unset($post['action']);

			$get_region_option = $this->db_driver->get_region_option($post);

			if ($get_region_option->num_rows() > 0) 
			{
				$result = $get_region_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}
	public function get_district_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_district_option')
		{
			unset($post['action']);

			$get_district_option = $this->db_driver->get_district_option($post);

			if ($get_district_option->num_rows() > 0) 
			{
				$result = $get_district_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}


	public function store_data()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'store_data')
		{
			$post = $this->input->post(NULL, TRUE);
			$store_data = $this->db_driver->store_data($post);

			echo json_encode(array('success' => $store_data));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data')
		{
			unset($post['action']);
			$delete_data = $this->db_driver->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_driver->get_autocomplete_data($post);

			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}
}