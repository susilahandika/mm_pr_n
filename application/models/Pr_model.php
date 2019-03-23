<?php 

class Pr_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function insertPr()
	{
		$data = array(
				'dept'     => 21,
				'deptname' => 'dus'
			);

		$this->db->insert('user.departemen', $data);

	}

}