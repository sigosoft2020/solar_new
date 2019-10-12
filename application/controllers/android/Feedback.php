<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Feedback extends CI_Controller {
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
	   date_default_timezone_set("Asia/Kolkata");
	   $current = date('Y-m-d H:i:s');
	    
	   $customer_id      = $this->input->post('customer_id');
	   $customer_name    = $this->input->post('customer_name');
	   $no_of_stars      = $this->input->post('no_of_stars');
	   $comments         = $this->input->post('comments');
	   
	   $feedback_array    =[
	                         'customer_id'      => $customer_id,
	                         'customer_name'    => $customer_name,
	                         'customer_comments'=> $comments,
	                         'no_of_stars'      => $no_of_stars,
	                         'status'           => 'Active',
	                         'timestamp'        => $current
	                      ];
	   
       $feedback_check = $this->Common->get_details('feedback',array('customer_id'=>$customer_id));
       if($feedback_check->num_rows()>0)
       {
         $return = [
                       'status'   => false,
                       'message'  => 'already added'
                   ];
       }
       else
       {
         if($this->Common->insert('feedback',$feedback_array))  
           {
              $return = [
                          'status'   =>  true,
                          'message'  => 'success'
                      ];  
           }
          else
           {
              $return = [
                          'status'   =>  false,
                          'message'  => 'failed to add feedback'
                      ];    
           }
       }
       print_r(json_encode($return));
	}
   
}
