<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {

        parent::__construct();
	      $this->data['view'] = 'user';
        $this->data['base_url'] = base_url();

			  $this->load->helper('custom_language');
			  $lang = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
			  $this->data['language_content'] = get_languages($lang);$user_id = $this->session->userdata('user_id');
        $this->data['user_id'] = $user_id;
				$this->load->helper('subscription_helper');
        $this->data['subscription_details'] = get_subscription_details(md5($user_id));
        $this->load->model('categories_model','category');
        $this->load->model('language_model','language');
        $this->data['language'] = $this->language->active_language();
        $this->data['category'] = $this->category->show_category(); 

        $this->load->model('profile_model','profile');
    }

	public function index($user_id="")
	{
    if($this->session->userdata('user_id'))
		{
      $user_id = md5($this->session->userdata('user_id'));
      $this->data['page'] = 'profile';
  		$this->data['model'] = 'profile';
      $this->data['profile'] = $this->profile->profile_details($user_id);
      $this->load->vars($this->data);
  		$this->load->view('template');
    }
    else {
      redirect(base_url());
    }
	}

  public function change_password()
  {
     if($this->input->post()){
        $user_id = $this->session->userdata('user_id');
        $confirm_password = $this->input->post('confirm_password');
        $current_password = $this->input->post('current_password');

        $result = $this->profile->change_password($user_id,$confirm_password,$current_password);

        if($result == 1){
          $this->session->set_flashdata('message', 'Password changed successfully...');
        }else if($result == 2){
          $this->session->set_flashdata('message', 'Current password not match...');
        }else if($result == 3){
          $this->session->set_flashdata('message', 'Something is wrong, please try again later...');
        }
     }
    redirect(base_url('edit-profile?tab=change'));
  }

  public function check_password()
	{
		$isAvailable = 0;
	  $current_password = $this->input->post('current_password');
	  if(($this->session->userdata('user_id')))
	  {
	    $user_id = $this->session->userdata('user_id');
	    $query = $this->db->query("SELECT `password` FROM `users` WHERE `user_id` = $user_id ;");
	    $result = $query->row_array();

	    if(!empty($result)){
	      if($result['password']==md5($current_password))
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
		$data['mobile_no'] = $mobile_no = $this->input->post('mobile_no');
		$profile_image = $this->input->post('profile_image');
		$ic_card_image = $this->input->post('ic_card_image');
    if(!empty($profile_image))
    {
      $data['profile_img'] = "uploads/profile_img/".$profile_image;
      $this->session->set_userdata('profile_img',$data['profile_img']);
    }
    if(!empty($ic_card_image))
    {
      $data['ic_card_image'] = "uploads/ic_card_image/".$ic_card_image;
    }
		$result = $this->profile->update_profile($data);
		if($result)
		{
			redirect(base_url('edit-profile'));
            $this->session->set_flashdata('success_message','Your profile updated successfully.');
			//echo 1;
		}
	 else
		{
            redirect(base_url('edit-profile'));
            $this->session->set_flashdata('error_message','Something went wrong, Please try again.');
			//echo 2;
		}
	}
}
