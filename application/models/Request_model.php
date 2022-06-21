<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_model extends CI_Model {

	public function __construct() {

        parent::__construct();
        $this->load->database();
         $this->load->helper('user_timezone');
        date_default_timezone_set('UTC');
        $this->date = date('Y-m-d');
        $this->date = utc_date_conversion($this->date);
        $this->date = date('Y-m-d',strtotime($this->date));
    }

    public function get_request($inputs)
    {


      $new_details = array();
      $user_id = $inputs['user_id'];

      $accept =  $this->get_accept();


      $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;
      $latitude   = $inputs['latitude'];
	    $longitude  = $inputs['longitude'];
	    $radius     = 10;


       $longitude_min = $longitude - 100 / abs(cos(deg2rad($longitude)) * 69);
       $longitude_max = $longitude + 100 / abs(cos(deg2rad($longitude)) * 69);
       $latitude_min  = $latitude - (100 / 69);
       $latitude_max  = $latitude + (100 / 69);

		

      $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, '%h:%i %p') as request_time,RD.proposed_fee as amount,RD.currency_code,RD.contact_number,RD.latitude,RD.longitude,RD.status,RD.request_image,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,
			 1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - RD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(RD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - RD.longitude) * pi()/180 / 2), 2) )) AS distance");
      $this->db->from("request_details RD");
      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');

      if(!empty($accept)){
        $this->db->where_not_in('RD.r_id', $accept);
      }
      $this->db->where('RD.delete_status', 0);
      $this->db->where('RD.request_date >=', $this->date);

       if(!empty($inputs['search_title'])){
          $this->db->like('title', $inputs['search_title'],'BOTH');
        }
        if(!empty($inputs['request_date'])){
          $this->db->where('request_date', $inputs['request_date']);
        }
        if(!empty($inputs['request_time'])){
          $request_time = strtotime($inputs['request_time']);
          $request_time = date('H:i',$request_time);
          $this->db->where('request_time >=',$request_time.':00' );
          $this->db->where('request_time <=',$request_time.':59' );
        }
        if(!empty($inputs['min_price']) && !empty($inputs['max_price'])){

          $this->db->where('proposed_fee >=', $inputs['min_price']);
          $this->db->where('proposed_fee <=', $inputs['max_price']);
        }

        if(!empty($inputs['location'])){
          $this->db->like('location', $inputs['location'],'BOTH');
        }

      $this->db->order_by('RD.request_date', 'ASC');
      $this->db->limit(10, $offset);
			$rescordss = $this->db->get()->result_array();

			$rescords = array();

      if(count($rescordss) > 0){
        foreach($rescordss as $key => $value){
         
           unset($value['distance']);
            $rescords[] = $value;
        }
      }

$count=$rescordss?count($rescordss):0;
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

	public function get_request_details($r_id)
   {

      $new_details = array();

      $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,RD.request_time,RD.currency_code,RD.proposed_fee as amount,RD.contact_number,RD.latitude,RD.longitude,RD.status,RD.request_image,RD.country_code,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no");
      $this->db->from("request_details RD");
      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');
      $this->db->where("MD5(RD.r_id)", $r_id);
      $this->db->where("RD.status = 1");
	   
       $rescords = $this->db->get()->row_array();
      return $rescords;
   }



     public function create_new_request($input)
    {
      
    
      $new_details = array();
      
      $user_id = $this->session->userdata('user_id');
      $title   = $input['title'];

      $this->db->where('title', $title);
      $this->db->where('user_id', $user_id);
      $count = $this->db->count_all_results('request_details');

      if($count == 0){
      $new_details['user_id'] = $user_id;
      $new_details['title'] = $input['title'];
      $new_details['description'] = json_encode($input['description']);
      $new_details['location'] = $input['location'];
      $new_details['request_date'] = date('Y-m-d',strtotime($input['request_date']));
      $new_details['request_time'] = date('G:i:s a', strtotime($input['request_time']));
      $new_details['proposed_fee'] = $input['proposed_fee']; 
      $new_details['country_code'] = $input['countryCode']; 
      $new_details['contact_number'] = $input['contact_number'];
      $new_details['latitude'] = $input['latitude'];
      $new_details['longitude'] = $input['longitude'];
      $new_details['currency_code'] = ($this->session->userdata('usercurrency_code'))?$this->session->userdata('usercurrency_code'):'USD';
      $new_details['request_image'] = ($input['request_image'])?$input['request_image']:'';
      $new_details['created'] =  date('Y-m-d H:i:s');
      
      return   $this->db->insert('request_details', $new_details);

      }else{
        return 2; // Already Exists
      }
 }

 public function update_request($input)
    {
      $array = $input['data'];
      parse_str($array, $inputs);
      $new_details = array();

      $user_id = $this->session->userdata('user_id');
      $title   = $inputs['title'];
      $r_id = $inputs['r_id'];

      $this->db->where('title', $title);
      $this->db->where('r_id !=', $r_id);
      $this->db->where('user_id', $user_id);
      $count = $this->db->count_all_results('request_details');
      
      if($count == 0){
      $new_details['title'] = $inputs['title'];
      $new_details['description'] = json_encode($inputs['description']);
      $new_details['location'] = $inputs['location'];
      $new_details['request_date'] = date('Y-m-d',strtotime($inputs['request_date']));
      $new_details['request_time'] = $inputs['request_time'];
      $new_details['proposed_fee'] = $inputs['proposed_fee'];
      $new_details['country_code'] = $input['countryCode']; 
      $new_details['contact_number'] = $inputs['contact_number'];
      $new_details['latitude'] = $inputs['latitude'];
      $new_details['longitude'] = $inputs['longitude'];
      $new_details['request_image'] = (!empty($inputs['request_image']))?"uploads/add_request_image/" . $inputs['request_image']:'';
      $new_details['created'] =  date('Y-m-d H:i:s');

      return $this->db->update('request_details', $new_details, array('r_id' => $r_id));
      }else{
        return 2; // Already Exists
      }
 }


 public function request_accept($request_id)
 {
          $current_time = date('Y-m-d H:i:s');

        $subscriber_id = $this->session->userdata('user_id');

        $this->db->select('user_id AS requester_id,r_id');
        $this->db->where('md5(r_id)', $request_id);
        $row = $this->db->get('request_details')->row_array();
        $requester_id = $row['requester_id'];
        $request_id = $row['r_id'];

        $new_details = array();
        $new_details['acceptor_id'] = $subscriber_id;
        $new_details['request_id'] =  $request_id;
        $new_details['requester_id'] = $requester_id;
        $new_details['status'] = 1;
        $new_details['accept_date_time'] = $current_time;
        return $this->db->insert('request_accept_details', $new_details);
 }

   public function get_accept()
   {
      $this->db->select('request_id');
      $records = $this->db->get('request_accept_details')->result_array();
       if(!empty($records)){
        $records = array_map('current', $records);
       }
     return $records;
   }

     public function my_request($inputs)
   {

      $user_id = $inputs['user_id'];
      $new_details = array();
      if(isset($inputs['nextpage'])){
        $inputs['page'] = $inputs['nextpage'];
      }

      if(isset($inputs['search_filter'])){
        $filter_by = $inputs['search_filter'];
      }else{
        $filter_by = '4'; //All

      }
        $filter_by = ($filter_by!=10)?$filter_by:'';

      // 0 - Pending, 1- Accepted, 2 - Completed
  

      $this->db->select('RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, "%h:%i %p") as request_time,RD.request_time as requesttime,RD.proposed_fee as amount,RD.currency_code,RD.contact_number,RD.latitude,RD.longitude, RD.request_image, U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,RD.status,IF(RAD.status IS NULL,0,RAD.status) as request_accept_status');
      $this->db->from('request_details RD');
      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');
      $this->db->join('request_accept_details RAD', 'RAD.request_id = RD.r_id', 'LEFT');

      if($filter_by == 1 || $filter_by == 2){ // 1- Accepted, 2 - Completed
        $this->db->where('RAD.status',$filter_by);
      }
      if($filter_by == 0 && $filter_by!=''){ // 0 -pending

       $this->db->where('RD.status',1);
       $this->db->having('request_accept_status', 0);
       $this->db->where('RD.request_date >=', $this->date);
      }

      $this->db->where('RD.delete_status', 0);
      $this->db->where('RD.user_id', $user_id);
      $this->db->order_by('RD.r_id', 'ASC');
      $count = $this->db->get()->num_rows();



      $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;

      $this->db->select('RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, "%h:%i %p") as request_time,RD.request_time as requesttime,RD.proposed_fee as amount,RD.currency_code,RD.contact_number,RD.latitude,RD.longitude, RD.request_image, U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,RD.status,IF(RAD.status IS NULL,0,RAD.status) as request_accept_status');
      $this->db->from('request_details RD');
      $this->db->where('RD.status',1);
      $this->db->where('RD.delete_status', 0);
      $this->db->where('RD.user_id', $user_id);
      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');
      $this->db->join('request_accept_details RAD', 'RAD.request_id = RD.r_id', 'LEFT');


      if($filter_by == 1 || $filter_by == 2){ // 1- Accepted, 2 - Completed
        $this->db->where('RAD.status',$filter_by);
      }
      if($filter_by == 0 && $filter_by!=''){// 0 -pending

       $this->db->where('RD.status',1);
       $this->db->having('request_accept_status', 0);
       $this->db->where('RD.request_date >=', $this->date);
      }

      $this->db->order_by('RD.r_id', 'ASC');

      $this->db->limit(10, $offset);
      $rescords_array = $this->db->get()->result_array();
    
      $rescords = array();
      if(count($rescords_array) >0){
        foreach ($rescords_array as $array) {

          date_default_timezone_set("Asia/Kuala_Lumpur");
          $date_time = date('Y-m-d H:i:s');

          $rad_status = $array['request_accept_status'];
          $status = $array['status'];
          $request_date = $array['request_date'].' '.$array['requesttime'];

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
          unset($array['requesttime'],$array['request_accept_status']);

          $rescords[] = $array;
        }
      }

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

	 public function delete_request($request_id)
	 {
		 	$new_details= array();
	    $new_details['delete_status'] = 1;
	    return $this->db->update('request_details', $new_details, array('r_id'=>$request_id));
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


   public function mybooking($inputs)
   {

        $user_id = $inputs['user_id'];
      $new_details = array();
      if(isset($inputs['nextpage'])){
        $inputs['page'] = $inputs['nextpage'];
      }

      if(isset($inputs['search_filter'])){
        $filter_by = $inputs['search_filter'];
      }else{
        $filter_by = ''; //All

      }
        $filter_by = ($filter_by!=10)?$filter_by:'';

      // 0 - Pending, 1- Accepted, 2 - Completed
  

      $this->db->select('bs.*, pd.title,pd.contact_number,pd.service_image, u.full_name,u.profile_img');
      $this->db->from('book_service bs');
      $this->db->join('provider_details pd', 'bs.provider_id=pd.p_id', 'LEFT');
      $this->db->join('users u', 'u.user_id=pd.user_id', 'LEFT');
      $this->db->where('bs.user_id', $user_id);
      if(isset($filter_by)&& !empty($filter_by))
      {
        $this->db->where('bs.service_status', $filter_by);
      }
      $count = $this->db->get()->num_rows();



      $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;

      $this->db->select('bs.*,count(rr.id) as review_count,DATE_FORMAT(bs.service_date, "%d-%M-%Y") as service_dates, TIME_FORMAT(bs.from_time, "%h:%i %p") as from_times, TIME_FORMAT(bs.to_time, "%h:%i %p") as to_times, pd.title,pd.contact_number, u.full_name,u.profile_img,pd.service_image');
      $this->db->from('book_service bs');
      $this->db->join('provider_details pd', 'bs.provider_id=pd.p_id', 'LEFT');
      $this->db->join('users u', 'u.user_id=pd.user_id', 'LEFT');
      $this->db->join('rating_review rr', '(rr.user_id=bs.user_id AND rr.p_id=bs.provider_id)', 'LEFT');
      $this->db->where('bs.user_id', $user_id);
      $this->db->group_by('bs.id');
      if(isset($filter_by)&& !empty($filter_by))
      {
        $this->db->where('bs.service_status', $filter_by);
      }

      $this->db->limit(10, $offset);
      $rescords_array = $this->db->get()->result_array();
    


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
      $new_details['request_list'] = $rescords_array;
      return $new_details;


   }

   public function bookingservice($inputs)
   {

        $user_id = $inputs['user_id'];
      $new_details = array();
      if(isset($inputs['nextpage'])){
        $inputs['page'] = $inputs['nextpage'];
      }

      if(isset($inputs['search_filter'])){
        $filter_by = $inputs['search_filter'];
      }else{
        $filter_by = ''; //All

      }
        $filter_by = ($filter_by!=10)?$filter_by:'';

      // 0 - Pending, 1- Accepted, 2 - Completed
  

      $this->db->select('bs.*, TIME_FORMAT(bs.from_time, "%h:%i %p") as from_times, TIME_FORMAT(bs.to_time, "%h:%i %p") as to_times, pd.title,u.mobile_no, u.full_name,u.profile_img');
      $this->db->from('book_service bs');
      $this->db->join('provider_details pd', 'bs.provider_id=pd.p_id', 'LEFT');
      $this->db->join('users u', 'u.user_id=bs.user_id', 'LEFT');
      $this->db->where('pd.user_id', $user_id);
      if(isset($filter_by)&& !empty($filter_by))
      {
        $this->db->where('bs.service_status', $filter_by);
      }

      $count = $this->db->get()->num_rows();



      $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;

      $this->db->select('bs.*, DATE_FORMAT(bs.service_date, "%d-%M-%Y") as service_dates, TIME_FORMAT(bs.from_time, "%h:%i %p") as from_times, TIME_FORMAT(bs.to_time, "%h:%i %p") as to_times, pd.title,u.mobile_no, u.full_name,u.profile_img');
      $this->db->from('book_service bs');
      $this->db->join('provider_details pd', 'bs.provider_id=pd.p_id', 'LEFT');
      $this->db->join('users u', 'u.user_id=bs.user_id', 'LEFT');
      $this->db->where('pd.user_id', $user_id);
      if(isset($filter_by)&& !empty($filter_by))
      {
        $this->db->where('bs.service_status', $filter_by);
      }

      $this->db->limit(10, $offset);
      $rescords_array = $this->db->get()->result_array();
   

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
      $new_details['request_list'] = $rescords_array;
      return $new_details;


   }

}

/* End of file Api_model.php */
/* Location: ./application/models/Api_model.php */
