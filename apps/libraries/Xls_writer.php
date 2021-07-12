<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package RAB
 * @copyright Noobscript
 * @author Sikelopes
 * @version 1.0
 * @access Public
 * @path /payroll/apps/libraries/Xls_writer.php
 */

chdir(APPPATH.'libraries/phpoffice_phpspreadsheet_1.10.1.0');

require_once 'vendor/autoload.php';

chdir(APPPATH);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Xls_writer {
	private $_spreadsheet;
	private $_worksheet;
	private $_config = [];
	private $_title = '';
	private $_fields = [];
	private $_headers = [];
	private $_headers2 = [];
	private $_ar_headers_merge = [];
	private $_zero = [];
	private $_data = [];
	private $_body_row_start = 0;
	private $_header_row_last = 1;

	function __construct()
	{
		$this->_spreadsheet = new Spreadsheet();
	}

	public function set_title($title)
	{
		$this->_title = $title;
	}

	public function config($config)
	{
		$ar_config = $config;

		$this->_config = (array) json_decode($ar_config['cols']);

		$this->_fields = $this->_config['colsIdx'];
		$this->_headers = $this->_config['colsName'];
		$this->_zero = isset($this->_config['colsZero']) ? $this->_config['colsZero']: array();

		if (isset($this->_config['colsName2'])) $this->_headers2 = $this->_config['colsName2'];
		if (isset($this->_config['colsMerge'])) $this->_ar_headers_merge = $this->_config['colsMerge'];
		if (isset($ar_config['bodyRowStart'])) $this->_body_row_start = $ar_config['bodyRowStart'];
		if (isset($ar_config['headerRowLast'])) $this->_header_row_last = $ar_config['headerRowLast'];
	}

	public function store_data($data)
	{
		$this->_data = $data;
	}

	public function add_sheet($sheet)
	{
		$worksheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($this->_spreadsheet, $sheet);

		$this->_spreadsheet->addSheet($worksheet, 0);
		$this->_spreadsheet->setActiveSheetIndexByName($sheet);

		$this->_worksheet = $this->_spreadsheet->getActiveSheet();
	}

	public function save($filename)
	{
		$this->_create_grid();

		$writer = new Xlsx($this->_spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	private function _get_header_style()
	{
		return [
			'font' => [
				'bold' => true,
				'color' => ['rgb' => '000000'],
				'name' => 'Arial',
				'size' => '10',
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'color' => ['rgb' => 'CCCCCC']
			]
		];
	}

	private function _get_body_style()
	{
		return [
			'font' => [
				'color' => ['rgb' => '000000'],
				'name' => 'Arial',
				'size' => '10',
				
			]
		];
	}

	private function _create_grid()
	{
		// if ( ! empty($this->_title))
		// {
		// 	$this->_worksheet->setCellValue('A1', $this->_title);
		// }

		$header_style = $this->_get_header_style();
		$char = 'A';

		for ($x = 0; $x < count($this->_headers); $x++)
		{
			$this->_worksheet->setCellValue($char.'1', $this->_headers[$x]);
			$this->_worksheet->getColumnDimension($char)->setAutoSize(true);

			if (($x + 1) != count($this->_headers))
			{
				$char++;
			}
		}

		// if (count($this->_headers2) > 0)
		// {
		// 	$char = 'A';

		// 	for ($x = 0; $x < count($this->_headers2); $x++)
		// 	{
		// 		$this->_worksheet->setCellValue($char.'3', $this->_headers2[$x]);
		// 		$this->_worksheet->getColumnDimension($char)->setAutoSize(true);

		// 		if (($x + 1) != count($this->_headers2))
		// 		{
		// 			$char++;
		// 		}
		// 	}
		// }

		$this->_worksheet->getStyle('A1'.':'.$char.$this->_header_row_last)->applyFromArray($header_style);

		// if ( ! empty($this->_title))
		// {
		// 	$this->_worksheet->mergeCells('A1'.':'.$char.'1');
		// }

		// if (count($this->_ar_headers_merge) > 0)
		// {
		// 	for ($x = 0; $x < count($this->_ar_headers_merge); $x++)
		// 	{
		// 		$this->_worksheet->mergeCells($this->_ar_headers_merge[$x]);
		// 	}
		// }

		$first_row = 2;

		if ($this->_body_row_start > 0) $first_row = $this->_body_row_start;

		$row = $first_row;
		$body_style = $this->_get_body_style();

		foreach ($this->_data as $k => $v)
		{
			$char = 'A';

			for ($x = 0; $x < count($this->_fields); $x++)
			{
				$field = $this->_fields[$x];

				if (isset($v[$field]) && ! is_null($v[$field]))
				{
					$value = $v[$field];

					if (in_array($field, $this->_zero))
					{
						$this->_worksheet->setCellValueExplicit($char.$row, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					}
					else if (strpos($value, '=', 0) !== false) 
					{
						$this->_worksheet->setCellValueExplicit($char.$row, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
					}
					else
					{
						$this->_worksheet->setCellValue($char.$row, $value);
					}
				}

				if (($x + 1) != count($this->_headers))
				{
					$char++;
				}
			}

			$this->_worksheet->getStyle('A'.$row.':'.$char.$row)->applyFromArray($body_style);

			$row++;
		}

		$last_row = count($this->_data) + $first_row - 1;
	}
}