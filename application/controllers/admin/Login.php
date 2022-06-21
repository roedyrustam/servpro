<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
        $this->load->model('admin_login_model','admin_login');


        $this->data['view'] = 'admin';
        $this->data['base_url'] = base_url();

    }


	public function index()
	{
    if (empty($this->session->userdata['admin_id']))
    {
  		$this->data['page'] = 'login';
  		$this->data['model'] = 'login';
  		$this->load->vars($this->data);
  		$this->load->view('template');
    }
    else {
      redirect(base_url()."dashboard");
    }
	}

  public function is_valid_login()
	{
		$this->load->library('encryption');
		$username = $this->input->post('username');

		$password = $this->input->post('password');
		$pswd=base64_encode($password);

		$result = $this->admin_login->is_valid_login($username,$pswd);


		if(!empty($result))
		{
      $this->session->set_userdata('admin_id',$result['ADMINID']);
      $this->session->set_userdata('admin_profile_img',$result['profile_thumb']);
  		    $access_result_data = $this->db->where('admin_user_id',$result['ADMINID'])->where('access_status',1)->select('module_id')->get('module_access')->result_array();
  		    $access_result_data_array = array_column($access_result_data, 'module_id');
			$this->session->set_userdata('access_module',$access_result_data_array);
			echo 1;
		}
	 	else
		{
    		$this->session->set_flashdata('error_message','Wrong login credentials.');
			echo 2;
		}
	}

	public function forgot_password()
	{

		$this->data['page'] = 'forgot_password';
		$this->data['model'] = 'login';
		$this->load->vars($this->data);
		$this->load->view('template');
	}

	public function send_forgot_password()
	{
  	$mailss = $this->input->post('email_id');
    $this->db->where('email', $mailss);
    $this->load->library('servpro');
      $record = $this->db->get('administrators')->row_array();
      if(!empty($record)){

        $id = $record['ADMINID'];
        $details="Your Username : ".$record['username']."/n"."Your password : ".base64_decode($record['password']);
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $to = $mailss;
        $subject = 'Forgot Password reset link for ';
        $message = 'Your Login Details '.$details;
        $send=$this->servpro->send_mail($to,$subject,$message);
        redirect(base_url().'admin');
  }

}

 	public function logout()
	{
	    if (!empty($this->session->userdata['admin_id']))
	    {
	      $this->session->unset_userdata('admin_id');
	    }
	    $this->session->set_flashdata('success_message','Logged out successfully');
			redirect(base_url()."admin");
    }

}
