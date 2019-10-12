<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Certificates extends CI_Controller {
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
       $certificate_check = $this->Common->get_details('certificate',array('certificate_status'=>'Active'));
       if($certificate_check->num_rows()>0)
       {
         $certificates = $this->android->get_certificates();  
         $return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $certificates
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
