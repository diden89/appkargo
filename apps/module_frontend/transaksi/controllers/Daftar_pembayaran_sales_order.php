<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/transaksi/controllers/Daftar_pembayaran_sales_order.php
 */

class Daftar_pembayaran_sales_order extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/daftar_pembayaran_sales_order_model', 'db_daftar_pso');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Daftar Pembayaran Sales Order';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/daftar_pembayaran_sales_order', 'Daftar Pembayaran Sales Order')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/transaksi/daftar_pembayaran_sales_order.js').'"></script>',
		);

		$this->store_params['item'] = [];
		$date = date('d-m-Y H:i:s');
		$date = strtotime($date);
		$date = strtotime("-7 day", $date);
		// echo date('d-m-Y H:i:s', $date);

		$params['date_range1'] = date('Y-m-d H:i:s', $date);
		$params['date_range2'] = date('Y-m-d H:i:s');
		$load_data_daftar_pembayaran_sales_order = $this->db_daftar_pso->load_data_daftar_pembayaran_sales_order($params);

		if ($load_data_daftar_pembayaran_sales_order->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_daftar_pembayaran_sales_order->result();

			foreach ($result as $k => $v)
			{
				$num++;

				
				$v->num = $num;
				$v->sop_created_date = date('d-m-Y',strtotime($v->sop_created_date));	
				$v->so_total_amount = number_format($v->so_total_amount);	
			}
			// print_r($result);exit;
			$this->store_params['item'] = $result;
		}

		$this->view('daftar_pembayaran_sales_order_view');
	}

	public function load_daftar_pembayaran_sales_order_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_daftar_pembayaran_sales_order_form')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array(
				'table' => 'province'
			);

			// $post['vendor'] = $this->db_daftar_pso->get_option_province()->result();
			// $post['province'] = $this->db_daftar_pso->get_option_province()->result();
			// $post['vendor'] = $this->db_daftar_pso->get_option_vendor()->result();
			// $post['item_list'] = $this->db_daftar_pso->get_option_item_list()->result();
			$get_last_notrx = $this->db_daftar_pso->get_last_notrx();

			if($get_last_notrx->num_rows() > 0)
			{
				$notrx = $get_last_notrx->row();
				$last_notrx = $notrx->notrx + 1;
			}
			else
			{
				$last_notrx = 1;
			}

			$notrx = sprintf('%04d',$last_notrx).'/SOPAY/'.date('Ymd');
			$post['last_notrx'] = $notrx;
			

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_daftar_pso->load_data_daftar_pembayaran_sales_order($post)->row();
			}
	
			$this->_view('daftar_pembayaran_sales_order_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_vendor_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_vendor_option')
		{
			unset($post['action']);

			$get_vendor_option = $this->db_daftar_pso->get_vendor_option();

			if ($get_vendor_option->num_rows() > 0) 
			{
				$result = $get_vendor_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_kas_bank_option()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_kas_bank_option')
		{
			unset($post['action']);

			$get_kas_bank_option = $this->db_daftar_pso->get_kas_bank_option();

			if ($get_kas_bank_option->num_rows() > 0) 
			{
				$result = $get_kas_bank_option->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_sales_order_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_sales_order_data')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$get_sales_order_data = $this->db_daftar_pso->get_sales_order_data($post);
			if ($get_sales_order_data->num_rows() > 0) 
			{
				$result = $get_sales_order_data->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$number++;
					$v->no = $number;
					$v->so_qty = number_format($v->so_qty);
					$sum[] = $v->so_total_amount;
					$v->so_total_amount_so = $v->so_total_amount;
					$v->so_total_amount = 'Rp. '.number_format($v->so_total_amount);
					$v->so_created_date = date('d-m-Y', strtotime($v->so_created_date));
				}
				$array_sum = array_sum($sum);
				// print_r($array_sum);exit;
				echo json_encode(array('success' => TRUE, 'data' => $result,'total_amount' => 'Rp. '.number_format($array_sum),'amount' => $array_sum));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function load_data_temporary_detail_so()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_temporary_detail_so')
		{
			// print_r($_POST);exit;
			$post = $this->input->post(NULL, TRUE);
			$load_data_detail_so = $this->db_daftar_pso->load_data_detail_so($post);
			if ($load_data_detail_so->num_rows() > 0) 
			{
				$result = $load_data_detail_so->result();
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

	public function store_data_daftar_pembayaran_sales_order()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_daftar_pembayaran_sales_order')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$params = array();
			$i=0;
			foreach($post['bayar_so'] as $k => $v)
			{
				if(! empty($v))
				{
					$key_lock = str_replace('/','',$post['last_notrx']);
					$key_lock = $key_lock.'_'.$i;
					$params = array(
						'sop_no_trx' => $post['last_notrx'],
						'sop_so_no_trx' => $post['so_no_trx'][$i],
						'sop_key_lock' => $key_lock,
						'sop_created_date' => date('Y-m-d',strtotime($post['so_created_date'])),
						'sop_type_pay' => $post['sop_type_pay'],
						'mode' => $post['mode']
					); 
					$store_data_daftar_pembayaran_sales_order = $this->db_daftar_pso->store_data_daftar_pembayaran_sales_order($params);

					$new_params = array(
						'so_is_pay' => 'LN',
						'so_no_trx' => $post['so_no_trx'][$i]
					);
					
					$update_status_so = $this->db_daftar_pso->update_status_sales_order($new_params);

					$trx_params = array(
						'trx_no_trx' => $post['last_notrx'],
						'trx_key_lock' => $key_lock,

					);
					$insert_to_trx = $this->db_daftar_pso->store_data_ref_trx($trx_params);


					$i++;					
				}
			}

			$load_data = $this->db_daftar_pso->load_data_daftar_pembayaran_sales_order();
			
			if ($load_data->num_rows() > 0) 
			{
				$result = $load_data->result();
				$number = 1;

				foreach ($result as $k => $v)
				{					
					$v->no = $number;
					$v->sop_created_date = date('d-m-Y',strtotime($v->sop_created_date));	
					$v->so_total_amount = number_format($v->so_total_amount);	

					$number++;
				}

				// print_r($result);exit;
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function store_data_ref_trx($params = array())
	{
		if (isset($params['action']) && $params['action'] == 'store_data_ref_trx')
		{
			// $params = $this->input->post(NULL, TRUE);
			// print_r($params);exit;
			$params['cid_ci_no_trx'] = $params['ci_no_trx_temp'];
			

			$cek_temp_data = $this->db_cash_in->load_data_cash_in_detail($params);

			if($cek_temp_data->num_rows() > 0) 
			{
				$temp_result = $cek_temp_data->result();
				foreach($temp_result as $k => $v)
				{
					$cek_trx_data = $this->db_cash_in->cek_ref_transaksi($v->cid_key_lock);
					if($cek_trx_data->num_rows() > 0)
					{
						$new_params = array(
							// 'trx_no_trx' => $params['ci_no_trx_temp'],
							'trx_rad_id_from' => $v->cid_rad_id,
							'trx_rad_id_to' => $params['ci_rad_id'],
							'trx_total' => $v->cid_total,
							'trx_created_date' => $params['ci_created_date'],	
						);

						$cond = array(
							'trx_key_lock' => $v->cid_key_lock,
							'mode' => $params['mode'],
						);				

					}
					else
					{
						$new_params = array(
							'trx_no_trx' => $params['ci_no_trx_temp'],
							'trx_rad_id_from' => $v->cid_rad_id,
							'trx_rad_id_to' => $params['ci_rad_id'],
							'trx_total' => $v->cid_total,
							'trx_created_date' => $params['ci_created_date'],	
							'trx_key_lock' => $v->cid_key_lock,	
						);

						$cond = array(
							'trx_key_lock' => $v->cid_key_lock,
							'mode' =>'add',
						);
					}
			
			// print_r($new_params);
			// print_r($cond);exit;
					$store_data_kas_masuk = $this->db_cash_in->store_data_ref_trx($new_params,$cond);
				}
			}

		}
		else $this->show_404();
	}

	public function delete_data_item()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_item = $this->db_daftar_pso->delete_data_item($post);

			if ($delete_data_item->num_rows() > 0) 
			{
				$result = $delete_data_item->result();
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

	public function delete_data_temp()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_temp')
		{
			$post = $this->input->post(NULL, TRUE);
			$delete_data_sod = $this->db_daftar_pso->delete_data_so_detail($post);

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