<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/controllers/Brand.php
 */

class Brand extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('trademark/brand_model', 'db_brand');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Client’s Trademarks';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('trademark/brand', 'Client’s Trademarks')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/trademark/brand.js').'"></script>'
		);

		$this->view('brand_view');
	}

	public function get_data()
	{	
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_data')
		{
			$get_data = $this->db_brand->get_data($post);

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

	public function popup_modal()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);

			$this->_view('brand_popup_modal_view', $post);
		}
		else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'store_data')
		{
			unset($post['action']);

			$store_data = $this->db_brand->store_data($post);

			// if ($store_data) {
			// 	if ($post['mode'] == 'add') $this->_insert_word_to_dictionary($store_data, $post['br_name']);
			// 	if ($post['mode'] == 'edit') $this->_edit_word_in_dictionary($post['br_id'], $post['br_name']);
			// } 

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

			$delete_data = $this->db_brand->delete_data($post);

			echo json_encode(array('success' => $delete_data));
		}
		else $this->show_404();
	}

	public function popup_upload_excel()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_upload_excel')
		{
			unset($post['action']);

			$this->_view('brand_popup_upload_excel_view', $post);
		}
		else $this->show_404();
	}

	public function upload_file_excel()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'upload_file_excel')
		{
			unset($post['action']);

			$file = $_FILES['file']['tmp_name'];
			
			$this->load->library('xls_reader');
			$this->xls_reader->read_file($file);

			$tmpData = $this->xls_reader->create_data();

			$data = array();

			if ($tmpData) 
			{
				$total = count($tmpData->data);


				for ($i=0; $i < $total; $i++) 
				{
					$newdata = array();

					$first_datetime = '';
					if (!empty($tmpData->data[$i][0])) $first_datetime = is_string($tmpData->data[$i][0]) ? date('d-m-Y', strtotime($tmpData->data[$i][0])) : date('d-m-Y', $this->xls_reader->excel_to_time_timestamp($tmpData->data[$i][0]));
					$newdata['first_datetime'] = $first_datetime;

					$last_datetime = '';
					if (!empty($tmpData->data[$i][1])) $last_datetime = is_string($tmpData->data[$i][1]) ? date('d-m-Y', strtotime($tmpData->data[$i][1])) : date('d-m-Y', $this->xls_reader->excel_to_time_timestamp($tmpData->data[$i][1]));
					$newdata['last_datetime'] = $last_datetime;

					$first_user = !empty($tmpData->data[$i][2]) ? $this->_get_user_id($tmpData->data[$i][2]) : '';
					$newdata['first_user'] = $first_user;

					$last_user = !empty($tmpData->data[$i][3]) ? $this->_get_user_id($tmpData->data[$i][3]) : '';
					$newdata['last_user'] = $last_user;

					$newdata['br_app_number'] = $tmpData->data[$i][4];
					$br_receive_date = '';
					if (!empty($tmpData->data[$i][5])) $br_receive_date = is_string($tmpData->data[$i][5]) ? date('d-m-Y', strtotime($tmpData->data[$i][5])) : date('d-m-Y', $this->xls_reader->excel_to_time_timestamp($tmpData->data[$i][5]));
					$newdata['br_receive_date'] = $br_receive_date;
					$newdata['br_priority'] = $tmpData->data[$i][6];
					$newdata['br_owner_name'] = $tmpData->data[$i][7];
					$newdata['br_owner_address'] = $tmpData->data[$i][8];
					$newdata['br_lawyer_name'] = $tmpData->data[$i][9];
					$newdata['br_lawyer_address'] = $tmpData->data[$i][10];
					$newdata['br_name'] = $tmpData->data[$i][11];
					$newdata['br_meaning_of_language'] = $tmpData->data[$i][12];
					$newdata['br_color_description'] = $tmpData->data[$i][13];
					$newdata['br_class_of_good_or_services'] = $tmpData->data[$i][14];
					$newdata['br_desc_of_good_or_services'] = $tmpData->data[$i][15];
					$newdata['br_status'] = $tmpData->data[$i][16];
					$newdata['br_description'] = $tmpData->data[$i][17];
					$br_reminder = '';
					if (!empty($tmpData->data[$i][18])) $br_reminder = is_string($tmpData->data[$i][18]) ? date('d-m-Y', strtotime($tmpData->data[$i][18])) : date('d-m-Y', $this->xls_reader->excel_to_time_timestamp($tmpData->data[$i][18]));
					$newdata['br_reminder'] = $br_reminder;
					$newdata['br_reg_number'] = $tmpData->data[$i][19];
					$br_expiry_date = '';
					if (!empty($tmpData->data[$i][20])) $br_expiry_date = is_string($tmpData->data[$i][20]) ? date('d-m-Y', strtotime($tmpData->data[$i][20])) : date('d-m-Y', $this->xls_reader->excel_to_time_timestamp($tmpData->data[$i][20]));
					$newdata['br_expiry_date'] = $br_expiry_date;
					$newdata['br_history_status'] = $tmpData->data[$i][21];
					$newdata['br_contact_person'] = $tmpData->data[$i][22];
					$newdata['br_last_client_update'] = $tmpData->data[$i][23];
					$newdata['br_history_client_update'] = $tmpData->data[$i][24];
					$newdata['br_fee'] = $tmpData->data[$i][25];
					$newdata['br_bill'] = $tmpData->data[$i][26];
					$newdata['br_payment_status'] = $tmpData->data[$i][27];
					$newdata['br_document'] = $tmpData->data[$i][28];
					$newdata['br_additional_document'] = $tmpData->data[$i][29];
					$newdata['br_certificate'] = $tmpData->data[$i][30];
					$newdata['br_img'] = $tmpData->data[$i][31];

					array_push($data, $newdata);
				}
			}
			echo json_encode(array('success' => TRUE, 'data' => $data));
		}
		else $this->show_404();
	}

	private function _get_user_id($ud_fullname)
	{
		$get_user_id = $this->db_brand->get_user_id($ud_fullname);
		
		if ($get_user_id->num_rows() == 1) 
		{
			$row = $get_user_id->row();

			return $row->ud_id;
		}
		else return '';
	}

	public function popup_item_detail()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_item_detail')
		{
			unset($post['action']);

			$this->_view('brand_popup_item_detail_view', $post);
		}
		else $this->show_404();
	}

	public function export_to_excel()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'export_to_excel')
		{
			unset($post['action']);

			$get_data_to_export = $this->db_brand->get_data_to_export($post);

			if ($get_data_to_export->num_rows() > 0) 
			{
				ini_set('memory_limit', '-1');

				$result = $get_data_to_export->result();

				$no = 1;

				foreach ($result as $k => $v) 
				{
					$v->no = $no++;
				}

				$data = array();

				foreach ($result as $k => $v) 
				{
					$data[$k] = (array)$v;
				}

				$this->load->library('xls_writer');

				$this->xls_writer->config($post);

				$this->xls_writer->store_data($data);
				$this->xls_writer->add_sheet('Laporan');

				$this->xls_writer->save('Report_brand_list_'.date('Y-m-d_H-i-s').'.xlsx');
			}
		}
		else $this->show_404();
	}

	private function _insert_word_to_dictionary($br_id, $brand)
	{
		return $this->db_brand->insert_word_to_dictionary($br_id, $brand);
	}

	private function _edit_word_in_dictionary($br_id, $brand)
	{
		return $this->db_brand->edit_word_in_dictionary($br_id, $brand);
	}
}