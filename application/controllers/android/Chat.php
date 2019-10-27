<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Chat extends CI_Controller {
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
	    
	   $customer_id      = $this->security->xss_clean($this->input->post('user_id'));
	   $username         = $this->security->xss_clean($this->input->post('username'));
	   $messgae          = $this->security->xss_clean($this->input->post('message'));
	   $fcm              = $this->security->xss_clean($this->input->post('fcm'));
	   $date             = date('Y-m-d');
	   $time             = date('H:i A');
	   
	   $array    =[
                     'user_id'          => $customer_id,
                     'user_name'        => $username,
                     'message'          => $messgae,
                     'date'             => $date,
                     'time'             => $time,
                     'user_type'        => 'customer',
                     'timestamp'        => $current
                  ];
	                      
      if($id=$this->Common->insert('messages',$array))  
       {
           $fcm_check        = $this->Common->get_details('user_fcm',array('user_id'=>$customer_id));
    	   if($fcm_check->num_rows()>0)
    	   {
        	    $token    =[
                                 'user_id'          => $customer_id,
                                 'device_token'     => $fcm
                           ]; 
                $this->Common->update('user_id',$customer_id,'user_fcm',$token);
    	   }
    	   else
    	   {
    	       $token  = [
                          'user_id'       => $customer_id,
                          'device_token'  => $fcm,
                          'timestamp'     => $current
                        ];  
               $this->Common->insert('user_fcm',$token);
    	   }
          
          $return = [
                       'status'   => true,
                       'message'  => 'success'
                     
                  ];  
       }
      else
       {
        $return = [
                       'status'   => false,
                       'message'  => 'failed to add question'
                  ];    
       }
       print_r(json_encode($return));
	}
   
}
