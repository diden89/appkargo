<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/controllers/Daftar_pembayaran_sales_order.php
 */

class Daftar_pembayaran_sales_order extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/daftar_pembayaran_sales_order_model', 'db_daftar_pso');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Daftar Pembayaran Sales Order';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/daftar_pembayaran_sales_order', 'Daftar Pembayaran Sales Order')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/transaksi/daftar_pembayaran_sales_order.js').'"></script>',
		);

		$this->store_params['item'] = [];
		$date = date('d-m-Y H:i:s');
		$date = strtotime($date);
		$date = strtotime("-7 day", $date);
		// echo date('d-m-Y H:i:s', $date);

		$params['date_range1'] = date('Y-m-d H:i:s', $date);
		$params['date_range2'] = date('Y-m-d H:i:s');
		$load_data_daftar_pembayaran_sales_order = $this->db_daftar_pso->load_data_daftar_pembayaran_sales_order($params);

		if ($load_data_daftar_pembayaran_sales_order->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_daftar_pembayaran_sales_order->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$get_progress_so = $this->db_daftar_pso->get_progress_so(array('so_id' => $v->so_id,'dod_is_status' => 'SELESAI'));

				$get_total_so = $this->db_daftar_pso->get_progress_so(array('so_id' => $v->so_id));

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

		$this->view('daftar_pembayaran_sales_order_view');
	}

	public function load_daftar_pembayaran_sales_order_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_daftar_pembayaran_sales_order_form')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array(
				'table' => 'province'
			);

			// $post['vendor'] = $this->db_daftar_pso->get_option_province()->result();
			// $post['province'] = $this->db_daftar_pso->get_option_province()->result();
			// $post['vendor'] = $this->db_daftar_pso->get_option_vendor()->result();
			// $post['item_list'] = $this->db_daftar_pso->get_option_item_list()->result();
			$get_last_notrx = $this->db_daftar_pso->get_last_notrx();

			if($get_last_notrx->num_rows() > 0)
			{
				$notrx = $get_last_notrx->row();
				$last_notrx = $notrx->notrx + 1;
			}
			else
			{
				$last_notrx = 1;
			}

			$notrx = sprintf('%04d',$last_notrx).'/SOPAY/'.date('Ymd');
			$post['last_notrx'] = $notrx;
			

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_daftar_pso->load_data_daftar_pembayaran_sales_order($post)->row();
			}
	
			$this->_view('daftar_pembayaran_sales_order_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_vendor_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_vendor_option')
		{
			unset($post['action']);

			$get_vendor_option = $this->db_daftar_pso->get_vendor_option();

			if ($get_vendor_option->num_rows() > 0) 
			{
				$result = $get_vendor_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_kas_bank_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_kas_bank_option')
		{
			unset($post['action']);

			$get_kas_bank_option = $this->db_daftar_pso->get_kas_bank_option();

			if ($get_kas_bank_option->num_rows() > 0) 
			{
				$result = $get_kas_bank_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_sales_order_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_sales_order_data')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$get_sales_order_data = $this->db_daftar_pso->get_sales_order_data($post);
			if ($get_sales_order_data->num_rows() > 0) 
			{
				$result = $get_sales_order_data->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$number++;
					$v->no = $number;
					$v->so_qty = number_format($v->so_qty);
					$sum[] = $v->so_total_amount;
					$v->so_total_amount = 'Rp. '.number_format($v->so_total_amount);
					$v->so_created_date = date('d-m-Y', strtotime($v->so_created_date));
				}
				$array_sum = array_sum($sum);
				// print_r($array_sum);exit;
				echo json_encode(array('success' => TRUE, 'data' => $result,'total_amount' => 'Rp. '.number_format($array_sum),'amount' => $array_sum));
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
			$load_data_detail_so = $this->db_daftar_pso->load_data_detail_so($post);
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

	public function store_data_daftar_pembayaran_sales_order()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_daftar_pembayaran_sales_order')
		{
			$post = $this->input->post(NULL, TRUE);
		print_r($post);exit;
			$store_data_daftar_pembayaran_sales_order = $this->db_daftar_pso->store_data_daftar_pembayaran_sales_order($post);

			if ($store_data_daftar_pembayaran_sales_order->num_rows() > 0) 
			{
				$result = $store_data_daftar_pembayaran_sales_order->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$number++;

					$get_progress_so = $this->db_daftar_pso->get_progress_so(array('so_id' => $v->so_id,'dod_is_status' => 'SELESAI'));

					$get_total_so = $this->db_daftar_pso->get_progress_so(array('so_id' => $v->so_id));

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

	public function delete_data_item()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_item = $this->db_daftar_pso->delete_data_item($post);

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
			$delete_data_sod = $this->db_daftar_pso->delete_data_so_detail($post);

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