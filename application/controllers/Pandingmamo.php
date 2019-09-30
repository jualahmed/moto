<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pandingmamo extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->load->model('product_model');
		$this->load->model('customer_model');
		$this->load->model('pandingmamo_model');
		$this->load->library('bangla_ntw');
	}

	public function index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['sale_status'] = '';
		$data['alarming_level'] = FALSE;
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['product'] = $this->product_model->all();
		$data['customer'] = $this->customer_model->all();
		$data['pandingmamo'] = $this->pandingmamo_model->all();
		$data['vuejscomp'] = 'pandingmamo.js';
		$this->__renderview('Setup/pandingmamo',$data);
	}

	public function create($value='')
	{
		$product_id=$this->input->post('product_id');
		$customer_id=$this->input->post('customer_id');
		$amount=$this->input->post('amount');
		$arrayName = array(
			'product_id' =>$product_id ,
			'customar_id' =>$customer_id ,
			'amount' =>$amount 
		);
		$this->db->insert('pendingmeno', $arrayName);
		redirect('pandingmamo/index','refresh');
	}

	public function printpandingmamo($id='')
	{
		$this->db->join('customer_info', 'customer_info.customer_id = pendingmeno.customar_id');
		$this->db->join('product_info', 'product_info.product_id = pendingmeno.product_id');
		$this->db->where('id', $id);
		$data['single']=$this->db->get('pendingmeno')->row();
		$this->load->view('Prints/printpandingmamo',$data);
	}

}

/* End of file Pandingmamo.php */
/* Location: ./application/controllers/Pandingmamo.php */