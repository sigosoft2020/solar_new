<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Dashboard extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('Dashboard_model','dash');
	}
	public function index()
	{   
	    $enquiries = $this->Common->get_details('enquiry',array('response'=>''))->num_rows();
	    $data['enquiries'] = $enquiries;
	    
	    $documents = $this->Common->get_details('documents',array())->num_rows();
	    $data['documents'] = $documents;
	    
	    $feedbacks = $this->Common->get_details('feedback',array())->num_rows();
	    $data['feedback'] = $feedbacks;
	    
	    $reviews = $this->Common->get_details('product_reviews',array())->num_rows();
	    $data['reviews'] = $reviews;
	    
	    $latest_enquiries = $this->dash->get_enquiries();
	    $data['enquiry']  = $latest_enquiries;
	    
	    $latest_reviews = $this->dash->get_reviews();
	    $data['review']  = $latest_reviews;
	    
	    $latest_feedbacks = $this->dash->get_feedbacks();
	    $data['feedbacks']  = $latest_feedbacks;
	    
		$this->load->view('admin/dashboard',$data);
	}
}
