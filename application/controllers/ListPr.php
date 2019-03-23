<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class ListPr extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array(
				'title' => 'List PR',
				'listpr' => $this->db->query("SELECT a.id_pr, a.tgl_pr, a.deptname, a.secname, a.nama, a.sup_name 
											  FROM prc_rqst.vw_pr a
											  WHERE a.tgl_pr > dateadd(m, -6, getdate() - datepart(d, getdate()) + 1)")->result_array(),
			);

		$this->load->view('listPr_view', $data);
	}
}