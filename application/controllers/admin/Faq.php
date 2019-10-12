<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Faq extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Faq_model','faq');
	}
	public function index()
	{      
        // $faqs             = $this->faq->get_faqs(); 
        // $data['faqs']     = $faqs;
		$this->load->view('admin/faq/view');
	}
   
    public function get()
	{
		$result = $this->faq->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = $res->faq_title;
			$sub_array[] = $res->faq_description;
// 			$sub_array[] = '<img src="' . base_url() . $res->faq_image . '" height="100px">';
			$sub_array[] = $res->faq_status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:orange" href="' . site_url('admin/faq/edit/'.$res->faq_id) . '"><i class="fa fa-pencil"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->faq->get_all_data(),
			"recordsFiltered" => $this->faq->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{      
		$this->load->view('admin/faq/add');
	}

	public function insert_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

	    $title        = $this->security->xss_clean($this->input->post('title'));
	    $description  = $this->security->xss_clean($this->input->post('description'));
// 		$image        = $this->input->post('image');
// 		$img          = substr($image, strpos($image, ",") + 1);

// 		$url      = FCPATH.'uploads/faq/';
// 		$rand     = $title.date('Ymd').mt_rand(1001,9999);
// 		$userpath = $url.$rand.'.png';
// 		$path     = "uploads/faq/".$rand.'.png';
// 		file_put_contents($userpath,base64_decode($img));
		
		$faq_check = $this->Common->get_details('faq',array('faq_title'=>$title,'faq_description'=>$description));
		if($faq_check->num_rows()>0)
		{
            $this->session->set_flashdata('add_error', 'failed');
			redirect('admin/faq');
		}
        else
        {	
		    $array['faq_title']        = $title;
		    $array['faq_description']  = $description;
// 			$array['faq_image']        = $path;
			$array['timestamp']        = $current;
			$array['faq_status']       = 'Active';
			if($this->Common->insert('faq',$array))
			{   
				$this->session->set_flashdata('add_message', 'success');
			    redirect('admin/faq');
			}
			else 
			{
				
				$this->session->set_flashdata('error', 'Failed to add banner..!');

				redirect('admin/faq/add');
			}	
		}	
	}

	public function edit($id)
	{

		$faq_details = $this->Common->get_details('faq',array('faq_id'=>$id))->row();
		$data['faq']   = $faq_details;


		$this->load->view('admin/faq/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');
        
        $faq_id      = $this->security->xss_clean($this->input->post('faq_id'));
	    $title       = $this->security->xss_clean($this->input->post('title'));
	    $description = $this->security->xss_clean($this->input->post('description'));
	    $status      = $this->security->xss_clean($this->input->post('status'));
		$image       = $this->input->post('image');

		if ($image != '') 
		   {
				$img      = substr($image, strpos($image, ",") + 1);

				$url      = FCPATH.'uploads/faq/';
				$rand     = $title.date('Ymd').mt_rand(1001,9999);
				$userpath = $url.$rand.'.png';
				$path     = "uploads/faq/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				// Remove old image from the server
				$old = $this->Common->get_details('banners',array('banner_id' => $banner_id))->row()->image;
				$remove_path = FCPATH . $old;
				unlink($remove_path);

				$faq_array['faq_title']        = $title;
			    $faq_array['faq_description']  = $description;
				$faq_array['faq_image']        = $path;
				$faq_array['faq_status']       = $status;
			}
			else 
			{
		        $faq_array['faq_title']        = $title;
			    $faq_array['faq_description']  = $description;
				$faq_array['faq_status']       = $status;
			}

		if($this->Common->update('faq_id', $faq_id,'faq',$faq_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/faq');
		}
		else 
		{
			$this->session->set_flashdata('edit_error', 'failed');
			redirect('admin/faq/edit/'.$faq_id);
		}	
	}
}
