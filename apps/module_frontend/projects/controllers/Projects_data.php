<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/projects/controllers/Projects_data.php
 */

class Projects_data extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('projects/projects_data_model', 'db_projects_data');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Projects Data';
		$this->store_params['pages_title'] = 'Projects Data List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('projects/projects_data', 'Projects Data')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/projects/projects_data.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('projects_data_view');
	}

	public function get_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_data')
		{
			$success = FALSE;
			$get_data = $this->db_projects_data->get_data();

			if ($get_data && $get_data->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_data->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_sub_data()
	{
		// print_r($_POST);exit;
		if (isset($_POST['action']) && $_POST['action'] == 'get_sub_data')
		{
			$success = FALSE;
			
			$get_sub = $this->db_projects_data->get_sub_data(array('ps.ps_p_id' => $_POST['p_id']));
			
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
				$post['data'] = $this->db_projects_data->get_data(array('p_id' => $post['data']))->row();
			}

			$this->_view('projects_data_form_view', $post);
		}
		else $this->show_404();
	}

	public function popup_projects_sub()
	{
		$post = $this->input->post(NULL, TRUE);
		
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);

			$post['projects'] = $this->db_projects_data->get_option_unit(array('p_is_active' => 'Y'),'projects')->result();
			$post['building'] = $this->db_projects_data->get_option_unit(array('bt_is_active' => 'Y'),'building_type')->result();

			if($post['mode'] == 'edit')
			{
				$post['data'] = $this->db_projects_data->get_sub_data(array('ps.ps_id' => $post['id']))->row();
			}
			
			$this->_view('projects_sub_data_form_view', $post);
		}
		else $this->show_404();
	}

	public function store_data_projects()
	{
		$post = $this->input->post(NULL, TRUE);
		
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data_projects')
		{
			unset($post['action']);

			if(isset($post['p_id']) && $post['p_id'] !== "")
			{
				$store_data = $this->db_projects_data->store_data_projects($post);
			}
			else
			{
				$store_data = $this->db_projects_data->store_data_projects($post);	
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
				$store_data = $this->db_projects_data->store_data_projects_sub($post);
			}
			else
			{
				$store_data = $this->db_projects_data->store_data_projects_sub($post);	
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

			$delete_data = $this->db_projects_data->delete_data($post,$post['mode']);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

}