<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/controllers/User.php
 */

class Menu_access_user extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('settings/menu_access_user_model', 'db_mau');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Menu Access User';
		$this->store_params['pages_title'] = 'Access User List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('settings/menu_access_user', 'Menu Access User')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/settings/menu_access_user.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('menu_access_user_view');
	}

	public function get_user_group()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_user_group')
		{
			$success = FALSE;
			$get_user_group = $this->db_mau->get_user_group(array('ug_is_active' => 'Y'));

			$option = array();

			if($get_user_group && $get_user_group->num_rows() > 0)
			{
				foreach ($get_user_group->result() as $k => $v) {
					$option[] = '<option value="'.$v->ug_id.'">'.$v->ug_caption.'</option>';
				}
				echo json_encode(array('success' => TRUE, 'data' => $option));
			}else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_user_detail()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_user_detail')
		{
			$success = FALSE;
			$get_user_detail = $this->db_mau->get_user_detail(array('ud.ud_is_active' => 'Y','ug.ug_id' => $_POST['ug_id']));

			if ($get_user_detail && $get_user_detail->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_user_detail->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_menu_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_menu_data')
		{
			$success = FALSE;
			
			$get_user_access = $this->db_mau->get_access_user(array('mau_is_active' => 'Y','mau_user_id' => $_POST['ud_id']));
			
			$get_menu = $this->db_mau->get_menu(array('rm_is_active' => 'Y'));
			
			$menu = array();

			if($get_user_access->num_rows() > 0)
			{
				$get_a_menu = array();
				$t=0;
				foreach($get_user_access->result() as $k => $v)
				{
					$get_a_menu[$v->mau_id] = $v->mau_menu_id;
					$t++;
				}
				
				$i=0;
				foreach($get_menu->result() as $gm => $mn)
				{		
					$check = array_search($mn->rm_id, $get_a_menu) ? 'checked' : '';
					$mau_id = array_search($mn->rm_id, $get_a_menu) ? array_search($mn->rm_id, $get_a_menu) : '';
					$menu[$i] = (object) array(
						'rm_id' => $mn->rm_id,
						'rm_parent_id' =>$mn->rm_parent_id,
						'rm_caption' =>$mn->rm_caption,
						'mau_id' => $mau_id,
						'checked' => $check,
					);						
					$i++;
				}
			}
			else
			{
				$i=0;
				foreach($get_menu->result() as $gm => $mn)
				{		
					$menu[$i] = (object) array(
						'rm_id' => $mn->rm_id,
						'rm_parent_id' =>$mn->rm_parent_id,
						'rm_caption' =>$mn->rm_caption,
						'mau_id' => '',
						'checked' => '',
					);						
					$i++;
				}
			}

			if (count($menu) > 0) echo json_encode(array('success' => TRUE, 'data' => $menu));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);
		
		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

			if(isset($post['mau_id']))
			{
				$delete = $this->db_mau->delete_access_user($post);

				$params = array();
				$store_data = TRUE;
				if(isset($post['rm_id'])){
					foreach ($post['rm_id'] as $k => $v) {
						$params = array(
							'mau_user_id' => $post['ud_id'],
							'mau_menu_id' => $v,
						);
						$cek_am = $this->db_mau->cek_access_user($params);
						if($cek_am->num_rows() > 0)
						{
							$get_am = $cek_am->row();
							$params['mode'] = 'edit';
							$params['mau_id'] = $get_am->mau_id;
							
							// print_r($params);
							$store_data = $this->db_mau->store_data($params);
						}
						else
						{
							$params['mode'] = 'add';
							$store_data = $this->db_mau->store_data($params);
						}
					}
				}

			}
			else
			{
				foreach ($post['rm_id'] as $k => $v) {
					$params = array(
						'mau_user_id' => $post['ud_id'],
						'mau_menu_id' => $v,
						'mode' => 'add',
					);
					
					$params['mode'] = 'add';
					$store_data = $this->db_mau->store_data($params);	
				}
			}

			echo json_encode(array('success' => $store_data,'ud_id' => $post['ud_id']));
		}
		else $this->show_404();
	}

}