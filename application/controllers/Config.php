<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('config_model');
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
		$data['sale_status'] = '';
		$data['alarming_level'] = FALSE;
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'config.js';
		$this->__renderview('Setup/config',$data);
	}
	
	public function all()
	{
		$data=$this->config_model->all();
		echo json_encode($data);
	}

	public function find()
	{	
		$id=$this->input->post('id');
		$data=$this->config_model->find($id);
		echo json_encode($data);
	}

	public function update()
	{
    	$id=$this->input->post('id');
	    $data = array(
	        'rate' => $this->input->post('rate'),
	        'freemonth' => $this->input->post('freemonth'),
	        'pardayrate' => $this->input->post('pardayrate'),
	    );
	    $id = $this->config_model->update($id,$data);
	    echo json_encode('success');
	}

}

/* End of file Config.php */
/* Location: ./application/controllers/Config.php */