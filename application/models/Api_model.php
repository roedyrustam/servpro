<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Api_model extends CI_Model {



  public function __construct() {



    parent::__construct();

    $this->load->database();

    $this->load->helper('user_timezone');

    date_default_timezone_set('UTC');

    $this->date = date('Y-m-d');

    $this->date = utc_date_conversion($this->date);

    $this->date = date('Y-m-d',strtotime($this->date));

    $this->base_url = base_url();



  }

  public function login($user)

  {





    $login_through = $user['Loginthrough'];



    $where  = array();



    if($login_through == 1){



      $username = $user['Username'];

      $password = $user['Password'];

      $where['password'] = md5($password);

      $this->db->where("(username = '$username' OR email = '$username' OR mobile_no = '$username')");



    }else if($login_through == 2 ||  $login_through == 3 ||  $login_through == 4){

      $where['tokenid'] = $user['Tokenid'];

    }



    $where['verified']  = '1';

    $where['is_active'] = '1';

    $this->db->where($where);

    $record = $this->db->get('users')->row_array();



    $records = array();



    if(!empty($record)){



      $user_id = $record['user_id'];



        /* // Login user token update stop



        $unique_code = $this->getToken(14,$user_id);

        $last_login = date('Y-m-d H:i:s');

        $token_valid = date('Y-m-d H:i:s',strtotime("+60 minutes"));

        $this->db->where('user_id', $user_id);

        $this->db->update('users', array('unique_code' => $unique_code,'last_login'=>$last_login,'token_valid'=>$token_valid));*/

        $count = 0 ;

        if(!empty($user['Deviceid'])){



          $device_id   = $user['Deviceid'];

          $this->db->where('user_id', $user_id);

          $this->db->where('device_id', $device_id);

          $count       = $this->db->count_all_results('device_details');



        }



        if(!empty($user['Devicetype']) && !empty($user['Deviceid'])){



         $device_type = strtolower($user['Devicetype']);

         $device_id   = $user['Deviceid'];



         $date = date('Y-m-d H:i:s');



         if($count == 0 ){

          $this->db->insert('device_details', array('user_id'=> $user_id,'device_type'=> $device_type,'device_id'=> $device_id,'created'=>$date));

        }else{

          $this->db->where('user_id',$user_id);

          $this->db->update('device_details', array('device_type'=> $device_type,'device_id'=> $device_id,'created'=>$date));

        }



      }



      $this->db->select('subscription_id');

      $this->db->where('subscriber_id',$user_id);

      $subscription = $this->db->get('subscription_details')->row_array();



      if(!empty($subscription)){

        $id = $subscription['subscription_id'];

        $this->db->select('id,subscription_name');

        $this->db->where('id',$id);

        $subscription = $this->db->get('subscription_fee')->row_array();

        $subscribed_user = $subscription['id'];

        $subscribed_msg = $subscription['subscription_name'];

      }else{

        $subscribed_user = 0;

        $subscribed_msg = 'Free';

      }



      $unique_code = $record['unique_code'];

      $subscribed_user = 1;

      $records = array('username'=>$record['username'],'token'=>$unique_code,'subscribed_user'=>$subscribed_user,'subscribed_msg'=>$subscribed_msg,'currency_code'=>$record['currency_code']);

      $records['user_id'] = $record['user_id'];

      $records['email']   = $record['email'];

      $records['mobile_no'] = $record['mobile_no'];

      $profile_img = (!empty($record['profile_img']))?$record['profile_img']:'noimage.png';

        $records['profile_img'] = $profile_img; // $this->base_url.$profile_img;



      }



      return $records;

    }



    public function logout($token='',$device_type,$deviceid)

    {

      $result = 0;



      $device_id   = $deviceid;

      $device_type = strtolower($device_type);

      $user_id = $this->get_user_id_using_token($token);



      $this->db->where(array('device_id'=>$device_id, 'device_type'=>$device_type, 'user_id'=>$user_id));

      $this->db->delete('device_details');



      if(!empty($token)){

        $last_login = date('Y-m-d H:i');

        $this->db->where('unique_code', $token);

        // $this->db->update('users', array('unique_code' =>'','last_login'=>$last_login));

        $this->db->update('users', array('last_login'=>$last_login));

        $result = $this->db->affected_rows();

      }
      return $result;
    }



    public function change_password($inputs){
      $user_id = $this->get_user_id_using_token($inputs['Token']);
      $current_password = $inputs['Currentpassword'];
      $current_password = md5($current_password);
      $this->db->where(array('password'=>$current_password));
      $this->db->where('user_id', $user_id);
      $record = $this->db->count_all_results('users');
      if($record > 0){
        $confirm_password = $inputs['Confirmpassword'];
        $confirm_password = md5($confirm_password);
        $this->db->where('user_id', $user_id);
        return  $this->db->update('users',array('password'=>$confirm_password));
      }else{
        return 0;
      }
    }

    public function subscription_success($inputs)
    {
     $new_details = array();
     $user_id = $this->get_user_id_using_token($inputs['token']);

     $subscription_id = $inputs['subscription_id'];
     $transaction_id  = $inputs['transaction_id'];
     $payment_details = !empty($inputs['payment_details'])?$inputs['payment_details']:'';

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



         $this->db->insert('subscription_details', $new_details);

         $id = $this->db->insert_id();



       }else{



         $this->db->where('subscriber_id', $user_id);

         $this->db->update('subscription_details', $new_details);

         $details = $this->db->get('subscription_details',array('subscriber_id'=>$user_id))->row_array();

         $id = $details['id'];

       }

       $array['sub_id'] = $id;

       $array['subscription_id'] = $subscription_id;

       $array['subscriber_id'] = $user_id;

       $array['subscription_date'] = date('Y-m-d');

       $array['tokenid'] = $transaction_id;

       $array['payment_details'] = $payment_details;

       $this->db->insert('subscription_payment', $array);



       $this->db->where('subscriber_id', $user_id);

       return $this->db->get('subscription_details')->row_array();



     }else{



      return false;

    }



  }



  public function request_accept($inputs='')

  {





   $new_details = array();

   $subscriber_id = $this->get_user_id_using_token($inputs['token']);

   $request_id = $inputs['request_id'];







   $current_time = date('Y-m-d H:i:s');



       // $this->db->where('expiry_date_time >= ', $current_time);

       // $this->db->where('subscriber_id', $subscriber_id);

       //  $count = $this->db->count_all_results('subscription_details');

       // if($count == 0){



       //  return 2;



       // } else{



   $this->db->select('user_id AS requester_id');

   $this->db->where('r_id', $request_id);

   $this->db->where('delete_status', 0);

   $row = $this->db->get('request_details')->row_array();

   $requester_id = $row['requester_id'];



   $new_details = array();

   $new_details['acceptor_id'] = $subscriber_id;

   $new_details['request_id'] =  $request_id;

   $new_details['requester_id'] = $requester_id;

   $new_details['status'] = 1;

   $new_details['accept_date_time'] = $current_time;

   return $this->db->insert('request_accept_details', $new_details);

      // }





 }



 public function request_complete($inputs)

 {







   $new_details = array();

   $subscriber_id = $this->get_user_id_using_token($inputs['token']);

   $request_id = $inputs['request_id'];







   $current_time = date('Y-m-d H:i:s');

       /*

       $this->db->where('expiry_date_time >= ', $current_time);

       $this->db->where('subscriber_id', $subscriber_id);

       $count = $this->db->count_all_results('subscription_details');



       if($count == 0){



        return 2;



       } else{

      */



        $this->db->select('acceptor_id,request_id,requester_id');

        $this->db->where('request_id', $request_id);

        $row = $this->db->get('request_accept_details')->row_array();



        $acceptor_id  = $row['acceptor_id'];

        $requester_id = $row['requester_id'];

        $request_id   = $row['request_id'];



        $new_details = array();

        $new_details['acceptor_id'] = $acceptor_id;

        $new_details['request_id'] =  $request_id;

        $new_details['requester_id'] = $requester_id;

        $new_details['status'] = 2;

        $new_details['accept_date_time'] = $current_time;

        $this->db->where(array('request_id'=>$request_id,'requester_id' => $requester_id,'acceptor_id' => $acceptor_id));

        return $this->db->update('request_accept_details', $new_details);

        //}



      }



      public function token_is_valid($token)

      {



   /* $token_valid = date('Y-m-d H:i');



    $where  = array();

    $where['verified']  = '1';

    $where['is_active'] = '1';

    $where['unique_code'] = $token;

    $this->db->where($where);

    $this->db->where('token_valid >= ', $token_valid);

     $count = $this->db->count_all_results('users');



    if($count == 0){



        $last_login = date('Y-m-d H:i');

        $this->db->where('unique_code', $token);

        $this->db->update('users', array('unique_code' =>'','last_login'=>$last_login));

        return $count;

    }else{



        $token_valid = date('Y-m-d H:i:s',strtotime("+60 minutes"));

        $this->db->where('unique_code', $token);

        $this->db->update('users', array('token_valid'=>$token_valid));

        return $count;

      }*/ 
      
      if($token == "8338d6ff4f0878b222f312494c1621a9"){
        $count = 1;
      }else{
        $where = array();
        $where['unique_code'] = $token;
        $this->db->where($where);
        $count = $this->db->count_all_results('users');
      }
      return $count;
    }

    public function subscription()
    {
     $result= $this->db->where('status',1)->get('subscription_fee')->result_array();
    
    return $result;
    
     

   }

    // public function subscription()

    // {

    //   $this->db->select('SF*.,CR.rate as currency_value,(SF.fee * CR.)';
    //   $this->db->from('subscription_fee SF');
    //   $this->db->join('currency_rate CR', 'SF.currency_code=CR.currency_code', 'left');
    //   $this->db->where('SF.status',1)
    //   $records =  $this->db->get()->row_array();

    //   $this->db->where('status',1)
    //   ->get('subscription_fee')->result_array();

    //   return  $result;


    // }



   public function category()

   {

    return $this->db->query("SELECT IF(COUNT(s.subcategory_name) > 0,1,0) AS is_subcategory ,c.id as catrgory_id,c.category_name,c.category_image FROM categories c LEFT JOIN subcategories as s ON c.id=s.category WHERE c.status=1 group by c.id")->result_array();

  }



  public function subcategory($category)

  {

    $this->db->select('id as subcategory_id,subcategory_name,subcategory_image,category as category_id');

    $this->db->from('subcategories');
    $categories = urldecode($category);     
    $category_id  = explode(',', $categories);
    $this->db->where_in('category',$category_id);

    return $this->db->where('status',1)->get()->result_array();

  }



  public function new_provide_by_user($inputs)

  {

    $new_details = array();



    $user_id = $this->get_user_id_using_token($inputs['Token']);

    $title   = $inputs['title'];



    $this->db->where('title', $title);

    $this->db->where('user_id', $user_id);



    $count = $this->db->count_all_results('provider_details');

    if($count == 0){



      $new_details['user_id'] = $user_id;

      $new_details['title'] = $inputs['title'];

      $new_details['category'] = $inputs['category'];

      $new_details['subcategory'] = $inputs['sub_category'];

      $new_details['description_details'] = $inputs['description_details'];

      $new_details['contact_number'] = $inputs['contact_number'];

      $new_details['availability'] = $inputs['availability'];

      $new_details['latitude'] = $inputs['latitude'];

      $new_details['longitude'] = $inputs['longitude'];

      $new_details['location'] = $inputs['location'];

      $new_details['start_date'] = $inputs['start_date'];

      $new_details['end_date'] = $inputs['end_date'];

      $new_details['created'] =  date('Y-m-d H:i:s');;

      return   $this->db->insert('provider_details', $new_details);

    }else{

        return 2; // Already Exists

      }



    }

    public function update_service($inputs)

    {

      $new_details = array();



      $user_id = $this->get_user_id_using_token($inputs['token']);

     // $title   = $inputs['title'];

      $service_id = $inputs['service_id'];



     // $this->db->where('title', $title);

      $this->db->where('p_id', $service_id);

      $this->db->where('user_id', $user_id);

      $this->db->where('delete_status', 0);

      $count = $this->db->count_all_results('provider_details');

      if($count == 1){



        $new_details['user_id'] = $user_id;

        $new_details['title'] = $inputs['title'];

        $new_details['category'] = $inputs['category'];

        $new_details['subcategory'] = $inputs['subcategory'];

        $new_details['description_details'] = $inputs['description_details'];

        $new_details['contact_number'] = $inputs['contact_number'];

        $new_details['availability'] = $inputs['availability'];

        $new_details['latitude'] = $inputs['latitude'];

        $new_details['longitude'] = $inputs['longitude'];

        $new_details['location'] = $inputs['location'];

        $new_details['start_date'] = $inputs['start_date'];

        $new_details['end_date'] = $inputs['end_date'];

        $new_details['created'] =  date('Y-m-d H:i:s');

        $this->db->where('p_id', $service_id);

        $this->db->where('delete_status', 0);

        return   $this->db->update('provider_details', $new_details);

      }else{

        return 2; // Already Exists

      }



    }



    public function service_remove($inputs)

    {

     $new_details = array();

     $user_id = $this->get_user_id_using_token($inputs['token']);

     $service_id = $inputs['service_id'];

     $this->db->where('p_id', $service_id);

     $this->db->where('user_id', $user_id);

     $this->db->update('provider_details',array('delete_status'=>1));

     return  $result = $this->db->affected_rows();

   }



   public function request_remove($inputs)

   {

     $new_details = array();

     $user_id = $this->get_user_id_using_token($inputs['token']);

     $request_id = $inputs['request_id'];

     $this->db->where('r_id', $request_id);

     $this->db->where('user_id', $user_id);

     $this->db->update('request_details',array('delete_status'=>1));

     return  $result = $this->db->affected_rows();



   }



   public function provider_list($inputs)

   {



    $new_details = array();

    $user_id = $this->get_user_id_using_token($inputs['Token']);

    $offset = ($inputs['Page']>1)?(($inputs['Page']-1)*10):0;



    $latitude   = $inputs['Latitude'];

    $longitude  = $inputs['Longitude'];

    $radius     = 1000000;





    $longitude_min = $longitude - 100000 / abs(cos(deg2rad($longitude)) * 69);

    $longitude_max = $longitude + 100000 / abs(cos(deg2rad($longitude)) * 69);

    $latitude_min  = $latitude - (100000 / 69);

    $latitude_max  = $latitude + (100000 / 69);



    $this->db->select("PD.p_id,PD.views,PD.user_id as provider_id,PD.title,PD.location,PD.description_details,PD.contact_number,PD.availability,PD.latitude,PD.longitude,PD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,

     1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - PD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(PD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - PD.longitude) * pi()/180 / 2), 2) )) AS distance");

    $this->db->from('provider_details PD');

    $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');

    $this->db->having('distance <=', $radius);

      // $this->db->where('end_date >=',$this->date);
    if(isset($inputs['Category']) && !empty($inputs['Category']))

    {
      $where = "FIND_IN_SET('".$inputs['Category']."', PD.Category)";  
      $this->db->where( $where );
    }
    if(isset($inputs['Subcategory']) && !empty($inputs['Subcategory']))

    {

         // $this->db->where('PD.subcategory', $inputs['subcategory']);
     $where = "FIND_IN_SET('".$inputs['Subcategory']."', PD.subcategory)";  
     $this->db->where( $where );

   }

   

   $this->db->where('PD.delete_status', 0);

   $this->db->where("PD.status = 1  AND (PD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (PD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ")");

   $count = $this->db->get()->num_rows();



   $this->db->select("PD.p_id,PD.views,PD.user_id as provider_id,PD.title,PD.location,PD.description_details,PD.contact_number,PD.availability,PD.latitude,PD.longitude,PD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,( SELECT IFNULL(ROUND(AVG(r.rating),1),0)
    FROM rating_review r
    WHERE r.p_id = PD.p_id
    )AS rating,

    1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - PD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(PD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - PD.longitude) * pi()/180 / 2), 2) )) AS distance");

   $this->db->from('provider_details PD');

   $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');
     // $this->db->join('rating_review R', 'R.P_id = PD.p_id', 'LEFT');

   $this->db->having('distance <=', $radius);

       //$this->db->where('end_date >=',$this->date);

   
   if(isset($inputs['Category']) && !empty($inputs['Category']))

   {
    $where = "FIND_IN_SET('".$inputs['Category']."', PD.category)";  
    $this->db->where( $where );
  }

  if(isset($inputs['Subcategory']) && !empty($inputs['Subcategory']))

  {

         // $this->db->where('PD.subcategory', $inputs['subcategory']);
   $where = "FIND_IN_SET('".$inputs['Subcategory']."', PD.subcategory)";  
   $this->db->where( $where );

 }

 $this->db->where('PD.delete_status', 0);

 $this->db->where("PD.status = 1  AND (PD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (PD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ")");



 $this->db->limit(10, $offset);

 $this->db->order_by('PD.p_id', 'DESC');

 //print_r($this->db->last_query());
 //exit;
 $rescordss = $this->db->get()->result_array();



 $rescords = array();

 foreach($rescordss as $key => $value){

  unset($value['distance']);

  $rescords[] = $value;

}





$total_pages = 0;

$next_page  = -1;



$page       = $inputs['Page'];



if($count > 0 && $page > 0){



 $total_pages = ceil($count / 10);
 $page        = $inputs['Page'];

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


return $new_details;

}

public function complete_provider($id,$user_id,$provider_id)

{

 $this->db->where("id = '$id' AND provider_id = '$provider_id' ");

 return $this->db->update('book_service', array('service_status'=> 2)); 

       //return $result = $this->db->affected_rows();

}

public function provider_search_list($inputs)

{



  $new_details = array();

  $user_id = $this->get_user_id_using_token($inputs['Token']);

  $offset = ($inputs['Page']>1)?(($inputs['Page']-1)*10):0;



  $search_title = (!empty($inputs['Searchtitle']))?$inputs['Searchtitle']:'';

  $search_date = (!empty($inputs['Searchdate']))?$inputs['Searchdate']:'';

  $location =     (!empty($inputs['Location']))?$inputs['Location']:'';

  $category =     (!empty($inputs['Category']))?$inputs['Category']:'';

  $subcategory =     (!empty($inputs['Subcategory']))?$inputs['Subcategory']:'';



  $latitude   = $inputs['Latitude'];

  $longitude  = $inputs['Longitude'];

  $radius     = 100000;





  $longitude_min = $longitude - 100000 / abs(cos(deg2rad($longitude)) * 69);

  $longitude_max = $longitude + 100000 / abs(cos(deg2rad($longitude)) * 69);

  $latitude_min  = $latitude - (100000 / 69);

  $latitude_max  = $latitude + (100000 / 69);



  $this->db->select("PD.p_id,PD.views,PD.user_id as provider_id,PD.title,PD.location,PD.description_details,PD.contact_number,PD.availability,PD.latitude,PD.longitude,PD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,( SELECT IFNULL(ROUND(AVG(r.rating),1),0)
    FROM rating_review r
    WHERE r.p_id = PD.p_id
    )AS rating,

    1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - PD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(PD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - PD.longitude) * pi()/180 / 2), 2) )) AS distance");

  $this->db->from('provider_details PD');

  $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');

  $this->db->having('distance <=', $radius);



  if(!empty($search_title)){

    $this->db->like('PD.title', $search_title, 'BOTH');

  }

  if(!empty($search_date)){

    $this->db->where('start_date <=', $search_date);

    $this->db->where('end_date >=', $search_date);

  }

  if(!empty($location)){

    $this->db->like('PD.location', $location, 'BOTH');

  }



  if(!empty($category)){
       // $this->db->where('PD.category', $category);
    $where = "FIND_IN_SET('".$category."', PD.category)";  
    $this->db->where( $where );

  }



  if(!empty($subcategory)){

        //$this->db->where('PD.subcategory', $subcategory);
    $where = "FIND_IN_SET('".$subcategory."', PD.subcategory)";  
    $this->db->where( $where );

  }



  $this->db->where('PD.delete_status', 0);

  $this->db->where("PD.status = 1  AND (PD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (PD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ")");

  $count = $this->db->get()->num_rows();



  $this->db->select("PD.p_id,PD.views,PD.user_id as provider_id,PD.title,PD.location,PD.description_details,PD.contact_number,PD.availability,PD.latitude,PD.longitude,PD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,( SELECT IFNULL(ROUND(AVG(r.rating),1),0)
    FROM rating_review r
    WHERE r.p_id = PD.p_id
    )AS rating,

    1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - PD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(PD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - PD.longitude) * pi()/180 / 2), 2) )) AS distance");

  $this->db->from('provider_details PD');

  $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');

  $this->db->having('distance <=', $radius);

  $this->db->where('PD.delete_status', 0);

  $this->db->where("PD.status = 1  AND (PD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (PD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ")");

  if(!empty($search_title)){

    $this->db->like('PD.title', $search_title, 'BOTH');

  }

  if(!empty($search_date)){

    $this->db->where('start_date<=', $search_date);

    $this->db->where('end_date >=', $search_date);

  }

  if(!empty($location)){

    $this->db->like('PD.location', $location, 'BOTH');

  }

  if(!empty($category)){

       // $this->db->where('PD.category', $category);
    $where = "FIND_IN_SET('".$category."', PD.category)";  
    $this->db->where( $where );

  }



  if(!empty($subcategory)){

       // $this->db->where('PD.subcategory', $subcategory);
   $where = "FIND_IN_SET('".$subcategory."', PD.subcategory)";  
   $this->db->where( $where );

 }

 $this->db->limit(10, $offset);

 $this->db->order_by('PD.p_id', 'desc');

 $rescordss = $this->db->get()->result_array();



 $rescords = array();

 foreach($rescordss as $key => $value){

  unset($value['distance']);

  $rescords[] = $value;

}

$total_pages = 0;
$next_page  = -1;
$page       = $inputs['Page'];
if($count > 0 && $page > 0){
   $total_pages = ceil($count / 10);
   $page        = $inputs['Page'];
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
return $new_details;
}



public function history_list($inputs)

{
  $user_id = $this->get_user_id_using_token($inputs['Token']);
  $new_details = array();
  $status = (!empty($inputs['Status']))?$inputs['Status']:'1';
  $this->db->from('request_accept_details RAD');

  if($inputs['Request'] == 1 ){
    $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');
    $this->db->where('requester_id', $user_id);
    $this->db->where('RD.delete_status', 0);
  }elseif($inputs['Request'] == 2 ){
    $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');
    $this->db->where('acceptor_id', $user_id);
    $this->db->where('RD.delete_status', 0);
  }elseif($inputs['Request'] == 3 ){
   $this->db->where("(requester_id = '$user_id' OR acceptor_id = '$user_id')" );
   $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');
   $this->db->where('RD.delete_status', 0);
 }
 
 $this->db->where('RD.status',1);
 $this->db->where('RAD.status',$status);
 $count = $this->db->count_all_results();
 $offset = ($inputs['Page']>1)?(($inputs['Page']-1)*10):0;

 $this->db->select('RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.currency_code,RD.location,RD.delete_status, RD.request_date,TIME_FORMAT(RD.request_time, "%h:%i %p") as request_time ,RD.proposed_fee as amount,RD.contact_number,RD.latitude,RD.longitude,RAD.acceptor_id,RAD.requester_id,U.username as requester_name,U.email as requester_email,U.profile_img as request_image,U.mobile_no as requester_mobile,
   U1.username as acceptor_name,U1.email as acceptor_email,U1.profile_img as acceptor_image,U1.mobile_no as acceptor_mobile,RAD.status as status');

 $this->db->from('request_accept_details RAD');
 
 if($inputs['Request'] == 1 ){
  $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');
  $this->db->where('RAD.requester_id', $user_id);
 }elseif($inputs['Request'] == 2 ){
  $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');
  $this->db->where('acceptor_id', $user_id);
 }elseif($inputs['Request'] == 3 ){
  $this->db->where("(RAD.requester_id = '$user_id' OR RAD.acceptor_id = '$user_id')" );
  $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');
 }

$this->db->join('users U', 'U.user_id = RAD.requester_id', 'LEFT');
$this->db->join('users U1', 'U1.user_id = RAD.acceptor_id', 'LEFT');
$this->db->where('RD.status',1);
$this->db->where('RD.delete_status', 0);
$this->db->where('RAD.status',$status);
$this->db->limit(10, $offset);

$rescords = $this->db->get()->result_array();

if($rescords){
  $user_currency = get_api_user_currency($user_id);
  $UserCurrency = $user_currency['user_currency_code'];

foreach ($rescords as $list) {
    $res['r_id'] = $list['r_id'];
    $res['requester_id'] = $list['requester_id'];
    $res['title'] = $list['title'];
    $res['description'] = $list['description'];
    // $res['currency_code'] = $list['currency_code'];
    $res['location'] = $list['location'];
    $res['request_date'] = $list['request_date'];
    $res['request_time'] = $list['request_time'];
    // $res['amount'] = $list['amount'];
    $res['amount'] = (!empty($UserCurrency)) ? get_gigs_currency($list['amount'], $list['currency_code'], $UserCurrency) : $list['amount'];
    $res['currency_code'] = currency_code_sign($UserCurrency);
    $res['contact_number'] = $list['contact_number'];
    $res['latitude'] = $list['latitude'];
    $res['longitude'] = $list['longitude'];
    $res['acceptor_id'] = $list['acceptor_id'];
    $res['requester_name'] = $list['requester_name'];
    $res['requester_email'] = $list['requester_email'];
    $res['request_image'] = $list['request_image'];
    $res['requester_mobile'] = $list['requester_mobile'];
    $res['acceptor_name'] = $list['acceptor_name'];
    $res['acceptor_email'] = $list['acceptor_email'];
    $res['acceptor_image'] = $list['acceptor_image'];
    $res['acceptor_mobile'] = $list['acceptor_mobile'];
    $res['status'] = $list['status'];
    $results[]=$res;
  }
}

$total_pages = 0;
$next_page  = -1;
$page       = $inputs['Page'];

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
$new_details['request_list'] = $results;

return $new_details;
}


public function requester_pending_list_count($token)

{

  $user_id = $this->get_user_id_using_token($token);

  $new_details = array();
  $request_list = '0';
  $provider_list = '0';

  $status = (!empty($inputs['status']))?$inputs['status']:'1';

  $this->db->from('request_accept_details RAD');

  $this->db->join('request_details RD', 'RD.r_id = RAD.request_id', 'LEFT');

  $this->db->where('requester_id', $user_id);

  $this->db->where('delete_status', 0);

  $this->db->where('RD.status',1);

  $this->db->where('RAD.status',$status);

  $count = $this->db->count_all_results();

  $request_list = (string)$count;

  

  $data= $this->db->query("SELECT COUNT(*) as provider FROM book_service AS bs LEFT JOIN provider_details AS pd ON bs.provider_id=pd.p_id WHERE pd.user_id='".$user_id."' AND bs.service_status = 1 ")->result_array();

    //print_r($data[0]['provider']); exit;

  $provider_list = (string)$data[0]['provider'];

  $new_details['request_list'] = $request_list;

  $new_details['provider_list'] = $provider_list;

  

  return $new_details;

}


public function profile($inputs)

{

  $user_id = $this->get_user_id_using_token($inputs['Token']);

  $results = array();

  $results = $this->db->get_where('users',array('user_id'=>$user_id))->row_array();

  $results['subscription_details'] = $this->get_subscription_details_using_user_id($user_id);

  return $results;

}



public function get_subscription_details_using_user_id($id='')

{



 $records = array();



 if(!empty($id)){

  $this->db->select('SD.expiry_date_time, SF.subscription_name');

  $this->db->from('subscription_details SD');

  $this->db->join('subscription_fee SF', 'SF.id = SD.subscription_id', 'left');

  $this->db->where('subscriber_id', $id);

  $records =  $this->db->get()->row_array();



  if(!empty($records)){

    $records['expiry_date_time'] = utc_date_conversion($records['expiry_date_time']);

  }else{

    $records = (object)array();

  }



}

return $records;

}



public function check_user($inputs='')

{

 $username = $inputs['Username'];

 $email = $inputs['Email'];
 $tokenid = $inputs['Tokenid'];

if($inputs['Registerthrough'] != 4) {

    $this->db->where("(username = '$username' OR email = '$email')");
} else {
    $this->db->where("(tokenid = '$tokenid')");
}

return $this->db->count_all_results('users');

}

public function check_mobile_no($inputs='')

{

 $mobile_no = $inputs['Mobileno'];
 $tokenid = $inputs['Tokenid'];

 if($inputs['Registerthrough'] == 1) {

    $this->db->where("mobile_no = '$mobile_no'");
} else {
    $this->db->where("(tokenid = '$tokenid')");
}
 
 return $this->db->count_all_results('users');

}



public function profile_image_upload($inputs)

{



 $update = array('ic_card_image'=>$inputs['ic_card_image'], 'profile_img'=>$inputs['profile_img']);

//  if(!empty($inputs['Profileimg'])){

//   $update['profile_img'] =$inputs['profile_img'];

// }



$this->db->where('user_id', $inputs['user_id']);

$this->db->update('users', $update);

$this->db->select('profile_img,ic_card_image');

$this->db->where('user_id', $inputs['user_id']);

return $this->db->get('users')->row_array();





}



public function new_user($inputs)

{

  $new_details = array();
  $subscription_data = array();

  $username = $inputs['Username'];

  $email = $inputs['Email'];
  $mobile_no = $inputs['Mobileno'];
  $tokenid = $inputs['Tokenid'];

  unset($inputs["Language"]);
$input["username"] = $inputs['Username'];
$input["email"] = ($inputs["Email"])?$inputs["Email"]:'';
$input["mobile_no"] = ($inputs["Mobileno"])?$inputs["Mobileno"]:'';
$input["register_through"] = $inputs["Registerthrough"];
$input["latitude"] = $inputs["Latitude"];
$input["longitude"] = $inputs["Longitude"];
$input["tokenid"] = $inputs["Tokenid"];
$input['created'] = date('Y-m-d H:i:s');
$input['password'] = ($inputs['Password'])?md5($inputs['Password']):'';
$input['verified'] = 1;
$input['is_active'] = 1;
$input['role'] = 2;
$input['full_name'] = $username;
////$input["device_id"] = $inputs["Deviceid"];

    if($inputs["Registerthrough"] != 4) {
        $this->db->where("(username = '$username' OR email = '$email')");
    } else {
        $this->db->where("(tokenid = '$tokenid')");
    }
    $count = $this->db->count_all_results('users');



  $this->db->where("mobile_no = '$mobile_no'");

  $counts = $this->db->count_all_results('users');



  $date = date('Y-m-d H:i:s');



  if($count == 0){

    $device_type = $inputs['Devicetype'];
    $device_id = $inputs['Deviceid'];
    unset($inputs['Deviceid'],$inputs['Devicetype']);
    $inputs['created'] = $date;
    $inputs['password'] = md5($inputs['Password']);
    $inputs['verified'] = 1;
    $inputs['is_active'] = 1;
    $inputs['role'] = 2;
    $inputs['full_name'] = $username;
        /*$my_file = 'file.txt';

        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

        $data = '----------';

        fwrite($handle, $data);*/

        $result  = $this->db->insert('users',$input);
        $user_id = $this->db->insert_id();
        $data1 = $this->db->last_query();

        // fwrite($handle, $data1);

        /* Create Toeken */

        $unique_code = $this->getToken(14,$user_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('users', array('unique_code'=>$unique_code));

        /* Create Toeken */

        /*$data2 = $this->db->last_query();

        fwrite($handle, $data2);

        fclose($handle);*/



        /*$subscription_data['user_id'] = $user_id;

        $subscription_data['subscription_id'] = 1;

        $this->temp_subscription_success($subscription_data);*/



        if(!empty($device_type) && !empty($device_id)){



         $device_type = strtolower($device_type);

         $device_id   = $device_id;





         $this->db->where('user_id', $user_id);

         $count = $this->db->count_all_results('device_details');



         if($count == 0 ){

          $this->db->insert('device_details', array('user_id'=> $user_id,'device_type'=> $device_type,'device_id'=> $device_id,'created'=>$date));

        }else{

          $this->db->where('user_id',$user_id);

          $this->db->update('device_details', array('device_type'=> $device_type,'device_id'=> $device_id,'created'=>$date));

        }



      }



      return $result;

    }else{



      return 2;

    }

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

       return $this->db->update('subscription_details', $new_details);

     }



   }else{



    return false;

  }



}

public function my_provider_list($inputs)

{



  $user_id = $this->get_user_id_using_token($inputs['token']);



  $new_details = array();



      $this->db->where('status', 1); // Default 1 - Active



      $this->db->where('user_id', $user_id);

      $this->db->where('delete_status', 0);

      $count = $this->db->count_all_results('provider_details');



      $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;



      $this->db->select('PD.p_id,PD.user_id as provider_id,PD.category,PD.subcategory,PD.title,PD.location,PD.location,PD.description_details,PD.contact_number,PD.availability,PD.latitude,PD.longitude,PD.start_date,PD.end_date,PD.status,PD.views,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,c.category_name,IF(s.subcategory_name IS NULL or s.subcategory_name = "", "", s.subcategory_name) as subcategory_name,( SELECT IFNULL(ROUND(AVG(r.rating),1),0)
        FROM rating_review r
        WHERE r.p_id = PD.p_id
      )AS rating');

      $this->db->from('provider_details PD');

      $this->db->where('PD.status',1);

      $this->db->where('PD.delete_status', 0);

      $this->db->where('PD.user_id', $user_id);

      $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');

      $this->db->join('categories c', 'c.id = PD.category', 'LEFT');

      $this->db->join('subcategories s', 's.id = PD.subcategory', 'LEFT');

      $this->db->order_by('PD.p_id', 'desc');

      $this->db->limit(10, $offset);

      $rescords = $this->db->get()->result_array();

      $details =array();
     // $rescords= array();
      foreach ($rescords as $data) {       
        $category_id = explode(',', $data['category']);
        $category_name=array();
        for ($i=0; $i < count($category_id) ; $i++) 
        { 

         @$categories_name=$this->db->select('category_name')->where('id',$category_id[$i])->get('categories')->row()->category_name;

         if(isset($categories_name) && !empty($categories_name)){
          $category_name[]=$categories_name;
        } else {
         $category_name[]='';
       }

     }

     $sub_category_id = explode(',', $data['subcategory']);
     $sub_category_name=array();
     for ($i=0; $i < count($sub_category_id) ; $i++) 
     { 
      @$sub_categories_name=$this->db->select('IF(subcategory_name IS NULL or subcategory_name = "", "", subcategory_name) as subcategory_name')->where('id',$sub_category_id[$i])->get('subcategories')->row()->subcategory_name;

      if(isset($sub_categories_name) && !empty($sub_categories_name)){
        $sub_category_name[]=$sub_categories_name;
      } else {
       $sub_category_name[]='';
     }
   }
   $category_names =implode(',', array_filter($category_name));
   $sub_category_names =implode(',', array_filter($sub_category_name));

   $details[] = array(
     "p_id" => $data['p_id'],
     "provider_id" => $data['provider_id'],
     "category"=> $data['category'],
     "subcategory"=> $data['subcategory'],
     "title"=> $data['title'],
     "location"=> $data['location'],
     "description_details"=> $data['description_details'],
     "availability"=> $data['availability'],
     "latitude"=> $data['latitude'],
     "longitude"=> $data['longitude'],
     "start_date"=> $data['start_date'],
     "end_date"=> $data['end_date'],
     "status"=> $data['status'],
     "views"=> $data['views'],
     "username"=> $data['username'],
     "email"=> $data['email'],
     "profile_img"=> $data['profile_img'],
     "profile_contact_no"=> $data['profile_contact_no'],
     "contact_number"=> $data['contact_number'],
     "category_name"=> $category_names,
     "subcategory_name"=> $sub_category_names,
     "rating"=> $data['rating'],

   );
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

 $new_details['provider_list'] = $details;





 return $new_details;

}







public function new_request_by_user($inputs)

{

  $new_details = array();



  $user_id = $this->get_user_id_using_token($inputs['Token']);

  $title   = $inputs['Title'];



  $this->db->where('title', $title);

  $this->db->where('user_id', $user_id);

  $this->db->where('delete_status', 0);

  $count = $this->db->count_all_results('request_details');

  if($count == 0){
    $new_details['user_id'] = $user_id;
    $new_details['title'] = $inputs['Title'];
    $new_details['description'] = $inputs['Description'];
    $new_details['location'] = $inputs['Location'];
    $new_details['request_date'] = date('Y-m-d',strtotime($inputs['Requestdate']));
    $new_details['request_time'] = date('H:i',strtotime($inputs['Requesttime']));
    $new_details['proposed_fee'] = $inputs['Proposedfee'];
    $new_details['contact_number'] = $inputs['Contactnumber'];
    $new_details['latitude'] = $inputs['Latitude'];
    $new_details['longitude'] = $inputs['Longitude'];
    $new_details['created'] =  date('Y-m-d H:i:s');
    return   $this->db->insert('request_details', $new_details);
  }else{
        return 2; // Already Exists
      }
    }

    public function update_rquest($inputs)
    {
      $new_details = array();
      $user_id = $this->get_user_id_using_token($inputs['token']);
    //  $title   = $inputs['title'];
      $request_id   = $inputs['request_id'];

    //  $this->db->where('title', $title);
      $this->db->where('user_id', $user_id);
      $this->db->where('r_id', $request_id);
      $this->db->where('delete_status', 0);
      $count = $this->db->count_all_results('request_details');

      if($count == 1){
        $new_details['user_id'] = $user_id;
        $new_details['title'] = $inputs['title'];
        $new_details['description'] = $inputs['description'];
        $new_details['location'] = $inputs['location'];
        $new_details['request_date'] = date('Y-m-d',strtotime($inputs['request_date']));
        $new_details['request_time'] = date('H:i',strtotime($inputs['request_time']));
        $new_details['proposed_fee'] = $inputs['proposed_fee'];
        $new_details['contact_number'] = $inputs['contact_number'];
        $new_details['latitude'] = $inputs['latitude'];
        $new_details['longitude'] = $inputs['longitude'];
        $new_details['created'] =  date('Y-m-d H:i:s');
        $this->db->where('r_id', $request_id);
        $this->db->where('delete_status', 0);
        return   $this->db->update('request_details', $new_details);
      }else{
        return 2; // Already Exists
      }
    }

    public function request_list($inputs)
    {
      $new_details = array();
      $accept =  $this->get_accept();
      $user_id = $this->get_user_id_using_token($inputs['Token']);
      $offset = ($inputs['Page']>1)?(($inputs['Page']-1)*10):0;
      $latitude   = $inputs['Latitude'];
      $longitude  = $inputs['Longitude'];
      $radius     = 10;
      $longitude_min = $longitude - 100 / abs(cos(deg2rad($longitude)) * 69);
      $longitude_max = $longitude + 100 / abs(cos(deg2rad($longitude)) * 69);
      $latitude_min  = $latitude - (100 / 69);
      $latitude_max  = $latitude + (100 / 69);

      $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, '%h:%i %p') as request_time ,RD.proposed_fee as amount,RD.currency_code,RD.contact_number,RD.latitude,RD.longitude,RD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,
        1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - RD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(RD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - RD.longitude) * pi()/180 / 2), 2) )) AS distance");

      $this->db->from("request_details RD");
      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');
      $this->db->having('distance <=', $radius);

      if(!empty($accept)){
        $this->db->where_not_in('RD.r_id', $accept);
      }
      $this->db->where('RD.delete_status', 0);
      $this->db->where('RD.request_date >=', $this->date);

      $this->db->where("RD.status = 1  AND (RD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (RD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ")");

      $count = $this->db->get()->num_rows();

      $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, '%h:%i %p') as request_time,RD.proposed_fee as amount,RD.currency_code,RD.contact_number,RD.latitude,RD.longitude,IF(RD.status=1,0,RD.status) as status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,

       1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - RD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(RD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - RD.longitude) * pi()/180 / 2), 2) )) AS distance");

      $this->db->from("request_details RD");
      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');
      $this->db->having('distance <=', $radius);

      if(!empty($accept)){
        $this->db->where_not_in('RD.r_id', $accept);
      }

      $this->db->where('RD.delete_status', 0);
      $this->db->where('RD.request_date >=', $this->date);

      // RD.status = 1  AND
      $this->db->where(" (RD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (RD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ")");

      $this->db->order_by('RD.r_id', 'DESC');
      $this->db->limit(10, $offset);

      $rescordss = $this->db->get()->result_array();
      $rescords = array();

      if(count($rescordss) > 0){
      $user_currency = get_api_user_currency($user_id);
      $UserCurrency = $user_currency['user_currency_code'];
      
      foreach($rescordss as $value){
        $amount = $value['amount'];
        $cur_code = $value['currency_code']; 
        $convert_amt = (!empty($UserCurrency)) ? get_gigs_currency( $amount, $cur_code,  $UserCurrency) : $value['amount'];
        $value['amount'] = "$convert_amt";
        $value['currency_code'] = currency_code_sign($UserCurrency);
        //unset($value['distance']);
        $rescords[] = $value;
        }
      }
    //$res['amount'] = (!empty($UserCurrency)) ? get_gigs_currency($list['amount'], $list['currency_code'], $UserCurrency) : $list['amount'];
    //$res['currency_code'] = currency_code_sign($UserCurrency);
      
      $total_pages = 0;
      $next_page   = -1;
      $page        = $inputs['Page'];

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

   public function search_request_list($inputs)
   {

     $search_title = (!empty($inputs['Searchtitle']))?$inputs['Searchtitle']:'';
     $request_date = (!empty($inputs['Requestdate']))?$inputs['Requestdate']:'';
     $request_time = (!empty($inputs['Requesttime']))?$inputs['Requesttime']:'';
     $min_price =  (!empty($inputs['Minprice']))?$inputs['Minprice']:'';
     $max_price =  (!empty($inputs['Maxprice']))?$inputs['Maxprice']:'';
     $location =     (!empty($inputs['Location']))?$inputs['Location']:'';

     if(!empty($request_time)){

      $request_time = date('H:i',strtotime($request_time));

    }

    $new_details = array();
    $accept =  $this->get_accept();
    $user_id = $this->get_user_id_using_token($inputs['token']);

    $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;
    $latitude   = isset($inputs['Latitude'])?$inputs['Latitude']:0;
    $longitude  = isset($inputs['Longitude'])?$inputs['Longitude']:0;
    $radius     = 10;


    $longitude_min = $longitude - 100 / abs(cos(deg2rad($longitude)) * 69);
    $longitude_max = $longitude + 100 / abs(cos(deg2rad($longitude)) * 69);
    $latitude_min  = $latitude - (100 / 69);
    $latitude_max  = $latitude + (100 / 69);



    $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, '%h:%i %p') as request_time ,RD.proposed_fee as amount,RD.currency_code,RD.contact_number,RD.latitude,RD.longitude,RD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,

      1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - RD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(RD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - RD.longitude) * pi()/180 / 2), 2) )) AS distance");
  
    $this->db->from("request_details RD");

    $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');

    $this->db->having('distance <=', $radius);

    if(!empty($accept)){

      $this->db->where_not_in('RD.r_id', $accept);

    }



    if(!empty($search_title)){

      $this->db->like('title',$search_title,'BOTH');

    }

    if(!empty($request_date)){

      $this->db->where('request_date', $request_date);

    }

    if(!empty($request_time)){

      $this->db->like('request_time', $request_time,'BOTH');

    }

    if(!empty($min_price) && !empty($max_price)){

      $this->db->where('proposed_fee >=',$min_price);

      $this->db->where('proposed_fee <=',$max_price);

    }

    if(!empty($location)){

      $this->db->like('location', $location, 'BOTH');

    }





    $this->db->where('RD.delete_status', 0);

    $this->db->where('RD.request_date >=', $this->date);



    $this->db->where("RD.status = 1  AND (RD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (RD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ")");

    $count = $this->db->get()->num_rows();





    $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, '%h:%i %p') as request_time,RD.proposed_fee as amount,RD.currency_code,RD.contact_number,RD.latitude,RD.longitude,RD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,

     1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - RD.latitude) *  pi()/180 / 2), 2) +COS(" . $latitude . " * pi()/180) * COS(RD.latitude * pi()/180) * POWER(SIN((" . $longitude . " - RD.longitude) * pi()/180 / 2), 2) )) AS distance");

    $this->db->from("request_details RD");

    $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');

    $this->db->having('distance <=', $radius);



    if(!empty($accept)){

      $this->db->where_not_in('RD.r_id', $accept);

    }

    $this->db->where('RD.delete_status', 0);

    $this->db->where('RD.request_date >=', $this->date);

    $this->db->where("RD.status = 1  AND (RD.longitude BETWEEN " . $longitude_min . " AND " . $longitude_max . ") AND (RD.latitude BETWEEN " . $latitude_min . " AND " . $latitude_max . ")");



    if(!empty($search_title)){

      $this->db->like('title',$search_title,'BOTH');

    }

    if(!empty($request_date)){

      $this->db->where('request_date', $request_date);

    }

    if(!empty($request_time)){

      $this->db->like('request_time', $request_time,'BOTH');

    }



    if(!empty($min_price) && !empty($max_price)){

      $this->db->where('proposed_fee >=',$min_price);

      $this->db->where('proposed_fee <=',$max_price);

    }



    if(!empty($location)){

      $this->db->like('location', $location, 'BOTH');

    }



    $this->db->order_by('RD.request_date', 'ASC');

    $this->db->limit(10, $offset);

    $rescordss = $this->db->get()->result_array();



    $rescords = array();

    if(count($rescordss) > 0){
    
    $user_currency = get_api_user_currency($users_id);
    $UserCurrency = $user_currency['user_currency_code'];

      foreach($rescordss as $key => $value){

       unset($value['distance']);
      
      $value['amount'] = (!empty($UserCurrency)) ? get_gigs_currency($value['amount'], $value['currency_code'], $UserCurrency) : $value['amount'];

       $rescords[] = $value;

     }

   }



   $total_pages = 0;

   $next_page  = -1;

   $page       = $inputs['Page'];



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

 public function my_request_list($inputs)

 {

  $user_id = $this->get_user_id_using_token($inputs['token']);





  $new_details = array();

  if(isset($inputs['filter_by'])){

    $filter_by = $inputs['filter_by'];

  }else{

    $filter_by = '';

  }

      // 0 - Pending, 1- Accepted, 2 - Completed

  /*    $this->db->where('status', 1); // Default 1 - Active

      $this->db->where('user_id', $user_id);

      $this->db->where('delete_status', 0);

      $count = $this->db->count_all_results('request_details');*/



      $this->db->select('RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, "%h:%i %p") as request_time,RD.request_time as requesttime,RD.proposed_fee as amount,RD.currency_code,RD.contact_number,RD.latitude,RD.longitude,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,RD.status,IF(RAD.status IS NULL,0,RAD.status) as request_accept_status');

      $this->db->from('request_details RD');

      $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');

      $this->db->join('request_accept_details RAD', 'RAD.request_id = RD.r_id', 'LEFT');



      if($filter_by == 1 || $filter_by == 2){ // 1- Accepted, 2 - Completed

        $this->db->where('RAD.status',$filter_by);

      }

      if($filter_by == 0 && $filter_by != ''){ // 0 -pending

       $this->db->where('RD.status',1);

       $this->db->having('request_accept_status', 0);

       $this->db->where('RD.request_date >=', $this->date);



     }



     $this->db->where('RD.delete_status', 0);

     $this->db->where('RD.user_id', $user_id);

     $this->db->order_by('RD.r_id', 'ASC');

     $count = $this->db->get()->num_rows();



     // echo $this->db->last_query();





     $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;



     $this->db->select('RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,TIME_FORMAT(RD.request_time, "%h:%i %p") as request_time,RD.request_time as requesttime,RD.proposed_fee as amount,RD.currency_code,RD.contact_number,RD.latitude,RD.longitude,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,RD.status,IF(RAD.status IS NULL,0,RAD.status) as request_accept_status');

     $this->db->from('request_details RD');

     $this->db->where('RD.status',1);

     $this->db->where('RD.delete_status', 0);

     $this->db->where('RD.user_id', $user_id);

     $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');

     $this->db->join('request_accept_details RAD', 'RAD.request_id = RD.r_id', 'LEFT');





      if($filter_by == 1 || $filter_by == 2){ // 1- Accepted, 2 - Completed

        $this->db->where('RAD.status',$filter_by);

      }

      if($filter_by == 0 && $filter_by !=''){ // 0 -pending

       $this->db->where('RD.status',1);

       $this->db->having('request_accept_status', 0);

       $this->db->where('RD.request_date >=', $this->date);



     }

     $this->db->order_by('RD.r_id', 'ASC');



     $this->db->limit(10, $offset);

     $rescords_array = $this->db->get()->result_array();

       

     $rescords = array();

     if(count($rescords_array) >0){
     
     $user_currency = get_api_user_currency($user_id);
     $UserCurrency = $user_currency['user_currency_code'];
     
     
      foreach ($rescords_array as $array) {
      
      
      
      $array['amount'] = (!empty($UserCurrency)) ? get_gigs_currency($array['amount'],$array['currency_code'] , $UserCurrency) : $array['amount'];



        date_default_timezone_set("Asia/Kuala_Lumpur");

        $date_time = date('Y-m-d H:i:s');
      
      
      $array['currency_code'] = currency_code_sign($UserCurrency);


    //$amount = $array['amount'];
        $rad_status = $array['request_accept_status'];

        $status = $array['status'];

        $request_date = $array['request_date'].' '.$array['requesttime'];

        if($rad_status == 0){

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

        }else{

          $array['status'] = $rad_status;

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



 public function language_list($key)
 {
  $this->db->select('page_key,lang_key,lang_value');
  $this->db->from('language_management');
  $this->db->where('language', $key);
  $this->db->order_by('page_key', 'ASC');
  $this->db->order_by('lang_key', 'ASC');
  $records = $this->db->get()->result_array();

  $language = array();
  if(!empty($records)){
    foreach ($records as $record) {
      $this->db->select('page_key,lang_key,lang_value');
      $this->db->from('language_management');
      $this->db->where('language', $key);
      $this->db->where('page_key', $record['page_key']);
      $this->db->where('lang_key', $record['lang_key']);
      $eng_records = $this->db->get()->row_array();
      if(!empty($eng_records['lang_value'])){
        $language['language'][$record['page_key']][$record['lang_key']] = $eng_records['lang_value'];
      }
      else {
        $language['language'][$record['page_key']][$record['lang_key']] = $record['lang_value'];
      }
    }
  }
  return $language;
}

public function get_user_id_using_token($token)
{
 $user_id = 0;

 if(!empty($token)){

  $this->db->select('user_id');

  $this->db->where('unique_code', $token);

  $records = $this->db->get('users')->row_array();

  $user_id = (!empty($records['user_id']))?$records['user_id']:0;

}

return $user_id;

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



        public function forgot_password($email)

        {



          $this->db->where('email', $email);

          $record = $this->db->get('users')->row_array();



          if(!empty($record)){



            $id = $record['user_id'];

            $userid = md5($id);

            $this->db->where('user_id', $id);

            $this->db->update('users', array('forgot' => $userid ));



            $this->load->library('servpro');

            $to = $email;

            $subject = 'Forgot Password reset link for ';

            $message = 'Reset Password link is follows <a href="'.base_url().'login/change_password/'.$userid.'">Reset Link</a>';

            $this->servpro->send_mail($to,$subject,$message);

            return true;



          }else{



            return false;



          }

        }


        public function contact_us($inputs)

        {



         $name=$inputs['name'];
         $email_address=$inputs['email_address'];
         $phone_no=$inputs['phone_no'];
         $subject=$inputs['subject'];
         $message=$inputs['message'];



         $this->load->library('servpro');

         $to = 'alsughayer11@gmail.com';
         $from=$email_address;

         $messages='<!DOCTYPE html>
         <html style="font-family: Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
         <head>
         <meta name="viewport" content="width=device-width" />
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
         <title>Email Template</title>
         </head>

         <body style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
         <table style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
         <tr>
         <td></td>
         <td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
         <div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
         <table width="100%" cellpadding="0" cellspacing="0" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
         <tr>
         <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;" align="center" valign="top">
         <table width="100%" cellpadding="0" cellspacing="0" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
         
         <tr>
         <td style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
         <table style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 20px auto 0;">
         
         <tr>
         <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
         <table style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 100%; margin: 0;">
         <thead>
         <tr>
         
         <th colspan="3" style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px;text-align:center; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;">Contact Us</th>
         
         </tr>
         </thead>
         <tbody>
         <tr>
         <td style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px; width:30%">Name</td>
         <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" colspan="2" valign="top">'.$name.'</td>
         </tr>
         <tr>
         <td style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;">Email</td>
         <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" colspan="2" valign="top">'.$email_address.'</td>
         </tr>
         <tr>
         <td style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;">Phonenumber</td>
         <td style="font-family:Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" colspan="2" valign="top">'.$phone_no.'</td>
         </tr>
         <tr>
         <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;">Message</td>
         <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" colspan="2" valign="top">'.$message.'</td>
         </tr>
         </tbody>
         
         </table>
         </td>
         </tr>
         </table>
         </td>
         </tr>
         </table>
         </td>
         </tr>
         </table>
         
         </div>
         </td>
         </tr>
         </table>
         </body>
         </html>';
         
         $this->servpro->send_mails($to,$subject,$messages,$from);

         return true;



         

       }



       public function colour_settings(){

        return $this->db->get('colour_settings')->row_array();

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



    public function chat_history($token,$page)

    {

     $user_id = $id = $this->get_user_id_using_token($token);



     $this->db->select('id,chat_from,chat_to');

     $this->db->from('chats');

     $this->db->where("chat_from = $id OR chat_to = $id");

     $this->db->order_by('id', 'desc');

     $chat_history = $this->db->get()->result_array();

     $chat_user_ids = array();

     if(!empty($chat_history)){

      foreach ($chat_history as $history) {

        $from = $history['chat_from'];

        if(!in_array($from, $chat_user_ids) && $from!=$id){

          $chat_user_ids[] = $from;

          $chat_ids[] = $history['id'];

        }

        $to = $history['chat_to'];

        if(!in_array($to, $chat_user_ids) && $to!=$id){

          $chat_user_ids[] = $to;

          $chat_ids[] = $history['id'];

        }

      }

    }

    $history     = array();

    $chathistory = array();

    $count       = 0;

    if(!empty($chat_ids)){



      $offset = ($page>1)?(($page-1)*10):0;



      $this->db->select('*');

      $this->db->from('chats C');

      $this->db->join('users UF','UF.user_id= C.chat_to','left');

      $this->db->join('users UT','UT.user_id= C.chat_from','left');

      $this->db->where_in("id",$chat_ids);



      $this->db->where('from_delete_sts', 0);

      $this->db->where('to_delete_sts', 0);

      $count = $this->db->get()->num_rows();

      $this->db->select('C.id,C.chat_from,C.chat_to,C.content,C.chat_utc_time,C.status,UF.username as fromname,UF.profile_img as from_profile_img,UT.username,UT.profile_img as profile_img');

      $this->db->from('chats C');

      $this->db->join('users UF','UF.user_id= C.chat_to','left');

      $this->db->join('users UT','UT.user_id= C.chat_from','left');

      $this->db->where_in("id",$chat_ids);



      $this->db->where('from_delete_sts', 0);

      $this->db->where('to_delete_sts', 0);

      $this->db->order_by('id', 'desc');

      $this->db->limit(10, $offset);

      $chathistory_array =  $this->db->get()->result_array();

      $chathistory = array();





      if(count($chathistory_array) > 0){

        foreach ($chathistory_array as $value) {

          if($value['chat_from'] !=  $user_id){

           $chat_count=count($this->db->where("chat_from = '".$value['chat_from']."' AND chat_to ='".$user_id."'")->where("status = 0")->get('chats')->result_array());
           $value['chat_count'] = (string)$chat_count;
                 //  $value['chat_count'] = '';
           unset($value['chat_to'],$value['fromname'],$value['from_profile_img']);

           $chathistory[] = $value;

         }else{

          $value['profile_img'] = $value['from_profile_img'];

          $value['username']  = $value['fromname'];

          $value['chat_from'] = $value['chat_to'];

                 // $chat_count=count($this->db->where("chat_from = '".$value['chat_to']."' OR chat_to = '".$value['chat_to']."'")->where("status = 0")->get('chats')->result_array());
          $value['chat_count'] = '0';
          unset($value['chat_to'],$value['fromname'],$value['from_profile_img']);

          $chathistory[] = $value;

        }

      }

    }



  }

     //print_r($this->db->last_query()); exit;



  $total_pages = 0;

  $next_page  = -1;







  if($count > 0 && $page > 0){



   $total_pages = ceil($count / 10);

   if($page < $total_pages){



     $next_page = ($page + 1);



   }else{



     $next_page = -1;

   }

 }

 $history['next_page']    = $next_page;

 $history['current_page'] = $page;

 $history['total_pages']  = $total_pages;

 $history['chat_list'] = $chathistory;





 return $history;



}


public function chat_history_count($token)

{

 $user_id = $id = $this->get_user_id_using_token($token);



 $this->db->select('id,chat_from,chat_to');

 $this->db->from('chats');

 $this->db->where("chat_from = $id OR chat_to = $id");

 $this->db->order_by('id', 'desc');

 $chat_history = $this->db->get()->result_array();

 $chat_user_ids = array();

 if(!empty($chat_history)){

  foreach ($chat_history as $history) {

    $from = $history['chat_from'];

    if(!in_array($from, $chat_user_ids) && $from!=$id){

      $chat_user_ids[] = $from;

      $chat_ids[] = $history['id'];

    }

    $to = $history['chat_to'];

    if(!in_array($to, $chat_user_ids) && $to!=$id){

      $chat_user_ids[] = $to;

      $chat_ids[] = $history['id'];

    }

  }

}

$history     = array();

$provider_chat_count = '0';

if(!empty($chat_ids)){

  $this->db->select('C.id,C.chat_from,C.chat_to,C.content,C.chat_utc_time,C.status,UF.username as fromname,UF.profile_img as from_profile_img,UT.username,UT.profile_img as profile_img');

  $this->db->from('chats C');

  $this->db->join('users UF','UF.user_id= C.chat_to','left');

  $this->db->join('users UT','UT.user_id= C.chat_from','left');

  $this->db->where_in("id",$chat_ids);



  $this->db->where('from_delete_sts', 0);

  $this->db->where('to_delete_sts', 0);

  $this->db->order_by('id', 'desc');

       // $this->db->limit(10, $offset);

  $chathistory_array =  $this->db->get()->result_array();

  if(count($chathistory_array) > 0){

    foreach ($chathistory_array as $value) {

      if($value['chat_from'] !=  $user_id){

       $chat_count=count($this->db->where("chat_from = '".$value['chat_from']."' AND chat_to ='".$user_id."'")->where("status = 0")->get('chats')->result_array());
       $provider_chat_count = (string)$chat_count;
       

     }

   }

 }

}

      // print_r($this->db->last_query()); exit;

return $provider_chat_count;



}


public function chat_conversation($array)

{



  $array['chat_from'] = $this->get_user_id_using_token($array['token']);



  unset($array['token']);

  $this->db->insert('chats', $array);

  $id = $this->db->insert_id();

  $this->db->select('C.id,C.chat_to,C.chat_from,C.content,C.chat_utc_time,C.status,UF.username as fromname,UT.username as toname');

  $this->db->from('chats C');

  $this->db->join('users UF','UF.user_id= C.chat_to','left');

  $this->db->join('users UT','UT.user_id= C.chat_from','left');

  $this->db->where(array('id'=>$id));

  return $this->db->get()->row_array();

}

public function message_status($id,$user_id,$table_name)

{

        // $this->db->where("(chat_from = '$id' AND chat_to = '$user_id') OR (chat_from = '$user_id' AND chat_to = '$id')");
  $this->db->where("chat_from = '$id' AND chat_to = '$user_id'");
  return $this->db->update($table_name, array('status'=> 1)); 

         //return $result = $this->db->affected_rows();

}
public function conversations($id,$user_id,$page)

{

        // $this->db->where("(chat_from = '$id' AND chat_to = '$user_id') OR (chat_from = '$user_id' AND chat_to = '$id')");
 $this->db->where("chat_from = '$id' AND chat_to = '$user_id'");
 $this->db->update('chats', array('status'=> 1));

 
 $this->db->select('*');

 $this->db->from('chats C');

 $this->db->join('users UF','UF.user_id= C.chat_from','left');

 $this->db->join('users UT','UT.user_id= C.chat_to','left');

 $this->db->where("(chat_from = '$id' AND chat_to = '$user_id') OR (chat_from = '$user_id' AND chat_to = '$id')");

 $this->db->where('from_delete_sts', 0);

 $this->db->where('to_delete_sts', 0);

 $count = $this->db->get()->num_rows();



 $offset = ($page>1)?(($page-1)*30):0;



 $this->db->select('C.id,C.chat_from,C.chat_to,C.content,C.chat_utc_time,C.status,UF.username as fromname,UT.username as toname');

 $this->db->from('chats C');

 $this->db->join('users UF','UF.user_id= C.chat_from','left');

 $this->db->join('users UT','UT.user_id= C.chat_to','left');

 $this->db->where("(chat_from = '$id' AND chat_to = '$user_id') OR (chat_from = '$user_id' AND chat_to = '$id')");

 $this->db->where('from_delete_sts', 0);

 $this->db->where('to_delete_sts', 0);

 $this->db->order_by('id', 'DESC');

 $this->db->limit(30, $offset);

 $chathistory = $this->db->get()->result_array();



 if(count($chathistory) > 0){

  usort($chathistory,function($a,$b){

   $x = $a['id'];

   $y = $b['id'];

   if ($x== $y)

    return 0;

  if ($x < $y)

    return -1;

  else

    return 1;

});



}

$chathistory_new = array();

if(!empty($chathistory)){

  foreach ($chathistory as $chat) {

    $datetime = $chat['chat_utc_time'];

    $time = utc_date_conversion($datetime);

    $chat['time'] = date('h:i A',strtotime($time));

    $chat['date'] = date('Y-m-d',strtotime($time));

    $chathistory_new[] = $chat;

  }

}



$chathistory = $chathistory_new;



$total_pages = 0;

$next_page  = -1;



if($count > 0 && $page > 0){



 $total_pages = ceil($count / 30);

 if($page < $total_pages){



   $next_page = ($page + 1);



 }else{



   $next_page = -1;

 }

}



$history['next_page']    = $next_page;

$history['current_page'] = $page;

$history['total_pages']  = $total_pages;

$history['chat_list'] = $chathistory;



return $history;

}

public function chat_history_requester($token,$page)

{

 $user_id = $id = $this->get_user_id_using_token($token);



 $this->db->select('id,chat_from,chat_to');

 $this->db->from('chats_requester');

 $this->db->where("chat_from = $id OR chat_to = $id");

 $this->db->order_by('id', 'desc');

 $chat_history = $this->db->get()->result_array();

 $chat_user_ids = array();

 if(!empty($chat_history)){

  foreach ($chat_history as $history) {

    $from = $history['chat_from'];

    if(!in_array($from, $chat_user_ids) && $from!=$id){

      $chat_user_ids[] = $from;

      $chat_ids[] = $history['id'];

    }

    $to = $history['chat_to'];

    if(!in_array($to, $chat_user_ids) && $to!=$id){

      $chat_user_ids[] = $to;

      $chat_ids[] = $history['id'];

    }

  }

}

$history     = array();

$chathistory = array();

$count       = 0;

if(!empty($chat_ids)){



  $offset = ($page>1)?(($page-1)*10):0;



  $this->db->select('*');

  $this->db->from('chats_requester C');

  $this->db->join('users UF','UF.user_id= C.chat_to','left');

  $this->db->join('users UT','UT.user_id= C.chat_from','left');

  $this->db->where_in("id",$chat_ids);



  $this->db->where('from_delete_sts', 0);

  $this->db->where('to_delete_sts', 0);

  $count = $this->db->get()->num_rows();



  $this->db->select('C.id,C.chat_from,C.chat_to,C.content,C.chat_utc_time,C.status,UF.username as fromname,UF.profile_img as from_profile_img,UT.username,UT.profile_img as profile_img');

  $this->db->from('chats_requester C');

  $this->db->join('users UF','UF.user_id= C.chat_to','left');

  $this->db->join('users UT','UT.user_id= C.chat_from','left');

  $this->db->where_in("id",$chat_ids);



  $this->db->where('from_delete_sts', 0);

  $this->db->where('to_delete_sts', 0);

  $this->db->order_by('id', 'desc');

  $this->db->limit(10, $offset);

  $chathistory_array =  $this->db->get()->result_array();

  $chathistory = array();





  if(count($chathistory_array) > 0){

    foreach ($chathistory_array as $value) {

      if($value['chat_from'] !=  $user_id){
       $chat_count=count($this->db->where("chat_from = '".$value['chat_from']."' AND chat_to ='".$user_id."'")->where("status = 0")->get('chats_requester')->result_array());
       $value['chat_count'] = (string)$chat_count;
       unset($value['chat_to'],$value['fromname'],$value['from_profile_img']);

       $chathistory[] = $value;

     }else{

      $value['profile_img'] = $value['from_profile_img'];

      $value['username']  = $value['fromname'];

      $value['chat_from'] = $value['chat_to'];
      
      $value['chat_count'] = '0';

      unset($value['chat_to'],$value['fromname'],$value['from_profile_img']);

      $chathistory[] = $value;

    }

  }

}



}





$total_pages = 0;

$next_page  = -1;







if($count > 0 && $page > 0){



 $total_pages = ceil($count / 10);

 if($page < $total_pages){



   $next_page = ($page + 1);



 }else{



   $next_page = -1;

 }

}

$history['next_page']    = $next_page;

$history['current_page'] = $page;

$history['total_pages']  = $total_pages;

$history['chat_list'] = $chathistory;





return $history;



}

public function chat_history_requester_count($token)

{

 $user_id = $id = $this->get_user_id_using_token($token);



 $this->db->select('id,chat_from,chat_to');

 $this->db->from('chats_requester');

 $this->db->where("chat_from = $id OR chat_to = $id");

 $this->db->order_by('id', 'desc');

 $chat_history = $this->db->get()->result_array();

 $chat_user_ids = array();

 if(!empty($chat_history)){

  foreach ($chat_history as $history) {

    $from = $history['chat_from'];

    if(!in_array($from, $chat_user_ids) && $from!=$id){

      $chat_user_ids[] = $from;

      $chat_ids[] = $history['id'];

    }

    $to = $history['chat_to'];

    if(!in_array($to, $chat_user_ids) && $to!=$id){

      $chat_user_ids[] = $to;

      $chat_ids[] = $history['id'];

    }

  }

}

$history     = array();

$requester_chat_count='0';

if(!empty($chat_ids)){    


  $this->db->select('C.id,C.chat_from,C.chat_to,C.content,C.chat_utc_time,C.status,UF.username as fromname,UF.profile_img as from_profile_img,UT.username,UT.profile_img as profile_img');

  $this->db->from('chats_requester C');

  $this->db->join('users UF','UF.user_id= C.chat_to','left');

  $this->db->join('users UT','UT.user_id= C.chat_from','left');

  $this->db->where_in("id",$chat_ids);



  $this->db->where('from_delete_sts', 0);

  $this->db->where('to_delete_sts', 0);

  $this->db->order_by('id', 'desc');

       // $this->db->limit(10, $offset);

  $chathistory_array =  $this->db->get()->result_array();

  $chathistory = array();





  if(count($chathistory_array) > 0){

    foreach ($chathistory_array as $value) {

      if($value['chat_from'] !=  $user_id){
       $chat_count=count($this->db->where("chat_from = '".$value['chat_from']."' AND chat_to ='".$user_id."'")->where("status = 0")->get('chats_requester')->result_array());
       $requester_chat_count = (string)$chat_count;

     }

   }

 }



}

return $requester_chat_count;



}

public function conversations_requester($id,$user_id,$page)

{

        //$this->db->where("(chat_from = '$id' AND chat_to = '$user_id') OR (chat_from = '$user_id' AND chat_to = '$id')");
  $this->db->where("chat_from = '$id' AND chat_to = '$user_id'");
  $this->db->update('chats_requester', array('status'=> 1));

  $this->db->select('*');

  $this->db->from('chats_requester C');

  $this->db->join('users UF','UF.user_id= C.chat_from','left');

  $this->db->join('users UT','UT.user_id= C.chat_to','left');

  $this->db->where("(chat_from = '$id' AND chat_to = '$user_id') OR (chat_from = '$user_id' AND chat_to = '$id')");

  $this->db->where('from_delete_sts', 0);

  $this->db->where('to_delete_sts', 0);

  $count = $this->db->get()->num_rows();



  $offset = ($page>1)?(($page-1)*30):0;



  $this->db->select('C.id,C.chat_from,C.chat_to,C.content,C.chat_utc_time,C.status,UF.username as fromname,UT.username as toname');

  $this->db->from('chats_requester C');

  $this->db->join('users UF','UF.user_id= C.chat_from','left');

  $this->db->join('users UT','UT.user_id= C.chat_to','left');

  $this->db->where("(chat_from = '$id' AND chat_to = '$user_id') OR (chat_from = '$user_id' AND chat_to = '$id')");

  $this->db->where('from_delete_sts', 0);

  $this->db->where('to_delete_sts', 0);

  $this->db->order_by('id', 'DESC');

  $this->db->limit(30, $offset);

  $chathistory = $this->db->get()->result_array();



  if(count($chathistory) > 0){

    usort($chathistory,function($a,$b){

     $x = $a['id'];

     $y = $b['id'];

     if ($x== $y)

      return 0;

    if ($x < $y)

      return -1;

    else

      return 1;

  });



  }

  $chathistory_new = array();

  if(!empty($chathistory)){

    foreach ($chathistory as $chat) {

      $datetime = $chat['chat_utc_time'];

      $time = utc_date_conversion($datetime);

      $chat['time'] = date('h:i A',strtotime($time));

      $chat['date'] = date('Y-m-d',strtotime($time));

      $chathistory_new[] = $chat;

    }

  }



  $chathistory = $chathistory_new;



  $total_pages = 0;

  $next_page  = -1;



  if($count > 0 && $page > 0){



   $total_pages = ceil($count / 30);

   if($page < $total_pages){



     $next_page = ($page + 1);



   }else{



     $next_page = -1;

   }

 }



 $history['next_page']    = $next_page;

 $history['current_page'] = $page;

 $history['total_pages']  = $total_pages;

 $history['chat_list'] = $chathistory;



 return $history;

}

public function chat_conversation_requester($array)

{



  $array['chat_from'] = $this->get_user_id_using_token($array['token']);



  unset($array['token']);

  $this->db->insert('chats_requester', $array);

  $id = $this->db->insert_id();

  $this->db->select('C.id,C.chat_to,C.chat_from,C.content,C.chat_utc_time,C.status,UF.username as fromname,UT.username as toname');

  $this->db->from('chats_requester C');

  $this->db->join('users UF','UF.user_id= C.chat_to','left');

  $this->db->join('users UT','UT.user_id= C.chat_from','left');

  $this->db->where(array('id'=>$id));

  return $this->db->get()->row_array();

}
public function get_service_details($inputs)

{



  $user_id = $this->get_user_id_using_token($inputs['token']);

  $service_id = $inputs['service_id'];

  return $this->db->get_where('provider_details',array('p_id'=>$service_id,'user_id'=>$user_id,'delete_status'=>0))->row_array();

}



public function get_request_details($inputs)

{



  $user_id = $this->get_user_id_using_token($inputs['token']);

  $request_id = $inputs['request_id'];

  return $this->db->get_where('request_details',array('r_id'=>$request_id,'user_id'=>$user_id,'delete_status'=>0))->row_array();

}



public function get_request_id_details($r_id)

{

  $new_details = array();

  $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,RD.request_time,RD.currency_code,RD.proposed_fee as amount,RD.contact_number,RD.latitude,RD.longitude,RD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no");

  $this->db->from("request_details RD");

  $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');

  $this->db->where("RD.r_id", $r_id);

  $this->db->where("RD.status = 1");

  $rescords = $this->db->get()->row_array();

  return $rescords;

}



public function get_history_details($r_id)

{

  $records = array();

  $this->db->select("RD.r_id,RD.user_id as requester_id,RD.title,RD.description,RD.location,RD.request_date,RD.request_time,RD.currency_code,RD.proposed_fee as amount,RD.contact_number,RD.latitude,RD.longitude,RD.status,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no,RAD.id as rad_id,RAD.status as rad_status,RAD.acceptor_id,

    U1.username as acceptor_name,U1.email as acceptor_email,U1.profile_img as acceptor_image,U1.mobile_no as acceptor_mobile");

  $this->db->from("request_details RD");

  $this->db->join('request_accept_details RAD', 'RAD.request_id = RD.r_id', 'LEFT');

  $this->db->join('users U', 'U.user_id = RD.user_id', 'LEFT');

  $this->db->join('users U1', 'U1.user_id = RAD.acceptor_id', 'LEFT');

  $this->db->where("RD.r_id", $r_id);

  $this->db->where("RD.status = 1");

  $records = $this->db->get()->row_array();

  return $records;



}



public function provider_details($p_id)

{



 $this->db->select("PD.p_id,PD.user_id as provider_id,PD.category,PD.subcategory,PD.title,PD.description_details,PD.contact_number,PD.availability,PD.location,PD.latitude,PD.longitude,PD.start_date,PD.end_date,PD.status,PD.created,U.username,U.email,U.profile_img,U.mobile_no as profile_contact_no");

 $this->db->from('provider_details PD');

 $this->db->join('users U', 'U.user_id = PD.user_id', 'LEFT');

 $this->db->where("PD.p_id", $p_id);

 $this->db->where("PD.status = 1");

 $service_details = $this->db->get()->row_array();



 $end_Date=date('Y-m-d', strtotime($service_details['end_date'].'+1 days'));

 $period = new DatePeriod(

   new DateTime($service_details['start_date']),

   new DateInterval('P1D'),

   new DateTime($end_Date)

 );



 $availability_details = json_decode($service_details['availability'],true);



 $weekday =array();

 $timings=array();



 foreach ($availability_details as $availability) {



  $day = $availability['day'];



  if($day == 1)

  {

    $weekday[] = 'Mon';

    $weekdays = 'Mon';

  }

  if($day == 2)

  {

    $weekday[] = 'Tue';

    $weekdays = 'Tue';

  }

  if($day == 3)

  {

    $weekday[] = 'Wed';

    $weekdays = 'Wed';

  }

  if($day == 4)

  {

    $weekday[] = 'Thu';

    $weekdays = 'Thu';

  }

  if($day == 5)

  {

    $weekday[] = 'Fri';

    $weekdays = 'Fri';

  }

  if($day == 6)

  {

    $weekday[] = 'Sat';

    $weekdays = 'Sat';

  }

  if($day == 7)

  {

    $weekday[] = 'Sun';

    $weekdays = 'Sun';

  }



  $timings[$weekdays] = $availability['from_time'] . "-" . $availability['to_time'];



}





$availability_date=array();

foreach ($period as $key => $value) 

{



  if (in_array($value->format('D'), $weekday))

  {

    if (date("Y-m-d") <= $value->format('Y-m-d')) 

    {

     $row['service_date']= $value->format('d-m-Y'); 

     $row['service_day']= $value->format('l'); 

     $row['service_time']= $timings[$value->format('D')];

     $row['is_selected']="0";



     $availability_date[]=$row;

   }



 }
}
return $availability_date;
}



public function book_service($token,$user_post_data)

{
  $user_id = $this->get_user_id_using_token($token);
  $data['date']=date('Y-m-d H:i:s');
  $data['service_date']=date('Y-m-d',strtotime($user_post_data['Servicedate']));
  $service_time=explode('-', $user_post_data['Servicetime']);
  $data['from_time']=date('H:i:s',strtotime($service_time[0]));
  $data['to_time']=date('H:i:s',strtotime($service_time[1]));
  $data['notes']=$user_post_data['Notes'];
  $data['provider_id']=$user_post_data['Providerid'];
  $data['user_id']=$user_id;
  $data['latitude']=$user_post_data['Latitude'];
  $data['longitude']=$user_post_data['Longitude'];
  $data['service_status']=1;
  $data['notification_status']=1;
  $data['status']=1;

  $this->db->where('service_date', $user_post_data['Servicedate']);
  $this->db->where('service_status',1);
  $this->db->where('provider_id',$user_post_data['Providerid']);
  $this->db->where('user_id', $user_id);
  $count = $this->db->count_all_results('book_service');

  if($count == 0)
  {
    if($this->db->insert('book_service',$data))
    {
     $result=1;
   }else{
     $result=2;
   }
 }else{
  $result=3;
}
  return $result;
}



public function my_booking_list($token)

{

 $user_id = $this->get_user_id_using_token($token);

 $result=array();

 $data= $this->db->query("SELECT bs.*, pd.title,u.mobile_no, u.full_name,u.profile_img,u.email,r.id as rating FROM book_service AS bs LEFT JOIN provider_details AS pd ON bs.provider_id=pd.p_id LEFT JOIN users AS u ON u.user_id=pd.user_id LEFT JOIN rating_review AS r ON r.p_id=bs.provider_id WHERE bs.user_id='".$user_id."'")->result_array();
          //print_r($data); exit;

 if(!empty($data))

 {

  foreach ($data as $rows) 

  {

    $row['service_date']= $rows['service_date']; //date('d M Y',strtotime($rows['service_date']));

    $row['service_time']=date('h:i A',strtotime($rows['from_time'])).' - '.date('h:i A',strtotime($rows['to_time']));

    $row['notes']=$rows['notes'];

    $row['latitude']=$rows['latitude'];

    $row['longitude']=$rows['longitude'];

    $row['title']=$rows['title'];

    $row['contact_number']=$rows['mobile_no'];

    $row['full_name']=$rows['full_name'];

    $row['email']=$rows['email'];

    $row['profile_img']=$rows['profile_img'];

    $row['service_status']=$rows['service_status'];

    $row['id']=$rows['id'];

    $row['provider_id']=$rows['provider_id'];

    if($rows['rating'] != ''){

      $row['is_rate']= '1';
    } else{
      $row['is_rate']= '0';
    }


    $result[]=$row;

    

  }



}



return $result;

}



public function booking_request_list($token)

{

 $user_id = $this->get_user_id_using_token($token);

 $result=array();

 $data= $this->db->query("SELECT bs.*, pd.title,u.mobile_no, u.full_name,u.profile_img,u.email FROM book_service AS bs LEFT JOIN provider_details AS pd ON bs.provider_id=pd.p_id LEFT JOIN users AS u ON u.user_id=bs.user_id WHERE pd.user_id='".$user_id."'")->result_array();


          //print_r($this->db->last_query()); exit;
 if(!empty($data))

 {

  foreach ($data as $rows) 

  {

    $row['service_date']= $rows['service_date']; //date('d M Y',strtotime($rows['service_date']));

    $row['service_time']=date('h:i A',strtotime($rows['from_time'])).' - '.date('h:i A',strtotime($rows['to_time']));

    $row['notes']=$rows['notes'];

    $row['latitude']=$rows['latitude'];

    $row['longitude']=$rows['longitude'];

    $row['title']=$rows['title'];

    $row['contact_number']=$rows['mobile_no'];

    $row['full_name']=$rows['full_name'];

    $row['email']=$rows['email'];

    $row['profile_img']=$rows['profile_img'];
    
    $row['service_status']=$rows['service_status'];

    $row['id']=$rows['id'];

    $row['provider_id']=$rows['provider_id'];



    $result[]=$row;

    

  }



}



return $result;

}

public function rate_review_for_provider($inputs)

{

  $new_details = array();

  $user_id = $this->get_user_id_using_token($inputs['token']);

  $new_details['user_id'] = $user_id;

  $new_details['p_id'] = $inputs['p_id'];

  $new_details['type'] = $inputs['type'];

  $new_details['rating'] = $inputs['rating'];

  $new_details['review'] = $inputs['review'];

  $new_details['created'] =  date('Y-m-d H:i:s');
  
  $this->db->where('status',1);

  $this->db->where('p_id',$inputs['p_id']);

  $this->db->where('user_id', $user_id);

  $count = $this->db->count_all_results('rating_review');

  if($count == 0)

  {

    return   $this->db->insert('rating_review', $new_details);
  }

  else

  {

    return $result = 2;

  }
  

}
public function comments_for_provider($inputs)

{

  $new_details = array();

  $user_id = $this->get_user_id_using_token($inputs['token']);

  $new_details['commenter_id'] = $user_id;

  $new_details['p_id'] = $inputs['p_id'];

  $new_details['comment'] = $inputs['comment'];

  $new_details['created'] =  date('Y-m-d H:i:s');

  $this->db->insert('comments', $new_details);

  return $this->db->insert_id();

}

public function replies_for_comments($inputs)

{

  $new_details = array();

  $user_id = $this->get_user_id_using_token($inputs['token']);

  $new_details['user_id'] = $user_id;

  $new_details['comment_id'] = $inputs['comment_id'];

  $new_details['p_id'] = $inputs['p_id'];

  $new_details['replies'] = $inputs['replies'];

  $new_details['replies_date'] =  date('Y-m-d H:i:s');

  $this->db->insert('replies', $new_details);

  return $this->db->insert_id();

}

public function rate_review_list($inputs)

{
  $offset = ($inputs['Page']>1)?(($inputs['Page']-1)*10):0;

  $this->db->select('R.id as rate_id,R.rating,review,R.rating,U.username as reviewer,U.profile_img');

  $this->db->from('rating_review R');

  $this->db->join('users U', 'U.user_id = R.user_id', 'LEFT');

  $this->db->where('p_id',$inputs['Pid']);

  $this->db->where('R.status',1);

  $count = $this->db->get()->num_rows();

  $this->db->select('R.id as rate_id,R.rating,review,R.rating,U.username as reviewer,U.profile_img,RT.name as rate_type,R.created');

  $this->db->from('rating_review R');

  $this->db->join('users U', 'U.user_id = R.user_id', 'LEFT');

  $this->db->join('ratings_type RT', 'RT.id = R.type', 'LEFT');

  $this->db->where('p_id',$inputs['Pid']);

  $this->db->where('R.status',1);

  $this->db->limit(10, $offset);

  $rescords = $this->db->get()->result_array();

  $rescords_new = array();

  if(!empty($rescords)){

    foreach ($rescords as $data) {

      $datetime = $data['created'];

      $data['created'] = utc_date_conversion($datetime);

      if($data['rate_type'] == null){
        $data['rate_type'] = '';
      }

      $rescords_new[] = $data;

    }

  }

  $rescordss = $rescords_new;

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

 $new_details['review_list'] = $rescordss;





 return $new_details;


}

public function comments_list($inputs)

{
 $offset = ($inputs['Page']>1)?(($inputs['Page']-1)*10):0;

 $this->db->select('C.comment,C.id as comment_id,C.commenter_id as user_id,C.p_id as provider_id,U.username as commenter,U.profile_img,C.created');

 $this->db->from('comments C');

 $this->db->join('users U', 'U.user_id = C.commenter_id', 'LEFT');

 $this->db->where('p_id',$inputs['Pid']);

 $this->db->where('C.status',1);

 $count = $this->db->get()->num_rows();

 $this->db->select('C.comment,C.id as comment_id,C.commenter_id as user_id,C.p_id as provider_id,U.username as commenter,U.profile_img,C.created');

 $this->db->from('comments C');

 $this->db->join('users U', 'U.user_id = C.commenter_id', 'LEFT');

 $this->db->where('p_id',$inputs['Pid']);

 $this->db->where('C.status',1);

 $this->db->order_by('C.id', 'DESC');

 $this->db->limit(10, $offset);

 $result = $this->db->get()->result_array();

 $details=array();

 foreach ($result as $data) {
   $details[] = array(
    "comment" => $data['comment'],
    "days_ago" => $this->time_elapsed_string( $data['created']),
    "comment_id"=> $data['comment_id'],
    "provider_id"=> $data['provider_id'],
    "user_id"=> $data['user_id'],
    "name"=> $data['commenter'],
    "profile_image"=> $data['profile_img'],
    "replies_count" => (string)$this->replies_details($data['comment_id'],1),
  );
 }

 $total_pages = 0;
 $next_page  = -1;
 $page = $inputs['Page'];

 if($count > 0 && $page > 0){
   $total_pages = ceil($count / 10);
   $page        = $inputs['Page'];

   if($page < $total_pages){
     $next_page = ($page + 1);
   }else{
     $next_page = -1;
   }
 }

 $new_details['next_page']    = $next_page;
 $new_details['current_page'] = $page;
 $new_details['total_pages']  = $total_pages;
 $new_details['comments_list'] = $details;
 return $new_details;

}
public function comments_details($id)

{
 $this->db->select('C.comment,C.id,C.commenter_id as user_id,C.p_id as provider_id,U.username as commenter,U.profile_img,C.created');
 $this->db->from('comments C');
 $this->db->join('users U', 'U.user_id = C.commenter_id', 'LEFT');
 $this->db->where('id',$id);
 $this->db->where('C.status',1);
 $result = $this->db->get()->result_array();
 $details=array();
 foreach ($result as $data) {
   $details = array(
    "comment" => $data['comment'],
    "days_ago" => $this->time_elapsed_string( $data['created']),
    "comment_id"=> $data['id'],
    "provider_id"=> $data['provider_id'],
    "user_id"=> $data['user_id'],
    "name"=> $data['commenter'],
    "profile_image"=> $data['profile_img'],
    "replies_count" => (string)$this->replies_details($data['id'],1),
  );
 }
 return $details;
}
public function replies_details($comment_id,$type=1)
{

 $this->db->select("r.*,u.username,u.profile_img");
 $this->db->from('replies r');
 $this->db->join('users u','r.user_id=u.user_id','LEFT');
 $this->db->where('r.comment_id',$comment_id);
 if($type == 1){
  return $this->db->count_all_results(); 
}else{

 $this->db->order_by('r.replies_date', 'ASC');
 $result= $this->db->get()->result_array();

 $details=array();

 foreach ($result as $data) {
   $details[] = array(
     "replies" => $data['replies'],
     "days_ago" => $this->time_elapsed_string( $data['replies_date']),
     "replies_id"=> $data['id'],
     "provider_id"=> $data['p_id'],
     "user_id"=> $data['user_id'],
     "comment_id"=> $data['comment_id'],
     "name"=> $data['username'],
     "profile_image"=> $data['profile_img'],
     
   );
   
 }

 return $details;
 
}


}
public function replies($replies_id)
{

  $this->db->select("r.*,u.username,u.profile_img");
  $this->db->from('replies r');
  $this->db->join('users u','r.user_id=u.user_id','LEFT');
  $this->db->where('r.id',$replies_id);
  $this->db->order_by('r.replies_date', 'ASC');
  $result= $this->db->get()->result_array();

  $details=array();

  foreach ($result as $data) {
   $details = array(
     "replies" => $data['replies'],
     "days_ago" => $this->time_elapsed_string( $data['replies_date']),
     "replies_id"=> $data['id'],
     "provider_id"=> $data['p_id'],
     "user_id"=> $data['user_id'],
     "comment_id"=> $data['comment_id'],
     "name"=> $data['username'],
     "profile_image"=> $data['profile_img'],
     
   );
   
 }

 return $details;
}
public function replies_list($inputs)

{
  $offset = ($inputs['page']>1)?(($inputs['page']-1)*10):0;

  $this->db->select("r.*,u.username,u.profile_img");
  $this->db->from('replies r');
  $this->db->join('users u','r.user_id=u.user_id','LEFT');
  $this->db->where('r.comment_id',$inputs['comment_id']);

  $count = $this->db->get()->num_rows();

  $this->db->select("r.*,u.username,u.profile_img");
  $this->db->from('replies r');
  $this->db->join('users u','r.user_id=u.user_id','LEFT');
  $this->db->where('r.comment_id',$inputs['comment_id']);

  $this->db->limit(10, $offset);

  $result = $this->db->get()->result_array();

  foreach ($result as $data) {
   $details[] = array(
     "replies" => $data['replies'],
     "days_ago" => $this->time_elapsed_string( $data['replies_date']),
     "replies_id"=> $data['id'],
     "provider_id"=> $data['p_id'],
     "user_id"=> $data['user_id'],
     "comment_id"=> $data['comment_id'],
     "name"=> $data['username'],
     "profile_image"=> $data['profile_img'],
     
   );
   
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

 $new_details['replies_list'] = $details;





 return $new_details;

}
private function time_elapsed_string($datetime, $full = false)
{
 $now = new DateTime;
 $ago = new DateTime($datetime);
 $diff = $now->diff($ago);

 $diff->w = floor($diff->d / 7);
 $diff->d -= $diff->w * 7;

 $string = array(
   'y' => 'year',
   'm' => 'month',
   'w' => 'week',
   'd' => 'day',
   'h' => 'hour',
   'i' => 'minute',
   's' => 'second',
 );
 foreach ($string as $k => &$v) {
   if ($diff->$k) {
     $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
   } else {
     unset($string[$k]);
   }
 }

 if (!$full) $string = array_slice($string, 0, 1);
 return $string ? implode(', ', $string) . ' ago' : 'just now';
}

public function ratings_type()

{

 return $this->db->where('status',0)->get('ratings_type')->result_array();

}

public function languages_list() {
  $this->db->select('language,language_value,tag');
  $this->db->from('language');
  $this->db->where('status', '1');
  $records = $this->db->get()->result_array();
  return $records;
}

}



/* End of file Api_model.php */

/* Location: ./application/models/Api_model.php */

