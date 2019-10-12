<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class About extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('About_model','about');
	}
	public function index()
	{      
        // $about         = $this->about->get_about(); 
        // $data['about'] = $about;
		$this->load->view('admin/about/view');
	}

	public function get()
	{
		$result = $this->about->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = $res->title;
			$sub_array[] = $res->description;
			$sub_array[] = '<img src="' . base_url() . $res->image . '" height="100px">';
			$sub_array[] = $res->status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:orange" href="' . site_url('admin/about/edit/'.$res->ab_id) . '"><i class="fa fa-pencil"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->about->get_all_data(),
			"recordsFiltered" => $this->about->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{      
		$this->load->view('admin/about/add');
	}

	public function insert_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

	    $title       = $this->security->xss_clean($this->input->post('title'));
	    $description = $this->security->xss_clean($this->input->post('description'));
		$image = $this->input->post('image');
		$img = substr($image, strpos($image, ",") + 1);

		$url = FCPATH.'uploads/about/';
		$rand = $title.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/about/".$rand.'.png';
		file_put_contents($userpath,base64_decode($img));
		
        $about_check  = $this->Common->get_details('about',array('title'=>$title,'description'=>$description));
        if($about_check->num_rows()>0)
        {
             $this->session->set_flashdata('add_error', 'failed');
			 redirect('admin/about');
        }
        else
        {
		    $array['title']        = $title;
			$array['description']  = $description;
			$array['image']        = $path;
			$array['timestamp']    = $current;
			$array['status']       = 'Active';
			if($this->Common->insert('about',$array))
			{   
				$this->session->set_flashdata('add_message', 'success');
			    redirect('admin/about');
			}
			else 
			{
				$this->session->set_flashdata('add_error', 'failed');
				redirect('admin/about/add');
			}
		}		
	}

	public function edit($id)
	{
		$about_details = $this->Common->get_details('about',array('ab_id'=>$id))->row();
		$data['abt']   = $about_details;
		$this->load->view('admin/about/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');
        
        $about_id    = $this->security->xss_clean($this->input->post('abt_id'));
        $description = $this->security->xss_clean($this->input->post('description'));
	    $title       = $this->security->xss_clean($this->input->post('title'));
	    $status      = $this->security->xss_clean($this->input->post('status'));
		$image       = $this->input->post('image');

		if ($image != '') 
		   {
				$img      = substr($image, strpos($image, ",") + 1);

				$url      = FCPATH.'uploads/about/';
				$rand     = $title.date('Ymd').mt_rand(1001,9999);
				$userpath = $url.$rand.'.png';
				$path     = "uploads/about/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				// Remove old image from the server
				$old = $this->Common->get_details('about',array('ab_id' => $about_id))->row()->image;
				$remove_path = FCPATH . $old;
				unlink($remove_path);

				$about_array['title']        = $title;
				$about_array['description']  = $description;
				$about_array['image']        = $path;
				$about_array['status']       = $status;
			}
			else 
			{
				$about_array['title']        = $title;
				$about_array['description']  = $description;
				$about_array['status']       = $status;
			}

		if($this->Common->update('ab_id', $about_id,'about',$about_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/about');
		}
		else 
		{
			$this->session->set_flashdata('edit_error', 'failed');
			redirect('admin/about/edit/'.$about_id);
		}	
	}
}
