<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/controllers/Delivery_order_cost.php
 */

class Delivery_order_cost extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/delivery_order_cost_model', 'db_doc');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Biaya Operasional DO';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/delivery_order_cost', 'Biaya Operasional DO')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/transaksi/delivery_order_cost.js').'"></script>',
		);
		
		$this->view('delivery_order_cost_view');
	}

	public function load_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data')
		{
			$post = $this->input->post(NULL, TRUE);
			$data = $this->db_doc->load_data($post);
		
			$num = 1;

			foreach ($data->data as $k => $v)
			{
				$v->num = $num;
				$v->total_amount = 'Rp. '.number_format($v->total);
				// $v->c_shipping_area = number_format($v->c_shipping_area);
				// $v->c_distance_area_full = $v->c_distance_area.' KM';

				$num++;
			}

			// print_r($data);exit;
			echo json_encode($data);
		}
		else $this->show_404();
	}

	public function load_data_temporary()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_temporary')
		{
			$post = $this->input->post(NULL, TRUE);
			if(! empty($post['so_no_trx']))
			{
				$load_data_temporary = $this->db_doc->load_data_temporary($post);
				// print_r($load_data_temporary);exit;
				if ($load_data_temporary->num_rows() > 0) 
				{
					$result = $load_data_temporary->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->no = $number;
						$v->docd_amount = number_format($v->docd_amount);

						$number++;
					}
					
				// print_r($post);exit;
					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));			
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);
		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_doc->get_autocomplete_data($post);

		// print_r($get_autocomplete_data);exit;
			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}


	public function load_delivery_order_cost_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_delivery_order_cost_form')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array(
				'table' => 'province'
			);
			// print_r($post);exit;
			$post['province'] = $this->db_doc->get_option_province()->result();
			$post['sales_order'] = $this->db_doc->get_option_no_trx()->result();
			$post['kas_bank'] = $this->db_doc->get_kas_bank()->result();
			$post['akun_header'] = $this->db_doc->get_akun_header()->result();
			// $post['vendor'] = $this->db_doc->get_option_customer()->result();
			// if($post['mode'] == 'edit')
			// {
			// 	$post['data'] = $this->db_doc->load_data($post)->row();
			// }
		// print_r($post['sales_order']);exit;
			$this->_view('delivery_order_cost_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_region_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_region_option')
		{
			unset($post['action']);

			$get_region_option = $this->db_doc->get_region_option($post);

			if ($get_region_option->num_rows() > 0) 
			{
				$result = $get_region_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_vehicle_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_vehicle_option')
		{
			unset($post['action']);

			$get_vehicle_option = $this->db_doc->get_vehicle_option($post);

			if ($get_vehicle_option->num_rows() > 0) 
			{
				$result = $get_vehicle_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_akun_header_option()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_akun_header_option')
		{
			unset($post['action']);

			$get_akun_header_option = $this->db_doc->get_akun_header();

			if ($get_akun_header_option->num_rows() > 0) 
			{
				$result = $get_akun_header_option->result();
				foreach($result as $k => $v) 
				{
					$v->rah_name = get_content($v->rah_name);
				}
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_akun_detail_option()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_akun_detail_option')
		{
			unset($post['action']);

			$get_akun_detail_option = $this->db_doc->get_akun_detail_option($post);

			if ($get_akun_detail_option->num_rows() > 0) 
			{
				$result = $get_akun_detail_option->result();
				foreach($result as $k => $v) 
				{
					$v->rad_name = strtoupper(get_content($v->rad_name));
				}
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function store_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'insert_data')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$cek = $this->db_doc->cek_order_cost($post);
			
			if($cek->num_rows() > 0)
			{
				echo json_encode(array('success' => TRUE));
			}
			else
			{
				$store_data = $this->db_doc->store_data($post);
				echo json_encode(array('success' => TRUE));
			}
			
		}
		else $this->show_404();
	}

	public function store_data_temporary()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'insert_temporary_data')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			
			$store_temporary_data = $this->db_doc->store_temporary_data($post);
			// print_r($store_temporary_data);exit;

			if ($store_temporary_data->num_rows() > 0) 
			{
				$result = $store_temporary_data->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->docd_amount = number_format($v->docd_amount);

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function total_amount_detail()
	{
		$post = $this->input->post(NULL, TRUE);
		// print_r($post);exit;
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'total_amount_detail')
		{
			unset($post['action']);

			$total_amount_detail = $this->db_doc->total_amount_detail($post);

			if ($total_amount_detail->num_rows() > 0) 
			{
				$result = $total_amount_detail->row();

				echo json_encode(array('success' => TRUE, 'total_amount' => number_format($result->total_amount)));
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

			$get_district_option = $this->db_doc->get_district_option($post);

			if ($get_district_option->num_rows() > 0) 
			{
				$result = $get_district_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	

	public function store_data_customer()
	{
		$post = $this->input->post(NULL, TRUE);
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_customer')
		{
			unset($post['action']);
			
			$store_data_customer = $this->db_doc->store_data_customer($post);
			
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
			$delete_data = $this->db_doc->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}
}