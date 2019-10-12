<?php

class Certificate_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  function get_certificates()
  {
    $this->db->select('*');
    $this->db->from('certificate');
    $this->db->order_by('certificate_id',"desc");
    return $this->db->get()->result();
  }

function make_query()
  {
    $table         = "certificate";
    $select_column = array("certificate_id","certificate_title","certificate_status","certificate_image");
    $order_column  = array(null,"certificate_title",null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    if (isset($_POST["search"]["value"])) 
    {
      $this->db->like("certificate_title",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) 
    {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else 
    {
      $this->db->order_by("certificate_id","desc");
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
    $this->db->from("certificate");
    return $this->db->count_all_results();
  }
	
}

?>
