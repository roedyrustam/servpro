<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
  public function is_valid_login($username,$password)
  {
    $password = md5($password);
    $this->db->select('user_id, profile_img');
    $this->db->from('administrators');
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$this->db->where('role',1);
	  $result = $this->db->get()->row_array();
    return $result;
  }

    public function admin_details($user_id)
	{
		$results = array();
		$results = $this->db->get_where('administrators',array('user_id'=>$user_id))->row_array();
		return $results;
	}

	public function update_profile($data)
	  {
			$user_id = $this->session->userdata('admin_id');
	    $results = $this->db->update('administrators', $data, array('user_id'=>$user_id));
	    return $results;
	  }

		public function change_password($user_id,$confirm_password,$current_password)
		{

	        $current_password = md5($current_password);
	        $this->db->where('user_id', $user_id);
	        $this->db->where(array('password'=>$current_password));
	        $record = $this->db->count_all_results('administrators');

	        if($record > 0){

	          $confirm_password = md5($confirm_password);
	          $this->db->where('user_id', $user_id);
	          return $this->db->update('administrators',array('password'=>$confirm_password));
	        }else{
	          return 2;
	        }
		}

		public function get_setting_list() {
        $data = array();
        $stmt = "SELECT a.*"
                . " FROM system_settings AS a"
                . " ORDER BY a.`id` ASC";
        $query = $this->db->query($stmt);
        if ($query->num_rows()) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function edit_payment_gateway($id)
    {
        $query = $this->db->query(" SELECT * FROM `payment_gateways` WHERE `id` = $id ");
        $result = $query->row_array();
        return $result;
    }

     public function all_payment_gateway()
    {
      $this->db->select('*');
        $this->db->from('payment_gateways');
        $query = $this->db->get();
        return $query->result_array();         
    }

        public function categories_list()
		{
			return $this->db->where('status',1)->get('categories')->result_array();
		}

		public function subcategories_list()
		{
					$this->db->select('s.*,c.category_name');
					$this->db->from('subcategories s');
					$this->db->join('categories c', 'c.id = s.category', 'left');
			return $this->db->where('s.status',1)->get()->result_array();
		}
		
        public function categories_details($id)
		{
			return $this->db->get_where('categories',array('id'=>$id))->row_array();
		}

		public function subcategories_details($id)
		{
			return $this->db->get_where('subcategories',array('id'=>$id))->row_array();
		}
		public function getting_pages_list($id)
	    {
	      $query  = $this->db->query("SELECT * FROM  `page_content` WHERE id = $id")->result();
	        return $query;         
	    }
	    public function getting_faq_list()
	    {
	      	$query  = $this->db->get_where('faq')->result();
	  		return $query;         
	    }
	    public function update_data($table, $data, $where = []) {
        if (count($where) > 0) {
            $this->db->where($where);
            $status = $this->db->update($table, $data);
            return $status;
        } else {
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }
    }

    	 public function GetBannersettings()
	{
		$results = array();
		$results = $this->db->get_where('bgimage',array('bgimg_id'=> 1))->result_array();
		return $results;
	}
	public function result_getall() {
		$this->db->select('SP.*,U.username,S.subscription_name,SD.expiry_date_time');
		$this->db->from('subscription_payment SP');
		$this->db->join('subscription_details SD','SD.subscription_id=SP.subscription_id','left'); 
		$this->db->join('subscription_fee S','S.id=SP.subscription_id','left'); 
		$this->db->join('users U','U.user_id=SP.subscriber_id','left');
		$this->db->where(array('SP.tokenid'=> 'Offline Payment'));
		$this->db->group_by('SP.id');
		$query = $this->db->get();
		return $query->result_array();
		
	}
}
?>
