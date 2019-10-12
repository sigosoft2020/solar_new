<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Certificate extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Certificate_model','certificate');
	}
	public function index()
	{      
		$this->load->view('admin/certificate/view');
	}

	public function add()
	{      
		$this->load->view('admin/certificate/add');
	}

	public function get()
	{
		$result = $this->certificate->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = $res->certificate_title;
			$sub_array[] = '<img src="' . base_url() . $res->certificate_image . '" height="100px">';
			$sub_array[] = $res->certificate_status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:orange" href="' . site_url('admin/certificate/edit/'.$res->certificate_id) . '"><i class="fa fa-pencil"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->certificate->get_all_data(),
			"recordsFiltered" => $this->certificate->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function insert_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

	    $title  = $this->security->xss_clean($this->input->post('title'));
		$image  = $this->input->post('image');
		$img    = substr($image, strpos($image, ",") + 1);

		$url      = FCPATH.'uploads/certificate/';
		$rand     = $title.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path     = "uploads/certificate/".$rand.'.png';
		file_put_contents($userpath,base64_decode($img));
		 
		$certificate_check = $this->Common->get_details('certificate',array('certificate_title'=>$title));
		if($certificate_check->num_rows()>0)   
		{
            $this->session->set_flashdata('add_error', 'failed');
			redirect('admin/certificate');
		}
		else
		{	
		    $array['certificate_title']        = $title;
			$array['certificate_image']        = $path;
			$array['timestamp']                = $current;
			$array['certificate_status']       = 'Active';
			if($this->Common->insert('certificate',$array))
			{   
				$this->session->set_flashdata('message', 'success');
			    redirect('admin/certificate');
			}
			else 
			{
				
				$this->session->set_flashdata('error', 'Failed to add certificate..!');
				redirect('admin/certificate/add');
			}
		}		
	}

	public function edit($id)
	{

		$certificate_details   = $this->Common->get_details('certificate',array('certificate_id'=>$id))->row();
		$data['certificate']   = $certificate_details;

		$this->load->view('admin/certificate/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');
        
        $certificate_id   = $this->security->xss_clean($this->input->post('certificate_id'));
	    $title            = $this->security->xss_clean($this->input->post('title'));
	    $status           = $this->security->xss_clean($this->input->post('status'));
		$image            = $this->input->post('image');

		if ($image != '') 
		   {
				$img      = substr($image, strpos($image, ",") + 1);

				$url      = FCPATH.'uploads/certificate/';
				$rand     = $title.date('Ymd').mt_rand(1001,9999);
				$userpath = $url.$rand.'.png';
				$path     = "uploads/certificate/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				// Remove old image from the server
				$old = $this->Common->get_details('certificate',array('certificate_id' => $certificate_id))->row()->certificate_image;
				$remove_path = FCPATH . $old;
				unlink($remove_path);

				$certificate_array['certificate_title']        = $title;
				$certificate_array['certificate_image']        = $path;
				$certificate_array['certificate_status']       = $status;
			}
			else 
			{
				$certificate_array['certificate_title']        = $title;
				$certificate_array['certificate_status']       = $status;
			}

		if($this->Common->update('certificate_id', $certificate_id,'certificate',$certificate_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/certificate');
		}
		else 
		{
			$this->session->set_flashdata('edit_failed', 'Failed');
			redirect('admin/certificate/edit/'.$certificate_id);
		}	
	}
}
