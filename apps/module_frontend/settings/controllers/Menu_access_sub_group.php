<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/controllers/User.php
 */

class Menu_access_sub_group extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('settings/menu_access_sub_group_model', 'db_masg');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Menu Access Sub Group';
		$this->store_params['pages_title'] = 'Menu Access Sub Group List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('settings/menu_access_sub_group', 'Menu Access Sub Group')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/settings/menu_access_sub_group.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('menu_access_sub_group_view');
	}

	public function get_user_group()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_user_group')
		{
			$success = FALSE;
			$get_user_group = $this->db_masg->get_user_group(array('ug_is_active' => 'Y'));

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

	public function get_user_sub_group()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_user_sub_group')
		{
			$success = FALSE;
			$get_user_sub_group = $this->db_masg->get_user_sub_group(array('usg_is_active' => 'Y','usg_group' => $_POST['id']));

			if ($get_user_sub_group && $get_user_sub_group->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_user_sub_group->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_menu_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_menu_data')
		{
			$success = FALSE;
			
			$get_sub_group = $this->db_masg->get_access_sub_group(array('masg_is_active' => 'Y','masg_usg_id' => $_POST['usg_id']));
			
			$get_menu = $this->db_masg->get_menu(array('rm_is_active' => 'Y'));
			
			$menu = array();

			if($get_sub_group->num_rows() > 0)
			{
				$get_s_group = array();
				$t=0;
				foreach($get_sub_group->result() as $k => $v)
				{
					$get_s_group[$v->masg_id] = $v->masg_rm_id;
					$t++;
				}
				
				$i=0;
				foreach($get_menu->result() as $gm => $mn)
				{		
					$check = array_search($mn->rm_id, $get_s_group) ? 'checked' : '';
					$masg_id = array_search($mn->rm_id, $get_s_group) ? array_search($mn->rm_id, $get_s_group) : '';
					$menu[$i] = (object) array(
						'rm_id' => $mn->rm_id,
						'rm_parent_id' =>$mn->rm_parent_id,
						'rm_caption' =>$mn->rm_caption,
						'masg_id' => $masg_id,
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
						'masg_id' => '',
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

			if(isset($post['masg_id']))
			{
				$delete = $this->db_masg->delete_access_sub_group($post);

				$params = array();
				$store_data = TRUE;
				if(isset($post['rm_id'])){
					foreach ($post['rm_id'] as $k => $v) {
						$params = array(
							'masg_ug_id' => $post['ug_id'],
							'masg_usg_id' => $post['usg_id'],
							'masg_rm_id' => $v,
						);
						$cek_asg = $this->db_masg->cek_access_sub_group($params);
						if($cek_asg->num_rows() > 0)
						{
							$get_asg = $cek_asg->row();
							$params['mode'] = 'edit';
							$params['masg_id'] = $get_asg->masg_id;
							
							// print_r($params);
							$store_data = $this->db_masg->store_data($params);
						}
						else
						{
							$params['mode'] = 'add';
							$store_data = $this->db_masg->store_data($params);
						}

					}					
				}
			}
			else
			{
				foreach ($post['rm_id'] as $k => $v) {
					$params = array(
						'masg_ug_id' => $post['ug_id'],
						'masg_usg_id' => $post['usg_id'],
						'masg_rm_id' => $v,
						'mode' => 'add',
					);
					
					$params['mode'] = 'add';
					$store_data = $this->db_masg->store_data($params);	
				}
			}

			echo json_encode(array('success' => $store_data,'usg_id' => $post['usg_id'],'ug_id' => $post['ug_id']));
		}
		else $this->show_404();
	}

}