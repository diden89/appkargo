<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author algazasolution
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/trademark/controllers/Trademark.php
 */

class Trademark extends NOOBS_Controller {
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->show_404();
	}
}