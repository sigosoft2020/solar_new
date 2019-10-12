<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class How_to_use extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Use_model','use');
	}
	public function index()
	{   
		$this->load->view('admin/manuals/view');
	}

	public function get()
	{
		$result = $this->use->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = $res->product_id;
			$sub_array[] = $res->title;
			$sub_array[] = $res->description;
			$sub_array[] = '<img src="' . base_url() . $res->image . '" height="100px">';
			$sub_array[] = $res->status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:orange" href="' . site_url('admin/how_to_use/edit/'.$res->hw_id) . '"><i class="fa fa-pencil"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->use->get_all_data(),
			"recordsFiltered" => $this->use->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{      
		$this->load->view('admin/manuals/add');
	}

	public function insert_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current 	 = date('Y-m-d H:i:s');
        
        $product_id  = $this->security->xss_clean($this->input->post('product_id'));
	    $title       = $this->security->xss_clean($this->input->post('title'));
	    $description = $this->security->xss_clean($this->input->post('description'));
		$image       = $this->input->post('image');
		$img         = substr($image, strpos($image, ",") + 1);

		$url      = FCPATH.'uploads/how_to_use/';
		$rand     = $title.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path     = "uploads/how_to_use/".$rand.'.png';
		file_put_contents($userpath,base64_decode($img));
		
        $manual_check  = $this->Common->get_details('how_to_use',array('product_id'=>$product_id));
        if($manual_check->num_rows()>0)
        {
             $this->session->set_flashdata('add_error', 'failed');
			 redirect('admin/how_to_use');
        }
        else
        {   
        	$array['product_id']   = $product_id;
		    $array['title']        = $title;
			$array['description']  = $description;
			$array['image']        = $path;
			$array['timestamp']    = $current;
			$array['status']       = 'Active';
			if($this->Common->insert('how_to_use',$array))
			{   
				$this->session->set_flashdata('add_message', 'success');
			    redirect('admin/how_to_use');
			}
			else 
			{
				$this->session->set_flashdata('add_error', 'failed');
				redirect('admin/how_to_use/add');
			}
		}		
	}

	public function edit($id)
	{
		$manual_details = $this->Common->get_details('how_to_use',array('hw_id'=>$id))->row();
		$data['manual']    = $manual_details;
		$this->load->view('admin/manuals/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');
        
        $manual_id   = $this->security->xss_clean($this->input->post('hw_id'));
        $product_id  = $this->security->xss_clean($this->input->post('product_id'));
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
				$old = $this->Common->get_details('how_to_use',array('hw_id' => $manual_id))->row()->image;
				$remove_path = FCPATH . $old;
				unlink($remove_path);
                
                $manual_array['product_id']   = $product_id;  
				$manual_array['title']        = $title;
				$manual_array['description']  = $description;
				$manual_array['image']        = $path;
				$manual_array['status']       = $status;
			}
			else 
			{
				$manual_array['product_id']   = $product_id;  
				$manual_array['title']        = $title;
				$manual_array['description']  = $description;
				$manual_array['status']       = $status;
			}

		if($this->Common->update('hw_id', $manual_id,'how_to_use',$manual_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/how_to_use');
		}
		else 
		{
			$this->session->set_flashdata('edit_error', 'failed');
			redirect('admin/how_to_use/edit/'.$about_id);
		}	
	}
}
