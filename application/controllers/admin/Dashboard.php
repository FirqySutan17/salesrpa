<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	var $session_data = "";
	public function __Construct() {
		parent::__construct();
		$this->cekLogin();
		$this->session_data = $this->session->userdata('user_dashboard');
	}

	public function index() {
		
		$data['title'] 				= 'DASHBOARD';
		$data['user']				= $this->session_data['user'];

		
		// $user_level = $this->session_data['user']['ROLE'];
		// $approvalUser = getUserLevel($user_level);
		// if (!empty($approvalUser)) {
		// 	$data['request'] 			= $this->datatable();
		// 	$data['history'] 			= $this->history();
		// }

		// dd($data);

		$this->template->_v('index', $data);
	}

	private function datatable() {
		$user_level 	= $this->session_data['user']['ROLE'];
		$approvalUser = getUserLevel($user_level);
		$userLevel 		= $approvalUser['CODE'];
		$employeeID 	= $this->session_data['user']['EMPLOYEE_ID'];
		// $salesList 		= getSalesID($userLevel, $this->session_data['user']['EMPLOYEE_ID'], 'AS_QUERY');

		$addWhere = "";
		if ($userLevel == 2) {
			$addWhere = "
				AND B.REG_EMP IN (
					SELECT EMPLOYEE_APPROVAL_ID FROM CD_SALES_APPROVAL WHERE EMPLOYEE_ID = '$employeeID'
				)
			";
		} elseif ($userLevel > 2) {
			$previousUserLevel = $userLevel - 1;
			$addWhere = "
				AND F.EMPLOYEE_ID IN (
					SELECT EMPLOYEE_APPROVAL_ID FROM CD_SALES_APPROVAL WHERE EMPLOYEE_ID = '$employeeID'
				) AND F.APPROVAL_LEVEL = '$previousUserLevel'
			";
		}
		$query = "
			select 
				A.*,
				B.*,
				C.FULL_NAME,
        D.FULL_NAME AS SALES_NAME,
				A.REMARKS as REMARKS_PRICE,
				E.CODE_NAME as AREA_NAME,
				A.SEQ as SEQ_NO,
				F.APPROVAL_LEVEL as APR_LEVEL,
				F.REMARKS as APR_REMARKS,
				F.EMPLOYEE_ID as APR_EMPLOYEE_ID
			from 
				TR_SS_ORDER_REQUEST_PRICE A, 
				TR_SS_ORDER_REQUEST B,
				CD_CUSTOMER C,
        CD_USER D,
				CD_CODE E,
        TR_SS_ORDER_REQUEST_APPROVAL F
			where 
				A.STATUS = 'N' AND
				A.REQ_NO = B.REQ_NO AND
				B.CUSTOMER = C.CUST AND
				B.REG_EMP = D.EMPLOYEE_ID AND
				(A.REQ_NO = F.REQ_NO (+) AND A.SEQ = F.SEQ (+)) AND
				(A.PRICE_AREA_CODE = E.CODE AND E.HEAD_CODE = 'TR20') AND
				A.CURRENT_APPROVAL_LEVEL = $userLevel
				$addWhere
			ORDER BY A.CREATED_AT DESC
		";
		// dd($query);
		$data 				= $this->db->query($query)->result_array();
		// dd($data);
		return $data;
	}

	private function history() {
		$employee_id = $this->session_data['user']['EMPLOYEE_ID'];
		$query = "
			SELECT
					E.REQ_NO,
					E.SEQ as SEQ_NO,
					E.APPROVAL_LEVEL,
					E.APPROVAL,
					E.CREATED_AT,
					A.STATUS as STATUS_PRICE,
					A.UNIT_PRICE,
					A.MARGIN_PRICE,
					A.OPEN_PRICE,
					B.BW,
					B.QTY,
					C.FULL_NAME
			FROM
					TR_SS_ORDER_REQUEST_APPROVAL E,
					TR_SS_ORDER_REQUEST_PRICE A,
					TR_SS_ORDER_REQUEST B,
					CD_CUSTOMER C
			WHERE
				E.EMPLOYEE_ID = '$employee_id' AND
				E.REQ_NO = A.REQ_NO AND E.SEQ = A.SEQ AND
				E.REQ_NO = B.REQ_NO AND
				B.CUSTOMER = C.CUST
			ORDER BY E.CREATED_AT DESC
		";
		// dd($query);
		$data 				= $this->db->query($query)->result_array();
		// dd($data);
		return $data;
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
			'CREATED_AT'     => date('Ymd His')
		]);

		$update_price = [
			'STATUS'	=> 'N',
			'CURRENT_APPROVAL_LEVEL' => $current_level + 1
		];

		if ($status == 'R') {
			$update_price['STATUS'] = 'R';
		}
		// dd($update_price);

		// Jika APPROVED, update juga TR_SS_ORDER_REQUEST
		if ($status === 'Y' && $current_level == $app_level) {
			// dd($current_level, FALSE);
			// dd($app_level);
			$this->db->where('REQ_NO', $req_no);
			$this->db->update('TR_SS_ORDER_REQUEST', [
				'STATUS' => $status
			]);

			$update_price['STATUS'] = $status;
		}

		

			// Selalu update status di TR_SS_ORDER_REQUEST_PRICE
			$this->db->where('REQ_NO', $req_no);
			$this->db->where('SEQ', $seq);
			$this->db->update('TR_SS_ORDER_REQUEST_PRICE', $update_price);

			

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(['success' => false, 'message' => 'Gagal menyimpan ke database']);
		} else {
			$this->db->trans_commit();
			if (SEND_WHATSAPP) {
				$whatsapp_data = [
					'TYPE'		=> 'APPROVAL_BROILER',
					'REQ_NO'	=> $req_no,
					'SEQ'			=> $seq
				];
				// dd($whatsapp_data);
				notifikasiWhatsapp($whatsapp_data);
			}
			echo json_encode(['success' => true]);
		}
	}

	public function get_approval_history()
	{
		if (!$this->input->is_ajax_request()) {
			show_error('No direct script access allowed', 403);
		}

		$req_no = $this->input->post('req_no');
		$seq = $this->input->post('seq');

		if (!$req_no) {
			echo json_encode(['success' => false, 'message' => 'REQ_NO is required']);
			return;
		}

		$query = "
			SELECT 
				E.REQ_NO,
				E.SEQ,
				E.APPROVAL_LEVEL,
				E.APPROVAL,
				E.REMARKS,
				E.EMPLOYEE_ID,
				B.FULL_NAME AS EMPLOYEE_NAME
			FROM 
				TR_SS_ORDER_REQUEST_APPROVAL E,
				TR_SS_ORDER_REQUEST_PRICE A,
				CD_USER B
			WHERE
				A.REQ_NO = E.REQ_NO AND
				A.SEQ = E.SEQ AND
				E.EMPLOYEE_ID = B.EMPLOYEE_ID AND
				A.STATUS = 'N' AND
				E.REQ_NO = '$req_no' AND
				E.SEQ = '$seq'
			ORDER BY 
				E.APPROVAL_LEVEL ASC
		";

		$result = $this->db->query($query, [$req_no])->result_array();

		echo json_encode([
			'success' => true,
			'history' => $result
		]);
	}

    private function _getNextSeq($req_no) {
        $this->db->select_max('SEQ');
        $this->db->where('REQ_NO', $req_no);
        $query = $this->db->get('TR_SS_ORDER_REQUEST_APPROVAL');
        $row = $query->row();

        return $row ? ($row->SEQ + 1) : 1;
    }


	private function cekLogin() {
		$session = $this->session->userdata('user_dashboard');
		if (empty($session)) {
			redirect('login_dashboard');
		}
	}
}
