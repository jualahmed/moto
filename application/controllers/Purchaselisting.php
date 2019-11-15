<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaselisting extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('purchaselisting_model');
		$this->load->model('report_model');
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
		$data['vuejscomp'] = 'purchaselisting.js';
		$this->__renderview('Purchase/purchaselisting',$data);
	}

	public function specificPurchaseReceipt()
	{
		$purchase_receipt_id 				= (int)$this->input->post('purchase_receipt_id');
		$receipt_general_details			= $this->purchaselisting_model->specific_purchase_receipt_general( $purchase_receipt_id);
		$tmp_row 							= $receipt_general_details->row();
		$tmp_data['final_amount'] 			= $tmp_row->final_amount;
		$tmp_data['purchase_amount'] 		= $tmp_row->purchase_amount;
		$tmp_data['total_purchase_amount'] 	= $this->purchaselisting_model->get_total_purchase_amount($purchase_receipt_id);
		echo json_encode($tmp_data);
	}

  public function allproductbelogntopurchase($purchase_id='')
  { 
    $data=$this->purchaselisting_model->allproductbelogntopurchase($purchase_id);
    echo json_encode($data);
  }

	public function getSpecificPurchaseReceiptProduct()
	{
		$purchase_receipt_id 		= (int)$this->input->post('purchase_receipt_id');
		$purchase_receipt_details	= $this->purchaselisting_model->specific_purchase_receipt($purchase_receipt_id);
		json_encode($purchase_receipt_details);
	}
	
	public function all($rowno=0)
	{
		$rowperpage = 12;
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->db->count_all('Purchaselisting_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('Purchaselisting_id', 'desc');
        $users_record = $this->db->get('Purchaselisting_info')->result_array();
        $config['base_url'] = base_url().'Purchaselisting';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        echo json_encode($data);
	}

  public function find()
  {
    $Purchaselisting_id=$this->input->post('purchaselisting_id');
    $data=$this->purchaselisting_model->findl($Purchaselisting_id);
    echo json_encode($data);
  }

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'Purchaselisting_name',
	        'label' => 'Purchaselisting_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'Purchaselisting_contact_no',
	        'label' => 'Purchaselisting_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'Purchaselisting_email',
	        'label' => 'Purchaselisting_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'Purchaselisting_address',
	        'label' => 'Purchaselisting_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'Purchaselisting_description',
	        'label' => 'Purchaselisting_description',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'Purchaselisting_description',
	        'label' => 'Purchaselisting_description',
	      )
	    );
	    $Purchaselisting_id=$this->input->post('Purchaselisting_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'Purchaselisting_name' => $this->input->post('Purchaselisting_name'),
	        'Purchaselisting_address' => $this->input->post('Purchaselisting_address'),
	        'Purchaselisting_contact_no' => $this->input->post('Purchaselisting_contact_no'),
	        'Purchaselisting_email' => $this->input->post('Purchaselisting_email'),
	        'Purchaselisting_description' => $this->input->post('Purchaselisting_description'),
	        'Purchaselisting_creator' => $creator,
	      );
	      $id = $this->Purchaselisting_model->update($Purchaselisting_id,$data);
	      $output = '';
	      if ($id) {
	        $jsonData['success'] = true;
	      }
	    }else {
	      foreach ($_POST as $key => $value) {
	        $jsonData['errors'][$key] = form_error($key);
	      }
	    }
	    echo json_encode($jsonData);
	}

  public function editPruchaseProduct()
  {
    $purchase_id      = $this->input->post('purchase_id');
    $qnty           = $this->input->post('qty');
    $unit_buy_price     = $this->input->post('u_b_p');
    $bulk_unit_sale_price     = $this->input->post('g_b_p');
    $general_unit_sale_price    = $this->input->post('e_b_p');
    echo $this->purchaselisting_model->editPruchaseProduct($purchase_id, $qnty, $unit_buy_price,$bulk_unit_sale_price,$general_unit_sale_price);
  }


	public function destroy($id)
	{	
		$result=$this->Purchaselisting_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'Purchaselisting Delete successfully');
			redirect('Purchaselisting','refresh');
		}
	}

}

/* End of file Purchaselisting.php */
/* Location: ./application/controllers/Purchaselisting.php */