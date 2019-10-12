<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Calls extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Call_model','call');
	}
	public function index()
	{      
		$this->load->view('admin/call/view');
	}
   
    public function get()
	{
		$result = $this->call->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = $res->call_title;
			$sub_array[] = $res->phonenumber;
			$sub_array[] = $res->call_status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:orange" href="' . site_url('admin/calls/edit/'.$res->call_id) . '"><i class="fa fa-pencil"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
							"draw"            => intval($_POST['draw']),
							"recordsTotal"    => $this->call->get_all_data(),
							"recordsFiltered" => $this->call->get_filtered_data(),
							"data"            => $data
						);
		echo json_encode($output);
	}

	public function add()
	{      
		$this->load->view('admin/call/add');
	}

	public function insert_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

	    $title        = $this->security->xss_clean($this->input->post('title'));
	    $phonenumber  = $this->security->xss_clean($this->input->post('phonenumber'));

		$call_check   = $this->Common->get_details('call_button',array('call_title'=>$title,'phonenumber'=>$phonenumber));
		if($call_check->num_rows()>0)
		{
            $this->session->set_flashdata('add_error', 'failed');
			redirect('admin/calls');
		}
        else
        {	
		    $array['call_title']    = $title;
		    $array['phonenumber']   = $phonenumber;
			$array['timestamp']     = $current;
			$array['call_status']   = 'Active';
			if($this->Common->insert('call_button',$array))
			{   
				$this->session->set_flashdata('add_message', 'success');
			    redirect('admin/calls');
			}
			else 
			{
			  $this->session->set_flashdata('error', 'Failed');
			  redirect('admin/calls/add');
			}	
		}	
	}

	public function edit($id)
	{

		$call_details   = $this->Common->get_details('call_button',array('call_id'=>$id))->row();
		$data['call']   = $call_details;

		$this->load->view('admin/call/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current      = date('Y-m-d H:i:s');
        
        $call_id      = $this->security->xss_clean($this->input->post('call_id'));
        $title        = $this->security->xss_clean($this->input->post('title'));
	    $phonenumber  = $this->security->xss_clean($this->input->post('phonenumber'));
	    $status       = $this->security->xss_clean($this->input->post('status'));
	
        $call_array['call_title']        = $title;
	    $call_array['phonenumber']       = $phonenumber;
		$call_array['call_status']       = $status;
		
		if($this->Common->update('call_id', $call_id,'call_button',$call_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/calls');
		}
		else 
		{
			$this->session->set_flashdata('edit_error', 'failed');
			redirect('admin/calls/edit/'.$call_id);
		}	
	}
}
