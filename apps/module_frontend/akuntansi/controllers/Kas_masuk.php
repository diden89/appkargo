<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/module_frontend/akuntansi/controllers/Kas_masuk.php
 */

class Kas_masuk extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('akuntansi/kas_masuk_model', 'db_cash_in');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Daftar Kas Masuk';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('akuntansi/kas_masuk', 'Kas Masuk')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/akuntansi/kas_masuk.js').'"></script>',
		);

		$this->store_params['item'] = [];
		$date = date('d-m-Y');
		$date = strtotime($date);
		$date = strtotime("-7 day", $date);
		
		$params['date_range1'] = date('Y-m-d', $date);
		$params['date_range2'] = date('Y-m-d');
		
		$load_data_kas_masuk = $this->db_cash_in->load_data_kas_masuk($params);

		if ($load_data_kas_masuk->num_rows() > 0)
		{
			$num = 0;
			$result = $load_data_kas_masuk->result();

			foreach ($result as $k => $v)
			{
				$num++;

				$v->num = $num;
				$v->ci_total = number_format($v->ci_total);
			}
			
			$this->store_params['item'] = $result;
		}
		$this->store_params['date_range1'] = date('Y-m-d', $date);

		$this->view('kas_masuk_view');
	}

	public function load_kas_masuk_form()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_kas_masuk_form')
		{
			$post = $this->input->post(NULL, TRUE);

			$post['kas_bank'] = $this->db_cash_in->get_kas_bank()->result();
			$post['akun_header'] = $this->db_cash_in->get_akun_header()->result();

			$get_last_notrx = $this->db_cash_in->get_last_notrx();

			if($get_last_notrx->num_rows() > 0)
			{
				$notrx = $get_last_notrx->row();
				$last_notrx = $notrx->notrx + 1;
			}
			else
			{
				$last_notrx = 1;
			}

			$post['last_notrx'] = sprintf('%04d',$last_notrx).'/CHIN/'.date('Ymd');

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_cash_in->load_data_kas_masuk($post)->row();
			}
			else
			{
				$delete = $this->db_cash_in->delete_temp_data($post);
			}
		// print_r($post);exit;
			$this->_view('kas_masuk_form_view', $post);
		}
		else $this->show_404();
	}

	public function get_akun_header_option()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_akun_header_option')
		{
			unset($post['action']);

			$get_akun_header_option = $this->db_cash_in->get_akun_header();

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

			$get_akun_detail_option = $this->db_cash_in->get_akun_detail_option($post);

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

	public function total_amount_detail_cash_in()
	{
		$post = $this->input->post(NULL, TRUE);
		// print_r($post);exit;
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'total_amount_detail_cash_in')
		{
			unset($post['action']);

			$total_amount_detail_cash_in = $this->db_cash_in->total_amount_detail_cash_in($post);

			if ($total_amount_detail_cash_in->num_rows() > 0) 
			{
				$result = $total_amount_detail_cash_in->row();

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

			$get_amount_to = $this->db_cash_in->get_amount_kas($post,array('trx_rad_id_to' => $post['ci_rad_id']));
			$get_amount_from = $this->db_cash_in->get_amount_kas($post,array('trx_rad_id_from' => $post['ci_rad_id']));

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
			// echo $selisih;exit;
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
			if($post['cid_id'] == false)
			{
				$cek_ci_detail = $this->db_cash_in->cek_cash_in_detail($post)->row();
				
				if(!empty($cek_ci_detail->max))
				{
					$key = str_replace('/','',$post['cid_no_trx']);
					$exp = explode('_',$cek_ci_detail->max);
					$val = $exp[1];
					$val++;
					$post['cid_key_lock'] = $key.'_'.$val;
				
				}
				else
				{
					$key = str_replace('/','',$post['cid_no_trx']);
					$post['cid_key_lock'] = $key.'_1';
				}
			}
			else
			{
				$post['cid_key_lock'] = $post['key_lock'];
			}
			
			// print_r($post);exit;
			$store_temporary_data = $this->db_cash_in->store_temporary_data($post);

			if ($store_temporary_data->num_rows() > 0) 
			{
				$result = $store_temporary_data->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->cid_total = number_format($v->cid_total);

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}


	public function load_data_kas_masuk()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_kas_masuk')
		{

			$post = $this->input->post(NULL, TRUE);

			$date = date('d-m-Y');
			$date = strtotime($date);
			$date = strtotime("-7 day", $date);
			
			$post['date_range1'] = date('Y-m-d', $date);
			$post['date_range2'] = date('Y-m-d');

			$load_data_kas_masuk = $this->db_cash_in->load_data_kas_masuk($post);
			// print_r($_POST);exit;
			if ($load_data_kas_masuk->num_rows() > 0) 
			{
				$result = $load_data_kas_masuk->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->ci_created_date = date('d-m-Y',strtotime($v->ci_created_date));
					$v->ci_total = number_format($v->ci_total);
					
					$number++;
				}

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function load_data_cash_in_detail()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'load_data_cash_in_detail')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$load_data_detail_so = $this->db_cash_in->load_data_cash_in_detail($post);
			if ($load_data_detail_so->num_rows() > 0) 
			{
				$result = $load_data_detail_so->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->cid_total = number_format($v->cid_total);

					$number++;
				}
				
			// print_r($result);exit;
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function store_data_kas_masuk()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'store_data_kas_masuk')
		{
			$post = $this->input->post(NULL, TRUE);
		// print_r($post);exit;

			// print_r($store_data_kas_masuk->result());exit;
			$store_data_ref_trx = $this->store_data_ref_trx($post);

			$date = date('d-m-Y');
			$date = strtotime($date);
			$date = strtotime("-7 day", $date);
			
			$params['date_range1'] = date('Y-m-d', $date);
			$params['date_range2'] = date('Y-m-d');

			$store_data_kas_masuk = $this->db_cash_in->store_data_kas_masuk($post);

			if ($store_data_kas_masuk->num_rows() > 0) 
			{
				$result = $store_data_kas_masuk->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->ci_created_date = date('d-m-Y',strtotime($v->ci_created_date));
					$v->ci_total = number_format($v->ci_total);

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
		if (isset($params['action']) && $params['action'] == 'store_data_kas_masuk')
		{
			$params['cid_ci_no_trx'] = $params['ci_no_trx_temp'];
			
			$cek_temp_data = $this->db_cash_in->get_cash_in_detail($params);
			
			if($cek_temp_data->num_rows() > 0) 
			{
				$temp_result = $cek_temp_data->result();
				foreach($temp_result as $k => $v)
				{
					$cek_trx_data = $this->db_cash_in->cek_ref_transaksi($v->cid_key_lock);
					
					if($cek_trx_data->num_rows() > 0)
					{
						$trx_result = $cek_trx_data->result();
						$n=0;
						foreach($trx_result as $trx_key => $val_trx)
						{
							if($n==0)
							{
								$val['rad_id_to'] = $params['ci_rad_id'];
							}
							else
							{
								$val['rad_id_to'] =  $v->cid_rad_id;
							}

							$new_params = array(
								'trx_rad_id_from' => $v->cid_rad_id,
								'trx_rad_id_to' => $val['rad_id_to'],
								'trx_total' => $v->cid_total,
								'trx_created_date' => $params['ci_created_date'],	
							);	
													
							$cond = array(
								'trx_id' => $val_trx->trx_id,
								'mode' => $params['mode'],
							);

							$store_data_kas_masuk = $this->db_cash_in->store_data_ref_trx($new_params,$cond);
							$n++;				
						}
					}
					else
					{
						for($i=0;$i<=1;$i++)
						{
							if($i==0)
							{
								$val['rad_id_to'] = $params['ci_rad_id'];
							}
							else
							{
								$val['rad_id_to'] =  $v->cid_rad_id;
							}
							$new_params = array(
								'trx_no_trx' => $params['ci_no_trx_temp'],
								'trx_rad_id_from' => $v->cid_rad_id,
								'trx_rad_id_to' => $val['rad_id_to'],
								'trx_total' => $v->cid_total,
								'trx_created_date' => $params['ci_created_date'],	
								'trx_key_lock' => $v->cid_key_lock,	
							);

							$cond = array(
								'mode' =>'add',
							);

							$store_data_kas_masuk = $this->db_cash_in->store_data_ref_trx($new_params,$cond);
						}
					}
				}
			}

		}
		else $this->show_404();
	}

	public function delete_data_temp_cash_in()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_temp_cash_in')
		{
			$post = $this->input->post(NULL, TRUE);

			$date = date('d-m-Y');
			$date = strtotime($date);
			$date = strtotime("-7 day", $date);
			
			$post['date_range1'] = date('Y-m-d', $date);
			$post['date_range2'] = date('Y-m-d');

			$delete_data_cash_in_detail = $this->db_cash_in->delete_data_cash_in_detail($post);
			$delete_data_cash_in = $this->db_cash_in->delete_data_cash_in($post);

			if ($delete_data_cash_in->num_rows() > 0) 
			{
				$result = $delete_data_cash_in->result();
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

	public function delete_data_item()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$date = date('d-m-Y');
			$date = strtotime($date);
			$date = strtotime("-7 day", $date);
			
			$post['date_range1'] = date('Y-m-d', $date);
			$post['date_range2'] = date('Y-m-d');

			$delete_data_ref_transaksi = $this->db_cash_in->delete_data_ref_transaksi($post);
			$delete_data_cash_in_detail = $this->db_cash_in->delete_data_cash_in_detail($post);
			$delete_data_cash_in = $this->db_cash_in->delete_data_cash_in($post);

			if ($delete_data_cash_in->num_rows() > 0) 
			{
				$result = $delete_data_cash_in->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->ci_created_date = date('d-m-Y',strtotime($v->ci_created_date));
					$v->ci_total = number_format($v->ci_total);

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
			$delete_data_ref_transaksi = $this->db_cash_in->delete_data_ref_transaksi($post);
			$delete_data_cash_in_detail = $this->db_cash_in->delete_data_cash_in_detail($post);
			$load_cash_in_detail = $this->db_cash_in->load_data_cash_in_detail($post);
			
			if ($load_cash_in_detail->num_rows() > 0) 
			{
				$result = $load_cash_in_detail->result();
				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;
					$v->cid_total = number_format($v->cid_total);

					$number++;
				}
				
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!','data' => array()));
		}
		else $this->show_404();
	}
}