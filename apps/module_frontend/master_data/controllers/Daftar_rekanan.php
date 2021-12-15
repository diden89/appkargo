<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/controllers/Daftar_rekanan.php
 */

class Daftar_rekanan extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master_data/daftar_rekanan_model', 'db_rekanan');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Data Rekanan';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('master_data/daftar_rekanan', 'Daftar Rekanan')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/master_data/daftar_rekanan.js').'"></script>',
		);

		$this->view('daftar_rekanan_view');
	}

	public function load_data_rekanan()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_rekanan')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_rekanan = $this->db_rekanan->load_data_rekanan($post);
			
			$number = 1;

			foreach ($load_data_rekanan->data as $k => $v) 
			{
				$v->no = $number;
				$number++;
			}

			echo json_encode($load_data_rekanan);
		}
		else $this->show_404();
	}

	public function rekanan_form()
	{

		if (isset($_POST['action']) && $_POST['action'] == 'rekanan_form')
		{
			$post = $this->input->post(NULL, TRUE);
			
			$post['vehicle'] = $this->db_rekanan->get_vehicle($post)->result();
			$post['user_detail'] = $this->db_rekanan->get_user_login($post)->result();
			
			if($post['mode'] == 'edit')
			{
				$post['txt_id'] = $post['data']['pr_id'];
				$post['data'] = $this->db_rekanan->get_data_rekanan($post)->row();

			}
			// print_r($post);exit;
			$this->_view('daftar_rekanan_form_view', $post);
		}
		else $this->show_404();
	}


	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);
		// print_r($post);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'store_data')
		{
			unset($post['action']);
		
			$store_data = $this->db_rekanan->store_data($post);
		
			echo json_encode(array('success' => $store_data));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($_POST['action']) && $_POST['action'] == 'delete_data')
		{
			unset($post['action']);

			$delete_data = $this->db_rekanan->delete_data($post);

			echo json_encode(array('success' => $delete_data));			

		}
		else $this->show_404();
	}

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_rekanan->get_autocomplete_data($post);

			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}

}