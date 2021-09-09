<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/core/NOOBS_Controller.php
 */

class NOOBS_Controller extends CI_Controller {
	public $auth = TRUE;
	public $store_params = array();
	
	function __construct($config = array())
	{
		parent::__construct();
		$this->load->model('auth/auth_model', 'db_auth');
		$this->load->model('main/main_model', 'db_main');

		if (count($config) > 0)
		{
			foreach ($config as $k => $v)
			{
				$this->$k = $v;
			}
		}

		if ($this->auth !== FALSE)
		{
			$this->validate_login();
		}

		$mod = $this->router->fetch_module();
		$ctl = $this->router->fetch_class();

		preg_match("/(" . $mod . "|" . $mod . "\/" . $ctl . ")\/(mod|app|front|pub)(image|style|script|font)\/(.*)/", $this->uri->uri_string(), $matches);
		
		if (count($matches) > 0)
		{
			$this->_asset_proxy($matches[3], $matches[4], $matches[2], $mod);

			exit();
		}
	}

	function _remap($method)
	{
		if (method_exists($this,$method))
		{
			call_user_func(array($this, $method));
			return false;
		}
		else
		{
			echo 'Method not found!';
		}
	}

	protected function view($body, $view = 'view')
	{
		$this->store_params['title'] = isset($this->store_params['title']) ? $this->store_params['title'] : NOOBS_TITLE;
		$this->store_params['body'] = $this->load->view($body, $this->store_params, TRUE);
		$this->store_params['menu'] = $this->_generate_menu();
		
		if (ENVIRONMENT == 'production')
		{
			$output = html_uglify($this->load->view($view, $this->store_params, TRUE));
		}
		else
		{
			$output = $this->load->view($view, $this->store_params, TRUE);
		}
		
		print ($output);
	}

	protected function _view($view, $params = array())
	{
		$this->store_params['title'] = isset($this->store_params['title']) ? $this->store_params['title'] : NOOBS_TITLE;
		
		if (ENVIRONMENT == 'production')
		{
			$output = html_uglify($this->load->view($view, $params, TRUE));
		}
		else
		{
			$output = $this->load->view($view, $params, TRUE);
		}
		
		print ($output);
	}
	
	protected function validate_login($params = FALSE)
	{
		if ($params !== FALSE)
		{
			$new_params = array(
				'ud_username' => $params->txt_username,
				'ud_password' => sha1(strtoupper($params->txt_username.':'.$params->txt_password))
			);
			// echo $new_params['ud_password'];exit;
			$validate_login = $this->db_auth->validate_login($new_params);

			if ($validate_login['success'] !== FALSE)
			{
				$this->session->set_userdata(array(
					'token' => $this->encryption->encrypt($validate_login['data']['ud_id'].':'.$validate_login['data']['ud_username']),
					'username' => $validate_login['data']['ud_username'],
					'user_sub_group' => $validate_login['data']['usg_id'],
					'user_group' => $validate_login['data']['ug_id'],
					'user_fullname' => $validate_login['data']['ud_fullname'],
					'user_img' => $validate_login['data']['ud_img_filename'],
					'user_id' => $validate_login['data']['ud_id']
				));
			}

			return $validate_login;
		}

		if ( ! is_null($this->session->userdata('token')))
		{
			$new_params = $this->decrypt_token();

			$validate_login = $this->db_auth->validate_login($new_params);

			return $validate_login['success'] ?? FALSE;
		}
		
		$this->session->set_userdata(array('_redir' => current_url()));
		redirect('auth/do_logout');
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

	protected function show_404()
	{
		$this->store_params['header_title'] = '404 Error Page';
		$this->store_params['breadcrumb'] = array(
			array('main', 'Beranda', 'fas fa-home'),
			array('main', '404 Error Page', 'fas fa-exclamation-triangle')
		);
		$this->view('errors/html/error_404');
	}

	protected function get_tree_menu($data, $mode = 'str')
	{
		$tree_menu = $this->_generate_tree_menu_array($data);
		$result = array('root' => $tree_menu);

		return $result;
	}

	private function _generate_menu()
	{
		$get_all_menu = $this->db_main->get_all_menu();
		$get_access_menu = $this->db_main->get_access_menu();
		$get_user_group_menu = $this->db_main->get_user_group_menu();
		$get_user_sub_group_menu = $this->db_main->get_user_sub_group_menu();

		$all_menu = $get_all_menu->result();

		$user_menu = array();

		foreach ($all_menu as $k => $v) 
		{
			if ($get_access_menu !== FALSE && in_array($v->id, $get_access_menu)) 
			{
				$user_menu[] = $v;
			}
			elseif ($get_user_group_menu !== FALSE && in_array($v->id, $get_user_group_menu))
			{
				$user_menu[] = $v;
			}
			elseif ($get_user_sub_group_menu !== FALSE && in_array($v->id, $get_user_sub_group_menu))
			{
				$user_menu[] = $v;
			}
		}

		$tree_menu = $this->_generate_tree_menu($user_menu);

		return $tree_menu;
	}

	private function _generate_tree_menu($datas, $parent_id = NULL, $idx = 0)
	{
		$str_menu = FALSE;

		if ($parent_id == '' || $parent_id == ' ' || $parent_id == NULL || $parent_id == 0 || empty($parent_id))
		{
			$parent_id = NULL;
		}

		$idx++;

		foreach ($datas as $data)
		{
			if ($data->parent_id == $parent_id)
			{
				$children = $this->_generate_tree_menu($datas, $data->id, $idx);

				if ($children !== FALSE)
				{
					$str_menu .= '<li class="nav-item has-treeview"><a class="nav-link" href="'.site_url($data->url).'"><i class="nav-icon '.$data->icon.'"></i><p>'.$data->caption.'<i class="fas fa-angle-down right"></i></p></a>'."\n";

					if ($idx > 0)
					{
						$str_menu .= '<ul class="nav nav-treeview">'."\n";
					}

					$str_menu .= $children;

					if ($idx > 0)
					{
						$str_menu .= '</ul>'."\n";
					}

					$str_menu .= '</li>'."\n";
				}
				else
				{
					$str_menu .= '<li class="nav-item"><a class="nav-link'.($this->uri->uri_string() == $data->url ? ' active' : '').'" href="'.site_url($data->url).'"><i class="nav-icon '.$data->icon.'"></i><p>'.$data->caption.'</p></a></li>'."\n";
				}
			}
		}

		return $str_menu;
	}

	private function _generate_tree_menu_array($datas, $parent_id = NULL, $idx = 0)
	{
		$menu = array();

		$idx++;

		foreach ($datas as $data)
		{
			if ($data->parent_id == $parent_id)
			{
				$children = $this->_generate_tree_menu_array($datas, $data->id, $idx);

				if (count($children) > 0)
				{
					$data->children = $children;
				}
				else
				{
					$data->leaf = TRUE;
				}

				$menu[] = $data;
			}
		}

		return $menu;
	}

	private function _asset_proxy($type, $asset, $scope, $mod)
	{
		$file = NULL;

		switch ($scope)
		{
			case 'mod': 
				if ($type == 'image' || $type == 'script' ||  $type == 'style')
				{
					$file = str_replace('..', '', APPPATH).NOOBS_MODULE_DIR.DS.$mod.DS.$type.'s'.DS.$asset;
				}
			break;
			case 'app': 
				if ($type == 'image' || $type == 'script' ||  $type == 'style' ||  $type == 'font')
				{
					$file = NOOBS_APP_DIR.$type.'s'.DS.$asset;
				}
			break;
			case 'front': 
				if ($type == 'image' || $type == 'script' ||  $type == 'style')
				{
					$file = NOOBS_FRONT_DIR.$type.'s'.DS.$asset;
				}
			break;
			case 'pub': 
				$file = NOOBS_NEEDS_DIR.$asset;
			break;
		}

		if (ENVIRONMENT == 'production') $file = str_replace(array('.js', '.css'), array('-min.js', '-min.css'), $file);
		if ( ! empty($file) && file_exists($file) && ! is_dir($file))
		{
			$mime = get_mime_by_extension($file);

			if ( ! $mime) 
			{
				if (preg_match("/\.(woff|eot|ttf|otf)$/", $file, $matches))
				{
					$ext = $matches[1];

					switch ($ext)
					{
						case 'woff': $mime = 'application/x-font-woff'; break;
						case 'eot': $mime = 'application/vnd.ms-fontobject'; break;
						case 'ttf': $mime = 'font/ttf'; break;
						case 'otf': $mime = 'font/otf'; break;
						default: $mime = 'application/octet-stream';
					}
				}
				else $mime = 'application/octet-stream';
			}

			if (filesize($file) == 0) exit();

			$lastmod = filemtime($file);
			$etag = md5_file($file);

			header("Content-Type: " . $mime);
			header("Content-Length: " . filesize($file));
			header("Last-Modified: " . gmdate("D, d M Y H:i:s", $lastmod) . " GMT");
			header("Etag: " . $etag);
			header("Cache-Control: public");

			if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastmod || @trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag)
			{
				header("HTTP/1.1 304 Not Modified");
				exit();
			}

			if ($type == 'style')
			{
				$s = array('$pubimage', '$pubstyle', '$pubscript', '$frontimage', '$frontstyle', '$frontscript', '$appimage', '$appstyle', '$appfont', '$appscript', '$modimage', '$modstyle', '$modscript');
				$r = array(
					normal_site_url($this->uri->segment(1).'/pubimage'),
					normal_site_url($this->uri->segment(1).'/pubstyle'),
					normal_site_url($this->uri->segment(1).'/pubscript'),
					normal_site_url($this->uri->segment(1).'/frontimage'),
					normal_site_url($this->uri->segment(1).'/frontstyle'),
					normal_site_url($this->uri->segment(1).'/frontscript'),
					normal_site_url($this->uri->segment(1).'/appimage'),
					normal_site_url($this->uri->segment(1).'/appstyle'),
					normal_site_url($this->uri->segment(1).'/appfont'),
					normal_site_url($this->uri->segment(1).'/appscript'),
					normal_site_url($this->uri->segment(1).'/modimage'),
					normal_site_url($this->uri->segment(1).'/modstyle'),
					normal_site_url($this->uri->segment(1).'/modscript')
				);

				$tmp = file_get_contents($file);
				$tmp = str_replace($s, $r, $tmp);

				print($tmp);
			} else print(file_get_contents($file));

		} else show_404();
	}
}