<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Messages extends CI_Controller {
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
	   $limit            = $this->security->xss_clean($this->input->post('count'));
	   
	   $message_check        = $this->Common->get_details('user_doubts',array('user_id'=>$customer_id));
	   if($message_check->num_rows()>0)
	   {  
	      $messages =  $this->android->get_messages($customer_id,$limit);
	      foreach($messages as $message)
	      {
	          $message->question_date = date('Y-m-d',strtotime($message->qs_date));
	          $message->question_time = date('H:i A',strtotime($message->qs_date));
	          if($message->answer=='')
	          {
	            $message->answer_date ='';
	            $message->answer_time ='';
	          }
	          else
	          {
	            $message->answer_date   = date('Y-m-d',strtotime($message->ans_date));
	            $message->answer_time   = date('H:i A',strtotime($message->ans_date));  
	          }
	          
	      }
          $return   = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $messages
                      ];  
       }
       else
       { 
          $messages = ''; 
          $return   = [
                       'status'   => false,
                       'message'  => 'failed',
                       'data'     => $messages
                      ];    
       }
       print_r(json_encode($return));
	}
   
}
