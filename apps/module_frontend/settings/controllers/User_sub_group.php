<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/controllers/User.php
 */

class User_sub_group extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('settings/user_sub_group_model', 'db_usg');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'User Sub Group';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('settings/user_group', 'User Sub Group')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/settings/user_sub_group.js').'"></script>'
		);


		$this->view('user_sub_group_view');
	}

	public function get_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_data')
		{
			$get_data = $this->db_usg->get_data($post);

			$number = 1;

			foreach ($get_data->data as $k => $v) 
			{
				$v->no = $number;

				$number++;
			}

			echo json_encode($get_data);
		}
		else $this->show_404();
	}

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_usg->get_autocomplete_data($post);

			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}

	public function popup_modal()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);

			$post['user_group'] = $this->db_usg->get_user_group()->result();

			$this->_view('user_sub_group_popup_modal_view', $post);
		}
		else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

			$store_data = $this->db_usg->store_data($post);

			echo json_encode(array('success' => $store_data));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'delete_data')
		{
			unset($post['action']);

			$delete_data = $this->db_usg->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

	private function get_user_group()
	{
		$get_user_group = $this->db_usg->get_user_group();

		return $get_user_group->result();
	}
}