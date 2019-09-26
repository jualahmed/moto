<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Registration extends MY_controller{
		
	public function __construct()
	{
		parent::__construct();
		$data['user_type'] = $this->tank_auth->get_usertype();
		$this->ci =& get_instance();
	}

	function transfer_employee()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'user_modification_form_view';
			
			$this -> form_validation -> set_rules('selected_user', ' ', 'xss_clean|required|numeric');
			$this -> form_validation -> set_rules('new_assigned_shop', ' ','required|xss_clean|numeric');
			if($this -> form_validation -> run())
			{
				$this -> registration_model -> transfer_employee(
						$this->form_validation->set_value('selected_user'),
						$this->form_validation->set_value('new_assigned_shop')
					);
				$data['status'] = 'successful';
			}
			
			$data['user_info'] = $this -> registration_model -> all_general_user();
			$data['specific_user'] = $this -> login_model -> specific_user( $this -> uri -> segment(3) );
			
			$data['change_mood'] = $this -> registration_model -> specific_user();
			$query = $this->ci->users->shop_information(FALSE, 0);
			if($query -> num_rows < 1) $temp[ '' ] = 'No Shop is listed Yet!';
			foreach($query -> result() as $field):
				$temp[ $field -> shop_id ] = $field -> shop_name.' ( '.$field -> shop_address .' )';
			endforeach;
			$data['all_shop'] = $temp;
			
			$data['main_content'] = 'transfer_employee_view';
			$data['tricker_content'] = 'tricker_registration_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('Registration/registration/noaccess');
	}
	
	function shop_setup()
	{
		$data['user_type'] = $this -> tank_auth -> get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'Registration', 'shop_setup'))
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_rules('shopName', ' ', 'xss_clean|required');
			$this -> form_validation -> set_rules('shopType', ' ','required|xss_clean');
			$this -> form_validation -> set_rules('shopAddress', ' ','required|xss_clean');
			$this -> form_validation -> set_rules('shopContact', ' ','required|xss_clean');
			if($this -> form_validation -> run())
			{
					$this -> registration_model -> shop_setup(
						$this->form_validation->set_value('shopName'),
						$this->form_validation->set_value('shopType'),
						$this->form_validation->set_value('shopAddress'),
						$this->form_validation->set_value('shopContact')
					);
				$data['status'] = '';
				$data['status'] = 'successful';
				$this->session->set_flashdata('msg1', '<div class="alert alert-success alert-dismissible" style="background:#00a65a;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Success</h4></div>');
				
			}
			else
			{
				$data['status'] = '';
				$data['status'] = 'failed';
				$this->session->set_flashdata('msg2', '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Failed</h4></div>');
			}
			
			//$data['main_content'] = 'shop_setup_view';
			//$data['tricker_content'] = 'tricker_registration_view';
			$this -> load -> view('shop_setup_view', $data);
			//redirect('Registration/shop_setup',$data);
		}
	}
	
	/* User Registration Home */
	function registration()
	{
		$data['sale_status'] = '';
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['access_status'] = $this -> uri -> segment(3);
		$data['alarming_level'] = FALSE;
		$data['main_content'] = 'registration_view';
		$data['tricker_content'] = 'tricker_registration_view';
		$this -> load -> view('include/template', $data);
	}
	
	
	function change_password()
	{
		$data['sale_status'] = '';
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['main_content'] = 'auth/change_password_form';
		$data['tricker_content'] = 'tricker_registration_view';
		$this -> load -> view('include/template', $data);
	}

	function create_service_provider()
	{
		$this -> form_validation -> set_rules('service_provider_name', 'Service Provider Name','required|xss_clean');
		if($this -> form_validation -> run() ==  FALSE)
		{
			echo json_encode(array('mssage'=>'error'));
		}
		else
		{
			$service_provider_name = $this -> input ->post('service_provider_name');
			$exists = $this -> product_model -> redundancy_check('service_provider_info', 'service_provider_name', $service_provider_name);
			if($exists == true)
			{
				echo 'exist';
			}
			else if($this -> registration_model -> create_service_provider())
			{
				echo 'success';
			}
			else
			{
				echo 'error';
			}
		}
	}

	function create_owner()
	{
		$this->form_validation->set_rules('owner_name', 'Owner Name','required|xss_clean');
		if($this->form_validation->run() ==  FALSE)
		{
			echo json_encode(array('mssage'=>'error'));
		}
		else
		{
			$owner_name = $this -> input ->post('owner_name');
			$exists = $this -> product_model -> redundancy_check('owner_info', 'owner_name', $owner_name);
			if($exists == true)
			{
				echo 'exist';
			}
			else if($this -> registration_model -> create_owner())
			{
				echo 'success';
			}
			else
			{
				echo 'error';
			}
		}
	}

	function create_loan_person()
	{
		$this -> form_validation -> set_rules('loan_person_name', 'Loan Person Name','required|xss_clean');
		if($this -> form_validation -> run() ==  FALSE)
		{
			echo json_encode(array('mssage'=>'error'));
		}
		else
		{
			if($this -> registration_model -> create_loan_person())
			{
				echo 'success';
			}
			else
			{
				echo 'error';
			}
		}
	}
	
	/* User Modification */
	function user_modification()
	{
		
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'user_modification_form_view';
			$data['user_info'] = $this -> registration_model -> all_user();
			//if($this -> uri -> segment(3))
			$data['change_mood'] = $this -> registration_model -> specific_user();
			//$data['tricker_content'] = 'tricker_registration_view';
			//$this -> load -> view('include/template', $data);
			$this->__renderview('user_modification_form_view', $data);
		}
		else redirect('Registration/registration/noaccess');
	}

    function update_user()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/	
				
			$this -> form_validation -> set_rules('user_address', 'User Address','required|xss_clean');
			$this -> form_validation -> set_rules('email', 'Phone Number','numeric|required|xss_clean');
			//$this-> form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			//$this-> form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
			$data['alarming_level'] = FALSE;
			$data['errors'] = array();
			$data['status']='';
			
			if ($this->form_validation->run(TRUE)) 
			{
				//$this->tank_auth->change_password_special($this->form_validation->set_value('new_password'), $this->input->post('ch_id'));
				$new_password 	= $this -> input -> post('new_password');
				$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($new_password);
				$this -> registration_model -> update_user($hashed_password,$new_password);
				$data['status'] = 'success';
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['user_info'] = $this -> registration_model -> all_user();
				$data['change_mood'] = $this -> registration_model -> specific_user();
				$this -> load -> view('user_modification_form_view', $data);
				
			}
			else
			{
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				$data['status'] = 'error';
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['user_info'] = $this -> registration_model -> all_user();
				$data['change_mood'] = $this -> registration_model -> specific_user();
				$this -> load -> view('user_modification_form_view', $data);
			}
		}
		else redirect('Registration/registration/noaccess');
	}
	
	/*investor entry*/
	function investor_registration()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['sale_status'] = '';
		/* end of Sale running Status*/
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['alarming_level'] = FALSE;
		//$data['main_content'] = 'investor_registration_form_view';
		//$data['tricker_content'] = 'tricker_account_view';
		$this -> load -> view('investor_registration_form_view', $data);
	}

	function create_investor()
	{
		$this -> form_validation -> set_rules('investor_name', 'Investor Name','required|xss_clean');
		$this -> form_validation -> set_rules('investor_address', 'Investor Address','required|xss_clean');
		$this -> form_validation -> set_rules('investor_contact_no', 'Phone Number','required|xss_clean|numeric');
		//$this -> form_validation -> set_rules('investor_email', 'Investor Email','required|valid_email');
		$this -> form_validation -> set_rules('investor_description', 'Description','max_length[250]|xss_clean');
		if($this -> form_validation -> run() ==  FALSE)
		{
			echo json_encode(array('mssage'=>'error'));
		}
		else
		{
			$investor_name = $this -> input -> post('investor_name');
															    //table_name   ,  field name1, field name2,  element1,  element2 
			$exists = $this -> product_model -> redundancy_check('investor_info', 'investor_name', $investor_name);
			if($exists == true)
			{
				echo 'exist';
			}
			else if($this -> registration_model -> create_investor())
			{
				echo 'success';
			}
			else
			{
				echo 'error';
			}
		}
	}
	
	function employee_salary_setup()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'Registration', 'employee_salary_setup'))
		{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$data['bd_date'] = date ('Y-m-d');
		$data['sale_status'] = '';
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['access_status'] = '';
		$data['status'] = '';
		
		
		$this->form_validation->set_rules('selectedUserId', ' ', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('salaryAmount', ' ', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('extraPayment', ' ', 'trim|xss_clean|numeric');
		$this->form_validation->set_rules('reducedAmount', ' ', 'trim|xss_clean|numeric');
		$this->form_validation->set_rules('salaryMonth', ' ', 'trim|xss_clean|required');
		$this->form_validation->set_rules('salaryYear', ' ', 'trim|xss_clean|required|numeric');
		if($this->form_validation->run())
		{
			
			if($this -> registration_model -> employee_salary_setup(
				$this->form_validation->set_value('selectedUserId'),
				$this->form_validation->set_value('salaryAmount'),
				$this->form_validation->set_value('extraPayment'),
				$this->form_validation->set_value('reducedAmount'),
				$this->form_validation->set_value('salaryMonth'),
				$this->form_validation->set_value('salaryYear')
			   ))
				$data['status'] = 'successful';
			else $data['status'] = 'error';
		}
		
		$query = $this -> registration_model -> userInformation(FALSE, 0);
		$all_employee[''] = 'Select An Employee';
		foreach($query -> result() as $field):
			$all_employee[ base_url().'Registration/employee_salary_setup/'.$field -> id] = $field -> username.' ( '.$field -> user_full_name.' )';
		endforeach;
		$data['user_info'] = $all_employee;
		
		$data['specific_user'] = $this -> registration_model -> userInformation( TRUE, $this -> uri -> segment(3) );
		
		$prev_date = date("d",strtotime(date("Y-m-d", strtotime($data['bd_date'])) . " -1 year"));
		$prev_month = date("m",strtotime(date("Y-m-d", strtotime($data['bd_date'])) . " -1 year"));
		$prev_year = date("Y",strtotime(date("Y-m-d", strtotime($data['bd_date'])) . " -1 year"));
		$temp_date = date("Y-m-d",strtotime($prev_year.'-'.$prev_month.'-'.$prev_date));
		
		$data['specific_user_salary'] = $this -> registration_model -> userSalaryInformation(TRUE, $this -> uri -> segment(3), TRUE, $temp_date, $data['bd_date']);
		$data['alarming_level'] = FALSE;
		
		//$data['main_content'] = 'employee_salary_setup_view';
		//$data['tricker_content'] = 'tricker_registration_view';
		//$this -> load -> view('include/template', $data);
		$this -> load -> view('employee_salary_setup_view', $data);
		}
		else redirect('Registration/registration/noaccess');
	}
}
