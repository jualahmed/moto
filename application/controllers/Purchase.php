<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Purchase extends MY_Controller
{
	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id = $this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('purchase_model');
    $this->load->model('distributor_model');
		$this->load->model('purchaselisting_model');
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
		$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this->tank_auth->get_username();
		$data['all_bank'] 	= $this->purchase_model->get_all_bank();
		$data['distributor_info'] 	= $this->distributor_model->all();
		$data['status'] 	= '';
		$data['vuejscomp'] = 'purchasereceipt.js';
		$this->__renderview('Purchase/purchasereceipt',$data);
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'challan_no',
	        'label' => 'challan_no'
	      ),
	      array(
	        'field' => 'distributor_id',
	        'label' => 'distributor_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'purchase_amount',
	        'label' => 'purchase_amount',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'transport_cost',
	        'label' => 'transport_cost',
	      ),
	      array(
	        'field' => 'gift_on_purchase',
	        'label' => 'gift_on_purchase',
	      ),
	      array(
	        'field' => 'final_amount',
	        'label' => 'final_amount',
	      ),
	      array(
	        'field' => 'receipt_date',
	        'label' => 'receipt_date',
	        'rules' => 'required'
	      )
	    );

		$creator = $this->tank_auth->get_user_id();
		$ffffffff=$this->input->post('receipt_date');
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'challan_no' => $this->input->post('challan_no'),
	        'distributor_id' => $this->input->post('distributor_id'),
	        'purchase_amount' => $this->input->post('purchase_amount'),
	        'transport_cost' => $this->input->post('transport_cost'),
	        'gift_on_purchase' => $this->input->post('gift_on_purchase'),
	        'final_amount' => $this->input->post('final_amount'),
	        'shop_id' 		=> $this->tank_auth->get_shop_id(), 
	        'receipt_status' 	=> 'unpaid',
			'total_paid' 		=> $this->input->post('payment_amount'),
	        'receipt_date	' => $ffffffff,
	        'receipt_creator' => $creator
	      );
	      // $id = 4;
	      $id = $this->purchase_model->create($data,$ffffffff);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['data'] = $this->purchase_model->all($data);
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
		$rowperpage = 8;
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->db->count_all('purchase_receipt_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('receipt_id', 'desc');
        $this->db->join('distributor_info', 'distributor_info.distributor_id = purchase_receipt_info.distributor_id');
        $users_record = $this->db->get('purchase_receipt_info')->result_array();
        $config['base_url'] = base_url().'purchase';
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
        $config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']   = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close']  = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']   = '</span></li>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        echo json_encode($data);
	}

	public function alls()
	{
		$data=$this->purchase_model->all();
		echo json_encode($data);
	}

	public function createlisting()
	{
		$purchase_receipt_id=$this->input->post('purchase_receipt_id');
		$product_id=$this->input->post('product_id');
		$productinfo=$this->input->post('productinfo');
		$expiredate=$this->input->post('expiredate');
		$tp_total=$this->input->post('tp_total');
		$vat_total=$this->input->post('vat_total');
		$quantity=$this->input->post('quantity');
		$total_buy_price=$this->input->post('total_buy_price');
		$unit_buy_price_purchase=$this->input->post('unit_buy_price_purchase');
		$exclusive_sale_price=$this->input->post('exclusive_sale_price');
		$general_sale_price=$this->input->post('general_sale_price');
		$creator = $this->tank_auth->get_user_id();
		// Bulk stoke info table
		
		$this->db->where('product_id', $product_id);
		$alddata=$this->db->get('bulk_stock_info')->result();

		if($alddata){
			if($alddata['0']->stock_amount==0){
				$totalquantity=$quantity;
				$unit_buy_price_purchase1=$unit_buy_price_purchase;
				$exclusive_sale_price1=$exclusive_sale_price;
				$general_unit_sale_price1=$general_sale_price;
				$object=[
					'stock_amount'=>$totalquantity,
					'bulk_unit_buy_price'=>$unit_buy_price_purchase1,
					'bulk_unit_sale_price'=>$exclusive_sale_price1,
					'general_unit_sale_price'=>$general_unit_sale_price1,
					'last_buy_price'=>$total_buy_price
				];
				$this->db->where('bulk_id', $alddata['0']->bulk_id);
				$this->db->update('bulk_stock_info',$object);
			}
			else{
				$oldquantity=$alddata['0']->stock_amount;
				$totalquantity=$quantity+$oldquantity;
				$unit_buy_price_purchase1=($alddata['0']->bulk_unit_buy_price+$unit_buy_price_purchase)/2;
				$exclusive_sale_price1=($alddata['0']->bulk_unit_sale_price+$exclusive_sale_price)/2;
				$general_unit_sale_price1=($alddata['0']->general_unit_sale_price+$general_sale_price)/2;
				$object=[
					'stock_amount'=>$totalquantity,
					'bulk_unit_buy_price'=>$unit_buy_price_purchase1,
					'bulk_unit_sale_price'=>$exclusive_sale_price1,
					'general_unit_sale_price'=>$general_unit_sale_price1,
					'last_buy_price'=>$total_buy_price
				];
				$this->db->where('bulk_id', $alddata['0']->bulk_id);
				$this->db->update('bulk_stock_info',$object);
			}
		}else{
			$object=[
				'stock_amount'=>$quantity,
				'product_id'=>$product_id,
				'shop_id'   => $this->tank_auth->get_shop_id(), 
				'bulk_unit_buy_price'=>$unit_buy_price_purchase,
				'bulk_unit_sale_price'=>$exclusive_sale_price,
				'general_unit_sale_price'=>$general_sale_price,
				'bulk_alarming_stock'=>100,
				'last_buy_price'=>$total_buy_price,
				'warranty_period'=>0,
				'product_specification'=>1,
				'stock_doc'=>date('Y-m-d'),
			];
			$this->db->insert('bulk_stock_info', $object);
		}

		foreach ($productinfo as $value) {
			$data = array(
		        'product_id' => $product_id,
		        'purchase_receipt_id' => $purchase_receipt_id,
				'purchase_date'=>date('Y-m-d'),
				'purchase_price'=>$unit_buy_price_purchase,
				'sale_price'=>$general_sale_price,
	        	'creator' => $creator,
		        'engineno' => $value['engineno'],
		        'batteryno' => $value['batteryno'],
		        'color' => $value['color'],
		        'chassisno' => $value['chassisno'],
		    );
	        $this->db->insert('warranty_product_list', $data);
		}
		// reciper for info table
		$data = array(
	        'purchase_receipt_id' => $purchase_receipt_id,
	        'product_id' => $product_id,
	        'purchase_quantity' => $quantity,
	        'unit_buy_price' => $unit_buy_price_purchase,
	        'purchase_expire_date' => $expiredate,
	        'purchase_description' => "a test purchase_receipt_id",
	        'purchase_creator' => $creator,
	    );
	    $id=$this->purchase_model->createlisting($data);
	    echo json_encode($id);
	}

	public function allproductbelogntopurchase($purchase_id='')
	{	
		$data=$this->purchase_model->allproductbelogntopurchase($purchase_id);
		echo json_encode($data);
	}
	
	public function purchase_return()
	{
		$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this -> tank_auth -> get_username();
		$data['all_bank'] 	= $this -> purchase_model -> get_all_bank();
		$data['distributor_info'] 	= $this -> purchase_model -> distributor_info();
		$data['product_info_warranty_details'] 	= '';
		$data['product_info_details'] 	= '';
		$data['return_main_product'] 	= $this -> purchase_model -> return_main_product();
		$i=1;
		foreach($data['return_main_product']->result() as $tmp)
		{
			$data['return_warranty_product'][$i] 	= $this -> purchase_model -> return_warranty_product($tmp->produ_id);
			$i++;
		}
		$distributor_id = $this->uri->segment(3);
		$product_id = $this->uri->segment(4);
		if($distributor_id!='' || $product_id!='')
		{
			$data['product_info'] 	= $this -> purchase_model -> product_info();
			$data['product_info_details'] 	= $this -> purchase_model -> product_info_details($product_id);
			$data['product_info_warranty_details'] 	= $this -> purchase_model -> product_info_warranty_details($product_id);
		}
		$data['status'] 	= '';
		$data['vuejscomp'] = 'purchase_return.js';
		$this->__renderview('Purchase/purchase_return', $data);
	}

	//  old code need to chance all function
	public function final_purchase_return()
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date=date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();
		$zero = 0;
		$this->db->select('purchase_return_main_product.*,SUM(return_quantity*buy_price) as total_return');
		$this->db->from('purchase_return_main_product');
		$this->db->where('purchase_return_main_product.status="'.$zero.'"');
		$query3 = $this->db->get();
		$tmp3 = $query3->row();
		$transaction_info = array
		(
		   'transaction_id'         			=> '',
		   'transaction_purpose'                => 'purchase_return',
		   'transaction_mode'                 	=> '',
		   'ledger_id'         					=> $tmp3->distri_id,
		   'common_id'         					=> '',
		   'amount'     						=> $tmp3->total_return,
		   'date'                   			=> date('Y-m-d'),
		   'status'        						=> 'active',
		   'creator'        					=> $creator,
		   'doc'   								=> $bd_date,
		   'dom'    							=> $bd_date
		);
		$this->db->insert('transaction_info', $transaction_info);
		$this->db->select('*');
		$this->db->from('purchase_return_main_product');
		$this->db->where('purchase_return_main_product.status="'.$zero.'"');
		$query1 = $this->db->get();
		$i=1;
		foreach($query1->result() as $tmp1)
		{
			$this->db->set('stock_amount', 'stock_amount-' . $tmp1->return_quantity, FALSE);
			$this->db->where('product_id', $tmp1->produ_id);
			$this->db->update('bulk_stock_info');
			
			$this->db->set('status', 'status+' . 1, FALSE);
			$this->db->where('status="'.$zero.'"');
			$this->db->where('prmp_id', $tmp1->prmp_id);
			$this->db->where('produ_id', $tmp1->produ_id);
			$this->db->update('purchase_return_main_product');
			 $i++;
		}

		$this->db->select('*');
		$this->db->from('purchase_return_warranty_product');
		$this->db->where('purchase_return_warranty_product.status="'.$zero.'"');
		$query2 = $this->db->get();
		
		
		if($query2->num_rows > 0)
		{
			$ii=1;
			foreach($query2->result() as $tmp2)
			{
				$this->db->where('ip_id', $tmp2->ip_id);
				$this->db->where('product_id', $tmp2->product_id);
				$this->db->delete('warranty_product_list');
				
				$this->db->set('status', 'status+' . 1, FALSE);
				$this->db->where('status="'.$zero.'"');
				$this->db->where('prwp_id', $tmp2->prwp_id);
				$this->db->where('prmp_id', $tmp2->prmp_id);
				$this->db->where('ip_id', $tmp2->ip_id);
				$this->db->where('product_id', $tmp2->product_id);
				$this->db->update('purchase_return_warranty_product');
				$ii++;
			}
			
		}
		redirect('purchase/purchase_return/null/null/success');

	}

  public function removeProductFromPurchase()
  {
    $purchase_receipt_id    = $this->input->post('purchase_receipt_id');
    $product_id       = $this->input->post('pro_id');
    $purchase_id      = $this->input->post('purchase_id');
    if($purchase_receipt_id != '' && $product_id != '' && is_numeric($purchase_receipt_id) && is_numeric($product_id))
    { 
      $data = $this->purchaselisting_model->removeProductFromPurchase($purchase_receipt_id, $product_id,$purchase_id);
      echo $data;
    }
  }
}
