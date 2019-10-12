<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Send_otp extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
	}
	public function index()
	{
	   $mobile      = $this->input->post('mobile');
	   $otp         = $this->input->post('otp');
	   $hashkey     = $this->input->post('hashkey');
	   
       $resp = file_get_contents("http://sms.moplet.com/api/sendhttp.php?authkey=1351AQBvZMqXG4fB5ca5c8c5&mobiles=".$mobile."&message=Your%OTP%20code%20is:%20".$otp."%20".$hashkey."&sender=HAJICW&route=4&country=0");
       if($resp)
       {   
            $return     = [
                           'status'   => true,
                           'message'  => 'OTP has been sent to your mobile number'
                         ];
       }
       else
       {
            $return = [
                           'status'   =>  false,
                           'message'  => 'failed'
                      ];    
       }
       print_r(json_encode($return));
	}
   
}
