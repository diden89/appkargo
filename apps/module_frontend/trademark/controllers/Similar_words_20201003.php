<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/controllers/Similar_words.php
 */

class Similar_words extends NOOBS_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('trademark/similar_words_model', 'db_similar_words');
	}

	public function index()
	{
		$this->store_params['header_title'] = 'Similar Words';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('trademark/similar_words', 'Similar Words')
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/trademark/similar_words.js').'"></script>'
		);

		$this->view('similar_words_view');
	}

	public function get_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_data')
		{
			$get_data = $this->db_similar_words->get_data($post);

			if ($get_data->num_rows() > 0) 
			{
				$result = $get_data->result();

				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;

					$number++;
				}
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function get_autocomplete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'get_autocomplete_data') 
		{
			$get_autocomplete_data = $this->db_similar_words->get_autocomplete_data($post);

			echo json_encode($get_autocomplete_data);
		}
		else $this->show_404();
	}

	public function get_data_similar_word()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_data_similar_word')
		{
			$get_data_similar_word = $this->db_similar_words->get_data_similar_word($post);

			if ($get_data_similar_word->num_rows() > 0) 
			{
				$result = $get_data_similar_word->result();

				$number = 1;

				foreach ($result as $k => $v)
				{
					$v->no = $number;

					$number++;
				}
				echo json_encode(array('success' => TRUE, 'data' => $result));
			}
			else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
		}
		else $this->show_404();
	}

	public function popup_modal()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'popup_modal')
		{
			unset($post['action']);

			$this->_view('similar_words_popup_modal_view', $post);
		}
		else $this->show_404();
	}

	public function store_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && !empty($post['action']) && $post['action'] == 'store_data') 
		{
			unset($post['action']);

			if ($post['mode'] == 'add') $this->_check_word_available($post['txt_new_word']);

			$txt_new_similar_word_id = $post['mode'] == 'add' ? $this->_store_new_word($post['txt_new_word']) : $post['txt_new_similar_word_id'];

			if ($txt_new_similar_word_id)
			{
				if ($this->_check_arr_similar_word_by_d_id($txt_new_similar_word_id)) exit(json_encode(array('success' => FALSE, 'msg' => 'This word is already connected to another words, please do the reverse of this action')));

				$arr_similar_word = array();

				$arr_similar_word[] = $txt_new_similar_word_id;
				
				if (isset($post['txt_d_id']) && !empty($post['txt_d_id'])) {

					$arr_similar_word[] = $post['txt_d_id'];

					if (isset($post['txt_d_similar_word']) && !empty($post['txt_d_similar_word']) && $post['txt_d_similar_word'] != NULL && $post['txt_d_similar_word'] != 'null') 
					{
						$tmp_post_similar_word = explode(',', $post['txt_d_similar_word']);

						$arr_similar_word = array_merge($arr_similar_word, $tmp_post_similar_word);
					}

					$success = FALSE;

					for ($i=0; $i < count($arr_similar_word); $i++) 
					{ 
						$new_arr_similar_word = $arr_similar_word;
						$txt_new_d_id = $arr_similar_word[$i];

						unset($new_arr_similar_word[$i]);

						$success = $this->_edit_similar_words($txt_new_d_id, array_unique($new_arr_similar_word));
					}

					echo json_encode(array('success' => $success));					
				}
				else echo json_encode(array('success' => TRUE));
			}
			else exit(json_encode(array('success' => FALSE, 'msg' => "Something wrong please call your system administrator.")));

		}
		else $this->show_404();
	}

	public function edit_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'edit_data')
		{
			unset($post['action']);

			$edit_data = $this->db_similar_words->edit_data($post);

			echo json_encode(array('success' => $edit_data));
		}
		else $this->show_404();
	}

	public function delete_data()
	{
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'delete_data')
		{
			$delete_data = $this->db_similar_words->delete_data($post);

			if ($delete_data)
			{
				$arr_similar_word = explode(',', $post['d_similar_word']);

				$success = FALSE;

				for ($i=0; $i < count($arr_similar_word) ; $i++) 
				{
					$new_d_id = $arr_similar_word[$i];

					$arr_similar_word_by_d_id = $this->_check_arr_similar_word_by_d_id($new_d_id);

					$key = array_search($post['d_id'], $arr_similar_word_by_d_id);

					unset($arr_similar_word_by_d_id[$key]);

					$success = $this->_edit_similar_words($new_d_id, array_unique($arr_similar_word_by_d_id));
				}

				echo json_encode(array('success' => $success));
			}
			else exit(json_encode(array('success' => FALSE, 'msg' => 'Something wrong please call your system administrator')));		
		}
		else $this->show_404();
	}

	private function _check_word_available($word)
	{
		$check_word_available = $this->db_similar_words->check_word_available($word);

		if ($check_word_available->num_rows() > 0) exit(json_encode(array('success' => FALSE, 'msg' => 'This word already exist in similar words')));
		else return TRUE;
	}

	private function _store_new_word($word)
	{
		return $this->db_similar_words->store_new_word($word);
	}

	private function _edit_similar_words($txt_d_id, $arr_similar_word)
	{
		return $this->db_similar_words->edit_similar_words($txt_d_id, $arr_similar_word);
	}

	private function _check_arr_similar_word_by_d_id($txt_d_id)
	{
		$arr_similar_word_by_d_id = $this->db_similar_words->check_arr_similar_word_by_d_id($txt_d_id);

		if ($arr_similar_word_by_d_id->num_rows() > 0) 
		{
			$row = $arr_similar_word_by_d_id->row();

			if (!empty($row->d_similar_word)) return explode(',', $row->d_similar_word);
			else return FALSE;
		}
		else return FALSE;
	}
}