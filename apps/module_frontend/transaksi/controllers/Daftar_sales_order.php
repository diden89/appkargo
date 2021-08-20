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
		$date = date('d-m-Y H:i:s');
		$date = strtotime($date);
		$date = strtotime("-7 day", $date);
		// echo date('d-m-Y H:i:s', $date);

		$params['date_range1'] = date('Y-m-d H:i:s', $date);
		$params['date_range2'] = date('Y-m-d H:i:s');
		$load_data_daftar_sales_order = $this->db_daftar_sales_order->load_data_daftar_sales_order($params);

		if ($load_data_daftar_sales_order->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_daftar_sales_order->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$get_progress_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id,'dod_is_status' => 'SELESAI'));

				$get_total_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id));

				if($get_progress_so->num_rows() > 0) {
					$progress = $get_progress_so->row();
					$v->progress =  $progress->progress;
				}
				else
				{
					$v->progress = 0;
				}

				if($get_total_so->num_rows() > 0) {
					$total = $get_total_so->row();
					$v->total =  $total->progress;
				}
				else
				{
					$v->total = 0;
				}
				
				$v->num = $num;
				$v->total_progress = ($v->total !== '0') ? round(($v->progress * 100) / $v->total,2) : '0';	
				$v->so_created_date = date('d-m-Y',strtotime($v->so_created_date));
			}
			// print_r($result);exit;
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
			$post['vendor'] = $this->db_daftar_sales_order->get_option_vendor()->result();
			$post['item_list'] = $this->db_daftar_sales_order->get_option_item_list()->result();
			$get_last_notrx = $this->db_daftar_sales_order->get_last_notrx();

			if($get_last_notrx->num_rows() > 0)
			{
				$notrx = $get_last_notrx->row();
				$last_notrx = $notrx->notrx + 1;
			}
			else
			{
				$last_notrx = 1;
			}

			$post['last_notrx'] = sprintf('%04d',$last_notrx);
			

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_daftar_sales_order->load_data_daftar_sales_order($post)->row();
			}
	
			$this->_view('daftar_sales_order_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_item_list_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_item_list_option')
		{
			unset($post['action']);

			$get_item_list_option = $this->db_daftar_sales_order->get_item_list_option($post);

			if ($get_item_list_option->num_rows() > 0) 
			{
				$result = $get_item_list_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
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
					$number++;

					$get_progress_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id,'dod_is_status' => 'SELESAI'));

					$get_total_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id));

					if($get_progress_so->num_rows() > 0) {
						$progress = $get_progress_so->row();
						$v->progress =  $progress->progress;
					}
					else
					{
						$v->progress = 0;
					}

					if($get_total_so->num_rows() > 0) {
						$total = $get_total_so->row();
						$v->total =  $total->progress;
					}
					else
					{
						$v->total = 0;
					}
					
					$v->no = $number;
					$v->total_progress = ($v->total !== '0') ? round(($progress->progress * 100) / $total->progress,2) : '0';	
					$v->so_created_date = date('d-m-Y',strtotime($v->so_created_date));	
					$v->so_total_amount = number_format($v->so_total_amount);	
				}

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function load_data_temporary_detail_so()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_temporary_detail_so')
		{
			// print_r($_POST);exit;
			$post = $this->input->post(NULL, TRUE);
			$load_data_detail_so = $this->db_daftar_sales_order->load_data_detail_so($post);
			if ($load_data_detail_so->num_rows() > 0) 
			{
				$result = $load_data_detail_so->result();
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
		// print_r($_POST);exit;
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
					$number++;

					$get_progress_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id,'dod_is_status' => 'SELESAI'));

					$get_total_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id));

					if($get_progress_so->num_rows() > 0) {
						$progress = $get_progress_so->row();
						$v->progress =  $progress->progress;
					}
					else
					{
						$v->progress = 0;
					}

					if($get_total_so->num_rows() > 0) {
						$total = $get_total_so->row();
						$v->total =  $total->progress;
					}
					else
					{
						$v->total = 0;
					}
					
					$v->no = $number;
					$v->total_progress = ($v->total !== '0') ? round(($progress->progress * 100) / $total->progress,2) : '0';	
					$v->so_created_date = date('d-m-Y',strtotime($v->so_created_date));	
					$v->so_total_amount = number_format($v->so_total_amount);	
				}


				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function store_data_temporary()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'insert_temporary_data')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$store_detail_so = $this->db_daftar_sales_order->store_detail_so($post);

			if ($store_detail_so->num_rows() > 0) 
			{
				$result = $store_detail_so->result();
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
	
	// public function store_data_temporary()
	// {
	// 	if (isset($_POST['action']) && $_POST['action'] == 'insert_temporary_data')
	// 	{
	// 		$post = $this->input->post(NULL, TRUE);

	// 		$get_data_item = $this->db_daftar_sales_order->get_option_item_list($post)->row();
			
	// 		$idx = (! empty($this->session->userdata('temp_data'))) ? (count($this->session->userdata('temp_data')) - 1) +1 : 0;
			
	// 		if($idx == 0)
	// 		{
	// 			$temp[$idx] = (object) array(
	// 				'qty' => $post['qty'],
	// 				'il_item_name' => $get_data_item->il_item_name
	// 			);				
			
	// 			$this->session->set_userdata(array(
	// 				'temp_data' => $temp
	// 			));
	// 		}
	// 		else
	// 		{				
	// 			$temp = (object) array(
	// 				'qty' => $post['qty'],
	// 				'il_item_name' => $get_data_item->il_item_name
	// 			);

	// 			array_push($_SESSION['temp_data'],$temp);
				
	// 		} 

			
	// 		// print_r($this->session);exit;
	// 		if (count($this->session->userdata('temp_data')) > 0) 
	// 		{
	// 			$idx = 0;
	// 			$temporary = $this->session->userdata('temp_data');
	// 			foreach ($temporary as $k => $v)
	// 			{
	// 				$v->idx = $idx;

	// 				$idx++;
	// 			}
				
	// 			echo json_encode(array('success' => TRUE, 'data' => $temporary));
	// 		}
	// 		else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
	// 	}
	// 	else $this->show_404();
	// }

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

	public function delete_data_temp()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_temp')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_sod = $this->db_daftar_sales_order->delete_data_so_detail($post);

			if ($delete_data_sod->num_rows() > 0) 
			{
				$result = $delete_data_sod->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!','data' => array()));
		}
		else $this->show_404();
	}
}