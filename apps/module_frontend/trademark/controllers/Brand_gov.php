<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/controllers/Brand_gov.php
 */

class Brand_gov extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('trademark/Brand_gov_model', 'db_brand_gov');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'List of BRM';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('trademark/brand_gov', 'List of BRM')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/trademark/brand_gov.js').'"></script>'
		);

		$this->view('brand_gov_view');
	}

	public function get_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_data')
		{
			$get_data = $this->db_brand_gov->get_data($post);

			$number = 1;

			foreach ($get_data->data as $k => $v) 
			{
				$v->no = $number;

				$file_link = base_url('files/' . $v->bp_filename);

				$v->file_link = $file_link;

				$v->bp_brm_published_date = '';

				if (!empty($v->bp_brm_published_date_start_new)) $v->bp_brm_published_date .= $v->bp_brm_published_date_start_new . ' - ';
				if (!empty($v->bp_brm_published_date_end_new)) $v->bp_brm_published_date .= $v->bp_brm_published_date_end_new;

				$number++;
			}

			echo json_encode($get_data);
		}
		else $this->show_404();
	}

	public function upload_file()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'upload_file') 
		{
		 	if ($_FILES['file_pdf']['error'] < 1 && $_FILES['file_pdf']['size'] > 0)
			{
				$config['upload_path'] = NOOBS_FILES_DIR;
				$config['allowed_types'] = 'pdf';
				$config['remove_spaces'] = TRUE;
				$config['encrypt_name'] = FALSE;

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('file_pdf'))
				{
					$upload_data = $this->upload->data();
				}
			}

			if (isset($upload_data)) echo json_encode(array('success' => TRUE));
			else echo json_encode(array('success' => FALSE));
		}
		else $this->show_404();
	} 
}