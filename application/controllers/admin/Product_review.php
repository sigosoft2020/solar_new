<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Product_review extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Review_model','review');
	}
	public function index()
	{      
		$this->load->view('admin/review/view');
	}
   
    public function get()
	{
		$result = $this->review->make_datatables();
		$data   = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = $res->order_no;
			$sub_array[] = $res->customer_name;
			$sub_array[] = $res->product_name;
			$sub_array[] = $res->product_review;
			$sub_array[] = $res->star_rating.'<i class="fa fa-star" style="color:orange"></i>';;
			$sub_array[] = $res->status;
			$sub_array[] = '<button type="button" class="btn btn-link" onclick="edit('.$res->review_id.',`' . $res->status .'`)"><i class="fa fa-pencil" style="font-size:24px;color:orange"></i></a></button>';

			$data[] = $sub_array;
		}

		$output = array(
						"draw"            => intval($_POST['draw']),
						"recordsTotal"    => $this->review->get_all_data(),
						"recordsFiltered" => $this->review->get_filtered_data(),
						"data"            => $data
						);
		echo json_encode($output);
	}

	public function edit($id)
	{
		$review_details   = $this->Common->get_details('product_reviews',array('review_id'=>$id))->row();
		$data['review']   = $review_details;

		$this->load->view('admin/review/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current      = date('Y-m-d H:i:s');
        
        $review_id    = $this->security->xss_clean($this->input->post('review_id'));
	    $status       = $this->security->xss_clean($this->input->post('status'));
	
		$review_array['status']  = $status;
		
		if($this->Common->update('review_id', $review_id,'product_reviews',$review_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/product_review');
		}
		else 
		{
			$this->session->set_flashdata('edit_error', 'failed');
			redirect('admin/product_review/edit/'.$review_id);
		}	
	}
}
