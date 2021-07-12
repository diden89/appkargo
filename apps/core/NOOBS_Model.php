<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/core/NOOBS_Model.php
 */

class NOOBS_Model extends CI_Model {
	protected $table = NULL;
	protected $column_order = NULL;
	protected $column_search = NULL;
	protected $date_format = '%Y-%m-%d';
	protected $datetime_format = '%Y-%m-%d %H:%i:%s';
	protected $time_format = '%H:%i:%s';

	protected function create_result($params = FALSE)
	{
		$result = new stdClass();
		$result->success = TRUE;
		// $result->draw = $params['draw'];
		$result->recordsTotal = 0;
		$result->recordsFiltered = 0;
		$result->data = array();

		$this->column_order = $this->set_column_order($params);

		if (isset($params['table']))
		{
			$this->table = $params['table'];
		}

		if (isset($params['length']))
		{
			$this->_limit = $params['length'];
		}

		if (isset($params['start']))
		{
			$this->_start = $params['start'];
		}

		if ($params !== FALSE)
		{
			$this->_bind_limit($params);
			$this->_bind_sort($params);
		}

		if (isset($params['where']))
		{
			$params['where'] = str_replace(" = 'null'", ' IS NULL', $params['where']);
			$this->db->where($params['where'], NULL, FALSE);
		}

		$qry = $this->db->get_temp($this->table);

		$qry = preg_replace('/SELECT\s/', 'SELECT SQL_CALC_FOUND_ROWS ', $qry, 1);
		
		$qry = $this->db->query($qry);

		if ($qry->num_rows() > 0)
		{
			$db_total = clone($this->db);

			$total = $db_total->query("SELECT FOUND_ROWS() total")->row()->total;

			$result->recordsTotal = $total;
			$result->recordsFiltered = $total;
			$result->total = $total;
			$result->data = $qry->result();
			
			$qry->free_result();
			unset($db_total);
		}

		return $result;
	}
	
	protected function create_autocomplete_data($params = FALSE)
	{
		$result = new stdClass();

		$result->total_count = 0;
		$result->incomplete_results = FALSE;
		$result->items = array();

		if (isset($params['table']))
		{
			$this->table = $params['table'];
		}

		if (isset($params['where']))
		{
			$params['where'] = str_replace(" = 'null'", ' IS NULL', $params['where']);
			$this->db->where($params['where'], NULL, FALSE);
		}

		$qry = $this->db->get_temp($this->table);

		$qry = preg_replace('/SELECT\s/', 'SELECT SQL_CALC_FOUND_ROWS ', $qry, 1);
		
		$qry = $this->db->query($qry);

		if ($qry->num_rows() > 0)
		{
			$db_total = clone($this->db);

			$total = $db_total->query("SELECT FOUND_ROWS() total")->row()->total;

			$result->total_count = intval($total);
			$result->incomplete_results = FALSE;
			$result->items = $qry->result();
			
			$qry->free_result();
			unset($db_total);
		}

		return $result;
	}

	private function _bind_limit($params)
	{
		if (isset($params['length']))
		{
			if (isset($params['length']) && isset($params['start']))
			{
				$this->db->limit($this->_limit, $params['start']);
			}
			else
			{
				$this->db->limit($params['limit']);
			}
		}
	}

	private function _bind_sort($params)
	{
		if (isset($params['order']) && !empty($params['order']))
		{
			foreach ($params['order'] as $k => $v)
			{
				if (isset($v['column']) && !empty($v['column']))
				{
					$this->db->order_by($this->column_order[intval($v['column'])], $v['dir']);
				}
			}
		}
	}

	private function _bind_search($params)
	{
		if(isset($params['search']['value']) && !empty($params['search']['value']))
		{
			for ($i=0; $i < count($this->column_search); $i++) 
			{ 
				if ($i===0) $this->db->like($this->column_search[$i], $params['search']['value']);
				else $this->db->or_like($this->column_search[$i], $params['search']['value']);
			}
		}
	}

	protected function set_column_order($params = FALSE)
    {

    	if ($params !== FALSE)
    	{
    		if(isset($params['columns']) && !empty($params['columns']))
    		{
    			$sort = array();

    			foreach ($params['columns'] as $k => $v) 
    			{
    				if ($v['orderable'] === 'true') 
    				{
    					$sort[] = $v['data'];
    				}
    				else $sort[] = '';
    			}

    			return $sort;
    		}
    	}
    }

    protected function set_column_search($params = FALSE)
    {
    	if ($params !== FALSE)
    	{
    		if(isset($params['columns']) && !empty($params['columns']))
    		{
    			$search = array();

    			foreach ($params['columns'] as $k => $v) 
    			{
    				if ($v['searchable'] === 'true') 
    				{
    					$search[] = $v['data'];
    				}
    			}

    			$tmp_list_fields = $this->db->qb_select_pub;
    			$list_field = array();

    			$tmp_date_format = '';

    			for ($i=0; $i < count($tmp_list_fields); $i++) {
    				$pos = strpos($tmp_list_fields[$i], "AS");
    				if ($pos !== FALSE) 
    				{
						$list_fields[] = substr($tmp_list_fields[$i], 0, $pos - 1);		
    				} 
    				else 
    				{
    					if (strpos($tmp_list_fields[$i], "DATE_FORMAT") !== FALSE) 
    					{
    						$list_fields[] = $tmp_list_fields[$i].", '".$this->date_format."')";
    					}
    				}
    			}

    			$list_search = array();

    			for ($j=0; $j < count($search); $j++) {
    				$txt_pos = strpos($search[$j], "txt_");
    				if ($txt_pos !== FALSE) 
    				{
						$list_search[] = substr($search[$j], 4, strlen($search[$j]));		
    				} else $list_search[] = $search[$j];
    			}

    			$list_searchable = array();

    			for ($k=0; $k < count($list_fields); $k++) {
    				for ($l=0; $l < count($list_search); $l++) {
    					$txt_find_post = strpos($list_fields[$k], $list_search[$l]);
    					if ($txt_find_post) 
    					{
    						$list_searchable[] = $list_fields[$k]; 
    					}
    				}
    			}

    			return $list_searchable;
    		}
    	}
    }

	protected function add($data = array(), $return_id = FALSE, $skip_last_user_datetime = FALSE)
	{
		if ( ! empty($this->table))
		{
			$decrypt_token = $this->decrypt_token();

			$this->db->trans_begin();
			$this->_fixup_data($data);

			if (!$skip_last_user_datetime)
			{
				$this->db->set('last_user', $decrypt_token['ud_id']);
				$this->db->set('last_datetime', 'NOW()', FALSE);
			}

			$this->db->insert($this->table);

			$insert_id = $this->db->insert_id();
			$fields = $this->db->field_data($this->table);

			foreach ($fields as $k => $v)
			{
				if ($v->primary_key == 1)
				{
					$this->db->where($v->name, $insert_id);
				}
			}

			$qry_log = $this->db->get($this->table);
			$qry_row = $qry_log->row();

			foreach ($qry_row as $k => $v)
			{
				$this->db->set($k, $v);
			}

			$this->db->set('log_action', 'add');
			$this->db->set('log_datetime', 'NOW()', FALSE);
			$this->db->set('log_user_id', $decrypt_token['ud_id']);
			$this->db->insert('log_'.$this->table);

			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				
				return FALSE;
			}
			else
			{
				$this->db->trans_commit();

				if ($return_id !== FALSE)
				{
					return $insert_id;
				}
				else
				{
					return TRUE;
				}
			}
		}
		else
		{
			return FALSE;
		}
	}

	protected function edit($data = array(), $where = NULL)
	{
		if ( ! empty($this->table))
		{
			$decrypt_token = $this->decrypt_token();

			$this->db->trans_begin();
			$this->_fixup_data($data);
			$this->db->set('last_user', $decrypt_token['ud_id']);
			$this->db->set('last_datetime', 'NOW()', FALSE);
			$this->db->where($where, NULL, FALSE);
			$this->db->update($this->table);

			$this->db->where($where, NULL, FALSE);
			$qry_log = $this->db->get($this->table);
			$qry_row = $qry_log->row();

			foreach ($qry_row as $k => $v)
			{
				$this->db->set($k, $v);
			}

			$this->db->set('log_action', 'edit');
			$this->db->set('log_datetime', 'NOW()', FALSE);
			$this->db->set('log_user_id', $decrypt_token['ud_id']);
			$this->db->insert('log_'.$this->table);

			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				
				return FALSE;
			}
			else
			{
				$this->db->trans_commit();

				return TRUE;
			}
		}
	}
	
	public function delete($key, $values)
	{
		if ( ! empty($this->table))
		{
			$decrypt_token = $this->decrypt_token();

			if ( ! is_array($values)) $values = array($values);

			$this->db->trans_begin();
			$this->db->where_in($key, $values);

			$qry = $this->db->get($this->table);

			if ($qry->num_rows() > 0) 
			{
				$row = $qry->result_array();
				$new_row = array();

				foreach ($row as $k => $v)
				{
					$v['log_action'] = 'delete';
					$v['log_datetime'] = date('Y-m-d H:i:s');
					
					if (empty($decrypt_token['ud_id'])) $v['log_user_id'] = $qry_row->ud_id;
					else $v['log_user_id'] = $decrypt_token['ud_id'];

					$new_row[$k] = $v;
				}

				$this->db->insert_batch('log_'.$this->table, $new_row);
				$this->db->where_in($key, $values);
				$this->db->delete($this->table);

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();

					return FALSE;
				}
				else
				{
					$this->db->trans_commit();

					return TRUE;
				}
			}
			else
			{
				$this->db->trans_commit();

				return TRUE;
			} 
		}
	}

	private function _validate_fields($params)
	{
		$list_fields = $this->db->list_fields($this->table);
		$params_keys = array_keys($params);
		$ar_compare = array_diff($params_keys, $list_fields);

		if (count($ar_compare) > 0)
		{
			return FALSE;
		}

		return TRUE;
	}

	private function _fixup_data($data)
	{
		$fields = $this->db->field_data($this->table);
		
		if ( ! is_array($data)) $data = (array)$data;
		
		foreach ($fields as $f)
		{
			foreach ($data as $k => $v)
			{
				if ($f->name == $k)
				{
					if ($v == '0')
					{
						$this->db->set($k, 0);
					}
					elseif (empty($v) || $v == '' || $v === NULL)
					{
						$this->db->set($k, NULL);
					}
					else
					{
						if (strtoupper($f->type) == 'DATE')
						{
							if (strtoupper($v) == 'NOW()' || strtoupper($v) == 'SYSDATE')
							{
								$this->db->set($k, $v, FALSE);
							}
							else
							{
								$new_value = date('Y-m-d', strtotime($v));
								$this->db->set($k, "DATE_FORMAT('{$new_value}', '{$this->date_format}')", FALSE);
							}
						}
						elseif (strtoupper($f->type) == 'DATETIME')
						{
							if (strtoupper($v) == 'NOW()' || strtoupper($v) == 'SYSDATE')
							{
								$this->db->set($k, $v, FALSE);
							}
							else
							{
								$new_value = date('Y-m-d H:i:s', strtotime($v));
								$this->db->set($k, "DATE_FORMAT('{$new_value}', '".$this->datetime_format."')", FALSE);
							}
						}
						elseif (strtoupper($f->type) == 'VARCHAR' || strtoupper($f->type) == 'VARCHAR2' || strtoupper($f->type) == 'TEXT')
						{
							$this->db->set($k, htmlentities($v, ENT_QUOTES));
						}
						else
						{
							$this->db->set($k, $v);
						}
					}
				}
			}
		}
	}

	protected function store_item_mutation($params = array())
	{
		$this->table = 'item_mutation';

		$new_params = array(
			'imt_im_id' => !empty($params['imt_im_id']) ?  $params['imt_im_id'] : '',
			'imt_is_id' => !empty($params['imt_is_id']) ?  $params['imt_is_id'] : '',
			'imt_w_id' => !empty($params['imt_w_id']) ?  $params['imt_w_id'] : '',
			'imt_ir_id' => !empty($params['imt_ir_id']) ?  $params['imt_ir_id'] : '',
			'imt_old_qty' => !empty($params['imt_old_qty']) ?  $params['imt_old_qty'] : '',
			'imt_action' => !empty($params['imt_action']) ?  $params['imt_action'] : '',
			'imt_document_number' => !empty($params['imt_document_number']) ?  $params['imt_document_number'] : '',
			'imt_qty' => !empty($params['imt_qty']) ?  $params['imt_qty'] : '',
			'imt_new_qty' => !empty($params['imt_new_qty']) ?  $params['imt_new_qty'] : '',
			'imt_w_id_receive' => !empty($params['imt_w_id_receive']) ?  $params['imt_w_id_receive'] : '',
			'imt_ir_id_receive' => !empty($params['imt_ir_id_receive']) ?  $params['imt_ir_id_receive'] : ''
		);

		$this->add($new_params);
	}

	protected function decrypt_token()
	{
		$token = $this->encryption->decrypt($this->session->userdata('token'));
		$exp_token = explode(':', $token);
		
		return array('ud_id' => $exp_token[0], 'ud_username' => $exp_token[1]);
	}
	
	protected function print_out($param)
	{
		echo '<pre>';
		
		if (is_array($param) || is_object($param))
		{
			print_r($param);
		}
		elseif (is_callable($param))
		{
			var_dump($param);
		}
		else
		{
			echo $param;
		}

		exit();
	}
}