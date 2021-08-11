	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/*!
	 * @package APPKARGO
	 * @copyright Noobscript
	 * @author Sikelopes
	 * @edit Diden89
	 * @version 1.0
	 * @access Public
	 * @path /appkargo/apps/module_frontend/transaksi/controllers/Daftar_delivery_order.php
	 */

	class Daftar_delivery_order extends NOOBS_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('transaksi/daftar_delivery_order_model', 'db_daftar_delivery_order');
		}

		public function index()
		{
			$this->store_params['header_title'] = 'Daftar Delivery Order';
			$this->store_params['breadcrumb'] = array(
				array('', 'Home'),
				array('transaksi/daftar_delivery_order', 'Daftar Delivery Order')
			);

			$this->store_params['source_bot'] = array(
				'<script src="'.base_url('vendors/jquery-number-master/jquery.number.js').'"></script>',
				'<script src="'.base_url('scripts/transaksi/daftar_delivery_order.js').'"></script>',
			);

			$this->store_params['item'] = [];
			$date = date('d-m-Y H:i:s');
			$date = strtotime($date);
			$date = strtotime("-7 day", $date);
			// echo date('d-m-Y H:i:s', $date);

			$params['date_range1'] = date('Y-m-d H:i:s', $date);
			$params['date_range2'] = date('Y-m-d H:i:s');
			$load_data_daftar_delivery_order = $this->db_daftar_delivery_order->load_data_daftar_delivery_order($params);

			if ($load_data_daftar_delivery_order->num_rows() > 0)
			{
				$num = 0;
				$result = $load_data_daftar_delivery_order->result();

				foreach ($result as $k => $v)
				{
					$num++;

					$v->num = $num;
				}

				$this->store_params['item'] = $result;
			}

			$this->view('daftar_delivery_order_view');
		}

		public function load_do_data()
		{
			$post = $this->input->post(NULL, TRUE);

			// print_r($post);exit;
			if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'load_data_daftar_delivery_order')
			{
				unset($post['action']);

				$load_data_daftar_delivery_order = $this->db_daftar_delivery_order->load_data_daftar_delivery_order($post);

				if ($load_data_daftar_delivery_order->num_rows() > 0) 
				{
					$result = $load_data_daftar_delivery_order->result();
					$num = 0;

					foreach ($result as $k => $v)
					{
						$num++;

						$v->num = $num;
						$v->dod_created_date = date('d-m-Y H:i:s',strtotime($v->dod_created_date));
						$v->dod_shipping_qty = number_format($v->dod_shipping_qty);
						$v->dod_ongkir = number_format($v->dod_ongkir);
					}

					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
			}
			else $this->show_404();
		}

		public function load_daftar_delivery_order_form()
		{
			if (isset($_POST['action']) && $_POST['action'] == 'load_daftar_delivery_order_form')
			{
				$post = $this->input->post(NULL, TRUE);
				$params = array(
					'table' => 'province'
				);

				$post['sales_order'] = $this->db_daftar_delivery_order->get_option_so()->result();
				$post['customer'] = $this->db_daftar_delivery_order->get_option_customer()->result();
				$post['vehicle'] = $this->db_daftar_delivery_order->get_option_vehicle()->result();
				$post['driver'] = $this->db_daftar_delivery_order->get_option_driver()->result();
				$post['vendor'] = $this->db_daftar_delivery_order->get_option_vendor()->result();
				$post['item_list'] = $this->db_daftar_delivery_order->get_option_item_list()->result();
				$get_last_notrx = $this->db_daftar_delivery_order->get_last_notrx();

				if($get_last_notrx->num_rows() > 0)
				{
					$notrx = $get_last_notrx->row();
					$last_notrx = $notrx->notrx + 1;
				}
				else
				{
					$last_notrx = 1;
				}

				$post['last_notrx'] = sprintf('%04d',$last_notrx);
				

				if($post['mode'] == 'edit')
				{
					$post['data'] = $this->db_daftar_delivery_order->load_data_daftar_delivery_order($post)->row();
				}
		
				$this->_view('daftar_delivery_order_form_view', $post);
			}
			else $this->show_404();
		}

		public function load_update_status_form()
		{
			if (isset($_POST['action']) && $_POST['action'] == 'load_update_status_form')
			{
				$post = $this->input->post(NULL, TRUE);
						
				$this->_view('update_status_form_view', $post);
			}
			else $this->show_404();
		}

		public function get_detail_so_option()
		{
			$post = $this->input->post(NULL, TRUE);

			// print_r($post);exit;
			if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_detail_so_option')
			{
				unset($post['action']);

				$get_detail_so_option = $this->db_daftar_delivery_order->get_detail_so_option($post);

				if ($get_detail_so_option->num_rows() > 0) 
				{
					$result = $get_detail_so_option->result();

					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
			}
			else $this->show_404();
		}

		public function get_realisasi_qty() //dipakai
		{
			$post = $this->input->post(NULL, TRUE);


			if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_realisasi_qty')
			{
				unset($post['action']);

				$get_realisasi_qty = $this->db_daftar_delivery_order->get_realisasi_qty($post);

				if ($get_realisasi_qty->num_rows() > 0) 
				{
					$res = $get_realisasi_qty->row();
					$qty = (! empty($res->qty_real) && $res->qty_real !== "") ? $res->qty_real : '0';
					echo json_encode(array('success' => TRUE, 'qty_real' => $qty));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
			}
			else $this->show_404();
		}

		public function get_ongkir_district()
		{
			$post = $this->input->post(NULL, TRUE);


			if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_ongkir_district')
			{
				unset($post['action']);

				$get_ongkir_district = $this->db_daftar_delivery_order->get_ongkir_district($post);

				if ($get_ongkir_district->num_rows() > 0) 
				{
					$res = $get_ongkir_district->row();

					echo json_encode(array('success' => TRUE, 'ongkir_temp' => $res->c_shipping_area));
				}
				else echo json_encode(array('success' => FALSE, 'ongkir_temp' => '0'));
			}
			else $this->show_404();
		}

		public function get_item_list_option()
		{
			$post = $this->input->post(NULL, TRUE);


			if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_item_list_option')
			{
				unset($post['action']);

				$get_item_list_option = $this->db_daftar_delivery_order->get_item_list_option($post);

				if ($get_item_list_option->num_rows() > 0) 
				{
					$result = $get_item_list_option->result();

					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
			}
			else $this->show_404();
		}

		public function get_customer_option() //dipakai
		{
			$post = $this->input->post(NULL, TRUE);


			if (isset($post['action']) && ! empty($post['action']) && $post['action'] == 'get_customer_option')
			{
				unset($post['action']);

				$get_customer_option = $this->db_daftar_delivery_order->get_customer_option($post);

				if ($get_customer_option->num_rows() > 0) 
				{
					$result = $get_customer_option->result();

					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data Not Found!'));
			}
			else $this->show_404();
		}

		public function load_data_daftar_delivery_order()
		{
			if (isset($_POST['action']) && $_POST['action'] == 'load_data_daftar_delivery_order')
			{
				$post = $this->input->post(NULL, TRUE);
				$load_data_daftar_delivery_order = $this->db_daftar_delivery_order->load_data_daftar_delivery_order($post);
				// print_r($_POST);exit;
				if ($load_data_daftar_delivery_order->num_rows() > 0) 
				{
					$result = $load_data_daftar_delivery_order->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->no = $number;

						$number++;
					}

					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
			}
			else $this->show_404();
		}

		public function load_data_delivery_detail_do()
		{
			if (isset($_POST['action']) && $_POST['action'] == 'load_data_delivery_detail_do')
			{
				// print_r($_POST);exit;
				$post = $this->input->post(NULL, TRUE);
				$load_data_detail_do = $this->db_daftar_delivery_order->load_data_detail_do($post);
				if ($load_data_detail_do->num_rows() > 0) 
				{
					$result = $load_data_detail_do->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->no = $number;

						$number++;
					}
					
					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
			}
			else $this->show_404();
		}

		public function print_delivery_order() //dipakai
		{
			print_r($_POST);exit;
			if (isset($_POST['action']) && $_POST['action'] == 'load_data_delivery_detail_do')
			{
				$post = $this->input->post(NULL, TRUE);
				$load_data_detail_do = $this->db_daftar_delivery_order->load_data_detail_do($post);
				if ($load_data_detail_do->num_rows() > 0) 
				{
					$result = $load_data_detail_do->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->no = $number;

						$number++;
					}
					
					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
			}
			else $this->show_404();
		}



		public function store_data_daftar_delivery_order()
		{
			// print_r($_POST);exit;
			if (isset($_POST['action']) && $_POST['action'] == 'store_data_daftar_delivery_order')
			{
				$post = $this->input->post(NULL, TRUE);
				$store_data_daftar_delivery_order = $this->db_daftar_delivery_order->store_data_daftar_delivery_order($post);

				if ($store_data_daftar_delivery_order->num_rows() > 0) 
				{
					$result = $store_data_daftar_delivery_order->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->no = $number;

						$number++;
					}


					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
			}
			else $this->show_404();
		}

		public function store_data_detail_delivery_order()//dipakai
		{
			if (isset($_POST['action']) && $_POST['action'] == 'insert_delivery_order')
			{
				$post = $this->input->post(NULL, TRUE);
				// print_r($post);exit;
				$get_qty = $this->db_daftar_delivery_order->get_quantity($post)->row();
				$post['new_qty'] = $get_qty->sod_realisasi + $post['dod_shipping_qty'];
				$update_quantity_sales_order_detail = $this->db_daftar_delivery_order->update_quantity_sales_order_detail($post);
				$store_data_daftar_delivery_order = $this->db_daftar_delivery_order->store_data_daftar_delivery_order($post);

				if ($store_data_daftar_delivery_order->num_rows() > 0) 
				{
					$result = $store_data_daftar_delivery_order->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->num = $number;
						$v->dod_created_date = date('d-m-Y H:i:s',strtotime($v->dod_created_date));
						$v->dod_shipping_qty = number_format($v->dod_shipping_qty);
						$v->dod_ongkir = number_format($v->dod_ongkir);

						$number++;
					}
					
					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
			}
			else $this->show_404();
		}

		public function store_update_status()//dipakai
		{
			if (isset($_POST['action']) && $_POST['action'] == 'store_update_status')
			{
				$post = $this->input->post(NULL, TRUE);
				// print_r($post);exit;
				
				$input_to_delivery_order_status = $this->db_daftar_delivery_order->store_delivery_order_status($post);
				$update_status_sales_order = $this->db_daftar_delivery_order->store_update_status_sales_order($post);
				$update_status = $this->db_daftar_delivery_order->store_update_status_delivery_order($post);

				if ($update_status->num_rows() > 0) 
				{
					$result = $update_status->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->num = $number;
						$v->dod_created_date = date('d-m-Y',strtotime($v->dod_created_date));
						$v->dod_shipping_qty = number_format($v->dod_shipping_qty);
						$v->dod_ongkir = number_format($v->dod_ongkir);

						$number++;
					}
					
					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
			}
			else $this->show_404();
		}
		
		public function delete_data_item()
		{
			if (isset($_POST['action']) && $_POST['action'] == 'delete_data_item')
			{
				$post = $this->input->post(NULL, TRUE);
				$delete_data_item = $this->db_daftar_delivery_order->delete_data_item($post);

				if ($delete_data_item->num_rows() > 0) 
				{
					$result = $delete_data_item->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->no = $number;

						$number++;
					}
					
					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!'));
			}
			else $this->show_404();
		}

		public function delete_data_temp()
		{
			// print_r($_POST);exit;
			if (isset($_POST['action']) && $_POST['action'] == 'delete_data_temp')
			{
				$post = $this->input->post(NULL, TRUE);
				$delete_data_sod = $this->db_daftar_delivery_order->delete_data_so_detail($post);

				if ($delete_data_sod->num_rows() > 0) 
				{
					$result = $delete_data_sod->result();
					$number = 1;

					foreach ($result as $k => $v)
					{
						$v->no = $number;

						$number++;
					}
					
					echo json_encode(array('success' => TRUE, 'data' => $result));
				}
				else echo json_encode(array('success' => FALSE, 'msg' => 'Data not found!','data' => array()));
			}
			else $this->show_404();
		}
	}