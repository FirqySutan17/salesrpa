<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Sales extends CI_Controller {
	var $menu_id 	= "";
	var $menu_id2 	= "";
	var $menu_id3 	= "";
	var $session_data = "";
	var $menu_ids = [];
	public function __Construct() {
		parent::__construct();
		$this->menu_id 		= 'S001';
		$this->menu_id2 	= 'S002';
		$this->menu_id3 	= 'S003';
		$this->menu_ids = ['S001', 'S002', 'S003'];
		$this->session_data = $this->session->userdata('user_dashboard');

		$this->cekLogin();
		$this->own_link = admin_url('sales');
		$this->load->library('upload');
	}

  	public function index()
	{
		$sdate = date('Y-m') . '-01';
		$edate = date('Y-m-d');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$sdate = $this->input->post('sdate');
			$edate = $this->input->post('edate');
		}

		$filter = [
			'sdate' => $sdate,
			'edate' => $edate
		];

		$data['title'] = 'DAILY SALES RPA';
		$data['user'] = $this->session_data['user'];
		$data['plans'] = $this->datatable($filter);
		$data['filter'] = $filter;

		$this->template->_v('sales/index', $data);
	}

	public function create_plan() {
		$data['title'] 				= 'DAILY SALES RPA';
		$data['user']				= $this->session_data['user'];

		$data['customer'] 			= $this->datatable_cust();

		$this->template->_v('sales/create-plan', $data);
	}

	public function save_plan()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$this->load->helper('date'); // jika kamu butuh bantuan waktu
			$now  = date('Y-m-d H:i:s');
			$user = $this->session_data['user']['EMPLOYEE_ID'];

			try {
				// Insert ke TB_PLAN
				$data_plan = [
					'ACTIVITY_NO' => $post['activity_no'],
					'ACTIVITY_DATE' => $post['activity_date'],
					'SALES_NPK' => $post['sales_npk'],
					'SALES_NAME' => $post['sales_name'],
					'CREATED_BY' => $user,
					'CREATED_AT' => $now,
					'UPDATED_BY' => $user,
					'UPDATED_AT' => $now
				];

				$save_plan = $this->Dbhelper->insertData('TB_PLAN', $data_plan);

				if (!$save_plan) {
					throw new Exception("Gagal menyimpan data ke TB_PLAN");
				}

				// Insert ke TB_PLAN_ACTIVITY
				$customers     = $post['cust'];
				$cust_names    = $post['cust_name'];
				$phones        = $post['phone'];
				$addresses     = $post['address'];
				$target_plans  = $post['target_plan'];

				if (!empty($customers)) {
					foreach ($customers as $i => $cust) {
						$data_activity = [
							'ACTIVITY_NO'  => $post['activity_no'],
							'SEQUENCE'     => $i + 1,
							'CUST'         => $cust,
							'CUST_NAME'    => $cust_names[$i],
							'PHONE'        => $phones[$i],
							'ADDRESS'      => $addresses[$i],
							'TARGET_PLAN'  => $target_plans[$i],
						];

						echo "<pre>Data Activity ke-" . ($i+1) . ":\n";
						print_r($data_activity);
						echo "</pre>";

						$save_activity = $this->Dbhelper->insertData('TB_PLAN_ACTIVITY', $data_activity);

						if (!$save_activity) {
							echo "<pre>Gagal Insert Activity ke-" . ($i+1) . "</pre>";
							echo $this->db->last_query(); // Tampilkan query terakhir
							print_r($this->db->error());  // Jika pakai CI versi 3.1.10 ke atas
							exit;
						}
					}
				}

				$this->session->set_flashdata('success', 'Data rencana berhasil disimpan.');
				redirect('dashboard/sales/plan-activity');

			} catch (Exception $e) {
				log_message('error', $e->getMessage());
				$this->session->set_flashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
				redirect('dashboard/sales/plan-activity');
			}
		}

		

		$this->session->set_flashdata('error', 'Akses tidak valid.');
		redirect('dashboard/sales/plan-activity');
	}

	public function delete_plan($act_number)
    {
        $this->db->where('act_number', $act_number);
        $this->db->delete('TB_PLAN_ACTIVITY');

        $this->db->where('act_number', $act_number);
        $this->db->delete('TB_PLAN');

        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('dashboard/sales/plan-activity');
    }

	public function index_actual() {
		$data['title'] 				= 'DAILY SALES RPA';
		$data['user']				= $this->session_data['user'];

		$this->template->_v('sales/index-actual', $data);
	}

	public function edit_plan($activity_no) {
		$data['title'] = 'DAILY SALES RPA';
		$data['user'] = $this->session_data['user'];

		// Ambil data TB_PLAN berdasarkan ACTIVITY_NO
		$this->db->where('ACTIVITY_NO', $activity_no);
		$data['plan'] = $this->db->get('TB_PLAN')->row_array();

		// Ambil data TB_PLAN_ACTIVITY berdasarkan ACTIVITY_NO
		$this->db->where('ACTIVITY_NO', $activity_no);
		$data['plan_activities'] = $this->db->get('TB_PLAN_ACTIVITY')->result_array();

		$data['other_activities'] = $this->db->where('ACTIVITY_NO', $activity_no)->get('TB_PLAN_ACTIVITY_OTHER')->result_array();
		// dd($data['other_activities']);

		$this->template->_v('sales/edit', $data);
	}

	public function update_plan() 
	{
		$activity_nos = $this->input->post('activity_no');
		$custs        = $this->input->post('cust');
		$coordinates  = $this->input->post('coordinate');
		$remarks      = $this->input->post('remark');
		$images       = $_FILES['image'];

		foreach ($activity_nos as $i => $activity_no) {
			$data = [
				'COORDINATE' => $coordinates[$i],
				'REMARK'     => $remarks[$i]
			];

			if (!empty($images['name'][$i])) {
				$_FILES['file']['name']     = $images['name'][$i];
				$_FILES['file']['type']     = $images['type'][$i];
				$_FILES['file']['tmp_name'] = $images['tmp_name'][$i];
				$_FILES['file']['error']    = $images['error'][$i];
				$_FILES['file']['size']     = $images['size'][$i];

				$config['upload_path']   = './uploads/plan/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['file_name']     = 'plan_'.$activity_no.'_'.$custs[$i].'_'.time();
				$config['overwrite']     = true;

				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('file')) { // Ganti 'IMAGE_PATH' menjadi 'file'
					$this->session->set_flashdata('error', "Create data failed");
					redirect('dashboard/sales/plan-activity');
				}

				$uploadData = $this->upload->data();
				$data['IMAGE_PATH'] = $uploadData['file_name']; // <-- Tambahkan ini
			}

			$this->db->where('ACTIVITY_NO', $activity_no);
			$this->db->where('CUST', $custs[$i]);
			$this->db->update('TB_PLAN_ACTIVITY', $data);
		}

		// Bagian untuk TB_PLAN_ACTIVITY_OTHER
		$other_ids         = $this->input->post('other_id');
		$other_customers   = $this->input->post('other_customer');
		$other_phones      = $this->input->post('other_phone');
		$other_coordinates = $this->input->post('other_coordinate');
		$other_addresses   = $this->input->post('other_address');
		$other_remarks     = $this->input->post('other_remark');
		$other_images      = $_FILES['other_image'];
		$deleted_ids       = $this->input->post('deleted_other_id');

		// Hapus data berdasarkan ID yang ditandai
		if (!empty($deleted_ids)) {
			foreach ($deleted_ids as $id) {
				$this->db->where('ID', $id)->delete('TB_PLAN_ACTIVITY_OTHER');
			}
		}

		if ($other_customers && count($other_customers) > 0) {
			foreach ($other_customers as $i => $cust) {
				if (empty($cust)) continue;

				$data = [
					'CUSTOMER'   => $cust,
					'PHONE'      => $other_phones[$i] ?? '',
					'COORDINATE' => $other_coordinates[$i] ?? '',
					'ADDRESS'    => $other_addresses[$i] ?? '',
					'REMARK'     => $other_remarks[$i] ?? '',
					'ACTIVITY_NO'=> $activity_no // jika ACTIVITY_NO-nya satu saja, atau sesuaikan jika dinamis
				];

				// upload image jika ada
				if (!empty($other_images['name'][$i])) {
					$_FILES['file']['name']     = $other_images['name'][$i];
					$_FILES['file']['type']     = $other_images['type'][$i];
					$_FILES['file']['tmp_name'] = $other_images['tmp_name'][$i];
					$_FILES['file']['error']    = $other_images['error'][$i];
					$_FILES['file']['size']     = $other_images['size'][$i];

					$config['upload_path']   = './uploads/other/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['file_name']     = 'other_' . time() . '_' . $i;

					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('IMAGE_PATH'))
					{
						$this->session->set_flashdata('error', "Create data failed");
						redirect('dashboard/sales/plan-activity');
					}

					$uploadData = $this->upload->data();

					unset($config);
				}

				$other_id = $other_ids[$i] ?? null;

				if (!empty($other_id)) {
					// Update existing
					$this->db->where('ID', $other_id);
					$this->db->update('TB_PLAN_ACTIVITY_OTHER', $data);
				} else {
					// Insert new
					$this->db->insert('TB_PLAN_ACTIVITY_OTHER', $data);
				}
			}
		}

		$this->session->set_flashdata('success', 'Data berhasil diperbarui.');
		redirect('dashboard/sales/plan-activity');
	}

	private function datatable($filter)
	{
		$sdate = date('d-m-Y', strtotime($filter['sdate']));
		$edate = date('d-m-Y', strtotime($filter['edate']));

		$query = "
			SELECT 
				P.ACTIVITY_NO,
				P.ACTIVITY_DATE,
				P.SALES_NPK,
				P.SALES_NAME,
				A.CUST,
				A.CUST_NAME,
				A.PHONE,
				A.ADDRESS,
				A.TARGET_PLAN
			FROM TB_PLAN P
			JOIN TB_PLAN_ACTIVITY A ON P.ACTIVITY_NO = A.ACTIVITY_NO
			WHERE TO_DATE(P.ACTIVITY_DATE, 'DD-MM-YYYY') 
                  BETWEEN TO_DATE('$sdate', 'DD-MM-YYYY') 
                  AND TO_DATE('$edate', 'DD-MM-YYYY')
			ORDER BY P.ACTIVITY_DATE ASC, P.ACTIVITY_NO ASC
		";
		
		$raw_data = $this->db->query($query)->result_array();
		// dd($query);
	
		// Kelompokkan berdasarkan ACTIVITY_NO
		$plans = [];
		foreach ($raw_data as $row) {
			$key = $row['ACTIVITY_NO'];

			if (!isset($plans[$key])) {
				$plans[$key] = [
					'ACTIVITY_NO' => $row['ACTIVITY_NO'],
					'ACTIVITY_DATE' => $row['ACTIVITY_DATE'],
					'SALES_NPK' => $row['SALES_NPK'],
					'SALES_NAME' => $row['SALES_NAME'],
					'customers' => []
				];
			}

			// Tambahkan data customer ke dalam list
			$plans[$key]['customers'][] = [
				'CUST' => $row['CUST'],
				'CUST_NAME' => $row['CUST_NAME'],
				'PHONE' => $row['PHONE'],
				'ADDRESS' => $row['ADDRESS'],
				'TARGET_PLAN' => $row['TARGET_PLAN'],
			];
		}
		// dd($plans);
		// Ubah menjadi array numerik
		return array_values($plans);
	}

	private function datatable_cust() {
		$query = "
			SELECT * FROM MOBILE.CD_CUSTOMER
			WHERE CUST LIKE 'SH%'
			AND CUST_CLASS ='01'
		";

		$result = $this->db->query($query)->result_array();

		$customer = [];
		foreach ($result as $row) {
			$customer[] = [
				'CUST' => $row['CUST'],
				'FULL_NAME' => $row['FULL_NAME'],
				'MOBILE_PHONE' => $row['MOBILE_PHONE'],
				'ADDRESS' => trim($row['ADDRESS1'] . ' ' . ($row['ADDRESS2'] !== '.' ? $row['ADDRESS2'] : '')),
			];
		}

		return $customer;
	}

	// CHANGE NECESSARY POINT
	private function cekLogin() {
		$session = $this->session_data;
		if (empty($session)) {
			redirect('login_dashboard');
		}

		$user_access = $session['user_access'];
		$menu_access = $this->menu_ids;
		$check_exist = array_intersect($menu_access, $user_access);
		// dd($check_exist);
		if (empty($check_exist) && !in_array('*', $user_access)) {
			redirect('dashboard');
		}
	}
}