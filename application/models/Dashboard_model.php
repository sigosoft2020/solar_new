<?php

class Dashboard_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  function get_enquiries()
  {
    $this->db->select('*');
    $this->db->from('enquiry');
    $this->db->order_by('enquiry_id',"desc");
    $this->db->limit('5');
    return $this->db->get()->result();
  }
  
  function get_reviews()
  {
    $this->db->select('*');
    $this->db->from('product_reviews');
    $this->db->order_by('review_id',"desc");
    $this->db->limit('5');
    return $this->db->get()->result();
  }
  
  function get_feedbacks()
  {
    $this->db->select('*');
    $this->db->from('feedback');
    $this->db->order_by('feedback_id',"desc");
    $this->db->limit('5');
    return $this->db->get()->result();
  }

  
}

?>
