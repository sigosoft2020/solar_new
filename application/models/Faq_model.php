<?php

class Faq_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  function get_faqs()
  {
    $this->db->select('*');
    $this->db->from('faq');
    // $this->db->where('banner_status','Active');
    $this->db->order_by('faq_id',"desc");
    return $this->db->get()->result();
  }

 function make_query()
  {
    $table         = "faq";
    $select_column = array("faq_id","faq_title","faq_description","faq_status","faq_image");
    $order_column  = array(null,"faq_title",null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    if (isset($_POST["search"]["value"])) 
    {
      $this->db->like("faq_title",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) 
    {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else 
    {
      $this->db->order_by("faq_id","desc");
    }
  }

  function make_datatables()
  {
    $this->make_query();
    if ($_POST["length"] != -1) 
    {
      $this->db->limit($_POST["length"],$_POST["start"]);
    }
    $query = $this->db->get();
    return $query->result();
  }

  function get_filtered_data()
  {
    $this->make_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  function get_all_data()
  {
    $this->db->select("*");
    $this->db->from("faq");
    return $this->db->count_all_results();
  }

	
}

?>
