<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
	public function index()
	{
		$this->load->view('json_view');
	}

	public function listpr()
	{
		$list = array();
		$listdata = array();

		$hasil = $this->db->query("SELECT a.id_pr, a.tgl_pr, a.deptname, a.secname, a.nama, a.sup_name, a.tgl_prs_bm 
						  FROM prc_rqst.vw_pr a
						  WHERE a.tgl_pr > dateadd(m, -1, getdate() - datepart(d, getdate()) + 1)")->result_array();

		foreach ($hasil as $value) {
			$a = array();
			$a[] = $value['id_pr'];
			$a[] = $value['tgl_pr'];
			$a[] = $value['deptname'];
			$a[] = $value['secname'];
			$a[] = $value['nama'];
			$a[] = $value['sup_name'];
			$a[] = $value['tgl_prs_bm'];

			$list[] = $a;
		}

		/*echo "<pre>";
		print_r(json_encode($list));
		echo "</pre>";*/

		$listdata['data'] = $list;

		echo json_encode($listdata);
	}
}