<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {

	public function __construct() {

        parent::__construct();
        $this->load->database();
        $this->load->helper('user_timezone');
        date_default_timezone_set('UTC');
    }

	public function profile($user_id)
  {
    $results = array();
    $results = $this->db->get_where('users',array('md5(user_id)'=>$user_id))->row_array();
    $results['subscription_details'] = $this->get_subscription_details_using_user_id($user_id);
    return $results;
  }

	public function change_password($user_id,$confirm_password,$current_password)
	{
		
        $current_password = md5($current_password);
        $this->db->where('user_id', $user_id);
        $this->db->where(array('password'=>$current_password));
        $record = $this->db->count_all_results('users');
        
        if($record > 0){
          
          $confirm_password = md5($confirm_password);
          $this->db->where('user_id', $user_id);
          return $this->db->update('users',array('password'=>$confirm_password));
        }else{
          return 2;
        }
	}

	public function get_subscription_details_using_user_id($id='')
	{
		$records = array();

		if(!empty($id)){
		 $this->db->select('SD.expiry_date_time, SF.subscription_name');
		 $this->db->from('subscription_details SD');
		 $this->db->join('subscription_fee SF', 'SF.id = SD.subscription_id', 'left');
		 $this->db->where('md5(subscriber_id)', $id);
		 $records =  $this->db->get()->row_array();

		 if(!empty($records)){
			 $records['expiry_date_time'] = utc_date_conversion($records['expiry_date_time']);
		 }else{
			 $records = (object)array();
		 }

		}
		return $records;
	}



	public function profile_details($user_id)
  {
    $results = array();
    $results = $this->db->get_where('users',array('md5(user_id)'=>$user_id))->row_array();
		$subscription_details = $this->get_subscription_details_using_user_id($user_id);
    $results['subscription_details'] = $this->details_get_subscription_details_using_user_id($user_id);
    return $results;
  }

	public function details_get_subscription_details_using_user_id($id='')
	{
		$records = array();

		if(!empty($id)){
		 $this->db->select('SD.expiry_date_time, SF.subscription_name');
		 $this->db->from('subscription_details SD');
		 $this->db->join('subscription_fee SF', 'SF.id = SD.subscription_id', 'left');
		 $this->db->where('md5(subscriber_id)', $id);
		 $records =  $this->db->get()->row_array();

		 if(!empty($records)){
			 $records['expiry_date_time'] = utc_date_conversion($records['expiry_date_time']);
		 }else{
			 $records = array();
		 }

		}
		return $records;
	}

	public function update_profile($data)
  {
		$user_id = $this->session->userdata('user_id');
    $results = $this->db->update('users', $data, array('user_id'=>$user_id));
    return $results;
  }





}

/* End of file Api_model.php */
/* Location: ./application/models/Api_model.php */
