<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pandingmamo_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function all($value='')
	{	
		$this->db->join('customer_info', 'customer_info.customer_id = pendingmeno.customar_id');
		$this->db->join('product_info', 'product_info.product_id = pendingmeno.product_id');
		$this->db->order_by('id', 'desc');
		return $this->db->get('pendingmeno')->result();
	}
	

}

/* End of file Pandingmamo_model.php */
/* Location: ./application/models/Pandingmamo_model.php */