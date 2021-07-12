<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/settings/controllers/User.php
 */

class Menu extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('settings/menu_model', 'db_menu');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Menu';
		$this->store_params['pages_title'] = 'Menu List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('settings/menu', 'Menu')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/settings/menu.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('menu_view');
	}

	public function get_menu_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_menu_data')
		{
			$success = FALSE;
			$get_menu = $this->db_menu->get_menu(array('rm_is_active' => 'Y'));

			if ($get_menu && $get_menu->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_menu->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	// public function get_sequence()
	// {
	// 	if (isset($_POST['menu']))
	// 	{
	// 		$get_parent = $this->db_menu->get_parent_id($_POST['menu'])->row();
	// 		$success = FALSE;
	// 		$get_sequence = $this->db_menu->get_sequence($get_parent->rm_parent_id);

	// 		if ($get_sequence && $get_sequence->num_rows() > 0)
	// 		{ 
	// 			$data = $get_sequence->row();
	// 			echo json_encode(array('success' => TRUE, 'seq' => $data->rm_sequence+1));
	// 		}
	// 		else
	// 		{ 
	// 			echo json_encode(array('success' => TRUE));
	// 		}
	// 	} else $this->show_404();
	// }

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_menu->get_autocomplete_data();

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
			$data = $this->db_menu->get_menu(array('rm_id' => $post['id']));			

			if($data->num_rows() > 0)
			{
				$data2 = $data->row();
				$parent_id = ($data2->rm_parent_id !== "") ? $data2->rm_parent_id : "";
				$post['data'] = $data2;
			}
			else
			{
				$parent_id = "";
			}
			$post['option'] = $this->_build_data($parent_id);
			
			$this->_view('menu_popup_modal_view', $post);
		}
		else $this->show_404();
	}

	public function _build_data($id = "")
	{
		$get_menu_list = $this->db_menu->get_menu(array('rm_is_active' => 'Y'));
		$tree_menu_list = $this->_buildTree($get_menu_list->result(),$id);

		return $tree_menu_list;
	}

	public function _buildTree($datas, $sel_id = "", $parent_id = NULL, $idx = 0) 
	{
	    $str_menu = FALSE;

		if ($parent_id == '' || $parent_id == ' ' || $parent_id == NULL || $parent_id == 0 || empty($parent_id))
		{
			$parent_id = NULL;
		}

		$idx++;

		foreach ($datas as $data)
		{
			$dash = ($parent_id !== NULL) ? str_repeat('>', $idx) .' ' :'';
			$sel = ($data->rm_id == $sel_id) ? 'selected' : '';
			if ($data->rm_parent_id == $parent_id)
			{
				$children = $this->_buildTree($datas, $sel_id, $data->rm_id, $idx);

				if ($children !== FALSE)
				{

					$str_menu .= '
							<option value="'.$data->rm_id.'" '.$sel.'>'.$dash.$data->rm_caption.'</option>
						';	

					if ($idx > 0)
					{
						$str_menu .= $children;
					}
				
				}
				else
				{
					
					if($parent_id != NULL)
					{
						$str_menu .= '
							<option value="'.$data->rm_id.'" '.$sel.'>'.$dash.$data->rm_caption.'</option>
						';	
					}
					else
					{

						$str_menu .= '
							<option value="'.$data->rm_id.'" '.$sel.'>'.$data->rm_caption.'</option>
						';	

					}	
				}
			}
		}

		return $str_menu;
	}

	public function get_menu_option($menu_id = "")
	{
		$option = "";

		$menu_opt = $this->db_menu->get_menu_option(array('rm_is_active' => 'Y'));
		
		if($menu_opt->num_rows() > 0){ 
	        foreach($menu_opt->result_array() as $row)
	        {
	        	$sel = ($menu_id == $row['rm_id']) ? 'selected' : '';
	        	if($row['rm_parent_id'] != "" || $row['rm_parent_id'] != null)
	        	{
	        		$get_menu_utama = $this->db_menu->get_menu_option(array('rm_is_active' => 'Y','rm_id' => $row['rm_parent_id']))->row();
	            	 $option .= '<option value="'.$row['rm_id'].'"'.$sel.'>'.$get_menu_utama->rm_caption.' > '.$row['rm_caption'].'</option>'; 
	        	}
	        	else
	        	{
	        		 $option .= '<option value="'.$row['rm_id'].'"'.$sel.'>'.$row['rm_caption'].'</option>'; 
	        	}
	        } 
	    }else{ 
	         $option .= '<option value="">No Data</option>'; 
	    } 

	    return $option;
	}


	public function store_data()
	{

		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

			$store_data = $this->db_menu->store_data($post);

			if ($store_data)
			{
				$rm_id = $post['mode'] == 'add' ? $store_data : $post['txt_id_menu'];

			}

			echo json_encode(array('success' => $store_data,'url' => base_url('settings/menu')));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'delete_data')
		{
			unset($post['action']);

			$delete_data = $this->db_menu->delete_data($post);

			echo json_encode(array('success' => $delete_data,'url' => base_url('settings/menu')));
		}
		else $this->show_404();
	}

}