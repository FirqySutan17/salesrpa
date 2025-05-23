<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SettingUserCustomer extends CI_Controller {
	var $menu_id = "";
	var $session_data = "";
	public function __Construct() {
		parent::__construct();
		$this->menu_id = 'O006';
		$this->session_data = $this->session->userdata('user_dashboard');

		$this->cekLogin();
		$this->own_link = admin_url('setting-user-customer');
	}

	public function index() {

		$data['title'] 			= 'DATA USER';
		$data['user']				= $this->session_data['user'];
		$data['datatable']	= $this->datatable();
		$this->template->_v('setting_usercust/index', $data);
	}

	public function edit($employee_id) {

		$data['title'] 		= 'Setting User Customer';
		$data['model']		= $this->Dbhelper->selectTabelOne('*', 'CD_USER', array('EMPLOYEE_ID' => $employee_id));
		$model_uc					= $this->Dbhelper->selectTabel('*', 'CD_USER_CUSTOMER', array('EMPLOYEE_ID' => $employee_id));
		$model_area 			= $this->Dbhelper->selectTabel('CODE_AREA', 'CD_USER_AREA', array('EMPLOYEE_ID' => $employee_id));

		$user_customer = [];
		$user_area = [];
		if (!empty($model_area)) {
			foreach ($model_area as $v) {
				$user_area[] = $v['CODE_AREA'];
			}
		}
		if (!empty($model_uc)) {
			foreach ($model_uc as $v) {
				$user_customer[] = $v['CUSTOMER'];
			}
		}

		
		$data['area'] 				= $this->Dbhelper->selectTabel('CODE, CODE_NAME', 'CD_CODE', array('HEAD_CODE' => 'SA01'), 'CODE', 'ASC');
		$data['model_area'] 		= $user_area;
		$data['user_customer']	= $user_customer;
		$data['list_customer']	= $this->datatable_cust($user_area);
		$this->template->_v('setting_usercust/edit', $data);
	}

	public function do_update() {

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();

			$employee_id 		= $post['employee_id'];
			$customer_data 	= $post['customer'];

			$customer_batch = [];
			if (!empty($customer_data)) {
				foreach ($customer_data as $v) {
					$customer_batch[] = [
						'EMPLOYEE_ID'	=> $employee_id,
						'CUSTOMER'		=> $v
					];
				}
				
			}

			$this->db->delete('CD_USER_CUSTOMER', array('EMPLOYEE_ID' => $employee_id));
			if (!empty($customer_batch)) {
				$save = $this->db->insert_batch('CD_USER_CUSTOMER', $customer_batch);	

			}
			
			$this->session->set_flashdata('success', "Update data success");
			return redirect($this->own_link);
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function area($employee_id) {

		$data['title'] 		= 'Setting User Customer';
		$data['model']		= $this->Dbhelper->selectTabelOne('*', 'CD_USER', array('EMPLOYEE_ID' => $employee_id));
		$model_area 			= $this->Dbhelper->selectTabel('CODE_AREA', 'CD_USER_AREA', array('EMPLOYEE_ID' => $employee_id));
		$model_op 				= $this->Dbhelper->selectTabel('CODE_AREA', 'CD_USER_AREA_OP', array('EMPLOYEE_ID' => $employee_id));

		$user_area = [];
		$user_op = [];
		if (!empty($model_area)) {
			foreach ($model_area as $v) {
				$user_area[] = $v['CODE_AREA'];
			}
		}
		if (!empty($model_op)) {
			foreach ($model_op as $v) {
				$user_op[] = $v['CODE_AREA'];
			}
		}
		$data['list_area'] 				= $this->Dbhelper->selectTabel('CODE, CODE_NAME', 'CD_CODE', array('HEAD_CODE' => 'SA01'), 'CODE', 'ASC');
		$data['list_op'] 				= $this->Dbhelper->selectTabel('CODE, CODE_NAME', 'CD_CODE', array('HEAD_CODE' => 'TR20'), 'CODE', 'ASC');
		$data['model_area'] 		= $user_area;
		$data['model_op'] 		= $user_op;
		$data['list_customer']	= $this->datatable_cust($user_area);
		$this->template->_v('setting_usercust/area', $data);
	}

	public function do_area() {

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();

			$employee_id 		= $post['employee_id'];
			$area_batch = [];
			foreach ($post['sales_area'] as $v) {
				$area_batch[] = [
					'EMPLOYEE_ID'	=> $post['employee_id'],
					'CODE_AREA'		=> $v
				];
			}
			$this->db->delete('CD_USER_AREA', array('EMPLOYEE_ID' => $post['employee_id']));
			if (!empty($area_batch)) {
				$save = $this->db->insert_batch('CD_USER_AREA', $area_batch);
			}

			$op_area_batch = [];
			foreach ($post['op_area'] as $v) {
				$op_area_batch[] = [
					'EMPLOYEE_ID'	=> $post['employee_id'],
					'CODE_AREA'		=> $v
				];
			}
			$this->db->delete('CD_USER_AREA_OP', array('EMPLOYEE_ID' => $post['employee_id']));
			if (!empty($op_area_batch)) {
				$save = $this->db->insert_batch('CD_USER_AREA_OP', $op_area_batch);
			}
			
			$this->session->set_flashdata('success', "Update data success");
			return redirect($this->own_link);
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function index_approval_price() {

		$data['title'] 			= 'DATA APPROVAL OP';
		$data['datatable']	= $this->Dbhelper->selectTabel('HEAD_CODE, CODE, CODE_NAME, DESC1, DESC2', 'CD_CODE', array('HEAD_CODE' => 'APR01', 'CODE !=' => '*'));
		$this->template->_v('setting_usercust/index_approval_price', $data);
	}

	public function index_approval() {
		$this->cekLogin('O007');
		$role = 'KOORDINATOR';
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$role 			= $this->input->post('role');
		}


		$data['title'] 			= 'DATA SETTING APPROVAL';
		$data['datatable']	= $this->Dbhelper->selectTabel('EMPLOYEE_ID, FULL_NAME, EMAIL, ROLE, PHONE_NUMBER', 'CD_USER', array('ROLE' => $role, 'IS_ACTIVE' => 'Y'));
		$data['active_role'] = $role;
		$data['role']				= [
			'KOORDINATOR',
			'MANAGER',
			'HEAD',
			'DIREKTUR'
		];
		$this->template->_v('setting_usercust/index_approval', $data);
	}

	public function edit_approval($employee_id) {

		$data['title'] 		= 'Setting Sales Approval';
		$data['model']		= $this->Dbhelper->selectTabelOne('EMPLOYEE_ID, FULL_NAME, ROLE', 'CD_USER', array('EMPLOYEE_ID' => $employee_id));

		$role_name = $data['model']['ROLE'];
		$query = "
			SELECT HEAD_CODE, CODE, CODE_NAME FROM CD_CODE WHERE HEAD_CODE = 'APR01' AND CODE = (
				SELECT TO_CHAR(CODE - 1) as CODE FROM CD_CODE WHERE HEAD_CODE = 'APR01' AND CODE_NAME = '$role_name'
			)
		";
		$user_level 			= $this->Dbhelper->selectOneRawQuery($query);
		$employee_level = $user_level['CODE'] + 1;
		$model_employee_approval 	= $this->Dbhelper->selectTabel('EMPLOYEE_ID, EMPLOYEE_APPROVAL_ID', 'CD_SALES_APPROVAL', array('EMPLOYEE_ID' => $employee_id, 'APPROVAL_LEVEL' => $employee_level));

		$user_approval = [];
		if (!empty($model_employee_approval)) {
			foreach ($model_employee_approval as $v) {
				$user_approval[] = $v['EMPLOYEE_APPROVAL_ID'];
			}
		}

		$data['employee_list']		= $this->Dbhelper->selectTabel('EMPLOYEE_ID, FULL_NAME', 'CD_USER', array('ROLE' => $user_level['CODE_NAME'], 'IS_ACTIVE' => 'Y'), 'FULL_NAME', 'ASC');
		$data['user_approval'] 		= $user_approval;
		$data['model']['APPROVAL_LEVEL'] = $employee_level;
		// dd($data);
		$this->template->_v('setting_usercust/edit_approval', $data);
	}

	public function do_update_approval() {

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$employee_id 		= $post['employee_id'];
			$approval_level = $post['approval_level'];
			$employee_list 			= $post['employee'];

			$employee = [];
			if (!empty($employee_list)) {
				foreach ($employee_list as $v) {
					$employee[] = [
						'EMPLOYEE_ID'	=> $employee_id,
						'EMPLOYEE_APPROVAL_ID'		=> $v,
						'APPROVAL_LEVEL' => $approval_level
					];
				}
				
			}

			$this->db->delete('CD_SALES_APPROVAL', array('EMPLOYEE_ID' => $employee_id, 'APPROVAL_LEVEL' => $approval_level));
			if (!empty($employee)) {
				$save = $this->db->insert_batch('CD_SALES_APPROVAL', $employee);	

			}
			
			$this->session->set_flashdata('success', "Update data success");
			return redirect(admin_url('setting-approval'));
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect(admin_url('setting-approval'));
	}

	public function index_open_price() {
		$this->cekLogin('O008');

		$date = date('Ymd');
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$date 			= date('Ymd', strtotime($this->input->post('date')));
		}

		$query = "
			SELECT A.HEAD_CODE, A.CODE, A.CODE_NAME as PLANT, $date as PRICE_DATE, (SELECT JSON_PRICE FROM CD_SALES_OPEN_PRICE WHERE CODE = A.CODE AND PRICE_DATE = '$date') JSON_PRICE
			FROM CD_CODE A
			WHERE
				A.HEAD_CODE = 'TR20' AND
				A.CODE != '*' AND
				A.USE_YN = 'Y'
		";
		$data['title'] 			= 'SETTING - SALES OP';
		$data['datatable']	= $this->Dbhelper->selectRawQuery($query);
		$data['date']				= date('Y-m-d', strtotime($date));
		// dd($data);	
		$this->template->_v('setting_usercust/index_open_price', $data);
	}

	public function edit_open_price($codeDate) {

		$expCodeDate = explode("-", $codeDate);
		$query = "
			SELECT A.HEAD_CODE, A.CODE, A.CODE_NAME as PLANT, $expCodeDate[1] as PRICE_DATE, (SELECT JSON_PRICE FROM CD_SALES_OPEN_PRICE WHERE CODE = A.CODE AND PRICE_DATE = '$expCodeDate[1]') JSON_PRICE
			FROM CD_CODE A
			WHERE
				A.HEAD_CODE = 'TR20' AND
				A.CODE = '$expCodeDate[0]' AND
				A.USE_YN = 'Y'
		";
		$data['title'] 		= 'Setting Sales Open Price';
		$data['model']		= $this->Dbhelper->selectOneRawQuery($query);
		$data['range_bw_list']		= $this->Dbhelper->selectTabel('*', 'MT_RANGE_BW', array(), 'SEQ', 'ASC');
		// dd($data);
		$this->template->_v('setting_usercust/edit_open_price', $data);
	}

	public function do_update_open_price() {

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$code 		= $post['code'];
			$price_date = $post['date'];
			$price_list = [];

			if (!empty($post['range'])) {
				foreach ($post['range'] as $seq => $cal) {
					$price = !empty($post['prices'][$seq]) ? $post['prices'][$seq] : 0;
					$price_list[$seq] = [
						'cal' 	=> $cal,
						'price'	=> $price
					];
				}				
			}
			
			$insert = [
				'CODE'	=> $code,
				'PRICE_DATE' => $price_date,
				'JSON_PRICE' => json_encode($price_list)
			];
			$this->db->delete('CD_SALES_OPEN_PRICE', array('CODE' => $code, 'PRICE_DATE' => $price_date));
			if (!empty($insert)) {
				$save = $this->db->insert('CD_SALES_OPEN_PRICE', $insert);	

			}
			
			$this->session->set_flashdata('success', "Update data success");
			return redirect(admin_url('setting-open-price'));
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect(admin_url('setting-open-price'));
	}

	public function do_upload_open_price() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post 	= $this->input->post();
			$berkas = $_FILES['file'];
			if (!empty($berkas)) {
				$filedata =	explode("\n", file_get_contents($berkas['tmp_name']));
				$result = $this->open_price_upload($filedata, $post);
				// $result = $this->employee_upload($filedata, '3232');
				// $result = $this->collector_data($filedata);
				// $result = $this->customer_data($filedata);
			}
			$this->session->set_flashdata('error', "Import data gagal");
        	return redirect(admin_url('setting-open-price'));
		}
		echo "CANNOT ACCESS THIS URL";
		exit();
	}

	public function open_price_upload($filedata, $post) {
		$table_name 	= "CD_SALES_OPEN_PRICE";
		$date = date('Ymd', strtotime($post['date']));

		$templatePrice = [];
		foreach ($filedata as $i => $v) {
			$v = dbClean(trim($v));
			$value = explode("	", $v);
			if ($i == 0) {
				$no = 1;
				foreach ($value as $key => $vl) {
					if ($key > 1) {
						$templatePrice[$no] = [
							"cal" 	=> $vl,
							"price"	=> 0
						];
						$no++;
					}
				}
			}
			if (!empty($v) && $i > 1) {
				$code_area 		= $value[0];
				$currentPrice = $templatePrice;
				$no = 1;
				foreach ($value as $key => $vl) {
					if ($key > 1) {
						$currentPrice[$no]["price"] = $vl;
						$no++;
					}
				}

				$head_data = ["CODE" => $code_area, "PRICE_DATE" => $date];
				$check_data = $this->Dbhelper->selectTabelOne('*', $table_name, ["CODE" => $code_area, "PRICE_DATE" => $date]);
				if (!empty($check_data)) {
					// DELETE EXISTING DATA
					// dd($table_name, FALSE);
					// dd($head_data);
					$delete_data = $this->db->delete($table_name, ["CODE" => $code_area, "PRICE_DATE" => $date]);
				}
				$common_data 	= [
					"JSON_PRICE"	=> json_encode($currentPrice)
				];

				$post_data = array_merge($head_data, $common_data);
				$insert_batch[] = $post_data;
			}
		}
		// dd($insert_batch);
		$save = $this->db->insert_batch($table_name, $insert_batch);
		// dd($save, FALSE);
		if ($save) {
			$this->session->set_flashdata('success', "Upload data berhasil");
					return redirect(admin_url('setting-open-price'));
		}
		return 0;
	}

	private function datatable() {
		$this->db->select('
			CD_USER.PLANT as COMPANY_CODE,
			COMPANY.CODE_NAME as COMPANY_NAME,  
			CD_USER.EMPLOYEE_ID as EMPLOYEE_ID,
			CD_USER.FULL_NAME as FULL_NAME,
			CD_USER.REGION as REGION_CODE,
			REGION.CODE_NAME as REGION_NAME,
			CD_USER.EMAIL
		');
        $this->db->from('CD_USER');
        $this->db->join('CD_CODE COMPANY', "CD_USER.PLANT = COMPANY.CODE AND COMPANY.HEAD_CODE = 'AB'");
        $this->db->join('CD_CODE REGION', "CD_USER.REGION = REGION.CODE AND REGION.HEAD_CODE = 'CS02'", "left");
        $this->db->where('CD_USER.ROLE', 'SALES');
        $this->db->where('CD_USER.IS_ACTIVE', 'Y');
        $data = $this->db->get()->result_array();
		return $data;
	}

	private function datatable_cust($user_area = []) {
		$customer_area = "";
		if (!empty($user_area) && !in_array('*', $user_area)) {
			$customer_area = " AND REGION_CODE IN (";
			foreach ($user_area as $i => $v) {
				if ($i > 0) {
					$customer_area .= ", ";
				}
				$customer_area .= "'$v'";
			}
			$customer_area .= ")";
		}
		$customer_area = "";
		$query = "
			SELECT CUST, FULL_NAME FROM CD_CUSTOMER WHERE CUST LIKE 'SK%' $customer_area
			ORDER BY FULL_NAME ASC
		";
		$data 				= $this->db->query($query)->result_array();
		return $data;
	}

	private function validation($post_data) {
		$errMessage 	= [];
		$full_name		= $post_data["FULL_NAME"];
		$employee_id	= $post_data["EMPLOYEE_ID"];
		$plant	= $post_data["PLANT"];
		$region	= $post_data["REGION"];

		if (empty($full_name)) {
			$errMessage[] = "Full Name is required";
		}
		if (empty($employee_id)) {
			$errMessage[] = "Employee ID is required";
		}
		if (empty($plant) || empty($region)) {
			$errMessage[] = "Plant or Region are required";
		}

		return $errMessage;
	}

	// CHANGE NECESSARY POINT
	private function cekLogin($menu_id = "") {
		$session = $this->session_data;
		if (empty($session)) {
			redirect('login_dashboard');
		}

		$user_access = $session['user_access'];
		$menu_id = empty($menu_id) ? $this->menu_id : $menu_id;
		if (!in_array($menu_id, $user_access) && !in_array('*', $user_access)) {
			redirect('dashboard');
		}
	}
}

