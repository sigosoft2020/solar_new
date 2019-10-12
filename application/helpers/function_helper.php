<?php
  function pr($data)
  {
    echo "<pre>";
	  print_r($data);
	  echo "</pre>";
	  die();
  }
  function is_login()
  {
    $ci =& get_instance();
	  $ci->load->library('session');
	  $user = $ci->session->userdata('app_user');
    if (isset($user)) {
      if ($user['type'] == 'admin') {
        return 'admin';
      }
      elseif($user['type'] == 'vendor'){
        return 'vendor';
      }
      else{
          return "user";
      }
    }
    else {
      return false;
    }
  }
  function get_session()
  {
    $ci =& get_instance();
	  $ci->load->library('session');
	  $user = $ci->session->userdata('dof_user');
    return $user;
  }
 ?>
