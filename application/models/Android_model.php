<?php

class Android_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  function get_banners()
  {
    $this->db->select('banner_id,banner_title,banner_image,product_id');
    $this->db->from('banners');
    $this->db->where('banner_status','Active');
    $this->db->order_by('banner_id',"desc");
    return $this->db->get()->result();
  }
  
  function get_how_it_works($id)
  {
    $this->db->select('hw_id as id,product_id,title,description,image');
    $this->db->from('how_to_use');
    $this->db->where('product_id',$id);
    $this->db->where('status','Active');
    return $this->db->get()->result();
  }
  
  function get_how_it_works_data()
  {
    $this->db->select('hw_id as id,product_id,title,description,image');
    $this->db->from('how_to_use');
    $this->db->where('status','Active');
    $this->db->order_by('product_id',"desc");
    return $this->db->get()->result();
  }
  
  function get_certificates()
  {
    $this->db->select('certificate_id,certificate_title,certificate_image');
    $this->db->from('certificate');
    $this->db->where('certificate_status','Active');
    $this->db->order_by('certificate_id',"desc");
    return $this->db->get()->result();
  }
  
  function get_documents()
  {
    $this->db->select('document_id,document_title,document_type,file');
    $this->db->from('documents');
    $this->db->where('document_status','Active');
    return $this->db->get()->result();
  }
  
  function get_about()
  {
    $this->db->select('ab_id as id,title,image,description');
    $this->db->from('about');
    $this->db->where('status','Active');
    return $this->db->get()->row();
  }
  
  function get_image_documents()
  {
    $this->db->select('document_id,document_title,document_type,file');
    $this->db->from('documents');
    $this->db->where('document_type','photo');
    $this->db->where('document_status','Active');
    $this->db->order_by('document_id','desc');
    return $this->db->get()->result();
  }
  
  function get_video_documents()
  {
    $this->db->select('document_id,document_title,document_type,file');
    $this->db->from('documents');
    $this->db->where('document_type','video');
    $this->db->where('document_status','Active');
    $this->db->order_by('document_id','desc');
    return $this->db->get()->result();
  }
  
  function get_audio_documents()
  {
    $this->db->select('document_id,document_title,document_type,file,timestamp');
    $this->db->from('documents');
    $this->db->where('document_type','audio');
    $this->db->where('document_status','Active');
    $this->db->order_by('document_id','desc');
    return $this->db->get()->result();
  }
  
  function get_factsheet_documents()
  {
    $this->db->select('document_id,document_title,document_type,file,size');
    $this->db->from('documents');
    $this->db->where('document_type','fact_sheet');
    $this->db->where('document_status','Active');
    $this->db->order_by('document_id','desc');
    return $this->db->get()->result();
  }
  
  function get_enquiries($id)
  {
    $this->db->select('enquiry_id,category_id,category_name,product_id,product_name,user_id,customer_name,customer_phone,customer_address,comments,response,timestamp');
    $this->db->from('enquiry');
    $this->db->where('user_id',$id);
    $this->db->order_by('enquiry_id','desc');
    return $this->db->get()->result();
  }
  
  function get_faqs()
  {
    $this->db->select('faq_id,faq_title,faq_description,faq_image');
    $this->db->from('faq');
    $this->db->where('faq_status','Active');
    return $this->db->get()->result();
  }
  
  function get_reviews($id)
  {
    $this->db->select('customer_name,product_name,star_rating,product_review');
    $this->db->from('product_reviews');
    $this->db->where('product_id',$id);
    return $this->db->get();
  }
  
  function get_reviews_data()
  {
    $this->db->select('customer_name,product_id,product_name,star_rating,product_review');
    $this->db->from('product_reviews');
    $this->db->order_by('review_id','desc');
    return $this->db->get();
  }
  
  public function get_news_data()
  {
    $this->db->select('news_id,title,description,date,image');
    $this->db->from('news');
    $this->db->where('status','Active');
    $this->db->order_by('news_id','desc');
    return $this->db->get()->result();
  }
  
  public function get_news_by_id($news_id)
  {
    $this->db->select('news_id,title,description,date,image');
    $this->db->from('news');
    $this->db->where('news_id',$news_id);
    $this->db->where('status','Active');
    return $this->db->get()->result();
  }
  
  public function get_news_comments($id)
  {
    $this->db->select('comment_id,news_id,user_id,user_name,comments,date,time');
    $this->db->from('news_comments');
    $this->db->where('news_id',$id);
    return $this->db->get()->result();
  }
  
}

?>
