<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/main/controllers/Main.php
 */

class Main extends NOOBS_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Welcome, '.$this->session->userdata('user_fullname').'!';
		$this->store_params['breadcrumb'] = array(
			array('main', 'Home', 'fas fa-home')
		);

		$params['range_1'] = date('Y-m-01');
		$params['range_2'] = date('Y-m-t');

		$total_so = $this->db_main->total_so_bulanan($params);
		if($total_so->num_rows() > 0)
		{
			$tot_so = $total_so->row();
			$total_so_bulanan = $tot_so->total_so;
		}
		else
		{
			$total_so_bulanan = 0;
		}

		$total_pendapatan = $this->db_main->total_pendapatan_bulanan($params);
		if($total_pendapatan->num_rows() > 0)
		{
			$tot_pend = $total_pendapatan->row();
			$total_pendapatan_bulanan = $tot_pend->total_pendapatan;
		}
		else
		{
			$total_pendapatan_bulanan = 0;
		}

		$total_kendaraan = $this->db_main->total_kendaraan($params);
		if($total_kendaraan->num_rows() > 0)
		{
			$tot_kendaraan = $total_kendaraan->row();
			$total_transport = $tot_kendaraan->total_kendaraan;
		}
		else
		{
			$total_transport = 0;
		}

		// $total_rekanan = $this->db_main->total_rekanan($params);
		// if($total_rekanan->num_rows() > 0)
		// {
		// 	$tot_rekanan = $total_rekanan->row();
		// 	$total_partner = $tot_rekanan->total_rekanan;
		// }
		// else
		// {
		// 	$total_partner = 0;
		// }

		$this->store_params['so_total'] = array(
			'total' => $total_so_bulanan
		);

		$this->store_params['pendapatan_total'] = array(
			'total' => $total_pendapatan_bulanan
		);

		$this->store_params['kendaraan_total'] = array(
			'total' => $total_transport
		);

		// $this->store_params['rekanan_total'] = array(
		// 	'total' => $total_partner
		// );
		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/main/main.js').'"></script>'
		);

		if($this->session->userdata('user_group') === '1')
		{
			$this->view('main_view');
		}
		else
		{
			$this->view('main_user_view');	
		}
	}

	public function generate_chart()
	{
		$params['years'] = date('Y');
		$get_data_penghasilan = $this->db_main->get_data_penghasilan($params);
		$get_data_pengeluaran = $this->db_main->get_data_pengeluaran($params);

		if($get_data_penghasilan->num_rows() > 0)
		{
			if($get_data_pengeluaran->num_rows() > 0)
			{
				$result2 = $get_data_pengeluaran->result_array();
			}

			$result = $get_data_penghasilan->result();
			$i = 0;
			foreach($result as $k => $v)
			{
				$v->total_pengeluaran = $result2[$i]['total'];
				$i++;
			}

			$get_data_penghasilan_ytd = $this->db_main->get_data_penghasilan_ytd($params)->row();
			$get_data_pengeluaran_ytd = $this->db_main->get_data_pengeluaran_ytd($params)->row();
			// print_r($result);exit;
			echo json_encode(array('value' => $result, 'total_ytd' => 'Rp. '.number_format($get_data_penghasilan_ytd->total), 'total_pengeluaran_ytd' => 'Rp. '.number_format($get_data_pengeluaran_ytd->total)));
		}
	}
	public function profile()
	{
		$token = $this->decrypt_token();
		$get_profile = $this->db_main->get_profile($token);

		$this->store_params['header_title'] = 'User Setting';
		$this->store_params['breadcrumb'] = array(
			array('main/profile', 'Profile', 'fas fa-user')
		);

		$this->store_params['data'] = $get_profile->row_array();
		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/main/profile.js').'"></script>'
		);

		$this->view('profile_view');
	}

	public function profile_store_data()
	{
		if (isset($_POST['action']) && $this->uri->segment(3) !== FALSE)
		{
			$mode = $this->uri->segment(3);

			switch ($mode)
			{
				case 1: $this->_store_biodata(); break;
				case 2: $this->_store_login_access(); break;
			}
		}
		else
		{
			$this->show_404();
		}
	}

	private function _store_biodata()
	{
		$post = $this->input->post(NULL, TRUE);

		if ($post['action'] == 1)
		{
			if ($_FILES['file_avatar']['error'] < 1 && $_FILES['file_avatar']['size'] > 0)
			{
				$config['upload_path'] = NOOBS_IMAGES_DIR.'profiles'.DS;
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['remove_spaces'] = TRUE;
				$config['encrypt_name'] = TRUE;

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('file_avatar'))
				{
					$upload_data = $this->upload->data();
				}
			}

			if (isset($upload_data))
			{
				$post['upload_data'] = $upload_data;
			}

			$store_biodata = $this->db_main->store_biodata($post);

			echo json_encode(array('success' => $store_biodata));
		}
		else
		{
			$this->show_404();
		}
	}

	private function _store_login_access()
	{
		$post = $this->input->post(NULL, TRUE);

		if ($post['action'] == 2)
		{
			if ($post['txt_password_1'] == $post['txt_password_2'])
			{
				$store_login_access = $this->db_main->store_login_access($post);

				echo json_encode(array('success' => $store_login_access));
			}
			else
			{
				echo json_encode(array('success' => FALSE, 'msg' => 'Password and password confirm are not the same.'));
			}
		}
		else
		{
			$this->show_404();
		}
	}
}