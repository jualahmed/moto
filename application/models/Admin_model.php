<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function alltodayinstallment($a='')
	{	
		$date=date("Y-m'd");
		$this->db->where('all_installment.status',1);
		$this->db->where('all_installment.date',$date);
		$this->db->join('sells_log', 'sells_log.id = all_installment.sells_log_id');
		$this->db->join('customer_info', 'customer_info.customer_id = sells_log.customar_id');
		return $this->db->get('all_installment');
	}

	public function backup_database()
	{
		$bd_date = date('Y-m-d');
		$this->load->dbutil();
		if ($this->dbutil->database_exists('dokani'))
		{
		   $prefs = array(
				'tables'      => array(),              // Array of tables to backup.
				'format'      => 'txt',                // gzip, zip, txt
				'add_drop'    => TRUE,                 // Whether to add DROP TABLE statements to backup file
				'add_insert'  => TRUE,                 // Whether to add INSERT data to backup file
				'newline'     => "\n"                  // Newline character used in backup file
			);
			$backup =& $this->dbutil->backup($prefs);
			$path = "D:\\dokani_backup\\".$bd_date;    // For Windows
		    if(!is_dir($path))                         //create the folder if it's not already exists
		    {
		      mkdir($path,0700,TRUE);
		    } 
			$this->load->helper('file');
			write_file($path.'\\dokani.sql', $backup); // For Windows
			return true;
		}
		return false;
	}
}

/* End of file Admin_model.php */
/* Location: ./application/models/Admin_model.php */