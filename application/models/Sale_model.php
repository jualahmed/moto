<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_model extends CI_Model {

    public function __construct()
    {
    	parent::__construct();
    	//Do your magic here
    }

    public function search($query='')
	{
		return $this->db->query("SELECT * FROM product_info INNER JOIN  bulk_stock_info ON  bulk_stock_info.product_id = product_info.product_id INNER JOIN  warranty_product_list ON  warranty_product_list.product_id = product_info.product_id WHERE (`chassisno` RLIKE ' +$query') OR `chassisno` LIKE '$query%' AND warranty_product_list.status=0")->result();
	}

	public function updatestock($product_id)
	{
		$this->db->set('stock_amount', 'stock_amount-1',FALSE);
		$this->db->where('product_id', $product_id);
		return $this->db->update('bulk_stock_info'); 
	}

	public function create($data='')
	{
		$this->db->insert('sells_log', $data);
   	 	$id= $this->db->insert_id();

   	 	$this->db->where('id', $id);
   	 	$add=$this->db->get('sells_log')->row();
   	 	if($add->alldate!="null"){
	   	 	foreach (json_decode($add->alldate) as $key => $value) {
				$data1=array(
					'sells_log_id'=>$id,
					'date'=>$value,
					'amount'=>$add->permonthpay,
				);
				$this->db->insert('all_installment', $data1);
			}
		}

   	 	$object=array(
			'shop_id'=>1,
			'sells_log_id'=>$id,
			'payment_mode'=>'cash',
			'invoice_creator'=>$data['creator'],
			'totalamount'=>$data['advancepay'],
		);
		$this->db->insert('invoice_info', $object);
		$bd_date=$data['date'];

		if($data['advancepay']>0){
			$payment_info = array
			(
			   'transaction_purpose'                => 'collection',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> $data['customar_id'],
			   'common_id'         					=> $id,
			   'amount'     						=> $data['advancepay'],
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $data['creator'],
			);
			$this->db->insert('transaction_info', $payment_info);
			$insert_id = $this->db->insert_id();
			$cash_book = array(
			   'cb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'transaction_type'                	=> 'in',
			   'amount'                 			=> $data['advancepay'],
			   'date'         						=> $bd_date,
			   'status'    	 						=> 'active',
			   'creator'                   			=> $data['creator'],
			);
			$this->db->insert('cash_book', $cash_book);
		}
		if($data['installmentfee']>0){
			$installmentfee = array
			(
			   'transaction_purpose'                => 'installmentfee',
			   'transaction_mode'                 	=> '',
			   'ledger_id'         					=> $data['customar_id'],
			   'common_id'         					=> $id,
			   'amount'     						=> $data['installmentfee'],
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $data['creator'],
			);
			$this->db->insert('transaction_info', $installmentfee);

			$cash_book = array(
			   'cb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'transaction_type'                	=> 'in',
			   'amount'                 			=> $$data['installmentfee'],
			   'date'         						=> $bd_date,
			   'status'    	 						=> 'active',
			   'creator'                   			=> $data['creator'],
			);
			$this->db->insert('cash_book', $cash_book);
		}
		if($data['price']>0){
			$sale = array
			(
			   'transaction_purpose'                => 'sale',
			   'transaction_mode'                 	=> '',
			   'ledger_id'         					=> $data['customar_id'],
			   'common_id'         					=> $id,
			   'amount'     						=> $data['price'],
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $data['creator'],
			);
			$this->db->insert('transaction_info', $sale);
		}
		if($data['discount']>0){
			$discount = array
			(
			   'transaction_purpose'                => 'discount',
			   'transaction_mode'                 	=> '',
			   'ledger_id'         					=> $data['customar_id'],
			   'common_id'         					=> $id,
			   'amount'     						=> $data['discount'],
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $data['creator'],
			);
			$this->db->insert('transaction_info', $discount);
		}
		if($data['screchcard']>0){
			$screchcard = array
			(
			   'transaction_purpose'                => 'screchcard',
			   'transaction_mode'                 	=> '',
			   'ledger_id'         					=> $data['customar_id'],
			   'common_id'         					=> $id,
			   'amount'     						=> $data['screchcard'],
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $data['creator'],
			);
			$this->db->insert('transaction_info', $screchcard);
		}
		if($data['totalinterest']>0){
			$totalinterest = array
			(
			   'transaction_purpose'                => 'interestsale',
			   'transaction_mode'                 	=> '',
			   'ledger_id'         					=> $data['customar_id'],
			   'common_id'         					=> $id,
			   'amount'     						=> $data['totalinterest'],
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $data['creator'],
			);
			$this->db->insert('transaction_info', $totalinterest);
		}
		return $id;
	}

	public function find($id='')
	{	
		$this->db->select('sells_log.*,product_info.*,warranty_product_list.*,customer_info.*,users.*, sells_log.id as sid');
		$this->db->where('sells_log.id',$id);
		$this->db->join('product_info','product_info.product_id = sells_log.product_id');
		$this->db->join('customer_info','customer_info.customer_id = sells_log.customar_id');
		$this->db->join('warranty_product_list','warranty_product_list.ip_id = sells_log.w_product_id');
		$this->db->join('users','users.id = sells_log.creator');
		return $this->db->get('sells_log')->result();
	}

	public function findinstallmentsinvoice($id='')
	{	
		$this->db->select('sells_log.*,product_info.*,warranty_product_list.*,customer_info.*,users.*,invoice_info.*, sells_log.id as sid,purchase_receipt_info.*');
		$this->db->where('sells_log_id',$id);
		$this->db->join('sells_log','sells_log.id = invoice_info.sells_log_id');
		$this->db->join('product_info','product_info.product_id = sells_log.product_id');
		$this->db->join('warranty_product_list','warranty_product_list.ip_id = sells_log.w_product_id');
		$this->db->join('purchase_receipt_info','purchase_receipt_info.receipt_id = warranty_product_list.purchase_receipt_id');
		$this->db->join('customer_info','customer_info.customer_id = sells_log.customar_id');
		$this->db->join('users','users.id = invoice_info.invoice_creator');
		$this->db->order_by('invoice_info.invoice_id', 'desc');
		$this->db->limit(1);
		return $this->db->get('invoice_info')->row();
	}

	public function updateinvoice($id='')
	{	
		$array=array();
		$munisefee=$this->input->get('munisefee');
    $amount=$this->input->get('amount');
		$payment_date=$this->input->get('payment_date');
		$finaldiscount=$this->input->get('finaldiscount');
		if($munisefee>0){
			$amount=$amount-$munisefee;
		}
		$this->db->where('id',$id);
		$data=$this->db->get('sells_log')->row();

		if($finaldiscount>0){
			$this->db->set('discount', 'discount+'.$finaldiscount,FALSE);
			$this->db->set('finalamount', 'finalamount-'.$finaldiscount,FALSE);
			$this->db->set('totaldue', 'totaldue-'.$finaldiscount,FALSE);
			$this->db->where('id', $id);
			$this->db->update('sells_log'); 
		}

		$this->db->where('date', $data->seconddate);
		$this->db->where('sells_log_id', $data->id);
		$allins=$this->db->get('all_installment')->row();
    $this->db->set('status', 0);
		$this->db->set('payment_date', $payment_date);
		$this->db->where('all_installment_id', $allins->all_installment_id);
		$this->db->update('all_installment');

		foreach (json_decode($data->alldate) as $key => $value) {
			if($key==0){
				continue;
			}else{
				array_push($array, $value);
			}
		}


		$totaldue=$data->totaldue/$data->totalkisti;
		$seconddate= $array[0];
		$totalinterest=$data->totalinterest/$data->totalkisti;
		if($totalinterest>0){
			$amount=$amount-$totalinterest;
		}
		$this->db->set('totalkisti', 'totalkisti-1',FALSE);
		$this->db->set('seconddate', $seconddate);
		$this->db->set('alldate', json_encode($array));
		$this->db->set('totaldue', 'totaldue-'.$amount,FALSE);
		$this->db->set('totalinterest', 'totalinterest-'.$totalinterest,FALSE);
		$this->db->where('id', $id);
		$this->db->update('sells_log'); 

		$creator = $this->tank_auth->get_user_id();

		$this->db->where('id',$id);
		$data1=$this->db->get('sells_log')->row();

		$object=array(
			'shop_id'=>1,
			'sells_log_id'=>$data1->id,
			'payment_mode'=>'cash',
			'invoice_creator'=>$creator,
			'totalamount'=>$amount+$totalinterest+$munisefee,
		);
		$this->db->insert('invoice_info', $object);
		$invoid=$this->db->insert_id();
		$bd_date=date('Y-m-d');
		// Transaction info
		$payment_info = array
		(
		   'transaction_purpose'                => 'collection',
		   'transaction_mode'                 	=> 'cash',
		   'ledger_id'         					=> $data1->customar_id,
		   'common_id'         					=> $data1->id,
		   'sub_id'         					=> $invoid,
		   'amount'     						=> $amount,
		   'date'                   			=> $bd_date,
		   'status'        						=> 'active',
		   'creator'        					=> $creator,
		);
		$this->db->insert('transaction_info', $payment_info);
		$insert_id = $this->db->insert_id();
		$cash_book = array(
		   'cb_id'         						=> '',
		   'transaction_id'                     => $insert_id,
		   'transaction_type'                	=> 'in',
		   'amount'                 			=> $amount,
		   'date'         						=> $bd_date,
		   'status'    	 						=> 'active',
		   'creator'                   			=> $creator,
		);
		$this->db->insert('cash_book', $cash_book);

		if($munisefee>0){
			$payment_info = array
			(
			   'transaction_purpose'                => 'latefeecollection',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> $data1->customar_id,
			   'common_id'         					=> $data1->id,
			   'sub_id'         					=> $invoid,
			   'amount'     						=> $munisefee,
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			);
			$this->db->insert('transaction_info', $payment_info);
			$insert_id = $this->db->insert_id();
			$cash_book = array(
			   'cb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'transaction_type'                	=> 'in',
			   'amount'                 			=> $munisefee,
			   'date'         						=> $bd_date,
			   'status'    	 						=> 'active',
			   'creator'                   			=> $creator,
			);
			$this->db->insert('cash_book', $cash_book);
		}

		if($totalinterest>0){
			$payment_info = array
			(
			   'transaction_purpose'                => 'interestcollection',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> $data1->customar_id,
			   'common_id'         					=> $data1->id,
			   'sub_id'         					=> $invoid,
			   'amount'     						=> $totalinterest,
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			);
			$this->db->insert('transaction_info', $payment_info);
			$idssssssss = $this->db->insert_id();
			$cash_book = array(
			   'cb_id'         						=> '',
			   'transaction_id'                     => $idssssssss,
			   'transaction_type'                	=> 'in',
			   'amount'                 			=> $totalinterest,
			   'date'         						=> $bd_date,
			   'status'    	 						=> 'active',
			   'creator'                   			=> $creator,
			);
			$this->db->insert('cash_book', $cash_book);
		}

		return 1;
	}

	public function updateInstallment($id='',$month,array $alldate,$withinterest='',$installmentfee='')
	{	
		$salelogeidddddddddddddddddddddd=$id;
		$alddddddddd=$alldate;
		$creator = $this->tank_auth->get_user_id();
		$this->db->where('id',$id);
		$data=$this->db->get('sells_log')->row();

		if($data->installmentfee==0 && $installmentfee>0){
			$this->db->where('id', $id);
			$this->db->set('installmentfee','installmentfee +'.$installmentfee,FALSE);
			$this->db->set('finalamount','finalamount +'.$installmentfee,FALSE);
			$this->db->set('totaldue','totaldue +'.$installmentfee,FALSE);
			$this->db->update('sells_log');
		}

		if (!$withinterest && $data->installmentfee>0) {
			$currentinstallmentfee=$data->installmentfee;
			$this->db->where('id', $salelogeidddddddddddddddddddddd);
			$this->db->set('installmentfee','installmentfee -'.$currentinstallmentfee,FALSE);
			$this->db->set('finalamount','finalamount -'.$currentinstallmentfee,FALSE);
			$this->db->set('totaldue','totaldue -'.$currentinstallmentfee,FALSE);
			$this->db->update('sells_log');
		}

		$this->db->where('id',$id);
		$data=$this->db->get('sells_log')->row();

		$configdata=$this->db->get('config')->row();
		$totalinterest=0;
		$notpaidyetinterst=0;
		$permonthpay=0;
		$months=0;
		$totalkisti=0;
		$gap=0;

		$donekm=$data->month-$data->totalkisti;
		for ($i=0; $i <$donekm ; $i++) { 
			array_shift($alldate);
		}

		if($month>0){
			$donekm=$data->month-$data->totalkisti;
			$nm=$month-$donekm;
			$interast=($data->finalamount*$configdata->rate)/100;
    		$interast=$interast/12;
    		$interast=$interast*$month;
    		if($withinterest){
    			$totalinterest=$interast;
    			$this->db->where('transaction_purpose', 'totalinterest');
    			$this->db->where('common_id', $id);
    			$d=$this->db->get('transaction_info')->row();
    			if(count($d)>0){
    				$this->db->set('amount',$totalinterest);
    				$this->db->set('creator',$creator);
    				$this->db->where('transaction_id', $d->transaction_id);
    				$this->db->update('transaction_info');
    			}else{
    				$totalinterest = array
					(
					   'transaction_purpose'                => 'totalinterest',
					   'transaction_mode'                 	=> '',
					   'ledger_id'         					=> $data->customar_id,
					   'common_id'         					=> $id,
					   'amount'     						=> $totalinterest,
					   'date'                   			=> date('Y-m-d'),
					   'status'        						=> 'active',
					   'creator'        					=> $creator,
					);
					$idddddddddd=$this->db->insert('transaction_info', $totalinterest);
					$cash_book = array(
					   'cb_id'         						=> '',
					   'transaction_id'                     => $idddddddddd,
					   'transaction_type'                	=> 'in',
					   'amount'                 			=> $installmentfee,
					   'date'         						=> date("y-m-d"),
					   'status'    	 						=> 'active',
					   'creator'                   			=> $creator,
					);
					$this->db->insert('cash_book', $cash_book);
    			}

    		}else{
    			$totalinterest=0;
    			$this->db->where('transaction_purpose', 'totalinterest');
    			$this->db->where('common_id', $id);
    			$d=$this->db->get('transaction_info')->row();
    			if(count($d)>0){
    				$this->db->set('amount',$totalinterest);
    				$this->db->set('creator',$creator);
    				$this->db->where('transaction_id', $d->transaction_id);
    				$this->db->update('transaction_info');
    			}
    		}
    		$oldpermontinterst=$data->totalinterastlog/$data->month;
    		$notpaidyetinterst=$totalinterest-($oldpermontinterst*($data->month-$data->totalkisti));
    		$gap=$nm;
    		$permonthpay=($data->totaldue+$notpaidyetinterst)/$nm;
			$months=$month;
			$totalkisti=$nm;
		}

		// insert and update all installment table
		if($month>$data->month){
			for($i=0;$i<$month;$i++) {
				if($data->month>$i){
					continue;
				}else{
					$data1=array(
						'sells_log_id'=>$id,
						'date'=>$alddddddddd[$i],
						'amount'=>$permonthpay,
					);
					$this->db->insert('all_installment', $data1);
				}
			}
		}else{
			$abc=json_decode($data->alldate[$i]);
			for($i=0;$i<$data->month;$i++) {
				if($month>$i){
					$this->db->where('sells_log_id', $id);
					$this->db->where('date', $alldate[$i]);
					$this->db->where('status', 1);
					$ddddd=$this->db->get('all_installment')->row();
					$data1=array(
						'amount'=>$permonthpay,
					);
					$this->db->where('all_installment_id', $ddddd->all_installment_id);
					$this->db->update('all_installment', $data1);
				}else{
					$this->db->where('sells_log_id', $id);
					$this->db->order_by('all_installment_id', 'desc');
					$gggggg=$this->db->get('all_installment')->row();
					$this->db->where('all_installment_id', $gggggg->all_installment_id);
					$this->db->delete('all_installment');
				}
			}
		}
		$this->db->set('totalinterest', $notpaidyetinterst);
		$this->db->set('totalinterastlog', $totalinterest);
		$this->db->set('permonthpay', $permonthpay);
		$this->db->set('month', $months);
		$this->db->set('totalkisti', $totalkisti);
		$this->db->set('seconddate', $alldate[0]);
		$this->db->set('alldate', json_encode($alldate));
		$this->db->set('gap', $gap);
		$this->db->where('id', $salelogeidddddddddddddddddddddd);
		return $this->db->update('sells_log'); 
	}
}

/* End of file Sale_model.php */
/* Location: ./application/models/Sale_model.php */