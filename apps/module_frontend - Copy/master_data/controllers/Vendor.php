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

		$this->store_params['item'] = [];

		$load_data_vendor = $this->db_vendor->load_data_vendor();

		if ($load_data_vendor->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_vendor->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
			}

			$this->store_params['item'] = $result;
		}

		$this->view('vendor_view');
	}

	public function load_vendor_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_vendor_form')
		{
			$post = $this->input->post(NULL, TRUE);
			
			$post['vendor'] = $this->db_vendor->load_data_vendor($post)->row();

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_vendor->load_data_vendor($post)->row();
			}
			
			$this->_view('vendor_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_data_vendor()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_vendor')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_vendor = $this->db_vendor->load_data_vendor($post);
			// print_r($_POST);exit;
			if ($load_data_vendor->num_rows() > 0) 
			{
				$result = $load_data_vendor->result();
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

	public function delete_data_vendor()
	{

		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item')
		{
			$post = $this->input->post(NULL, TRUE);
			$cek_before_delete = $this->db_vendor->cek_before_delete($post,'item_list','il');
			if($cek_before_delete->num_rows() < 1)
			{
				$delete_data_item = $this->db_vendor->delete_data_item($post);

				if ($delete_data_item->num_rows() > 0) 
				{
					$result = $delete_data_item->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->no = $number;

						$number++;
					}
					
					echo json_encode(array('success' => TRUE, 'data' => $result,'msg' => 'Success'));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
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
			 	echo json_encode(array('success' => TRUE, 'msg' => 'Cannot delete this data!','data' => $res));
			}
		}
		else $this->show_404();
	}
}