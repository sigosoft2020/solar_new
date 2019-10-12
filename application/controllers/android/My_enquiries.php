<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class My_enquiries extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('Android_model','android');
	}
	public function index()
	{
	   $customer_id      = $this->input->post('customer_id');
	   
       $comment_check = $this->Common->get_details('enquiry',array('user_id'=>$customer_id));
       if($comment_check->num_rows()>0)
       {   
            $enquiries  = $this->android->get_enquiries($customer_id);
            $return     = [
                           'status'   => true,
                           'message'  => 'success',
                           'data'     => $enquiries
                         ];
       }
       else
       {
            $return = [
                           'status'   =>  false,
                           'message'  => 'failed',
                           'data'     => ''
                      ];    
        
       }
       print_r(json_encode($return));
	}
   
}
