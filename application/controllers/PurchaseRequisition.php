<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseRequisition extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		
		if (!isset($this->session->iduser)) {
			$this->session->iduser = $this->input->get('id');
		}
	}

	public function index()
	{
		$this->cekSession();

		$data = array(
				'title' 	=> 'List PR',
				'dept' 		=> $this->combineArray('SELECT dept, deptname FROM [user].departemen', 'dept', 'deptname'),
				'section' 	=> $this->combineArray('SELECT idsec, secname FROM [user].sec_usr', 'idsec', 'secname'),
				'user' 		=> $this->combineArray('SELECT idusr, nama FROM [user].usrlogin WHERE idrule = 1', 'idusr', 'nama'),
			);

		$this->load->view('listPr_view', $data);
	}

	public function cekSession()
	{
		if (!isset($this->session->iduser)) {
			header('Location: http://svmm014/mm_pr');
		}
	}

	public function listpr()
	{
		$list = array();
		$listdata = array();
		$idpr = $this->input->post('idpr');

		$date = $this->getMaxDatePr();

		$draw=$_REQUEST['draw'];

		/*Jumlah baris yang akan ditampilkan pada setiap page*/
		$length=$_REQUEST['length'];

		/*Offset yang akan digunakan untuk memberitahu database
		dari baris mana data yang harus ditampilkan untuk masing masing page
		*/
		$start=$_REQUEST['start'];

		/*Keyword yang diketikan oleh user pada field pencarian*/

		if($idpr){
			$hasil = $this->db->query("SELECT a.id_pr, a.tgl_pr, a.deptname, a.secname, a.nama, a.sup_name, a.tgl_prs_bm
										FROM (
											SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_pr DESC) as row
											FROM prc_rqst.vw_pr
											WHERE id_pr like '%$idpr%') a
										WHERE row > " . $start . " and row <= " . ($start+$length) . "
										AND a.id_pr like '%$idpr%'")->result_array();

			$totalpr = $this->db->query("SELECT COUNT(id_pr) AS total_pr
											FROM prc_rqst.pr
											WHERE id_pr like '%$idpr%'")->result_array();
		} else{
			$hasil = $this->db->query("SELECT a.id_pr, a.tgl_pr, a.deptname, a.secname, a.nama, a.sup_name, a.tgl_prs_bm
										FROM (
											SELECT *, ROW_NUMBER() OVER (ORDER BY tgl_pr DESC) as row
											FROM prc_rqst.vw_pr
											WHERE tgl_pr > '$date') a
										WHERE row > " . $start . " and row <= " . ($start+$length) . "
										AND a.tgl_pr > '$date'")->result_array();

			$totalpr = $this->db->query("SELECT COUNT(id_pr) AS total_pr FROM prc_rqst.pr WHERE tgl_pr > '$date'")->result_array();
		}

		$total = count($hasil);

		foreach ($hasil as $value) {
			$a = array();
			$a[] = '<a href="' . base_url() . 'purchaseRequisition/detailPr/' . $value['id_pr'] . '" title="">' . $value['id_pr'] . '</a>';
			$a[] = $value['tgl_pr'];
			$a[] = $value['deptname'];
			$a[] = $value['secname'];
			$a[] = $value['nama'];
			$a[] = $value['sup_name'];
			$a[] = $value['tgl_prs_bm'];

			$list[] = $a;
		}

		$listdata['draw'] = $draw;
		$listdata['recordsTotal'] = $listdata['recordsFiltered'] = $totalpr[0]['total_pr'];
		$listdata['data'] = $list;

		echo json_encode($listdata);
	}

	public function combineArray($sql, $string1, $string2)
	{
		$key = array('');
		$values = array('');

		$getdept = $this->db->query($sql)->result_array();

		foreach ($getdept as $value) {
			$key[] = $value[$string1];
			$values[] = $value[$string2];
		}

		$x = array_combine($key, $values);

		return $x;
	}

	public function getSupplier()
	{
		$getdept = $this->db->query('SELECT sups, sup_name FROM prc_rqst.supplier')->result_array();

		foreach ($getdept as $value) {
			$key[] = $value['sups'];
			$values[] = $value['sup_name'];
		}

		$x = array_combine($key, $values);

		return $x;
	}

	public function getSection($dept_id)
	{
		$sql = 'SELECT * FROM [user].sec_usr WHERE dept = ' . $dept_id;
		$getsection = $this->db->query($sql)->result_array();

		echo "<option></option>";
		foreach ($getsection as $value) {
			echo '<option value="' . $value['idsec'] . '">' . $value['secname'] . '</option>';
		}
	}

	public function getDeptHead($dept_id)
	{
		$sql = 'SELECT idusr, nama FROM [user].usrlogin WHERE idrule = 2 AND dept = ' . $dept_id;
		$getdepthead = $this->db->query($sql)->result_array();

		echo "<option></option>";
		foreach ($getdepthead as $value) {
			echo '<option value="' . $value['idusr'] . '">' . $value['nama'] . '</option>';
		}
		}

	public function getSatuan()
	{
		$sql = 'SELECT id_satuan, satuan FROM prc_rqst.satuan ORDER BY satuan ASC';
		$getsatuan = $this->db->query($sql)->result_array();

		echo "<option></option>";
		foreach ($getsatuan as $value) {
			echo '<option value="' . $value['satuan'] . '">' . $value['satuan'] . '</option>';
		}
	}

	public function submit_pr()
	{
		$this->cekSession();

		$this->load->library('form_validation');
		$this->load->helper('file');


		if($this->input->post('simpan_pr')){
			$data['error'] = false;

			$this->form_validation->set_rules('txt_dept', 'Departemen column', 'required');
			$this->form_validation->set_rules('txt_section', 'Section column', 'required');
			$this->form_validation->set_rules('txt_dept_head', 'Dept head column', 'required');
			$this->form_validation->set_rules('txt_remark', 'Remark column', 'required');

			$dtl_item = $this->input->post('hd_dtl_item');
			for($a=0; $a<count($dtl_item); $a++){
				$this->form_validation->set_rules('hd_dtl_item[' . $a . ']', 'Item PR-' . ($a+1) . '', 'required');
				$this->form_validation->set_rules('dtl_qty_ord[' . $a . ']', 'Qty PR-' . ($a+1) . '', 'required');
				$this->form_validation->set_rules('dtl_satuan[' . $a . ']', 'Satuan PR-' . ($a+1) . '', 'required');
			}

			$data = array(
				'title'    => 'PR Application',
				'dept'     => $this->combineArray('SELECT dept, deptname FROM [user].departemen', 'dept', 'deptname'),
				'satuan'   => $this->combineArray('SELECT id_satuan, satuan FROM prc_rqst.satuan', 'id_satuan', 'satuan'),
				'section'  => array(''=>''),
				'dept_head'=> array(''=>''),
				'supplier' => '',
				'tanggal'  => date('Y-m-d'),
				'item'     => $this->db->query("SELECT item_no, item_name FROM prc_rqst.item_req")->result_array(),
			);

			if($this->form_validation->run()==false AND !$this->uploadFile($_FILES['file_upload'])){

				$data['section'] = $this->combineArray("SELECT idsec, secname FROM [user].sec_usr WHERE dept = '" . set_value('txt_dept') . "'", 'idsec', 'secname');
				$data['dept_head'] = $this->combineArray("SELECT idusr, nama FROM [user].usrlogin WHERE dept = '" . set_value('txt_dept') . "' AND idrule = 2", 'idusr', 'nama');

				$data['error'] = true;

				$this->load->view('newPr_view', $data);
			} else{

				$this->db->trans_start();
				$this->db->trans_begin();

				$data = array(
						'id_pr'      => 1,
						'dept'       => $this->input->post('txt_dept'),
						'tgl_pr'     => date("m/d/Y h:i:sa"),
						'id_section' => $this->input->post('txt_section'),
						'id_usr'	 => 219202695,
						'sups'       => $this->input->post('txt_supplier'),
						'remark'     => $this->input->post('txt_remark'),
						'dtl_remark' => $this->input->post('txt_dtl_remark'),
						'id_dh2'     => $this->input->post('txt_dept_head'),
						'pmb'        => $this->input->post('txt_pmb'),
					);

				$output = $this->db->query("EXEC prc_rqst.save_pr '" . $data['id_pr'] . "', '" . $data['dept'] . "', '" . $data['tgl_pr'] . "', '" . $data['id_section'] . "', '" . $data['id_usr'] . "', '" . $data['remark'] . "', '" . $data['dtl_remark'] . "', '" . $data['id_dh2'] . "'")->result_array();

				$dtl_item    = $this->input->post('hd_dtl_item');
				$dtl_qty_ord = $this->input->post('dtl_qty_ord');
				$dtl_satuan  = $this->input->post('dtl_satuan');

				// Mengambli detail PR
				for($a=0; $a<count($dtl_item); $a++){
					$dtl = array(
							'id_pr'   => $output[0]['id_pr'],
							'id_item' => '' . $dtl_item[$a],
							'unit'    => $dtl_satuan[$a],
							'qty'     => $dtl_qty_ord[$a],
						);

					$this->db->query("INSERT INTO prc_rqst.dtl_pr (id_pr, id_item, unit, qty) VALUES (" . $dtl['id_pr'] . ", '" . $dtl['id_item'] . "', '" . $dtl['unit'] . "', " . $dtl['qty'] . ")");
				}

				// Upload File
				/*$fileUpload = $_FILES['file_upload'];
				$this->uploadFile($fileUpload);*/

				if ($this->db->trans_status() === FALSE)
				{
				        $this->db->trans_rollback();
				        $this->db->trans_complete();
				}
				else
				{
				        $this->db->trans_commit();
				        $this->db->trans_complete();
				        header("Location:" . base_url() . "PurchaseRequisition");
				}

				// header("Location:" . base_url() . "PurchaseRequisition");
			}
		}
	}

	public function ubahPr()
	{
		$this->cekSession();

		$data = array(
				'id_pr'      => $this->input->post('hd_idpr'),
				'id_usr'	 => $this->session->iduser,
				'sups'       => $this->input->post('txt_supplier'),
				'remark'     => $this->input->post('txt_remark'),
				'dtl_remark' => $this->input->post('txt_dtl_remark'),
				'pmb'        => $this->input->post('txt_pmb'),
			);

		$this->db->trans_start();
		$this->db->trans_begin();

		$this->db->query("update prc_rqst.pr set sups='" . $data['sups'] . "', dtl_remark='" . $data['dtl_remark'] . "', pmb=" . $data['pmb'] . " where id_pr=" . $data['id_pr'] . ";");

		$dtl_item    = $this->input->post('hd_dtl_item');
		$dtl_qty_ord = $this->input->post('dtl_qty_ord');
		$dtl_satuan  = $this->input->post('dtl_satuan');
		$dtl_qty_app = $this->input->post('dtl_qty_app');
		$dtl_harga   = $this->input->post('dtl_harga');
		$dtl_total   = $this->input->post('dtl_total');

		// Mengambli detail PR
		for($a=0; $a<count($dtl_item); $a++){
			$dtl = array(
					'id_pr'       => $data['id_pr'],
					'id_item'     => '' . $dtl_item[$a],
					'unit'        => $dtl_satuan[$a],
					'qty'         => $dtl_qty_ord[$a],
					'dtl_qty_app' => $dtl_qty_app[$a],
					'dtl_harga'   => $dtl_harga[$a],
					'dtl_total'   => $dtl_total[$a],
				);

			// $this->db->query("delete from prc_rqst.dtl_pr where id_pr = " . $dtl['id_pr'] . ";");

			// $this->db->query("INSERT INTO prc_rqst.dtl_pr (id_pr, id_item, unit, qty, qtyApp, harga, total) VALUES (" . $dtl['id_pr'] . ", '" . $dtl['id_item'] . "', '" . $dtl['unit'] . "', " . $dtl['qty'] . ", " . $dtl['dtl_qty_app'] . ", " . $dtl['dtl_harga'] . ", " . $dtl['dtl_total'] . ")");

			$this->db->query("UPDATE prc_rqst.dtl_pr SET id_item = '" . $dtl['id_item'] . "', unit = '" . $dtl['unit'] . "', qty = " . $dtl['qty'] . ", qtyApp = " . $dtl['dtl_qty_app'] . ", harga = " . $dtl['dtl_harga'] . ", total = " . $dtl['dtl_total'] . " WHERE id_pr = '" . $dtl['id_pr'] . "' and id_item = '" . $dtl['id_item'] . "'");
		}

		$this->db->query("insert into prc_rqst.log_update_pr values (". $data['id_pr'] .", " . $data['id_usr'] . ", '" . date("m/d/Y h:i:sa") . "');");

		if ($this->db->trans_status() === FALSE)
		{
				$this->db->trans_rollback();
				echo "Gagal update data";
		}
		else
		{
				$this->db->trans_commit();
				echo "Sukses";
				// header("Location:" . base_url() . "PurchaseRequisition");
		}

		$this->db->trans_complete();

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		header("Location:" . base_url() . "PurchaseRequisition/detailPr/" . $dtl['id_pr']);
		
	}

	public function uploadFile($fileUpload)
	{
		$this->load->library('upload');

		$number_of_files = sizeof($fileUpload['name']);
		$files = $fileUpload;
		$errormsg = array();

		for($i=0; $i<$number_of_files; $i++){

			$filename = ( $files['name'][$i] <> '' ? trim(str_replace(' ', '', date('dmY'))) . '_' . str_replace(' ', '_', $files['name'][$i]) : '');

			$config['upload_path'] = './assets/file/';
			$config['allowed_types'] = 'jpg|png|jpeg|pdf';
			$config['max_size'] = '512';
			$config['overwrite'] = true;
			$config['file_name'] = $filename;

			$_FILES['file_upload']['name'] = $filename;
			$_FILES['file_upload']['type'] = $files['type'][$i];
			$_FILES['file_upload']['tmp_name'] = $files['tmp_name'][$i];
			$_FILES['file_upload']['error'] = $files['error'][$i];
			$_FILES['file_upload']['size'] = $files['size'][$i];

			$this->upload->initialize($config);

			if(!$this->upload->do_upload('file_upload')){
				// echo $this->upload->display_errors();
				$errormsg[] = $this->upload->display_errors();
			} else{
				$this->upload->data();
			}
		}

		if(count($errormsg)>0){
			return false;
		} else {
			return true;
		}
	}

	public function newPr()
	{
		$data = array(
				'title'    => 'PR Application',
				'dept'     => $this->combineArray('SELECT dept, deptname FROM [user].departemen', 'dept', 'deptname'),
				'section'  => array('' => ''),
				'dept_head'=> array('' => ''),
				'supplier' => '',
				'tanggal'  => date('Y-m-d'),
				'item'     => $this->db->query("SELECT item_no, item_name FROM prc_rqst.item_req")->result_array(),
			);

		$this->load->view('newPr_view', $data);
	}

	public function detailPr($idPr)
	{
		$this->cekSession();

		$pr_header = $this->db->query("SELECT a.*, b.nama
										FROM prc_rqst.pr a
										INNER JOIN [user].usrlogin b on a.id_dh2 = b.idusr
										WHERE a.id_pr = " . $idPr)->result_array();

		$pr_detail = $this->db->query("SELECT a.id_item, b.item_name, a.qty, a.unit, a.qtyApp, a.harga, a.total
									FROM prc_rqst.dtl_pr a
									INNER JOIN prc_rqst.item_req b ON a.id_item = b.item_no
									WHERE id_pr = " . $idPr)->result_array();

		$remark = array(
			10 => "Rusak",
			11 => "New Store",
			99 => "Lain-lain",
		);

		$pmb = array(
			1 => "Cash",
			2 => "Credit",
		);

		$data = array(
				'title'    => 'PR Application',
				'dept'     => $this->combineArray('SELECT dept, deptname FROM [user].departemen', 'dept', 'deptname'),
				'supplier' => $this->combineArray('SELECT sups, sup_name FROM prc_rqst.supplier', 'sups', 'sup_name'),
				'tanggal'  => date('Y-m-d'),
				'item'     => $this->db->query("SELECT item_no, item_name FROM prc_rqst.item_req")->result_array(),
				'data_pr'  => $pr_header,
				'data_dtl' => $pr_detail,
				'section'  => $this->combineArray('SELECT idsec, secname FROM [user].sec_usr', 'idsec', 'secname'),
				'satuan'   => $this->combineArray('SELECT id_satuan, satuan FROM prc_rqst.satuan ORDER BY satuan ASC', 'satuan', 'satuan'),
				'remark'   => $remark,
				'pmb'  	   => $pmb,
			);

		$this->load->helper('form');
		$this->load->view('detailPr_view', $data);
	}

	public function backPage()
	{
		if(isset($_SERVER['HTTP_REFERER'])){
			header('location:' . $_SERVER['HTTP_REFERER']);
		} else{
			header('location:http://' . $_SERVER['HTTP_REFERER']);
		}
		exit;
	}

	public function getMaxDatePr()
	{
		$date=date_create(date("Y-m-d"));
		date_add($date,date_interval_create_from_date_string("-3 month"));

		return date_format($date,"Y-m-d");
	}

	public function goBack()
	{
		$referred_from = $this->session->userdata('referred_from');
		redirect($referred_from, 'refresh');
	}
}
