<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/auth/controllers/Auth.php
 */

class Auth extends NOOBS_Controller {
	function __construct()
	{
		parent::__construct(array(
			'auth' => FALSE
		));
	}

	public function index()
	{
		$this->_view('auth_view');
	}

	public function do_login()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'do_login')
		{
			$post = $this->input->post();
			$params = json_decode($post['data']);
			$do_login = $this->validate_login($params);

			if ($do_login['success'] !== FALSE)
			{
				$result = array(
					'success' => TRUE,
					'location' => $this->session->userdata('user_location_caption'),
					'ip' => $this->input->ip_address()
				);
			}
			else
			{
				$result = array(
					'success' => FALSE,
					'msg' => 'Invalid username or password.'
				);
			}
			// print_r($result);exit;
			print(json_encode($result));
		}
		else
		{
			show_404();
		}
	}

	public function do_logout()
	{
		$this->session->set_userdata(array('token' => ''));
		$this->session->unset_userdata(array('token' => ''));
		$this->session->sess_destroy();

		redirect('auth');
	}
}
