<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/projects/controllers/Material_consumption.php
 */

class Material_consumption extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('projects/material_consumption_model', 'db_material_consumption');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Material Consumption';
		$this->store_params['pages_title'] = 'Material Consumption Data';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('projects/material_consumption', 'Material Consumption')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('vendors/jquery-datetimepicker/css/bootstrap-datetimepicker.min.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/projects/material_consumption.js').'"></script>',
			'<script src="'.base_url('vendors/jquery-datetimepicker/js/bootstrap-datetimepicker.js').'"></script>'
		);
		$this->store_params['projects'] = $this->db_material_consumption->get_option(array('p_is_active' => 'Y'),'projects')->result();

		$this->view('material_consumption_view');
	}

	public function get_projects_sub()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_sub_data')
		{
			$success = FALSE;
			$get_data = $this->db_material_consumption->get_option(array('ps_is_active' => 'Y','ps_p_id' => $_POST['p_id']),'projects_sub');

			if ($get_data && $get_data->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_data->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_data')
		{
			$success = FALSE;
			$get_data = $this->db_material_consumption->get_data();

			if ($get_data && $get_data->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_data->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function show_material()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'show_material')
		{
			$success = FALSE;
			$get_data = $this->db_material_consumption->get_data_material($_POST);
			if($get_data && $get_data->num_rows() > 0)
			{	
				$data = $get_data->result();
				$num = 0;
				foreach($data as $k => $v)
				{
					$num++;

					$v->num = $num;
					$v->mc_date_order = date('d M Y, H:i:s',strtotime($v->mc_date_order));
					$v->mc_price = number_format($v->mc_price);

				}

				echo json_encode(array('success' => TRUE, 'data' => $data));
			}
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_sub_data()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'get_sub_data')
		{
			$success = FALSE;
			
			$get_sub = $this->db_material_consumption->get_sub_data(array('ps.ps_p_id' => $_POST['p_id']));
			
			if ($get_sub->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_sub->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function popup_projects()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_material_consumption->get_data(array('p_id' => $post['data']))->row();
			}

			$this->_view('material_consumption_form_view', $post);
		}
		else $this->show_404();
	}

	public function popup_material()
	{
		$post = $this->input->post(NULL, TRUE);
		
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);

			$post['projects'] = $this->db_material_consumption->get_option(array('p_is_active' => 'Y','p_id' => $post['p_id']),'projects')->row();
			
			$post['projects_sub'] = $this->db_material_consumption->get_option(array('ps_is_active' => 'Y','ps_id' => $post['ps_id']),'projects_sub')->row();
			$post['material'] = $this->db_material_consumption->get_option(array('il_is_active' => 'Y'),'item_list')->result();

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_material_consumption->get_sub_data(array('ps.ps_id' => $post['id']))->row();
			}
			
			$this->_view('material_consumption_form_view', $post);
		}
		else $this->show_404();
	}

	public function store_data_material()
	{
		$post = $this->input->post(NULL, TRUE);
		
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data_material')
		{
			unset($post['action']);

			if(isset($post['p_id']) && $post['p_id'] !== "")
			{
				$store_data = $this->db_material_consumption->store_data_material($post);
			}
			else
			{
				$store_data = $this->db_material_consumption->store_data_material($post);	
			}

			echo json_encode(array('success' => $store_data,'p_id' => $post['p_id']));
		}
		else $this->show_404();
	}

	public function store_data_projects_sub()
	{
		$post = $this->input->post(NULL, TRUE);
		
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data_projects_sub')
		{
			unset($post['action']);

			if(isset($post['ps_id']) && $post['ps_id'] !== "")
			{
				$store_data = $this->db_material_consumption->store_data_projects_sub($post);
			}
			else
			{
				$store_data = $this->db_material_consumption->store_data_projects_sub($post);	
			}

			echo json_encode(array('success' => $store_data,'p_id' => $post['ps_p_id']));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'delete_data')
		{
			unset($post['action']);

			$delete_data = $this->db_material_consumption->delete_data($post,$post['mode']);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

}