<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/akuntansi/controllers/Daftar_perkiraan.php
 */

class Daftar_perkiraan extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('akuntansi/daftar_perkiraan_model', 'db_daftar_perkiraan');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Daftar Perkiraan';
		$this->store_params['pages_title'] = 'Daftar Perkiraan List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('akuntansi/daftar_perkiraan', 'Daftar Perkiraan')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/akuntansi/daftar_perkiraan.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('daftar_perkiraan_view');
	}

	public function get_daftar_perkiraan_data()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_daftar_perkiraan_data')
		{
			$success = FALSE;
			$get_daftar_perkiraan = $this->db_daftar_perkiraan->get_daftar_perkiraan(array('rm_is_active' => 'Y'));

			if ($get_daftar_perkiraan && $get_daftar_perkiraan->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_daftar_perkiraan->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_akun_header()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_akun_header')
		{
			$success = FALSE;
			$get_akun_header = $this->db_daftar_perkiraan->get_akun_header(array('rah_is_active' => 'Y'));

			if ($get_akun_header && $get_akun_header->num_rows() > 0) echo json_encode(array('success' => TRUE, 'data' => $get_akun_header->result()));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	public function get_akun_detail()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'get_akun_detail')
		{
			$success = FALSE;
			
			$get_akun_header = $this->db_daftar_perkiraan->get_akun_header(array('rah_is_active' => 'Y','rah_id' => $_POST['rah_id']));
			
			$get_akun_detail = $this->db_daftar_perkiraan->get_akun_detail(array('rad_is_active' => 'Y'));
			
			$detail = array();

			if($get_akun_header->num_rows() > 0)
			{
				$header = array();
				$t=0;
				foreach($get_akun_header->result() as $k => $v)
				{
					$header[$v->mag_id] = $v->mag_rm_id;
					$t++;
				}
				
				$i=0;
				foreach($get_akun_detail->result() as $gm => $mn)
				{		
					$check = array_search($mn->rm_id, $header) ? 'checked' : '';
					$mag_id = array_search($mn->rm_id, $header) ? array_search($mn->rm_id, $header) : '';
					$detail[$i] = (object) array(
						'rm_id' => $mn->rm_id,
						'rm_parent_id' =>$mn->rm_parent_id,
						'rm_caption' =>$mn->rm_caption,
						'mag_id' => $mag_id,
						'checked' => $check,
					);						
					$i++;
				}
			}
			else
			{
				$i=0;
				foreach($get_akun_detail->result() as $gm => $mn)
				{		
					$detail[$i] = (object) array(
						'rm_id' => $mn->rm_id,
						'rm_parent_id' =>$mn->rm_parent_id,
						'rm_caption' =>$mn->rm_caption,
						'mag_id' => '',
						'checked' => '',
					);						
					$i++;
				}
			}

			if (count($detail) > 0) echo json_encode(array('success' => TRUE, 'data' => $detail));
			else echo json_encode(array('success' => TRUE));
		} else $this->show_404();
	}

	// public function get_sequence()
	// {
	// 	if (isset($_POST['daftar_perkiraan']))
	// 	{
	// 		$get_parent = $this->db_daftar_perkiraan->get_parent_id($_POST['daftar_perkiraan'])->row();
	// 		$success = FALSE;
	// 		$get_sequence = $this->db_daftar_perkiraan->get_sequence($get_parent->rm_parent_id);

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
			$get_autocomplete_data = $this->db_daftar_perkiraan->get_autocomplete_data();

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
			$data = $this->db_daftar_perkiraan->get_daftar_perkiraan(array('rm_id' => $post['id']));			

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
			
			$this->_view('daftar_perkiraan_popup_modal_view', $post);
		}
		else $this->show_404();
	}

	public function _build_data($id = "")
	{
		$get_daftar_perkiraan_list = $this->db_daftar_perkiraan->get_daftar_perkiraan(array('rm_is_active' => 'Y'));
		$tree_daftar_perkiraan_list = $this->_buildTree($get_daftar_perkiraan_list->result(),$id);

		return $tree_daftar_perkiraan_list;
	}

	public function _buildTree($datas, $sel_id = "", $parent_id = NULL, $idx = 0) 
	{
	    $str_daftar_perkiraan = FALSE;

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

					$str_daftar_perkiraan .= '
							<option value="'.$data->rm_id.'" '.$sel.'>'.$dash.$data->rm_caption.'</option>
						';	

					if ($idx > 0)
					{
						$str_daftar_perkiraan .= $children;
					}
				
				}
				else
				{
					
					if($parent_id != NULL)
					{
						$str_daftar_perkiraan .= '
							<option value="'.$data->rm_id.'" '.$sel.'>'.$dash.$data->rm_caption.'</option>
						';	
					}
					else
					{

						$str_daftar_perkiraan .= '
							<option value="'.$data->rm_id.'" '.$sel.'>'.$data->rm_caption.'</option>
						';	

					}	
				}
			}
		}

		return $str_daftar_perkiraan;
	}

	public function get_daftar_perkiraan_option($daftar_perkiraan_id = "")
	{
		$option = "";

		$daftar_perkiraan_opt = $this->db_daftar_perkiraan->get_daftar_perkiraan_option(array('rm_is_active' => 'Y'));
		
		if($daftar_perkiraan_opt->num_rows() > 0){ 
	        foreach($daftar_perkiraan_opt->result_array() as $row)
	        {
	        	$sel = ($daftar_perkiraan_id == $row['rm_id']) ? 'selected' : '';
	        	if($row['rm_parent_id'] != "" || $row['rm_parent_id'] != null)
	        	{
	        		$get_daftar_perkiraan_utama = $this->db_daftar_perkiraan->get_daftar_perkiraan_option(array('rm_is_active' => 'Y','rm_id' => $row['rm_parent_id']))->row();
	            	 $option .= '<option value="'.$row['rm_id'].'"'.$sel.'>'.$get_daftar_perkiraan_utama->rm_caption.' > '.$row['rm_caption'].'</option>'; 
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

			$store_data = $this->db_daftar_perkiraan->store_data($post);

			if ($store_data)
			{
				$rm_id = $post['mode'] == 'add' ? $store_data : $post['txt_id_daftar_perkiraan'];

			}

			echo json_encode(array('success' => $store_data,'url' => base_url('daftar_perkiraan/daftar_perkiraan')));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'delete_data')
		{
			unset($post['action']);

			$delete_data = $this->db_daftar_perkiraan->delete_data($post);

			echo json_encode(array('success' => $delete_data,'url' => base_url('daftar_perkiraan/daftar_perkiraan')));
		}
		else $this->show_404();
	}

}