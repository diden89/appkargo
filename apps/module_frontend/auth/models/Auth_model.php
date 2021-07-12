<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/auth/models/Auth_model.php
 */

class Auth_model extends NOOBS_Model
{
	public function validate_login($params = array())
	{
		if (isset($params['ud_username']) && isset($params['ud_password']))
		{
			$result = array(
				'success' => FALSE,
				'data' => array()
			);

			$this->db->from('user_detail ud');
			$this->db->join('user_sub_group usg', 'usg.usg_id = ud.ud_sub_group');
			$this->db->join('user_group ug', 'ug.ug_id = usg.usg_group');
			$this->db->where('ud_is_active', 'Y');
			$this->db->where('usg_is_active', 'Y');
			$this->db->where('ug_is_active', 'Y');
			$this->db->where('ud_username', $params['ud_username']);
			$this->db->where('ud_password', $params['ud_password']);

			$qry = $this->db->get();

			if ($qry->num_rows() > 0)
			{
				$result['success'] = TRUE;
				$result['data'] = $qry->row_array();
			}

			return $result;
		}
		else
		{
			return FALSE;
		}
	}
}