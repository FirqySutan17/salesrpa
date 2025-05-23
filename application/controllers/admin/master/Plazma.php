<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Plazma extends CI_Controller {
	var $menu_id = "";
	var $session_data = "";
	public function __Construct() {
		parent::__construct();
		$this->menu_id = 'M004';
		$this->session_data = $this->session->userdata('user_dashboard');

		$this->cekLogin();
		$this->own_link = admin_url('master/plazma');
	}

	public function index() {

		$data['title'] 			= 'DATA PLAZMA';
		$data['user']				= $this->session_data['user'];
		$data['datatable']	= $this->datatable();
		$this->template->_v('master/plazma/index', $data);
	}

	private function datatable() {
		$query = "
			SELECT
				PLAZMA, PLAZMA_NAME, ADDRESS, OWNER, PHONE, PLANT, FN_CODE_NAME('CS02', PLANT) as PLANT_NAME
			FROM TR_CD_PLAZMA
			ORDER BY PLAZMA ASC
		";
		$data = $this->db->query($query)->result_array();
		return $data;
	}

	// CHANGE NECESSARY POINT
	private function cekLogin() {
		$session = $this->session_data;
		if (empty($session)) {
			redirect('login_dashboard');
		}

		$user_access = $session['user_access'];
		if (!in_array($this->menu_id, $user_access) && !in_array('*', $user_access)) {
			redirect('dashboard');
		}
	}
}

