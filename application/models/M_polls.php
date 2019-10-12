<?php

class M_polls extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
 function upcoming()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select('polls.poll_id,question');
    $this->db->from('polls');
    $this->db->where('ts >',$today);
    $this->db->where('status','1');
    return $this->db->get();
  }
  function checkPoll($id,$poll_id)
  {
    $this->db->select('opt_id');
    $this->db->from('results');
    $this->db->where('poll_id',$poll_id);
    $this->db->where('member_id',$id);
    $get = $this->db->get();

    if ($get->num_rows() > 0) {
      return $get->row()->opt_id;
    }
    else {
      return false;
    }
  }
  function getOptions($poll_id)
  {
    $this->db->select('opt_id,option_name');
    $this->db->from('poll_options');
    $this->db->where('poll_id',$poll_id);
    $get = $this->db->get()->result();
    return $get;
  }
  function completed()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select('polls.poll_id,question');
    $this->db->from('polls');
    $this->db->where('ts <=',$today);
    $this->db->where('status','1');
    return $this->db->get();
  }
  function getTotal($poll_id)
  {
    $this->db->select('*');
    $this->db->from('results');
    $this->db->where('poll_id',$poll_id);
    return $this->db->count_all_results();
  }
  function getTotalOfOption($opt_id)
  {
    $this->db->select('*');
    $this->db->from('results');
    $this->db->where('opt_id',$opt_id);
    return $this->db->count_all_results();
  }

  function make_query(){
    $today = date('Y-m-d H:i:s');

    $table = "polls";
    $select_column = array("poll_id","question","end_date","end_time","ts","status");
    $order_column = array(null,"question",null,null,null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->where('status','1');
    $this->db->where('ts >=',$today);
    if (isset($_POST["search"]["value"])) {
      $this->db->like("question",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("end_date","asc");
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
    $this->db->where('status','1');
    $this->db->where('ts >=',$today);
    return $this->db->count_all_results();
  }
}

?>
