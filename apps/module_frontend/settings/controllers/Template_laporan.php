<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/settings/controllers/Template_laporan.php
 */

class Template_laporan extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('settings/template_laporan_model', 'db_tl');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Template';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('settings/template_laporan', 'Daftar Template')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/settings/template_laporan.js').'"></script>',
		);

		$this->view('template_laporan_view');
	}

	public function load_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data')
		{
			$post = $this->input->post(NULL, TRUE);
			
			$load_data = $this->db_tl->load_data($post);
			
			$number = 1;

			foreach ($load_data->data as $k => $v) 
			{
				$v->no = $number;

				$number++;
			}
			echo json_encode($load_data);
		}
		else $this->show_404();
	}

	public function template_laporan_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'template_laporan_form')
		{
			$post = $this->input->post(NULL, TRUE);
			
			// print_r($post);exit;
			$post['temp'] = $this->db_tl->get_data($post)->row();
			$post['vendor'] = $this->db_tl->vendor_option($post)->result();
			
			$this->_view('template_laporan_form_view', $post);
		}
		else $this->show_404();
	}


	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);
		if (isset($_POST['action']) && $_POST['action'] == 'store_data')
		{
			unset($post['action']);
			$unique = '';
			$i=0;
			foreach($post['v_akses'] as $k)
			{
				
				if($i == 0) { $unique .= md5($k); }
				else { $unique .= ','.md5($k);}
				$i++;
			}
			
			$post['v_unique_akses'] = $unique;
			$post['v_akses'] = implode(',',$post['v_akses']);
			
			$store_data = $this->db_tl->store_data($post);

			echo json_encode(array('success' => $store_data));
		}
		else $this->show_404();
	}

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_tl->get_autocomplete_data($post);

			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}

}