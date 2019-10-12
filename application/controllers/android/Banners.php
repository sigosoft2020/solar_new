<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Banners extends CI_Controller {
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
       $banner_check = $this->Common->get_details('banners',array('banner_status'=>'Active'));
       if($banner_check->num_rows()>0)
       {
         $banners = $this->android->get_banners();  
         $return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $banners
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
