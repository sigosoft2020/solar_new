<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Documents extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Document_model','document');
	}
	public function index()
	{      
        // $documents         = $this->document->get_documents(); 
        // $data['documents'] = $documents;
		$this->load->view('admin/document/view');
	}
    
   public function get()
	{
		$result = $this->document->make_datatables();
		$data = array();
		foreach ($result as $res) {
            
             if($res->document_type=='photo') 
	    	  {
	    	  	$type = "Image";
	    	  	$file = '<img src="' . base_url() . $res->file . '" height="100px">';
	    	  }
	    	  elseif($res->document_type=='video')
	    	  {
	    	  	$type =  "Video";
	    	  	$file = $res->file;
	    	  }
	    	  elseif($res->document_type=='audio')
	    	  {
	    	  	$type =  "Audio";
	    	  	$file = '<audio controls><source src="'. base_url() . $res->file .'" type="audio/mpeg"></audio>';
	    	  }
	    	  else
	    	  {
	    	  	$type =  "Fact Sheet";
                $file = '<a href="'. base_url() . $res->file .'"><img src="http://localhost/solar/assets/images/pdf.png" width="60" height="60"></a>';
	    	  }

			$sub_array   = array();
			$sub_array[] = $res->document_title;
			$sub_array[] = $type;
			$sub_array[] = $file;
			$sub_array[] = $res->document_status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;color:orange" href="' . site_url('admin/documents/edit/'.$res->document_id) . '"><i class="fa fa-pencil"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->document->get_all_data(),
			"recordsFiltered" => $this->document->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{      
		$this->load->view('admin/document/add');
	}

	public function insert_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

	    $title  = $this->security->xss_clean($this->input->post('title'));
	    $type   = $this->security->xss_clean($this->input->post('type'));
		$image  = $this->input->post('image');
        $sheet  =  $_FILES['fact_sheet'];
        $video  =  $this->security->xss_clean($this->input->post('video'));
        $audio  =  $_FILES['audio'];

        if($image != '')
        {
	        $img      = substr($image, strpos($image, ",") + 1);
			$url      = FCPATH.'uploads/documents/';
			$rand     = $title.date('Ymd').mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path     = "uploads/documents/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));
			$file     = $path;
			$size     ='';
        }
		elseif($sheet['name'] != '')
		{
			$sheet_tar       = "uploads/documents/";
			$sheet_rand      = $title.date('Ymd').mt_rand(1001,9999);
			$sheet_tar_file  = $sheet_tar .$sheet_rand.basename($sheet['name']);
			move_uploaded_file($sheet["tmp_name"], $sheet_tar_file);     
			$file            = $sheet_tar_file;
			$size            = number_format($sheet['size'] / 1024, 2) . ' KB';
		}
		elseif($audio['name'] != '')
		{
			$audio_tar       = "uploads/documents/";
			$audio_rand      = $title.date('Ymd').mt_rand(1001,9999);
			$audio_tar_file  = $audio_tar .$audio_rand.basename($audio['name']);
			move_uploaded_file($audio["tmp_name"], $audio_tar_file);  
			$file            = $audio_tar_file;
			$size            = '';
		}
        else
        {
            $file             = $video;
            $size             = '';
        }
       
        $document_check  = $this->Common->get_details('documents',array('document_title'=>$title,'document_type'=>$type));
        if($document_check->num_rows()>0)
        {
            $this->session->set_flashdata('add_error', 'failed');
			redirect('admin/documents');
        }
        else
        {	
		    $array['document_title']           = $title;
		    $array['size']                     = $size;
			$array['document_type']            = $type;
			$array['file']                     = $file;
			$array['timestamp']                = $current;
			$array['document_status']          = 'Active';
			if($this->Common->insert('documents',$array))
			{   
				$this->session->set_flashdata('add_message', 'success');
			    redirect('admin/documents');
			}
			else 
			{			
				$this->session->set_flashdata('add_error', 'Failed to add certificate..!');
				redirect('admin/documents/add');
			}	
		}	
	}

	public function edit($id)
	{

		$document_details   = $this->Common->get_details('documents',array('document_id'=>$id))->row();
		$data['document']   = $document_details;

		$this->load->view('admin/document/edit',$data);
	}

	public function update_data()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');
        
        $document_id   = $this->security->xss_clean($this->input->post('document_id'));
	    $title         = $this->security->xss_clean($this->input->post('title'));
	    $status        = $this->security->xss_clean($this->input->post('status'));
	    $type   	   = $this->security->xss_clean($this->input->post('type'));
		$image  	   = $this->input->post('image');
        $sheet  	   =  $_FILES['fact_sheet'];
        $video  	   =  $this->security->xss_clean($this->input->post('video'));
        $audio  	   =  $_FILES['audio'];
        
        // print_r($image); 

		 if ($image != '') 
		   {
				$img      = substr($image, strpos($image, ",") + 1);

				$url      = FCPATH.'uploads/documents/';
				$rand     = $title.date('Ymd').mt_rand(1001,9999);
				$userpath = $url.$rand.'.png';
				$path     = "uploads/documents/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				// // Remove old image from the server
				$old = $this->Common->get_details('documents',array('document_id' => $document_id))->row()->file;
				$remove_path = FCPATH . $old;
				unlink($remove_path);

				$document_array['file']                  = $path;
				$document_array['document_title']        = $title;
				$document_array['document_type']         = $type;
				$document_array['document_status']       = $status;
	        }
	      elseif($sheet['name'] != '')
			{
				$sheet_tar       = "uploads/documents/";
				$sheet_rand      = $title.date('Ymd').mt_rand(1001,9999);
				$sheet_tar_file  = $sheet_tar .$sheet_rand.basename($sheet['name']);
				move_uploaded_file($sheet["tmp_name"], $sheet_tar_file);     
				
				$document_array['file']                  = $sheet_tar_file;
				$document_array['document_title']        = $title;
				$document_array['document_type']         = $type;
				$document_array['document_status']       = $status;
			}
		 elseif($audio['name'] != '')
			{
				$audio_tar       = "uploads/documents/";
				$audio_rand      = $title.date('Ymd').mt_rand(1001,9999);
				$audio_tar_file  = $audio_tar .$audio_rand.basename($audio['name']);
				move_uploaded_file($audio["tmp_name"], $audio_tar_file);  
				
				$document_array['file']    				 = $audio_tar_file;
				$document_array['document_title']        = $title;
				$document_array['document_type']         = $type;
				$document_array['document_status']       = $status;
			}
		 elseif($video != '')	
		   {
		   	    $document_array['file']    				 = $video;
				$document_array['document_title']        = $title;
				$document_array['document_type']         = $type;
				$document_array['document_status']       = $status;
		   }	
	      else
	       {
	            $document_array['document_title']        = $title;
				$document_array['document_type']         = $type;
				$document_array['document_status']       = $status;
	       }

		if($this->Common->update('document_id', $document_id,'documents',$document_array))
		  {   
			$this->session->set_flashdata('edit_message', 'success');
		    redirect('admin/documents');
		  }
		else 
		  {
			$this->session->set_flashdata('edit_failed', 'Failed');
			redirect('admin/certificate/edit/'.$certificate_id);
		  }	
	}
}
