<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/views/report/report_laba_rugi_pdf.php
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$header_title?></title>
	<style>
		.table_strip {
		  font-family: arial;
		  border-collapse: collapse;
		  width: 100%;
		}

		.tdth {
		  border: 1px solid #dddddd;
		  text-align: left;
		  padding: 8px;
		  font-size: 10px;
		}

		.tr:nth-child(even) {
		  background-color: #dddddd;
		}
	</style>
</head>
<body>
	<table>
		<tr>
			<td rowspan="4">
				<img src="<?php echo base_url('images/0b30659b-8f94-4d5f-9695-a8a3441d376a.jpg'); ?>" width="100px">
			</td>
			<td>
				<h3><?=$header_title?></h3>
			</td>
			<td>
				Periode : <?=$bulan?> <?=$tahun?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$company_title?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$address?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$phone?>
			</td>
			
		</tr>
	</table>
	<hr>
	
</body>
</html>

