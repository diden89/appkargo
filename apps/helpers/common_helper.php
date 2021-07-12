<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/helpers/common_helper.php
 */

/**
 * Do Clean Content
 * ================
 * Make clean content from string
 */
if ( ! function_exists('do_content'))
{
	function do_content($str)
	{
		$new_str = nl2br($str);
		$new_str = htmlentities($new_str, ENT_QUOTES);
		$new_str = str_replace('\\r\\n', '', $new_str);

		return $new_str;
	}
}

// ------------------------------------------------------------------------

/**
 * Get Clean Content
 * =================
 * Get clean content from string
 */
if ( ! function_exists('get_content'))
{
	function get_content($str)
	{
		$new_str = html_entity_decode($str, ENT_QUOTES);
		$new_str = preg_replace('/\s+/', ' ', $new_str);
		$new_str = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $new_str);

		return $new_str;
	}
}

// ------------------------------------------------------------------------

/**
 * Get Clean Summary
 * =================
 * Get clean summary from string
 */
if ( ! function_exists('get_summary'))
{
	function get_summary($str, $length = 50)
	{
		$new_str = html_entity_decode($str, ENT_QUOTES);
		$new_str = str_replace(array(
			'<br>',
			'<br/>',
			'<br />',
			'<hr>',
			'<hr/>',
			'<hr />',
			'<li>',
			'</li>',
			'<ol>',
			'</ol>',
			'<ul>',
			'</ul>',
		), ' ', $new_str);
		$new_str = preg_replace('/\s+/', ' ', $new_str);
		$new_str = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $new_str);
		$new_str = strip_tags($new_str);
		$str_length = strlen($new_str);

		if ($str_length > $length) $glue = '...';
		else $glue = '';

		$new_str = substr($new_str, 0, $length).$glue;

		return $new_str;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_template_url'))
{
	/**
	 * Get Template Url
	 *
	 * Create a local template url on your basepath
	 *
	 * @param	string	$uri
	 * @return	string
	 */
	function get_template_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->base_url('vendors/template/3.0.0/'.$uri, $protocol);
	}
}