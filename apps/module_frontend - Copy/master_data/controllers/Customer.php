<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/controllers/Customer.php
 */

class Customer extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master_data/customer_model', 'db_customer');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Data Pelanggan';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('master_data/customer', 'Data Pelanggan')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/master_data/customer.js').'"></script>',
		);
		
		$this->view('customer_view');
	}

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);
		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_customer->get_autocomplete_data($post);

		// print_r($get_autocomplete_data);exit;
			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}


	public function load_customer_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_customer_form')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array(
				'table' => 'province'
			);
			// print_r($post);exit;
			$post['province'] = $this->db_customer->get_option_province()->result();
			// $post['vendor'] = $this->db_customer->get_option_customer()->result();
			// if($post['mode'] == 'edit')
			// {
			// 	$post['data'] = $this->db_customer->load_data_customer($post)->row();
			// }
	
			$this->_view('customer_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_region_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_region_option')
		{
			unset($post['action']);

			$get_region_option = $this->db_customer->get_region_option($post);

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

			$get_district_option = $this->db_customer->get_district_option($post);

			if ($get_district_option->num_rows() > 0) 
			{
				$result = $get_district_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function load_data_customer()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_customer')
		{
			$post = $this->input->post(NULL, TRUE);
			$data = $this->db_customer->load_data_customer($post);
		
			$num = 1;

			foreach ($data->data as $k => $v)
			{
				$v->num = $num;
				$v->c_shipping_area = number_format($v->c_shipping_area);
				$v->c_distance_area_full = $v->c_distance_area.' KM';

				$num++;
			}

			// print_r($data);exit;
			echo json_encode($data);
		}
		else $this->show_404();
	}

	public function store_data_customer()
	{
		$post = $this->input->post(NULL, TRUE);
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_customer')
		{
			unset($post['action']);
			
			$store_data_customer = $this->db_customer->store_data_customer($post);
			
			echo json_encode(array('success' => $store_data_customer));
			
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);
		
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data')
		{
			unset($post['action']);
			$delete_data = $this->db_customer->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}
}