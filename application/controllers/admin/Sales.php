<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Sales extends CI_Controller {
	var $menu_id 	= "";
	var $menu_id2 	= "";
	var $session_data = "";
	var $menu_ids = [];
	public function __Construct() {
		parent::__construct();
		$this->menu_id 		= 'SA001';
		$this->menu_id2 	= 'SA002';
		$this->menu_ids = ['SA001', 'SA002'];
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

		$npk_user = $this->session_data['user']['EMPLOYEE_ID']; // ambil employee_id user login
		$today = date('d-m-Y');

		$data['title'] = 'DAILY SALES RPA';
		$data['user'] = $this->session_data['user'];
		$data['plans'] = $this->datatable($filter, $npk_user); // perbaikan: kirim 2 parameter
		$data['filter'] = $filter;
		// Buat array untuk simpan flag modify per ACTIVITY_NO
		$can_modify = [];

		foreach ($data['plans'] as $plan) {
			$activity_no = $plan['ACTIVITY_NO'];

			// Query cek remark di TB_PLAN_ACTIVITY
			$this->db->select('REMARK');
			$this->db->where('ACTIVITY_NO', $activity_no);
			$activities = $this->db->get('TB_PLAN_ACTIVITY')->result_array();

			$hasRemark = false;
			foreach ($activities as $act) {
				if (!empty(trim($act['REMARK']))) {
					$hasRemark = true;
					break;
				}
			}

			$can_modify[$activity_no] = !$hasRemark; // true kalau semua remark kosong
		}

		$data['can_modify'] = $can_modify;
		$this->db->from('TB_PLAN');
		$this->db->where('SALES_NPK', $npk_user);
		$this->db->where('ACTIVITY_DATE', $today);
		$is_planned_today = $this->db->count_all_results() > 0;

		$data['is_planned_today'] = $is_planned_today;
		// dd($data['plans']);
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
			$this->load->helper('date');
			$now  = date('Y-m-d H:i:s');
			$user = $this->session_data['user']['EMPLOYEE_ID'];

			try {
				// Cek apakah ACTIVITY_NO sudah ada di TB_PLAN
				$this->db->where('ACTIVITY_NO', $post['activity_no']);
				$existing_plan = $this->db->get('TB_PLAN')->row();

				$data_plan = [
					'ACTIVITY_DATE' => $post['activity_date'],
					'SALES_NPK'     => $post['sales_npk'],
					'SALES_NAME'    => $post['sales_name'],
					'UPDATED_BY'    => $user,
					'UPDATED_AT'    => $now
				];

				if ($existing_plan) {
					// Update data plan
					$this->db->where('ACTIVITY_NO', $post['activity_no']);
					$update_plan = $this->db->update('TB_PLAN', $data_plan);

					if (!$update_plan) {
						throw new Exception("Gagal update data di TB_PLAN");
					}
				} else {
					// Insert baru data plan
					$data_plan['ACTIVITY_NO'] = $post['activity_no'];
					$data_plan['CREATED_BY']  = $user;
					$data_plan['CREATED_AT']  = $now;

					$insert_plan = $this->db->insert('TB_PLAN', $data_plan);
					if (!$insert_plan) {
						throw new Exception("Gagal insert data di TB_PLAN");
					}
				}

				// Hapus data lama TB_PLAN_ACTIVITY untuk ACTIVITY_NO ini
				$this->db->where('ACTIVITY_NO', $post['activity_no']);
				$this->db->delete('TB_PLAN_ACTIVITY');

				// Insert ulang TB_PLAN_ACTIVITY
				$customers     = $post['cust'];
				$cust_names    = $post['cust_name'];
				$phones        = $post['phone'];
				$addresses     = $post['address'];
				$target_plans  = $post['target_plan'];

				foreach ($customers as $i => $cust) {
					$data_activity = [
						'ACTIVITY_NO' => $post['activity_no'],
						'SEQUENCE'    => $i + 1,
						'CUST'        => $cust,
						'CUST_NAME'   => $cust_names[$i],
						'PHONE'       => $phones[$i],
						'ADDRESS'     => $addresses[$i],
						'TARGET_PLAN' => $target_plans[$i],
					];

					$insert_activity = $this->db->insert('TB_PLAN_ACTIVITY', $data_activity);

					if (!$insert_activity) {
						throw new Exception("Gagal insert TB_PLAN_ACTIVITY ke index " . $i);
					}
				}

				// Proses TB_PLAN_ACTIVITY_OTHER: update, insert, delete
				$other_ids           = $this->input->post('other_id');
				$other_customers     = $this->input->post('other_customer');
				$other_phones        = $this->input->post('other_phone');
				$other_address_plans = $this->input->post('other_address_plan');
				$other_target_plans  = $this->input->post('other_target');
				$deleted_ids         = $this->input->post('deleted_other_id');

				// Hapus data yang ditandai di deleted_other_id
				if (!empty($deleted_ids)) {
					foreach ($deleted_ids as $id) {
						$this->db->where('ID', $id)->delete('TB_PLAN_ACTIVITY_OTHER');
					}
				}

				// Insert / update data TB_PLAN_ACTIVITY_OTHER
				if ($other_customers && count($other_customers) > 0) {
					foreach ($other_customers as $i => $cust) {
						if (empty($cust)) continue;

						$data_other = [
							'CUSTOMER'    => $cust,
							'PHONE'       => $other_phones[$i] ?? '',
							'ADDRESS_PLAN'=> $other_address_plans[$i] ?? '',
							'TARGET_PLAN' => $other_target_plans[$i] ?? '',
							'STATUS'      => 'Y',
							'ACTIVITY_NO' => $post['activity_no']
						];

						$other_id = $other_ids[$i] ?? null;

						if (!empty($other_id)) {
							// Update existing
							$this->db->where('ID', $other_id);
							$this->db->update('TB_PLAN_ACTIVITY_OTHER', $data_other);
						} else {
							// Insert baru
							$this->db->insert('TB_PLAN_ACTIVITY_OTHER', $data_other);
						}
					}
				}

				$this->session->set_flashdata('success', 'DATA PLAN BERHASIL DISIMPAN.');
				redirect('dashboard/sales/activity');

			} catch (Exception $e) {
				log_message('error', $e->getMessage());
				$this->session->set_flashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
				redirect('dashboard/sales/activity');
			}
		}

		$this->session->set_flashdata('error', 'AKSES TIDAK VALID.');
		redirect('dashboard/sales/activity');
	}


	// public function save_plan()
	// {
	// 	if ($this->input->server('REQUEST_METHOD') === 'POST') {
	// 		$post = $this->input->post();
	// 		$this->load->helper('date'); // jika kamu butuh bantuan waktu
	// 		$now  = date('Y-m-d H:i:s');
	// 		$user = $this->session_data['user']['EMPLOYEE_ID'];

	// 		try {
	// 			// Insert ke TB_PLAN
	// 			$data_plan = [
	// 				'ACTIVITY_NO' => $post['activity_no'],
	// 				'ACTIVITY_DATE' => $post['activity_date'],
	// 				'SALES_NPK' => $post['sales_npk'],
	// 				'SALES_NAME' => $post['sales_name'],
	// 				'CREATED_BY' => $user,
	// 				'CREATED_AT' => $now,
	// 				'UPDATED_BY' => $user,
	// 				'UPDATED_AT' => $now
	// 			];

	// 			$save_plan = $this->Dbhelper->insertData('TB_PLAN', $data_plan);

	// 			if (!$save_plan) {
	// 				throw new Exception("Gagal menyimpan data ke TB_PLAN");
	// 			}

	// 			// Insert ke TB_PLAN_ACTIVITY
	// 			$customers     = $post['cust'];
	// 			$cust_names    = $post['cust_name'];
	// 			$phones        = $post['phone'];
	// 			$addresses     = $post['address'];
	// 			$target_plans  = $post['target_plan'];

	// 			$this->db->select('MAX(SEQUENCE) AS MAX_SEQ');
	// 			$this->db->where('ACTIVITY_NO', $post['activity_no']);
	// 			$query = $this->db->get('TB_PLAN_ACTIVITY');
	// 			$row = $query->row();
	// 			$max_sequence = $row && $row->MAX_SEQ ? (int) $row->MAX_SEQ : 0;

	// 			foreach ($customers as $i => $cust) {
	// 				$sequence = $max_sequence + $i + 1;

	// 				$data_activity = [
	// 					'ACTIVITY_NO'  => $post['activity_no'],
	// 					'SEQUENCE'     => $sequence,
	// 					'CUST'         => $cust,
	// 					'CUST_NAME'    => $cust_names[$i],
	// 					'PHONE'        => $phones[$i],
	// 					'ADDRESS'      => $addresses[$i],
	// 					'TARGET_PLAN'  => $target_plans[$i],
	// 				];

	// 				$save_activity = $this->Dbhelper->insertData('TB_PLAN_ACTIVITY', $data_activity);

	// 				if (!$save_activity) {
	// 					echo "<pre>Gagal Insert Activity ke-" . ($i+1) . "</pre>";
	// 					echo $this->db->last_query();
	// 					print_r($this->db->error());
	// 					exit;
	// 				}
	// 			}

	// 			// Bagian untuk TB_PLAN_ACTIVITY_OTHER
	// 			$other_ids         = $this->input->post('other_id');
	// 			$other_customers   = $this->input->post('other_customer');
	// 			$other_phones      = $this->input->post('other_phone');
	// 			$other_address_plans      = $this->input->post('other_address_plan');
	// 			$target_plans      = $this->input->post('other_target');
	// 			$deleted_ids       = $this->input->post('deleted_other_id');

	// 			// Hapus data berdasarkan ID yang ditandai
	// 			if (!empty($deleted_ids)) {
	// 				foreach ($deleted_ids as $id) {
	// 					$this->db->where('ID', $id)->delete('TB_PLAN_ACTIVITY_OTHER');
	// 				}
	// 			}

	// 			if ($other_customers && count($other_customers) > 0) {
	// 				foreach ($other_customers as $i => $cust) {
	// 					if (empty($cust)) continue;

	// 					$data = [
	// 						'CUSTOMER'   	  => $cust,
	// 						'PHONE'     	  => $other_phones[$i] ?? '',
	// 						'ADDRESS_PLAN'     => $other_address_plans[$i] ?? '',
	// 						'TARGET_PLAN'     => $target_plans[$i] ?? '',
	// 						'STATUS'   	  	  => 'Y',
	// 						'ACTIVITY_NO'	  => $post['activity_no']
	// 					];

	// 					$other_id = $other_ids[$i] ?? null;

	// 					if (!empty($other_id)) {
	// 						// Update existing
	// 						$this->db->where('ID', $other_id);
	// 						$this->db->update('TB_PLAN_ACTIVITY_OTHER', $data);
	// 					} else {
	// 						// Insert new
	// 						$this->db->insert('TB_PLAN_ACTIVITY_OTHER', $data);
	// 					}
	// 				}
	// 			}

	// 			$this->session->set_flashdata('success', 'DATA PLAN BERHASIL TERSIMPAN.');
	// 			redirect('dashboard/sales/activity');

	// 		} catch (Exception $e) {
	// 			log_message('error', $e->getMessage());
	// 			$this->session->set_flashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
	// 			redirect('dashboard/sales/activity');
	// 		}
	// 	}

	// 	$this->session->set_flashdata('error', 'AKSES TIDAK VALID.');
	// 	redirect('dashboard/sales/activity');
	// }

	public function modify_plan($activity_no) {
		$data['title']       = 'DAILY SALES RPA';
		$data['user']        = $this->session_data['user'];
		$data['customer']    = $this->datatable_cust();

		// Ambil data TB_PLAN berdasarkan ACTIVITY_NO
		$this->db->where('ACTIVITY_NO', $activity_no);
		$data['plan'] = $this->db->get('TB_PLAN')->row_array();

		// Ambil data TB_PLAN_ACTIVITY berdasarkan ACTIVITY_NO
		$this->db->where('ACTIVITY_NO', $activity_no);
		$data['plan_activities'] = $this->db->get('TB_PLAN_ACTIVITY')->result_array();
		
		$data['other_activities'] = $this->db->where('ACTIVITY_NO', $activity_no)->where('STATUS', 'Y')->order_by('ID', 'ASC')->get('TB_PLAN_ACTIVITY_OTHER')->result_array();

		// dd($data['plan']);
		// dd($data['plan_activities']);
		// dd($data['other_activities']);

		$this->template->_v('sales/edit-plan', $data);
	}

	public function delete_plan($act_number)
	{
		// Hapus dari TB_PLAN_ACTIVITY_ORDER terlebih dahulu (jika tabel ini memiliki FOREIGN KEY ke ACTIVITY)
		$this->db->where('ACTIVITY_NO', $act_number);
		$this->db->delete('TB_PLAN_ACTIVITY_OTHER');

		// Kemudian hapus dari TB_PLAN_ACTIVITY
		$this->db->where('ACTIVITY_NO', $act_number);
		$this->db->delete('TB_PLAN_ACTIVITY');

		// Terakhir hapus dari TB_PLAN
		$this->db->where('ACTIVITY_NO', $act_number);
		$this->db->delete('TB_PLAN');

		$this->session->set_flashdata('success', 'DATA BERHASIL TERHAPUS.');
		redirect('dashboard/sales/activity');
	}

	public function report() {
		$sdate = date('Y-m') . '-01';
		$edate = date('Y-m-d');
		$sales = "*";
		$filter_user 				= ['EMPLOYEE_ID !=' => '999999'];

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$sdate 	= $this->input->post('sdate');
			$edate 	= $this->input->post('edate');
			$sales 	= $this->input->post('sales');
		}

		$filter = [
			'sdate' => $sdate,
			'edate' => $edate,
			'sales'	=> $sales
		];

		$npk_user = $this->session_data['user']['EMPLOYEE_ID']; // ambil employee_id user login

		$data['title'] = 'DAILY SALES RPA';
		$data['user'] = $this->session_data['user'];
		$data['sales'] 	= $this->Dbhelper->selectTabel('EMPLOYEE_ID, FULL_NAME', 'CD_USER', $filter_user, 'EMPLOYEE_ID', 'ASC');
		$data['plans'] = $this->datatable_report($filter, $npk_user); // perbaikan: kirim 2 parameter
		$data['filter'] = $filter;

		$this->template->_v('sales/report', $data);
	}

	public function edit_plan($activity_no) {
		$data['title']       = 'DAILY SALES RPA';
		$data['user']        = $this->session_data['user'];
		$data['customer']    = $this->datatable_cust();

		// Ambil data TB_PLAN berdasarkan ACTIVITY_NO
		$this->db->where('ACTIVITY_NO', $activity_no);
		$data['plan'] = $this->db->get('TB_PLAN')->row_array();

		// Ambil data TB_PLAN_ACTIVITY berdasarkan ACTIVITY_NO
		$this->db->where('ACTIVITY_NO', $activity_no);
		$data['plan_activities'] = $this->db->get('TB_PLAN_ACTIVITY')->result_array();

		// Tambahkan data gambar ke tiap aktivitas
		foreach ($data['plan_activities'] as &$activity) {
			$activity['IMAGES'] = $this->db->get_where('TB_PLAN_ACTIVITY_IMAGES', [
				'ACTIVITY_NO' => $activity['ACTIVITY_NO'],
				'CUST'        => $activity['CUST']
			])->result_array();
		}
		
		$data['other_activities_fix'] = $this->db->where('ACTIVITY_NO', $activity_no)->where('STATUS', 'Y')->order_by('ID', 'ASC')->get('TB_PLAN_ACTIVITY_OTHER')->result_array();
		foreach ($data['other_activities_fix'] as &$other) {
			$other['IMAGES'] = $this->db->get_where('TB_PLAN_ACTIVITY_OTHER_IMAGES', ['ID' => $other['ID']])->result_array();
		}
		$data['other_activities']     = $this->db->where('ACTIVITY_NO', $activity_no)->where('STATUS IS NULL', null, false)->get('TB_PLAN_ACTIVITY_OTHER')->result_array();

		$this->template->_v('sales/edit', $data);
	}

	public function update_plan() 
	{
		$activity_nos = $this->input->post('activity_no');
		$custs        = $this->input->post('cust');
		$coordinates  = $this->input->post('coordinate');
		$address  	  = $this->input->post('address');
		$remarks      = $this->input->post('remark');
		$images       = $_FILES['image'];

		foreach ($activity_nos as $i => $activity_no) {
			$data = [
				'COORDINATE'     => $coordinates[$i] ?? '',
				'ADDRESS_ACTUAL' => $address[$i] ?? '',
				'REMARK'         => $remarks[$i] ?? ''
			];

			// Update data utama
			$this->db->where('ACTIVITY_NO', $activity_no);
			$this->db->where('CUST', $custs[$i]);
			$this->db->update('TB_PLAN_ACTIVITY', $data);

			// Upload multiple image
			if (isset($_FILES['image']['name'][$i]) && is_array($_FILES['image']['name'][$i])) {
				foreach ($_FILES['image']['name'][$i] as $j => $filename) {
					if (empty($filename)) continue;

					$_FILES['file']['name']     = $filename;
					$_FILES['file']['type']     = $_FILES['image']['type'][$i][$j];
					$_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i][$j];
					$_FILES['file']['error']    = $_FILES['image']['error'][$i][$j];
					$_FILES['file']['size']     = $_FILES['image']['size'][$i][$j];

					$config['upload_path']   = './uploads/plan/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['file_name']     = 'plan_' . $activity_no . '_' . $custs[$i] . '_' . time() . '_' . $j;
					$config['overwrite']     = false;

					$this->upload->initialize($config);
					if (!$this->upload->do_upload('file')) {
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect('dashboard/sales/activity');
					}

					$uploadData = $this->upload->data();
					$image_path = $uploadData['file_name'];

					// Simpan ke tabel TB_PLAN_ACTIVITY_IMAGES
					$this->db->insert('TB_PLAN_ACTIVITY_IMAGES', [
						'ACTIVITY_NO' => $activity_no,
						'CUST'        => $custs[$i],
						'IMAGE_PATH'  => $image_path
					]);
				}
			}
		}

		$activity_nos       = $this->input->post('activity_no'); // Array of ACTIVITY_NO
		$ids                = $this->input->post('id');          // Array of ID (primary key of TB_PLAN_ACTIVITY_OTHER)
		$coordinates        = $this->input->post('coordinatecust');
		$addresses          = $this->input->post('addresscust');
		$remarks            = $this->input->post('remark_cust');
		$phones             = $this->input->post('phone_cust');
		$image_ups             = $_FILES['image_cust'];             // Multi-upload format: image_cust[0][], image_cust[1][]...

		foreach ($ids as $i => $id_val) {
			$activity_no = $activity_nos[$i] ?? '';
			$coordinate  = $coordinates[$i] ?? '';
			$address     = $addresses[$i] ?? '';
			$remark      = $remarks[$i] ?? '';
			$phone       = $phones[$i] ?? '';

			// Ambil CUST berdasarkan ID
			$customer = $this->db->select('CUSTOMER')
				->from('TB_PLAN_ACTIVITY_OTHER')
				->where('ID', $id_val)
				->get()
				->row('CUSTOMER');

			// Update data utama
			$this->db->where('ID', $id_val);
			$this->db->update('TB_PLAN_ACTIVITY_OTHER', [
				'COORDINATE' => $coordinate,
				'ADDRESS'    => $address,
				'REMARK'     => $remark,
				'PHONE'      => $phone
			]);

			// Upload multiple image jika ada
			if (isset($image_ups['name'][$i]) && is_array($image_ups['name'][$i])) {
				foreach ($image_ups['name'][$i] as $j => $filename) {
					if (empty($filename)) continue;

					$_FILES['file']['name']     = $filename;
					$_FILES['file']['type']     = $image_ups['type'][$i][$j];
					$_FILES['file']['tmp_name'] = $image_ups['tmp_name'][$i][$j];
					$_FILES['file']['error']    = $image_ups['error'][$i][$j];
					$_FILES['file']['size']     = $image_ups['size'][$i][$j];

					$config['upload_path']   = './uploads/other/';
					$config['allowed_types'] = '*'; 
					$config['file_name']     = 'other_' . $activity_no . '_' . $customer . '_' . time() . '_' . $j;
					$config['overwrite']     = false;

					$this->upload->initialize($config);

					if (!$this->upload->do_upload('file')) {
						$error = $this->upload->display_errors();
						echo "Upload gagal: " . $error;
						echo "MIME Type file: " . $_FILES['file']['type'];
						exit;
					}

					$uploadData = $this->upload->data();
					$image_path = $uploadData['file_name'];

					$insert_data = [
						'ACTIVITY_NO' => $activity_no,
						'CUST'        => $customer,
						'IMAGE_PATH'  => $image_path,
						'ID_DATA'     => $id_val
					];

					if (!$this->db->insert('TB_PLAN_ACTIVITY_OTHER_IMAGES', $insert_data)) {
						$error = $this->db->error();
						echo "DB Insert gagal: " . print_r($error, true);
						exit;
					}
				}
			}
		}

		// Insert ke TB_PLAN_ACTIVITY
		$cust_news          = $this->input->post('custnew');
		$cust_name_news     = $this->input->post('cust_name_new');
		$phone_news         = $this->input->post('phone_new');
		$address_news       = $this->input->post('address_new');
		$coordinate_news    = $this->input->post('coordinateloca');
		$address_actual_new = $this->input->post('addressloca');
		$remark_news        = $this->input->post('remark_new');
		$image_news         = $_FILES['image_customers'];

		if ($cust_news && count($cust_news) > 0) {
			foreach ($cust_news as $i => $cust) {
				// Abaikan entri jika semua field penting kosong
				if (
					empty($cust_news[$i]) &&
					empty($cust_name_news[$i]) &&
					empty($phone_news[$i]) &&
					empty($address_news[$i]) &&
					empty($coordinate_news[$i]) &&
					empty($address_actual_new[$i]) &&
					empty($remark_news[$i]) &&
					empty($image_news['name'][$i])
				) {
					continue; // skip baris ini
				}

				$activity_no = $activity_nos[$i]; // Pastikan $activity_nos[] tersedia dari proses sebelumnya

				$data_activity = [
					'ACTIVITY_NO'    => $activity_no,
					'SEQUENCE'       => $i + 1,
					'CUST'           => $cust_news[$i],
					'CUST_NAME'      => $cust_name_news[$i],
					'PHONE'          => $phone_news[$i],
					'ADDRESS'        => $address_news[$i],
					'COORDINATE'     => $coordinate_news[$i],
					'ADDRESS_ACTUAL' => $address_actual_new[$i],
					'REMARK'         => $remark_news[$i]
				];

				// Penanganan Upload Gambar
				if (!empty($image_news['name'][$i])) {
					$_FILES['file']['name']     = $image_news['name'][$i];
					$_FILES['file']['type']     = $image_news['type'][$i];
					$_FILES['file']['tmp_name'] = $image_news['tmp_name'][$i];
					$_FILES['file']['error']    = $image_news['error'][$i];
					$_FILES['file']['size']     = $image_news['size'][$i];

					$config['upload_path']   = './uploads/plan/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['file_name']     = 'plan_'.$activity_no.'_'.$cust_news[$i].'_'.time();
					$config['overwrite']     = true;

					$this->upload->initialize($config);

					if (!$this->upload->do_upload('file')) {
						$error_msg = $this->upload->display_errors();
						$this->session->set_flashdata('error', "GAGAL UPLOAD GAMBAR: $error_msg");
						redirect('dashboard/sales/activity');
					}

					$uploadData = $this->upload->data();
					$data_activity['IMAGE_PATH'] = $uploadData['file_name'];
				}

				// Cek apakah data sudah ada di TB_PLAN_ACTIVITY (UPSERT)
				$existing = $this->db->get_where('TB_PLAN_ACTIVITY', [
					'ACTIVITY_NO' => $activity_no,
					'CUST'        => $cust_news[$i]
				])->row();

				if ($existing) {
					// Update jika data sudah ada
					$this->db->where('ACTIVITY_NO', $activity_no);
					$this->db->where('CUST', $cust_news[$i]);
					$this->db->update('TB_PLAN_ACTIVITY', $data_activity);
				} else {
					$this->db->select_max('ID');
					$last_id = $this->db->get('TB_PLAN_ACTIVITY')->row()->ID;
					$data_activity['ID'] = $last_id + 1;
					$this->db->insert('TB_PLAN_ACTIVITY', $data_activity);
				}
			}
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
					if ( ! $this->upload->do_upload('file')) { // Ganti 'IMAGE_PATH' menjadi 'file'
						$this->session->set_flashdata('error', "TAMBAH DATA GAGAL. SILAHKAN COBA KEMBALI");
						redirect('dashboard/sales/activity');
					}

					$uploadData = $this->upload->data();
					$data['IMAGE_PATH'] = $uploadData['file_name']; // <-- Tambahkan ini
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
		$this->session->set_flashdata('success', 'DATA BERHASIL DIPERBAHARUI.');
		redirect('dashboard/sales/activity');
	}

	public function delete_image($image_id)
	{
		// Ambil data gambar dulu
		$image = $this->db->get_where('TB_PLAN_ACTIVITY_IMAGES', ['ID' => $image_id])->row();

		if (!$image) {
			$this->session->set_flashdata('error', 'Gambar tidak ditemukan.');
			redirect('dashboard/sales/activity');
		}

		// Hapus file fisik gambar dari server (jika ada)
		$file_path = './uploads/plan/' . $image->IMAGE_PATH;
		if (file_exists($file_path)) {
			unlink($file_path);
		}

		// Hapus data gambar dari database
		$this->db->where('ID', $image_id);
		$this->db->delete('TB_PLAN_ACTIVITY_IMAGES');

		$this->session->set_flashdata('success', 'Gambar berhasil dihapus.');
		redirect($_SERVER['HTTP_REFERER']); // Kembali ke halaman sebelumnya
	}

	public function delete_other_image($image_id)
	{
		$img = $this->db->get_where('TB_PLAN_ACTIVITY_OTHER_IMAGES', ['ID' => $image_id])->row();
		if (!$img) {
			$this->session->set_flashdata('error', 'Gambar tidak ditemukan.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$file_path = './uploads/other/' . $img->IMAGE_PATH;
		if (file_exists($file_path)) {
			unlink($file_path);
		}

		$this->db->where('ID', $image_id);
		$this->db->delete('TB_PLAN_ACTIVITY_OTHER_IMAGES');

		$this->session->set_flashdata('success', 'Gambar berhasil dihapus.');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function get_modal_detail($activity_no) {
		error_reporting(0);  // matikan error reporting agar tidak muncul di output JSON
		// ini_set('display_errors', 0);
		// ini_set('log_errors', 1);

		$data = [];

		$data['plan'] = $this->db->where('ACTIVITY_NO', $activity_no)->get('TB_PLAN')->row_array();
		$data['plan_activities'] = $this->db->where('ACTIVITY_NO', $activity_no)->order_by('ID', 'ASC')->get('TB_PLAN_ACTIVITY')->result_array();
		$data['other_activities'] = $this->db->where('ACTIVITY_NO', $activity_no)->get('TB_PLAN_ACTIVITY_OTHER')->result_array();

		header('Content-Type: application/json');
		echo trim(json_encode($data));
		exit;
	}

	public function market()
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

		$npk_user = $this->session_data['user']['EMPLOYEE_ID']; // ambil employee_id user login

		$data['title'] = 'DAILY SALES RPA';
		$data['user'] = $this->session_data['user'];
		$data['markets'] = $this->datatable_survey($filter, $npk_user); // perbaikan: kirim 2 parameter
		$data['filter'] = $filter;

		$this->template->_v('sales/market', $data);
	}

	public function create_survey() {
		$data['title'] 				= 'DAILY SALES RPA';
		$data['user']				= $this->session_data['user'];

		$this->template->_v('sales/create-survey', $data);
	}

	public function save_survey()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$this->load->helper('date'); // jika kamu butuh bantuan waktu
			$now  = date('Y-m-d H:i:s');
			$user = $this->session_data['user']['EMPLOYEE_ID'];

			try {
				// Insert ke TB_PLAN
				$data_survey = [
					'SURVEY_NO' 	=> $post['survey_no'],
					'SURVEY_DATE' 	=> $post['survey_date'],
					'TITLE' 		=> $post['title'],
					'JENIS_MARKET' 	=> $post['jenis_market'],
					'TARGET_SURVEY' => $post['target_survey'],
					'HASIL_SURVEY'  => $post['hasil_survey'],
					'CONTACT_NAME'  => $post['contact_name'],
					'CONTACT_PHONE' => $post['contact_phone'],
					'COORDINATE'    => $post['coordinate'],
					'ADDRESS' 		=> $post['addresscoor'],
					'SALES_NPK' 	=> $post['sales_npk'],
					'SALES_NAME' 	=> $post['sales_name'],
					'CREATED_BY' 	=> $user,
					'CREATED_AT' 	=> $now,
					'UPDATED_BY' 	=> $user,
					'UPDATED_AT' 	=> $now
				];

				$save_survey = $this->Dbhelper->insertData('TB_SURVEY_MARKET', $data_survey);

				if (!$save_survey) {
					throw new Exception("Gagal menyimpan data ke TB_SURVEY_MARKET");
				}

				// Bagian untuk TB_PLAN_ACTIVITY_OTHER
				if (!empty($_FILES['other_image']['name'][0])) {
					$other_images = $_FILES['other_image'];

					for ($i = 0; $i < count($other_images['name']); $i++) {
						if (!empty($other_images['name'][$i])) {
							$_FILES['file']['name']     = $other_images['name'][$i];
							$_FILES['file']['type']     = $other_images['type'][$i];
							$_FILES['file']['tmp_name'] = $other_images['tmp_name'][$i];
							$_FILES['file']['error']    = $other_images['error'][$i];
							$_FILES['file']['size']     = $other_images['size'][$i];

							$config['upload_path']   = './uploads/market/';
							$config['allowed_types'] = 'jpg|jpeg|png';
							$config['file_name']     = 'market_' . time() . '_' . $i;

							$this->upload->initialize($config);

							if (!$this->upload->do_upload('file')) {
								$this->session->set_flashdata('error', "TAMBAH DATA GAGAL. SILAHKAN COBA KEMBALI");
								redirect('dashboard/sales/survey-market');
							}

							$uploadData = $this->upload->data();
							$data_image = [
								'IMAGE_PATH'  => $uploadData['file_name'],
								'SEQUENCE'    => $i + 1,
								'SURVEY_NO'   => $post['survey_no'] // atau field relasi yang sesuai
							];

							$this->db->insert('TB_SURVEY_MARKET_IMAGE', $data_image);
						}
					}
				}
				
			$this->session->set_flashdata('success', 'DATA SURVEY MARKET BERHASIL TERSIMPAN.');
			redirect('dashboard/sales/survey-market');

			} catch (Exception $e) {
				log_message('error', $e->getMessage());
				$this->session->set_flashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
				redirect('dashboard/sales/survey-market');
			}
		}

		$this->session->set_flashdata('error', 'AKSES TIDAK VALID.');
		redirect('dashboard/sales/survey-market');
	}

	public function edit_survey($survey_no) {
		$data['title'] = 'DAILY SALES RPA';
		$data['user'] = $this->session_data['user'];

		// Ambil data TB_SURVEY_MARKET berdasarkan SURVEY_NO
		$this->db->where('SURVEY_NO', $survey_no);
		$data['survey'] = $this->db->get('TB_SURVEY_MARKET')->row_array();

		$data['other_images'] = $this->db->where('SURVEY_NO', $survey_no)->get('TB_SURVEY_MARKET_IMAGE')->result_array();
		// dd($data['other_activities']);

		$this->template->_v('sales/update-survey', $data);
	}

	public function update_survey()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$this->load->helper('date');
			$now  = date('Y-m-d H:i:s');
			$user = $this->session_data['user']['EMPLOYEE_ID'];

			try {
				// Data utama untuk TB_SURVEY_MARKET
				$data_survey = [
					'SURVEY_DATE' 	=> $post['survey_date'],
					'TITLE' 		=> $post['title'],
					'JENIS_MARKET' 	=> $post['jenis_market'],
					'TARGET_SURVEY' => $post['target_survey'],
					'HASIL_SURVEY'  => $post['hasil_survey'],
					'CONTACT_NAME'  => $post['contact_name'],
					'CONTACT_PHONE' => $post['contact_phone'],
					'COORDINATE'    => $post['coordinate'],
					'ADDRESS' 		=> $post['addresscoor'],
					'SALES_NPK' 	=> $post['sales_npk'],
					'SALES_NAME' 	=> $post['sales_name'],
					'UPDATED_BY' 	=> $user,
					'UPDATED_AT' 	=> $now
				];

				$this->db->where('SURVEY_NO', $post['survey_no']);
				$updated = $this->db->update('TB_SURVEY_MARKET', $data_survey);

				if (!$updated) {
					throw new Exception("Gagal mengupdate data TB_SURVEY_MARKET");
				}

				// Hapus gambar sebelumnya jika ada
				if (isset($post['deleted_ids']) && is_array($post['deleted_ids'])) {
					foreach ($post['deleted_ids'] as $id) {
						$image = $this->db->get_where('TB_SURVEY_MARKET_IMAGE', ['ID' => $id])->row();
						if ($image) {
							@unlink('./uploads/market/' . $image->IMAGE_PATH);
							$this->db->where('ID', $id)->delete('TB_SURVEY_MARKET_IMAGE');
						}
					}
				}

				// Simpan gambar baru jika ada upload
				if (!empty($_FILES['other_image']['name'][0])) {
					$other_images = $_FILES['other_image'];

					for ($i = 0; $i < count($other_images['name']); $i++) {
						if (!empty($other_images['name'][$i])) {
							$_FILES['file']['name']     = $other_images['name'][$i];
							$_FILES['file']['type']     = $other_images['type'][$i];
							$_FILES['file']['tmp_name'] = $other_images['tmp_name'][$i];
							$_FILES['file']['error']    = $other_images['error'][$i];
							$_FILES['file']['size']     = $other_images['size'][$i];

							$config['upload_path']   = './uploads/market/';
							$config['allowed_types'] = 'jpg|jpeg|png';
							$config['file_name']     = 'market_' . time() . '_' . $i;

							$this->upload->initialize($config);

							if (!$this->upload->do_upload('file')) {
								$this->session->set_flashdata('error', "UPLOAD GAGAL. SILAHKAN COBA KEMBALI");
								redirect('dashboard/sales/survey-market');
							}

							$uploadData = $this->upload->data();
							$data_image = [
								'IMAGE_PATH'  => $uploadData['file_name'],
								'SEQUENCE'    => $i + 1,
								'SURVEY_NO'   => $post['survey_no']
							];

							$this->db->insert('TB_SURVEY_MARKET_IMAGE', $data_image);
						}
					}
				}

				$this->session->set_flashdata('success', 'DATA BERHASIL DIUPDATE.');
				redirect('dashboard/sales/survey-market');

			} catch (Exception $e) {
				log_message('error', $e->getMessage());
				$this->session->set_flashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
				redirect('dashboard/sales/survey-market');
			}
		}

		$this->session->set_flashdata('error', 'AKSES TIDAK VALID.');
		redirect('dashboard/sales/survey-market');
	}

	public function market_report() {
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

		$npk_user = $this->session_data['user']['EMPLOYEE_ID']; // ambil employee_id user login

		$data['title'] = 'DAILY SALES RPA';
		$data['user'] = $this->session_data['user'];
		$data['markets'] = $this->datatable_survey($filter, $npk_user); // perbaikan: kirim 2 parameter
		$data['filter'] = $filter;

		$this->template->_v('sales/market-report', $data);
	}

	public function get_modal_survey_detail($survey_no) {
		error_reporting(0);  // matikan error reporting agar tidak muncul di output JSON
		// ini_set('display_errors', 0);
		// ini_set('log_errors', 1);

		$data = [];

		$data['survey'] = $this->db->where('SURVEY_NO', $survey_no)->get('TB_SURVEY_MARKET')->row_array();
		$data['other_images'] = $this->db->where('SURVEY_NO', $survey_no)->get('TB_SURVEY_MARKET_IMAGE')->result_array();

		header('Content-Type: application/json');
		echo trim(json_encode($data));
		exit;
	}

	private function datatable($filter, $npk_user)
	{
		$sdate = date('d-m-Y', strtotime($filter['sdate']));
		$edate = date('d-m-Y', strtotime($filter['edate']));

		// Daftar NPK yang boleh lihat semua data
		$exception_ids = ['01220023', '999999', '01220014', '07050009'];

		$where_npk = "";
		if (!in_array($npk_user, $exception_ids)) {
			$where_npk = " AND P.SALES_NPK = '$npk_user'";
		}

		// Query utama: TB_PLAN + TB_PLAN_ACTIVITY
		$query_main = "
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
				$where_npk
			ORDER BY P.ACTIVITY_DATE DESC
		";

		$main_data = $this->db->query($query_main)->result_array();

		// Query tambahan: TB_PLAN + TB_PLAN_ACTIVITY_OTHER
		$query_other = "
			SELECT 
				P.ACTIVITY_NO,
				B.CUSTOMER,
				B.PHONE,
				B.ADDRESS,
				B.REMARK
			FROM TB_PLAN P
			JOIN TB_PLAN_ACTIVITY_OTHER B ON P.ACTIVITY_NO = B.ACTIVITY_NO
			WHERE TO_DATE(P.ACTIVITY_DATE, 'DD-MM-YYYY') 
				BETWEEN TO_DATE('$sdate', 'DD-MM-YYYY') 
				AND TO_DATE('$edate', 'DD-MM-YYYY')
				$where_npk
		";

		$other_data = $this->db->query($query_other)->result_array();

		// Format hasil
		$plans = [];

		// Data dari TB_PLAN_ACTIVITY
		foreach ($main_data as $row) {
			$key = $row['ACTIVITY_NO'];
			if (!isset($plans[$key])) {
				$plans[$key] = [
					'ACTIVITY_NO' => $row['ACTIVITY_NO'],
					'ACTIVITY_DATE' => $row['ACTIVITY_DATE'],
					'SALES_NPK' => $row['SALES_NPK'],
					'SALES_NAME' => $row['SALES_NAME'],
					'customers' => [],
					'other_customers' => []
				];
			}

			$plans[$key]['customers'][] = [
				'CUST' => $row['CUST'],
				'CUST_NAME' => $row['CUST_NAME'],
				'PHONE' => $row['PHONE'],
				'ADDRESS' => $row['ADDRESS'],
				'TARGET_PLAN' => $row['TARGET_PLAN'],
			];
		}

		// Data dari TB_PLAN_ACTIVITY_OTHER
		foreach ($other_data as $row) {
			$key = $row['ACTIVITY_NO'];
			if (!isset($plans[$key])) {
				// Jika tidak ada dari main_data, inisialisasi dasar
				$plans[$key] = [
					'ACTIVITY_NO' => $row['ACTIVITY_NO'],
					'ACTIVITY_DATE' => null,
					'SALES_NPK' => null,
					'SALES_NAME' => null,
					'customers' => [],
					'other_customers' => []
				];
			}

			$plans[$key]['other_customers'][] = [
				'CUSTOMER' => $row['CUSTOMER'],
				'PHONE' => $row['PHONE'],
				'ADDRESS' => $row['ADDRESS'],
				'REMARK' => $row['REMARK']
			];
		}

		return array_values($plans);
	}

	private function datatable_report($filter, $npk_user)
	{
		$sdate = date('d-m-Y', strtotime($filter['sdate']));
		$edate = date('d-m-Y', strtotime($filter['edate']));

		// NPK pengecualian (bisa lihat semua data)
		$exception_ids = ['01220023', '999999', '01220014', '07050009'];
		$where_npk = "";
		$sales_filter = "";

		if (!in_array($npk_user, $exception_ids)) {
			$where_npk = " AND P.SALES_NPK = '$npk_user'";
		}

		if ($filter['sales'] != '*') {
			$sales_filter = " and P.SALES_NPK = '".$filter['sales']."'";
		}

		// Query dari TB_PLAN_ACTIVITY
		$query_1 = "
			SELECT 
				P.ACTIVITY_NO,
				P.ACTIVITY_DATE,
				P.SALES_NPK,
				P.SALES_NAME,
				A.CUST AS CUSTOMER_CODE,
				A.CUST_NAME AS CUSTOMER_NAME,
				A.TARGET_PLAN,
				A.REMARK
			FROM TB_PLAN P
			JOIN TB_PLAN_ACTIVITY A ON P.ACTIVITY_NO = A.ACTIVITY_NO
			WHERE TO_DATE(P.ACTIVITY_DATE, 'DD-MM-YYYY') 
				BETWEEN TO_DATE('$sdate', 'DD-MM-YYYY') 
				AND TO_DATE('$edate', 'DD-MM-YYYY')
				$where_npk
				$sales_filter
			ORDER BY P.ACTIVITY_DATE DESC
		";

		// Query dari TB_PLAN_ACTIVITY_OTHER
		$query_2 = "
			SELECT 
				P.ACTIVITY_NO,
				P.ACTIVITY_DATE,
				P.SALES_NPK,
				P.SALES_NAME,
				B.CUSTOMER AS CUSTOMER_CODE,
				B.CUSTOMER AS CUSTOMER_NAME,
				B.TARGET_PLAN,
				B.REMARK
			FROM TB_PLAN P
			JOIN TB_PLAN_ACTIVITY_OTHER B ON P.ACTIVITY_NO = B.ACTIVITY_NO
			WHERE TO_DATE(P.ACTIVITY_DATE, 'DD-MM-YYYY') 
				BETWEEN TO_DATE('$sdate', 'DD-MM-YYYY') 
				AND TO_DATE('$edate', 'DD-MM-YYYY')
				$where_npk
				$sales_filter
			ORDER BY P.ACTIVITY_DATE DESC
		";

		// Gabungkan hasil dari kedua query
		$data_1 = $this->db->query($query_1)->result_array();
		$data_2 = $this->db->query($query_2)->result_array();

		// Gabung dua hasil ke dalam satu array
		$result = array_merge($data_1, $data_2);

		return $result;
	}

	private function datatable_survey($filter, $npk_user)
	{
		$sdate = date('d-m-Y', strtotime($filter['sdate']));
		$edate = date('d-m-Y', strtotime($filter['edate']));

		// NPK yang dapat akses semua data
		$exception_ids = ['01220023', '999999', '01220014', '07050009'];

		$query = "
			SELECT *
			FROM TB_SURVEY_MARKET
			WHERE TO_DATE(SURVEY_DATE, 'DD-MM-YYYY') 
				BETWEEN TO_DATE('$sdate', 'DD-MM-YYYY') 
				AND TO_DATE('$edate', 'DD-MM-YYYY')
		";

		// Tambahkan filter jika bukan user pengecualian
		if (!in_array($npk_user, $exception_ids)) {
			$query .= " AND SALES_NPK = '$npk_user'";
		}

		$query .= " ORDER BY SURVEY_DATE ASC";

		// Eksekusi query
		$result = $this->db->query($query)->result_array();

		return $result;
	}

	private function datatable_cust() 
	{
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

	

	private function cekLogin() 
	{
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