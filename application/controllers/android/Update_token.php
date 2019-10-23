<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Update_token extends CI_Controller {
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
	   $fcm              = $this->security->xss_clean($this->input->post('fcm'));
	   
	   $fcm_check        = $this->Common->get_details('user_fcm',array('user_id'=>$customer_id));
	   if($fcm_check->num_rows()>0)
	   {
    	       $array    =[
                             'user_id'          => $customer_id,
                             'device_token'     => $fcm
                          ];
    	                      
         if($this->Common->update('user_id',$customer_id,'user_fcm',$array))  
           {
              $return = [
                           'status'   => true,
                           'message'  => 'success',
                      ];  
           }
          else
           {
            $return = [
                           'status'   => false,
                           'message'  => 'failed to update device token'
                      ];    
           }
	   }
	   else
	   {
	        $return = [
                           'status'   => false,
                           'message'  => 'no data'
                      ];    
	   }
	   
       print_r(json_encode($return));
	}
   
}
