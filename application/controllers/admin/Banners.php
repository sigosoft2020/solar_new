<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Banners extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Banner_model','banner');
	}
	public function index()
	{      
        // $banners         = $this->banner->get_banners(); 
        // $data['banners'] = $banners;
		$this->load->view('admin/banner/view');
	}

	public function get()
	{
		$result = $this->banner->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = $res->banner_title;
			$sub_array[] = '<img src="' . base_url() . $res->banner_image . '" height="100px">';
			$sub_array[] = $res->banner_status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:orange" href="' . site_url('admin/banners/edit/'.$res->banner_id) . '"><i class="fa fa-pencil"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->banner->get_all_data(),
			"recordsFiltered" => $this->banner->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{      
		$this->load->view('admin/banner/add');
	}

	public function insert_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

	    $title  = $this->security->xss_clean($this->input->post('title'));
		$image  = $this->input->post('image');
		$img    = substr($image, strpos($image, ",") + 1);

		$url      = FCPATH.'uploads/banner/';
		$rand     = $title.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path     = "uploads/banner/".$rand.'.png';
		file_put_contents($userpath,base64_decode($img));
		
        $banner_check = $this->Common->get_details('banners',array('banner_title'=>$title));
        if($banner_check->num_rows()>0)
        {
            $this->session->set_flashdata('add_error', 'failed');
			redirect('admin/banners');
        }
        else 
        {
		    $array['banner_title']        = $title;
			$array['banner_image']        = $path;
			$array['timestamp']           = $current;
			$array['banner_status']       = 'Active';
			if($this->Common->insert('banners',$array))
			{   
				$this->session->set_flashdata('message', 'success');
			    redirect('admin/banners');
			}
			else 
			{
				
				$this->session->set_flashdata('error', 'Failed to add banner..!');
				redirect('admin/banners/add');
			}	
		}	
	}

	public function edit($id)
	{

		$banner_details = $this->Common->get_details('banners',array('banner_id'=>$id))->row();
		$data['banner']   = $banner_details;


		$this->load->view('admin/banner/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');
        
        $banner_id   = $this->security->xss_clean($this->input->post('banner_id'));
	    $title       = $this->security->xss_clean($this->input->post('title'));
	    $status      = $this->security->xss_clean($this->input->post('status'));
		$image       = $this->input->post('image');

		if ($image != '') 
		   {
				$img      = substr($image, strpos($image, ",") + 1);

				$url      = FCPATH.'uploads/banner/';
				$rand     = $title.date('Ymd').mt_rand(1001,9999);
				$userpath = $url.$rand.'.png';
				$path     = "uploads/banner/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				// Remove old image from the server
				$old = $this->Common->get_details('banners',array('banner_id' => $banner_id))->row()->banner_image;
				$remove_path = FCPATH . $old;
				unlink($remove_path);

				$banner_array['banner_title']        = $title;
				$banner_array['banner_image']        = $path;
				$banner_array['banner_status']       = $status;
			}
			else 
			{
				$banner_array['banner_title']        = $title;
				$banner_array['banner_status']       = $status;
			}

		if($this->Common->update('banner_id', $banner_id,'banners',$banner_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/banners');
		}
		else 
		{
			$this->session->set_flashdata('edit_failed', 'Failed');
			redirect('admin/banners/edit/'.$banner_id);
		}	
	}
}
