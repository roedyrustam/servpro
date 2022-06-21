<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function __construct() {

        parent::__construct();
        $this->load->database();
        date_default_timezone_set('UTC');
    }

		public function total_requests(){
			return $this->db->count_all_results('request_details');
		}

		public function total_providers(){
			$this->db->where('delete_status', 0);
			return $this->db->count_all_results('provider_details');
		}
		public function edit_paytab_settings(){
			$this->db->select('*');
			return $this->db->get('paytabs_details')->row_array();
		}
		public function edit_paypal_settings(){
			$this->db->select('*');
			return $this->db->get('paypal_details')->row_array();
		}
		public function edit_razorpay_settings(){
			$this->db->select('*');
			return $this->db->get('razorpay_gateway')->row_array();
		}
		public function total_revenue(){
			$this->db->select_sum('proposed_fee');
			$this->db->where('status', 2);
			return $this->db->get('request_details')->row_array();
		}

		public function total_pending_providers(){
			$this->db->where('status', 1);
			return $this->db->count_all_results('request_details');
		}

		public function request_details($month, $year){
			$this->db->select("count(r_id) AS tot");
			$this->db->where("MONTH(created)", $month);
			$this->db->where("YEAR(created)", $year);
			return $this->db->get('request_details')->row_array();
		}

		public function provider_details($month, $year){
			$this->db->select("count(p_id) AS tot");
			$this->db->where("MONTH(created)", $month);
			$this->db->where("YEAR(created)", $year);
			return $this->db->get('provider_details')->row_array();
		}

		public function last_request_details(){
			
			$query = $this->db->query("select max(created) from (select max(created) as created from request_details union select max(created) as created from provider_details) AS created");
			return $query->row_array();
		}

		public function colour_settings(){
			return $this->db->get('colour_settings')->row_array();
		}


		var $column_order = array(null, 'U.username','U.mobile_no','U.email','U.last_login','U.created','S.subscription_name');
		var $column_search = array( 'U.username','U.mobile_no','U.email','U.last_login','S.subscription_name');
		var $order = array('U.user_id' => 'DESC'); // default order
		var $users  = 'users U';
		var $subscription_details  = 'subscription_details SD';
		var $subscription  = 'subscription_fee S';
		private function p_get_datatables_query()
		{


			$this->db->select('U.user_id,U.username,U.profile_img,U.mobile_no,U.email,created as signup_date,U.last_login,U.role,U.is_active,S.subscription_name,SD.subscriber_id');
			$this->db->from($this->users);
			$this->db->join($this->subscription_details,'SD.subscriber_id=U.user_id','left');
			$this->db->join($this->subscription,'S.id=SD.subscription_id','left');
			$i = 0;
			foreach ($this->column_search as $item) // loop column
				{
						if($_POST['search']['value']) // if datatable send POST for search
						{

								if($i===0) // first loop
								{
										$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
										$this->db->like($item, $_POST['search']['value']);
								}
								else
								{

									if($item == 'status'){
										if(strtolower($_POST['search']['value'])=='active'){
											$search_val = 1;
											$this->db->or_like($item, $search_val);
										}
										if(strtolower($_POST['search']['value'])=='inactive'){
											$search_val = 0;
											$this->db->or_like($item, $search_val);
										}


										}else{
											$search_val = $_POST['search']['value'];
											$this->db->or_like($item, $search_val);
										}

								}

								if(count($this->column_search) - 1 == $i) //last loop
										$this->db->group_end(); //close bracket
						}
						$i++;
				}

				if(isset($_POST['order'])) // here order processing
				{
						$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
				}
				else if(isset($this->order))
				{
						$order = $this->order;
						$this->db->order_by(key($order), $order[key($order)]);
				}
		}

	  public function users_list(){
	      $this->p_get_datatables_query();
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        $query = $this->db->get();
	        return $query->result();
	  }

	  public function users_list_all(){

	    $this->db->from($this->users);
	        return $this->db->count_all_results();
	  }

	  public function users_list_filtered(){

	        $this->p_get_datatables_query();
	        $query = $this->db->get();
	        return $query->num_rows();
	  }

		public function admin_details($user_id)
		{
			$results = array();
			$results = $this->db->get_where('administrators',array('ADMINID'=>$user_id))->row_array();
			return $results;
		}

		public function update_profile($data)
	  {
			$user_id = $this->session->userdata('admin_id');
	    $results = $this->db->update('administrators', $data, array('ADMINID'=>$user_id));


	    return $results;
	  }

		public function change_password($user_id,$confirm_password,$current_password)
		{

	        $current_password = ($current_password);
	        $this->db->where('user_id', $user_id);
	        $this->db->where(array('password'=>$current_password));
	        $record = $this->db->count_all_results('users');

	        if($record > 0){

	          $confirm_password = ($confirm_password);
	          $this->db->where('user_id', $user_id);
	          return $this->db->update('users',array('password'=>$confirm_password));
	        }else{
	          return 2;
	        }
		}
		public function change_password_admin($user_id,$confirm_password,$current_password)
		{

	        $this->db->where('ADMINID', $user_id);
	        $this->db->where(array('password'=>$current_password));
	        $record = $this->db->count_all_results('administrators');


	        if($record > 0){

	          $this->db->where('ADMINID', $user_id);
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

    public function banner_system_settings($id){
    	$query = $this->db->query("select * from `system_settings` where `key` = '$id'");
    	$result = $query->row_array();
        return $result;
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


}

/* End of file Api_model.php */
/* Location: ./application/models/Api_model.php */
