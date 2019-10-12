<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Faq extends CI_Controller {
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
       $faq_check = $this->Common->get_details('faq',array('faq_status'=>'Active'));
       if($faq_check->num_rows()>0)
       {
         $faqs = $this->android->get_faqs();  
         $return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $faqs
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
