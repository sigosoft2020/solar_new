<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Enquiry extends CI_Controller {
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
	   $customer_phone   = $this->input->post('customer_phone');
	   $customer_address = $this->input->post('customer_address');
	   $category_id      = $this->input->post('category_id');
	   $category_name    = $this->input->post('category_name');
	   $product_id       = $this->input->post('product_id');
	   $product_name     = $this->input->post('product_name');
	   $comments         = $this->input->post('comments');
	   
	   $comment_array    =[
	                         'category_id'      => $category_id,
	                         'category_name'    => $category_name,
	                         'product_id'       => $product_id,
	                         'product_name'     => $product_name,
	                         'user_id'          => $customer_id,
	                         'customer_name'    => $customer_name,
	                         'customer_phone'   => $customer_phone,
	                         'customer_address' => $customer_address,
	                         'comments'         => $comments,
	                         'timestamp'        => $current
	                      ];
	   
       $comment_check = $this->Common->get_details('enquiry',array('user_id'=>$customer_id,'category_id'=>$category_id,'product_id'=>$product_id,'comments'=>$comments));
       if($comment_check->num_rows()>0)
       {
         $return = [
                       'status'   => false,
                       'message'  => 'already added'
                   ];
       }
       else
       {
         if($this->Common->insert('enquiry',$comment_array))  
           {
              $return = [
                           'status'   => true,
                           'message'  => 'success'
                      ];  
           }
          else
          {
            $return = [
                           'status'   => false,
                           'message'  => 'failed to create enquiry'
                      ];    
          }
       }
       print_r(json_encode($return));
	}
   
}
