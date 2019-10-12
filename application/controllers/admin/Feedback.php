<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Feedback extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Feedback_model','feedback');
	}
	public function index()
	{      
		$this->load->view('admin/feedback/view');
	}
   
    public function get()
	{
		$result = $this->feedback->make_datatables();
		$data   = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = $res->customer_name;
			$sub_array[] = $res->customer_comments;
			$sub_array[] = $res->no_of_stars.'<i class="fa fa-star" style="color:orange"></i>';;
			$sub_array[] = $res->status;
			$sub_array[] = '<button type="button" class="btn btn-link" onclick="edit('.$res->feedback_id.')"><i class="fa fa-pencil" style="font-size:24px;color:orange"></i></a></button>';
			$data[] = $sub_array;
		}

		$output = array(
						"draw"            => intval($_POST['draw']),
						"recordsTotal"    => $this->feedback->get_all_data(),
						"recordsFiltered" => $this->feedback->get_filtered_data(),
						"data"            => $data
						);
		echo json_encode($output);
	}

	public function edit($id)
	{
		$feedback_details   = $this->Common->get_details('feedback',array('feedback_id'=>$id))->row();
		$data['feedback']   = $feedback_details;

		$this->load->view('admin/feedback/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current      = date('Y-m-d H:i:s');
        
        $feedback_id  = $this->security->xss_clean($this->input->post('feedback_id'));
	    $status       = $this->security->xss_clean($this->input->post('status'));
	
		$feedback_array['status']  = $status;
		
		if($this->Common->update('feedback_id', $feedback_id,'feedback',$feedback_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/feedback');
		}
		else 
		{
			$this->session->set_flashdata('edit_error', 'failed');
			redirect('admin/feedback/edit/'.$review_id);
		}	
	}
}
