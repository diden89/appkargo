<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author diden89
 * @version 1.0
 * @access Public
 * @link /rab_frontend/apps/module_frontend/report/controllers/Neraca.php
 */

class Neraca extends NOOBS_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('report/neraca_model', 'db_neraca');
		
	}

	public function index()
	{
		$this->store_params['page_active'] = isset($this->store_params['page_active']) ? $this->store_params['page_active'] : 'Home';
		$this->store_params['header_title'] = 'Neraca';
		$this->store_params['pages_title'] = 'Neraca List';
		$this->store_params['breadcrumb'] = array(
			array('', 'Home'),
			array('report/neraca', 'Neraca')
		);
		
		$this->store_params['source_top'] = array(
			'<link rel="stylesheet" href="'.base_url('styles/jquerysctipttop.css').'">'
		);

		$this->store_params['source_bot'] = array(
			'<script src="'.base_url('scripts/report/neraca.js').'"></script>',
			'<script src="'.base_url('vendors/jquery_acollapsetable/jquery.aCollapTable.js').'"></script>'
		);

		$this->view('neraca_view');
	}

	
	public function print_pdf()
	{
		$post = $this->input->post();
		// print_r($post);exit;
		
		$this->laporan_neraca($post);

	}

	public function laporan_neraca($params)
	{
		$data_company = $this->db_main->get_company();

		$data['header_title'] = 'Neraca';

		// $data['akun'] = $this->_build_data();
		$years_start  = date('Y',strtotime($params['range_date']));
		$month_select  = date('m',strtotime($params['range_date']));

		$params['date_range_1'] = $years_start.'-01-01';
		$dd = $years_start.'-'.$month_select.'-05';
		$dt =  date('Y-n-t',strtotime($dd));
		$params['date_range_2'] = date('Y-m-t', strtotime($dt));
		
		$akun_header_laba_ditahan = $this->db_neraca->get_akun_header(array("PENDAPATAN", 'BIAYA'),'laba_ditahan')->result();

		$n=0;
		foreach($akun_header_laba_ditahan as $header_laba => $laba_ditahan)
		{
			$akun_detail = $this->db_neraca->get_akun_detail($laba_ditahan->rah_id,$params)->result();
		
			foreach($akun_detail as $k => $v)
			{
				
				$sum[$n][] = $v->total;

			}
			$data['total_laba_ditahan'][] = array_sum($sum[$n]);
			$data['total_name_laba_ditahan'][] = 'TOTAL '.strtoupper($laba_ditahan->rah_name);

			$n++;
		}

		$labarugi = $data['total_laba_ditahan'][0] * 2;
		foreach($data['total_laba_ditahan'] as $tot)
		{
			$labarugi -= $tot;
			// echo $tot;
		}
		$data['laba_rugi'] = $labarugi;

		$akun_header = $this->db_neraca->get_akun_header(array("AKTIVA", 'MODAL'))->result();
		$i = 0;
		// print_r($akun_header);exit;
		$piutang_usaha = 0;
		foreach($akun_header as $header => $rah)
		{
			$akun_detail = $this->db_neraca->get_akun_detail($rah->rah_id,$params)->result();
			foreach($akun_detail as $k => $v)
			{

				if($v->rad_is_bank == 'Y')
				{
					$get_amount_to = $this->db_neraca->get_amount_kas($params,array('trx_rad_id_to' => $v->rad_id));
					$get_amount_from = $this->db_neraca->get_amount_kas($params,array('trx_rad_id_from' => $v->rad_id));

					$amount_to = '';
					$amount_from = '';
					
					if($get_amount_to->num_rows() > 0)
					{
						$to = $get_amount_to->row();
						$amount_to = $to->amount;
					}
					else
					{
						$amount_to = '0';
					}

					if($get_amount_from->num_rows() > 0)
					{
						$from = $get_amount_from->row();
						$amount_from = $from->amount;
					}
					else
					{
						$amount_from = '0';
					}
					
					$selisih = $amount_to - $amount_from;
					$v->total = $selisih;
				}
				if($v->rad_id == '24')
				{
					$piutang_usaha = $v->total;
				}

				if($v->rad_id == '34')
				{
					$v->total = $data['laba_rugi'] + $piutang_usaha;
				}

				$total[$i][] = $v->total;
			}
			$data['total'][] = array_sum($total[$i]);
			$data['total_name'][] = 'TOTAL '.strtoupper($rah->rah_name);


			$data['akun'][$rah->rah_name][] = $this->_build_data($akun_detail);
			$i++;
		}


		// print_r($data);exit;
		$total_kewajiban = $data['total'][0] * 2;
		foreach($data['total'] as $total_modal)
		{
			$total_kewajiban = $total_modal;
			// echo $tot;
		}
		
		$data['total_kewajiban'] = $total_kewajiban;
		// print_r($data);exit;
		
		if($data_company->num_rows() > 0)
		{
			$data_company = $data_company->row();
			$data['company_title'] = $data_company->rc_name;
			$data['address'] = $data_company->rc_address;
			$data['phone'] = $data_company->rc_phone;
			$data['logo'] = $data_company->rc_logo;

		}
		$data['bulan'] = $this->month_name(date('n',strtotime($params['range_date'])));
		$data['tahun'] = date('Y',strtotime($params['range_date']));
		$data['periode'] = date('d-m-Y', strtotime($params['date_range_2']));
		
		$view = $this->load->view('report/neraca_pdf', $data, TRUE);

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

		$pdf_creator->Output('Neraca_'.date('YmdHis').'.pdf', 'I');

	}

	public function _build_data($data)
	{
		$tree_detail_list = $this->_buildTree($data,NULL,0);

		return $tree_detail_list;
	}

	public function _buildTree($datas, $parent_id = NULL, $idx = 0) 
	{
	    // $akun_detail = array();
	    $akun_detail = "";

		if ($parent_id == '' || $parent_id == ' ' || $parent_id == NULL || $parent_id == 0 || empty($parent_id))
		{
			$parent_id = NULL;
		}

		$idx++;

		foreach ($datas as $data)
		{

			$dash = ($parent_id !== NULL) ? str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $idx) .'' :'';

			if ($data->rad_parent_id == $parent_id)
			{
				$children = $this->_buildTree($datas, $data->rad_id, $idx);

				if ($children != "")
				{

					$akun_detail .= '<tr>';
					$akun_detail .= '<td>'.$dash.strtoupper($data->rad_name).'</td>';
					$akun_detail .= '<td></td>';
					$akun_detail .= '</tr>';
					
					if ($idx > 0)
					{
						$akun_detail .= $children;
					}
				
				}
				else
				{
					
					if($parent_id != NULL && $parent_id != '')
					{					
						$akun_detail .= '<tr>';
						$akun_detail .= '<td>'.$dash.strtoupper($data->rad_name).'</td>';
						$akun_detail .= '<td style="text-align:right;">'.number_format($data->total).'</td>';
						$akun_detail .= '</tr>';						
					}
					else
					{

						$akun_detail .= '<tr>';
						$akun_detail .= '<td>'.$dash.strtoupper($data->rad_name).'</td>';
						$akun_detail .= '<td style="text-align:right;"></td>';
						// $akun_detail .= '<td style="text-align:right;">'.number_format($data->total).'</td>';
						$akun_detail .= '</tr>';
					}	
				}
			}
		}

		return $akun_detail;
	}

	public function month_name($params)
	{
		$month = '';
		if($params == '01')
		{
			return $month = 'Januari';
		}
		else if($params == '02')
		{
			return $month = 'Februari';
		}
		else if($params == '03')
		{
			return $month = 'Maret';
		}
		else if($params == '03')
		{
			return $month = 'Maret';
		}
		else if($params == '04')
		{
			return $month = 'April';
		}
		else if($params == '05')
		{
			return $month = 'Mei';
		}
		else if($params == '06')
		{
			return $month = 'Juni';
		}
		else if($params == '07')
		{
			return $month = 'Juli';
		}
		else if($params == '08')
		{
			return $month = 'Agustus';
		}
		else if($params == '09')
		{
			return $month = 'September';
		}
		else if($params == '10')
		{
			return $month = 'Oktober';
		}
		else if($params == '11')
		{
			return $month = 'November';
		}
		else
		{
			return $month = 'Desember';
		}
		
	}

}