<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author Sikelopes
 * @edit Diden89
 * @version 1.0
 * @access Public
 * @path /appkargo/apps/views/report/report_piutang_detail_pdf.php
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
				Periode : <?=$date_range_1?> - <?=$date_range_2?>
			</td>
		</tr>
		<tr>
			<td>
				<?=$company_title?>
			</td>
		</tr>
		<tr>
			<td style="width:350px">
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
		<?php 
		// print_r($item);exit;
		if(! empty($item)) 
		{
			foreach($item as $k => $v)
			{
				?>
				<tr class="tr">
					<th class="tdth" colspan="7"><?php echo $v['so_no_trx'];?></th>
					<th class="tdth"><?php echo $v['tot_prog_dos'];?></th>
					<th class="tdth" colspan="3"><?php echo 'Rp. '.$v['so_total_amount'];?></th>
				</tr>
				<br>
					<tr class="tr">
						<th width="10" class="tdth">No</th>
						<th class="tdth">Tipe Order</th>
						<th class="tdth">No Transaksi</th>
						<th class="tdth">Peternak</th>
						<th class="tdth">Barang</th>
						<th class="tdth">Pengemudi</th>
						<th class="tdth">Alamat</th>
						<th class="tdth">Total Barang</th>
						<th class="tdth">Ongkir</th>
						<th class="tdth">tanggal</th>
					</tr>
				<?php
				foreach($v['detail'] as $dk => $vk)
				{
					?>
					<tr class="tr">
						<td class="tdth"><?php echo $vk->num; ?></td>
						<td class="tdth"><?php echo $vk->so_tipe_show; ?></td>
						<td class="tdth"><?php echo $vk->dod_no_trx; ?></td>
						<td class="tdth"><?php echo $vk->c_name; ?></td>
						<td class="tdth"><?php echo $vk->il_item_name; ?></td>
						<td class="tdth"><?php echo $vk->d_name_pengemudi; ?></td>
						<td class="tdth"><?php echo $vk->d_address_area; ?></td>
						<td class="tdth"><?php echo $vk->dos_filled_show; ?></td>
						<td class="tdth"><?php echo '<b>Rp. '.$vk->new_ongkir; ?></b></td>
						<td class="tdth"><?php echo date('d-m-Y',strtotime($vk->dod_created_date)); ?></td>
					</tr>
					<?php
				}
			}
		}

		?>
	</table>
</body>
</html>

