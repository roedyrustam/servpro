<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
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

			$latitude   = $inputs['latitude'];
		  $longitude  = $inputs['longitude'];
		  $radius     = 100000;


               $longitude_min = $longitude - 100000 / abs(cos(deg2rad($longitude)) * 69);
               $longitude_max = $longitude + 100000 / abs(cos(deg2rad($longitude)) * 69);
               $latitude_min  = $latitude - (100000 / 69);
               $latitude_max  = $latitude + (100000 / 69);

      $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.request_image,RD.description,RD.location,RD.request_date,RD.request_time,RD.currency_code,RD.proposed_fee as amount,RD.contact_number,RD.latitude,RD.longitude,RD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,
			 1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - RD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(RD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - RD.longitude) * pi()/180 / 2), 2) )) AS distance");
      $this->db->from("request_details RD");
      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');
      $this->db->having('distance <=', $radius);
     if(!empty($accept)){
        $this->db->where_not_in('RD.r_id', $accept);
      }
      $this->db->where('RD.delete_status', 0);
      $this->db->where('RD.request_date <=', $this->date);
      $this->db->where("RD.status = 1  AND (RD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (RD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ")");
			$this->db->order_by('RD.created', 'DESC');
			$rescordss = $this->db->get()->result_array();
			$rescords = array();
			foreach($rescordss as $key => $value){
 				unset($value['distance']);
				 $rescords[] = $value;
			}

      return $rescords;
   }


   public function get_services($inputs)
    {
      $new_details = array();
      $user_id = $inputs['user_id'];
      $latitude   = $inputs['latitude'];
      $longitude  = $inputs['longitude'];
      $radius     = 100000;
               $longitude_min = $longitude - 100000 / abs(cos(deg2rad($longitude)) * 69);
               $longitude_max = $longitude + 100000 / abs(cos(deg2rad($longitude)) * 69);
               $latitude_min  = $latitude - (100000 / 69);
               $latitude_max  = $latitude + (100000 / 69);

      $this->db->select("PD.p_id,PD.user_id as provider_id,PD.title,PD.service_image,PD.location,PD.description_details,PD.contact_number,PD.availability,PD.latitude,PD.longitude,PD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,
       1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - PD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(PD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - PD.longitude) * pi()/180 / 2), 2) )) AS distance");
        $this->db->from('provider_details PD');
        $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');
        $this->db->having('distance <=', $radius);
        
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


        $this->db->select("PD.p_id,PD.user_id as provider_id,PD.title,PD.service_image,PD.location,PD.description_details,PD.contact_number,PD.availability,PD.latitude,PD.longitude,PD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,
       1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - PD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(PD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - PD.longitude) * pi()/180 / 2), 2) )) AS distance");
        $this->db->from('provider_details PD');
        $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');
        $this->db->having('distance <=', $radius);
       
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
      return $rescords;

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

  public function get_requestdetails()
  {
    $accept = $this->get_accept();
    $query=$this->db->select('*');
    if(!empty($accept)){
        $this->db->where_not_in('request_details.r_id', $accept);
      }
    $this->db->where('status', 1);
    $num = $this->db->get('request_details')->num_rows();

    return $num;
  }
  public function get_total_services()
  {
    $query=$this->db->select('*');
    $this->db->where('status', 1);
    $num = $this->db->get('provider_details')->num_rows();

    return $num;
  }
   public function get_total_users()
  {
    $query=$this->db->select('*');
    $this->db->where('role', 2);
    $this->db->where('is_active', 1);
    $num = $this->db->get('users')->num_rows();

    return $num;
  }

  public function get_search_request($inputs)
   {

      $new_details = array();
      $user_id = $inputs['user_id'];
      $search_title = $inputs['search_title'];

      
      $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,RD.request_time,RD.currency_code,RD.proposed_fee as amount,RD.contact_number,RD.latitude,RD.longitude,RD.request_image,RD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no");
      $this->db->from("request_details RD");
      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');
      if(!empty($search_title)){
          $this->db->like('title', $search_title,'BOTH');
        }
      $this->db->where('RD.delete_status', 0);
      $this->db->where('RD.request_date >=', $this->date);
      $this->db->where("RD.status = 1");
      $this->db->order_by('RD.created', 'DESC');
      $this->db->limit(4);
      $rescordss = $this->db->get()->result_array();

      $rescords = array();
      foreach($rescordss as $key => $value){
        unset($value['distance']);
         $rescords[] = $value;
      }

      return $rescords;
   }

   public function fetch_data($service_title) {
      $userdata = $this->db->where('status',1)->like('title', $service_title)->get('request_details')->result_array();
        $data = json_encode($userdata);
        return $data;
    }
}
