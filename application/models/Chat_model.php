<?php

class Chat_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  function get_enquiries()
  {
    $this->db->select('*');
    $this->db->from('user_doubts');
    $this->db->order_by('ud_id',"desc");
    return $this->db->get()->result();
  }
 
 function make_query()
  {
    $table         = "user_doubts";
    $select_column = array("ud_id","user_name","question","answer","qs_date");
    $order_column  = array(null,"user_name","question",null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    if (isset($_POST["search"]["value"])) 
    {
      $this->db->like("user_name",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) 
    {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else 
    {
      $this->db->order_by("ud_id","desc");
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
    $this->db->from("user_doubts");
    return $this->db->count_all_results();
  }	
}

?>
