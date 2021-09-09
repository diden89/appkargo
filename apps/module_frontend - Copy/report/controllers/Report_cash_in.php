<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/report/controllers/Report_cash_in.php
 */

class Report_cash_in extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('report/Report_cash_in_model', 'db_rci');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Laporan Kas Masuk';
		$this->store_params['pages_title'] = 'Laporan Kas Masuk List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('report/Report_cash_in', 'Laporan Kas Masuk')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/report/report_cash_in.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('report_cash_in_view');
	}

	
	public function print_pdf()
	{
		$post = $this->input->post();

		if($post['type'] == 'rekap')
		{
			$this->rekap_laporan_kas_masuk($post);
		}
		else
		{
			$this->detail_laporan_kas_masuk($post);
		}

	}
	public function rekap_laporan_kas_masuk($params)
	{
		$data = array();

		$get_data = $this->db_rci->load_data_kas_masuk($params);
		$data_company = $this->db_main->get_company();

		if ($get_data->num_rows() > 0)
		{
			$num = 0;
			$result = $get_data->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
				$v->ci_total_val = number_format($v->ci_total);
			}
			
			$data['item'] = $result;
		}

		// print_r($params);exit;
		$data['header_title'] = 'Rekap Laporan Kas Masuk';

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

	public function detail_laporan_kas_masuk($params)
	{
		$data = array();

		$get_data = $this->db_rci->load_data_kas_masuk($params);

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
				$get_data_detail = $this->db_rci->load_data_kas_masuk_detail(array('no_trx' => $v->ci_no_trx));
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
		
		$view = $this->load->view('report/report_cash_in_detail_pdf', $data, TRUE);
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