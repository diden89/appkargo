<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Andy1t
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/libraries/Xls_reader.php
 */


chdir(APPPATH.'libraries/phpoffice_phpspreadsheet_1.10.1.0');

require_once 'vendor/autoload.php';

chdir(APPPATH);

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use \PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Xls_reader extends Coordinate
{
	private $file;
	private $worksheet;
	private $data = array();

	public function read_file($file)
	{
		$reader = new Xlsx();

		$reader->setReadDataOnly(TRUE);

		$this->file = $reader->load($file);

		$this->worksheet = $this->file->getActiveSheet();
	}

	public function create_data($sheet = 0, $have_header = TRUE, $start = 1, $limit = 0)
	{
		$rows = $this->num_of_rows();
		$cols = $this->num_of_cols();

		if ($rows == 0 && $cols == 0) 
		{
			return FALSE;
			exit;
		}

		$sheet = $this->worksheet;

		$header = array();
		$tot;
		
		$rowIterator = $this->worksheet->getRowIterator();

		if ($have_header) 
		{
			$break = 1;
			$iteration = 0;
			
			foreach ($rowIterator as $row) 
			{
				if ($break !== $iteration) 
				{
					$cellIterator = $row->getCellIterator();
					foreach ($cellIterator as $cell) 
					{
						$header[] = $cell->getValue() !== NULL ? $cell->getValue() : '';
					}

					$iteration++;
				}
			}
		} else $start = 0;

		$ret = array();
		$iteration = 0;

		foreach ($rowIterator as $row) 
		{
			$line = array();

			if ($iteration >= $start)
			{
				$cellIterator = $row->getCellIterator();

				foreach ($cellIterator as $cell) 
				{
					$line[] = $cell->getValue() !== NULL ? $cell->getValue() : '';
				}

				$ret[] = $line;
			}

			$iteration++;
		}

		$result = new stdClass();

	    $result->header = $header;
	    $result->data = $ret;

		return $result;
	}

	public function num_of_rows()
	{
		return $this->worksheet->getHighestRow();
	}

	public function num_of_cols()
	{
		return $this->columnIndexFromString($this->worksheet->getHighestColumn());
	}

	public function excel_to_time_timestamp($value)
	{
		return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
	}
}