<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oldsale extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('sale_model');
		$this->load->model('config_model');
		$this->load->model('bankcard_model');
		$this->load->library('bangla_ntw');
		$this->load->model('company_model');
		$this->load->model('category_model');
		$this->load->model('unit_model');
		$this->load->model('product_model');
	}
	
	public function is_logged_in()
	{
		$this->load->library('tank_auth');
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login','refresh');
		}
	}

	public function index()
	{	
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
	    $data['card_info'] 	= $this->bankcard_model->allcard();
	    $data['company'] = $this->company_model->all();
		$data['catagory'] = $this->category_model->all();
		$data['unit'] = $this->unit_model->all();
		$data['product_specification'] = $this->product_model->product_specification();
		$data['last_id'] = $this->product_model->getLastInserted();
		$data['vuejscomp'] = 'old_sale.js';
		$this->__renderview('Sale/old_sale',$data);	
	}
}

/* End of file Oldsale.php */
/* Location: ./application/controllers/Oldsale.php */