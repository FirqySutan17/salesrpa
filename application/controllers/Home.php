<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __Construct() {
		parent::__construct();
		$this->session_data = $this->session->userdata('user_dashboard');
		$this->load->library('upload');
	}

	public function index() {
		$is_login = empty($this->session_data) ? FALSE : TRUE;
		$data = [
			'is_login'	=> $is_login
		];
		$this->load->view('welcome', $data);
	}

	public function detail_mobile($visiting_no) {

		$data = $this->get_visitingreport($visiting_no);
		$data['title'] 				= 'Visit Detail';
		$this->load->view('admin/visit/detail_mobile', $data);
	}

	public function entry_mobile($employee_id) {
		return $this->entry_mobile_view($employee_id);
	}
	

	private function entry_mobile_view($employee_id) {
		$user = $this->Dbhelper->selectTabelOne('*', 'CD_USER', array('EMPLOYEE_ID' => $employee_id));
		if (empty($user)) {
			return "User not found";
		}

		if (!empty($this->session->userdata('user_dashboard'))) {
			$this->session->sess_destroy();
		}

		$data['title'] 			= 'SURVEY';
		$data['user'] 			= $user;
		$data['provinces'] 	= $this->Dbhelper->selectTabel('ID_PROVINCE, PROVINCE', 'CD_PROVINCE', [], 'PROVINCE', 'ASC');
		$data['placeholder'] 	= $this->list_placeholder();
		$data['harvest'] 	= $this->list_harvest();
		
		// dd($data['user']);
		$this->load->view('admin/survey/create_mobile', $data);
	}

	public function set_session_mobile($employee_id) {
		$user = $this->Dbhelper->selectTabelOne('*', 'CD_USER', array('EMPLOYEE_ID' => $employee_id));
		if (empty($user)) {
			return "User not found";
		}
		$data["user"] = $user;
		$session['user_dashboard'] = $data;
		$this->session->set_userdata($session);
	}

	public function do_create_mobile() {
		$this->set_session_mobile($this->input->post('employee_id_sess'));
		$session_data = $this->session->userdata('user_dashboard');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$postjson = json_encode($post);
			$textfile = date('YmdHis').'_'.$session_data['user']['EMPLOYEE_ID'];
			$redirect = base_url()."survey/entry_mobile/".$session_data['user']['EMPLOYEE_ID'];
			
			$redirect = $_SERVER['HTTP_REFERER'];
			// dd($redirect); 
			if (!write_file(APPPATH."logs/log_$textfile.txt", $postjson)) {
				$this->session->set_flashdata('alert', "Unable to logs post");
				return redirect($redirect);
			} else {
				$survey_no = $this->generateSurveyNo();
				try {
					
					// SURVEY DATA
					$survey_report = [
						"SURVEY_NO"			=> $survey_no,
						"SURVEY_DATE"		=> date('Ymd', strtotime($post['survey_date'])),
						"COORDINATE"		=> dbClean($post['coordinate']),
						"LAND_TYPE"			=> dbClean($post['land_type']),
						"PROVINCE"			=> dbClean($post['province']),
						"REGENCY"				=> dbClean($post['regencies']),
						"DISTRICT"			=> dbClean($post['districts']),
						"DESCRIPTION"		=> dbClean($post['address']),
						"CREATED_AT"		=> date('Ymd His'),
						"CREATED_BY"		=> $this->session_data['user']['EMPLOYEE_ID'],
						"PLANT"					=> $this->session_data['user']['PLANT'] == '*' ? '3212' : $this->session_data['user']['PLANT'],
						"CURRENT_PHASE"	=> ""
					];

					if (empty($survey_report["CREATED_BY"])) {
						$this->session->set_flashdata('error', "User log-in not found");
							return redirect($this->own_link.'/report');
					}
					
					$survey_farmers = [];
					if (!empty($post['farmer_name'])) {
						foreach ($post['farmer_name'] as $i => $v) {
							$curr_data = [
								"SURVEY_NO"		=> $survey_no,
								"SEQUENCE"		=> $i + 1,
								"SURVEY_DATE"	=> date('Ymd', strtotime($survey_report['SURVEY_DATE'])),
								"FARMER_NAME"	=> $v,
								"FARMER_PHONE"	=> $post['farmer_phone'][$i]
							];

							$survey_farmers[] = $curr_data;
						}
					}

					$survey_market_price = [];
					if (!empty($post['market_price'])) {
						foreach ($post['market_price'] as $i => $v) {
							$curr_data = [
								"SURVEY_NO"		=> $survey_no,
								"SURVEY_DATE"	=> date('Ymd', strtotime($post['market_date'][$i])),
								"PRICE"	=> $v
							];

							$survey_market_price[] = $curr_data;
						}
					}

					$survey_harvest_phase = [];

					$survey_planting_phase = [];
					$current_phase 	= "";
					$phase_array = ['persiapan-lahan', 'vegetatif-awal', 'vegetatif-akhir', 'genetatif-awal', 'genetatif-akhir', 'gagal-panen'];
					if (!empty($post['PLANTING_siklus'])) {
						$sequence = 1;
						foreach ($post['PLANTING_siklus'] as $siklus_index => $siklus) {
							foreach ($phase_array as $phase_key) {
								$phase 	= $post['PLANTING_phase'][$phase_key][$siklus_index];
								$curr_phase_date 	= !empty($post['PLANTING_date'][$phase_key][$siklus_index]) ?  date('Ymd', strtotime($post['PLANTING_date'][$phase_key][$siklus_index])) : '';

								if (!empty($curr_phase_date)) {
									$current_phase = $phase_key;
								}
								foreach ($post['PLANTING_description'][$phase_key][$siklus_index] as $i => $v) {
									$curr_data = [
										"SURVEY_NO"			=> $survey_no,
										"SEQUENCE"			=> $sequence,
										"SURVEY_DATE"		=> $curr_phase_date,
										"PHASE"				=> $phase,
										"DESCRIPTION"		=> dbClean($v),
										"SIKLUS"			=> $siklus
									];
			
									$sequence += 1;
									$survey_planting_phase[] = $curr_data;
								}
							}

							if (!empty($post['HARVEST_score'])) {
								foreach ($post['HARVEST_score'][$siklus_index] as $i => $v) {
									if (!empty($post['baris'][$siklus_index][$i])) {
										$curr_data = [
											"SURVEY_NO"			=> $survey_no,
											"SEQUENCE"			=> $i + 1,
											"SURVEY_DATE"		=> date('Ymd', strtotime($survey_report['SURVEY_DATE'])),
											"SCORE"				=> $v,
											"BARIS"				=> dbClean($post['baris'][$siklus_index][$i]),
											"BARIS_ACTUAL"		=> dbClean($post['baris_actual'][$siklus_index][$i]),
											"BARIS"				=> dbClean($post['baris'][$siklus_index][$i]),
											"BARIS_ACTUAL"		=> dbClean($post['baris_actual'][$siklus_index][$i]),
											"BIJI"				=> dbClean($post['biji'][$siklus_index][$i]),
											"BIJI_ACTUAL"		=> dbClean($post['biji_actual'][$siklus_index][$i]),
											"BOBOT"				=> dbClean($post['bobot'][$siklus_index][$i]),
											"BOBOT_ACTUAL"		=> dbClean($post['bobot_actual'][$siklus_index][$i]),
											'SIKLUS'			=> $siklus
										];
			
										$survey_harvest_phase[] = $curr_data;
									}
								}
							}
						}
					}


					$survey_galleries = [];
					if (!empty($_FILES)) {
						// foreach ($_FILES['SURVEY_IMAGE']['name'] as $key => $v) {
						// 	$no = $key + 1;
						// 	$berkas = [];
						// 	$berkas['name']= $v;
						//       $berkas['type']= $_FILES['SURVEY_IMAGE']['type'][$key];
						//       $berkas['tmp_name']= $_FILES['SURVEY_IMAGE']['tmp_name'][$key];
						//       $berkas['error']= $_FILES['SURVEY_IMAGE']['error'][$key];
						//       $berkas['size']= $_FILES['SURVEY_IMAGE']['size'][$key];

						//       $namafile = $this->upload_image($berkas, $survey_no, $no);
						//       $survey_galleries[] = [
						//       	'SURVEY_NO'		=> $survey_no,
						//       	'SEQUENCE'		=> $no,
						//       	'IMAGE_TITLE'	=> !empty($post['SURVEY_IMAGE_TITLE'][$key]) ? $post['SURVEY_IMAGE_TITLE'][$key] : '-',
						//       	'IMAGE_FILENAME'	=> $namafile
						//       ];
						// }
					}
					$survey_report['CURRENT_PHASE'] = $current_phase;
					$save = $this->Dbhelper->insertData('SURVEY', $survey_report);
					if (!empty($survey_farmers)) {
						$save_farmers = $this->db->insert_batch('SURVEY_FARMERS', $survey_farmers);
					}
					if (!empty($survey_market_price)) {
						$save_market_prices = $this->db->insert_batch('SURVEY_MARKET_PRICES', $survey_market_price);
					}
					if (!empty($survey_harvest_phase)) {
						$save_harvest_phase = $this->db->insert_batch('SURVEY_HARVEST_PHASE', $survey_harvest_phase);
					}
					if (!empty($survey_planting_phase)) {
						$save_planting_phase = $this->db->insert_batch('SURVEY_PLANTING_PHASE', $survey_planting_phase);
						// dd($save_planting_phase, FALSE);
						// dd($survey_planting_phase);
					}
					if (!empty($survey_galleries)) {
						$save_galleries = $this->db->insert_batch('SURVEY_IMAGES', $survey_galleries);
					}
					if ($save) {
						$this->session->set_flashdata('success', "Create data success");
						return redirect($this->own_link);
					}
				} catch (Exception $e) {
					dd($e->getMessage());
				}
			}
			$this->session->set_flashdata('alert', "Create data failed");
			return redirect($redirect);
		} else {
			return redirect($redirect);
		}
	}

	private function generateSurveyNo() {
		$generated_no = "SURVEY".date('Ymd');
		$no = 1;
		$today = date('Ymd');
		$this->db->select('SURVEY_NO, CREATED_AT');
		$this->db->from('SURVEY');
		$this->db->like('CREATED_AT', $today, 'after');
		$this->db->order_by('CREATED_AT', 'DESC');
		$this->db->order_by('SURVEY_NO', 'DESC');
		$latest_data = $this->db->get()->row();
		if (!empty($latest_data)) {
				$no = substr($latest_data->SURVEY_NO, -4);

				$date = date('Y-m-d', strtotime($latest_data->CREATED_AT));
				$hour = date('H', strtotime($latest_data->CREATED_AT));
				$no += 1;
		}
		if ($no < 10) {
				$no = "000".$no;
		} elseif ($no >= 10 && $no < 100) {
				$no = "00".$no;
		} elseif ($no >= 100 && $no < 1000) {
				$no = "0".$no;
		}

		$generated_no = $generated_no.$no;
		return $generated_no;
	}

	private function list_surveyor() {
		$query = "
			select
				CREATED_BY,
				FN_USER_NAME(CREATED_BY) CREATED_BY_NAME
			from SURVEY
			WHERE CREATED_BY != '999999'
			GROUP BY CREATED_BY
			ORDER BY CREATED_BY ASC
		";
		$data 				= $this->db->query($query)->result_array();
		return $data;
	}

	private function list_phase() {
		$data = [];

		$data[] 	= ["CODE" => 'persiapan-lahan', "CODE_NAME" => 'PERSIAPAN LAHAN'];
		$data[] 	= ["CODE" => 'vegetatif-awal', 	"CODE_NAME" => 'VEGETATIF AWAL'];
		$data[] 	= ["CODE" => 'vegetatif-akhir', "CODE_NAME" => 'VEGETATIF AKHIR'];
		$data[] 	= ["CODE" => 'genetatif-awal', 	"CODE_NAME" => 'GENETATIF AWAL'];
		$data[] 	= ["CODE" => 'genetatif-akhir', "CODE_NAME" => 'GENETATIF AKHIR'];
		$data[] 	= ["CODE" => 'gagal-panen', 		"CODE_NAME" => 'GAGAL PANEN'];
		return $data;
	}

	private function list_placeholder() {
		$data = [];

		$data['persiapan-lahan'] 	= ["STANDARD / KETERANGAN PERSIAPAN LAHAN"];
		$data['vegetatif-awal'] 	= ["UMUR TANAM (1 - 25)", "TINGGI TANAMAN", "JUMLAH DAUN", "JENIS PUPUK YANG SUDAH DIAPLIKASIKAN", "ESTIMASI JUMLAH PUPUK DIAPLIKASIKAN (KG)", "JENIS HERBISIDA / PERSTISIDA YANG DIAPLIKASIKAN", "CUACA SAAT SURVEY (KERING, BERAWAN, GERIMIS, HUJAN ATAU BANJIR)", "FREKUENSI HUJAN DALAM SEMINGGU DI LOKASI SURVEY (BERAPA KALI DALAM SEMINGGU)", "INTESITAS HUJAN DALAM SEMINGGU (KECIL, SEDANG, BESAR)"];
		$data['vegetatif-akhir'] 	= ["UMUR TANAM (26 - 50)", "TINGGI TANAMAN", "JUMLAH DAUN", "MUNCUL BUNGA JANTAN DAN BETINA (ADA / TIDAK)", "JENIS PUPUK YANG SUDAH DIAPLIKASIKAN", "ESTIMASI JUMLAH PUPUK DIAPLIKASIKAN (KG)", "JENIS HERBISIDA / PESTISIDA YANG DIAPLIKASIKAN", "CUACA SAAT SURVEY (KERING, BERAWAN, GERIMIS, HUJAN ATAU BANJIR)", "FREKUENSI HUJAN DALAM SEMINGGU DI LOKASI SURVEY (BERAPA KALI DALAM SEMINGGU)", "INTESITAS HUJAN DALAM SEMINGGU (KECIL, SEDANG, BESAR)"];
		$data['genetatif-awal'] 	= ["UMUR TANAM (51 - 70)", "MUNCUL BUAH (ADA / TIDAK)", "JIKA BUAH ADA MAKA UKURAN BUAH (PANJANG DAN DIAMETER BUAH MUDA)", "MUNCUL BUNGA JANTAN DAN BETINA (ADA / TIDAK)", "KONDISI BUAH MUDAH (HUJAN SEGAR, PUCAT ATAU BUSUK)", "ESTIMASI JUMLAH PUPUK DIAPLIKASIKAN (KG)", "JENIS HERBISIDA / PESTISIDA YANG DIAPLIKASIKAN", "CUACA SAAT SURVEY (KERING, BERAWAN, GERIMIS, HUJAN ATAU BANJIR)", "FREKUENSI HUJAN DALAM SEMINGGU DI LOKASI SURVEY (BERAPA KALI DALAM SEMINGGU)", "INTESITAS HUJAN DALAM SEMINGGU (KECIL, SEDANG, BESAR)"];
		$data['genetatif-akhir']	= ["UMUR TANAM (71 - 110)", "MASUK KE FORMAT HASIL PANEN PADA SHEET HASIL PANEN", "JENIS HERBISIDA / PESTISIDA YANG DIAPLIKASIKAN", "CUACA SAAT SURVEY (KERING, BERAWAN, GERIMIS, HUJAN ATAU BANJIR)", "FREKUENSI HUJAN DALAM SEMINGGU DI LOKASI SURVEY (BERAPA KALI DALAM SEMINGGU)", "INTESITAS HUJAN DALAM SEMINGGU (KECIL, SEDANG, BESAR)"];
		$data['gagal-panen']			= ["UMUR SAAT PUSO", "KONDISI SAAT PUSO (KEKERINGAN / BANJIR)", "ESTIMASI LAHAN YANG TERKENA PUSO", "ESTIMASI PRODUKSI YANG HILANG KARENA PUSO"];

		return $data;
	}

	private function list_harvest() {
		$result = [];
		
		$result[0] = [
			"BARIS"	=> '0 - 5',
			"BIJI"	=> '0',
			"BOBOT"			=> '0'
		];

		$result[1] = [
			"BARIS"	=> '6',
			"BIJI"	=> '1-50',
			"BOBOT"			=> '1-9'
		];

		$result[2] = [
			"BARIS"	=> '7',
			"BIJI"	=> '51-100',
			"BOBOT"			=> '10-40'
		];

		$result[3] = [
			"BARIS"	=> '8-9',
			"BIJI"	=> '101-150',
			"BOBOT"			=> '41-80'
		];

		$result[4] = [
			"BARIS"	=> '10',
			"BIJI"	=> '151-200',
			"BOBOT"			=> '81-120'
		];

		$result[5] = [
			"BARIS"	=> '11',
			"BIJI"	=> '201-250',
			"BOBOT"			=> '121-160'
		];

		$result[6] = [
			"BARIS"	=> '12',
			"BIJI"	=> '251-300',
			"BOBOT"			=> '161-200'
		];

		$result[7] = [
			"BARIS"	=> '13',
			"BIJI"	=> '301-350',
			"BOBOT"			=> '201-240'
		];

		$result[8] = [
			"BARIS"	=> '14',
			"BIJI"	=> '351-400',
			"BOBOT"			=> '241-280'
		];

		$result[9] = [
			"BARIS"	=> '15',
			"BIJI"	=> '401-450',
			"BOBOT"			=> '281-320'
		];

		$result[10] = [
			"BARIS"	=> '16',
			"BIJI"	=> '451-500',
			"BOBOT"			=> '321-350'
		];

		return $result;
	}

	public function upload_image($berkas, $survey_no, $sequence) {
		$result = "";
		if ($berkas["name"] != "") {
			$pathDir 	= "./upload/";
			// chmod($pathDir, 777);
			$temp = explode(".", $berkas["name"]);
			$type_file = '.'.end($temp);
			if (trim($berkas['name']) != "") {
				$_FILES["files"] = $berkas;
				$stringRandom = random_char(10);
				$nama = $survey_no."_".$sequence.$type_file;
				$config['upload_path']          = $pathDir;
								$config['allowed_types']        = 'gif|jpg|png|jpeg';

								$config['file_name'] = $nama;
								$this->upload->initialize($config);
								if ( ! $this->upload->do_upload('files')) {
										$result = array('error' => $this->upload->display_errors());
								} else {
										$result = $nama;
								}
			}
		}

		return $result;
	}

	private function collection_type() {
		$data = [
			'CICILAN', 'SEGERA', 'TRANSAKSI_ULANG', 'JALUR_HUKUM', 'TAKE_OVER_ASSET', 'AMBIL_JAMINAN', 'SULIT_COLLECTION', 'SHM'
		];

		return $data;
	}

	private function get_visitingreport($visiting_no) {
		$data['vr'] 			= $this->detail_data($visiting_no);
		$data['vr_assets']		= $this->Dbhelper->selectTabel('*', 'TR_VR_ASSETS', array('VISITING_NO' => $visiting_no), 'SEQUENCE', 'ASC');
		$data['vr_collection_plan']		= $this->Dbhelper->selectTabel('*', 'TR_VR_COLLECTION_PLAN', array('VISITING_NO' => $visiting_no), 'SEQUENCE', 'ASC');
		$data['vr_details']		= $this->Dbhelper->selectTabel('*', 'TR_VR_DETAILS', array('VISITING_NO' => $visiting_no), 'SEQUENCE', 'ASC');
		$data['vr_other_debts']		= $this->Dbhelper->selectTabel('*', 'TR_VR_OTHER_DEBTS', array('VISITING_NO' => $visiting_no), 'SEQUENCE', 'ASC');
		$data['vr_strategy']		= $this->Dbhelper->selectTabel('*', 'TR_VR_STRATEGY', array('VISITING_NO' => $visiting_no), 'SEQUENCE', 'ASC');
		$data['vr_galleries']		= $this->Dbhelper->selectTabel('*', 'TR_VR_GALLERIES', array('VISITING_NO' => $visiting_no), 'SEQUENCE', 'ASC');
		return $data;
	}

	private function detail_data($visiting_no) {
		$query = "
			select
			    a.*,
			    b.SALES_ORG as COMPANY_CODE,
			    b.CUSTOMER_NAME,
				b.TELEPHONE_2,
				b.STREET,
				b.CHIEF,
				b.CHIEF_ID,
			    FN_CODE_NAME('CS02' ,REGION)   REGION_NAME,
			    FN_CODE_NAME('AB' ,SALES_ORG)   COMPANY_NAME,
			    FN_CODE_NAME('AC01' ,NVL(SALES_OFFICE,'3210'))   SALES_OFFICE_NAME,
			    FN_HR_EMPLOYEE('02',PIC_OPEN_TS) PIC_OPEN_TS_NAME,
			    FN_HR_EMPLOYEE('02',PIC_OPEN_ASM) PIC_OPEN_ASM_NAME,
			    FN_HR_EMPLOYEE('02',PIC_OPEN_GSM) PIC_OPEN_GSM_NAME,
			    FN_HR_EMPLOYEE('02',PIC_OPEN_CCT) PIC_OPEN_CCT_NAME,
			    FN_HR_EMPLOYEE('02',PIC_CLOSE_TS) PIC_CLOSE_TS_NAME,
			    FN_HR_EMPLOYEE('02',PIC_CLOSE_ASM) PIC_CLOSE_ASM_NAME,
			    FN_HR_EMPLOYEE('02',PIC_CLOSE_GSM) PIC_CLOSE_GSM_NAME,
			    FN_HR_EMPLOYEE('02',PIC_CLOSE_CCT) PIC_CLOSE_CCT_NAME,
			    FN_USER_NAME(CREATED_BY) CREATED_BY_NAME
			from TR_VR a, CD_CUSTOMER b
			where 
				a.CUSTOMER = b.CUSTOMER 
				and a.PLANT = b.SALES_ORG
				and a.VISITING_NO = '$visiting_no'
		";
        $data = $this->db->query($query)->row_array();
        // dd($this->db->last_query());
        // dd($data);
        return $data;
	}

	private function generateVisitingNo() {
        $generated_no = "VISIT".date('Ymd');
        $no = 1;
        $today = date('Ymd');
        $this->db->select('VISITING_NO, CREATED_AT');
        $this->db->from('TR_VR');
        $this->db->like('CREATED_AT', $today, 'after');
        $this->db->order_by('CREATED_AT', 'DESC');
        $this->db->order_by('VISITING_NO', 'DESC');
        $latest_data = $this->db->get()->row();
        if (!empty($latest_data)) {
            $no = substr($latest_data->VISITING_NO, -4);

            $date = date('Y-m-d', strtotime($latest_data->CREATED_AT));
            $hour = date('H', strtotime($latest_data->CREATED_AT));
            $no += 1;
        }
        if ($no < 10) {
            $no = "000".$no;
        } elseif ($no >= 10 && $no < 100) {
            $no = "00".$no;
        } elseif ($no >= 100 && $no < 1000) {
            $no = "0".$no;
        }

        $generated_no = $generated_no.$no;
        return $generated_no;
    }


		private function delete_image($filename) {
			$path_to_file = './upload/'.$filename;
			if(unlink($path_to_file)) {
					return true;
			}
			else {
					return false;
			}
		}

		public function profile() {
			$this->cekLogin();
			$data['title'] 	= 'My Profile';
			$data['user']	= $this->session_data['user'];
			$this->template->_v('profile/index', $data);
		}

		public function profile_update() {
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$post = $this->input->post();
				$update_data = [];

				$user = $this->session_data['user'];
				if (!password_verify($post['CURRENT_PASSWORD'], $user['PASSWORD'])) {
					$this->session->set_flashdata('error', "Update data failed");
					return redirect(base_url()."/profile");
				}

				if (!empty($post['NEW_PASSWORD'])) {
					$update_data['PASSWORD'] = password_hash(dbClean($post['NEW_PASSWORD']), PASSWORD_DEFAULT);
				}

				if (!empty($update_data)) {
					$save 	= $this->Dbhelper->updateData("CD_USER", array('EMPLOYEE_ID' => $user['EMPLOYEE_ID']), $update_data);		
					if ($save) {
						$this->session->set_flashdata('success', "Update data success");
						return redirect(base_url('dashboard'));
					}
				}
				$this->session->set_flashdata('error', "Update data failed");
				return redirect(base_url()."/profile");
			}
			$this->session->set_flashdata('error', "Access denied");
					return redirect(base_url('dashboard'));
		}

		public function ajax_load_project_detail() {
			// $check = $this->onlyRequestPost();
			// if (!$check) {
			// 	return json_encode([]);
			// }

			$project = $this->input->get('project');

			$query = "
				SELECT
					A.*,
					B.PLAZMA_NAME,
					C.FARM_NAME
				FROM TR_PROJECT A, TR_CD_PLAZMA B, TR_CD_FARM C
				WHERE
					A.PLAZMA 	= B.PLAZMA AND
					A.FARM 		= C.FARM AND
					A.PROJECT = '$project'
			";
			$result = $this->db->query($query)->row_array();
			echo json_encode($result);
		}
		
		public function ajax_load_customer() {
			// $check = $this->onlyRequestPost();
			// if (!$check) {
			// 	return json_encode([]);
			// }

			$area = $this->input->get('area');
			if ($area == '') {
				echo json_encode([]);
			} else {
				$keyword = strtoupper($this->input->get('q'));
				$this->db->select('*');
				$this->db->from('CD_CUSTOMER');
				if (!empty($area) && $area != '*') {
					$this->db->where('CD_CUSTOMER.REGION_CODE', $area);
				}
				$this->db->like('CD_CUSTOMER.CUST', 'SK', 'after');
				$this->db->group_start();
					$this->db->like('CD_CUSTOMER.FULL_NAME', $keyword, 'both');
					$this->db->or_like('CD_CUSTOMER.CUST', $keyword, 'both');
				$this->db->group_end();
				$this->db->order_by('CD_CUSTOMER.CUST', 'ASC');

				$data = $this->db->get()->result_array();
				echo json_encode($data);
			}
		}

		public function ajax_load_customer_limit() {
			// $check = $this->onlyRequestPost();
			// if (!$check) {
			// 	return json_encode([]);
			// }

			$customer = $this->input->get('customer');
			$this->db->select('*');
			$this->db->from('TR_SS_REMAINDER');
			$this->db->where('TR_SS_REMAINDER.CUST', $customer);

			$data = $this->db->get()->row_array();

			$result = [
				"status"	=> !empty($data) ? true : false,
				"msg"		=> !empty($data) ? "success" : "failed",
				"data"		=> $data
			];
			echo json_encode($result);
		}

		public function ajax_load_employee() {
			// $check = $this->onlyRequestPost();
			// if (!$check) {
			// 	return json_encode([]);
			// }

			$plant 		= $this->input->get('plant');
			$keyword 	= strtoupper($this->input->get('q'));
			$attr 		= $this->input->get('attribute_name');

			$roles 		= [];
			// if (!empty($attr)) {
			// 	if ($attr == 'pic_open_ts') {
			// 		$roles = ['TS'];
			// 	} elseif ($attr == 'pic_open_cct') {
			// 		$roles = ['CCT'];
			// 	} elseif ($attr == 'pic_open_asm') {
			// 		$roles = ['ASM'];
			// 	} elseif ($attr == 'pic_open_gsm') {
			// 		$roles = ['GSM'];
			// 	}
			// }
			$this->db->select('
				HR_EMPLOYEE.EMPNO,
				HR_EMPLOYEE.FULL_NAME
			');
					$this->db->from('HR_EMPLOYEE');
					$this->db->where('HR_EMPLOYEE.PLANT', $plant);
					$this->db->where('HR_EMPLOYEE.CONDITION_IN_OFFICE', '1');
					if (!empty($roles)) {
						$this->db->where_in('HR_EMPLOYEE.TS_ASM_GSM_CCT', $roles);
					}
					$this->db->group_start();
						$this->db->like('HR_EMPLOYEE.FULL_NAME', $keyword, 'both');
						$this->db->or_like('HR_EMPLOYEE.EMPNO', $keyword, 'both');
					$this->db->group_end();
					$this->db->order_by('HR_EMPLOYEE.FULL_NAME', 'ASC');

					$data = $this->db->get()->result_array();
			echo json_encode($data);
		}

		public function ajax_load_group_customer_reminder() {
			// $check = $this->onlyRequestPost();
			// if (!$check) {
			// 	return json_encode([]);
			// }
			$all_plant = [
				['GROUP_CUSTOMER' => '*', 'GROUP_CUSTOMER_NM' => 'ALL GROUP CUSTOMER']
			];

			$plant = $this->input->get('plant');
			$keyword = strtoupper($this->input->get('q'));
			$this->db->select('
				GROUP_CUSTOMER, GROUP_CUSTOMER_NM
			');
					$this->db->from('FEED_CUST_REMAINDER_WA');
					if (!empty($plant) && $plant != '*') {
						$this->db->where('FEED_CUST_REMAINDER_WA.BUSINESS_AREA', $plant);
					}
					$this->db->group_start();
						$this->db->like('FEED_CUST_REMAINDER_WA.CUSTOMER_NM', $keyword, 'both');
						$this->db->or_like('FEED_CUST_REMAINDER_WA.CUSTOMER', $keyword, 'both');
					$this->db->group_end();
					$this->db->group_by('GROUP_CUSTOMER, GROUP_CUSTOMER_NM');
					$this->db->order_by('FEED_CUST_REMAINDER_WA.GROUP_CUSTOMER_NM', 'ASC');

					$data = $this->db->get()->result_array();
					$data = array_merge($all_plant, $data);
			echo json_encode($data);
		}

		public function ajax_load_customer_reminder() {
			// $check = $this->onlyRequestPost();
			// if (!$check) {
			// 	return json_encode([]);
			// }
			$all_plant = [
				['CUSTOMER' => '*', 'CUSTOMER_NM' => 'ALL CUSTOMER']
			];

			$plant = $this->input->get('plant');
			$group_customer = $this->input->get('group_customer');
			$exp_group_customer = explode("|", $group_customer);
			$keyword = strtoupper($this->input->get('q'));
			$this->db->select('
				CUSTOMER, CUSTOMER_NM
			');
					$this->db->from('FEED_CUST_REMAINDER_WA');
					if (!empty($plant) && $plant != '*') {
						$this->db->where('FEED_CUST_REMAINDER_WA.BUSINESS_AREA', $plant);
					}
					if (!empty($exp_group_customer[0]) && $exp_group_customer[0] != '*') {
				$this->db->where('FEED_CUST_REMAINDER_WA.GROUP_CUSTOMER', $exp_group_customer[0]);
			}
					$this->db->group_start();
						$this->db->like('FEED_CUST_REMAINDER_WA.CUSTOMER_NM', $keyword, 'both');
						$this->db->or_like('FEED_CUST_REMAINDER_WA.CUSTOMER', $keyword, 'both');
					$this->db->group_end();
					$this->db->group_by('CUSTOMER, CUSTOMER_NM');
					$this->db->order_by('FEED_CUST_REMAINDER_WA.CUSTOMER_NM', 'ASC');

					$data = $this->db->get()->result_array();
					$data = array_merge($all_plant, $data);
			echo json_encode($data);
		}

		public function ajax_load_kota() {
			// $check = $this->onlyRequestPost();
			// if (!$check) {
			// 	return json_encode([]);
			// }

			$provinsi 		= $this->input->get('provinsi');
			$keyword 	= strtoupper($this->input->get('q'));
			$this->db->select('
				ID_REGENCIES,
				REGENCIES
			');
					$this->db->from('CD_REGENCIES');
					$this->db->where('PROVINCE_ID', $provinsi);
					$this->db->group_start();
						$this->db->like('REGENCIES', $keyword, 'both');
					$this->db->group_end();
					$this->db->order_by('REGENCIES', 'ASC');

					$data = $this->db->get()->result_array();
			echo json_encode($data);
		}

		public function ajax_load_desa() {
			// $check = $this->onlyRequestPost();
			// if (!$check) {
			// 	return json_encode([]);
			// }

			$kota 		= $this->input->get('kota');
			$keyword 	= strtoupper($this->input->get('q'));
			$this->db->select('
				ID_DISTRICTS,
				DISTRICS
			');
					$this->db->from('CD_DISTRICTS');
					$this->db->where('REGENCIES_ID', $kota);
					$this->db->group_start();
						$this->db->like('DISTRICS', $keyword, 'both');
					$this->db->group_end();
					$this->db->order_by('DISTRICS', 'ASC');

					$data = $this->db->get()->result_array();
			echo json_encode($data);
		}

		private function onlyRequestPost() {
			$session = $this->session_data;
			if (empty($session) || $this->input->server('REQUEST_METHOD') != 'POST') {
				return false;
			}
			return true;
		}

		// DONT CHANGE THIS
		private function cekLogin() {
			$session = $this->session_data;
			if (empty($session)) {
				redirect('login_dashboard');
			}
		}
		private function validation($post_data) {
			$errMessage 	= [];
			$id 			= isset($post_data["id"]) ? $post_data["id"] : null;
			$surat_id		= isset($post_data['surat_id']) ? $post_data['surat_id'] : null;

			if (!empty($id)) {
				$data = $this->Surat_model->find($id);
				if (empty($data)) {
					$this->session->set_flashdata('error', "Data not found");
							return redirect('pengajuan-surat');
						}
						$user = $this->session_data['user'];
						if ($data->user_id != $user['id']) {
							$this->session->set_flashdata('error', "Data not found");
							return redirect('pengajuan-surat');
						}
			}

			return $errMessage;
		}
}
