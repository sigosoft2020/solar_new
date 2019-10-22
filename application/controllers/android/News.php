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
      $this->load->model('Android_model','android');
  }
  public function index()
  {     
     $news_id = $this->input->post('news_id'); 
       $check   = $this->Common->get_details('news',array('news_id'=>$news_id,'status'=>'Active'));
       if($check->num_rows()>0)
       {
         $details = $this->android->get_news_by_id($news_id);  
         $return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $details
                   ];
       }
       else
       {
        $return = [
                       'status'   => false,
                       'message'  => 'failed',
                       'data'     => ''
                   ];  
       }
       print_r(json_encode($return));
  }
  
  public function get_data()
  {     
       $check = $this->Common->get_details('news',array('status'=>'Active'));
       if($check->num_rows()>0)
       {
         $details = $this->android->get_news_data();  
         $return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => $details
                   ];
       }
       else
       {
        $return = [
                       'status'   => false,
                       'message'  => 'failed',
                       'data'     => ''
                   ];  
       }
       print_r(json_encode($return));
  }
  
    public function add_comments()
  {
     date_default_timezone_set("Asia/Kolkata");
     $current = date('Y-m-d H:i:s');
      
     $customer_id      = $this->security->xss_clean($this->input->post('user_id'));
     $customer_name    = $this->security->xss_clean($this->input->post('user_name'));
     $news_id          = $this->security->xss_clean($this->input->post('news_id'));
     $comments         = $this->security->xss_clean($this->input->post('comments'));
     $date             = date('Y-m-d');
     $time             = date('h:i A');
     
     $comment_array    =[
                           'user_id'          => $customer_id,
                           'user_name'        => $customer_name,
                           'news_id'          => $news_id,
                           'comments'         => $comments,
                           'date'             => $date,
                           'time'             => $time,
                           'timestamp'        => $current
                        ];
    
         if($this->Common->insert('news_comments',$comment_array))  
           {
              $return = [
                           'status'   => true,
                           'message'  => 'success'
                        ];  
           }
          else
           {
              $return = [
                           'status'   => false,
                           'message'  => 'failed to add comments'
                        ];    
           }
       print_r(json_encode($return));
  }
  
  public function comments_by_news()
  {
     $news_id          = $this->security->xss_clean($this->input->post('news_id'));
     $comment_check    = $this->Common->get_details('news_comments',array('news_id'=>$news_id));
     if($comment_check->num_rows()>0)
     {
         $comments     = $this->android->get_news_comments($news_id);
         $return       = [
                           'status'  => true,
                           'message' => 'success',
                           'data'    => $comments
                         ];
     }
     else
     {
         $comments     = '';
         $return       = [
                           'status'  => false,
                           'message' => 'failed',
                           'data'    => $comments
                         ];
     }
     print_r(json_encode($return));
  }

}
