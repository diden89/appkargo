<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/master_data/controllers/Vendor.php
 */

class Vendor extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master_data/vendor_model', 'db_vendor');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Data Vendor';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('master_data/vendor', 'Daftar Item')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/master_data/vendor.js').'"></script>',
		);

		$this->view('vendor_view');
	}

	public function load_data_vendor()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_vendor')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_vendor = $this->db_vendor->load_data_vendor($post);
			
			$number = 1;

			foreach ($load_data_vendor->data as $k => $v) 
			{
				$v->no = $number;

				$number++;
			}
			echo json_encode($load_data_vendor);
		}
		else $this->show_404();
	}

	public function vendor_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'vendor_form')
		{
			$post = $this->input->post(NULL, TRUE);
			
			$post['user'] = $this->db_vendor->get_user_akses($post)->result();
			if($post['mode'] == 'edit')
			{
				$post['txt_id'] = $post['data']['v_id'];
				$data = $this->db_vendor->get_data_vendor($post);
				foreach($data->result() as $v => $k)
				{
					$akses = explode(',', str_replace(' ','',$k->v_user_access));
					$k->user_akses = $akses;
				}

				$post['data'] = $data->row();
			}
			// print_r($post);exit;
			$this->_view('vendor_form_view', $post);
		}
		else $this->show_404();
	}


	public function store_data_vendor()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_vendor')
		{
			$post = $this->input->post(NULL, TRUE);
			$store_data_vendor = $this->db_vendor->store_data_vendor($post);

			if ($store_data_vendor->num_rows() > 0) 
			{
				$result = $store_data_vendor->result();
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

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($_POST['action']) && $_POST['action'] == 'delete_data')
		{
			unset($post['action']);

			$cek_before_delete = $this->db_vendor->cek_before_delete($post,'item_list','il');
			
			if($cek_before_delete->num_rows() < 1)
			{
				$delete_data = $this->db_vendor->delete_data($post);

				echo json_encode(array('success' => $delete_data));
			}
			else
			{
				$res = $cek_before_delete->result();
				$numb = 1;

				foreach ($res as $k => $v)
				{
					$v->no = $numb;

					$numb++;
				}
			 	echo json_encode(array('success' => FALSE, 'msg' => 'Cannot delete this data!','data' => $res));
			}
		}
		else $this->show_404();
	}

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_vendor->get_autocomplete_data($post);

			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}

}