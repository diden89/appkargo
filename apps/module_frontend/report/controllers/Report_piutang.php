<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/report/controllers/Report_piutang.php
 */

class Report_piutang extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('report/report_piutang_model', 'db_rp');
		$this->load->model('transaksi/daftar_sales_order_model', 'db_daftar_sales_order');

	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Laporan Piutang';
		$this->store_params['pages_title'] = 'Laporan Piutang List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('report/report_piutang', 'Laporan Kas Masuk')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/report/report_piutang.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('report_piutang_view');
	}

	
	public function print_pdf()
	{
		$post = $this->input->post();
		// print_r($post);exit;
		if($post['type'] == 'rekap')
		{
			$this->rekap_laporan_piutang($post);
		}
		else
		{
			$this->detail_laporan_kas_masuk($post);
		}

	}
	public function rekap_laporan_piutang($params)
	{
		$data = array();

		$get_data = $this->db_rp->load_data_rekap_tagihan($params);
		$data_company = $this->db_main->get_company();

		$load_data_daftar_sales_order = $this->db_daftar_sales_order->load_data_daftar_sales_order($params);

		if ($load_data_daftar_sales_order->num_rows() > 0)
		{
			$num = 0;
			$i=0;
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
			$data['item'] = $result;
		}

		// print_r($data);exit;
		$data['header_title'] = 'Rekap Piutang';

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
		
		$view = $this->load->view('report/report_piutang_rekap_pdf', $data, TRUE);

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

		$pdf_creator->Output('Report Piutang_'.date('YmdHis').'_rekap.pdf', 'I');
	}

	public function detail_laporan_kas_masuk($params)
	{
		$data = array();

		// $get_data = $this->db_rp->load_data_kas_masuk($params);

		$data_company = $this->db_main->get_company();

		$load_data_daftar_sales_order = $this->db_daftar_sales_order->load_data_daftar_sales_order($params);


		if ($load_data_daftar_sales_order->num_rows() > 0)
		{
			$num = 0;
			$i=0;
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

					$get_detail_do = $this->db_rp->load_data_rekap_tagihan_new($params);
					if($get_detail_do->num_rows() > 0)
					{
						$num = 0;
						$res_detail = $get_detail_do->result();
						foreach ($res_detail as $key => $value) {
							$num++;
							$value->num = $num;

							$value->d_name_pengemudi = $value->d_name.' / '.$value->ve_license_plate;
							$value->d_address_area = $value->c_address.'<br>Kec. '.$value->rsd_name;
							$value->dod_shipping_qty = number_format($value->dod_shipping_qty);
							$value->dos_filled_show = number_format($value->dos_filled);
							$value->dod_created_date = date('d-m-Y',strtotime($value->dod_created_date));
							$value->dos_created_date = date('d-m-Y H:i:s',strtotime($value->dos_created_date));
							$value->so_tipe_show = ($value->so_tipe == 'so') ? 'NEW ORDER' : 'TRANSFER';

							if(! empty($value->dos_filled)) 
							{
								$value->new_ongkir = number_format($value->dos_ongkir);
								$value->dod_is_status = $value->dos_status;
							}
							else
							{
								$value->new_ongkir = 0;
								$value->dod_is_status = $value->dod_is_status;
							}
							// $value->cid_total_val = number_format($value->cid_total);
						}

						$data['item'][$i]['detail'] = $res_detail;
					}				
				}
				else
				{
					$get_progress_so = $this->db_daftar_sales_order->get_progress_so_transfer(array('so_id' => $v->so_id,'dotd_is_status' => 'SELESAI'));

					$get_total_so = $this->db_daftar_sales_order->get_progress_so_transfer(array('so_id' => $v->so_id));

					$get_progress_do = $this->db_daftar_sales_order->get_progress_do_transfer(array('so_id' => $v->so_id));

					$get_progress_dos = $this->db_daftar_sales_order->get_progress_dos_transfer(array('so_id' => $v->so_id, 'sel'=> 'sum(dots.dots_filled) as total_progress_dos'));
					
					$get_amount_dos = $this->db_daftar_sales_order->get_progress_dos_transfer(array('so_id' => $v->so_id, 'sel'=> 'sum(dots.dots_ongkir) as total_amount_dos'));

					$get_detail_do_trf = $this->db_rp->load_data_rekap_tagihan_trf($params);
					if($get_detail_do_trf->num_rows() > 0)
					{
						$num = 0;
						$res_detail_trf = $get_detail_do_trf->result();
						foreach ($res_detail_trf as $key => $value) {
							$num++;
							$value->num = $num;
							$value->d_name_pengemudi = $value->d_name.' / '.$value->ve_license_plate;
							$value->d_address_area = $value->c_address.'<br>Kec. '.$value->rsd_name;
							$value->dod_shipping_qty = number_format($value->dod_shipping_qty);
							$value->dos_filled_show = number_format($value->dos_filled);
							$value->dod_created_date = date('d-m-Y',strtotime($value->dod_created_date));
							$value->dos_created_date = date('d-m-Y H:i:s',strtotime($value->dos_created_date));
							$value->so_tipe_show = ($value->so_tipe == 'so') ? 'NEW ORDER' : 'TRANSFER';

							if(! empty($value->dos_filled)) 
							{
								$value->new_ongkir = number_format($value->dos_ongkir);
								$value->dod_is_status = $value->dos_status;
							}
							else
							{
								$value->new_ongkir = 0;
								$value->dod_is_status = $value->dod_is_status;
							}
						}

						$data['item'][$i]['detail'] = $res_detail_trf;
					}	
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

				$data['item'][$i]['so_no_trx'] = $v->so_no_trx;
				$data['item'][$i]['tot_prog_dos'] = number_format($v->tot_prog_dos);
				$data['item'][$i]['so_total_amount'] = number_format($v->so_total_amount);

				

				$i++;
			}
			
		}

			// print_r($data);exit;
		$data['header_title'] = 'Detail Laporan Piutang';

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
		// print_r($data);exit;
		
		$view = $this->load->view('report/report_piutang_detail_pdf', $data, TRUE);
		// echo $view;exit;
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

				$pdf_creator->Output('Report Cash In_'.date('YmdHis').'_detail.pdf', 'I');
	}
}