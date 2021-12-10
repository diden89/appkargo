<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/controllers/Delivery_order_cost.php
 */

class Delivery_order_cost extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/delivery_order_cost_model', 'db_doc');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Biaya Operasional DO';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/delivery_order_cost', 'Biaya Operasional DO')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/transaksi/delivery_order_cost.js').'"></script>',
		);
		
		$this->view('delivery_order_cost_view');
	}

	public function load_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data')
		{
			$post = $this->input->post(NULL, TRUE);
			$data = $this->db_doc->load_data($post);
		
			$num = 1;

			foreach ($data->data as $k => $v)
			{
				$v->num = $num;
				$v->total_amount = 'Rp. '.number_format($v->total);
				$v->doc_created_date = date('d-m-Y H:i:s', strtotime($v->doc_created_date));

				$num++;
			}

			echo json_encode($data);
		}
		else $this->show_404();
	}

	public function load_data_temporary()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_temporary')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			if(! empty($post['so_no_trx']))
			{
				$load_data_temporary = $this->db_doc->load_data_temporary($post);
				// print_r($load_data_temporary);exit;
				if ($load_data_temporary->num_rows() > 0) 
				{
					$result = $load_data_temporary->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->no = $number;
						$v->docd_amount = number_format($v->docd_amount);

						$number++;
					}
					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));			
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);
		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_doc->get_autocomplete_data($post);

		// print_r($get_autocomplete_data);exit;
			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}


	public function load_delivery_order_cost_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_delivery_order_cost_form')
		{
			$post = $this->input->post(NULL, TRUE);

			$post['sales_order'] = $this->db_doc->get_option_no_trx($post['mode'])->result();
			$post['kas_bank'] = $this->db_doc->get_kas_bank()->result();
			$post['akun_header'] = $this->db_doc->get_akun_header()->result();
			
			$get_last_notrx = $this->db_doc->get_last_notrx();
			
			if($get_last_notrx->num_rows() > 0)
			{
				$notrx = $get_last_notrx->row();
				$last_notrx = $notrx->notrx + 1;
			}
			else
			{
				$last_notrx = 1;
			}

			$post['last_notrx'] = sprintf('%04d',$last_notrx).'/PAYDO/'.date('Ymd');
			$this->_view('delivery_order_cost_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_delivery_order_cost_detail()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_delivery_order_cost_detail')
		{
			$post = $this->input->post(NULL, TRUE);

			$cost_detail = $this->db_doc->load_data_temporary($post);

			if ($cost_detail->num_rows() > 0) 
			{
				$result = $cost_detail->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->docd_amount = number_format($v->docd_amount);
					$v->doc_created_date = date('d-m-Y H:i:s', strtotime($v->doc_created_date));
					$number++;
				}
			}
			$post['result'] = $result;
			$this->_view('delivery_order_cost_detail_view', $post);
		}
		else $this->show_404();
	}

	public function get_vehicle_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_vehicle_option')
		{
			unset($post['action']);

			$get_vehicle_option = $this->db_doc->get_vehicle_option($post);

			if ($get_vehicle_option->num_rows() > 0) 
			{
				$result = $get_vehicle_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_akun_header_option()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_akun_header_option')
		{
			unset($post['action']);

			$get_akun_header_option = $this->db_doc->get_akun_header();

			if ($get_akun_header_option->num_rows() > 0) 
			{
				$result = $get_akun_header_option->result();
				foreach($result as $k => $v) 
				{
					$v->rah_name = get_content($v->rah_name);
				}
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_akun_detail_option()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_akun_detail_option')
		{
			unset($post['action']);

			$get_akun_detail_option = $this->db_doc->get_akun_detail_option($post);

			if ($get_akun_detail_option->num_rows() > 0) 
			{
				$result = $get_akun_detail_option->result();
				foreach($result as $k => $v) 
				{
					$v->rad_name = strtoupper(get_content($v->rad_name));
				}
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function store_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'insert_data')
		{
			$post = $this->input->post(NULL, TRUE);
		
			$cek = $this->db_doc->cek_order_cost($post);
			
			if($cek->num_rows() > 0)
			{
				echo json_encode(array('success' => TRUE));
			}
			else
			{
				$store_data = $this->db_doc->store_data($post);
				echo json_encode(array('success' => TRUE));
			}
			
		}
		else $this->show_404();
	}

	public function store_data_temporary()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'insert_temporary_data')
		{
			$post = $this->input->post(NULL, TRUE);
			
			if(! empty($post['docd_lock'] ))
			{
				$post['docd_lock_ref'] = $post['docd_lock'];
			}
			else
			{
				$cek_docd = $this->db_doc->cek_order_cost_detail($post)->row()->count_id;			

					$doc_no_trx = str_replace('/','',$post['doc_no_trx']);
					$post['docd_lock_ref'] = $doc_no_trx.'_'.$cek_docd;
			}
			// print_r($post);
			$store_temporary_data = $this->db_doc->store_temporary_data($post);
			
			$post['trx_rad_id_from'] = '3';

			$store_data_ref_trx = $this->db_doc->store_data_ref_trx($post);

			if ($store_temporary_data->num_rows() > 0) 
			{
				$result = $store_temporary_data->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->docd_amount = number_format($v->docd_amount);

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}	

	public function total_amount_detail()
	{
		$post = $this->input->post(NULL, TRUE);
		// print_r($post);exit;
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'total_amount_detail')
		{
			unset($post['action']);

			$total_amount_detail = $this->db_doc->total_amount_detail($post);

			if ($total_amount_detail->num_rows() > 0) 
			{
				$result = $total_amount_detail->row();

				echo json_encode(array('success' => TRUE, 'total_amount' => 'Rp '.number_format($result->total_amount)));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function delete_data_temp()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_temp')
		{
			$post = $this->input->post(NULL, TRUE);

			$delete_data_ref_transaksi = $this->db_doc->delete_data_ref_transaksi($post);
			$delete_data_temp = $this->db_doc->delete_data_temp($post);
			// print_r($delete_data_temp->result()) ;exit;
			if ($delete_data_temp->num_rows() > 0) 
			{
				$result = $delete_data_temp->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->docd_amount = number_format($v->docd_amount);

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!','data' => array()));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data')
		{
			$post = $this->input->post(NULL, TRUE);
			
			$delete_data_order_cost = $this->db_doc->delete_data_order_cost($post);
			$delete_data_order_cost_detail = $this->db_doc->delete_data_order_cost_detail($post);
			$delete_data_ref_transaksi = $this->db_doc->delete_data_ref_transaksi($post);
			
			return $load_data = $this->load_data(array('action' => 'load_data'));

			// echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

}