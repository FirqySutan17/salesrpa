<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Confirm extends CI_Controller {
	var $menu_id 	= "";
	var $menu_id2 	= "";
	var $menu_id3 	= "";
	var $menu_id4 	= "";
	var $session_data = "";
	var $menu_ids = [];
	public function __Construct() {
		parent::__construct();
		$this->menu_id 		= 'C001';
		$this->menu_id2 	= 'C002';
		$this->menu_id3 	= 'C003';
		$this->menu_id4 	= 'C004';
		$this->menu_ids = ['O002', 'O003', 'O004', 'C001', 'C002', 'C003', 'C004'];
		$this->session_data = $this->session->userdata('user_dashboard');

		$this->cekLogin();
		$this->own_link = admin_url('confirm');
		$this->load->library('upload');
	}

  public function index() {
		$sdate 		= date('Y-m-d');
		$edate 		= date('Y-m-d');
		$customer 		= "*";

		$user 			= $this->session_data['user'];
		$user_area 	= !empty($this->session_data['user_area']) ? $this->session_data['user_area'] : [];
		if ($user['EMPLOYEE_ID'] == '999999') {
			$user_area = ['*'];
		}	
		
		$model_uc					= $this->Dbhelper->selectTabel('*', 'CD_USER_CUSTOMER', array('EMPLOYEE_ID' => $user['EMPLOYEE_ID']));
		$user_customer = [];
		if (!empty($model_uc)) {
			foreach ($model_uc as $v) {
				$user_customer[] = $v['CUSTOMER'];
			}
		}
		// dd($user_area);

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$sdate 				= $this->input->post('sdate');
			$edate 				= $this->input->post('edate');
			$customer 			= $this->input->post('customer');
		}
		

		$filter = [
			"sdate"			=> $sdate,
			"edate"			=> $edate,
			"customer"		=> $customer,
		];
		$data['title'] 				= 'BROILER';
		$data['datatable']			= $this->datatable_action($filter, $user_area, $user_customer);
		$data['filter']				= $filter;
		$data['customer'] 			= $this->datatable_cust($user_area);
		// dd($data['customer']);
		$this->template->_v('confirm/index', $data);
	}

	public function report() {
		$sdate 		= date('Y-m').'-01';
		$edate 		= date('Y-m-d');
		$customer 	= "*";
		$status 	= "*";

		$user 		= $this->session_data['user'];
		$user_area 	= !empty($this->session_data['user_area']) ? $this->session_data['user_area'] : [];
		if ($user['EMPLOYEE_ID'] == '999999') {
			$user_area = ['*'];
		}	

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$sdate 				= $this->input->post('sdate');
			$edate 				= $this->input->post('edate');
			$customer 			= $this->input->post('customer');
			$status 		= $this->input->post('confirm_status');
		}

		$filter = [
			"sdate"			=> $sdate,
			"edate"			=> $edate,
			"customer"		=> $customer,
			"status"		=> $status,
		];
		$data['title'] 				= 'BROILER';
		$data['datatable']			= $this->datatable($filter, $user_area);
		$data['filter']				= $filter;
		$data['customer'] 			= $this->datatable_cust($user_area);
		// dd($data['customer']);
		$this->template->_v('confirm/report', $data);
	}

	public function report_approval() {
		$sdate 		= date('Y-m').'-01';
		$edate 		= date('Y-m-d');
		$approval 	= "*";

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$sdate 				= $this->input->post('sdate');
			$edate 				= $this->input->post('edate');
			$approval 			= $this->input->post('approval');
		}

		$filter = [
			"sdate"			=> $sdate,
			"edate"			=> $edate,
			"approval"		=> $approval,
		];

		$data['title'] 				= 'BROILER';
		$data['user']				= $this->session_data['user'];
		$data['filter']				= $filter;
		$data['history'] 			= $this->history($filter);
		$data['approval'] 			= $this->datatable_approval();

		$this->template->_v('confirm/report_approval', $data);
	}

	private function history($filter) {
		$query = "
			SELECT
				E.REQ_NO,
				E.SEQ AS SEQ_NO,
				E.APPROVAL_LEVEL,
				E.APPROVAL,
				E.CREATED_AT,
				A.STATUS AS STATUS_PRICE,
				A.UNIT_PRICE,
				A.MARGIN_PRICE,
				A.OPEN_PRICE,
				B.BW,
				B.QTY,
				C.FULL_NAME AS CUSTOMER_NAME,
				D.FULL_NAME AS APPROVER_NAME,
				E.REMARKS AS APPROVER_REMARKS
			FROM
				TR_SS_ORDER_REQUEST_APPROVAL E,
				TR_SS_ORDER_REQUEST_PRICE A,
				TR_SS_ORDER_REQUEST B,
				CD_CUSTOMER C,
				CD_USER D
			WHERE
				E.REQ_NO = A.REQ_NO
				AND E.SEQ = A.SEQ
				AND E.REQ_NO = B.REQ_NO
				AND B.CUSTOMER = C.CUST
				AND E.EMPLOYEE_ID = D.EMPLOYEE_ID
				AND TO_DATE(SUBSTR(E.CREATED_AT, 1, 8), 'YYYYMMDD') BETWEEN TO_DATE('".$filter['sdate']."', 'YYYY-MM-DD') AND TO_DATE('".$filter['edate']."', 'YYYY-MM-DD')
		";

		if ($filter['approval'] != '*') {
			$query .= " AND E.EMPLOYEE_ID = '".$filter['approval']."'";
		}

		$query .= " ORDER BY E.REQ_NO, E.SEQ, E.CREATED_AT";
		// dd($query);
		return $this->db->query($query)->result_array();
	}


	public function report_excel() {
		$sdate 		= date('Y-m').'-01';
		$edate 		= date('Y-m-d');
		$customer 	= "*";
		$status 	= "*";

		$user 			= $this->session_data['user'];
		$user_area 		= !empty($this->session_data['user_area']) ? $this->session_data['user_area'] : [];
		if ($user['EMPLOYEE_ID'] == '999999') {
			$user_area = ['*'];
		}	

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$sdate 				= $this->input->post('sdate');
			$edate 				= $this->input->post('edate');
			$customer 			= $this->input->post('customer');
			$status 		= $this->input->post('confirm_status');
		}

		$filter = [
			"sdate"			=> $sdate,
			"edate"			=> $edate,
			"customer"		=> $customer,
			"status"		=> $status,
		];
		$datatable			= $this->datatable($filter, $user_area);
		$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();

		$styleBorder = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => '00000000'],
		        ],
		    ],
		    'font' => [
		        'bold' => false,
		        'size' => 11,
		        'name'	=> 'CJ ONLYONE NEW 본문 Light'
		    ],
		    'alignment' => [
		    	'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
		    ],
		];

		$styleTH = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => '00000000'],
		        ],
		    ],
		    'font' => [
		        'bold' => false,
		        'size' => 11,
		        'name'	=> 'CJ ONLYONE NEW 본문 Light'
		    ],
		    'alignment' => [
		    	'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
		    ],
		];

		$styleAMT = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => '00000000'],
		        ],
		    ],
		    'font' => [
		        'bold' => false,
		        'size' => 11,
		        'name'	=> 'CJ ONLYONE NEW 본문 Light'
		    ],
		    'alignment' => [
		    	'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
		    ],
		];

		$styleFTH = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => '00000000'],
		        ],
		    ],
		    'font' => [
		        'bold' => false,
		        'size' => 11,
		        'name'	=> 'CJ ONLYONE NEW 본문 Light'
		    ],
		    'alignment' => [
		    	'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
		    ],
		];


		// HEADER REPORT
			$sheet->setCellValue('A1', 'REQ NO');
			$sheet->setCellValue('B1', 'REQ DATE');
			$sheet->setCellValue('C1', 'REQ TIME');
			$sheet->setCellValue('D1', 'CUSTOMER');
			$sheet->setCellValue('E1', 'CUSTOMER NAME');
			$sheet->setCellValue('F1', 'SALES ID');
			$sheet->setCellValue('G1', 'SALES NAME');
			$sheet->setCellValue('H1', 'PLAZMA NAME');
			$sheet->setCellValue('I1', 'FARM NAME');
			$sheet->setCellValue('J1', 'REQ QTY');
			$sheet->setCellValue('K1', 'REQ BW');
			$sheet->setCellValue('L1', 'REQ REMARKS');
			$sheet->setCellValue('M1', 'QTY');
			$sheet->setCellValue('N1', 'BW');
			$sheet->setCellValue('O1', 'UNIT PRICE');
			$sheet->setCellValue('P1', 'AMOUNT');
			$sheet->setCellValue('Q1', 'SIZE');
			$sheet->setCellValue('R1', 'ORDER STATUS');
			$sheet->setCellValue('S1', 'CONFIRM STATUS');
			$sheet->setCellValue('T1', 'CONFIRM ORDER NO');
			$sheet->setCellValue('U1', 'CONFIRM REMARK');
			$sheet->setCellValue('V1', 'DELIVERY QTY');
			$sheet->setCellValue('W1', 'DELIVERY BW');
			$sheet->getStyle('A1:W1')->applyFromArray($styleTH)->getAlignment()->setWrapText(true);
			$sheet->getRowDimension('1')->setRowHeight(35, 'px');

	    $rowNumber = 2;
	    // LIST DATA
			if (!empty($datatable)) {
				foreach ($datatable as $v) {
					// dd($v);
					$sheet->setCellValue('A'.$rowNumber, $v['REQ_NO']);
					$sheet->setCellValue('B'.$rowNumber, date('Y-m-d', strtotime($v['REG_DATE'])));
					$sheet->setCellValue('C'.$rowNumber, date('H:i:s', strtotime($v['REG_DATE'])));
					$sheet->setCellValue('D'.$rowNumber, $v['CUSTOMER']);
					$sheet->setCellValue('E'.$rowNumber, $v['FULL_NAME']);
					$sheet->setCellValue('F'.$rowNumber, $v['REG_EMP']);
					$sheet->setCellValue('G'.$rowNumber, $v['PIC']);
					$sheet->setCellValue('H'.$rowNumber, $v['PLAZMA_NAME']);
					$sheet->setCellValue('I'.$rowNumber, $v['FARM_NAME']);
					$sheet->setCellValue('J'.$rowNumber, $v['REQ_QTY']);
					$sheet->setCellValue('K'.$rowNumber, $v['REQ_BW']);
					$sheet->setCellValue('L'.$rowNumber, $v['REMARKS']);
					$sheet->setCellValue('M'.$rowNumber, $v['QTY']);
					$sheet->setCellValue('N'.$rowNumber, $v['BW']);
					$sheet->setCellValue('O'.$rowNumber, formatRupiah($v['UP']));
					$sheet->setCellValue('P'.$rowNumber, formatRupiah($v['AMOUNT']));
					$sheet->setCellValue('Q'.$rowNumber, $v['NOTE']);
					$sheet->setCellValue('R'.$rowNumber, $v['STATUS']);
					$sheet->setCellValue('S'.$rowNumber, $v['CONFIRM_STATUS']);
					$sheet->setCellValue('T'.$rowNumber, $v['ORDER_NO']);
					$sheet->setCellValue('U'.$rowNumber, $v['CONFIRM_REMARK']);
					$sheet->setCellValue('V'.$rowNumber, $v['DELIVERY_QTY']);
					$sheet->setCellValue('W'.$rowNumber, $v['DELIVERY_BW']);
					$sheet->getStyle('A'.$rowNumber.':N'.$rowNumber)->applyFromArray($styleBorder)->getAlignment()->setWrapText(true);
					$sheet->getStyle('O'.$rowNumber.':P'.$rowNumber)->applyFromArray($styleAMT);
					$sheet->getStyle('Q'.$rowNumber.':W'.$rowNumber)->applyFromArray($styleBorder)->getAlignment()->setWrapText(true);

					$rowNumber++;
				}
			}

	    $sheet->getColumnDimension('A')->setAutoSize(true);
	    $sheet->getColumnDimension('B')->setAutoSize(true);
	    $sheet->getColumnDimension('C')->setAutoSize(true);
	    $sheet->getColumnDimension('D')->setAutoSize(true);
	    $sheet->getColumnDimension('E')->setAutoSize(true);
	    $sheet->getColumnDimension('F')->setAutoSize(true);
	    $sheet->getColumnDimension('G')->setAutoSize(true);
	    $sheet->getColumnDimension('H')->setAutoSize(true);
	    $sheet->getColumnDimension('I')->setAutoSize(true);
	    $sheet->getColumnDimension('J')->setAutoSize(true);
	    $sheet->getColumnDimension('K')->setAutoSize(true);
	    $sheet->getColumnDimension('L')->setAutoSize(true);
	    $sheet->getColumnDimension('M')->setAutoSize(true);
	    $sheet->getColumnDimension('N')->setAutoSize(true);
	    $sheet->getColumnDimension('O')->setAutoSize(true);
	    $sheet->getColumnDimension('P')->setAutoSize(true);
	    $sheet->getColumnDimension('Q')->setAutoSize(true);
	    $sheet->getColumnDimension('R')->setAutoSize(true);
	    $sheet->getColumnDimension('S')->setAutoSize(true);
	    $sheet->getColumnDimension('T')->setAutoSize(true);
	    $sheet->getColumnDimension('U')->setAutoSize(true);
	    $sheet->getColumnDimension('V')->setAutoSize(true);
	    $sheet->getColumnDimension('W')->setAutoSize(true);
		$writer = new Xlsx($spreadsheet);
 		$filename = "report-order-salesweb-".strtotime(date('YmdHis'));
		// $writer->save('write2.xlsx'); 
		ob_end_clean();

		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');
		exit();
	}

	public function entry() {

		$user 					= $this->session_data['user'];
		$data['title'] 			= 'BROILER';
		$data['user'] 			= $user;
		// $data['customers']       = $this->datatable_cust();
		$data['projects']       = $this->datatable_project();
		$data['area']			= $this->Dbhelper->selectTabel('HEAD_CODE, CODE, CODE_NAME', 'CD_CODE', array('HEAD_CODE' => 'AE', 'CODE !=' => "*"), 'HEAD_CODE', 'ASC');
		$this->template->_v('confirm/create', $data);
	}

	public function do_create_copy() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			// $postjson = json_encode($post);
			// $textfile = date('YmdHis').'_'.$this->session_data['user']['EMPLOYEE_ID'];
			// if (!write_file(APPPATH."logs/log_$textfile.txt", $postjson)) {
			// 	$this->session->set_flashdata('success', "Unable to logs post");
			// 	return redirect($this->own_link.'/report');
			// }

			$request_no = $this->generateOrderNo();
			try {
				
				// ORDER REQUEST DATA
				$order_request = [
					"COMPANY"				=> "01",
					"REQ_NO"				=> $request_no,
					"REQ_DATE"				=> date('Ymd', strtotime($post['req_date'])),
					"ORDER_CLASS"			=> dbClean($post['order_class']),
					"CUSTOMER"				=> dbClean($post['customer']),
					"CONTROL_NO"			=> dbClean($post['control_no']),
					"REMARKS"				=> dbClean($post['remarks']),
					"STATUS"				=> "N",
					"SEQ"					=> 1,
					"ITEM"					=> dbClean($post['item']),
					"QTY"					=> dbClean($post['qty']),
					"UP"					=> dbClean($post['price']),
					"AMOUNT"				=> dbClean($post['amount']),
					"NOTE"					=> dbClean($post['note']),
					"PLANT"					=> dbClean($post['plant']),
					"PROJECT"				=> dbClean($post['project']),
					"FARM"					=> dbClean($post['farm']),
					"PLAZMA"				=> dbClean($post['plazma']),
					"BW"					=> $post['bw'],
					"CUST_PHONE_NO" 		=> dbClean($post['customer_phone']),
					"REG_EMP"				=> $this->session_data['user']['EMPLOYEE_ID'],
					"REG_DATE"				=> date('Ymd'),
					"MOD_EMP"				=> $this->session_data['user']['EMPLOYEE_ID'],
					"MOD_DATE"				=> date('Ymd'),
					"IMAGE"					=> ""
				];

				if (empty($order_request["REG_EMP"])) {
						$this->session->set_flashdata('error', "User log-in not found");
						return redirect($this->own_link);
				}

				if (!empty($_FILES['image']['name'])) {
					$berkas = $_FILES['image'];
					$namafile = $this->upload_file($berkas, $request_no); 
					if ($namafile) {
						$order_request["IMAGE"] 		= $namafile;
						$order_request["IMAGE_URL"] = 'http://103.209.6.32:8080/broiler/upload/'.$namafile;
					}
				}

				$save = $this->Dbhelper->insertData('TR_SS_ORDER_REQUEST', $order_request);
				
				if ($save) {
					$this->session->set_flashdata('success', "update data success");
					return redirect($this->own_link);
				}
			} catch (Exception $e) {
				dd($e->getMessage());
			}
			$this->session->set_flashdata('error', "update data failed");
			return redirect($this->own_link);
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function do_create() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			try {
				
				$order_request = [
					"COMPANY"					=> "01",
					"REQ_NO"					=> $this->generateOrderNo(),
					"REQ_DATE"				=> date('Ymd'),
					"ORDER_CLASS"			=> '11',
					"CUSTOMER"				=> $post['customer'],
					"REMARKS"					=> $post['remark'],
					"STATUS"					=> "N",
					"CONFIRM_STATUS"	=> "N",
					"SEQ"							=> 1,
					"ITEM"						=> '10001001',
					"REQ_QTY"					=> $post['qty'],
					"REQ_BW"					=> $post['bw'],
					"RANGE_BW"				=> $post['range_bw'],
					"CUST_PHONE_NO" 	=> $post['customer_phone'],
					"REG_DATE"				=> date('Ymd His')
				];
				$save = $this->Dbhelper->insertData('TR_SS_ORDER_REQUEST', $order_request);
				
				if ($save) {
					$this->session->set_flashdata('success', "request order data success");
					return redirect($this->own_link);
				}
			} catch (Exception $e) {
				dd($e->getMessage());
			}
			$this->session->set_flashdata('error', "request order data failed");
			return redirect($this->own_link);
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function direct() {
		$user 					= $this->session_data['user'];
		$data['title'] 			= 'BROILER';
		$data['user'] 			= $user;
		$this->template->_v('confirm/direct', $data);
	}

	public function save()
	{
		if (!$this->input->is_ajax_request()) {
			show_error('No direct script access allowed', 403);
		}

		$employee_id = $this->session_data['user']['EMPLOYEE_ID'];

		$req_no        = $this->input->post('req_no');
		$seq           = $this->input->post('seq');
		$status        = $this->input->post('status'); // 'Y' = approve, 'R' = reject
		$app_level     = $this->input->post('approval_level');
		$note          = $this->input->post('note');

		if (!$req_no || !$note || !$employee_id) {
			echo json_encode([
				'success'        => false,
				'req_no'         => $req_no,
				'approval_level' => $app_level,
				'note'           => $note,
				'employee_id'    => $employee_id
			]);
			return;
		}

		$user_level = $this->session_data['user']['ROLE'];
		$approvalUser = getUserLevel($user_level);

		$current_level = $approvalUser['CODE'];
		$this->db->trans_begin();

		
		// Insert ke TR_SS_ORDER_REQUEST_APPROVAL
		$this->db->insert('TR_SS_ORDER_REQUEST_APPROVAL', [
			'REQ_NO'         => $req_no,
			'SEQ'            => $seq,
			'APPROVAL_LEVEL' => $current_level,
			'APPROVAL'       => $status,
			'REMARKS'        => $note,
			'EMPLOYEE_ID'    => $employee_id,
			'CREATED_AT'     => date('Y-m-d H:i:s')
		]);

		$update_price = [
			'STATUS'	=> 'N',
			'CURRENT_APPROVAL_LEVEL' => $current_level + 1
		];

		if ($status == 'R') {
			$update_price['STATUS'] = 'R';
		}

		// Jika APPROVED, update juga TR_SS_ORDER_REQUEST
		if ($status === 'Y' && $current_level == $app_level) {
			$this->db->where('REQ_NO', $req_no);
			$this->db->update('TR_SS_ORDER_REQUEST', [
				'STATUS' => $status
			]);

			$update_price['STATUS'] = $status;
		}

			// Selalu update status di TR_SS_ORDER_REQUEST_PRICE
			$this->db->where('REQ_NO', $req_no);
			$this->db->update('TR_SS_ORDER_REQUEST_PRICE', $update_price);


		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(['success' => false, 'message' => 'Gagal menyimpan ke database']);
		} else {
			$this->db->trans_commit();
			echo json_encode(['success' => true]);
		}
	}

	public function entry_customer() {

		$user 					= $this->session_data['user'];
		$data['title'] 			= 'BROILER';
		$data['user'] 			= $user;
		// $data['customers']       = $this->datatable_cust();
		$data['projects']       = $this->datatable_project();
		$data['area']				= $this->Dbhelper->selectTabel('HEAD_CODE, CODE, CODE_NAME', 'CD_CODE', array('HEAD_CODE' => 'AE', 'CODE !=' => "*"), 'HEAD_CODE', 'ASC');
		$this->template->_v('confirm/create', $data);
	}

	public function do_create_customer() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			// $postjson = json_encode($post);
			// $textfile = date('YmdHis').'_'.$this->session_data['user']['EMPLOYEE_ID'];
			// if (!write_file(APPPATH."logs/log_$textfile.txt", $postjson)) {
			// 	$this->session->set_flashdata('success', "Unable to logs post");
			// 	return redirect($this->own_link.'/report');
			// }

			$request_no = $this->generateOrderNo();
			try {
				
				// ORDER REQUEST DATA
				$order_request = [
					"COMPANY"				=> "01",
					"REQ_NO"				=> $request_no,
					"REQ_DATE"				=> date('Ymd', strtotime($post['req_date'])),
					"ORDER_CLASS"			=> dbClean($post['order_class']),
					"CUSTOMER"				=> dbClean($post['customer']),
					"CONTROL_NO"			=> dbClean($post['control_no']),
					"REMARKS"				=> dbClean($post['remarks']),
					"STATUS"				=> "N",
					"SEQ"					=> 1,
					"ITEM"					=> dbClean($post['item']),
					"QTY"					=> dbClean($post['qty']),
					"UP"					=> dbClean($post['price']),
					"AMOUNT"				=> dbClean($post['amount']),
					"NOTE"					=> dbClean($post['note']),
					"PLANT"					=> dbClean($post['plant']),
					"PROJECT"				=> dbClean($post['project']),
					"FARM"					=> dbClean($post['farm']),
					"PLAZMA"				=> dbClean($post['plazma']),
					"BW"					=> $post['bw'],
					"CUST_PHONE_NO" 		=> dbClean($post['customer_phone']),
					"REG_EMP"				=> $this->session_data['user']['EMPLOYEE_ID'],
					"REG_DATE"				=> date('Ymd'),
					"MOD_EMP"				=> $this->session_data['user']['EMPLOYEE_ID'],
					"MOD_DATE"				=> date('Ymd'),
					"IMAGE"					=> ""
				];

				if (empty($order_request["REG_EMP"])) {
						$this->session->set_flashdata('error', "User log-in not found");
						return redirect($this->own_link);
				}

				if (!empty($_FILES['image']['name'])) {
					$berkas = $_FILES['image'];
					$namafile = $this->upload_file($berkas, $request_no); 
					if ($namafile) {
						$order_request["IMAGE"] 		= $namafile;
						$order_request["IMAGE_URL"] = 'http://103.209.6.32:8080/broiler/upload/'.$namafile;
					}
				}

				$save = $this->Dbhelper->insertData('TR_SS_ORDER_REQUEST', $order_request);
				
				if ($save) {
					$this->session->set_flashdata('success', "update data success");
					return redirect($this->own_link);
				}
			} catch (Exception $e) {
				dd($e->getMessage());
			}
			$this->session->set_flashdata('error', "update data failed");
			return redirect($this->own_link);
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function detail($order_no) {
		$user	= 	$this->session_data['user'];

		$data_detail = $this->get_orderdetail($order_no);
		$data['title'] 				= 'REQUEST ORDER';
		$data['user'] 				= $user;
		$data['detail']				= $data_detail;
		// dd($data['detail']);
		$this->template->_v('confirm/detail', $data);
	}

	public function generate_pdf($order_no) {
		$data_detail = $this->get_orderdetail($order_no);
	
		$this->load->library('pdf');
		$data['detail'] = $data_detail;
		$html = $this->load->view('admin/order/pdf', $data, TRUE);
		
		$this->dompdf->loadHtml($html);
		
		// Set paper size and orientation
		$this->dompdf->setPaper('A4', 'portrait');
		
		// Enable loading of remote resources
		$this->dompdf->set_option('isRemoteEnabled', TRUE);
		
		// Render the HTML as PDF
		$this->dompdf->render();
		
		// Output the generated PDF (1 = download and 0 = preview)
		$filename = "request_order_" . date("Y-m-d_H:i:s");
		$this->dompdf->stream($filename . ".pdf", array("Attachment" => 0));
	}
	

	public function edit($order_no) {
		$user 							= $this->session_data['user'];

		$data_detail = $this->get_orderdetail($order_no);
		$data['title'] 			= 'REQUEST ORDER';
		$data['detail']				= $data_detail;		
		$data['projects']       = $this->datatable_project();

		// dd($data_detail);
		$employeeID = empty($data_detail['REQUEST_ORDER']['REG_EMP']) ? $user['EMPLOYEE_ID'] : $data_detail['REQUEST_ORDER']['REG_EMP'];
		$query = "
			SELECT
				A.*, B.CODE_NAME
			FROM 
				CD_USER_AREA_OP A,
				CD_CODE B
			WHERE
				B.HEAD_CODE = 'TR20' AND
				A.CODE_AREA = B.CODE AND
				EMPLOYEE_ID = '$employeeID'
		";
		$opArea = $this->Dbhelper->selectRawQuery($query);
		$search_rangeBW = $this->Dbhelper->selectTabelOne('*', 'MT_RANGE_BW', array('RANGE' => trim($data_detail['REQUEST_ORDER']['RANGE_BW'])));

		$op_list = [];
		if (!empty($opArea)) {
			$opList = [];
			foreach ($opArea as $v) {
				$opList[] = $v['CODE_AREA'];
			}
			$opData = $this->db->select('*')->where_in('CODE', $opList)->where('PRICE_DATE', $data_detail['REQUEST_ORDER']['REQ_DATE'])->get('CD_SALES_OPEN_PRICE')->result_array();
			$op_list = $this->mergeAreaOP($search_rangeBW['SEQ'], $opArea, $opData);
		}
		
		$data['open_price_list'] = $op_list;
		$data['approval_list']	= $this->Dbhelper->selectTabel('HEAD_CODE, CODE, CODE_NAME, DESC1 as START, DESC2 as END', 'CD_CODE', array('HEAD_CODE' => 'APR01', 'CODE !=' => '*'));

		$data['sales_request_price'] = $this->Dbhelper->selectTabel('*', 'TR_SS_ORDER_REQUEST_PRICE', array('REQ_NO' => $order_no), 'SEQ', 'DESC');
		$data['price_progress'] = !empty($data['sales_request_price']) ? $data['sales_request_price'][0] : [];
		$data['sales_request_approval'] = $this->get_sales_request_price($order_no);
		// dd($data);
		$this->template->_v('confirm/edit', $data);
	}

	public function mergeAreaOP($sequenceBW, $areaList, $opList) {
		$data = [];
		foreach ($areaList as $area) {
			$curr_data = [
				"CODE"				=> $area['CODE_AREA'],
				"CODE_NAME"		=> $area['CODE_NAME'],
				"PRICE"	=> 0,
			];
			
			$key = array_search($curr_data['CODE'], array_column($opList, 'CODE'));
			if ($key !== null && !empty($opList[$key]) && $opList[$key]['CODE'] == $curr_data['CODE']) {
				$priceJSON = json_decode($opList[$key]['JSON_PRICE'], TRUE);
				$curr_data['PRICE'] = $priceJSON[$sequenceBW]['price'];
			}
			$data[] = $curr_data;
		}
		return $data;
	}

	public function get_sales_request_price($req_no) {
		$query = "
			SELECT
				A.*,
				B.FULL_NAME AS EMP_NAME,
				B.ROLE
			FROM
				TR_SS_ORDER_REQUEST_APPROVAL A,
				CD_USER B
			WHERE
				A.EMPLOYEE_ID = B.EMPLOYEE_ID AND
				A.REQ_NO = '$req_no'
			ORDER BY
				A.APPROVAL_LEVEL ASC
		";
		$result = $this->Dbhelper->selectRawQuery($query);
		return $result;
	}

	public function do_update() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$request_no = $post['req_no'];
			try {
				
				$order_request = [
					"CONTROL_NO"		=> dbClean($post['control_no']),
					"REMARKS"				=> dbClean($post['remarks']),
					"QTY"						=> dbClean($post['qty']),
					"UP"						=> dbClean($post['price']),
					"AMOUNT"				=> dbClean($post['amount']),
					"NOTE"					=> dbClean($post['note']),
					"PLANT"					=> dbClean($post['plant']),
					"PROJECT"				=> dbClean($post['project']),
					"FARM"					=> dbClean($post['farm']),
					"PLAZMA"				=> dbClean($post['plazma']),
					"BW"						=> $post['bw'],
					"CUST_PHONE_NO" => dbClean($post['customer_phone']),
					"REG_EMP"				=> $this->session_data['user']['EMPLOYEE_ID'],
					"MOD_EMP"				=> $this->session_data['user']['EMPLOYEE_ID'],
					"OVERLIMIT_REMARKS"	=> dbClean($post['overlimit_remarks']),
					"MOD_DATE"			=> date('Ymd'),
					'STATUS'				=> 'N'
				];
				if (empty($order_request['QTY']) || empty($order_request['UP']) || empty($order_request['AMOUNT']) || empty($order_request['PROJECT']) || empty($order_request['FARM']) || empty($order_request['PLAZMA']) || empty($order_request['BW'])) {
					$this->session->set_flashdata('error', "Update data failed");
					return redirect($this->own_link.'/edit.'.$request_no);
				}
				

				// dd($post);

				$checkDataOrder = $this->Dbhelper->selectOneRawQuery("SELECT * FROM TR_SS_ORDER_REQUEST WHERE REQ_NO = '$request_no'");
				// JIKA DATA ORDER DATA
				if (!empty($checkDataOrder)) {
					$checkPriceApproved = $this->Dbhelper->selectOneRawQuery("SELECT * FROM TR_SS_ORDER_REQUEST_PRICE WHERE REQ_NO = '$request_no' AND STATUS = 'Y'");
					// JIKA DATA PRICE SUDAH DI APPROVE, MAKA HANYA PROSES PERHITUNGAN QTY, UNIT PRICE, dan AMOUNT saja lalu auto approved (status Y)
					if (!empty($checkPriceApproved)) {
						$order_request = [
							"QTY"						=> dbClean($post['qty']),
							"AMOUNT"				=> dbClean($post['amount']),
							"BW"						=> $post['bw'],
							"MOD_DATE"			=> date('Ymd'),
							'STATUS'				=> 'Y'
						];

						$save = $this->db->update('TR_SS_ORDER_REQUEST', $order_request, array('REQ_NO' => $request_no));
						if ($save) {
							$this->session->set_flashdata('success', "Update data success");
							return redirect($this->own_link);
						}
					}
				}

				if (!empty($_FILES['image']['name'])) {
					$berkas = $_FILES['image'];
					$namafile = $this->upload_file($berkas, $request_no); 
					$delete_file = $this->delete_file($post['image_file_old']);
					if ($namafile) {
						$order_request["IMAGE"] 		= $namafile;
						$order_request["IMAGE_URL"] = 'http://103.209.6.32:8080/broiler/upload/'.$namafile;
					}
				}

				$margin_price = $post['margin_price'];
				$margin_price_where = abs($margin_price);
				if ($margin_price > 0) {
					$margin_price_where = 0;
				}
				$query = "
					SELECT * FROM (
						SELECT HEAD_CODE, CODE, CODE_NAME, DESC1, DESC2 FROM CD_CODE WHERE HEAD_CODE = 'APR01' AND (TO_NUMBER(DESC1) <= $margin_price_where) ORDER BY TO_NUMBER(DESC2) DESC
					) a
					WHERE rownum = 1
				";
				$approval_level = $this->Dbhelper->selectOneRawQuery($query);
				// dd($approval_level, FALSE);
				// dd($query);
				$insert_price = [
					'REQ_NO'	=> $request_no,
					'SEQ'			=> $this->checkRequestPrice($request_no),
					'UNIT_PRICE'	=> $post['price'],
					'APPROVAL_LEVEL' => $approval_level['CODE'],
					'STATUS'	=> 'N',
					'MARGIN_PRICE'	=> $margin_price_where,
					'CREATED_AT'	=> date('Ymd His'),
					'UPDATED_AT'	=> date('Ymd His'),
					'OPEN_PRICE'	=> $post['open_price'],
					'REMARKS'	=> $post['remarks_price'],
					'PRICE_AREA_CODE'	=> $post['price_area_code'],
					'CURRENT_APPROVAL_LEVEL'	=> $approval_level['CODE'] == 1 ? 1 : 2,
				];
				if ($approval_level['CODE'] == 1) {
					$insert_price['STATUS'] = 'Y';
					$order_request['STATUS'] = 'Y';
				}

				$this->db->insert('TR_SS_ORDER_REQUEST_PRICE', $insert_price);
				// dd($post, FALSE);

				$save = $this->db->update('TR_SS_ORDER_REQUEST', $order_request, array('REQ_NO' => $request_no));

				
				if (SEND_WHATSAPP && $order_request['STATUS'] != 'Y') {
					$whatsapp_data = [
						'TYPE'		=> 'APPROVAL_BROILER',
						'REQ_NO'	=> $request_no,
						'SEQ'			=> $insert_price['SEQ']
					];
					notifikasiWhatsapp($whatsapp_data);
				}
				// dd($save);
				if ($save) {
					$this->session->set_flashdata('success', "Update data success");
					return redirect($this->own_link);
				}
			} catch (Exception $e) {
				dd($e->getMessage());
			}
			$this->session->set_flashdata('error', "Update data failed");
			return redirect($this->own_link);
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function do_delete() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$request_no = $post['req_no'];
			try {
				$order_request = [
					"STATUS"				=> "D",
					"MOD_EMP"				=> $this->session_data['user']['EMPLOYEE_ID'],
					"MOD_DATE"			=> date('Ymd')
				];

				$save = $this->db->update('TR_SS_ORDER_REQUEST', $order_request, array('REQ_NO' => $request_no));
				if ($save) {
					$this->session->set_flashdata('success', "Delete data success");
					return redirect($this->own_link);
				}
			} catch (Exception $e) {
				dd($e->getMessage());
			}
			$this->session->set_flashdata('error', "Delete data failed");
			return redirect($this->own_link);
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function do_cancel() {
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$post = $this->input->post();
			$request_no = $post['req_no'];
			try {
				$order_request = [
					"STATUS"				=> "Y",
					"MOD_EMP"				=> $this->session_data['user']['EMPLOYEE_ID'],
					"MOD_DATE"			=> date('Ymd')
				];

				$save = $this->db->update('TR_SS_ORDER_REQUEST', $order_request, array('REQ_NO' => $request_no));
				if ($save) {
					$this->session->set_flashdata('success', "Update data success");
					return redirect($this->own_link);
				}
			} catch (Exception $e) {
				dd($e->getMessage());
			}
			$this->session->set_flashdata('error', "Update data failed");
			return redirect($this->own_link);
		}
		$this->session->set_flashdata('error', "Access denied");
        return redirect($this->own_link);
	}

	public function credit_limit() {
		// $sdate 		= date('Y-m').'-01';
		// $edate 		= date('Y-m-d');
		$customer 		= "*";
		// $status = "*";

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			// $sdate 				= $this->input->post('sdate');
			// $edate 				= $this->input->post('edate');
			$customer 			= $this->input->post('customer');
			// $status 		= $this->input->post('confirm_status');
		}

		$filter = [
			// "sdate"			=> $sdate,
			// "edate"			=> $edate,
			"customer"		=> $customer,
			// "status"		=> $status,
		];
		$data['title'] 				= 'CREDIT LIMIT LIST';
		$data['datatable']			= $this->datatable_creditlimit($filter);
		$data['filter']				= $filter;
		$data['customer'] 			= $this->datatable_cust();
		// dd($data['customer']);
		$this->template->_v('confirm/credit_limit', $data);
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
		$query = "
			SELECT * FROM CD_CUSTOMER WHERE CUST LIKE 'SK%' $customer_area
		";
		$data 				= $this->db->query($query)->result_array();
		return $data;
	}

	private function datatable_approval() {
		$query = "
			SELECT * 
			FROM CD_USER
            WHERE 
                ROLE != 'SUPERADMIN' AND 
				ROLE != 'SALES'

		";
		$data 				= $this->db->query($query)->result_array();
		// dd($data);
		return $data;
	}

  private function datatable_project() {
		$query = "
			select 
				A.*,
				B.PLAZMA_NAME
			from 
				TR_PROJECT A, 
				TR_CD_PLAZMA B
			where nvl(A.closed,'N') ='N'
				AND A.project_date > to_char(sysdate - 150,'yyyymmdd')
				AND UPPER(A.PROJECT_NAME) NOT LIKE '%TEMPORARY%' 
				AND UPPER(A.PROJECT_NAME) NOT LIKE '%DELETE%'
				AND UPPER(A.PROJECT_NAME) NOT LIKE '%JANGAN%'
				AND UPPER(A.PROJECT_NAME) NOT LIKE '%JGN%'
				AND UPPER(A.PROJECT_NAME) NOT LIKE '%DIINPUT%'
				AND A.PLAZMA = B.PLAZMA
			ORDER BY PROJECT DESC
		";
		$data 				= $this->db->query($query)->result_array();
		return $data;
	}

	private function datatable($filter, $user_area) {
		$sdate = date('Ymd', strtotime($filter['sdate']));
		$edate = date('Ymd', strtotime($filter['edate']));
		$customer = $filter['customer'];
		$status = $filter['status'];

		$where = " AND (A.REQ_DATE BETWEEN '$sdate' AND '$edate')";
		if ($customer != '*') {
			$where .= " AND A.CUSTOMER = '$customer'";
		}
		if ($status != '*') {
			$where .= " AND A.CONFIRM_STATUS = '$status'";
		}

		$customer_area = "";
		if (!empty($user_area) && !in_array('*', $user_area)) {
			$customer_area = " AND D.REGION_CODE IN (";
			foreach ($user_area as $i => $v) {
				if ($i > 0) {
					$customer_area .= ", ";
				}
				$customer_area .= "'$v'";
			}
			$customer_area .= ")";
		}
		$where .= " ".$customer_area;
		
		$query = "
			SELECT 
				A.*, B.PLAZMA_NAME, C.FARM_NAME, D.FULL_NAME,
				D.REGION_CODE,
				(CASE NVL(A.STATUS,'N') 
          WHEN 'N' THEN 'REQUESTED'
          WHEN 'Y' THEN 'ORDERED'
          WHEN 'C' THEN 'CANCELED'
         END) STATUS,
        (CASE NVL(A.CONFIRM_STATUS,'N')  
          WHEN 'N' THEN 'NOT CONFIRM'
          WHEN 'P' THEN 'PENDING'
          WHEN 'Y' THEN 'CONFIRM'
         END) CONFIRM_STATUS,
				 E.FULL_NAME as PIC
			FROM
				TR_SS_ORDER_REQUEST A,
				TR_CD_PLAZMA B, 
				TR_CD_FARM C,
				CD_CUSTOMER D,
				CD_USER E
			WHERE 
				A.PLAZMA 	    = B.PLAZMA (+) AND
				A.FARM 		    = C.FARM (+) AND
				A.CUSTOMER 		= D.CUST AND
				A.REG_EMP 		= E.EMPLOYEE_ID (+) AND
				A.STATUS 			!= 'D'  AND
                A.STATUS             != 'C'
				$where
			ORDER BY A.REQ_NO DESC
		";
		// dd($query);
		// $query = "SELECT * FROM TR_SS_ORDER_REQUEST";
		$data 				= $this->db->query($query)->result_array();
		return $data;
	}

	private function datatable_action($filter, $user_area, $user_customer) {
		$sdate = date('Ymd', strtotime($filter['sdate']));
		$edate = date('Ymd', strtotime($filter['edate']));
		$customer = $filter['customer'];

		$where = " AND (A.REQ_DATE BETWEEN '$sdate' AND '$edate')";
		if ($customer != '*') {
			$where .= " AND A.CUSTOMER = '$customer'";
		}
		
		$customer_area = "";
		if (!empty($user_area) && !in_array('*', $user_area) && empty($user_customer)) {
			$customer_area = " AND D.REGION_CODE IN (";
			foreach ($user_area as $i => $v) {
				if ($i > 0) {
					$customer_area .= ", ";
				}
				$customer_area .= "'$v'";
			}
			$customer_area .= ")";
		}
		$customer_data = "";
		if (!empty($user_customer) && !in_array('*', $user_customer)) {
			$customer_data = " AND D.CUST IN (";
			foreach ($user_customer as $i => $v) {
				if ($i > 0) {
					$customer_data .= ", ";
				}
				$customer_data .= "'$v'";
			}
			$customer_data .= ")";
		}
		$where .= " ".$customer_area;
		$where .= " ".$customer_data;
		$query = "
		SELECT 
				A.*, B.PLAZMA_NAME, C.FARM_NAME, D.FULL_NAME,
				(CASE NVL(A.STATUS,'N') 
          WHEN 'N' THEN 'REQUESTED'
          WHEN 'Y' THEN 'ORDERED'
          WHEN 'C' THEN 'CANCELED'
         END) STATUS,
        (CASE NVL(A.CONFIRM_STATUS,'N')  
          WHEN 'N' THEN 'NOT CONFIRM'
          WHEN 'P' THEN 'PENDING'
          WHEN 'Y' THEN 'CONFIRM'
         END) CONFIRM_STATUS
			FROM
				TR_SS_ORDER_REQUEST A,
				TR_CD_PLAZMA B, 
				TR_CD_FARM C,
				CD_CUSTOMER D
			WHERE 
				A.PLAZMA 	    = B.PLAZMA (+) AND
				A.FARM 		    = C.FARM (+) AND
				A.CUSTOMER 		= TRIM(D.CUST) AND
				(A.CONFIRM_STATUS IS NULL OR A.CONFIRM_STATUS = 'N') AND
				A.STATUS = 'N'
				$where
			ORDER BY A.REQ_NO DESC
		";
		// dd($query);
		// $query = "SELECT * FROM TR_SS_ORDER_REQUEST";
		$data 				= $this->db->query($query)->result_array();
		return $data;
	}

	private function get_orderdetail($order_no) {
		$query = "
			SELECT ROWNUM,
				C.COMPANY,
				C.ORDER_NO,
				C.ORDER_DATE,
				C.CUSTOMER,
				FULL_NAME,
				ADDRESS1 || '' || ADDRESS2 AS ADDRESS,
				TELEPHONE_NO || '/' ||MOBILE_PHONE PHONE,
				FAX_NO,
				SUJA.FN_ITEM_NAME('L',C.ITEM) ITEM_NAME,
				SUM(C.QTY) QTY, 
				SUM(C.BW) BW, 
				C.PLANT,
				FN_CODE_NAME('AA',C.COMPANY)               AS COMPANY_NAME,
				FN_CODE_NAME('TR20',C.PLANT)                 AS PLANT_NAME,
				C.NOTE ,
				C.FARM,
				SUJA.FN_TR_FARM_NAME('01',C.PLAZMA,C.FARM)  AS FARM_NAME, 
				SUJA.FN_TR_FARM_address('01',C.PLAZMA,C.FARM) AS FARM_ADDRESS,
				C.PLAZMA,
				C.REMARKS,
				B.REGION_CODE
			FROM SUJA.CD_CUSTOMER    B,
				TR_SS_ORDER_REQUEST    C
			WHERE C.CUSTOMER    = B.CUST
			AND C.COMPANY     = '01'
			AND C.REQ_NO    = '$order_no'  
			GROUP BY ROWNUM, C.COMPANY, C.ORDER_NO, C.ORDER_DATE, C.CUSTOMER,  C.ITEM, C.PLANT, 
					FULL_NAME, ADDRESS1, ADDRESS2, TELEPHONE_NO, MOBILE_PHONE, FAX_NO,  C.NOTE, C.FARM, C.PLAZMA, C.REMARKS, B.REGION_CODE
		";
		$query2 = "select 
				A.*,
                B.PLAZMA_NAME,
				C.FARM_NAME,
                D.FULL_NAME,
				D.REGION_CODE,
				FN_CODE_NAME('AE',D.REGION_CODE)                 AS AREA_NAME,
				
                F.TM_NAME as TEAM_NAME
			FROM
                TR_SS_ORDER_REQUEST A,
                TR_CD_PLAZMA B, 
                TR_CD_FARM C,
                CD_CUSTOMER D,
                TR_PROJECT E,
                SUJA.TR_TEAM F
			where 
                A.PLAZMA 	    = B.PLAZMA (+) AND
				A.FARM 		    = C.FARM (+) AND
                A.CUSTOMER 		= TRIM(D.CUST) AND
                (A.PROJECT = E.PROJECT (+) AND E.CD_TEAM = F.CD_TEAM (+)) AND
				A.REQ_NO = '$order_no'
			ORDER BY REQ_NO DESC";
		// dd($query);
		$data['REQUEST_ORDER'] = $this->Dbhelper->selectOneRawQuery($query2);
		$data['ORDER'] 		= $this->Dbhelper->selectOneRawQuery($query);
		// dd($query2);
		// $data 				= $this->db->query($query)->result_array();
		return $data;
	}

	private function generateOrderNo() {
			$generated_no = date('Ymd')."RQ";
			$no = 1;
			$today = date('Ymd');
			$this->db->select('REQ_NO, REG_DATE');
			$this->db->from('TR_SS_ORDER_REQUEST');
			$this->db->like('REG_DATE', $today, 'after');
			$this->db->order_by('REG_DATE', 'DESC');
			$this->db->order_by('REQ_NO', 'DESC');
			$latest_data = $this->db->get()->row();
			if (!empty($latest_data)) {
					$no = substr($latest_data->REQ_NO, -4);
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

	private function checkRequestPrice($request_no) {
		$no = 1;
		$table = $this->Dbhelper->selectTabelOne('SEQ', 'TR_SS_ORDER_REQUEST_PRICE', array('REQ_NO' => $request_no), 'SEQ', 'DESC');
		if (!empty($table)) {
			$no = $table['SEQ'] + 1;
		}

		return $no;
	}

	public function upload_file($berkas, $request_no) {
		$result = "";
		if ($berkas["name"] != "") {
			$pathDir 	= "./upload/";
			if (!file_exists($pathDir)) {
					mkdir($pathDir, 0777, true);
			}
			// chmod($pathDir, 777);
			$temp = explode(".", $berkas["name"]);
			$type_file = '.'.end($temp);
			if (trim($berkas['name']) != "") {
				$_FILES["files"] = $berkas;
				$stringRandom = random_char(5);
				$nama = $request_no.$type_file;
				$config['upload_path']          = $pathDir;
				$config['allowed_types']        = 'gif|jpg|png|jpeg';

				$config['file_name'] = $nama;
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('files')) {
						// $result = array('error' => $this->upload->display_errors()); 
				} else {
						$result = $nama;
				}
			}
		}

		return $result;
	}

	private function delete_file($filename) {
		$path_to_file = './upload/excel/'.$filename;
		if(unlink($path_to_file)) {
		     return true;
		}
		else {
		     return false;
		}
	}

	private function datatable_creditlimit($filter) {
		// $sdate = date('Ymd', strtotime($filter['sdate']));
		// $edate = date('Ymd', strtotime($filter['edate']));
		$customer = $filter['customer'];
		// $status = $filter['status'];

		// $where = " AND (A.REQ_DATE BETWEEN '$sdate' AND '$edate')";
		$where = "";
		if ($customer != '*') {
			$where .= " AND TRIM(A.CUST) = '$customer'";
		}
		// if ($status != '*') {
		// 	$where .= $status == 'Y' ? " AND A.CONFIRM_STATUS = 'Y'" : " AND A.CONFIRM_STATUS IS NULL";
		// }
		
		$query = "
			SELECT 
				A.*, D.FULL_NAME
			FROM
				TR_SS_REMAINDER A,
				CD_CUSTOMER D
			WHERE 
				TRIM(A.CUST) = TRIM(D.CUST)
				$where
			ORDER BY A.CUST DESC
		";
		// dd($query);
		// $query = "SELECT * FROM TR_SS_ORDER_REQUEST";
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
		// if (!in_array($this->menu_id, $user_access) && !in_array($this->menu_id2, $user_access) && !in_array('*', $user_access)) {
		// 	redirect('dashboard');
		// }

	}
}