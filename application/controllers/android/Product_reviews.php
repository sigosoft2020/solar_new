<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Product_reviews extends CI_Controller {
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
	   $product_id       = $this->input->post('product_id');
	   $product_name     = $this->input->post('product_name');
	   $order_no         = $this->input->post('order_no');
	   $no_of_stars      = $this->input->post('no_of_stars');
	   $comments         = $this->input->post('comments');
	   
	   $review_array    =[
	                         'order_no'         => $order_no,
	                         'customer_id'      => $customer_id,
	                         'customer_name'    => $customer_name,
	                         'product_id'       => $product_id,
	                         'product_name'     => $product_name,
	                         'product_review'   => $comments,
	                         'star_rating'      => $no_of_stars,
	                         'status'           => 'Active',
	                         'timestamp'        => $current
	                      ];
	   
       $review_check = $this->Common->get_details('product_reviews',array('customer_id'=>$customer_id,'product_id'=>$product_id));
       if($review_check->num_rows()>0)
       {
         $return = [
                       'status'   => false,
                       'message'  => 'already added'
                   ];
       }
       else
       {
         if($this->Common->insert('product_reviews',$review_array))  
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
                          'message'  => 'failed to add reviews'
                      ];    
           }
       }
       print_r(json_encode($return));
	}
	
	public function get()
	{
	    $product_id      = $this->input->post('product_id');
	    $review_check    = $this->android->get_reviews($product_id);
	    
	    if($review_check->num_rows()>0)
	    {
	       $reviews =   $review_check->result();
	       $return = [
                          'status'   =>  true,
                          'message'  => 'success',
                          'data'     => $reviews
                      ];  
	    }
	    else
	    {
	       $reviews =   '';
	       $return = [
                          'status'   =>  false,
                          'message'  => 'failed',
                          'data'     => $reviews
                      ];    
	    }
	    print_r(json_encode($return));
	}
	
	public function reviews()
	{
	    $reviews_check    = $this->android->get_reviews_data();
	    
	    if($reviews_check->num_rows()>0)
	    {
	       $review =   $reviews_check->result();
	       $return = [
                          'status'   =>  true,
                          'message'  => 'success',
                          'data'     => $review
                      ];  
	    }
	    else
	    {
	       $review =   '';
	       $return = [
                          'status'   =>  false,
                          'message'  => 'failed',
                          'data'     => $review
                      ];    
	    }
	    print_r(json_encode($return));
	}
   
}
