<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/transaksi/controllers/Tagihan_pembayaran.php
 */

class Tagihan_pembayaran extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/tagihan_pembayaran_model', 'db_tp');
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Tagihan Pembayaran';
		$this->store_params['pages_title'] = 'Tagihan Pembayaran List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('transaksi/tagihan_pembayaran', 'Tagihan Pembayaran')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/transaksi/tagihan_pembayaran.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->store_params['vendor'] = $this->db_tp->load_vendor()->result();

		$this->view('tagihan_pembayaran_view');
	}

	
	public function print_pdf()
	{
		$post = $this->input->post();
		// print_r($post);exit;
		if(! empty($post))
		{
			$get_file_template = $this->db_tp->load_template_laporan($post);
			if($get_file_template->num_rows() > 0)
			{
				$temp = $get_file_template->row();
				$post['temp'] = $temp->tl_file_template;
				$post['tl_name'] = str_replace(" ","_",$temp->tl_name);
				$this->rekap_tagihan_pembayaran($post);

			}
		}
		else $this->show_404();


	}
	public function rekap_tagihan_pembayaran($params)
	{
		$data = array();
	
		$get_data = ($params['tipe_so'] == 'so') ? $this->db_tp->load_data_rekap_tagihan($params) : $this->db_tp->load_data_rekap_tagihan_transfer($params);

		$data_company = $this->db_main->get_company();

		$result = $get_data->result();
		// print_r($params);exit;
		$number = 1;
		$total_ong = array();
		foreach ($result as $k => $v) 
		{
			$v->num = $number;
			$v->d_name_pengemudi = $v->d_name.' / '.$v->ve_license_plate;
			$v->d_address_area = $v->c_address.'<br>Kec. '.$v->rsd_name;
			$v->dod_shipping_qty = number_format($v->dod_shipping_qty);
			$v->dos_filled_view = number_format($v->dos_filled);
			$v->dod_created_date = date('d-m-Y',strtotime($v->dod_created_date));
			$v->dos_created_date = date('d-m-Y H:i:s',strtotime($v->dos_created_date));

			if(! empty($v->dos_filled)) 
			{
				$v->new_ongkir = number_format($v->dos_ongkir);
				$v->dod_is_status = $v->dos_status;
			}
			else
			{
				$v->new_ongkir = 0;
				$v->dod_is_status = $v->dod_is_status;
			}

			$total_ong[] = $v->dos_ongkir;

			$number++;
		}

		$data['item'] = $result;

		// print_r($params);exit;
		$data['header_title'] = 'TAGIHAN EKSPEDISI';

		if($data_company->num_rows() > 0)
		{
			$data_company = $data_company->row();
			$data['company_title'] = ( ! empty($params['nama_perusahaan'])) ? $params['nama_perusahaan'] : $data_company->rc_name;
			$data['address'] = ( ! empty($params['alamat_perusahaan'])) ? $params['alamat_perusahaan'] : $data_company->rc_address;
			$data['phone'] = ( ! empty($params['no_telp'])) ? $params['no_telp'] : $data_company->rc_phone;
			$data['owner'] = ( ! empty($params['pimpinan'])) ? $params['pimpinan'] : $data_company->rc_owner;
			$data['logo'] = $data_company->rc_logo;

		}
		
		$data['date_range_1'] = (isset($params['date_range_1'])) ? $params['date_range_1'] : '';
		$data['date_range_2'] = (isset($params['date_range_2'])) ? $params['date_range_2'] : '';
		$data['tanggal_penagihan'] = (isset($params['tanggal_penagihan'])) ? $this->tanggal_indo($params['tanggal_penagihan']) : '';
		$data['no_tagihan'] = $params['no_tagihan'];
		$data['note'] = $params['note'];

		$ong = array_sum($total_ong);
		
		$data['terbilang'] = $this->penyebut($ong);
		
			$view = $this->load->view('tagihan/'.$params['temp'], $data, TRUE);

				$this->load->library('pdf_creator');

				$pdf_creator = $this->pdf_creator->load([
				    'mode' => 'utf-8',
				    'format' => 'A4',
				    'margin_top' => 5,
				    'margin_bottom' => 25,
					'margin_header' => 40,
					'margin_footer' => 15
				]);

				$pdf_creator->setHtmlFooter($this->session->userdata('username').'|Created Date : '.date('d-m-Y'));
				$pdf_creator->WriteHTML($view);

				$pdf_creator->Output('Tagihan Pembayaran_'.$params['tl_name'].'_'.date('YmdHis').'.pdf', 'I');

				
	}

	
	function penyebut($nilai) {
		$nilai = abs($nilai);

		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}

	function tanggal_indo($tanggal)
	{
		$bulan = array (1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
		$split = explode('-', $tanggal);
		return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
	}


}