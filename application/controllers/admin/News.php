<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class News extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('News_model','news');
	}
	public function index()
	{      
		$this->load->view('admin/news/view');
	}
   
    public function get()
	{
		$result = $this->news->make_datatables();
		$data = array();
		foreach ($result as $res) {
			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->image . '" height="100px">';
			$sub_array[] = $res->title;
			$sub_array[] = $res->description;
			$date        = date('d-M-Y',strtotime($res->date));
			$sub_array[] = $date;
			$sub_array[] = $res->status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:orange" href="' . site_url('admin/news/edit/'.$res->news_id) . '"><i class="fa fa-pencil"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->news->get_all_data(),
			"recordsFiltered" => $this->news->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{      
		$this->load->view('admin/news/add');
	}

	public function insert_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

	    $title        = $this->security->xss_clean($this->input->post('title'));
	    $description  = $this->security->xss_clean($this->input->post('description'));
	    $date         = $this->security->xss_clean($this->input->post('date'));
		$image        = $this->input->post('image');
		$img          = substr($image, strpos($image, ",") + 1);

		$url      = FCPATH.'uploads/news/';
		$rand     = $title.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path     = "uploads/news/".$rand.'.png';
		file_put_contents($userpath,base64_decode($img));
		
		$news_check = $this->Common->get_details('news',array('title'=>$title,'description'=>$description,'date'=>$date));
		if($news_check->num_rows()>0)
		{
            $this->session->set_flashdata('add_error', 'failed');
			redirect('admin/faq');
		}
        else
        {	
		    $array['title']        = $title;
		    $array['description']  = $description;
			$array['image']        = $path;
			$array['date']         = $date;
			$array['timestamp']    = $current;
			$array['status']       = 'Active';
			if($this->Common->insert('news',$array))
			{   
				$this->session->set_flashdata('add_message', 'success');
			    redirect('admin/news');
			}
			else 
			{
				$this->session->set_flashdata('error', 'Failed to add news..!');
				redirect('admin/news/add');
			}	
		}	
	}

	public function edit($id)
	{
		$news_details = $this->Common->get_details('news',array('news_id'=>$id))->row();
		$data['news']   = $news_details;

		$this->load->view('admin/news/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');
        
        $news_id     = $this->security->xss_clean($this->input->post('news_id'));
	    $title       = $this->security->xss_clean($this->input->post('title'));
	    $description = $this->security->xss_clean($this->input->post('description'));
	    $date        = $this->security->xss_clean($this->input->post('date'));
	    $status      = $this->security->xss_clean($this->input->post('status'));
		$image       = $this->input->post('image');

		if ($image != '') 
		   {
				$img      = substr($image, strpos($image, ",") + 1);

				$url      = FCPATH.'uploads/news/';
				$rand     = $title.date('Ymd').mt_rand(1001,9999);
				$userpath = $url.$rand.'.png';
				$path     = "uploads/news/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				// Remove old image from the server
				$old = $this->Common->get_details('news',array('news_id' => $news_id))->row()->image;
				$remove_path = FCPATH . $old;
				unlink($remove_path);

				$news_array['title']        = $title;
			    $news_array['description']  = $description;
			    $news_array['date']         = $date;
				$news_array['image']        = $path;
				$news_array['status']       = $status;
			}
			else 
			{
		        $news_array['title']        = $title;
			    $news_array['description']  = $description;
			     $news_array['date']        = $date;
				$news_array['status']       = $status;
			}

		if($this->Common->update('news_id', $news_id,'news',$news_array))
		{   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/news');
		}
		else 
		{
			$this->session->set_flashdata('edit_error', 'failed');
			redirect('admin/news/edit/'.$news_id);
		}	
	}
}
