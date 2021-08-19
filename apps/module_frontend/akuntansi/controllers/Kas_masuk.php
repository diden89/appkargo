<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/akuntansi/controllers/Kas_Keluar.php
 */

class Kas_Keluar extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('akuntansi/kas_keluar_model', 'db_cash_out');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Daftar Kas Keluar';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('akuntansi/kas_keluar', 'Kas Keluar')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/akuntansi/kas_keluar.js').'"></script>',
		);

		$this->store_params['item'] = [];
		$date = date('d-m-Y');
		$date = strtotime($date);
		$date = strtotime("-7 day", $date);
		
		$params['date_range1'] = date('Y-m-d', $date);
		$params['date_range2'] = date('Y-m-d');
		
		$load_data_kas_keluar = $this->db_cash_out->load_data_kas_keluar($params);

		if ($load_data_kas_keluar->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_kas_keluar->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
				$v->co_total = number_format($v->co_total);
			}
			
			$this->store_params['item'] = $result;
		}
		$this->store_params['date_range1'] = date('Y-m-d', $date);

		$this->view('kas_keluar_view');
	}

	public function load_kas_keluar_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_kas_keluar_form')
		{
			$post = $this->input->post(NULL, TRUE);
			$params = array(
				'table' => 'province'
			);

			$post['kas_bank'] = $this->db_cash_out->get_kas_bank()->result();
			$post['akun_header'] = $this->db_cash_out->get_akun_header()->result();
			// $post['get_amount_kas'] = $this->db_cash_out->get_amount_kas()->result();
			$get_last_notrx = $this->db_cash_out->get_last_notrx();
			// $post['vendor'] = $this->db_cash_out->get_option_vendor()->result();
			// $post['item_list'] = $this->db_cash_out->get_option_item_list()->result();

			if($get_last_notrx->num_rows() > 0)
			{
				$notrx = $get_last_notrx->row();
				$last_notrx = $notrx->notrx + 1;
			}
			else
			{
				$last_notrx = 1;
			}

			$post['last_notrx'] = sprintf('%04d',$last_notrx).'/CHOUT/'.date('Ymd');

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_cash_out->load_data_kas_keluar($post)->row();
			}
			else
			{
				$delete = $this->db_cash_out->delete_temp_data($post);
			}
		// print_r($post);exit;
			$this->_view('kas_keluar_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_akun_header_option()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_akun_header_option')
		{
			unset($post['action']);

			$get_akun_header_option = $this->db_cash_out->get_akun_header();

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

			$get_akun_detail_option = $this->db_cash_out->get_akun_detail_option($post);

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

	public function total_amount_detail_cash_out()
	{
		$post = $this->input->post(NULL, TRUE);
		// print_r($post);exit;
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'total_amount_detail_cash_out')
		{
			unset($post['action']);

			$total_amount_detail_cash_out = $this->db_cash_out->total_amount_detail_cash_out($post);

			if ($total_amount_detail_cash_out->num_rows() > 0) 
			{
				$result = $total_amount_detail_cash_out->row();

				echo json_encode(array('success' => TRUE, 'total_amount' => number_format($result->total_amount)));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	public function get_amount_kas()
	{
		$post = $this->input->post(NULL, TRUE);
		// print_r($post);exit;
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_amount_kas')
		{
			unset($post['action']);

			$get_amount_to = $this->db_cash_out->get_amount_kas($post,array('trx_rad_id_to' => $post['co_rad_id']));
			$get_amount_from = $this->db_cash_out->get_amount_kas($post,array('trx_rad_id_from' => $post['co_rad_id']));

			$amount_to = '';
			$amount_from = '';
			
			if($get_amount_to->num_rows() > 0)
			{
				$to = $get_amount_to->row();
				$amount_to = $to->amount;
			}
			else
			{
				$amount_to = 0;
			}

			if($get_amount_from->num_rows() > 0)
			{
				$from = $get_amount_from->row();
				$amount_from = $from->amount;
			}
			else
			{
				$amount_from = 0;
			}

			$selisih = $amount_to - $amount_from;

			echo json_encode(array('success' => TRUE, 'amount' => number_format($selisih)));
			
		}
		else $this->show_404();
	}

	public function store_data_temporary()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'insert_temporary_data')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			if($post['cod_id'] == false)
			{
				$cek_co_detail = $this->db_cash_out->cek_cash_out_detail($post)->row();
				
				if(!empty($cek_co_detail->max))
				{
					$key = str_replace('/','',$post['cod_no_trx']);
					$exp = explode('_',$cek_co_detail->max);
					$val = $exp[1];
					$val++;
					$post['cod_key_lock'] = $key.'_'.$val;
				
				}
				else
				{
					$key = str_replace('/','',$post['cod_no_trx']);
					$post['cod_key_lock'] = $key.'_1';
				}
			}
			else
			{
				$post['cod_key_lock'] = $post['key_lock'];
			}
			
			// print_r($post);exit;
			$store_temporary_data = $this->db_cash_out->store_temporary_data($post);

			if ($store_temporary_data->num_rows() > 0) 
			{
				$result = $store_temporary_data->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->cod_total = number_format($v->cod_total);

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}


	public function load_data_kas_keluar()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_kas_keluar')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_kas_keluar = $this->db_cash_out->load_data_kas_keluar($post);
			// print_r($_POST);exit;
			if ($load_data_kas_keluar->num_rows() > 0) 
			{
				$result = $load_data_kas_keluar->result();
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

	public function load_data_cash_out_detail()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_cash_out_detail')
		{
			$post = $this->input->post(NULL, TRUE);
			$load_data_detail_so = $this->db_cash_out->load_data_cash_out_detail($post);
			if ($load_data_detail_so->num_rows() > 0) 
			{
				$result = $load_data_detail_so->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->cod_total = number_format($v->cod_total);

					$number++;
				}
				
			// print_r($post);exit;
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function store_data_kas_keluar()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_kas_keluar')
		{
			$post = $this->input->post(NULL, TRUE);

			// print_r($store_data_kas_keluar->result());exit;
			$store_data_ref_trx = $this->store_data_ref_trx($post);

			$store_data_kas_keluar = $this->db_cash_out->store_data_kas_keluar($post);

			if ($store_data_kas_keluar->num_rows() > 0) 
			{
				$result = $store_data_kas_keluar->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->co_created_date = date('d-m-Y',strtotime($v->co_created_date));
					$v->co_total = number_format($v->co_total);

					$number++;
				}

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function store_data_ref_trx($params = array())
	{
		if (isset($params['action']) && $params['action'] == 'store_data_kas_keluar')
		{
			// $params = $this->input->post(NULL, TRUE);
			// print_r($params);exit;
			$params['cod_co_no_trx'] = $params['co_no_trx_temp'];
			

			$cek_temp_data = $this->db_cash_out->load_data_cash_out_detail($params);

			if($cek_temp_data->num_rows() > 0) 
			{
				$temp_result = $cek_temp_data->result();
				foreach($temp_result as $k => $v)
				{
					$cek_trx_data = $this->db_cash_out->cek_ref_transaksi($v->cod_key_lock);
					if($cek_trx_data->num_rows() > 0)
					{
						$new_params = array(
							// 'trx_no_trx' => $params['co_no_trx_temp'],
							'trx_rad_id_from' => $params['co_rad_id'],
							'trx_rad_id_to' => $v->cod_rad_id,
							'trx_total' => $v->cod_total,
							'trx_created_date' => $params['co_created_date'],	
						);

						$cond = array(
							'trx_key_lock' => $v->cod_key_lock,
							'mode' => $params['mode'],
						);				

					}
					else
					{
						$new_params = array(
							'trx_no_trx' => $params['co_no_trx_temp'],
							'trx_rad_id_from' => $params['co_rad_id'],
							'trx_rad_id_to' => $v->cod_rad_id,
							'trx_total' => $v->cod_total,
							'trx_created_date' => $params['co_created_date'],	
							'trx_key_lock' => $v->cod_key_lock,	
						);

						$cond = array(
							'trx_key_lock' => $v->cod_key_lock,
							'mode' =>'add',
						);
					}
			
			// print_r($new_params);
			// print_r($cond);exit;
					$store_data_kas_keluar = $this->db_cash_out->store_data_ref_trx($new_params,$cond);
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

			$delete_data_ref_transaksi = $this->db_cash_out->delete_data_ref_transaksi($post);
			$delete_data_cash_out_detail = $this->db_cash_out->delete_data_cash_out_detail($post);
			$delete_data_cash_out = $this->db_cash_out->delete_data_cash_out($post);

			if ($delete_data_cash_out->num_rows() > 0) 
			{
				$result = $delete_data_cash_out->result();
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
			$delete_data_ref_transaksi = $this->db_cash_out->delete_data_ref_transaksi($post);
			$delete_data_cash_out_detail = $this->db_cash_out->delete_data_cash_out_detail($post);
			$load_cash_out_detail = $this->db_cash_out->load_data_cash_out_detail($post);
			
			if ($load_cash_out_detail->num_rows() > 0) 
			{
				$result = $load_cash_out_detail->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->cod_total = number_format($v->cod_total);

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!','data' => array()));
		}
		else $this->show_404();
	}
}