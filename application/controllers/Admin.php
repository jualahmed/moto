<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class admin extends MY_controller{

	public function __construct()
	{
    	parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin_model');
		$this->load->library('session');
	}

	public function is_logged_in()
	{
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login');
		}
	}

	public function index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['alltodayinstallment'] = $this->admin_model->alltodayinstallment();
		$data['messsage'] = $this->session->userdata('success');
		$this->__renderview('home', $data);
	}

	public function allsmssend($value='')
	{
		$alltodayinstallment = $this->admin_model->alltodayinstallment();
		foreach ($alltodayinstallment->result() as $key => $value) {
			echo $value->customer_contact_no;
		}
		$this->session->set_flashdata('success', 'Message send successfully');
		redirect('admin','refresh');
	}

	public function singlesmssend($n='')
	{
		$this->session->set_flashdata('success', 'Message send successfully');
		echo $n;
		redirect('admin','refresh');
	}

	public function download_database(){
		$temp = $this->admin_model->backup_database();
		echo json_encode($temp);
	}
}
