<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/controllers/Daftar_sales_order.php
 */

class Daftar_sales_order extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/daftar_sales_order_model', 'db_daftar_sales_order');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Daftar Sales Order';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/daftar_sales_order', 'Daftar Sales Order')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/transaksi/daftar_sales_order.js').'"></script>',
		);

		$this->store_params['item'] = [];

		$load_data_daftar_sales_order = $this->db_daftar_sales_order->load_data_daftar_sales_order();

		if ($load_data_daftar_sales_order->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_daftar_sales_order->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
			}

			$this->store_params['item'] = $result;
		}

		$this->view('daftar_sales_order_view');
	}

	public function load_daftar_sales_order_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_daftar_sales_order_form')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array(
				'table' => 'province'
			);

			$post['province'] = $this->db_daftar_sales_order->get_option_province()->result();
			$post['vendor'] = $this->db_daftar_sales_order->get_option_daftar_sales_order()->result();
			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_daftar_sales_order->load_data_daftar_sales_order($post)->row();
			}
	
			$this->_view('daftar_sales_order_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_region_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_region_option')
		{
			unset($post['action']);

			$get_region_option = $this->db_daftar_sales_order->get_region_option($post);

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

			$get_district_option = $this->db_daftar_sales_order->get_district_option($post);

			if ($get_district_option->num_rows() > 0) 
			{
				$result = $get_district_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function load_data_daftar_sales_order()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_daftar_sales_order')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_daftar_sales_order = $this->db_daftar_sales_order->load_data_daftar_sales_order($post);
			// print_r($_POST);exit;
			if ($load_data_daftar_sales_order->num_rows() > 0) 
			{
				$result = $load_data_daftar_sales_order->result();
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

	public function store_data_daftar_sales_order()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_daftar_sales_order')
		{
			$post = $this->input->post(NULL, TRUE);
			$store_data_daftar_sales_order = $this->db_daftar_sales_order->store_data_daftar_sales_order($post);

			if ($store_data_daftar_sales_order->num_rows() > 0) 
			{
				$result = $store_data_daftar_sales_order->result();
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
			$delete_data_item = $this->db_daftar_sales_order->delete_data_item($post);

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