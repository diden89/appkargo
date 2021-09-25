<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/controllers/Daftar_delivery_order_transfer.php
 */

class Daftar_delivery_order_transfer extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/daftar_delivery_order_transfer_model', 'db_ddo_trx');
		// print_r($this->session);exit;
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Daftar Delivery Order Transfer';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/daftar_delivery_order_transfer', 'Daftar Delivery Order Transfer')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/transaksi/daftar_delivery_order_transfer.js').'"></script>',
		);
		
		$this->store_params['item'] = [];
		$date = date('d-m-Y H:i:s');
		$date = strtotime($date);
		$date = strtotime("-7 day", $date);
		// echo date('d-m-Y H:i:s', $date);

		$params['date_range1'] = date('Y-m-d', $date);
		$params['date_range2'] = date('Y-m-d');

		$load_data_daftar_transfer = $this->db_ddo_trx->load_data_daftar_transfer($params);

		if ($load_data_daftar_transfer->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_daftar_transfer->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
			}

			$this->store_params['item'] = $result;
		}

		$this->view('daftar_delivery_order_transfer_view');
	}

	public function load_data_daftar_transfer() // dipakai
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_daftar_transfer')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_daftar_transfer = $this->db_ddo_trx->load_data_daftar_transfer($post);
			// print_r($_POST);exit;
			if ($load_data_daftar_transfer->num_rows() > 0) 
			{
				$result = $load_data_daftar_transfer->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->num = $number;
					$v->dotd_shipping_qty = number_format($v->dotd_shipping_qty);
					$v->dotd_ongkir = number_format($v->dotd_ongkir);
					$v->dotd_created_date = date('d-m-Y',strtotime($v->dotd_created_date));

					$number++;
				}
				// print_r($result);exit;
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function get_realisasi_qty() // dipakai
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_realisasi_qty')
		{
			unset($post['action']);

			$get_realisasi_qty = $this->db_ddo_trx->get_realisasi_qty($post);

			if ($get_realisasi_qty->num_rows() > 0) 
			{
				$res = $get_realisasi_qty->row();
				$qty = (! empty($res->qty_real) && $res->qty_real !== "") ? $res->qty_real : '0';
				echo json_encode(array('success' => TRUE, 'qty_real' => $qty));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_ongkir_district() // dipakai
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_ongkir_district')
		{
			unset($post['action']);

			$get_ongkir_district = $this->db_ddo_trx->get_ongkir_district($post);

			if ($get_ongkir_district->num_rows() > 0) 
			{
				$res = $get_ongkir_district->row();

				echo json_encode(array('success' => TRUE, 'ongkir_temp' => $res->c_shipping_area));
			}
			else echo json_encode(array('success' => FALSE, 'ongkir_temp' => '0'));
		}
		else $this->show_404();
	}

	public function load_daftar_delivery_order_transfer_form() // dipakai
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_daftar_delivery_order_transfer_form')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array(
				'table' => 'province'
			);

			$post['sales_order'] = $this->db_ddo_trx->get_option_so()->result();
			$post['customer'] = $this->db_ddo_trx->get_option_customer()->result();
			$post['vehicle'] = $this->db_ddo_trx->get_option_vehicle()->result();
			$post['driver'] = $this->db_ddo_trx->get_option_driver()->result();
			$post['vendor'] = $this->db_ddo_trx->get_option_vendor()->result();
			$post['item_list'] = $this->db_ddo_trx->get_option_item_list()->result();
			$get_last_notrx = $this->db_ddo_trx->get_last_notrx();

			if($get_last_notrx->num_rows() > 0)
			{
				$notrx = $get_last_notrx->row();
				$last_notrx = $notrx->notrx + 1;
			}
			else
			{
				$last_notrx = 1;
			}

			$post['last_notrx'] = sprintf('%04d',$last_notrx);
			

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_ddo_trx->load_data_daftar_transfer($post)->row();
				
			}
		// print_r($post['data']);exit;
			$this->_view('daftar_delivery_order_transfer_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_do_data() // dipakai
	{
		$post = $this->input->post(NULL, TRUE);

		// print_r($post);exit;
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'load_data_daftar_transfer')
		{
			unset($post['action']);

			$load_data_daftar_transfer = $this->db_ddo_trx->load_data_daftar_transfer($post);

			if ($load_data_daftar_transfer->num_rows() > 0) 
			{
				$result = $load_data_daftar_transfer->result();
				$num = 0;

				foreach ($result as $k => $v)
				{
					$num++;

					$v->num = $num;
					$v->dotd_created_date = date('d-m-Y',strtotime($v->dotd_created_date));
					$v->dotd_shipping_qty_ori = $v->dotd_shipping_qty;
					$v->dotd_shipping_qty = number_format($v->dotd_shipping_qty);
					$v->dotd_ongkir = number_format($v->dotd_ongkir);
				}
					// print_r($result);exit;
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function store_data_transfer()//dipakai
	{
		if (isset($_POST['action']) && $_POST['action'] == 'insert_delivery_order')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$store_data_daftar_delivery_order_transfer = $this->db_ddo_trx->store_data_daftar_delivery_order_transfer($post);

			$get_total_qty = $this->db_ddo_trx->get_total_qty($post,'sum(dotd_shipping_qty) as total_qty');
			$get_total_amount = $this->db_ddo_trx->get_total_amount($post,'sum(dotd.dotd_ongkir) as total_amount');

			if($get_total_qty->num_rows() > 0) {
				$total = $get_total_qty->row();
				$post['new_qty'] = $total->total_qty;
			
				$update_quantity_sales_order_detail = $this->db_ddo_trx->update_quantity_sales_order_detail($post);

			}

			if($get_total_amount->num_rows() > 0) {
				$total_a = $get_total_amount->row();
				$post['total_amount'] = $total_a->total_amount;
			
				$update_amount_sales_order_detail = $this->db_ddo_trx->update_amount_sales_order_detail($post);

			}

			$result = $this->db_ddo_trx->load_data_daftar_transfer($post);
			
			if ($result->num_rows() > 0) 
			{
				$res = $result->result();
				$number = 1;

				foreach ($res as $k => $v)
				{
					$v->num = $number;
					$v->dotd_created_date = date('d-m-Y H:i:s',strtotime($v->dotd_created_date));
					$v->dotd_shipping_qty = number_format($v->dotd_shipping_qty);
					$v->dotd_ongkir = number_format($v->dotd_ongkir);

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $res));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}	

	public function load_update_status_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_update_status_form')
		{
			$post = $this->input->post(NULL, TRUE);

			$post['data'] = $this->db_ddo_trx->load_data_daftar_transfer($post)->row();
			// print_r($post);exit;

			$this->_view('update_status_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_detail_so_option()
	{
		$post = $this->input->post(NULL, TRUE);

		// print_r($post);exit;
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_detail_so_option')
		{
			unset($post['action']);

			$get_detail_so_option = $this->db_ddo_trx->get_detail_so_option($post);

			if ($get_detail_so_option->num_rows() > 0) 
			{
				$result = $get_detail_so_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}	

	public function get_item_list_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_item_list_option')
		{
			unset($post['action']);

			$get_item_list_option = $this->db_ddo_trx->get_item_list_option($post);

			if ($get_item_list_option->num_rows() > 0) 
			{
				$result = $get_item_list_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_customer_option() //dipakai
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_customer_option')
		{
			unset($post['action']);

			$get_customer_option = $this->db_ddo_trx->get_customer_option($post);

			if ($get_customer_option->num_rows() > 0) 
			{
				$result = $get_customer_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_customer_option_to() //dipakai
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_customer_option_to')
		{
			unset($post['action']);

			$get_customer_option_to = $this->db_ddo_trx->get_customer_option_to($post);

			if ($get_customer_option_to->num_rows() > 0) 
			{
				$result = $get_customer_option_to->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}	

	public function load_data_delivery_detail_do()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_delivery_detail_do')
		{
			// print_r($_POST);exit;
			$post = $this->input->post(NULL, TRUE);
			$load_data_detail_do = $this->db_ddo_trx->load_data_detail_do($post);
			if ($load_data_detail_do->num_rows() > 0) 
			{
				$result = $load_data_detail_do->result();
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

	public function print_delivery_order() //dipakai
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_delivery_detail_do')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_detail_do = $this->db_ddo_trx->load_data_detail_do($post);
			if ($load_data_detail_do->num_rows() > 0) 
			{
				$result = $load_data_detail_do->result();
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

	public function store_data_daftar_delivery_order_transfer()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_daftar_delivery_order_transfer')
		{
			$post = $this->input->post(NULL, TRUE);
			$store_data_daftar_delivery_order_transfer = $this->db_ddo_trx->store_data_daftar_delivery_order_transfer($post);

			if ($store_data_daftar_delivery_order_transfer->num_rows() > 0) 
			{
				$result = $store_data_daftar_delivery_order_transfer->result();
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

	public function store_update_status()//dipakai
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_update_status')
		{
			$post = $this->input->post(NULL, TRUE);
			$post['total_terpenuhi'] = str_replace(',','',$post['total_terpenuhi']);
			$post['dotd_is_status'] = 'SELESAI';
			
			$input_to_delivery_order_status = $this->db_ddo_trx->store_delivery_order_status($post);

			$update_status = $this->db_ddo_trx->store_update_status_delivery_order($post); //update status
			print_r($post);exit;

			$get_total_filled = $this->db_ddo_trx->get_total_filled($post,'total');

			if($get_total_filled->num_rows() > 0) {
				$get_total_success = $this->db_ddo_trx->get_total_filled($post);

				if($get_total_success->num_rows() > 0) {
					$get_ttl = $get_total_filled->row();
					$get_suc = $get_total_success->row();

					if($get_suc->total_data < $get_ttl->total_data) {
						$post['is_status'] = 'ON PROGRESS';
					} else if($get_suc->total_data == $get_ttl->total_data) {
						$post['is_status'] = $post['dotd_is_status'];
					}
				}
			}
			 // print_r($post);exit;
			$update_status_sales_order = $this->db_ddo_trx->store_update_status_sales_order($post);

			if ($update_status->num_rows() > 0) 
			{
				$result = $update_status->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->num = $number;
					$v->dotd_created_date = date('d-m-Y',strtotime($v->dotd_created_date));
					$v->dotd_shipping_qty = number_format($v->dotd_shipping_qty);
					$v->dotd_ongkir = number_format($v->dotd_ongkir);

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
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array();
			
			$get_data = $this->db_ddo_trx->load_data_daftar_transfer($post)->row();			
			// print_r($get_data);
			// exit;
			$new_amount = $get_data->so_total_amount - $get_data->so_total_amount;
			$params['total_amount'] = $new_amount;
			$params['so_id'] = $get_data->so_id;

			$new_qty = $get_data->dotd_shipping_qty - $get_data->sod_realisasi;
			$params['new_qty'] = $new_qty;
			$params['dotd_sod_id'] = $get_data->dotd_sod_id;

			$update_amount = $this->db_ddo_trx->update_amount_sales_order_detail($params);

			$update_qty = $this->db_ddo_trx->update_quantity_sales_order_detail($params);

			$delete_do = $this->db_ddo_trx->delete_data_daftar_delivery_order_transfer($post);

			if ($delete_do->num_rows() > 0) 
			{
				$result = $delete_do->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->num = $number;

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function delete_data_temp()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_temp')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_sod = $this->db_ddo_trx->delete_data_so_detail($post);

			if ($delete_data_sod->num_rows() > 0) 
			{
				$result = $delete_data_sod->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!','data' => array()));
		}
		else $this->show_404();
	}
}