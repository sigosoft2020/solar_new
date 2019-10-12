<?php

class M_admin extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  function getBooking()
  {
    $this->db->select('*');
    $this->db->from('booking_enquiry');
    $this->db->order_by('booking_id',"desc");
    return $this->db->get()->result();
  }
  
  function getImages()
  {
    $this->db->select('*');
    $this->db->from('gallery');
    $this->db->order_by('gallery_id',"desc");
    return $this->db->get()->result();
  }
  
   function getBrands()
  {
    $this->db->select('*');
    $this->db->from('brand');
    $this->db->order_by('brand_id',"desc");
    return $this->db->get()->result();
  }
  
  function getVehicles()
  {
    $this->db->select('*');
    $this->db->from('vehicles');
    $this->db->order_by('vehicle_id',"desc");
    return $this->db->get()->result();
  }
	
	function getEnquiries()
  {
    $this->db->select('*');
    $this->db->from('contact');
    $this->db->order_by('contact_id',"desc");
    return $this->db->get()->result();
  }
	
}

?>
