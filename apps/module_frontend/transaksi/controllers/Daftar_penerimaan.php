<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/controllers/Daftar_penerimaan.php
 */

class Daftar_penerimaan extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/daftar_penerimaan_model', 'db_daftar_penerimaan');
		// print_r($this->session);exit;
	}

	public function index()
	{
		$params['user_id'] = $this->session->userdata('user_id');

		$this->store_params['header_title'] = 'Daftar Penerimaan';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/daftar_penerimaan', 'Daftar Penerimaan')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/transaksi/daftar_penerimaan.js').'"></script>',
		);
		
		$this->store_params['item'] = [];
		$date = date('d-m-Y H:i:s');
		$date = strtotime($date);
		$date = strtotime("-7 day", $date);
		// echo date('d-m-Y H:i:s', $date);

		$params['date_range1'] = date('Y-m-d', $date);
		$params['date_range2'] = date('Y-m-d');

		$cek_driver_akses = $this->db_daftar_penerimaan->cek_driver_akses($params);
		if($cek_driver_akses->num_rows() > 0)
		{
			$params['akses_driver'] = $params['user_id'];
		}
		else
		{
			$params['akses_driver'] = "";
		}

		$load_data_daftar_penerimaan = $this->db_daftar_penerimaan->load_data_daftar_penerimaan($params);

		if ($load_data_daftar_penerimaan->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_daftar_penerimaan->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
				if(! empty($v->dos_filled)) 
				{
					$v->new_ongkir = $v->dos_ongkir;
					$v->dod_is_status = $v->dos_status;
				}
				else
				{
					$v->new_ongkir = $v->dod_ongkir;
					$v->dod_is_status = $v->dod_is_status;
				}
			}
			// print_r($result);exit;

			$this->store_params['item'] = $result;
		}

		$this->view('daftar_penerimaan_view');
	}

	public function load_data_daftar_penerimaan() // dipakai
	{
		$params['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['action']) && $_POST['action'] == 'load_data_daftar_penerimaan')
		{
			$post = $this->input->post(NULL, TRUE);

			$cek_driver_akses = $this->db_daftar_penerimaan->cek_driver_akses($params);
			if($cek_driver_akses->num_rows() > 0)
			{
				$post['akses_driver'] = $post['user_id'];
			}
			else
			{
				$post['akses_driver'] = "";
			}

			$load_data_daftar_penerimaan = $this->db_daftar_penerimaan->load_data_daftar_penerimaan($post);
			// print_r($_POST);exit;
			if ($load_data_daftar_penerimaan->num_rows() > 0) 
			{
				$result = $load_data_daftar_penerimaan->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->num = $number;
					if(! empty($v->dos_filled)) 
					{
						$v->new_ongkir = $v->dos_ongkir;
						$v->dod_is_status = $v->dos_status;
					}
					else
					{
						$v->new_ongkir = $v->dod_ongkir;
						$v->dod_is_status = $v->dod_is_status;
					}

					$number++;
				}
				// print_r($result);exit;
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function load_daftar_penerimaan_form() // dipakai
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_daftar_penerimaan_form')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array(
				'table' => 'province'
			);

			$new_params['user_id'] = $this->session->userdata('user_id');

			$post['sales_order'] = $this->db_daftar_penerimaan->get_option_so()->result();
			$post['customer'] = $this->db_daftar_penerimaan->get_option_customer()->result();
			$post['vehicle'] = $this->db_daftar_penerimaan->get_option_vehicle()->result();
			$post['driver'] = $this->db_daftar_penerimaan->get_option_driver()->result();
			$post['vendor'] = $this->db_daftar_penerimaan->get_option_vendor()->result();
			$post['item_list'] = $this->db_daftar_penerimaan->get_option_item_list()->result();
			$get_last_notrx = $this->db_daftar_penerimaan->get_last_notrx();

			if($get_last_notrx->num_rows() > 0)
			{
				$notrx = $get_last_notrx->row();
				$last_notrx = $notrx->notrx + 1;
			}
			else
			{
				$last_notrx = 1;
			}

			$cek_driver_akses = $this->db_daftar_penerimaan->cek_driver_akses($new_params);
			if($cek_driver_akses->num_rows() > 0)
			{
				$post['akses_driver'] = $post['user_id'];
			}
			else
			{
				$post['akses_driver'] = "";
			}

			$post['last_notrx'] = sprintf('%04d',$last_notrx);
			

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_daftar_penerimaan->load_data_daftar_penerimaan($post)->row();
				
			}
		// print_r($post['data']);exit;
			$this->_view('daftar_penerimaan_form_view', $post);
		}
		else $this->show_404();
	}

	public function load_do_data() // dipakai
	{
		$post = $this->input->post(NULL, TRUE);
		$new_params['user_id'] = $this->session->userdata('user_id');

		// print_r($post);exit;
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'load_data_daftar_penerimaan')
		{
			unset($post['action']);

			$cek_driver_akses = $this->db_daftar_penerimaan->cek_driver_akses($new_params);
			if($cek_driver_akses->num_rows() > 0)
			{
				$post['akses_driver'] = $post['user_id'];
			}
			else
			{
				$post['akses_driver'] = "";
			}

			$load_data_daftar_penerimaan = $this->db_daftar_penerimaan->load_data_daftar_penerimaan($post);

			if ($load_data_daftar_penerimaan->num_rows() > 0) 
			{
				$result = $load_data_daftar_penerimaan->result();
				$num = 0;

				foreach ($result as $k => $v)
				{
					$num++;

					$v->num = $num;
					$v->dod_created_date = date('d-m-Y',strtotime($v->dod_created_date));
					$v->dod_shipping_qty_ori = $v->dod_shipping_qty;
					$v->dod_shipping_qty = number_format($v->dod_shipping_qty);
					$v->dod_ongkir = number_format($v->dod_ongkir);
					$v->new_ongkir = $v->dod_ongkir;
				}
					// print_r($result);exit;
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	
	public function load_update_status_form()
	{
		$new_params['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['action']) && $_POST['action'] == 'load_update_status_form')
		{
			$post = $this->input->post(NULL, TRUE);

			$cek_driver_akses = $this->db_daftar_penerimaan->cek_driver_akses($new_params);
			if($cek_driver_akses->num_rows() > 0)
			{
				$post['akses_driver'] = $post['user_id'];
			}
			else
			{
				$post['akses_driver'] = "";
			}

			$post['data'] = $this->db_daftar_penerimaan->load_data_daftar_penerimaan($post)->row();
			// print_r($post);exit;

			$this->_view('update_status_form_view', $post);
		}
		else $this->show_404();
	}


	public function print_penerimaan() //dipakai
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_delivery_detail_do')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_detail_do = $this->db_daftar_penerimaan->load_data_detail_do($post);
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

	public function store_update_status()//dipakai
	{
		$new_params['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['action']) && $_POST['action'] == 'store_update_status')
		{
			$post = $this->input->post(NULL, TRUE);
			$post['total_terpenuhi'] = str_replace(',','',$post['total_terpenuhi']);
			$post['dod_is_status'] = 'SELESAI';
			$input_to_penerimaan_status = $this->db_daftar_penerimaan->store_penerimaan_status($post);

			$cek_driver_akses = $this->db_daftar_penerimaan->cek_driver_akses($new_params);
			if($cek_driver_akses->num_rows() > 0)
			{
				$post['akses_driver'] = $post['user_id'];
			}
			else
			{
				$post['akses_driver'] = "";
			}
			// print_r($post);exit;
			$update_status = $this->db_daftar_penerimaan->store_update_status_penerimaan($post); //update status

			$get_total_do = $this->db_daftar_penerimaan->get_total_do($post,'total')->row();
			$get_total_sod = $this->db_daftar_penerimaan->get_total_sod_total($post)->row();
			
			// print_r($get_total_do);exit;
			if($get_total_do->total_order !== 0)
			{
				$get_ttl = $get_total_do->total_order;
			}

			if($get_total_sod->total_sod !== 0)
			{
				$get_ttl_sod = $get_total_sod->total_sod;
			}

			if($get_ttl < $get_ttl_sod) {
				$post['is_status'] = 'ON PROGRESS';
			} else if($get_ttl == $get_ttl_sod) {
				$post['is_status'] = $post['dod_is_status'];
			}

			// print_r($post);exit;
			$update_status_sales_order = $this->db_daftar_penerimaan->store_update_status_sales_order($post);

			if ($update_status->num_rows() > 0) 
			{
				$result = $update_status->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->num = $number;
					$v->dod_created_date = date('d-m-Y',strtotime($v->dod_created_date));
					$v->dod_shipping_qty = number_format($v->dod_shipping_qty);
					
					if(! empty($v->dos_filled)) 
					{
						$v->new_ongkir = number_format($v->dos_ongkir);
						$v->dod_is_status = $v->dos_status;
					}
					else
					{
						$v->new_ongkir = number_format($v->dos_ongkir);
						$v->dod_is_status = $v->dod_is_status;
					}

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
			
			$get_data = $this->db_daftar_penerimaan->load_data_daftar_penerimaan($post)->row();			
			// print_r($get_data);
			// exit;
			$new_amount = $get_data->so_total_amount - $get_data->so_total_amount;
			$params['total_amount'] = $new_amount;
			$params['so_id'] = $get_data->so_id;

			$new_qty = $get_data->dod_shipping_qty - $get_data->sod_realisasi;
			$params['new_qty'] = $new_qty;
			$params['dod_sod_id'] = $get_data->dod_sod_id;

			$update_amount = $this->db_daftar_penerimaan->update_amount_sales_order_detail($params);

			$update_qty = $this->db_daftar_penerimaan->update_quantity_sales_order_detail($params);

			$delete_do = $this->db_daftar_penerimaan->delete_data_daftar_penerimaan($post);

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

}