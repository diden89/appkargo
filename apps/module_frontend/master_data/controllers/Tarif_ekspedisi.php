<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/master_data/controllers/Tarif_ekspedisi.php
 */

class Tarif_ekspedisi extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master_data/Tarif_ekspedisi_model', 'db_tem');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Menu Access User';
		$this->store_params['pages_title'] = 'Access User List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('master_data/tarif_ekspedisi', 'Tarif Ekspedisi')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/master_data/tarif_ekspedisi.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('tarif_ekspedisi_view');
	}

	public function get_provinsi()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_provinsi')
		{
			$success = FALSE;
			$get_provinsi = $this->db_tem->get_provinsi(array('rp_is_active' => 'Y'));

			$option = array();

			if($get_provinsi && $get_provinsi->num_rows() > 0)
			{
				foreach ($get_provinsi->result() as $k => $v) {
					$option[] = '<option value="'.$v->rp_id.'">'.$v->rp_name.'</option>';
				}
				echo json_encode(array('success' => TRUE, 'data' => $option));
			}else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_district()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_district')
		{
			$success = FALSE;
			$get_district = $this->db_tem->get_district(array('rd.rd_is_active' => 'Y','rp.rp_id' => $_POST['rp_id']));

			if ($get_district && $get_district->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_district->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_kec_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_kec_data')
		{
			$success = FALSE;
			
			$get_shipping_data = $this->db_tem->get_shipping_data(array('sh_is_active' => 'Y','sh_rd_id' => $_POST['rd_id']));
			
			$get_kec_data = $this->db_tem->get_kec_data(array('rsd_is_active' => 'Y','rsd_district_id' => $_POST['rd_id']));
			
			$kec = array();

			if($get_kec_data->num_rows() > 0)
			{
				$get_s_district = array();
				$get_a_district = array();
				$t=0;
				foreach($get_shipping_data->result() as $k => $v)
				{
					$get_s_district[$v->sh_cost] = $v->sh_rsd_id;
					$get_a_district[$v->sh_id] = $v->sh_rsd_id;
					// $get_s_district[$t]['sh_cost'] = $v->sh_cost;
					$t++;
				}
				// print_r($get_s_district);exit;
				$i=0;
				foreach($get_kec_data->result() as $gm => $mn)
				{		
					$sh_cost = array_search($mn->rsd_id, $get_s_district) ;
					$sh_id = array_search($mn->rsd_id, $get_a_district) ? array_search($mn->rsd_id, $get_a_district) : '';
					
					$kec[$i] = (object) array(
						'rsd_id' => $mn->rsd_id,
						'rsd_name' =>$mn->rsd_name,
						'sh_id' => $sh_id,
						'sh_cost' => $sh_cost,
						// 'checked' => $check,
					);						
					$i++;
				}
			}
			else
			{
				$i=0;
				foreach($get_kec_data->result() as $gm => $mn)
				{		
					$kec[$i] = (object) array(
						'rsd_id' => $mn->rsd_id,
						'rsd_name' =>$mn->rsd_name,
						'sh_cost' => '',
						'sh_id' => '',
						'checked' => '',
					);						
					$i++;
				}
			}
			// print_r($kec);
			// exit;
			if (count($kec) > 0) echo json_encode(array('success' => TRUE, 'data' => $kec));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);
		// print_r($post);exit;
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

			if(isset($post['sh_id']))
			{
				$delete = $this->db_tem->delete_access_user($post);

				$params = array();
				$store_data = TRUE;
				if(isset($post['rsd_id'])){
					foreach ($post['rsd_id'] as $k => $v) {
						$params = array(
							'sh_rsd_id' => $post['rsd_id'],
							'mau_menu_id' => $v,
						);
						$cek_am = $this->db_tem->cek_access_user($params);
						if($cek_am->num_rows() > 0)
						{
							$get_am = $cek_am->row();
							$params['mode'] = 'edit';
							$params['mau_id'] = $get_am->mau_id;
							
							// print_r($params);
							$store_data = $this->db_tem->store_data($params);
						}
						else
						{
							$params['mode'] = 'add';
							$store_data = $this->db_tem->store_data($params);
						}
					}
				}

			}
			else
			{
				foreach ($post['rsd_id'] as $k => $v) {
					$params = array(
						'mau_user_id' => $post['ud_id'],
						'mau_menu_id' => $v,
						'mode' => 'add',
					);
					
					$params['mode'] = 'add';
					$store_data = $this->db_tem->store_data($params);	
				}
			}

			echo json_encode(array('success' => $store_data,'ud_id' => $post['ud_id']));
		}
		else $this->show_404();
	}

}