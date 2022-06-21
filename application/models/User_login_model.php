<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_login_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

  public function total_revenue(){
		$this->db->select('forgot');
		$this->db->where('user_id', 3);
		return $this->db->get('request_details')->row_array();
	}

  public function is_valid_login($username,$password)
  {
    $password = md5($password);
    $this->db->select('username,user_id, is_active, latitude, longitude, profile_img, register_through, currency_code');
    $this->db->from('users');
		$this->db->where("(username = '$username' OR email = '$username' OR mobile_no = '$username')");
		$this->db->where('password',$password);
    $this->db->where('register_through', 1);
		$this->db->where('role',2);
		$this->db->where('verified',1);
		$result = $this->db->get()->row_array();
    return $result;
  }



public function is_password_change_login($password)
  {
    $password = md5($password);
    $this->db->select('username,user_id, is_active, latitude, longitude, profile_img, register_through');
    $this->db->from('users');
    $this->db->where('password',$password);
    $this->db->where('register_through', 1);
    $this->db->where('role',2);
    $this->db->where('verified',1);
    $result = $this->db->get()->row_array();
    return $result;
  }

    public function google_plus($inputs){

    $oauth_uid = $inputs['oauth_uid'];

    $this->db->select('username,user_id, latitude, longitude, profile_img, register_through');
    $this->db->from('users');
    $this->db->where('tokenid',$oauth_uid);
    $this->db->where('role',2);
    $this->db->where('verified',1);
    $this->db->where('is_active',1);
    $this->db->where('register_through',3);
    $result = $this->db->get()->row_array();
    return $result;
    }

    public function face_book($inputs){

    $oauth_uid = $inputs['oauth_uid'];

    $this->db->select('username,user_id, latitude, longitude, profile_img, register_through');
    $this->db->from('users');
    $this->db->where('tokenid',$oauth_uid);
    $this->db->where('role',2);
    $this->db->where('verified',1);
    $this->db->where('is_active',1);
    $this->db->where('register_through',2);
    $result = $this->db->get()->row_array();
    return $result;
    }

	public function check_username($username)
	{
		$this->db->select('*');
    $this->db->where('username', $username);
		$this->db->where('register_through', 1);
		$this->db->from('users');
		$result = $this->db->get()->num_rows();
		return $result;
	}

  public function check_usernames($username)
  {
    $this->db->select('*');
    $this->db->where('id', $username);
    $this->db->where('register_through', 1);
    $this->db->from('users');
    $result = $this->db->get()->row_array();
    return $result;
  }
  public function check_email_id($email_addr)
  {
    $this->db->select('*');
    $this->db->where('email', $email_addr);
    $this->db->from('administrators');
    $result = $this->db->get()->num_rows();
    return $result;
  }
  public function get_admin_profile_bymail($email_addr)
  {
    $this->db->select('*');
    $this->db->where('email', $email_addr);
    $this->db->from('administrators');
    $result = $this->db->get()->row_array();
    return $result;
  }
	public function check_email_address($email_addr)
	{
		$this->db->select('*');
		$this->db->where('email', $email_addr);
		$this->db->from('users');
		$result = $this->db->get()->num_rows();
		return $result;
	}

    public function check_phone($phone)
  {
    $this->db->select('*');
    $this->db->where('mobile_no', $phone);
    $this->db->from('users');
    $result = $this->db->get()->num_rows();
    return $result;
  }

  public function check_mob_number($phone) {
    $this->db->select('*');
    $this->db->where('mobile_no', $phone);
    $this->db->where('user_id!=', $this->session->userdata('user_id'));
    $this->db->from('users');
    $result = $this->db->get()->num_rows();
    return $result;
  }

	public function signup($inputs)
	{
      $result  = $this->db->insert('users',$inputs);
      $user_id = $this->db->insert_id();
      $unique_code = $this->getToken(14,$user_id);
      $username = $inputs['username'];
      $this->db->where('user_id', $user_id);
      $this->db->update('users', array('unique_code'=>$unique_code));
			$this->session->set_userdata('username',$username);

			return $result;
	}


  public function signup_social($inputs)
  {
      $result  = $this->db->insert('users',$inputs);
      $user_id = $this->db->insert_id();

      $this->session->set_userdata('user_id',$user_id);
      $unique_code = $this->getToken(14,$user_id);

      $this->db->where('user_id', $user_id);
      $this->db->update('users', array('unique_code'=>$unique_code));

     
      return $result;
  }

	public function temp_subscription_success($inputs)
     {

       $new_details = array();

       $user_id = $inputs['user_id'];

       $subscription_id = $inputs['subscription_id'];


       $this->db->select('duration');
       $record = $this->db->get_where('subscription_fee',array('id'=>$subscription_id))->row_array();

       if(!empty($record)){


       $duration = $record['duration'];
       $days = 30;
       switch ($duration) {
         case 1:
           $days = 30;
           break;
         case 2:
           $days = 60;
           break;
         case 3:
           $days = 90;
           break;
         case 6:
           $days = 180;
           break;
         case 12:
           $days = 365;
           break;
         case 24:
           $days = 730;
           break;

         default:
           $days = 30;
           break;
       }

        $subscription_date = date('Y-m-d H:i:s');
        $expiry_date_time =  date('Y-m-d H:i:s',strtotime(date("Y-m-d  H:i:s", strtotime($subscription_date)) ." +".$days."days"));


       $new_details['subscriber_id'] = $user_id;
       $new_details['subscription_id'] = $subscription_id;
       $new_details['subscription_date'] = $subscription_date;
       $new_details['expiry_date_time'] = $expiry_date_time;
			 $this->db->where('subscriber_id', $user_id);
       $count = $this->db->count_all_results('subscription_details');
       if($count == 0){

       return $this->db->insert('subscription_details', $new_details);

       }else{

         $this->db->where('subscriber_id', $user_id);
        $this->db->update('subscription_details', $new_details);
       }

     }else{

      return false;
     }

    }

      public function getToken($length,$user_id)
   {
       $token = $user_id;

       $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
       $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
       $codeAlphabet.= "0123456789";

       $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
         $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];

    }

    return $token;
   }

   function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
  }

	public function forgot_count($user_id)
	{
		$query=$this->db->select('forgot');
		$this->db->where('forgot', $user_id);
		$num = $this->db->get('users')->num_rows();

		return $num;
	}

	public function forgot_password($email) {
      
        $this->db->where('email', $email);
        $record = $this->db->get('users')->row_array();
        if(!empty($record)){
            $id = $record['user_id'];
            $userid = md5($id);
            $this->db->where('user_id', $id);
            $this->db->update('users', array('forgot' => $userid ));

            $from_email= 'nithya.t@dreamguys.co.in';
            $to_mail = $email;
            $subject = 'Forgot Password reset link for Servpro';
            $message = '
            <h2>Hi,</h2>

<p>We&#39;ve received a request to reset the password for this email address.</p>

<p>Click the button below to reset it.</p>

<p><a href="'.base_url().'login/change_password/'.$userid.'" target="_blank" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #00839a; margin: 0; padding:5px 10px;">Reset My Password</a></p>

<p>&nbsp;</p>

<p>If you didn&#39;t request this, you can ignore this email. Your password won&#39;t change until you create a new password.</p>

<p>&nbsp;</p>
<p>Thanks,<br />
Servpro Team</p>';
            $phpmail_config = $this->db->get_where('system_settings',array('key' => 'mail_config'))->row()->value;
            $smtp_email_port = $this->db->get_where('system_settings',array('key' => 'smtp_email_port'))->row()->value;
            $smtp_email_password = $this->db->get_where('system_settings',array('key' => 'smtp_email_password'))->row()->value;
            if (isset($phpmail_config) && !empty($phpmail_config)) {
                if ($phpmail_config == "phpmail") {
                    $from_email = $this->db->get_where('system_settings',array('key' => 'email_address'))->row()->value;
                } else {
                    $from_email = $this->db->get_where('system_settings',array('key' => 'smtp_email_address'))->row()->value;
                }
            }

            $mail_config['smtp_host'] = 'smtp.gmail.com';
            $mail_config['smtp_port'] = $smtp_email_port;
            $mail_config['smtp_user'] = $from_email;
            $mail_config['_smtp_auth'] = TRUE;
            $mail_config['smtp_pass'] =  $smtp_email_password;
            $mail_config['smtp_crypto'] = 'tls';
            $mail_config['protocol'] = 'smtp';
            $mail_config['mailtype'] = 'html';
            $mail_config['send_multipart'] = FALSE;
            $mail_config['charset'] = 'utf-8';
            $mail_config['newline']   = "\r\n";
            $mail_config['wordwrap'] = TRUE;

            $this->load->library('email', $mail_config);

            //Send mail to User
            if(!empty($from_email)&&isset($from_email)){
                    $mail = $this->email
                    ->from($from_email)
                    ->to($to_mail)
                    ->subject($subject)
                    ->message($message);

                if (!$this->email->send()) {
                    show_error($this->email->print_debugger()); 
                } else {
                    echo 'Your e-mail has been sent!';
                }
            }
        return true;
      }else{
        return false;
      }
    }

	public function change_password($data, $userid)
	{
     
		$this->db->where('user_id',$userid);
		$result = $this->db->update('users',$data);
		return $result;
	}

  public function get_userid($userid)
  {
    $result = $this->db->select('user_id');
    $this->db->from('users');
    $this->db->where('forgot',$userid);
    $result = $this->db->get()->row_array();
    return $result;
  }
}
