<?php
/*!
 * ---------------------------------------------------------------
 * START THE APPLICATION AND LET'S GET IT ON!!
 * ---------------------------------------------------------------
 *
 * Do not change this section 'til the end of page!
 */
	if ( ! defined('DS')) define('DS', DIRECTORY_SEPARATOR);

	$doc_path = explode('/', $_SERVER['DOCUMENT_ROOT']);
	$doc_dir = explode(DS, __DIR__);
	$front_dir = explode(DS, __DIR__);
	$cnt_doc_dir = count($doc_dir);

	for ($x = 0; $x < $cnt_doc_dir; $x++)
	{
		if (is_array($doc_path))
		{
			$doc_path = implode('/', $doc_path);
			$doc_dir = implode(DS, $doc_dir);
		}
		
		if ( ! is_dir($doc_dir.DS.$noobs_vendordir))
		{
			$doc_path = explode('/', $doc_path);
			$doc_dir = explode(DS, $doc_dir);
			
			array_pop($doc_path);
			array_pop($doc_dir);
			
			$doc_path = implode('/', $doc_path);
			$doc_dir = implode(DS, $doc_dir);
		}
	}

	$app_dir = implode(DS, $front_dir);
	$noobs_['NOOBS_TITLE'] = $noobs_title;
	$noobs_['NOOBS_TITLE_1'] = $noobs_title_1;
	$noobs_['NOOBS_TITLE_2'] = $noobs_title_2;
	$noobs_['NOOBS_NEEDS_DIR'] = $doc_dir.DS.$noobs_vendordir.DS;
	$noobs_['NOOBS_BASE_DIR'] = $doc_dir.DS;
	$noobs_['NOOBS_BASE_URL'] = '/';
	$noobs_['NOOBS_APP_DIR'] = $app_dir.DS;
	$noobs_['NOOBS_IMAGES_DIR'] = $app_dir.DS.'images'.DS;
	$noobs_['NOOBS_FILES_DIR'] = $app_dir.DS.'files'.DS;
	$noobs_['NOOBS_ENCRYPTION_KEY'] = sha1(md5($noobs_title));
	$noobs_['NOOBS_DB_START'] = $noobs_db_start;
	$noobs_['NOOBS_LANGUAGE'] = $noobs_language;
	$noobs_['NOOBS_EXPIRATION'] = $noobs_expiration;
	$noobs_['NOOBS_UPDATE_TIME'] = $noobs_update_time;
	$noobs_['NOOBS_ENV'] = $noobs_env;
	$noobs_['NOOBS_DEFAULT_CONTROL'] = $noobs_default_controller;
	$noobs_['NOOBS_MODULE_DIR'] = $noobs_module_dir;
	$noobs_['NOOBS_MODULE_URL'] = $noobs_module_url;

	if (isset($noobs_sessdir) && ! empty($noobs_sessdir))
	{
		$noobs_['NOOBS_APP_SESSION'] = $noobs_sessdir;
	}
	else
	{
		$noobs_['NOOBS_APP_SESSION'] = NOOBS_APP_DIR.'apps'.DS.'sessions';
	}

	for ($x = 0; $x < count($noobs_db_hostname); $x++)
	{
		$noobs_['NOOBS_DB_COUNT'] = count($noobs_db_hostname);
		$noobs_['NOOBS_DB_HOSTNAME'.$x] = $noobs_db_hostname[$x];
		$noobs_['NOOBS_DB_USERNAME'.$x] = $noobs_db_username[$x];
		$noobs_['NOOBS_DB_PASSWORD'.$x] = $noobs_db_password[$x];
		$noobs_['NOOBS_DB_DATABASE'.$x] = $noobs_db_database[$x];
		$noobs_['NOOBS_DB_DRIVER'.$x] = $noobs_db_driver[$x];
		$noobs_['NOOBS_DB_PCONNECT'.$x] = $noobs_db_pconnect[$x];
		$noobs_['NOOBS_DB_ACTIVE'.$x] = $noobs_db_active[$x];
	}

	foreach ($noobs_ as $k => $v)
	{
		if ( ! defined($k)) define($k, $v);
	}

	$i = '';

	for ($x = 0; $x < (count(explode('/', $_SERVER['REQUEST_URI'])) - 2); $x++)
	{
		$i .= '../';
	}

	$system_path = NOOBS_NEEDS_DIR.'codeigniter'.DS.'3.1.9';
	$application_folder = 'apps';
	$view_folder = '';

	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (($_temp = realpath($system_path)) !== FALSE)
	{
		$system_path = $_temp.DIRECTORY_SEPARATOR;
	}
	else
	{
		$system_path = strtr(
			rtrim($system_path, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		).DIRECTORY_SEPARATOR;
	}

	if ( ! is_dir($system_path))
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
		exit(3); // EXIT_CONFIG
	}

	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
	define('BASEPATH', $system_path);
	define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
	define('SYSDIR', basename(BASEPATH));

	if (is_dir($application_folder))
	{
		if (($_temp = realpath($application_folder)) !== FALSE)
		{
			$application_folder = $_temp;
		}
		else
		{
			$application_folder = strtr(
				rtrim($application_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
	{
		$application_folder = BASEPATH.strtr(
			trim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3);
	}

	define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

	if ( ! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.'views';
	}
	elseif (is_dir($view_folder))
	{
		if (($_temp = realpath($view_folder)) !== FALSE)
		{
			$view_folder = $_temp;
		}
		else
		{
			$view_folder = strtr(
				rtrim($view_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.strtr(
			trim($view_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3);
	}

	define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);

/*!
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
	require_once BASEPATH.'core/CodeIgniter.php';
