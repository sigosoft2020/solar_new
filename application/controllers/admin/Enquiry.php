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
			$this->load->model('M_admin');
			$this->load->model('Enquiry_model','enquiry');
	}
	public function index()
	{      
        // $enquiries         = $this->enquiry->get_enquiries(); 
        // $data['enquiries'] = $enquiries;
		$this->load->view('admin/enquiry/view');
	}

	public function get()
	{
		$result = $this->enquiry->make_datatables();
		$data = array();
		foreach ($result as $res) {
            if($res->response=='')
            {
              $response = '<button type="button" class="btn btn-warning" onclick="add(' . $res->enquiry_id . ',`' . $res->comments . '`)">Add</button>';	
            }
            else
            {
             $response = '<button type="button" class="btn btn-warning" onclick="view(`'.$res->response .'`,`' . $res->comments .'`)">View</button>';
            }

			$sub_array = array();
			$sub_array[] = $res->product_name;
			$sub_array[] = $res->customer_name;
			$sub_array[] = $res->customer_phone;
			$sub_array[] = $res->customer_address;
			$sub_array[] = $response;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->enquiry->get_all_data(),
			"recordsFiltered" => $this->enquiry->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}


	public function add_response()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

		$enq_id   = $this->security->xss_clean($this->input->post('enquiry_id'));
		$response = $this->security->xss_clean($this->input->post('response'));

        $res['response']    = $response;
        $res['updated_at']  = $current;
		if($this->Common->update('enquiry_id',$enq_id,'enquiry',$res))
	     {
			$this->session->set_flashdata('message', 'Response added successfully');
			redirect('admin/enquiry');
	     }	
	     else 
	     {
			$this->session->set_flashdata('error', 'failed');
    		redirect('admin/enquiry');
		}	
	}
}
