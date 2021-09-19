<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/transaksi/controllers/Tagihan_pembayaran.php
 */

class Tagihan_pembayaran extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/tagihan_pembayaran_model', 'db_tp');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Laporan Tagihan Pembayaran';
		$this->store_params['pages_title'] = 'Laporan Tagihan Pembayaran List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/tagihan_pembayaran', 'Laporan Tagihan Pembayaran')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/transaksi/tagihan_pembayaran.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->store_params['vendor'] = $this->db_tp->load_vendor()->result();

		$this->view('tagihan_pembayaran_view');
	}

	
	public function print_pdf()
	{
		$post = $this->input->post();

		$this->rekap_tagihan_pembayaran($post);

		// print_r($post);exit;
		// if($post['vendor'] == 'rekap')
		// {
		// }
		// else
		// {
		// 	$this->detail_laporan_kas_masuk($post);
		// }

	}
	public function rekap_tagihan_pembayaran($params)
	{
		$data = array();

		$get_data = $this->db_tp->load_data_rekap_tagihan($params);

		$data_company = $this->db_main->get_company();

		$result = $get_data->result();
		$number = 0;
		foreach ($result as $k => $v) 
		{
			$v->num = $number;
			$v->d_name_pengemudi = $v->d_name.' / '.$v->ve_license_plate;
			$v->d_address_area = $v->c_address.'<br>Kec. '.$v->rsd_name;
			$v->dod_shipping_qty = number_format($v->dod_shipping_qty);
			$v->dos_filled = number_format($v->dos_filled);
			$v->dod_created_date = date('d-m-Y',strtotime($v->dod_created_date));
			$v->dos_created_date = date('d-m-Y H:i:s',strtotime($v->dos_created_date));

			if(! empty($v->dos_filled)) 
			{
				$v->new_ongkir = number_format($v->dos_ongkir);
				$v->dod_is_status = $v->dos_status;
			}
			else
			{
				$v->new_ongkir = 0;
				$v->dod_is_status = $v->dod_is_status;
			}

			$number++;
		}

		$data['item'] = $result;

		print_r($data);exit;
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
		
		$view = $this->load->view('transaksi/tagihan_pembayaran_'.$params['vendor'].'_pdf', $data, TRUE);

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

	public function detail_laporan_kas_masuk($params)
	{
		$data = array();

		$get_data = $this->db_tp->load_data_kas_masuk($params);

		$data_company = $this->db_main->get_company();

		if ($get_data->num_rows() > 0)
		{
			$result = $get_data->result();
			$i = 0;
			foreach ($result as $k => $v)
			{
				$v->ci_total_val = number_format($v->ci_total);
				$data['item'][$i]['ci_no_trx'] = $v->ci_no_trx; 
				$data['item'][$i]['rad_name'] = $v->rad_name; 
				$data['item'][$i]['ci_created_date'] = $v->ci_created_date; 
				$data['item'][$i]['ci_total'] = $v->ci_total; 
				$data['item'][$i]['ci_total_val'] = number_format($v->ci_total); 
				$get_data_detail = $this->db_tp->load_data_kas_masuk_detail(array('no_trx' => $v->ci_no_trx));
				if($get_data_detail->num_rows() > 0)
				{
					$num = 0;
					$res_detail = $get_data_detail->result();
					foreach ($res_detail as $key => $value) {
						$num++;
						$value->num = $num;
						$value->cid_total_val = number_format($value->cid_total);
					}

					$data['item'][$i]['detail'] = $res_detail;
				}
				$i++;
			}
			
		}

		$data['header_title'] = 'Detail Laporan Kas Masuk';

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
		
		$view = $this->load->view('transaksi/tagihan_pembayaran_detail_pdf', $data, TRUE);
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