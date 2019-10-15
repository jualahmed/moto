<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends MY_Controller {
	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('product_model');
		$this->load->model('category_model');
		$this->load->model('company_model');
		$this->load->model('unit_model');
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
		$data['company'] = $this->company_model->all();
		$data['catagory'] = $this->category_model->all();
		$data['unit'] = $this->unit_model->all();
		$data['product_specification'] = $this->product_model->product_specification();
		$data['last_id'] = $this->product_model->getLastInserted();
		$data['vuejscomp'] = 'product.js';
		$this->__renderview('Setup/product',$data);
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'product_name',
	        'label' => 'product_name',
	        'rules' => 'required|is_unique[product_info.product_name]'
	      ),
	      array(
	        'field' => 'catagory_id',
	        'label' => 'catagory_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_id',
	        'label' => 'company_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'product_model',
	        'label' => 'product_model',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'product_specification',
	        'label' => 'product_specification',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'unit_id',
	        'label' => 'unit_id',
	        'rules' => 'required'
	      ) 
	    );
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'product_name' => $this->input->post('product_name'),
	        'product_model' => $this->input->post('product_model'),
	        'catagory_id' => $this->input->post('catagory_id'),
	        'company_id' => $this->input->post('company_id'),
	        'product_size' => $this->input->post('product_size'),
	        'unit_id' => $this->input->post('unit_id'),
	        'product_specification' => $this->input->post('product_specification'),
	        'product_warranty' => $this->input->post('product_warranty'),
	        'product_creator' => $creator
	      );
	      $id = $this->product_model->create($data);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['success'] = true;
	      }
	    }else {
	      foreach ($_POST as $key => $value) {
	        $jsonData['errors'][$key] = form_error($key);
	      }
	    }
	    echo json_encode($jsonData);
	}

	public function all($rowno=0)
	{
		$rowperpage = 12;
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->db->count_all('product_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->join('catagory_info', 'catagory_info.catagory_id = product_info.catagory_id');
        $this->db->join('company_info', 'company_info.company_id = product_info.company_id');
        $this->db->order_by('product_id', 'desc');
        $users_record = $this->db->get('product_info')->result_array();
        $config['base_url'] = base_url().'product';
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
		$product_id=$this->input->post('product_id');
		$data=$this->product_model->find($product_id);
		echo json_encode($data);
	}

	public function w_p_update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'engineno',
	        'label' => 'engineno',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'chassisno',
	        'label' => 'chassisno',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'color',
	        'label' => 'color',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'batteryno',
	        'label' => 'batteryno',
	        'rules' => 'required'
	      ),
	    );
	    $ip_id=$this->input->post('ip_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'engineno' => $this->input->post('engineno'),
	        'chassisno' => $this->input->post('chassisno'),
	        'color' => $this->input->post('color'),
	        'batteryno' => $this->input->post('batteryno')
	      );
	      $this->db->where('ip_id', $ip_id);
	      $id=$this->db->update('warranty_product_list', $data);
	      $output = '';
	      if ($id) {
	        $jsonData['success'] = true;
	        $jsonData['id'] = $ip_id;
	      }
	    }else {
	      foreach ($_POST as $key => $value) {
	        $jsonData['errors'][$key] = form_error($key);
	      }
	    }
	    echo json_encode($jsonData);
	}

	public function find_worranty()
	{	
		$id=$this->input->post('id');
		$this->db->where('ip_id', $id);
		$data=$this->db->get('warranty_product_list')->row();
		echo json_encode($data);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'product_name',
	        'label' => 'product_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'catagory_id',
	        'label' => 'catagory_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_id',
	        'label' => 'company_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'unit_id',
	        'label' => 'unit_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'product_model',
	        'label' => 'product_model'
	      ),
	      array(
	        'field' => 'product_size',
	        'label' => 'product_size'
	      ) 
	    );
	    $product_id=$this->input->post('product_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'product_name' => $this->input->post('product_name'),
	        'catagory_id' => $this->input->post('catagory_id'),
	        'company_id' => $this->input->post('company_id'),
	        'product_size' => $this->input->post('product_size'),
	        'product_model' => $this->input->post('product_model'),
	        'unit_id' => $this->input->post('unit_id'),
	        'product_creator' => $creator
	      );
	      $id = $this->product_model->update($product_id,$data);
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

	public function destroy($id)
	{	
		$result=$this->product_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'product Delete successfully');
			redirect('product','refresh');
		}
	}

	public function checkAvailability() {
	  $product_name =strtolower(preg_replace('/\+/', '', $this->input->post('customProductName')));
	  $query=$this -> db -> select('*')
						-> from('product_info')
						->like('LOWER(product_name)',$product_name)
						->get();
	  if($query -> num_rows() >0) {
		  echo 'Product Name Not Available';
	  }
	  else{
		  echo 'Product Name Available';
	  }
	}

	public function search($query='')
	{	
		$query=$this->input->get('query');
		$data=$this->product_model->search($query);
		echo json_encode($data);
	}

	public function search_barcode_barcode()
	{
		$barcode = $this->input->post('barcode');
		$this->db->select('product_id');
		$this->db->from('product_info');
		$this->db->where('barcode',$barcode);
		$quer=$this->db->get();
		if($quer->num_rows >0){ 
			foreach($quer-> result() as $field):
				$inputValue = $field->product_id;
			endforeach;
		}
		// var_dump(expression)
		redirect('product/searchBarcode/'.$inputValue);
	}

	public function searchBarcode()
	{
		$data['bd_date'] = date ('Y-m-d');
		$data['user_id'] = $this->tank_auth->get_user_id();
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();	
		$data['shop_name'] = $this->tank_auth->get_shopname();
		$data['shop_address'] = $this->tank_auth->get_shopaddress();
		$data['access_status'] = '';
		$data['sale_status'] = '';
		$data['status'] = '';
		$data['alarming_level'] = FALSE;
	    $query = $this->product_model->productsss_info(FALSE, 0, $this->tank_auth->get_shop_id());
		$temp[''] = 'Select A Product';
		foreach($query -> result() as $field):
			 $temp[base_url().'product/searchBarcode/'.$field->product_id] = $field->product_id;
		endforeach;
		$data['product_info'] = $temp;
		$data['product_type'] = 'nil';
		if($this->input->post('productId'))
	    	$product_ID = $this->input->post('productId'); // from submission
		else $product_ID = $this->uri->segment(3) ; // from url
		$query_two = $this->site_model->products_special_information($product_ID, $this->tank_auth->get_shop_id());
		foreach($query_two -> result() as $field):
			 $data['product_name'] = $field->product_id;
			 $data['available_stock'] = $field->available_stock;
			 $data['product_type'] = $field->product_specification;
			 $data['buy_price'] = $field->bulk_unit_buy_price;
			 $data['sale_price'] = $field->bulk_unit_sale_price;
			 $data['general_sale_price'] = $field->general_unit_sale_price;
		endforeach;
		if($this->uri->segment(3))
		{
			$this->form_validation->set_rules('product_id', ' ', 'trim|required|xss_clean');
			if( $data['product_type'] == 'bulk')
					$this->form_validation->set_rules('Quantity', ' ', 'trim|required|xss_clean|numeric');
		}
		else
		{
			$this->form_validation->set_rules('productId', ' ', 'trim|required|xss_clean');
			if( $data['product_type'] == 'bulk')
				$this->form_validation->set_rules('Quantity', ' ', 'trim|required|xss_clean|numeric');
			else $this->form_validation->set_rules('special_for_individual', ' ', 'trim|required|xss_clean|numeric');
		}
		$data['find_all_stock_id']= $this->site_model->find_all_stock_id($product_ID, $this->tank_auth->get_shop_id());
		if($this->form_validation->run())
		{
			$data['status'] = 'successful';
			$SALE_price = $this->input->post('unit_sale_price');
			$g_price = $this->input->post('general_sale_price');
			$PRODUCT_NAME = $this->input->post('PRODUCT_NAME');
			$this->site_model->makeBarcode($product_ID,$PRODUCT_NAME,$data['product_type'],$SALE_price,$g_price,$data['find_all_stock_id']);
		}
		$data['listed_product'] =$this->site_model->get_barcode_all_listed_product();
		$data['vuejscomp'] = 'searchBarcodeview.js';
		$this->__renderview('searchBarcodeview', $data);
	}

	public function delete_all_barcode_print_product()
	{
		$this->db->empty_table('barcode_print'); 
		redirect('product/searchBarcode');
	}
	
	public function print_barcode_by_search()
	{
		$data['nil_discount'] = 1;
		$data['listed_product'] = $this->site_model->get_barcode_all_listed_product();
		$this->load->view('barcode_print_view_by_search_label_printer', $data);
	}

	public function delete_barcode_print_product($print_id = '')
	{
		$this->db->where('print_id',$print_id); 
		$this->db->delete('barcode_print'); 
		redirect('product/searchBarcode');
	}

}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */