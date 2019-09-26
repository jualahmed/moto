<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sale extends MY_Controller {
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
		$data['vuejscomp'] = 'new_sale.js';
		$this->__renderview('Sale/new_sale',$data);	
	}

	public function search($query='')
	{	
		$query=$this->input->get('query');
		$data=$this->sale_model->search($query);
		echo json_encode($data);
	}

	public function new_sale()
	{	
		$date=$this->input->post('date');
		$w_product_id=$this->input->post('w_product_id');
		$installmentdate=$this->input->post('installmentdate');
		if(isset($installmentdate)){
			$nextdate= date('Y-m-d',strtotime($installmentdate[0]));
		}else{
			$nextdate=null;
		}

		$creator = $this->tank_auth->get_user_id();
		$data=array(
			'id'=>$this->input->post('id'),
			'product_id'=>$this->input->post('product_id'),
			'w_product_id'=>$w_product_id,
			'price'=>$this->input->post('price'),
			'discount'=>$this->input->post('discount'),
			'screchcard'=>$this->input->post('screchcard'),
			'advancepay'=>$this->input->post('advancepay'),
			'installmentfee'=>$this->input->post('installmentfee'),
			'finalamount'=>$this->input->post('finalamount'),
			'month'=>$this->input->post('month'),
			'totalkisti'=>$this->input->post('month'),
			'totaldue'=>$this->input->post('totaldue'),
			'totalinterest'=>$this->input->post('totalinterest'),
			'totalinterastlog'=>$this->input->post('totalinterest'),
			'permonthpay'=>$this->input->post('permonthpay'),
			'date'=>$date,
			'seconddate'=>$nextdate,
			'alldate'=>json_encode($installmentdate),
			'remarks'=>$this->input->post('remarks'),
			'key'=>$this->input->post('key'),	
			'referencename'=>$this->input->post('referencename'),
			'referenccontact'=>$this->input->post('referenccontact'),
			'customar_id'=>$this->input->post('customar_id'),
			'product_id'=>$this->input->post('product_id'),
			'creator' => $creator,
		);
		$this->sale_model->updatestock($data['product_id']);

		$this->db->set('status',1);
		$this->db->where('ip_id', $w_product_id);
		$this->db->update('warranty_product_list');

		$id=$this->sale_model->create($data);
		$d=array('id'=>$id,'data'=>$data);
		echo json_encode($d);
	}

	public function collection($value='')
	{		
		$id=$this->input->post('id');
		if(!$id){
			$id=$value;
		}
		$data['id']=0;
		if($id){
			$data['invoiceinfo']=$this->sale_model->find($id);
			$data['id']=$id;
		}
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'collection.js';
		echo $id;
		$this->__renderview('Sale/collection',$data);	
	}

	public function invoiceprint($d)
    {	
    	$id=$d;
    	$data['all']=$this->sale_model->find($id);
		$this->load->view('Prints/saleinvoice1', $data);
    }

    public function insinvoiceprint($d)
    {	
    	$id=$d;
    	$data['all']=$this->sale_model->findinstallmentsinvoice($id);
		$this->load->view('Prints/moneyrecept', $data);
    }

    public function paymentnow($id='')
    {	
		$data['id']=0;
		if($id){
			$data['id']=$id;
			$data['invoiceinfo']=$this->sale_model->find($id);
			$data['perdaylatecost']=$this->config_model->perdaycost();
			$invoice=$data['invoiceinfo'];
			$today=date('Y-m-d');
			$date1=date_create($invoice[0]->seconddate);
			$date2=date_create($today);
			if($date2>$date1){
				$diff=date_diff($date1,$date2);
				$data['totaldif']= $diff->format("%a");
			}else{
				$data['totaldif']=0;
			}
		}
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'collection.js';
		$data['paymentnow'] = '1';
		$this->__renderview('Sale/collection',$data);	
    }

    public function increase($id='')
    {	
		$data['id']=0;
		if($id){
			$data['id']=$id;

			$data['invoiceinfo']=$this->sale_model->find($id);
			$data['perdaylatecost']=$this->config_model->perdaycost();
			$invoice=$data['invoiceinfo'];
			$today=date('Y-m-d');
			$date1=date_create($invoice[0]->seconddate);
			$date2=date_create($today);
			if($date2>$date1){
				$diff=date_diff($date1,$date2);
				$data['totaldif']= $diff->format("%a");
			}else{
				$data['totaldif']=0;
			}
		}
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'collection.js';
		$data['increaseordecrease'] = '1';
		$this->__renderview('Sale/collection',$data);	
    }

    public function installmentsubmit($id='')
    {
    	$invoiceinfo=$this->sale_model->updateinvoice($id);
    	if($invoiceinfo){
    		$this->session->set_flashdata('success', 'Installments Payment Successfully Done');
    		redirect('sale/collection','refresh');
    	}
    }

    public function submitincress($id='')
    {
    	$month=$this->input->post('month');
    	$installmentfee=$this->input->post('installmentfee');
    	$alldate=$this->input->post('installmentdate');
    	$withinterest=$this->input->post('withinterest');
    	$invoiceinfo=$this->sale_model->updateInstallment($id,$month,$alldate,$withinterest,$installmentfee);
		$data['id']=0;
		if($id){
			$data['invoiceinfo']=$this->sale_model->find($id);
			$data['id']=$id;
		}
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'collection.js';
		echo json_encode($invoiceinfo);
    }

    public function salelogbycustomar($value='')
    {
    	$this->db->where('customar_id', $value);
    	$this->db->join('product_info', 'product_info.product_id = sells_log.product_id');
    	$this->db->join('warranty_product_list', 'warranty_product_list.ip_id = sells_log.w_product_id');
    	$this->db->join('purchase_receipt_info', 'purchase_receipt_info.receipt_id = warranty_product_list.purchase_receipt_id');
    	$data=$this->db->get('sells_log')->result();
    	echo json_encode($data);
    }

    public function insdate($value='')
    {	
    	$id=$this->input->get('id');
    	$date=$this->input->get('date');
    	$sale=0;
    	if($id){
    		$this->db->where('id', $id);
    		$sale=$this->db->get('sells_log')->row();
    	}
    	$data=array();
    	for ($i=1; $i <=$value; $i++) { 
    		if($id){
				$result = $this->add($sale->date, $i);
    		}else if($date){
				$result = $this->add($date, $i);
    		}else{
				$result = $this->add(date('Y-m-d'), $i);

    		}
			array_push($data, $result->format('Y-m-d'));
		}
		echo json_encode($data);
    }

    public function add($date_str, $months)
	{
	    $date = new DateTime($date_str);
	    // We extract the day of the month as $start_day
	    $start_day = $date->format('j');
	    // We add 1 month to the given date
	    $date->modify("+{$months} month");
	    // We extract the day of the month again so we can compare
	    $end_day = $date->format('j');
	    if ($start_day != $end_day)
	    {
	        // The day of the month isn't the same anymore, so we correct the date
	        $date->modify('last day of last month');
	    }
	    return $date;
	}
}

/* End of file Sale.php */
/* Location: ./application/controllers/Sale.php */