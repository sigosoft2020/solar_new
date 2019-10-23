<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Chats extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$this->load->model('Chat_model','chat');
	}
	public function index()
	{      
        // $enquiries         = $this->enquiry->get_enquiries(); 
        // $data['enquiries'] = $enquiries;
		$this->load->view('admin/chat/view');
	}

	public function get()
	{
		$result = $this->chat->make_datatables();
		$data = array();
		foreach ($result as $res) {
           if($res->answer=='')
            {
              $status = 'Not answered';
              $answer = '<button type="button" class="btn btn-success" onclick="add(' . $res->ud_id . ',`' . $res->question . '`)"><i class="fa fa-plus"></i></button>';	
            }
            else
            {
             $status = 'Answered';    
             $answer = '<button type="button" class="btn btn-success" onclick="edit(' . $res->ud_id . ',`'.$res->answer .'`,`' . $res->question .'`)"><i class="fa fa-edit"></i></button>';
            }
            
            
			$sub_array = array();
			$sub_array[] = $res->user_name;
			$sub_array[] = $res->question;
			$sub_array[] = $status;
		    $sub_array[] = $answer;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->chat->get_all_data(),
			"recordsFiltered" => $this->chat->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}


	public function add_answer()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

		$question_id   = $this->security->xss_clean($this->input->post('qs_id'));
		$answer         = $this->security->xss_clean($this->input->post('answer'));

        $res['answer']       = $answer;
        $res['ans_date']     = $current;
		if($this->Common->update('ud_id',$question_id,'user_doubts',$res))
	     {  
	        $user_id    = $this->Common->get_details('user_doubts',array('ud_id'=>$question_id))->row()->user_id; 
	        $fcm_check  = $this->Common->get_details('user_fcm',array('user_id'=>$user_id));
	        if($fcm_check->num_rows()>0)
	        {
	            $device_token = $fcm_check->row()->device_token;
	        }
	        else
	        {
	            $device_token = '';
	        }
	        $this->send_notification($device_token);
	        
			$this->session->set_flashdata('message', 'Answer added successfully');
			redirect('admin/chats');
	     }	
	     else 
	     {
			$this->session->set_flashdata('error', 'failed');
    		redirect('admin/chats');
		}	
	}
	
	public function edit_answer()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

		$question_id    = $this->security->xss_clean($this->input->post('qst_id'));
		$answer         = $this->security->xss_clean($this->input->post('ans'));

        $ans['answer']       = $answer;
        $ans['ans_date']     = $current;
		if($this->Common->update('ud_id',$question_id,'user_doubts',$ans))
	     {
			$this->session->set_flashdata('message', 'Answer edited successfully');
			redirect('admin/chats');
	     }	
	     else 
	     {
			$this->session->set_flashdata('error', 'failed');
    		redirect('admin/chats');
		}	
	}
	
	public function send_notification($id)
	{
	    $SERVER_API_KEY = "AAAA5hmcrBM:APA91bH9i1_kd0bM_Z17Ioy-w2FHA1anquuNf7NubJJ3UvD3Z8tGEItyS2pdSKg5fV2LSkuvEGWGwnqk6kpyxyOObQ9PHxIWZ45KPbfeJXwj-ATfCkWGW2OqKPbiLKLJJ3Bu0NDbvaC4";
    	$header = [
    		'Authorization: key='. $SERVER_API_KEY,
    		'Content-Type: Application/json'
    	];
    	$msg = [
    		'title' => 'New message',
    		'body'  => 'You have an new message'
    	];
    	
    	$notification = [
    		'title'             => 'New message',
    		'body'              => 'You have a new message',
    		'content_available' => true
    	];
    	
    	$payload = [
    		'data'         => $msg,
    		'notification' => $notification,
    		'to'           => $id,
    		'priority'     => 10
    	];
    	$url = 'https://fcm.googleapis.com/fcm/send';
    
    	$curl = curl_init();
    
    	curl_setopt_array($curl, array(
    		 CURLOPT_URL            => "https://fcm.googleapis.com/fcm/send",
    		 CURLOPT_RETURNTRANSFER => true,
    		 CURLOPT_CUSTOMREQUEST  => "POST",
    		 CURLOPT_POSTFIELDS     => json_encode($payload),
    		 CURLOPT_HTTPHEADER     => $header,
    	));
    
    	$response = curl_exec($curl);
    	$err = curl_error($curl);
    
    	curl_close($curl);
        
        return true;
	}
}
