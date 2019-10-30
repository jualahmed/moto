<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Account extends MY_controller{

	public function __construct()
	{
		parent::__construct();	
		$data['user_type'] = $this->tank_auth->get_usertype();
        if(!$this->access_control_model->my_access($data['user_type'], 'account', ''))
        {
            redirect('admin/noaccess');
        }
		$this->load->model('bankcard_model');
		$this->load->model('customer_model');
		$this->load->model('distributor_model');
	}
	
	public function transactionreport()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'transactionreport.js';
		$this->__renderview('Account/transactionreport',$data);
	}

	// all transaction report
	public function  all_today_transaction()
	{
		$transaction = array();
		$transaction2 = array();
		$transaction3 = array();
		$transaction4 = array();
		$transaction5 = array();
		$transaction6 = array();
		$transaction7 = array();
		$transaction10 = array();
		$transaction11 = array();
		$transaction_sum = array();
		$transaction_sum 	= $this->account_model->all_today_transaction_sum();
		$transaction_sum 	= $transaction_sum->result_array();
		$transaction8 		= $this->account_model->today_cashbook();
		$transaction9 		= $this->account_model->today_bankbook();
		foreach($transaction_sum as $field)
		{
			$purpose = $field['transaction_purpose'];
			
			if($purpose=='collection')
			{
				$transaction = $this->account_model->all_today_transaction_collection();
				$transaction = $transaction->result_array();
			}
			else if($purpose=='sale')
			{
				$transaction2 = $this->account_model->all_today_transaction_sale();
				$transaction2 = $transaction2->result_array();
			}
			else if($purpose=='credit_collection')
			{
				$transaction3 = $this->account_model->all_today_transaction_credit_collection();
				$transaction3 = $transaction3->result_array();
			}
			else if($purpose=='purchase')
			{
				$transaction4 = $this->account_model->all_today_transaction_purchase();
				$transaction4 = $transaction4->result_array();
			}
			else if($purpose=='payment')
			{
				$transaction5 = $this->account_model->all_today_transaction_purchase_payment();
				$transaction5 = $transaction5->result_array();
			}
			else if($purpose=='expense')
			{
				$transaction6 = $this->account_model->all_today_transaction_expense();
				$transaction6 = $transaction6->result_array();
			}
			else if($purpose=='expense_payment')
			{
				$transaction7 = $this->account_model->all_today_transaction_expense_payment();
				$transaction7 = $transaction7->result_array();
			}
			else if($purpose=='income')
			{
				$transaction10 = $this->account_model->all_today_transaction_income();
				$transaction10 = $transaction10->result_array();
			}
			else if($purpose=='income_get')
			{
				$transaction11 = $this->account_model->all_today_transaction_expense_get();
				$transaction11 = $transaction11->result_array();
			}
		}
		echo json_encode(array('transaction'=>$transaction,'transaction2'=>$transaction2,'transaction3'=>$transaction3,'transaction4'=>$transaction4,'transaction5'=>$transaction5,'transaction6'=>$transaction6,'transaction7'=>$transaction7,'transaction10'=>$transaction10,'transaction11'=>$transaction11,'transaction_sum'=>$transaction_sum,'transaction8'=>$transaction8,'transaction9'=>$transaction9));
	}

	// download the transaction report
	public function download_todays_transaction()
	{
		$bd_date = date('Y-m-d',time());	
		$credit = array();
		$debit = array();	
		$transaction = array();
		$transaction2 = array();
		$transaction3 = array();
		$transaction4 = array();
		$transaction5 = array();
		$transaction6 = array();
		$transaction7 = array();
		$transaction_sum = array();
		$this->data['transaction8'] 		= $this->account_model->today_cashbook_print();
		$this->data['transaction9'] 		= $this->account_model->today_bankbook_print();
		$transaction_sum 	= $this->account_model->all_today_transaction_sum();
		$this->data['transaction_sum'] 	= $transaction_sum->result_array();
		
		foreach($this->data['transaction_sum'] as $field)
		{
			$purpose = $field['transaction_purpose'];
			
			if($purpose=='collection')
			{
				$transaction = $this->account_model->all_today_transaction_collection_print();
				$this->data['transaction'] = $transaction->result_array();
			}
			else if($purpose=='sale')
			{
				$transaction2 = $this->account_model->all_today_transaction_sale_print();
				$this->data['transaction2'] = $transaction2->result_array();
			}
			else if($purpose=='credit_collection')
			{
				$transaction3 = $this->account_model->all_today_transaction_credit_collection_print();
				$this->data['transaction3'] = $transaction3->result_array();
			}
			else if($purpose=='purchase')
			{
				$transaction4 = $this->account_model->all_today_transaction_purchase_print();
				$this->data['transaction4'] = $transaction4->result_array();
			}
			else if($purpose=='payment')
			{
				$transaction5 = $this->account_model->all_today_transaction_purchase_payment_print();
				$this->data['transaction5'] = $transaction5->result_array();
			}
			else if($purpose=='expense')
			{
				$transaction6 = $this->account_model->all_today_transaction_expense_print();
				$this->data['transaction6'] = $transaction6->result_array();
			}
			else if($purpose=='expense_payment')
			{
				$transaction7 = $this->account_model->all_today_transaction_expense_payment_print();
				$this->data['transaction7'] = $transaction7->result_array();
			}
		}
		$this->__renderviewprint('Prints/accountreport/transaction_report',$this->data);
	}
	
	public function bank_transfer()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$data['bd_date'] = date('Y-m-d');
		$data['user_name'] = $this->tank_auth->get_username();
		$data['bank'] = $this->bankcard_model->all();
		$data['vuejscomp'] = 'bank_transfer.js';
		$this->__renderview('Account/bank_transfer', $data);
	}

	public function create_transfer()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$data['bd_date'] = date('Y-m-d');
		$data['user_name'] = $this->tank_auth->get_username();
		$data['bank'] = $this->bankcard_model->all();
		$data['vuejscomp'] = 'bank_transfer.js';
		$transfer_id = $this->account_model->create_transfer();
		if($transfer_id!=''){
			$data['status'] = 'success';
			redirect('account/bank_transfer/success');
		}
		else{
			$data['status'] = 'failed';
			redirect('account/bank_transfer/failed');
		}	
	}

	public function owner_transfer()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$data['owner_info'] = $this->account_model->owner_info();
		$data['bank_info'] = $this->bankcard_model->all();
		$data['vuejscomp'] = 'owner_transfer.js';
		$this->__renderview('Account/owner_transfer', $data);
	}

	public function loan_transfer()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$data['loan_person_info'] = $this->account_model->loan_person_info();
		$data['bank_info'] = $this->bankcard_model->all();
		$data['vuejscomp'] = 'loan_transfer.js';
		$this->__renderview('Account/loan_transfer', $data);
	}

	public function loan_transfer_report()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$data['loan_person_info'] = $this->account_model->loan_person_info();
		$data['vuejscomp'] = 'loan_transfer_report.js';
		$this->__renderview('Account/loan_transfer_report', $data);
	}

	public function ledgers()
	{
		$data['user_name'] = $this->tank_auth->get_username();
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['distributor_info'] = $this->distributor_model->all();				
		$data['customer_info'] = $this->customer_model->all();							
		$data['service_provider_info'] = $this->account_model->service_provider_info();							
		$data['owner_info'] = $this->account_model->owner_info();
		$data['expense_type'] = $this->my_variables_model->fatch_expense_type();
		$data['employee_info'] = $this->my_variables_model->employee_info();			
		$data['status'] = '';
		$data['vuejscomp'] = 'ledgers.js';
		$this->__renderview('Account/ledgers', $data);
	}

	public function all_ledger_report_find()
	{
		$bd_date = date('Y-m-d');
		$cur_bd_date = $bd_date;
		$start =$this->input->post('start');
		$end = $this->input->post('end');
		$distributor_id =$this->input->post('distributor_id');
		$customer_id =$this->input->post('customer_id');
		$type_id =$this->input->post('type_id');
		$employee_id =$this->input->post('employee_id');
		$purpose_id =$this->input->post('purpose_id');
		$transfer_type =$this->input->post('transfer_type');
		$owner_transfer_type =$this->input->post('owner_transfer_type');
		if($start=='')$start = '2018-01-01';
		if($end=='')$end = $cur_bd_date ;
		$new_date = $start;

		if($purpose_id ==1)
		{
			$sale_details = $this->account_model->all_sale($new_date,$end,$customer_id);
			if($sale_details!=FALSE)$ledger_list['total_sale'] = $sale_details->result_array();
			$collection_details = $this->account_model->all_collection($new_date,$end,$customer_id);
			if($collection_details!=FALSE)$ledger_list['total_collection'] = $collection_details->result_array();
			echo json_encode($ledger_list);
		}
		elseif($purpose_id ==2)
		{
			$sale_details = $this->account_model->all_sale($new_date,$end,$customer_id);
			if($sale_details!=FALSE)$ledger_list['total_sale'] = $sale_details->result_array();
			$collection_details = $this->account_model->all_collection($new_date,$end,$customer_id);
			if($sale_details!=FALSE)$ledger_list['total_collection'] = $collection_details->result_array();
			echo json_encode($ledger_list);
		}
	}

	public function ledger_report_print()
	{	
		$bd_date = date('Y-m-d');
		$cur_bd_date = $bd_date;
		$start =$this->uri->segment(7);
		$end = $this->uri->segment(8);
		// $distributor_id =$this->uri->segment(3);
		$customer_id =$this->uri->segment(6);
		// $type_id =$this->uri->segment(3);
		// $employee_id =$this->uri->segment(3);
		$purpose_id =$this->uri->segment(5);
		// $transfer_type =$this->uri->segment(3);
		// $owner_transfer_type =$this->uri->segment(3);
		if($start=='')$start = '2018-01-01';
		if($end=='')$end = $cur_bd_date ;
		$this->__renderviewprint('Prints/accountreport/ledger_report');
	}	

	public function cash_book_report()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'cash_book_report.js';
		$this->__renderview('Account/all_cash_book_report_new', $data);
	}

	public function cheque_status_report()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$data['distributor_info'] = $this->distributor_model->all();	
		$data['service_provider_info'] = $this->account_model->service_provider_info();		
		$data['bank_info'] = $this->bankcard_model->all();	
		$data['vuejscomp'] = 'cheque_status_report.js';
		$this->__renderview('Account/cheque_status_report', $data);
	}
	
	public function credit_collection_receipt()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this->access_control_model->my_access($data['user_type'], 'account', 'purchase_receipt_entry'))
		{
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = FALSE;
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['bank_info'] = $this->bankcard_model->all();
			$data['distributor_info'] = $this->distributor_model->all();
			$data['vuejscomp'] = 'credit_collection_receipt.js';
			$this->__renderview('Account/credit_collection_receipt', $data);
		}
		else redirect('account/account/noaccess');
	}

	public function purchase_payment_receipt()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account', 'purchase_receipt_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = FALSE;
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['bank_info'] = $this->bankcard_model->all();
			$data['distributor_info'] = $this->distributor_model->all();
			$data['vuejscomp'] = 'purchase_payment_receipt.js';
			$this->__renderview('Account/purchase_payment_receipt', $data);
		}
		else redirect('account/account/noaccess');
	}

	public function expense_payment_receipt()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account', 'purchase_receipt_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = FALSE;
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['bank_info'] = $this->bankcard_model->all();
			$data['distributor_info'] = $this->distributor_model->all();
			$data['employee_info'] = $this->my_variables_model->employee_info();
			$data['vuejscomp'] = 'expense_payment_receipt.js';
			$this->__renderview('Account/expense_payment_receipt', $data);
		}
		else redirect('account/account/noaccess');
	}

	public function pay_reci_report()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$data['distributor_info'] = $this->distributor_model->all();
		$data['service_provider_info'] = $this->account_model->service_provider_info();		
		$data['bank_info'] = $this->bankcard_model->all();		
		$data['vuejscomp'] = 'pay_reci_report.js';
		$this->__renderview('Account/pay_reci_report', $data);
	}

	public function get_all_customer()
	{
		$this->db->select('customer_info.customer_id,customer_info.customer_name');
		$this->db->from('customer_info');
		$this->db->order_by('customer_info.customer_id','asc');
		$query = $this->db->get();
		echo json_encode($query->result());
	}
	
	public function get_all_distributor()
	{
		$this->db->select('distributor_info.distributor_id,distributor_info.distributor_name');
		$this->db->from('distributor_info');
		$this->db->order_by('distributor_info.distributor_name','asc');
		$query = $this->db->get();
		echo json_encode($query->result());
	}

	public function get_all_expense_type()
	{
		$this->db->select('*');
		$this->db->from('type_info');
		$this->db->order_by('type_info.type_id','asc');
		$query = $this->db->get();
		echo json_encode($query->result());
	}

	public function get_all_employee()
	{
		$this->db->select('*');
		$this->db->from('employee_info');
		$this->db->order_by('employee_info.employee_id','asc');
		$query = $this->db->get();
		echo json_encode($query->result());
	}

	public function get_all_service_provider()
	{
		$this->db->select('service_provider_info.service_provider_id,service_provider_info.service_provider_name');
		$this->db->from('service_provider_info');
		$this->db->order_by('service_provider_info.service_provider_name','asc');
		$query = $this->db->get();
		echo json_encode($query->result());
	}
	
	public function get_single_customer_all_sale_payment_total()
	{
		$customer_id = $this->input->post('customer_id');
		$ledger_list = array();
		$receipt_sale_total_amount = $this->account_model->receipt_sale_total_amount($customer_id);
		$ledger_list['receipt_sale_total_amount'] = $receipt_sale_total_amount->result_array();
		
		$receipt_collection_total_amount = $this->account_model->receipt_collection_total_amount($customer_id);
		$ledger_list['receipt_collection_total_amount'] = $receipt_collection_total_amount->result_array();
		
		$receipt_delivery_total_amount = $this->account_model->receipt_delivery_total_amount($customer_id);
		$ledger_list['receipt_delivery_total_amount'] = $receipt_delivery_total_amount->result_array();
		
		$receipt_sale_return_total_amount = $this->account_model->receipt_sale_return_total_amount($customer_id);
		$ledger_list['receipt_sale_return_total_amount'] = $receipt_sale_return_total_amount->result_array();
		
		$receipt_cash_return_total_amount = $this->account_model->receipt_cash_return_total_amount($customer_id);
		$ledger_list['receipt_cash_return_total_amount'] = $receipt_cash_return_total_amount->result_array();
		
		$receipt_balance_total_amount_customer = $this->account_model->receipt_balance_total_amount_customer($customer_id);
		$ledger_list['receipt_balance_total_amount'] = $receipt_balance_total_amount_customer->result_array();
		echo json_encode(array("ledger_list"=>$ledger_list));
	}

	function get_single_distributor_all_purchase_payment_total()
	{
		$distributor_id = $this->input->post('distributor_id');
		$ledger_list = array();
		$receipt_purchase_total_amount = $this->account_model->receipt_purchase_total_amount($distributor_id);
		$ledger_list['receipt_purchase_total_amount'] = $receipt_purchase_total_amount->result_array();
		
		$receipt_payment_total_amount = $this->account_model->receipt_payment_total_amount($distributor_id);
		$ledger_list['receipt_payment_total_amount'] = $receipt_payment_total_amount->result_array();
		
		$receipt_purchase_return_total_amount = $this->account_model->receipt_purchase_return_total_amount($distributor_id);
		$ledger_list['receipt_purchase_return_total_amount'] = $receipt_purchase_return_total_amount->result_array();
		
		$receipt_payment_delete_total_amount = $this->account_model->receipt_payment_delete_total_amount($distributor_id);
		$ledger_list['receipt_payment_delete_total_amount'] = $receipt_payment_delete_total_amount->result_array();
		
		$receipt_balance_total_amount_distributor = $this->account_model->receipt_balance_total_amount_distributor($distributor_id);
		$ledger_list['receipt_balance_total_amount'] = $receipt_balance_total_amount_distributor->result_array();
		
		echo json_encode(array("ledger_list"=>$ledger_list));
	}

	function get_single_employee_all_expense_payment_total()
	{
		$employee_id = $this->input->post('employee_id');
		$ledger_list = array();
		$receipt_expense_total_amount_emp_wise = $this->account_model->receipt_expense_total_amount_emp_wise($employee_id);
		$ledger_list['receipt_expense_total_amount'] = $receipt_expense_total_amount_emp_wise->result_array();
		$receipt_expense_delete_total_amount_emp_wise = $this->account_model->receipt_expense_delete_total_amount_emp_wise($employee_id);
		$ledger_list['receipt_expense_delete_total_amount'] = $receipt_expense_delete_total_amount_emp_wise->result_array();
		$receipt_expense_payment_total_amount_emp_wise = $this->account_model->receipt_expense_payment_total_amount_emp_wise($employee_id);
		$ledger_list['receipt_expense_payment_total_amount'] = $receipt_expense_payment_total_amount_emp_wise->result_array();
		
		echo json_encode(array("ledger_list"=>$ledger_list));
	}

	function get_single_expense_type_all_expense_payment_total()
	{
		$expense_type = $this->input->post('expense_type');
		$ledger_list = array();
		$receipt_expense_total_amount_type_wise = $this->account_model->receipt_expense_total_amount_type_wise($expense_type);
		$ledger_list['receipt_expense_total_amount'] = $receipt_expense_total_amount_type_wise->result_array();
		$receipt_expense_delete_total_amount_type_wise = $this->account_model->receipt_expense_delete_total_amount_type_wise($expense_type);
		$ledger_list['receipt_expense_delete_total_amount'] = $receipt_expense_delete_total_amount_type_wise->result_array();
		$receipt_expense_payment_total_amount_type_wise = $this->account_model->receipt_expense_payment_total_amount_type_wise($expense_type);
		$ledger_list['receipt_expense_payment_total_amount'] = $receipt_expense_payment_total_amount_type_wise->result_array();
		
		echo json_encode(array("ledger_list"=>$ledger_list));
	}
	
	function get_all_card()
	{
		$this->db->select('bank_card_info.card_id,bank_card_info.card_name');
		$this->db->from('bank_card_info');
		$this->db->order_by('bank_card_info.card_id','asc');
		$query = $this->db->get();
		echo json_encode($query->result());
	}
	
	public function do_collection_payment()
	{
		$creator 			   	= $this->tank_auth->get_user_id(); 
		$payment_mode 			= (int)$this->input->post('payment_mode');
		$receipt_type 			= (int)$this->input->post('receipt_type');
		$customer_id 			= (int)$this->input->post('customer_id');
		$distributor_id 		= (int)$this->input->post('distributor_id');
		$service_provider_id 	= (int)$this->input->post('service_provider_id');
		$expense_type 			= (int)$this->input->post('expense_type');
		$employee_id 			= (int)$this->input->post('employee_id');
		$card_id 				= (int)$this->input->post('card_id');
		$payment_amount         = (Float)$this->input->post('payment_amount');
		$my_bank          		= (int)$this->input->post('my_bank');
		$to_bank          		= (int)$this->input->post('to_bank');
		$cheque_no          	= $this->input->post('cheque_no');
		$cheque_date          	= $this->input->post('cheque_date');
		$remarks          		= $this->input->post('remarks');
		$balance_customer       =(Float)$this->input->post('balance_customer');
		
		if($receipt_type == 1)
		{
			$transaction_id = $this->account_model->do_payment_distributor($creator,$payment_mode,$distributor_id,$card_id, $payment_amount,$my_bank,$to_bank,$cheque_no,$cheque_date,$remarks);
			echo $transaction_id;
		}
		else if($receipt_type == 2)
		{
			$transaction_id = $this->account_model->do_payment_expense($creator,$payment_mode,$service_provider_id,$expense_type,$employee_id,$card_id, $payment_amount,$my_bank,$to_bank,$cheque_no,$cheque_date,$remarks);
			echo $transaction_id;
		}
		else if($receipt_type == 3)
		{
			$transaction_id = $this->account_model->do_collection_client($creator,$payment_mode,$customer_id,$card_id, $payment_amount,$my_bank,$to_bank,$cheque_no,$cheque_date,$balance_customer,$remarks);
			echo $transaction_id;
		}		     
	}

	public function all_cheque_status_report_find()
	{
		$cheque_status=$this->input->post('cheque_status');
		$temp = array();
		$temp = $this->account_model->get_cheque_status_info_by_multi($cheque_status);
		$temp = $temp->result_array();

		$i=0;
		foreach($temp as $field)
		{
			$ledger_type = $field['ledger_type'];
			$ledger_id = $field['ledger_id'];
			$bb_id = $field['bb_id'];
			if($ledger_type=='sale_collection')
			{
				$sale_ledger_name = $this->account_model->get_sale_ledger_name($ledger_type,$ledger_id,$bb_id);
				$temp[$i]['sale_ledger_name'] = $sale_ledger_name->result_array();
			}
			else if($ledger_type=='purchase_payment')
			{
				$purchase_ledger_name = $this->account_model->get_purchase_ledger_name($ledger_type,$ledger_id,$bb_id);
				$temp[$i]['purchase_ledger_name'] = $purchase_ledger_name->result_array();
			}
			else if($ledger_type=='expense_payment')
			{
				$expense_ledger_name = $this->account_model->get_expense_ledger_name($ledger_type,$ledger_id,$bb_id);
				$temp[$i]['expense_ledger_name'] = $expense_ledger_name->result_array();
			}
			$i++;
		}
		echo json_encode(array("cheque_status"=>$temp));
	}
	


	public function create_owner_transfer()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$data['owner_info'] = $this -> account_model -> owner_info();
		
		
		$transfer_id = $this -> account_model -> create_owner_transfer();

		if($transfer_id!=''){
			$data['status'] = 'success';
			redirect('account/owner_transfer/success');
		}
		else{
			$data['status'] = 'failed';
			redirect('account/owner_transfer/failed');
		}	
	}

	public function create_loan_transfer()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$data['loan_person_info'] = $this -> account_model -> loan_person_info();
		
		
		$transfer_id = $this -> account_model -> create_loan_transfer();

		if($transfer_id!=''){
			$data['status'] = 'success';
			redirect('account/loan_transfer/success');
		}
		else{
			$data['status'] = 'failed';
			redirect('account/loan_transfer/failed');
		}	
	}

	function all_loan_transfer_report_find()
	{
		$credit = array();
		$debit = array();
		$credit = $this->account_model->get_loan_receive_in();
		$credit = $credit->result_array();
		$debit 	= $this->account_model->get_loan_payment_out();
		$debit 	= $debit->result_array();
		echo json_encode(array('credit'=>$credit,'debit'=>$debit));
	}

	function download_loan_transfer()
	{
		date_default_timezone_set("Asia/Dhaka");
		$bd_date = date('Y-m-d',time());
					
		$credit = array();
		$debit = array();
		$credit = $this->account_model->get_loan_receive_in();
		$this->data['credit'] = $credit->result_array();
		$debit 	= $this->account_model->get_loan_payment_out();
		$this->data['debit']  = $debit->result_array();


		$html=$this->load->view('Download/download_loan_transfer',$this->data, true); 

		$this->load->library('m_pdf');
		ob_start();
		$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
		$this->m_pdf->pdf->SetProtection(array('print'));
		$this->m_pdf->pdf->SetTitle("Loan Transfer Report");
		$this->m_pdf->pdf->SetAuthor("Dokani");
		$this->m_pdf->pdf->SetDisplayMode('fullpage');
		
		$this->m_pdf->pdf->AddPageByArray(array(
		'orientation' => '',
		'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
		//margin left,margin right,margin top,margin bottom,margin header,margin footer
		));
		//$this->m_pdf->pdf->SetColumns(2);
		$this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
		$this->m_pdf->pdf->Output();
		ob_end_flush();
		exit;
	}
	
	public function get_all_bank()
	{
		$this->db->select('bank_info.bank_name,bank_info.bank_id');
		$this->db->from('bank_info');
		$this->db->order_by('bank_info.bank_name','asc');
		$query = $this->db->get();
		echo json_encode ($query->result());
	}
		
	public function  all_cash_book_report_find()
	{
		$credit = array();
		$debit = array();
		$credit = $this->account_model->get_cash_book_in();
		$credit = $credit->result_array();
		$debit 	= $this->account_model->get_cash_book_out();
		$debit 	= $debit->result_array();

		echo json_encode(array('credit'=>$credit,'debit'=>$debit));
	}

	function download_cash_book()
	{
		date_default_timezone_set("Asia/Dhaka");
		$bd_date = date('Y-m-d',time());
					
		$credit = array();
		$debit = array();
		$credit = $this->account_model->get_cash_book_in_print();
		$this->data['credit'] = $credit->result_array();
		$debit 	= $this->account_model->get_cash_book_out_print();
		$this->data['debit']  = $debit->result_array();
		$this->__renderviewprint('Prints/accountreport/cash_book',$this->data); 
	}

	function bank_book_report()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['user_name'] = $this->tank_auth->get_username();
		$this -> load -> view('Account/all_bank_book_report_new', $data);
	}
	function  all_bank_book_report_find()
	{
		$credit = array();
		$debit = array();
		$credit = $this->account_model->get_bank_book_in();
		$credit = $credit->result_array();
		$debit 	= $this->account_model->get_bank_book_out();
		$debit 	= $debit->result_array();

		echo json_encode(array('credit'=>$credit,'debit'=>$debit));
	}

	function download_bank_book()
	{
		date_default_timezone_set("Asia/Dhaka");
		$bd_date = date('Y-m-d',time());
					
		$credit = array();
		$debit = array();
		$credit = $this->account_model->get_bank_book_in_print();
		$this->data['credit'] = $credit->result_array();
		$debit 	= $this->account_model->get_bank_book_out_print();
		$this->data['debit']  = $debit->result_array();


		$html=$this->load->view('Download/download_bank_book',$this->data, true); 

		$this->load->library('m_pdf');
		ob_start();
		$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
		$this->m_pdf->pdf->SetProtection(array('print'));
		$this->m_pdf->pdf->SetTitle("Bank Book Report");
		$this->m_pdf->pdf->SetAuthor("Dokani");
		$this->m_pdf->pdf->SetDisplayMode('fullpage');
		
		$this->m_pdf->pdf->AddPageByArray(array(
		'orientation' => '',
		'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
		//margin left,margin right,margin top,margin bottom,margin header,margin footer
		));
		//$this->m_pdf->pdf->SetColumns(2);
		$this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
		$this->m_pdf->pdf->Output();
		ob_end_flush();
		exit;
	}
	function investment_report()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['sale_status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['status'] = '';
		$data['all_investor'] = $this ->account_model-> all_investor();
		$this -> load -> view('Account/all_investment_report_new', $data);
	}

	function all_pay_report_find()
	{
		$type=$this->input->post('type');
		if($type=='payable')
		{
			$temp = array();

			$this->db->select('*');
			$this->db->from('distributor_info');
			$temp = $this->db->get();
			$temp = $temp->result_array();

			$i=0;
			foreach($temp as $field)
			{
				$distributor_id = $field['distributor_id'];
				$receipt_purchase_total_amount = $this->account_model->receipt_purchase_total_amount($distributor_id);
				$temp[$i]['receipt_purchase_total_amount'] = $receipt_purchase_total_amount->result_array();
				
				$receipt_payment_total_amount = $this->account_model->receipt_payment_total_amount($distributor_id);
				$temp[$i]['receipt_payment_total_amount'] = $receipt_payment_total_amount->result_array();
				
				$receipt_payment_delete_total_amount = $this->account_model->receipt_payment_delete_total_amount($distributor_id);
				$temp[$i]['receipt_payment_delete_total_amount'] = $receipt_payment_delete_total_amount->result_array();
				
				$receipt_purchase_return_total_amount = $this->account_model->receipt_purchase_return_total_amount($distributor_id);
				$temp[$i]['receipt_purchase_return_total_amount'] = $receipt_purchase_return_total_amount->result_array();
				
				$receipt_balance_total_amount_distributor = $this->account_model->receipt_balance_total_amount_distributor($distributor_id);
				$temp[$i]['receipt_balance_total_amount'] = $receipt_balance_total_amount_distributor->result_array();
				
				$i++;
			}
			echo json_encode(array("payable"=>$temp));
			
			
		}
		else if($type=='receive')
		{
			$temp2 = array();

			$this->db->select('*');
			$this->db->from('customer_info');
			$temp2 = $this->db->get();
			$temp2 = $temp2->result_array();

			$i=0;
			foreach($temp2 as $field)
			{
				$customer_id = $field['customer_id'];
				
				$receipt_sale_total_amount = $this->account_model->receipt_sale_total_amount($customer_id);
				$temp2[$i]['receipt_sale_total_amount'] = $receipt_sale_total_amount->result_array();
				
				$receipt_collection_total_amount = $this->account_model->receipt_collection_total_amount($customer_id);
				$temp2[$i]['receipt_collection_total_amount'] = $receipt_collection_total_amount->result_array();
				$receipt_delivery_total_amount = $this->account_model->receipt_delivery_total_amount($customer_id);
				$temp2[$i]['receipt_delivery_total_amount'] = $receipt_delivery_total_amount->result_array();
				$receipt_sale_return_total_amount = $this->account_model->receipt_sale_return_total_amount($customer_id);
				$temp2[$i]['receipt_sale_return_total_amount'] = $receipt_sale_return_total_amount->result_array();
				
				$receipt_balance_total_amount_customer = $this->account_model->receipt_balance_total_amount_customer($customer_id);
				$temp2[$i]['receipt_balance_total_amount'] = $receipt_balance_total_amount_customer->result_array();
				
				$i++;
			}
			echo json_encode(array("receive"=>$temp2));
		}
		else if($type=='expense_payable')
		{
			$temp3 = array();

			$this->db->select('*');
			$this->db->from('type_info');
			$temp3 = $this->db->get();
			$temp3 = $temp3->result_array();

			$i=0;
			foreach($temp3 as $field)
			{
				$type_id = $field['type_id'];
				
				$receipt_expense_total_amount_type_wise = $this->account_model->receipt_expense_total_amount_type_wise($type_id);
				$temp3[$i]['receipt_expense_total_amount'] = $receipt_expense_total_amount_type_wise->result_array();
				
				$receipt_expense_delete_total_amount_type_wise = $this->account_model->receipt_expense_delete_total_amount_type_wise($type_id);
				$temp3[$i]['receipt_expense_delete_total_amount'] = $receipt_expense_delete_total_amount_type_wise->result_array();
				$receipt_expense_payment_total_amount_type_wise = $this->account_model->receipt_expense_payment_total_amount_type_wise($type_id);
				$temp3[$i]['receipt_expense_payment_total_amount'] = $receipt_expense_payment_total_amount_type_wise->result_array();
				
				$i++;
			}
			echo json_encode(array("expense_payable"=>$temp3));
		}
	}
	
	function download_data_reci_pay()
	{
		date_default_timezone_set("Asia/Dhaka");
		$bd_date = date('Y-m-d',time());
		$data['bd_date'] = $bd_date;
		
		$temp = array();
		$temp2 = array();
		$type=$this->uri->segment(3);
		if($type=='payable')
		{
			$this->db->select('*');
			$this->db->from('distributor_info');
			$temppp = $this->db->get();
			$temp = $temppp->result_array();

			$i=0;
			foreach($temp as $field)
			{
				$distributor_id = $field['distributor_id'];
				$receipt_purchase_total_amount = $this->account_model->receipt_purchase_total_amount($distributor_id);
				$temp[$i]['receipt_purchase_total_amount'] = $receipt_purchase_total_amount->result_array();
				
				$receipt_payment_total_amount = $this->account_model->receipt_payment_total_amount($distributor_id);
				$temp[$i]['receipt_payment_total_amount'] = $receipt_payment_total_amount->result_array();
				
				$receipt_payment_delete_total_amount = $this->account_model->receipt_payment_delete_total_amount($distributor_id);
				$temp[$i]['receipt_payment_delete_total_amount'] = $receipt_payment_delete_total_amount->result_array();
				
				$receipt_purchase_return_total_amount = $this->account_model->receipt_purchase_return_total_amount($distributor_id);
				$temp[$i]['receipt_purchase_return_total_amount'] = $receipt_purchase_return_total_amount->result_array();
				
				$receipt_balance_total_amount_distributor = $this->account_model->receipt_balance_total_amount_distributor($distributor_id);
				$temp[$i]['receipt_balance_total_amount'] = $receipt_balance_total_amount_distributor->result_array();
				
				$i++;
			}
			
		}
		else if($type=='receive')
		{
			

			$this->db->select('*');
			$this->db->from('customer_info');
			$temp2 = $this->db->get();
			$temp2 = $temp2->result_array();

			$i=0;
			foreach($temp2 as $field)
			{
				$customer_id = $field['customer_id'];
				
				$receipt_sale_total_amount = $this->account_model->receipt_sale_total_amount($customer_id);
				$temp2[$i]['receipt_sale_total_amount'] = $receipt_sale_total_amount->result_array();
				
				$receipt_collection_total_amount = $this->account_model->receipt_collection_total_amount($customer_id);
				$temp2[$i]['receipt_collection_total_amount'] = $receipt_collection_total_amount->result_array();
				
				$receipt_sale_return_total_amount = $this->account_model->receipt_sale_return_total_amount($customer_id);
				$temp2[$i]['receipt_sale_return_total_amount'] = $receipt_sale_return_total_amount->result_array();
				
				$receipt_balance_total_amount_customer = $this->account_model->receipt_balance_total_amount_customer($customer_id);
				$temp2[$i]['receipt_balance_total_amount'] = $receipt_balance_total_amount_customer->result_array();
				
				$i++;
			}
		}
		else if($type=='expense_payable')
		{
			$temp3 = array();

			$this->db->select('*');
			$this->db->from('type_info');
			$temp3 = $this->db->get();
			$temp3 = $temp3->result_array();

			$i=0;
			foreach($temp3 as $field)
			{
				$type_id = $field['type_id'];
				
				$receipt_expense_total_amount_type_wise = $this->account_model->receipt_expense_total_amount_type_wise($type_id);
				$temp3[$i]['receipt_expense_total_amount'] = $receipt_expense_total_amount_type_wise->result_array();
				
				$receipt_expense_delete_total_amount_type_wise = $this->account_model->receipt_expense_delete_total_amount_type_wise($type_id);
				$temp3[$i]['receipt_expense_delete_total_amount'] = $receipt_expense_delete_total_amount_type_wise->result_array();
				$receipt_expense_payment_total_amount_type_wise = $this->account_model->receipt_expense_payment_total_amount_type_wise($type_id);
				$temp3[$i]['receipt_expense_payment_total_amount'] = $receipt_expense_payment_total_amount_type_wise->result_array();
				
				$i++;
			}
		}
		
		$data['payable']= $temp;
		$data['receive']= $temp2;
		$data['expense_payable']= $temp3;


		//$this->load->view('Download/download_data_reci_pay',$data); 
		$html=$this->load->view('Download/download_data_reci_pay',$data,true); 

		$this->load->library('m_pdf');
		ob_start();
		$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
		$this->m_pdf->pdf->SetProtection(array('print'));
		$this->m_pdf->pdf->SetTitle("Payable Receivable Report");
		$this->m_pdf->pdf->SetAuthor("Dokani");
		$this->m_pdf->pdf->SetDisplayMode('fullpage');
		
		$this->m_pdf->pdf->AddPageByArray(array(
		'orientation' => '',
		'mgl' => '10','mgr' => '10','mgt' => '45','mgb' => '20','mgh' => '10','mgf' => '5',
		//margin left,margin right,margin top,margin bottom,margin header,margin footer
		));
		//$this->m_pdf->pdf->SetColumns(2);
		$this->m_pdf->pdf->WriteHTML($html);
		ob_clean();
		$this->m_pdf->pdf->Output();
		ob_end_flush();
		exit;
		
	}
	
}

?>