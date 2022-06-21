<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_login_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
  public function is_valid_login($username,$password)
  {
    $this->db->select('ADMINID, profile_picture,profile_thumb,name,username');
    $this->db->from('administrators');
		$this->db->where('(username = \''.$username.'\' OR email = \''.$username.'\')');
		$this->db->where('password',$password);

    $result = $this->db->get()->row_array();
    return $result;
  }

}
?>
