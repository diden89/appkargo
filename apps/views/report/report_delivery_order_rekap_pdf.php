<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/views/report/report_delivery_rekap_pdf.php
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
		 /* width: 100%;*/
		}

		.tdth {
		  border: 1px solid #dddddd;
		  text-align: left;
		  padding: 8px;
		  font-size: 8px;
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
				Periode : <?=$date_range_1?> s/d <?=$date_range_2?>
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
			<th width="10" class="tdth" rowspan="2">No</th>
			<th class="tdth" rowspan="2">No Transaksi</th>
			<th class="tdth" rowspan="2">Nama Pelanggan</th>
			<th class="tdth" rowspan="2">Nama Barang</th>
			<th class="tdth" colspan="2" style="text-align:center;">Transportasi</th>
			<th class="tdth" rowspan="2">Tujuan</th>
			<th class="tdth" rowspan="2">Berat</th>
			<th class="tdth" rowspan="2">Ongkir</th>
			<th class="tdth" rowspan="2">Tanggal</th>
			<th class="tdth" rowspan="2">Status</th>
		</tr>
		<tr class="tr">
			<th class="tdth" >Pengemudi</th>
			<th class="tdth" style="word-break:break-all;">Kendaraan</th>
			
		</tr>
		
		<?php 
		$total = array();
		if(! empty($item)) 
		{
			foreach ($item as $k => $v) {
					$total[] = $v->dod_ongkir;
			?>
				<tr class="tr">
					<td class="tdth"><?php echo $v->num; ?></td>
					<td class="tdth"><?php echo $v->dod_no_trx; ?></td>
					<td class="tdth"><?php echo $v->c_name; ?></td>
					<td class="tdth"><?php echo $v->il_item_name; ?></td>
					<td class="tdth"><?php echo $v->d_name ?></td>
					<td class="tdth"><?php echo $v->ve_license_plate ?></td>
					<td class="tdth"><?php echo $v->rsd_name; ?></td>
					<td class="tdth" style="text-align:center;"><?php echo '<b>'.number_format($v->dod_shipping_qty); ?> Kg</b></td>
					<td class="tdth" style="text-align:right;"><?php echo '<b>Rp. '.number_format($v->dod_ongkir); ?></b></td>
					<td class="tdth"><?php echo date('d-m-Y', strtotime($v->dod_created_date)); ?></td>
					<td class="tdth"><?php echo $v->dod_is_status; ?></td>
				</tr>
			<?php
			} 
		} ?>
		

		
	</table>
</body>
</html>

