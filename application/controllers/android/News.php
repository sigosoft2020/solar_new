<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class News extends CI_Controller {
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
	   $news_id = $this->input->post('news_id'); 
       $check   = $this->Common->get_details('news',array('news_id'=>$news_id,'status'=>'Active'));
       if($check->num_rows()>0)
       {
         $details = $this->android->get_news_by_id($news_id);  
         $return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $details
                   ];
       }
       else
       {
        $return = [
                       'status'   => false,
                       'message'  => 'failed',
                       'data'     => ''
                   ];  
       }
       print_r(json_encode($return));
	}
	
	public function get_data()
	{     
       $check = $this->Common->get_details('news',array('status'=>'Active'));
       if($check->num_rows()>0)
       {
         $details = $this->android->get_news_data();  
         $return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $details
                   ];
       }
       else
       {
        $return = [
                       'status'   => false,
                       'message'  => 'failed',
                       'data'     => ''
                   ];  
       }
       print_r(json_encode($return));
	}

}
