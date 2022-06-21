<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
        $this->load->model('dashboard_model','dashboard');
                $this->load->library('Encryption','encryption');

        $this->data['view'] = 'admin';
        $this->data['base_url'] = base_url();
        
    }

	public function index()
	{
		$this->data['page'] = 'profile';
		$this->data['model'] = 'profile';
    $this->data['details'] = $this->dashboard->admin_details($this->session->userdata['admin_id']);
		$this->load->vars($this->data);
		$this->load->view('template');

	}

  public function check_password()
	{
		$isAvailable = 0;
	  $current_password = $this->input->post('current_password');
    $pswd=base64_encode($current_password);
    
	  if(($this->session->userdata('admin_id')))
	  {
	    $admin_id = $this->session->userdata('admin_id');
	    $query = $this->db->query("SELECT `password` FROM `administrators` WHERE `ADMINID` = $admin_id");
	    $result = $query->row_array();

	    if(!empty($result)){
	      if($result['password']==($pswd))
	      {
	        $isAvailable = 1;
	      }
	      else
	      {
	       $isAvailable = 0;
	     }
	   }
	   else{
	     $isAvailable = 0;
	   }
	   echo $isAvailable;
	 }
	}

  public function update_profile()
	{
    $profile_image = $this->input->post('profile_img');
    if(!empty($profile_image))
    {
      $data['profile_picture'] = "uploads/profile_img/".$profile_image;
      $data['profile_thumb'] = "uploads/profile_img/".$profile_image;
		  $result = $this->dashboard->update_profile($data);
  		if($result)
  		{
        $this->session->set_userdata('admin_profile_img',$data['profile_picture']);
  			$this->session->set_flashdata('success_message','Your profile updated successfully.');
  			echo 1;
  		}
  	 else
  		{
      $this->session->set_flashdata('error_message','Something went wrong, Please try again.');
  			echo 2;
  		}
	  }
   else
    {
    $this->session->set_flashdata('error_message','Something went wrong, Please try again.');
      echo 2;
    }
  }

  public function change_password()
  {
     if($this->input->post()){

        $user_id = $this->session->userdata('admin_id');
         $confirm_password = $this->input->post('confirm_password');
         $current_password = $this->input->post('current_password');
         $cnfrmpswd=base64_encode($confirm_password);
         $curpaswd=base64_encode($current_password);


          $result = $this->dashboard->change_password_admin($user_id,$cnfrmpswd,$curpaswd);


        if($result == 1){
          $this->session->set_flashdata('success_message', 'Password changed successfully...');

        }
        else{
          $this->session->set_flashdata('message', 'Something is wrong, please try again later...');

        }
     }
      redirect(base_url('admin-profile'));
  }
}
