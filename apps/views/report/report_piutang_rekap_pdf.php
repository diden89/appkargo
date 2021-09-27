<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/views/report/report_piutang_rekap_pdf.php
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
		  border: 1px dashed #dddddd;
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
				Periode : <?=$date_range_1?> - <?=$date_range_2?>
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
	<table class="table_strip">		
		<tr class="tr">
			<th width="10" class="tdth">No</th>
			<th class="tdth">No Transaksi</th>
			<th class="tdth">Tanggal</th>
			<th class="tdth">Masuk Ke Akun</th>
			<th class="tdth">Keterangan</th>
			<th class="tdth">Total</th>
			<th class="tdth">User Buat</th>
		</tr>
	
		<?php 
		$total = array();
		if(! empty($item)) 
		{
			foreach ($item as $k => $v) {
					$total[] = $v->ci_total;
			?>
				<tr class="tr">
					<td class="tdth"><?php echo $v->num; ?></td>
					<td class="tdth"><?php echo $v->dod_no_trx; ?></td>
					<td class="tdth"><?php echo date('d-m-Y',strtotime($v->dod_created_date)); ?></td>
					<td class="tdth"><?php echo $v->c_name; ?></td>
					<td class="tdth"><?php echo $v->dos_keterangan; ?></td>
					<td class="tdth"><?php echo $v->dos_ongkir; ?></td>
					<td class="tdth"><?php echo $v->c_name; ?></td>
				</tr>
			<?php
			} 
		} ?>

		<tr class="tr">
			<td colspan="5" class="tdth">Total</td>
			<td class="tdth"><?php echo number_format(array_sum($total)); ?></td>
		</tr>
	</table>
</body>
</html>

