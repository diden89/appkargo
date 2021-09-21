<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/controllers/Daftar_sales_order_transfer.php
 */

class Daftar_sales_order_transfer extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/daftar_sales_order_transfer_model', 'db_daftar_sales_order_transfer');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Daftar Sales Order Transfer';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/daftar_sales_order_transfer', 'Daftar Sales Order Transfer')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/transaksi/daftar_sales_order_transfer.js').'"></script>',
		);

		$this->store_params['item'] = [];
		
		$date = date('Y-m-d');
	
		$params['date_range1'] = date('Y-m-01');
		$params['date_range2'] = date('Y-m-t',strtotime($date));
		$load_data_daftar_sales_order_transfer = $this->db_daftar_sales_order_transfer->load_data_daftar_sales_order_transfer($params);

		if ($load_data_daftar_sales_order_transfer->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_daftar_sales_order_transfer->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$get_progress_sot = $this->db_daftar_sales_order_transfer->get_progress_sot(array('sot_id' => $v->sot_id,'dotd_is_status' => 'SELESAI'));

				$get_total_sot = $this->db_daftar_sales_order_transfer->get_progress_sot(array('sot_id' => $v->sot_id));

				$get_progress_do = $this->db_daftar_sales_order_transfer->get_progress_do(array('sot_id' => $v->sot_id));

				$get_progress_dots = $this->db_daftar_sales_order_transfer->get_progress_dots(array('sot_id' => $v->sot_id, 'sel'=> 'sum(dots.dots_filled) as total_progress_dots'));
				
				$get_amount_dots = $this->db_daftar_sales_order_transfer->get_progress_dots(array('sot_id' => $v->sot_id, 'sel'=> 'sum(dots.dots_ongkir) as total_amount_dots'));
				
				if($get_progress_do->num_rows() > 0) 
				{
					$prog = $get_progress_do->row();
					$v->tot_prog =  (! empty($prog->total_progress)) ? $prog->total_progress : 0;
				}

				if($get_progress_dots->num_rows() > 0) 
				{
					$prog_dots = $get_progress_dots->row();
					$v->tot_prog_dots =  (! empty($prog_dots->total_progress_dots)) ? $prog_dots->total_progress_dots : 0;
				}
				
				if($get_amount_dots->num_rows() > 0) 
				{
					$amount_dots = $get_amount_dots->row();
					$v->sot_total_amount =  (! empty($amount_dots->total_amount_dots)) ? $amount_dots->total_amount_dots : 0;
				}

				if($get_progress_sot->num_rows() > 0) {
					$progress = $get_progress_sot->row();
					$v->progress =  $progress->progress;
				}
				else
				{
					$v->progress = 0;
				}

				if($get_total_sot->num_rows() > 0) {
					$total = $get_total_sot->row();
					$v->total =  $total->progress;
				}
				else
				{
					$v->total = 0;
				}
				
				$v->num = $num;
				$v->total_progress = ($v->total !== '0') ? round(($v->progress * 100) / $v->total,2) : '0';	
				$v->sot_created_date = date('d-m-Y',strtotime($v->sot_created_date));
			}
			// print_r($result);exit;
			$this->store_params['item'] = $result;
		}

		$this->view('daftar_sales_order_transfer_view');
	}

	public function load_daftar_sales_order_transfer_form()
	{

		if (isset($_POST['action']) && $_POST['action'] == 'load_daftar_sales_order_transfer_form')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array(
				'table' => 'province'
			);

			$post['province'] = $this->db_daftar_sales_order_transfer->get_option_province()->result();
			$post['vendor'] = $this->db_daftar_sales_order_transfer->get_option_vendor()->result();
			$post['item_list'] = $this->db_daftar_sales_order_transfer->get_option_item_list()->result();
			$get_last_notrx = $this->db_daftar_sales_order_transfer->get_last_notrx();

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
				$post['data'] = $this->db_daftar_sales_order_transfer->load_data_daftar_sales_order_transfer($post)->row();
			}
	
			$this->_view('daftar_sales_order_transfer_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_item_list_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_item_list_option')
		{
			unset($post['action']);

			$get_item_list_option = $this->db_daftar_sales_order_transfer->get_item_list_option($post);

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

			$get_region_option = $this->db_daftar_sales_order_transfer->get_region_option($post);

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

			$get_district_option = $this->db_daftar_sales_order_transfer->get_district_option($post);

			if ($get_district_option->num_rows() > 0) 
			{
				$result = $get_district_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function load_data_daftar_sales_order_transfer()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_daftar_sales_order_transfer')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_daftar_sales_order_transfer = $this->db_daftar_sales_order_transfer->load_data_daftar_sales_order_transfer($post);
			// print_r($_POST);exit;
			if ($load_data_daftar_sales_order_transfer->num_rows() > 0) 
			{
				$result = $load_data_daftar_sales_order_transfer->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$number++;

					$get_progress_sot = $this->db_daftar_sales_order_transfer->get_progress_sot(array('sot_id' => $v->sot_id,'dotd_is_status' => 'SELESAI'));

					$get_total_sot = $this->db_daftar_sales_order_transfer->get_progress_sot(array('sot_id' => $v->sot_id));

					$get_progress_do = $this->db_daftar_sales_order_transfer->get_progress_do(array('sot_id' => $v->sot_id));
					
					if($get_progress_do->num_rows() > 0) 
					{
						$prog = $get_progress_do->row();
						$v->tot_prog =  (! empty($prog->total_progress)) ? $prog->total_progress : 0;
					}
					else
					{
						$v->tot_prog = 0;
					}

					if($get_progress_sot->num_rows() > 0) {
						$progress = $get_progress_sot->row();
						$v->progress =  $progress->progress;
					}
					else
					{
						$v->progress = 0;
					}

					if($get_total_sot->num_rows() > 0) {
						$total = $get_total_sot->row();
						$v->total =  $total->progress;
					}
					else
					{
						$v->total = 0;
					}
					
					$v->no = $number;
					$v->total_progress = ($v->total !== '0') ? round(($progress->progress * 100) / $total->progress,2) : '0';	
					$v->sot_created_date = date('d-m-Y',strtotime($v->sot_created_date));	
					$v->sot_total_amount = number_format($v->sot_total_amount);	
				}

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function load_data_temporary_detail_sot()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_temporary_detail_sot')
		{
			// print_r($_POST);exit;
			$post = $this->input->post(NULL, TRUE);
			$load_data_detail_sot = $this->db_daftar_sales_order_transfer->load_data_detail_sot($post);
			if ($load_data_detail_sot->num_rows() > 0) 
			{
				$result = $load_data_detail_sot->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->sotd_qty = number_format($v->sotd_qty);

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function store_data_daftar_sales_order_transfer()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_daftar_sales_order_transfer')
		{
			$post = $this->input->post(NULL, TRUE);
			$date = date('Y-m-d');
			$post['date_range1'] = date('Y-m-01');
			$post['date_range2'] = date('Y-m-t',strtotime($date));

			$store_data_daftar_sales_order_transfer = $this->db_daftar_sales_order_transfer->store_data_daftar_sales_order_transfer($post);

			if ($store_data_daftar_sales_order_transfer->num_rows() > 0) 
			{
				$result = $store_data_daftar_sales_order_transfer->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$number++;

					$get_progress_sot = $this->db_daftar_sales_order_transfer->get_progress_sot(array('sot_id' => $v->sot_id,'dotd_is_status' => 'SELESAI'));

					$get_total_sot = $this->db_daftar_sales_order_transfer->get_progress_sot(array('sot_id' => $v->sot_id));
					
					$get_progress_do = $this->db_daftar_sales_order_transfer->get_progress_do(array('sot_id' => $v->sot_id));

					$get_progress_dots = $this->db_daftar_sales_order_transfer->get_progress_dots(array('sot_id' => $v->sot_id, 'sel'=> 'sum(dots.dots_filled) as total_progress_dots'));
				
					if($get_progress_sot->num_rows() > 0) {
						$progress = $get_progress_sot->row();
						$v->progress =  $progress->progress;
					}
					else
					{
						$v->progress = 0;
					}

					if($get_total_sot->num_rows() > 0) {
						$total = $get_total_sot->row();
						$v->total =  $total->progress;
					}
					else
					{
						$v->total = 0;
					}

					if($get_progress_dots->num_rows() > 0) 
					{
						$prog_dots = $get_progress_dots->row();
						$v->tot_prog_dots =  (! empty($prog_dots->total_progress_dots)) ? $prog_dots->total_progress_dots : 0;
					}

					if($get_progress_do->num_rows() > 0) {
						$prog = $get_progress_do->row();
						$v->tot_prog =  (! empty($prog->total_progress)) ? $prog->total_progress : 0;
					}
					
					$v->no = $number;
					$v->total_progress = ($v->total !== '0') ? round(($progress->progress * 100) / $total->progress,2) : '0';	
					$v->sot_created_date = date('d-m-Y',strtotime($v->sot_created_date));	
					$v->sot_total_amount = number_format($v->sot_total_amount);	
					// $v->sot_total_terpenuhi = number_format($v->sot_total_amount);	
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
			$post['sotd_qty'] = str_replace(',','',$post['sotd_qty']);
			$store_detail_sot = $this->db_daftar_sales_order_transfer->store_detail_sot($post);

			if ($store_detail_sot->num_rows() > 0) 
			{
				$result = $store_detail_sot->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->sotd_qty = number_format($v->sotd_qty);

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
			$delete_data_item = $this->db_daftar_sales_order_transfer->delete_data_item($post);

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
			$delete_data_sotd = $this->db_daftar_sales_order_transfer->delete_data_sot_detail($post);

			if ($delete_data_sotd->num_rows() > 0) 
			{
				$result = $delete_data_sotd->result();
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

		$get_data = $this->db_daftar_sales_order_transfer->load_data_rekap_tagihan();

		$data_company = $this->db_main->get_company();

		if ($get_data->num_rows() > 0)
		{
			$num = 0;
			$result = $get_data->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$get_progress_sot = $this->db_daftar_sales_order_transfer->get_progress_sot(array('sot_id' => $v->sot_id,'dotd_is_status' => 'SELESAI'));

				$get_total_sot = $this->db_daftar_sales_order_transfer->get_progress_sot(array('sot_id' => $v->sot_id));

				$get_progress_do = $this->db_daftar_sales_order_transfer->get_progress_do(array('sot_id' => $v->sot_id));

				$get_progress_dots = $this->db_daftar_sales_order_transfer->get_progress_dots(array('sot_id' => $v->sot_id, 'sel'=> 'sum(dots.dots_filled) as total_progress_dots'));
				
				$get_amount_dots = $this->db_daftar_sales_order_transfer->get_progress_dots(array('sot_id' => $v->sot_id, 'sel'=> 'sum(dots.dots_ongkir) as total_amount_dots'));
				
				if($get_progress_do->num_rows() > 0) 
				{
					$prog = $get_progress_do->row();
					$v->tot_prog =  (! empty($prog->total_progress)) ? $prog->total_progress : 0;
				}

				if($get_progress_dots->num_rows() > 0) 
				{
					$prog_dots = $get_progress_dots->row();
					$v->tot_prog_dots =  (! empty($prog_dots->total_progress_dots)) ? $prog_dots->total_progress_dots : 0;
				}
				
				if($get_amount_dots->num_rows() > 0) 
				{
					$amount_dots = $get_amount_dots->row();
					$v->sot_total_amount =  (! empty($amount_dots->total_amount_dots)) ? $amount_dots->total_amount_dots : 0;
				}

				if($get_progress_sot->num_rows() > 0) {
					$progress = $get_progress_sot->row();
					$v->progress =  $progress->progress;
				}
				else
				{
					$v->progress = 0;
				}

				if($get_total_sot->num_rows() > 0) {
					$total = $get_total_sot->row();
					$v->total =  $total->progress;
				}
				else
				{
					$v->total = 0;
				}
				
				$v->num = $num;
				$v->total_progress = ($v->total !== '0') ? round(($v->progress * 100) / $v->total,2) : '0';	
				$v->sot_created_date = date('d-m-Y',strtotime($v->sot_created_date));
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