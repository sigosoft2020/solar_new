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
        $users = $this->chat->select_user();
        foreach($users as $user)
        {   
        	$last            = $this->chat->get_lastdata($user->user_id);
        	$user->last_mssg = $last->message;
        	$user->last_time = $last->time;
        	$user->unread    = $this->chat->get_unread($user->user_id);
        	$user->messages  = $this->chat->get_messages($user->user_id);
        }
        // print_r($user);
        $data['users'] = $users;
		$this->load->view('admin/chat/view',$data);
	}

	public function addchat()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');
        $date    = date('Y-m-d');
        $time    = date('h:i A');

		$user_id     = $this->security->xss_clean($this->input->post('user_id'));
		$message     = $this->security->xss_clean($this->input->post('message'));

        $array       = [
        	             'user_id'  => $user_id,
        	             'message'  => $message,
        	             'user_type'=> 'admin',
        	             'date'     => $date,
        	             'time'     => $time,
        	             'timestamp'=> $timestamp
                       ];
		if($this->Common->insert('messages',$array))
	     {  
	        $fcm_check  = $this->Common->get_details('user_fcm',array('user_id'=>$user_id));
	          if($fcm_check->num_rows()>0)
	        {
	            $device_token = $fcm_check->row()->device_token;
	            
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
                        		'to'           => $device_token,
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
                
                // return true;
	        }
	        
	        
			$this->session->set_flashdata('message', 'message sent successfully');
			redirect('admin/chats');
	     }	
	     else 
	     {
			$this->session->set_flashdata('error', 'failed');
    		redirect('admin/chats');
		}	
	}
	
	public function status_change()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $current = date('Y-m-d H:i:s');

		$user_id    = $this->security->xss_clean($this->input->post('user_id'));
		
        $sts        = [
        	            'status'  => 'read'
                      ];

		if($this->Common->update('user_id',$user_id,'messages',$sts))
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
