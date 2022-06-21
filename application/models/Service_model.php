<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Service_model extends CI_Model {

		public function __construct() {

	        parent::__construct();
	        $this->load->database();
	        date_default_timezone_set('UTC');
	       	$this->load->helper('subscription_helper');
	    }

		public function subscription_list()
		{
			return $this->db->get('subscription_fee')->result_array();
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

		public function ratingstype_list()
		{
			return $this->db->where('status',1)->get('ratings_type')->result_array();
		}

		public function subscription_details($id)
		{
			return $this->db->get_where('subscription_fee',array('id'=>$id))->row_array();
		}

		public function categories_details($id)
		{
			return $this->db->get_where('categories',array('id'=>$id))->row_array();
		}

		public function subcategories_details($id)
		{
			return $this->db->get_where('subcategories',array('id'=>$id))->row_array();
		}

		public function ratingstype_details($id)
		{
			return $this->db->get_where('ratings_type',array('id'=>$id))->row_array();
		}
		
	  public function subscriptions()
	  {
	    $result = $this->db->get_where('subscription_fee',array('status'=>1))->result_array();
	    return $result;
	  }

		var $column_order = array(null, 'U.username','P.contact_number','P.title','P.created');
		var $column_search = array('U.username','U.mobile_no','P.title','P.created');
		var $order = array('P.p_id' => 'DESC'); // default order
		var $request_details  = 'provider_details P';
		var $users  = 'users U';
		private function p_get_datatables_query()
		{


			$this->db->select('P.*,U.username,U.profile_img');
			$this->db->from($this->request_details);
			$this->db->join($this->users, 'U.user_id = P.user_id', 'left');
			$this->db->where('P.delete_status', 0);
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

	  public function provider_list(){
	      $this->p_get_datatables_query();
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        $this->db->group_by('P.p_id');
	        $query = $this->db->get();
	        return $query->result();
	  }

	  public function provider_list_all(){

	    $this->db->from($this->request_details);
	    $this->db->where('P.delete_status', 0);
	        return $this->db->count_all_results();
	  }

	  public function provider_list_filtered(){

	        $this->p_get_datatables_query();
	        $this->db->group_by('P.p_id');
	        $query = $this->db->get();
	        return $query->num_rows();
	  }

		var $r_column_order = array(null, 'U.username','R.contact_number','R.title','R.proposed_fee','R.request_date','R.created');
		var $r_column_search = array('U.username','R.contact_number','R.title','R.proposed_fee','R.request_date','R.created');
		var $r_order = array('R.r_id' => 'DESC'); // default order
		var $r_request_details  = 'request_details R';
		var $r_users  = 'users U';
		private function r_get_datatables_query()
		{


			$this->db->select('R.*,U.username,U.profile_img,IF(RAD.status IS NULL,0,RAD.status) as request_accept_status');
			$this->db->from($this->r_request_details);
			$this->db->join($this->r_users, 'U.user_id = R.user_id', 'left');
      $this->db->join('request_accept_details RAD', 'RAD.request_id = R.r_id', 'LEFT');
				$i = 0;

				foreach ($this->r_column_search as $item) // loop column
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

								if(count($this->r_column_search) - 1 == $i) //last loop
										$this->db->group_end(); //close bracket
						}
						$i++;
				}

				if(isset($_POST['order'])) // here order processing
				{
						$this->db->order_by($this->r_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
				}
				else if(isset($this->r_order))
				{
						$r_order = $this->r_order;
						$this->db->order_by(key($r_order), $r_order[key($r_order)]);
				}
		}

	  public function request_list(){
	      $this->r_get_datatables_query();
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        $this->db->group_by('R.r_id');
					$rescords_array = $this->db->get()->result_array();
		      $rescords = array();
		      if(count($rescords_array) >0){
		        foreach ($rescords_array as $array) {

		          date_default_timezone_set("Asia/Kuala_Lumpur");
		          $date_time = date('Y-m-d H:i:s');


							$delete_status = $array['delete_status'];
		          $rad_status = $array['request_accept_status'];
		          $status = $array['status'];
		          $request_date = $array['request_date'].' '.$array['request_time'];

		          if(strtotime($request_date) > strtotime($date_time)){
		            if($rad_status == 0){
		              $array['status']  = 0;
		            }else{
		              $array['status']  = $rad_status;
		            }
		          }else{
		            if($rad_status == 0){
		              $array['status']  = -1;
		            }
		          }
							if($delete_status == 1){
		              $array['status']  = 4;
							}
		          unset($array['request_accept_status']);

		          $rescords[] = $array;
		        }
		      }
					return $rescords;
	  }

	  public function request_list_all(){

	    $this->db->from($this->r_request_details);
	        return $this->db->count_all_results();
	  }

	  public function request_list_filtered(){

	        $this->r_get_datatables_query();
	        $this->db->group_by('R.r_id');
	        $query = $this->db->get();
	        return $query->num_rows();
	  }

    public function get_services($inputs)
    {
      $new_details = array();
      $user_id = $inputs['user_id'];
      $pid = isset($inputs["pid"]) ? $inputs["pid"]:"";
      $offset  = ($inputs['page']>1)?(($inputs['page']-1)*10):0;
  	  $latitude   = $inputs['latitude'];
		  $longitude  = $inputs['longitude'];
		  $radius     = 100000;
               $longitude_min = $longitude - 100000 / abs(cos(deg2rad($longitude)) * 69);
               $longitude_max = $longitude + 100000 / abs(cos(deg2rad($longitude)) * 69);
               $latitude_min  = $latitude - (100000 / 69);
               $latitude_max  = $latitude + (100000 / 69);

			$this->db->select("PD.p_id,PD.user_id as provider_id,PD.title,PD.service_image,PD.description_details,PD.contact_number,PD.availability,PD.location,PD.latitude,PD.longitude,PD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,
			 1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - PD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(PD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - PD.longitude) * pi()/180 / 2), 2) )) AS distance");
      	$this->db->from('provider_details PD');
      	$this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');
      	$this->db->having('distance <=', $radius);
      	if($pid){ $this->db->where("PD.p_id IN($pid)"); }
      	$this->db->where("PD.status = 1 AND PD.delete_status=0  AND  (PD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (PD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ") AND PD.delete_status=0");

       if(!empty($inputs['request_date'])){
          $this->db->where('start_date <= ', $inputs['request_date']);
          $this->db->where('end_date >= ', $inputs['request_date']);
        }

        if(!empty($inputs['location'])){
          $this->db->like('location', $inputs['location'],'BOTH');
        }
        $query = $this->db->get();

		if($query !== FALSE && $query->num_rows() > 0){
		    $count = $query->num_rows();
		}

      	$this->db->select("PD.p_id,PD.user_id as provider_id,PD.title,PD.service_image,PD.description_details,PD.contact_number,PD.availability,PD.location,PD.latitude,PD.longitude,PD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,
			 1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - PD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(PD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - PD.longitude) * pi()/180 / 2), 2) )) AS distance");
      	$this->db->from('provider_details PD');
        $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');
        $this->db->having('distance <=', $radius);
        if($pid){ $this->db->where("PD.p_id IN($pid)"); }
        $this->db->where("PD.status = 1  AND (PD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (PD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ") AND PD.delete_status=0");
         if(!empty($inputs['search_title'])){
          $this->db->like('title', $inputs['search_title'],'BOTH');
        }

        if(!empty($inputs['category'])){
          $this->db->where_in('category', $inputs['category']);
        }

        if(!empty($inputs['subcategory'])){
          $this->db->where_in('subcategory', $inputs['subcategory']);
        }

       if(!empty($inputs['request_date'])){
          $this->db->where('start_date <= ', $inputs['request_date']);
          $this->db->where('end_date >= ', $inputs['request_date']);
        }




        if(!empty($inputs['location'])){
          $this->db->like('location', $inputs['location'],'BOTH');
        }

      	$this->db->limit(20, $offset);
      	$query = $this->db->get();

		$rescordss = array();
		if($query !== FALSE && $query->num_rows() > 0){
		    $rescordss = $query->result_array();
		}

			$rescords = array();
			foreach($rescordss as $key => $value){
 				unset($value['distance']);
				 $rescords[] = $value;
			}


      $total_pages = 0;
      $next_page  = -1;

      $page       = $inputs['page'];

      if($count > 0 && $page > 0){

         $total_pages = ceil($count / 10);
         $page        = $inputs['page'];

         if($page < $total_pages){

           $next_page = ($page + 1);

         }else{

           $next_page = -1;
         }
      }
      $new_details['next_page']    = $next_page;
      $new_details['current_page'] = $page;
      $new_details['total_pages']  = $total_pages;
      $new_details['provider_list'] = $rescords;

      $subscription_details = get_subscription_details(md5($user_id));
			$chat_status = 0;
			$sub_count =0;

			if(isset($subscription_details)&& !empty($subscription_details))
			{
				$sub_count = count($subscription_details);
			}
			$subscription_id = $subscription_details['subscription_id'];
			$subscription_date = $subscription_details['subscription_date'];
			$expiry_date_time = $subscription_details['expiry_date_time'];
			date_default_timezone_set('UTC');
			$current_date_time = date('Y-m-d H:i:s');
			if(($sub_count > 0) && ($current_date_time <= $expiry_date_time)){
			 $chat_status = 0;
			} else {
			 $chat_status = 1;
			}
			$new_details['subscription_status'] = $chat_status;

      return $new_details;

    }

		public function get_service_details($p_id)
    {
      $this->db->select("PD.p_id,PD.user_id as provider_id,PD.category,PD.subcategory,PD.title,PD.description_details,PD.contact_number,PD.availability,PD.location,PD.latitude,PD.longitude,PD.start_date,PD.end_date,PD.status,PD.created,PD.country_code,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,( SELECT  IFNULL(ROUND(AVG(r.rating),1),0) FROM rating_review r WHERE r.p_id = PD.p_id )AS rating, PD.service_image");
      $this->db->from('provider_details PD');
      $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');
      $this->db->where("MD5(PD.p_id)", $p_id);
      $this->db->where("PD.status = 1");
      $records = $this->db->get()->row_array();
      return $records;

    }

    public function my_services($inputs)
   {

      $user_id = $inputs['user_id'];
      $new_details = array();
      $this->db->where('PD.status',1);
      $this->db->where('PD.delete_status', 0);
      $this->db->where('PD.user_id', $user_id);
      $count = $this->db->count_all_results('provider_details PD');

      $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;
      $this->db->select('PD.p_id,PD.user_id as provider_id,PD.title,PD.service_image,PD.location,PD.description_details,PD.contact_number,PD.availability,PD.latitude,PD.longitude,PD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no');
      $this->db->from('provider_details PD');
      $this->db->where('PD.status',1);
      $this->db->where('PD.delete_status', 0);
      $this->db->where('PD.user_id', $user_id);
      $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');
      $this->db->limit(10, $offset);

      $query = $this->db->get();

		$rescords = array();
		if($query !== FALSE && $query->num_rows() > 0){
		    $rescords = $query->result_array();
		}

      $total_pages = 0;
      $next_page  = -1;

      $page       = $inputs['page'];

      if($count > 0 && $page > 0){

         $total_pages = ceil($count / 10);
         $page        = $inputs['page'];

         if($page < $total_pages){

           $next_page = ($page + 1);

         }else{

           $next_page = -1;
         }
      }
      $new_details['next_page']    = $next_page;
      $new_details['current_page'] = $page;
      $new_details['total_pages']  = $total_pages;
      $new_details['provider_list'] = $rescords;

			$subscription_details = get_subscription_details(md5($user_id));
			$chat_status = 0;
			$sub_count =0;
			if(isset($subscription_details)&& !empty($subscription_details))
			{
				$sub_count = count($subscription_details);
			}
			$subscription_id = $subscription_details['subscription_id'];
			$subscription_date = $subscription_details['subscription_date'];
			$expiry_date_time = $subscription_details['expiry_date_time'];
			date_default_timezone_set('UTC');
			$current_date_time = date('Y-m-d H:i:s');
			if(($sub_count > 0) && ($current_date_time <= $expiry_date_time)){
			 $chat_status = 0;
			} else {
			 $chat_status = 1;
			}
			$new_details['subscription_status'] = $chat_status;


      return $new_details;
   }

    public function create_service($inputs)
    {
     
    	
      $new_details = array();
      $user_id = $this->session->userdata('user_id');
      $title   = $inputs['title'];
   
      
      	$array = array();
      	if(!empty($inputs['availability'][0]['day'])){
      		$from = $inputs['availability'][0]['from_time'];
      		$to = $inputs['availability'][0]['to_time'];
      		for ($i=1; $i <= 7; $i++) {
      			$array[$i] = array('day'=>$i,'from_time'=>$from,'to_time'=>$to);
      		}
      	}else{
      		if(!empty($inputs['availability'][0])){
      			unset($inputs['availability'][0]);
      		}
      		$array = array_map('array_filter', $inputs['availability']);
			$array = array_filter($array);
      	}
      	if(!empty($array)){
      		$array = array_values($array);
      	}
      $new_details['user_id'] = $user_id;
      $new_details['title'] = $inputs['title'];
      $new_details['category'] = implode(',',$inputs['category']);
      $new_details['subcategory'] = isset($inputs['subcategory']) ? implode(',',$inputs['subcategory']):'';
      $new_details['description_details'] = json_encode($inputs['description']);
      $new_details['country_code'] = $inputs['countryCode'];
      $new_details['contact_number'] = $inputs['contact_number'];
      $new_details['availability'] = json_encode($array);
      $new_details['location'] = $inputs['location'];
      $new_details['latitude'] = $inputs['latitude'];
      $new_details['longitude'] = $inputs['longitude'];
      $new_details['service_image'] = $inputs['service_image'];
      $new_details['start_date'] = date('Y-m-d',strtotime($inputs['start_date']));
      $new_details['end_date'] = date('Y-m-d',strtotime($inputs['end_date']));
      $new_details['created'] =  date('Y-m-d H:i:s');
      
      $result=   $this->db->insert('provider_details', $new_details);
      return $result;
      
    }

	  public function update_service($inputs)
    {
    
      $new_details = array();
      $user_id = $this->session->userdata('user_id');
      $title   = $inputs['title'];
      $p_id = $inputs['p_id'];

      $this->db->where('title', $title);
      $this->db->where('p_id !=', $p_id);
      $this->db->where('user_id', $user_id);
      $count = $this->db->count_all_results('provider_details');
      if($count == 0){
      	$array = array();

      	if(!empty($inputs['availability'][0]['day'])){
      		$from = $inputs['availability'][0]['from_time'];
      		$to = $inputs['availability'][0]['to_time'];
      		for ($i=1; $i <= 7; $i++) {
      			$array[$i] = array('day'=>$i,'from_time'=>$from,'to_time'=>$to);
      		}

      	}else{
      		if(!empty($inputs['availability'][0])){
      			unset($inputs['availability'][0]);
      		}
      		$array = array_map('array_filter', $inputs['availability']);
			$array = array_filter($array);
      	}
      	if(!empty($array)){
      		$array = array_values($array);
      	}

      $new_details['user_id'] = $user_id;
      $new_details['title'] = $inputs['title'];
      $new_details['category'] = implode(',',$inputs['category']);
      $new_details['subcategory'] = ($inputs['subcategory'])? implode(',',$inputs['subcategory']):'';
      $new_details['description_details'] = json_encode($inputs['description']);
      $new_details['country_code'] = $inputs['countryCode'];
      $new_details['contact_number'] = $inputs['contact_number'];
      $new_details['availability'] = json_encode($array);
      $new_details['location'] = $inputs['location'];
      $new_details['latitude'] = $inputs['latitude'];
      $new_details['longitude'] = $inputs['longitude'];
      $new_details['start_date'] = date('Y-m-d',strtotime($inputs['edit_start_date']));
      $new_details['end_date'] = date('Y-m-d',strtotime($inputs['edit_end_date']));
      $new_details['service_image'] = (!empty($inputs['service_image']))?"uploads/service_image/" . $inputs['service_image']:'';
      $new_details['created'] =  date('Y-m-d H:i:s');
      
      return $this->db->update('provider_details', $new_details, array('p_id' => $p_id));
      }else{
        return 2; // Already Exists
      }
    }


	public function get_pending_history($inputs)
    {
      $user_id = $inputs['user_id'];
      $new_details = array();
      $status = $inputs['status'];
    

      $this->db->from('request_accept_details RAD');
      $this->db->where("(requester_id = '$user_id' OR acceptor_id = '$user_id')" );
      $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');
      $this->db->where('RD.status',1);
      $this->db->where_in('RAD.status',$status);

      $count = $this->db->count_all_results();
      $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;

      $this->db->select('RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.currency_code,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, "%h:%i %p") as request_time ,RD.proposed_fee as amount,RD.contact_number,RD.latitude,RD.longitude,RAD.acceptor_id,RAD.requester_id,RD.request_image,U.username as requester_name,U.email as requester_email,U.profile_img,U.mobile_no as requester_mobile,
          U1.username as acceptor_name,U1.email as acceptor_email,U1.profile_img as acceptor_image,U1.mobile_no as acceptor_mobile,RAD.status as status');
      $this->db->from('request_accept_details RAD');

      $this->db->where("(requester_id = '$user_id' OR acceptor_id = '$user_id')" );
      $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');

      $this->db->join('users U', 'U.user_id = RAD.requester_id', 'LEFT');
      $this->db->join('users U1', 'U1.user_id = RAD.acceptor_id', 'LEFT');
      $this->db->where('RD.status',1);
      $this->db->where_in('RAD.status',1);
      $this->db->limit(10, $offset);
      $rescords = $this->db->get()->result_array();

      $total_pages = 0;
      $next_page  = -1;
      $page       = $inputs['page'];

      if($count > 0 && $page > 0){

         $total_pages = ceil($count / 10);


         if($page < $total_pages){

           $next_page = ($page + 1);

         }else{
           $next_page = -1;
         }
      }

      $new_details['next_page']    = $next_page;
      $new_details['current_page'] = $page;
      $new_details['total_pages']  = $total_pages;
      $new_details['request_list'] = $rescords;


      return $new_details;
   }

	public function get_history($inputs)
    {
      $user_id = $inputs['user_id'];
      $new_details = array();
      $status = $inputs['status'];
      $this->db->from('request_accept_details RAD');
      $this->db->where("(requester_id = '$user_id' OR acceptor_id = '$user_id')" );
      $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');
      $this->db->where('RD.status',1);
      $this->db->where_in('RAD.status',$status);

      $count = $this->db->count_all_results();
      $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;

      $this->db->select('RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.currency_code,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, "%h:%i %p") as request_time ,RD.proposed_fee as amount,RD.contact_number,RD.latitude,RD.longitude,RAD.acceptor_id,RAD.requester_id,RD.request_image,U.username as requester_name,U.email as requester_email,U.profile_img,U.mobile_no as requester_mobile,
          U1.username as acceptor_name,U1.email as acceptor_email,U1.profile_img as acceptor_image,U1.mobile_no as acceptor_mobile,RAD.status as status');
      $this->db->from('request_accept_details RAD');

      $this->db->where("(requester_id = '$user_id' OR acceptor_id = '$user_id')" );
      $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');

      $this->db->join('users U', 'U.user_id = RAD.requester_id', 'LEFT');
      $this->db->join('users U1', 'U1.user_id = RAD.acceptor_id', 'LEFT');
      $this->db->where('RD.status',1);
      $this->db->where_in('RAD.status',$status);
      $this->db->limit(10, $offset);
      $rescords = $this->db->get()->result_array();

      $total_pages = 0;
      $next_page  = -1;
      $page       = $inputs['page'];

      if($count > 0 && $page > 0){

         $total_pages = ceil($count / 10);


         if($page < $total_pages){

           $next_page = ($page + 1);

         }else{
           $next_page = -1;
         }
      }

      $new_details['next_page']    = $next_page;
      $new_details['current_page'] = $page;
      $new_details['total_pages']  = $total_pages;
      $new_details['request_list'] = $rescords;


      return $new_details;
   }
	 public function get_history_details($r_id)
    {
			$records = array();
			$this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,RD.request_time,RD.currency_code,RD.proposed_fee as amount,RD.contact_number,RD.latitude,RD.longitude,RD.status,RD.request_image,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,RAD.id as rad_id,RAD.status as rad_status,RAD.acceptor_id,
          U1.username as acceptor_name,U1.email as acceptor_email,U1.profile_img as acceptor_image,U1.mobile_no as acceptor_mobile");
      $this->db->from("request_details RD");
      $this->db->join('request_accept_details RAD', 'RAD.request_id = RD.r_id', 'LEFT');
      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');
      $this->db->join('users U1', 'U1.user_id = RAD.acceptor_id', 'LEFT');
      $this->db->where("MD5(RD.r_id)", $r_id);
      $this->db->where("RD.status = 1");
			$records = $this->db->get()->row_array();
      return $records;

    }
		public function change_request_status($req_id, $sts){

	    $result = $this->db->update('request_accept_details', array('status'=>$sts), array('id'=>$req_id));
	    return $result;
	  }

 	 public function delete_service($service_id)
 	 {
 		 	$new_details= array();
 	    $new_details['delete_status'] = 1;
 	    return $this->db->update('provider_details', $new_details, array('p_id'=>$service_id));
 	 }
 	    public function get_deviceids($id,$login_id)
   {
      $result_array = array();
      $where        = array();
      $result_array['android'] = array();
      $result_array['ios'] = array();

      $this->db->select('device_id');
      $where['device_type'] = 'ios';
      if($id!=0){
        $where['user_id']     = $id;
      }

      $this->db->where($where);
      $this->db->where('user_id !=', $login_id);
      $result_array['ios']  = $this->db->get('device_details')->result_array();

      $where        = array();
      $where['device_type'] = 'android';

      if($id!=0){
        $where['user_id']     = $id;
      }
      $this->db->select('device_id');
      $this->db->where($where);
      $this->db->where('user_id !=', $login_id);
      $result_array['android']  = $this->db->get('device_details')->result_array();
      return $result_array;
   }
   public function username($id)
   {
     $this->db->select('username');
     return $this->db->get_where('users', array('user_id'=>$id))->row_array();
   }

   public function provider($id)
   {
     $this->db->select('*');
     return $this->db->get_where('provider_details', array('p_id'=>$id))->row_array();
   }

   public function get_booked_service($provider_id, $user_id) {
   		$result = $this->db->get_where('book_service', array('MD5(provider_id)'=>$provider_id, 'user_id'=>$user_id))->row();
   		return $result;

   }

}

/* End of file Api_model.php */
/* Location: ./application/models/Api_model.php */
