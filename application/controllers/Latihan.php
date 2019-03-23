<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Latihan extends CI_Controller {

	public function index()
	{

		$data = array(
				'title'    => 'PR Application',
				'dept'     => $this->getDept(),
				'supplier' => array('', 'supp1', 'supp2', 'supp3'),
				'tanggal'  => date('Y-m-d'),
				'item' => $this->db->query("SELECT item_no, item_name FROM prc_rqst.item_req")->result_array(),
		);

		$this->load->helper('form');
		$this->load->view('select', $data);
	}

	public function getDept()
	{
		$getdept = $this->db->query('SELECT * FROM [user].departemen')->result_array();

		foreach ($getdept as $value) {
			$key[] = $value['dept'];
			$values[] = $value['deptname'];
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

	public function param()
	{
		$db = $this->db->query('SELECT * FROM [user].departemen')->result_array();

		echo "<pre>";
		print_r($this->combine($db));
		echo "</pre>";
	}

	public function getSatuan()
	{
		echo "<option></option>";
		echo "<option>asd</option>";
		echo "<option>asd</option>";
		echo "<option>asd</option>";
	}

	public function submit_pr()
	{

		$this->load->library('form_validation');
		$this->load->helper('file');

		if($this->input->post('simpan_pr')){

			$dtl_item = $this->input->post('hd_dtl_item');

			// Mengambli detail PR
			for($a=0; $a<count($dtl_item); $a++){
				echo "Data " . $dtl_item[$a] . "<br>";
			}

			// Upload File
			/*$fileUpload = $_FILES['file_upload'];
			$this->uploadFile($fileUpload);*/

		}
	}

	public function uploadFile($fileUpload)
	{
		$number_of_files = sizeof($fileUpload['tmp_name']);
		$files = $fileUpload;

		$config['upload_path'] = './assets/file/';
		$config['allowed_types'] = 'jpg|png|jpeg|pdf';
		$config['max_size'] = '512';
		$config['file_name'] = trim(str_replace(' ', '', date('dmYHis')));

		for($i=0; $i<$number_of_files; $i++){
			$_FILES['file_upload']['name'] = $files['name'][$i];
			$_FILES['file_upload']['type'] = $files['type'][$i];
			$_FILES['file_upload']['tmp_name'] = $files['tmp_name'][$i];
			$_FILES['file_upload']['error'] = $files['error'][$i];
			$_FILES['file_upload']['size'] = $files['size'][$i];
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('file_upload')){
				echo $this->upload->display_errors();
			} else{
				echo "Sukses";
			}
		}
	}
}
