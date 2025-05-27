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

  	public function index() {
		$data['title'] 				= 'DAILY SALES RPA';

		$this->template->_v('sales/index', $data);
	}

	public function create_plan() {
		$data['title'] 				= 'DAILY SALES RPA';
		$data['user']				= $this->session_data['user'];

		$this->template->_v('sales/create-plan', $data);
	}

	public function index_actual() {
		$data['title'] 				= 'DAILY SALES RPA';
		$data['user']				= $this->session_data['user'];

		$this->template->_v('sales/index-actual', $data);
	}

	public function edit_plan() {
		$data['title'] 				= 'DAILY SALES RPA';
		$data['user']				= $this->session_data['user'];

		$this->template->_v('sales/edit', $data);
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