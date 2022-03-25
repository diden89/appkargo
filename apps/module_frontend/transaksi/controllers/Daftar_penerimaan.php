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
		$this->load->model('transaksi/daftar_penerimaan_model', 'db_dp');
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

		$cek_driver_akses = $this->db_dp->cek_driver_akses($params);

		if($cek_driver_akses->num_rows() > 0)
		{
			$is_driver = 'Y';
		}
		else
		{
			$is_driver = 'N';
		}	

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
			'<script src="'.base_url('scripts/transaksi/daftar_penerimaan.js').'"></script>',
			'<script>
				var is_driver = "'.$is_driver.'";
			</script>',
		);

		$this->view('daftar_penerimaan_view');
	}

	public function load_data()
	{
		$params['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['action']) && $_POST['action'] == 'load_data')
		{
			$post = $this->input->post(NULL, TRUE);

			$cek_driver_akses = $this->db_dp->cek_driver_akses($params);
			// echo $cek_driver_akses->num_rows();exit;
			if($cek_driver_akses->num_rows() > 0)
			{
				$post['akses_driver'] = $params['user_id'];
			}
			else
			{
				$post['akses_driver'] = "";
			}	
			// print_r($post);exit;

			$post['date_range1'] = (! empty($post['date_range1'])) ? date('Y-m-d',strtotime($post['date_range1'])) : date('Y-m-01');
			$post['date_range2'] = (! empty($post['date_range2'])) ? date('Y-m-d',strtotime($post['date_range2'])) : date('Y-m-t');
			$load_data = $this->db_dp->load_data_daftar_penerimaan($post);
			
			// print_r($load_data);exit;
			$number = 1;

			foreach ($load_data->data as $k => $v) 
			{
				$v->no = $number;
				$v->d_name_pengemudi = $v->d_name.' / '.$v->ve_license_plate;
				$v->d_address_area = $v->c_address.'<br>Kec. '.$v->rsd_name;
				$v->dod_shipping_qty = number_format($v->dod_shipping_qty);
				$v->dos_filled_show = number_format($v->dos_filled);
				$v->dod_created_date = date('d-m-Y',strtotime($v->dod_created_date));
				$v->dos_created_date = date('d-m-Y H:i:s',strtotime($v->dos_created_date));
				$v->so_tipe_show = ($v->so_tipe == 'so') ? 'NEW ORDER' : 'TRANSFER';

				if(! empty($v->dos_filled)) 
				{
					$v->new_ongkir = number_format($v->dos_ongkir);
					$v->dod_is_status = $v->dos_status;
				}
				else
				{
					$v->new_ongkir = 0;
					$v->dod_is_status = $v->dod_is_status;
				}

				$number++;
			}
		// print_r($load_data);exit;
			echo json_encode($load_data);
		}
		else $this->show_404();
	}
	
	public function load_update_status_form()
	{
		$new_params['user_id'] = $this->session->userdata('user_id');

		if (isset($_POST['action']) && $_POST['action'] == 'load_update_status_form')
		{
			$post = $this->input->post(NULL, TRUE);
			// print_r($post);exit;
			$cek_driver_akses = $this->db_dp->cek_driver_akses($new_params);
			if($cek_driver_akses->num_rows() > 0)
			{
				$post['akses_driver'] = $new_params['user_id'];
			}
			else
			{
				$post['akses_driver'] = "";
			}
			if($post['data']['so_tipe'] == 'so') 
			{
				$post['val'] = $this->db_dp->load_data_form_order($post['data'])->row();
			}
			else 
			{
				$post['val'] = $this->db_dp->load_data_form_transfer($post['data'])->row();
			} 
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
			$load_data_detail_do = $this->db_dp->load_data_detail_do($post);
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
			$post['dod_is_status'] = 'SELESAI';
			$post['total_terpenuhi'] = str_replace(',', '',$post['total_terpenuhi']);
			// print_r($post);exit;
			$cek_driver_akses = $this->db_dp->cek_driver_akses($new_params);
			
			$post['akses_driver'] = ($cek_driver_akses->num_rows() > 0) ? $new_params['user_id'] : "";
			
			if($post['tipe'] == 'so')
			{
				$input_to_penerimaan_status = $this->db_dp->store_penerimaan_status_order($post);

				// print_r($post);exit;


				// print_r($post);exit;
				$get_detail_do = $this->db_dp->get_detail_do($post)->row();

				if($post['total_terpenuhi'] !== $get_detail_do->dod_shipping_qty)
				{
					$get_detail_so = $this->db_dp->get_detail_so($post)->row();

					$upd_qty = $post['dod_shipping_qty_old'] - $post['total_terpenuhi'];

					$post['upd_qty_realisasi'] = $get_detail_do->sod_realisasi - $upd_qty;

					$post['upd_new_ongkir'] = $get_detail_so->so_total_amount - $post['total_ongkir_upd_hidden'] ;
					$post['sod_id'] = $get_detail_do->sod_id;

					$update_status_sod = $this->db_dp->store_update_status_sales_order_detail($post);			
				}


				$update_status = $this->db_dp->store_update_status_penerimaan_order($post); //update status

				$get_total_do = $this->db_dp->get_total_do($post,'total')->row();
				$get_total_sod = $this->db_dp->get_total_sod_total($post)->row();

				
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
				
				
				$update_status_so = $this->db_dp->store_update_status_sales_order($post);

				echo json_encode(array('success' => $update_status));
			}
			else
			{
				$input_to_penerimaan_status = $this->db_dp->store_penerimaan_status_transfer($post);

				$cek_driver_akses = $this->db_dp->cek_driver_akses($new_params);
			
				$update_status = $this->db_dp->store_update_status_penerimaan_transfer($post); //update status

				$get_total_do = $this->db_dp->get_total_do_transfer($post,'total')->row();
				$get_total_sod = $this->db_dp->get_total_sod_total($post)->row();
				
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
				$update_status_sales_order = $this->db_dp->store_update_status_sales_order($post);

				echo json_encode(array('success' => $update_status));
			}
		}
		else $this->show_404();
	}

}