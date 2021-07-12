<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/libraries/Pdf_creator.php
 */

class Pdf_creator {
	function __construct()
	{
		chdir(APPPATH.'libraries/mPDF');

		require_once 'vendor/autoload.php';
		
		chdir(APPPATH);
	}
	
	function load($params=[]) {
		if (!isset($params['default_font'])) $params['default_font'] = 'calibri';
		
		return new \Mpdf\Mpdf($params);
	}
}