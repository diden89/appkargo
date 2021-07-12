<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/controllers/User.php
 */

class User extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('settings/user_model', 'db_user');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'User';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('settings/user', 'User')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/settings/user.js').'"></script>'
		);


		$this->view('user_view');
	}

	public function get_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_data')
		{
			$get_data = $this->db_user->get_data($post);

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
			$get_autocomplete_data = $this->db_user->get_autocomplete_data($post);

			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}

	public function popup_modal()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);

			$post['user_group'] = $this->get_user_group();

			$this->_view('user_popup_modal_view', $post);
		}
		else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

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

			$store_data = $this->db_user->store_data($post);

			echo json_encode(array('success' => $store_data));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'delete_data')
		{
			unset($post['action']);

			$delete_data = $this->db_user->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

	public function get_user_sub_group()
	{
		$post = $this->input->post(NULL, TRUE);


		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_user_sub_group')
		{
			unset($post['action']);

			$get_user_sub_group = $this->db_user->get_user_sub_group($post);

			if ($get_user_sub_group->num_rows() > 0) 
			{
				$result = $get_user_sub_group->result();

				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
		}
		else $this->show_404();
	}

	private function get_user_group()
	{
		$get_user_group = $this->db_user->get_user_group();

		return $get_user_group->result();
	}

	private function update_user_menu($ud_id)
	{
		$delete_all_menu = $this->db_user->delete_all_menu($ud_id);

		if ($delete_all_menu) 
		{
			$get_menu_access_sub_group = $this->db_user->get_menu_access_sub_group($ud_id);

			$success = FALSE;

			if ($get_menu_access_sub_group->num_rows() > 0) 
			{
				$result = $get_menu_access_sub_group->result_array();

				foreach ($result as $k => $v) 
				{
					$success = $this->db_user->store_menu_access($v);
				}

				return $success;
			}
			else exit(json_encode(array('success' => FALSE, 'msg' => 'No menus were found for users with this access group.')));
		}
		else exit(json_encode(array('success' => FALSE, 'msg' => 'An error occurred, please contact the system administrator.')));
	}
}