<?php

class Document_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  function get_documents()
  {
    $this->db->select('*');
    $this->db->from('documents');
    $this->db->order_by('document_id',"desc");
    return $this->db->get()->result();
  }

  function make_query()
  {
    $table         = "documents";
    $select_column = array("document_id","document_title","document_status","document_type","file");
    $order_column  = array(null,"document_title",null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    if (isset($_POST["search"]["value"])) 
    {
      $this->db->like("document_title",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) 
    {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else 
    {
      $this->db->order_by("document_id","desc");
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
    $this->db->from("documents");
    return $this->db->count_all_results();
  }
}

?>
