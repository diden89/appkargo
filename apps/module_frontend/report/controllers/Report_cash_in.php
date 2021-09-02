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
		$this->load->view('Report_cash_in_view_pdf');
	}
}