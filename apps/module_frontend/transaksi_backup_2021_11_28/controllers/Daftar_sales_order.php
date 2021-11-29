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
		
		$date = date('Y-m-d');
	
		$params['date_range1'] = date('Y-m-01');
		$params['date_range2'] = date('Y-m-t',strtotime($date));
		$load_data_daftar_sales_order = $this->db_daftar_sales_order->load_data_daftar_sales_order($params);

		if ($load_data_daftar_sales_order->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_daftar_sales_order->result();

			foreach ($result as $k => $v)
			{
				$num++;


				if($v->so_tipe == 'so')
				{
					$get_progress_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id,'dod_is_status' => 'SELESAI'));

					$get_total_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id));

					$get_progress_do = $this->db_daftar_sales_order->get_progress_do(array('so_id' => $v->so_id));

					$get_progress_dos = $this->db_daftar_sales_order->get_progress_dos(array('so_id' => $v->so_id, 'sel'=> 'sum(dos.dos_filled) as total_progress_dos'));
					
					$get_amount_dos = $this->db_daftar_sales_order->get_progress_dos(array('so_id' => $v->so_id, 'sel'=> 'sum(dos.dos_ongkir) as total_amount_dos'));					
				}
				else
				{
					$get_progress_so = $this->db_daftar_sales_order->get_progress_so_transfer(array('so_id' => $v->so_id,'dotd_is_status' => 'SELESAI'));

					$get_total_so = $this->db_daftar_sales_order->get_progress_so_transfer(array('so_id' => $v->so_id));

					$get_progress_do = $this->db_daftar_sales_order->get_progress_do_transfer(array('so_id' => $v->so_id));

					$get_progress_dos = $this->db_daftar_sales_order->get_progress_dos_transfer(array('so_id' => $v->so_id, 'sel'=> 'sum(dots.dots_filled) as total_progress_dos'));
					
					$get_amount_dos = $this->db_daftar_sales_order->get_progress_dos_transfer(array('so_id' => $v->so_id, 'sel'=> 'sum(dots.dots_ongkir) as total_amount_dos'));
				}
				
				if($get_progress_do->num_rows() > 0) 
				{
					$prog = $get_progress_do->row();
					$v->tot_prog =  (! empty($prog->total_progress)) ? $prog->total_progress : 0;
				}

				if($get_progress_dos->num_rows() > 0) 
				{
					$prog_dos = $get_progress_dos->row();
					$v->tot_prog_dos =  (! empty($prog_dos->total_progress_dos)) ? $prog_dos->total_progress_dos : 0;
				}
				
				if($get_amount_dos->num_rows() > 0) 
				{
					$amount_dos = $get_amount_dos->row();
					$v->so_total_amount =  (! empty($amount_dos->total_amount_dos)) ? $amount_dos->total_amount_dos : 0;
				}

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
				$v->so_tipe_view = ($v->so_tipe == 'tf') ? 'TRANSFER' : 'NEW ORDER';
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
			$num = 0;
			$result = $load_data_daftar_sales_order->result();

			foreach ($result as $k => $v)
			{
				$num++;


				if($v->so_tipe == 'so')
				{
					$get_progress_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id,'dod_is_status' => 'SELESAI'));

					$get_total_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id));

					$get_progress_do = $this->db_daftar_sales_order->get_progress_do(array('so_id' => $v->so_id));

					$get_progress_dos = $this->db_daftar_sales_order->get_progress_dos(array('so_id' => $v->so_id, 'sel'=> 'sum(dos.dos_filled) as total_progress_dos'));
					
					$get_amount_dos = $this->db_daftar_sales_order->get_progress_dos(array('so_id' => $v->so_id, 'sel'=> 'sum(dos.dos_ongkir) as total_amount_dos'));					
				}
				else
				{
					$get_progress_so = $this->db_daftar_sales_order->get_progress_so_transfer(array('so_id' => $v->so_id,'dotd_is_status' => 'SELESAI'));

					$get_total_so = $this->db_daftar_sales_order->get_progress_so_transfer(array('so_id' => $v->so_id));

					$get_progress_do = $this->db_daftar_sales_order->get_progress_do_transfer(array('so_id' => $v->so_id));

					$get_progress_dos = $this->db_daftar_sales_order->get_progress_dos_transfer(array('so_id' => $v->so_id, 'sel'=> 'sum(dots.dots_filled) as total_progress_dos'));
					
					$get_amount_dos = $this->db_daftar_sales_order->get_progress_dos_transfer(array('so_id' => $v->so_id, 'sel'=> 'sum(dots.dots_ongkir) as total_amount_dos'));
				}
				
				if($get_progress_do->num_rows() > 0) 
				{
					$prog = $get_progress_do->row();
					$v->tot_prog =  (! empty($prog->total_progress)) ? $prog->total_progress : 0;
				}

				if($get_progress_dos->num_rows() > 0) 
				{
					$prog_dos = $get_progress_dos->row();
					$v->tot_prog_dos =  (! empty($prog_dos->total_progress_dos)) ? $prog_dos->total_progress_dos : 0;
				}
				
				if($get_amount_dos->num_rows() > 0) 
				{
					$amount_dos = $get_amount_dos->row();
					$v->so_total_amount =  (! empty($amount_dos->total_amount_dos)) ? $amount_dos->total_amount_dos : 0;
				}

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
				$v->so_tipe_view = ($v->so_tipe == 'tf') ? 'TRANSFER' : 'NEW ORDER';
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
					$v->sod_qty = number_format($v->sod_qty);

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
			$date = date('Y-m-d');
			$post['date_range1'] = date('Y-m-01');
			$post['date_range2'] = date('Y-m-t',strtotime($date));

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
					
					$get_progress_do = $this->db_daftar_sales_order->get_progress_do(array('so_id' => $v->so_id));

					$get_progress_dos = $this->db_daftar_sales_order->get_progress_dos(array('so_id' => $v->so_id, 'sel'=> 'sum(dos.dos_filled) as total_progress_dos'));
				
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

					if($get_progress_dos->num_rows() > 0) 
					{
						$prog_dos = $get_progress_dos->row();
						$v->tot_prog_dos =  (! empty($prog_dos->total_progress_dos)) ? $prog_dos->total_progress_dos : 0;
					}

					if($get_progress_do->num_rows() > 0) {
						$prog = $get_progress_do->row();
						$v->tot_prog =  (! empty($prog->total_progress)) ? $prog->total_progress : 0;
					}
					
					$v->no = $number;
					$v->total_progress = ($v->total !== '0') ? round(($progress->progress * 100) / $total->progress,2) : '0';	
					$v->so_created_date = date('d-m-Y',strtotime($v->so_created_date));	
					$v->so_total_amount = number_format($v->so_total_amount);	
					$v->so_tipe_view = ($v->so_tipe == 'tf') ? 'TRANSFER' : 'NEW ORDER';
					// $v->so_total_terpenuhi = number_format($v->so_total_amount);	
				}

				// print_r($result);exit;
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
			$post['sod_qty'] = str_replace(',','',$post['sod_qty']);
			$store_detail_so = $this->db_daftar_sales_order->store_detail_so($post);

			if ($store_detail_so->num_rows() > 0) 
			{
				$result = $store_detail_so->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->sod_qty = number_format($v->sod_qty);

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

	public function rekap_tagihan()
	{
		$data = array();

		$get_data = $this->db_daftar_sales_order->load_data_rekap_tagihan();

		$data_company = $this->db_main->get_company();

		if ($get_data->num_rows() > 0)
		{
			$num = 0;
			$result = $get_data->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$get_progress_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id,'dod_is_status' => 'SELESAI'));

				$get_total_so = $this->db_daftar_sales_order->get_progress_so(array('so_id' => $v->so_id));

				$get_progress_do = $this->db_daftar_sales_order->get_progress_do(array('so_id' => $v->so_id));

				$get_progress_dos = $this->db_daftar_sales_order->get_progress_dos(array('so_id' => $v->so_id, 'sel'=> 'sum(dos.dos_filled) as total_progress_dos'));
				
				$get_amount_dos = $this->db_daftar_sales_order->get_progress_dos(array('so_id' => $v->so_id, 'sel'=> 'sum(dos.dos_ongkir) as total_amount_dos'));
				
				if($get_progress_do->num_rows() > 0) 
				{
					$prog = $get_progress_do->row();
					$v->tot_prog =  (! empty($prog->total_progress)) ? $prog->total_progress : 0;
				}

				if($get_progress_dos->num_rows() > 0) 
				{
					$prog_dos = $get_progress_dos->row();
					$v->tot_prog_dos =  (! empty($prog_dos->total_progress_dos)) ? $prog_dos->total_progress_dos : 0;
				}
				
				if($get_amount_dos->num_rows() > 0) 
				{
					$amount_dos = $get_amount_dos->row();
					$v->so_total_amount =  (! empty($amount_dos->total_amount_dos)) ? $amount_dos->total_amount_dos : 0;
				}

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
			$data['item'] = $result;
		}
		
		$data['header_title'] = 'Rekap Tagihan Pembayaran';

		if($data_company->num_rows() > 0)
		{
			$data_company = $data_company->row();
			$data['company_title'] = $data_company->rc_name;
			$data['address'] = $data_company->rc_address;
			$data['phone'] = $data_company->rc_phone;
			$data['logo'] = $data_company->rc_logo;

		}
		$data['date_range_1'] = (isset($params['date_range_1'])) ? $params['date_range_1'] : '';
		$data['date_range_2'] = (isset($params['date_range_2'])) ? $params['date_range_2'] : '';
		
		$view = $this->load->view('report/report_cash_in_rekap_pdf', $data, TRUE);

				$this->load->library('pdf_creator');

				$pdf_creator = $this->pdf_creator->load([
				    'mode' => 'utf-8',
				    'format' => 'A4',
				    'margin_top' => 5,
				    'margin_bottom' => 25,
					'margin_header' => 40,
					'margin_footer' => 15
				]);

				$pdf_creator->setHtmlFooter($this->session->userdata('username').'|Created Date : '.date('d-m-Y'));
				$pdf_creator->WriteHTML($view);

				$pdf_creator->Output('Report Cash In_'.date('YmdHis').'_rekap.pdf', 'I');
	}
}