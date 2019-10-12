<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class My_documents extends CI_Controller {
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
       $check = $this->Common->get_details('documents',array('document_status'=>'Active'));
       if($check->num_rows()>0)
       { 
         $image_check = $this->Common->get_details('documents',array('document_type'=>'photo','document_status'=>'Active'));
         if($image_check->num_rows()>0)
         {
           $images = $this->android->get_image_documents();  
         }
         else
         {
           $images =[];   
         }
         
         $video_check = $this->Common->get_details('documents',array('document_type'=>'video','document_status'=>'Active'));
         if($video_check->num_rows()>0)
         {
           $videos = $this->android->get_video_documents();
           foreach($videos as $video)
           {
             $url                =  $video->file; 
             $video->embeded_url =  $this->getYoutubeEmbedUrl($url);
           }
         }
         else
         {
           $videos =[];   
         }
         
         $audio_check = $this->Common->get_details('documents',array('document_type'=>'audio','document_status'=>'Active'));
         if($audio_check->num_rows()>0)
         {
           $audio = $this->android->get_audio_documents();
           foreach($audio as $a)
           {
             $a->time = date('h:i A',strtotime($a->timestamp));  
           }
         }
         else
         {
           $audio =[];   
         }
         
         $sheet_check = $this->Common->get_details('documents',array('document_type'=>'fact_sheet','document_status'=>'Active'));
         if($sheet_check->num_rows()>0)
         {
           $fact_sheet = $this->android->get_factsheet_documents();  
         }
         else
         {
           $fact_sheet =[];   
         }
         
         $return = [
                       'status'   => true,
                       'message'  => 'success',
                       'data'     => [
                                       'photos'     => $images,
                                       'videos'     => $videos,
                                       'audios'     => $audio,
                                       'fact_sheet' => $fact_sheet
                                     ]
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
	
	function getYoutubeEmbedUrl($url)
	{
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';
    
        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
    
        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$youtube_id.'" frameborder="0" allowfullscreen></iframe> ' ;
   }

}
