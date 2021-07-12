<?php
/*!
 * ---------------------------------------------------------------
 * APOTEK APPLICATION ENVIRONMENT
 * ---------------------------------------------------------------
 *
 * Change some value of variables below to make this application
 * to running well in your personal pc/laptop. Random changes will
 * make this application show some errors. Beware!
 */

/*!
 * ---------------------------------------------------------------
 * PLEASE, LET THEM LIKE THAT.
 * ---------------------------------------------------------------
 */
	$noobs_db_hostname = array();
	$noobs_db_username = array();
	$noobs_db_password = array();
	$noobs_db_database = array();
	$noobs_db_driver = array();
	$noobs_db_active = array();

	require_once 'config.php';

	define('ENVIRONMENT', $noobs_env);

	if (defined('ENVIRONMENT'))
	{
		ini_set('short_open_tag', '1');
		ini_set('log_errors', '1');
		ini_set('date.timezone', 'Asia/Jakarta');
		ini_set('max_execution_time', 0);
		set_time_limit(0);

		switch (ENVIRONMENT)
		{
			case 'development':
				ini_set('display_errors', 1);
				ini_set('display_startup_errors', 1);
				ini_set('track_errors', 1);
				ini_set('html_errors', 1);
				error_reporting(-1);
			break;
			case 'testing':
			case 'production':
				ini_set('display_errors', 0);
				ini_set('display_startup_errors', 0);
				ini_set('track_errors', 0);
				ini_set('html_errors', 0);
				error_reporting(NULL);
			break;
			default:
				header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
				echo 'The application environment is not set correctly.';
				exit(1);
			break;
		}
	}
	
	require_once 'bootstrap.php';