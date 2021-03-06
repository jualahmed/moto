<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Purchase_model extends CI_model
{
    private $userId;
	private $bdDate;
	public function __construct()
	{
		parent::__construct();
		$this->userId = $this->tank_auth->get_user_id();
		$this->bdDate = date ('Y-m-d');
	}

	// purchase receipt info
	public function create(array $data,$ddd)
	{	
		$dd=$ddd;
		$insert = $this->db->insert('purchase_receipt_info',$data);
		$ref_id= $this->db->insert_id();
		/* transport_cost is an expance */
		if($data['transport_cost'] > 0)
		{
			$expance = array(
				'shop_id' 				=>$this->tank_auth->get_shop_id(), 
				'service_provider_id' 	=> 1, // Need to set a Default Value(purchase_receipt_id) to get the distributor
				'expense_type' 			=> 10,				
				'expense_amount' 		=> $data['transport_cost'],
				'expense_details' 		=> 'Transaction Cost For Purchase Receipt '. $ref_id,
				'expense_creator' 		=> $data['receipt_creator']
			);	
			$insert = $this->db->insert('expense_info',$expance);

			$purchase_expense_info = array
			(
			   'transaction_id'         			=> '',
			   'transaction_purpose'                => 'expense',
			   'transaction_mode'                 	=> '',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $ref_id,
			   'amount'     						=> $data['transport_cost'],
			   'date'                   			=> $dd,
			   'status'        						=> 'active',
			   'creator'        					=> $data['receipt_creator'],
			);
			$this->db->insert('transaction_info', $purchase_expense_info);
		}
		
		$purchase_info = array
		(
		   'transaction_purpose'                => 'purchase',
		   'transaction_mode'                 	=> '',
		   'ledger_id'         					=> $data['distributor_id'],
		   'common_id'         					=> $ref_id,
		   'amount'     						=> $data['final_amount'],
		   'date'                   			=> $dd,
		   'status'        						=> 'active',
		   'creator'        					=> $data['receipt_creator'],
		);
		$this->db->insert('transaction_info', $purchase_info);
		

		$payment_mode = $this->input->post('payment_mode');
		$payment_amount = $this->input->post('payment_amount');
		$card_id = $this->input->post('card_id');
		$my_bank = $this->input->post('my_bank');
		$to_bank = $this->input->post('to_bank');
		$cheque_no = $this->input->post('cheque_no');
		$cheque_date = $this->input->post('cheque_date');
		$bd_date=$dd;
		if($payment_mode !='')
		{
			if($payment_mode==1 && $payment_amount>0)
			{
				$payment_info = array
				(
				   'transaction_purpose'                => 'payment',
				   'transaction_mode'                 	=> 'cash',
				   'ledger_id'         					=> $data['distributor_id'],
				   'common_id'         					=> $ref_id,
				   'amount'     						=> $payment_amount,
				   'date'                   			=> $bd_date,
				   'status'        						=> 'active',
				   'creator'        					=> $data['receipt_creator'],
				);
				$this->db->insert('transaction_info', $payment_info);
				$insert_id = $this->db->insert_id();
				$cash_book = array(
				   'cb_id'         						=> '',
				   'transaction_id'                     => $insert_id,
				   'transaction_type'                	=> 'out',
				   'amount'                 			=> $payment_amount,
				   'date'         						=> $bd_date,
				   'status'    	 						=> 'active',
				   'creator'                   			=> $data['receipt_creator'],
				);
				$this->db->insert('cash_book', $cash_book);
			}
			else if($payment_mode==2 && $payment_amount>0)
			{
				$payment_info = array
				(
				   'transaction_purpose'                => 'payment',
				   'transaction_mode'                 	=> 'cheque',
				   'ledger_id'         					=> $data['distributor_id'],
				   'common_id'         					=> $ref_id,
				   'amount'     						=> $payment_amount,
				   'date'                   			=> $bd_date,
				   'status'        						=> 'active',
				   'creator'        					=> $data['receipt_creator'],
				);
				$this->db->insert('transaction_info', $payment_info);
				$insert_id = $this->db->insert_id();
				$bank_book = array(
				   'bb_id'         						=> '',
				   'transaction_id'                     => $insert_id,
				   'ledger_id'         					=> $data['distributor_id'],
				   'ledger_type'         				=> 'purchase_payment',
				   'bank_id'                     		=> $my_bank,
				   'card_id'                     		=> 0,
				   'transaction_type'                	=> 'out',
				   'bank_name'                			=> $to_bank,
				   'cheque_no'                			=> $cheque_no,
				   'cheque_date'                		=> $cheque_date,
				   'amount'                 			=> $payment_amount,
				   'date'         						=> $bd_date,
				   'status'    	 						=> 'inactive',
				   'creator'                   			=> $data['receipt_creator'],
				);
				$this->db->insert('bank_book', $bank_book);
			}
			
			else if($payment_mode==3 && $payment_amount>0)
			{
				$payment_info = array
				(
				   'transaction_purpose'                => 'payment',
				   'transaction_mode'                 	=> 'card',
				   'ledger_id'         					=> $data['distributor_id'],
				   'common_id'         					=> $ref_id,
				   'amount'     						=> $payment_amount,
				   'date'                   			=> $bd_date,
				   'status'        						=> 'active',
				   'creator'        					=> $data['receipt_creator'],
				);
				$this->db->insert('transaction_info', $payment_info);
				$insert_id = $this->db->insert_id();
				
				$this->db->select('bank_card_info.bank_id');
				$this->db->from('bank_card_info');
				$this->db->where('bank_card_info.card_id',$card_id);
				$query = $this->db->get();
				$field = $query->row();
				$bank_id = $field->bank_id;
				
				$bank_book = array(
				   'bb_id'         						=> '',
				   'transaction_id'                     => $insert_id,
				   'bank_id'                     		=> $bank_id,
				   'card_id'                     		=> $card_id,
				   'transaction_type'                	=> 'out',
				   'bank_name'                			=> '',
				   'cheque_no'                			=> '',
				   'cheque_date'                		=> '0000-00-00',
				   'amount'                 			=> $payment_amount,
				   'date'         						=> $bd_date,
				   'status'    	 						=> 'active',
				   'creator'                   			=> $data['receipt_creator'],
				);
				$this->db->insert('bank_book', $bank_book);
			}
		}
		return $ref_id;
	}
	
	// create Purchase Listing
	public function createlisting(array $data)
	{
		$this->db->insert('purchase_info', $data);
		$id=$this->db->insert_id();
		$this->db->select('purchase_info.*,product_info.product_name');
		$this->db->where('purchase_id', $id);
		$this->db->join('product_info', 'product_info.product_id = purchase_info.product_id');
		return $this->db->get('purchase_info')->result();
	}

	public function allproductbelogntopurchase($purchase_id='')
	{	
		$this->db->select('purchase_info.*,product_info.product_name');
		$this->db->where('purchase_receipt_id', $purchase_id);
		$this->db->join('product_info', 'product_info.product_id = purchase_info.product_id');
		return $this->db->get('purchase_info')->result();
	}

	public function all()
	{	
		$this->db->order_by('receipt_id', 'asc');
        $this->db->join('distributor_info', 'distributor_info.distributor_id = purchase_receipt_info.distributor_id');
		return $this->db->get('purchase_receipt_info')->result();
	}

	/* Ending: newCreatePurchaseReceipt (added by Prasanta). */
	public function get_all_bank()
	{
		$this->db->select('bank_info.bank_name,bank_info.bank_id');
		$this->db->from('bank_info');
		$this->db->order_by('bank_info.bank_name','asc');
		$query = $this->db->get();
		return $query;
	}

		













	// old code will delete
	/* Receipt information */
	function receipt_info($distributor_id,$receipt_id)
	{
		$this->db->where("distributor_id", $distributor_id );
		//if($receipt_id!=''){$this -> db -> where("receipt_id", $receipt_id );}
		$this -> db -> order_by( "receipt_id", "asc" );
		$query = $this -> db -> get('purchase_receipt_info');
		return $query;
	}
	/* Product information */
	function product_info()
	{
		$this -> db -> select("product_info.product_id,product_info.product_name,product_info.product_specification");
		$this -> db -> from("product_info");
		$this -> db -> order_by("product_info.product_name", "asc" );
		$this -> db -> group_by("product_info.product_id" );
		$query = $this -> db -> get();

		return $query;
	}
	/* Product Details information */
	function product_info_details($product_id)
	{
		$this -> db -> select("product_info.product_id,product_info.product_name,product_info.product_specification,bulk_stock_info.stock_amount,bulk_stock_info.bulk_unit_buy_price");
		$this -> db -> from("bulk_stock_info,product_info");
		$this -> db -> where("bulk_stock_info.product_id=product_info.product_id");
		$this -> db -> where("product_info.product_id", $product_id );
		$query = $this -> db -> get();

		return $query;
	}
	/* Product Details information */
	function return_main_product()
	{
		$this -> db -> select("product_info.product_name,distributor_info.distributor_name,purchase_return_main_product.*");
		$this -> db -> from("distributor_info,product_info,purchase_return_main_product");
		$this -> db -> where("purchase_return_main_product.produ_id=product_info.product_id");
		$this -> db -> where("purchase_return_main_product.distri_id=distributor_info.distributor_id");
		$this -> db -> where("purchase_return_main_product.status=0");
		$query = $this -> db -> get();

		return $query;
	}

	function return_warranty_product($produ_id)
	{
		$this -> db -> select("*");
		$this -> db -> from("purchase_return_warranty_product");
		$this -> db -> where("purchase_return_warranty_product.product_id",$produ_id);
		$this -> db -> where("purchase_return_warranty_product.status=0");
		$query = $this -> db -> get();
		return $query;
	}

	/* Product Warranty Details information */
	function product_info_warranty_details($product_id)
	{
		$this -> db -> select("product_info.product_id,product_info.product_name,bulk_stock_info.stock_amount,warranty_product_list.ip_id,warranty_product_list.sl_no");
		$this -> db -> from("bulk_stock_info,product_info,warranty_product_list");
		$this -> db -> where("bulk_stock_info.product_id=product_info.product_id");
		$this -> db -> where("product_info.product_id=warranty_product_list.product_id");
		$this -> db -> where("warranty_product_list.product_id", $product_id );
		$this -> db -> where("warranty_product_list.status!=3");
		$query = $this -> db -> get();
		return $query;
	}

	/* Distributor information */
	function distributor_info()
	{
		$this -> db -> order_by( "distributor_name", "asc" );
		$query = $this -> db -> get('distributor_info');
		$data[''] =  'Select Distributor Name';
		foreach ($query-> result() as $field){
			$data[$field -> distributor_id] = $field -> distributor_name.' (Mob : '.$field -> distributor_contact_no.'  )';	
		}
		return $data;
	}


	
	public function getAllPurchaseReturnDistributor($purchase_return_id)
	{
	   $this->db->select('distributor_info.distributor_name');
	   $this->db->from('tmp_purchase_return_tbl,distributor_info');
	   $this->db->where('tmp_purchase_return_tbl.distributor_id = distributor_info.distributor_id');
	   $this->db->where('tmp_purchase_return_tbl.tmp_purchase_return_id', $purchase_return_id);
	   $this->db->where('tmp_purchase_return_tbl.status = "active"');
	   $data = $this->db->get();
		if($data->num_rows() > 0)
		{
			$temp = $data->row();
			return $temp->distributor_name;
		}
		else return false;

	}
	public function getAllPurchaseReturnProduct($purchase_return_id)
	{
	   $this->db->select('product_id, product_name, return_quantity, unit_buy_price, total_price,distributor_info.distributor_name');
	   $this->db->from('tmp_purchase_return_tbl, tmp_purchase_return_details_tbl,distributor_info');
	   $this->db->where('tmp_purchase_return_tbl.distributor_id = distributor_info.distributor_id');
	   $this->db->where('tmp_purchase_return_details_tbl.tmp_purchase_return_id', $purchase_return_id);
	   $this->db->where('tmp_purchase_return_tbl.status = "active"');
	   $data = $this->db->get();
		if($data->num_rows() > 0){
			return $data;
		}
		else return false;

	}
	public function createPurchaseReturn_direct($tmp_purchase_id,$creator, $shop_id, $bd_date)
	{
		$is_exists =    $this->db
						->select('tmp_purchase_return_id')
						->where('status = "active"')
						->limit(1)
						->get('tmp_purchase_return_tbl');
		if($is_exists->num_rows() == 0){
		$purchase_re_data = array(
				'tmp_purchase_return_id'        => '',
				'tmp_purchase_id'        => $tmp_purchase_id,
				'tmp_purchase_return_shop_id'   => $shop_id,
				'tmp_purchase_return_creator'   => $creator,
				'status'   					=> 'active',
				'total_amount'              => 0,           //initially 0
				'tmp_purchase_return_doc'       => $bd_date
			);

		$this->db->insert('tmp_purchase_return_tbl', $purchase_re_data);
		return $this->db->insert_id();
		}
		else{
			$tmp = $is_exists->row();
			return $tmp->tmp_purchase_return_id;
		}
	}
	public function get_direct_purchase_return_id()
	{
		$is_exists =    $this->db
						->select('tmp_purchase_return_id')
						->where('status = "active"')
						->limit(1)
						->get('tmp_purchase_return_tbl');
		if($is_exists->num_rows() != 0)
		{
			$tmp = $is_exists->row();
			return $tmp->tmp_purchase_return_id;
		}
		else
		{
			return false;
		}
	}
	public function get_distributor_purchase_return_id()
	{
		$is_exists =    $this->db
						->select('distributor_id')
						->where('status = "active"')
						->limit(1)
						->get('tmp_purchase_return_tbl');
		if($is_exists->num_rows() != 0)
		{
			$tmp = $is_exists->row();
			return $tmp->distributor_id;
		}
		else
		{
			return false;
		}
	}
	public function addToPurchaseReturn($pro_id, $product_name, $unit_price, $qnty, $distributor_id,$purchase_return_id)
	{   
		$total_price = round(($unit_price * $qnty), 2);
		$current_purchase_return_id 	= $this->purchase_model->get_direct_purchase_return_id();
		if($purchase_return_id ==0)
		{
			$data = array(
			'id'                    	=> '',
			'tmp_purchase_return_id'    => 0,
			'distributor_id'    		=> $distributor_id,
			'product_id'            	=> $pro_id,
			'product_name'          	=> $product_name,
			'return_quantity'       	=> $qnty,
			'unit_buy_price'            => $unit_price,
			'total_price'           	=> $total_price
			);

			$this->db->insert('tmp_purchase_return_details_tbl', $data);
			$this->db->set('total_amount', ' total_amount+' . $total_price, FALSE)
				->where('tmp_purchase_return_id', $current_purchase_return_id)
				->update('tmp_purchase_return_tbl');
				
			$data_new = array(
			'distributor_id'    => $distributor_id,
			);
			$this->db->where('tmp_purchase_return_id', $current_purchase_return_id);
			$this->db->update('tmp_purchase_return_tbl',$data_new);
		}
		else
		{
			$data = array(
				'id'                    	=> '',
				'tmp_purchase_return_id'   	=> $purchase_return_id,
				'distributor_id'    		=> $distributor_id,
				'product_id'            	=> $pro_id,
				'product_name'          	=> $product_name,
				'return_quantity'       	=> $qnty,
				'unit_buy_price'            => $unit_price,
				'total_price'           	=> $total_price
				);

			$this->db->insert('tmp_purchase_return_details_tbl', $data);
			$this->db->set('total_amount', ' total_amount+' . $total_price, FALSE)
				->where('tmp_purchase_return_id', $current_purchase_return_id)
				->update('tmp_purchase_return_tbl');
				
			$data_new = array(
			'distributor_id'    => $distributor_id,
			);
			$this->db->where('tmp_purchase_return_id', $current_purchase_return_id);
			$this->db->update('tmp_purchase_return_tbl',$data_new);
		}
	}
	public function doPurchaseReturn($current_purchase_return_id, $creator, $bd_date,$distributor_id)
	{   
		//$lsat_Id = $this->db->insert_id('sale_return_receipt_tbl') + 1;
		
		$status = 'active';
		$sql = $this->db
						->select('product_id, product_name, return_quantity, unit_buy_price, total_price, total_amount, tmp_purchase_return_shop_id')
						->from('tmp_purchase_return_tbl, tmp_purchase_return_details_tbl')
						->where('tmp_purchase_return_tbl.tmp_purchase_return_id = tmp_purchase_return_details_tbl.tmp_purchase_return_id')
						->where('tmp_purchase_return_tbl.status', $status)
						->where('tmp_purchase_return_tbl.tmp_purchase_return_id', $current_purchase_return_id)
						//->where('tmp_purchase_return_tbl.tmp_purchase_return_creator', $creator)
						->get();
		
		if($sql->num_rows() > 0)
		{
			$row_info = $sql->row();
			
			$transaction_info = array(
				'transaction_purpose'   => 'purchase_return',
				'ledger_id'   			=> $distributor_id,
				'amount'   				=> $row_info->total_amount,
				'date'               	=> $bd_date,
				'status'               	=> 'active',
				'creator'               => $creator,
				'doc'       			=> $bd_date,
				'dom'       			=> $bd_date
				);

			$this->db->insert('transaction_info', $transaction_info);
			
			$purchase_return_receipt_data = array(
				'purchase_return_id'        => '',
				'distributor_id'            => $distributor_id,
				'shop_id'               	=> $row_info->tmp_purchase_return_shop_id,
				'total_return_amount'   	=> $row_info->total_amount,
				'status'   					=> 'active',
				'creator'               	=> $creator,
				'purchase_return_doc'       => $bd_date,
				'purchase_return_dom'       => $bd_date
				);

			$this->db->insert('purchase_return_receipt_tbl', $purchase_return_receipt_data);
			$insert_id = $this->db->insert_id();
			foreach($sql->result() as $tmp)
			{
				$purchase_return_details_data = array(
					'id'                	=> '',
					'purchase_return_id'    => $insert_id,
					'product_id'        	=> $tmp->product_id,
					'product_name'      	=> $tmp->product_name,
					'return_quantity'   	=> $tmp->return_quantity,
					'unit_buy_price'   		=> $tmp->unit_buy_price,
					'total_price'       	=> $tmp->total_price,
					'return_doc'        	=> $bd_date,
					'return_dom'        	=> $bd_date
				);
				$this->db->insert('purchase_return_details_tbl', $purchase_return_details_data);

				$this->db->set('stock_amount', 'stock_amount-' . $tmp->return_quantity, FALSE)
							->where('product_id', $tmp->product_id)->update('bulk_stock_info');

			}
			$this->db->where('tmp_purchase_return_id', $current_purchase_return_id)
					->where('tmp_purchase_return_creator', $creator)
					->delete('tmp_purchase_return_tbl');

			$this->db->where('tmp_purchase_return_id', $current_purchase_return_id)->delete('tmp_purchase_return_details_tbl');

			return $insert_id;
		}
		else{
			return false;
		}
	}
	public function getreturnProducts($return_invoice_id)
	{

		$data   =  $this->db
				->select('product_info.product_name, purchase_return_details_tbl.return_quantity,purchase_return_details_tbl.unit_buy_price,purchase_return_details_tbl.total_price, purchase_return_receipt_tbl.purchase_return_id,purchase_return_receipt_tbl.total_return_amount,purchase_return_receipt_tbl.purchase_return_doc, username')
				->from('product_info, purchase_return_details_tbl,users,purchase_return_receipt_tbl')
				->where('purchase_return_receipt_tbl.purchase_return_id = purchase_return_details_tbl.purchase_return_id')
				->where('product_info.product_id = purchase_return_details_tbl.product_id')
				->where('purchase_return_receipt_tbl.creator = users.id')
				->where('purchase_return_receipt_tbl.purchase_return_id', $return_invoice_id)
				->get();

		if($data->num_rows() > 0)return $data;
		else return FALSE;

	}
	public function deleteProductFromPurchaseReturn($purchase_return_id, $product_id)
    {
		$this->db->select('return_quantity,unit_buy_price');
		$this->db->from('tmp_purchase_return_details_tbl');
		$this->db->where('product_id', $product_id);
		$query = $this->db->get();
		$tmp = $query->row();
		
		$this->db->set('total_amount', 'total_amount-' . $tmp->return_quantity * $tmp->unit_buy_price, FALSE)
							->where('tmp_purchase_return_id', $purchase_return_id)->update('tmp_purchase_return_tbl');
		
        $this->db->where('tmp_purchase_return_id', $purchase_return_id)
        ->where('product_id', $product_id)
        ->delete('tmp_purchase_return_details_tbl');
    }
}