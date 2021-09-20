<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/views/transaksi/tagihan_pembayaran_cioprm_pdf.php
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
		  height: 50px;
		}

		.tdth {
		  border: 1px solid #dddddd;
		  text-align: left;
		  padding: 8px;
		  font-size: 10px;
		}

		.td-th {
		  text-align: right;
		  padding: 8px;
		  font-size: 12px;
		}

		.tr:nth-child(even) {
		  background-color: #dddddd;
		}
	</style>
</head>
<body>
	<table>
		<tr>
			<td width="380px" style="font-size:18px;font-style: bold;">
				<?=strtoupper($company_title)?>
			</td>
		</tr>
		<tr>
			<td style="font-size:11px;font-style: italic;">
				<?=$address?>
			</td>
		</tr>
		<tr>
			<td style="font-size:14px;font-style: bold;">
				<?=$header_title?>
			</td>
		</tr>
		<tr>
			<td>
				Bulan : <?php echo date('F Y'); ?>
			</td>		
		</tr>
		<tr>
			<td>
				<?=$no_tagihan?>
			</td>		
		</tr>
		<tr>
			<td>
				Kepada YTH : 
			</td>
			
		</tr>
	</table>
	<hr>
	<table class="table_strip">	
		<tr>
			<th colspan="8">PT. CIOMAS ADI SATWA Unit PARIAMAN</th>
		</tr>	
		<tr class="tr" >
			<th width="10" rowspan="2" class="tdth" style="text-align: center;">No</th>
			<th class="tdth" rowspan="2" style="text-align: center;">No DO</th>
			<th class="tdth" rowspan="2" style="text-align: center;">Tanggal</th>
			<th class="tdth" colspan="2" style="text-align:center;">Jumlah Feed</th>
			<th class="tdth" rowspan="2"  style="text-align: center;">Nama Peternak</th>
			<th class="tdth" rowspan="2" style="text-align: center;">Alamat</th>
			<th class="tdth" rowspan="2" style="text-align: center;">Jumlah</th>
		</tr>
		<tr class="tr">		
			<!-- <th class="tdth"></th> -->
			<th class="tdth">Jml Ton</th>
			<th class="tdth">Ongkos / Ton</th>
		</tr>
	
		<?php 
		$total = array();
		if(! empty($item)) 
		{
			foreach ($item as $k => $v) {
				$total[] = $v->dos_ongkir;
			?>
				<tr class="tr">
					<td class="tdth"><?php echo $v->num; ?></td>
					<td class="tdth"><?php echo $v->dod_no_trx; ?></td>
					<td class="tdth"><?php echo date('d-m-Y',strtotime($v->so_created_date)); ?></td>
					<td class="tdth"><?php echo $v->dos_filled; ?></td>
					<td class="tdth" style="text-align: right;">Rp. <?php echo $v->c_shipping_area; ?></td>
					<td class="tdth"><?php echo $v->c_name; ?></td>
					<td class="tdth"><?php echo $v->d_address_area; ?></td>
					<td class="tdth" style="text-align: right;">Rp. <?php echo $v->new_ongkir; ?></td>
				</tr>
			<?php
			} 
		} ?>

		<tr class="tr">
			<td colspan="7" class="tdth">Total</td>
			<td class="tdth" style="font-style:bold;">Rp. <?php echo number_format(array_sum($total)); ?></td>
		</tr>
	</table>
	<p style="margin-top: 10pt; margin-left: 283.5pt; margin-bottom: 0pt; text-align: center; line-height: normal;"><strong><span style="font-family: Cambria;font-size: 11px;">Padang, <?php echo date('d F Y');?></span></strong></p>
<p style="margin-top: 0pt; margin-left: 283.5pt; margin-bottom: 0pt; text-align: center; line-height: normal; font-size: 11px;"><strong>Diketahui,</strong></p>
<p style="margin-top: 0pt; margin-left: 283.5pt; margin-bottom: 0pt; text-align: center; line-height: normal; font-size: 11px;"><strong>&nbsp;</strong></p>
<p style="margin-top: 0pt; margin-left: 283.5pt; margin-bottom: 0pt; text-align: center; line-height: normal; font-size: 11px;"><strong>&nbsp;</strong></p>
<p style="margin-top: 0pt; margin-left: 283.5pt; margin-bottom: 0pt; text-align: center; line-height: normal; font-size: 11px;"><strong>&nbsp;</strong></p>
<p style="margin-top: 0pt; margin-left: 283.5pt; margin-bottom: 0pt; text-align: center; line-height: normal; font-size: 11px;"><strong><u>WIWIT SYAFIANITA</u></strong></p>
<p style="margin-top: 0pt; margin-left: 283.5pt; margin-bottom: 0pt; text-align: center; line-height: normal; font-size: 11px;"><strong>Pimpinan Bintang Permata Ekspedisi</strong></p>
<p style="margin-top: 0pt; margin-bottom: 10pt;">&nbsp;</p>
</body>
</html>

