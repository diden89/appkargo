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
			'<script src="'.base_url('scripts/report/Report_cash_in.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('Report_cash_in_view');
	}

	
	public function print_pdf()
	{
		// print_r($_POST);exit;
		$data = array();
		$this->store_params['header_title'] = 'Laporan Kas Masuk';
		$post = $this->input->post();

		$get_data = $this->db_rci->load_data_kas_masuk($post);

		if ($get_data->num_rows() > 0)
		{
			$num = 0;
			$result = $get_data->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
				$v->ci_total = number_format($v->ci_total);
			}
			
			$data['item'] = $result;
		}

		$data['header_title'] = 'Laporan Kas Masuk';
	
		$view = $this->load->view('Report_cash_in_view_pdf', $data, TRUE);

				$this->load->library('pdf_creator');

				$pdf_creator = $this->pdf_creator->load([
				    'mode' => 'utf-8',
				    'format' => 'A4',
				    'margin_top' => 5,
				    'margin_bottom' => 25,
					'margin_header' => 40,
					'margin_footer' => 15
				]);

				$pdf_creator->WriteHTML($view);

				$pdf_creator->Output('Report Cash In_'.$row->txt_name.'_'.$row->txt_visit_date.'.pdf', 'I');
	}
}