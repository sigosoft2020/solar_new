<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
// 			$this->load->library('session');
// 			$this->load->helper('url');
			$this->load->model('Common');
	}
	public function index()
	{
	    redirect('login/login');
	}
	public function login()
	{
        if(isset($_COOKIE['solar_admin_id']))
        {
			$session = [
				'admin_id' => $_COOKIE['solar_admin_id'],
				'name'     => $_COOKIE['solar_admin_name']
			];
			$this->session->set_userdata('admin',$session);
			redirect('admin/dashboard');
		}

		$this->load->view('admin/login');
	}
	public function check()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$pass    = $this->security->xss_clean($this->input->post('password'));
		$password = md5($pass);

		$details = [
			'user_name' => $username,
			'password' => $password
		];

		$check = $this->Common->get_details('login',$details);
		if ( $check->num_rows() > 0 ) {
			$user = $check->row();
			$session = [
				'admin_id' => $user->login_id,
				'name'     => $user->user_name
			];
			$this->session->set_userdata('admin',$session);

			$hour = time() + 3600 * 24 * 30;
		    setcookie('solar_admin_id', $user->login_id, $hour);
			setcookie('solar_admin_name', $user->user_name, $hour);

			redirect('admin/dashboard');
		}
		else {
			$this->session->set_flashdata('message','Login failed');
			redirect('login');
		}
	}
	public function logout()
	{
		setcookie('solar_admin_id');
		setcookie('solar_admin_name');

		$this->session->unset_userdata('admin');
		redirect('login');
	}
	

}
