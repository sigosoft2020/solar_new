<?php

class M_completedpolls extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query(){
    $today = date('Y-m-d H:i:s');

    $table = "polls";
    $select_column = array("poll_id","question","end_date","end_time","status");
    $order_column = array(null,"name",null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->where('ts <',$today);
    if (isset($_POST["search"]["value"])) {
      $this->db->like("question",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("poll_id","desc");
    }
  }
  function make_datatables()
  {
    $this->make_query();
    if ($_POST["length"] != -1) {
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
    $today = date('Y-m-d H:i:s');

    $this->db->select("*");
    $this->db->from("polls");
    $this->db->where('ts >=',$today);
    return $this->db->count_all_results();
  }
}

?>
