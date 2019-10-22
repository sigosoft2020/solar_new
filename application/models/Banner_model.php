<?php

class Banner_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  function get_banners()
  {
    $this->db->select('*');
    $this->db->from('banners');
    // $this->db->where('banner_status','Active');
    $this->db->order_by('banner_id',"desc");
    return $this->db->get()->result();
  }

  function make_query()
  {
    $table         = "banners";
    $select_column = array("banner_id","banner_title","banner_status","banner_image","product_id");
    $order_column  = array(null,"banner_title",null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    if (isset($_POST["search"]["value"])) 
    {
      $this->db->like("banner_title",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) 
    {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else 
    {
      $this->db->order_by("banner_id","desc");
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
    $this->db->from("banners");
    return $this->db->count_all_results();
  }
	
}

?>
