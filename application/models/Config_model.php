<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($data='')
	{
		$this->db->insert('config',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{	$this->db->order_by('id', 'desc');
		return $this->db->get('config')->result();
	}

	public function perdaycost()
	{	$this->db->order_by('id', 'desc');
		return $this->db->get('config')->row();
	}

	public function find($id='')
	{
		$this->db->where('id', $id);
		return $this->db->get('config')->row();
	}

	public function update($id='',$data='')
	{
		$this->db->where('id', $id);
		return $this->db->update('config', $data);
	}

}

/* End of file Config_model.php */
/* Location: ./application/models/Config_model.php */