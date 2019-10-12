<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Sms extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Sms_model','sms');
	}
	public function index()
	{      
		$this->load->view('admin/sms/view');
	}
   
    public function get()
	{
		$result = $this->sms->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = $res->title;
			$sub_array[] = $res->link;
			$sub_array[] = $res->status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:orange" href="' . site_url('admin/sms/edit/'.$res->sms_id) . '"><i class="fa fa-pencil"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->sms->get_all_data(),
			"recordsFiltered" => $this->sms->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{      
		$this->load->view('admin/sms/add');
	}

	public function insert_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

	    $title     = $this->security->xss_clean($this->input->post('title'));
	    $link      = $this->security->xss_clean($this->input->post('link'));
		
		$sms_check = $this->Common->get_details('sms_gateway',array('title'=>$title,'link'=>$link));
		if($sms_check->num_rows()>0)
		{
            $this->session->set_flashdata('add_error', 'failed');
			redirect('admin/sms');
		}
        else
        {	
		    $array['title']        = $title;
		    $array['link']         = $link;
		    $array['status']       = 'Active';
			$array['timestamp']    = $current;
			if($this->Common->insert('sms_gateway',$array))
			{   
				$this->session->set_flashdata('add_message', 'success');
			    redirect('admin/sms');
			}
			else 
			{
				$this->session->set_flashdata('error', 'Failed to add');
				redirect('admin/sms/add');
			}	
		}	
	}

	public function edit($id)
	{

		$sms_details   = $this->Common->get_details('sms_gateway',array('sms_id'=>$id))->row();
		$data['sms']   = $sms_details;

		$this->load->view('admin/sms/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');
        
        $sms_id      = $this->security->xss_clean($this->input->post('sms_id'));
	    $title       = $this->security->xss_clean($this->input->post('title'));
	    $link        = $this->security->xss_clean($this->input->post('link'));
	    $status      = $this->security->xss_clean($this->input->post('status'));

        $sms_array['title']   = $title;
	    $sms_array['link']    = $link;
	    $sms_array['status']  = $status;

		if($this->Common->update('sms_id', $sms_id,'sms_gateway',$sms_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/sms');
		}
		else 
		{
			$this->session->set_flashdata('edit_error', 'failed');
			redirect('admin/sms/edit/'.$sms_id);
		}	
	}
}
