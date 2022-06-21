<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';


class Api extends REST_Controller {


  public function __construct() {

    parent::__construct();
        error_reporting(0);
    $this->load->helper('push_notifications');
    $this->load->helper('custom_language');
      $this->load->helper('currency_helper');

      $header =  getallheaders(); // Get Header Data
      $lang = (!empty($header['language']))?$header['language']:'';
      if(empty($lang)){
        $lang = (!empty($header['Language']))?$header['Language']:'en';
      }
      $language = get_languages($lang);
      $language = (!empty($language['language']))?$language['language']:'en';

        $token = (!empty($header['token']))?$header['token']:'';
        if(empty($token)){
            $token = (!empty($header['Token']))?$header['Token']:'';
        }
        $this->default_token = md5('Dreams99');
        $this->api_token = $token;



        $this->data['secret_key'] = '';

        $this->data['publishable_key'] = '';

        $this->data['website_logo_front'] ='assets/img/logo.png';

        $publishable_key='';
        $secret_key='';
        $live_publishable_key='';
        $live_secret_key='';
        $stripe_option='';


        $query = $this->db->query("select * from system_settings WHERE status = 1");
        $result = $query->result_array();
        if(!empty($result))
        {
          foreach($result as $data){



             if($data['key'] == 'secret_key'){

                $secret_key = $data['value'];

            }

            if($data['key'] == 'publishable_key'){

                $publishable_key = $data['value'];

            }

            if($data['key'] == 'live_secret_key'){

                $live_secret_key = $data['value'];

            }

            if($data['key'] == 'live_publishable_key'){

                $live_publishable_key = $data['value'];

            }

            if($data['key'] == 'stripe_option'){

                $stripe_option = $data['value'];

            } 


        }
    }


    if(@$stripe_option == 1){

      $this->data['publishable_key'] = $publishable_key;

      $this->data['secret_key']      = $secret_key;

  }

  if(@$stripe_option == 2){

      $this->data['publishable_key'] = $live_publishable_key;

      $this->data['secret_key']      = $live_secret_key;

  }


  $config['publishable_key'] =  $this->data['publishable_key'];

  $config['secret_key'] = $this->data['secret_key'];

  $this->load->library('stripe',$config);



  $this->language_content = $language;
  $this->load->model('api_model','api');

}

public function login_post()
{
   $data = array();
   $user_data = array();
   $user_post_data = $this->post();
   $user_data =  getallheaders(); // Get Header Data  
   $user_data = array_merge($user_data,$user_post_data);

   $response_code = '-1';
   $response_message = $this->language_content['lg11_validation_erro'];
   if(!empty($user_data['Loginthrough'])){
      if($user_data['Loginthrough'] == 1){
         if(!empty($user_data['Username']) && !empty($user_data['Password'])){

            $result = $this->api->login($user_data);

            if(!empty($result)){

               $response_code = '1';
               $response_message = $this->language_content['lg11_records_found'];
               $data['user_details'] = $result;

           }else{

               $response_code = '-1';
               $response_message = $this->language_content['lg11_invalid_login_d'];
           }

       }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_login_username_'];
    }
}else if($user_data['Loginthrough'] == 2 || $user_data['Loginthrough'] == 3 || $user_data['Loginthrough'] == 4){

 if(!empty($user_data['Tokenid']) ){

    $result = $this->api->login($user_data);

    if(!empty($result)){

       $response_code = '1';
       $response_message = $this->language_content['lg11_records_found'];
       $data['user_details'] = $result;

   }else{

       $response_code = '-2';
       $response_message = $this->language_content['lg11_user_details_no'];
   }
}else{
    $response_code = '-1';
    $response_message = $this->language_content['lg11_login_tokenid_i'];
}

}


}else{
  $response_code = '-1';
  $response_message = $this->language_content['lg11_login_type_is_n'];
}


$result = $this->data_format($response_code,$response_message,$data);

$this->response($result, REST_Controller::HTTP_OK);
}




public function forgot_password_post()
{

   $user_data = array();
   $user_post_data = $this->post();
   $user_data =  getallheaders(); // Get Header Data  
   $user_data = array_merge($user_data,$user_post_data);
    
   $response_code = '-1';
   $response_message = $this->language_content['lg11_email_address_n'];

   if(!empty($user_data['Emailaddress'])){

      $result = $this->api->forgot_password($user_data['Emailaddress']);

      if($result){

         $response_code = '1';
         $response_message = $this->language_content['lg11_password_reset_'];

     }else{

         $response_code = '-1';
         $response_message = $this->language_content['lg11_email_address_n1'];
     }

 }else{

  $response_code = '-1';
  $response_message = $this->language_content['lg11_email_address_m'];
}

$result = $this->data_format($response_code,$response_message,$data);

$this->response($result, REST_Controller::HTTP_OK);
}

public function change_password_post()
{
      $user_data = array();
      $user_post_data = $this->post();
    $user_data =  getallheaders(); // Get Header Data
    
    $user_data = array_merge($user_data,$user_post_data);
    $token = (!empty($user_data['Token']))?$user_data['Token']:'';
    if(empty($token)){
      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
    }

    $data = array();
    $response_code = '-1';
    $response_message = $this->language_content['lg11_email_address_n'];

    if(!empty($token)){
      $result = $this->api->token_is_valid($token);

      if($result){
        if(!empty($user_data['Currentpassword']) && !empty($user_data['Newpassword']) && !empty($user_data['Confirmpassword'])){
          $user_data['Token'] = $token;
          $result = $this->api->change_password($user_data);
          if($result){
            $response_code = '1';
            $response_message = 'Password changed successfully...';
          }else{
            $response_code = '-1';
            $response_message = 'Current password not match...';
          }
        }else{
          $response_code = '-1';
          $response_message = $response_message = $this->language_content['lg11_required_input_'];
        }
      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_invalid_user_to'];
      }
    }else{
      $response_code = '-1';
      $response_message = $this->language_content['lg11_user_token_is_m'];
    }
    $result = $this->data_format($response_code,$response_message,$data);
    $this->response($result, REST_Controller::HTTP_OK);
  }


  public function logout_post()
  {
    $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);
      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }
      $user_data['Token'] = $token;

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($user_data['Token'])){
        if(!empty($user_data['Devicetype']) && !empty($user_data['Deviceid'])){

          $result = $this->api->logout($user_data['Token'],$user_data['Devicetype'],$user_data['Deviceid']);

          if($result){

            $response_code = '1';
            $response_message = $this->language_content['lg11_logout_successf'];

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_invalid_user_to'];
          }
        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_required_input_'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }


    public function subscription_get()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      
      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      $result = $this->api->token_is_valid($token);

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);
        $user_data = $this->db->where('unique_code',$token)->get('users')->result_array();

        if($result){ 
          $result = $this->api->subscription();
      if(!empty($result)){
            
            $user_currency = get_api_user_currency($user_data[0]['user_id']);
            $UserCurrency = $user_currency['user_currency_code'];
            $result_data=array();
           
            foreach ($result as $currency_value) {
             
               $result_data['id']= $currency_value['id'];
               $result_data['subscription_name']= $currency_value['subscription_name'];
               $result_data['fee'] = (!empty($UserCurrency)) ? get_gigs_currency($currency_value['fee'], $currency_value['currency_code'], $UserCurrency) : $currency_value['fee'];
               $result_data['currency_symbol']= currency_code_sign($UserCurrency);
               $result_data['currency_code']= $UserCurrency;
               $result_data['duration']= $currency_value['duration'];
               $result_data['fee_description']= $currency_value['fee_description'];
               $result_data['status']= $currency_value['status'];
               $results[]=$result_data;
             }

             $response_code = '1';
             $response_message = $this->language_content['lg11_subscription_li'];
             $data['subscription_list'] = $results; //
            }

         }else{

             $response_code = '-1';
             $response_message = $this->language_content['lg11_invalid_user_to'];
         }
     }else{

      $response_code = '-1';
      $response_message = $this->language_content['lg11_user_token_is_m'];
  }
  $result = $this->data_format($response_code,$response_message,$data);
  $this->response($result, REST_Controller::HTTP_OK);
}

public function category_get()
{
   $user_data = array();
      $user_data =  getallheaders(); // Get Header Data


      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        if($token==$this->api_token){
                $result=1;           
            }
            else
            {
                $result = $this->api->token_is_valid($token);
            }

            if($result){

               $result = $this->api->category();
               $response_code = '1';
               $response_message = "category list";
               $data['category_list'] = $result;

           }else{

               $response_code = '-1';
               $response_message = $this->language_content['lg11_invalid_user_to'];
           }

       }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
  }


  public function terms_get()
  {
     $user_data = array();

     $query = $this->db->query("select * from system_settings WHERE status = 1");
     $result = $query->result_array();
     $terms = '';
     if(!empty($result))
     {
      foreach($result as $datas){
       if($datas['key'] == 'terms'){
        $terms = $datas['value'];
    }


}
}
if($result){

  $result = $this->api->category();
  $response_code = '1';
  $response_message = "Terms";
  $data['terms'] = $terms;

}else{

  $response_code = '-1';
  $response_message = $this->language_content['lg11_invalid_user_to'];
}



$result = $this->data_format($response_code,$response_message,$data);

$this->response($result, REST_Controller::HTTP_OK);
}


public function sub_category_post()
{
    $user_data = array();
      $user_data =  getallheaders(); // Get Header Data

      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        if($token==$this->api_token){
                $result=1;           
            }
            else
            {
                $result = $this->api->token_is_valid($token);
            }

            if($result){

             $result = $this->api->subcategory($user_data['Category']);
             $response_code = '1';
             $response_message = "category list";
             $data['category_list'] = $result;

         }else{

             $response_code = '-1';
             $response_message = $this->language_content['lg11_invalid_user_to'];
         }

     }else{

      $response_code = '-1';
      $response_message = $this->language_content['lg11_user_token_is_m'];
  }

  $result = $this->data_format($response_code,$response_message,$data);

  $this->response($result, REST_Controller::HTTP_OK);
}

public function provide_post()
{
   $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){
        
          if(!empty($user_data['title']) && !empty($user_data['category']) && !empty($user_data['description_details']) && !empty($user_data['contact_number'])&& !empty($user_data['availability']) && !empty($user_data['latitude']) && !empty($user_data['longitude'])&& !empty($user_data['start_date'])&& !empty($user_data['end_date']) && !empty($user_data['location'])){

            $user_data['token'] = $token;
            $result = $this->api->new_provide_by_user($user_data);
            if($result == 1){


              $response_code = '1';
              $response_message = $this->language_content['lg11_new_provide_det'];

              $to_user_id = 0;
              $title = $user_data['title'];
              $user_id = $this->api->get_user_id_using_token($user_data['token']);
              $name  = $this->api->username($user_id);
              $username = $name['username'];
              $message = $this->language_content['lg11_new_service_cre'].' '.$username;
              $this->notifications($this->language_content['lg11_new_service'],$title,$message,$to_user_id,$user_id);

            }else if($result == 2){
              $response_code = '-1';
              $response_message = $this->language_content['lg11_this_title_alre'];
            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }


    public function provide_update_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['title']) && !empty($user_data['category']) && !empty($user_data['description_details']) && !empty($user_data['contact_number']) && !empty($user_data['latitude']) && !empty($user_data['longitude']) && !empty($user_data['service_id']) && !empty($user_data['location'])){
            $user_data['token'] = $token;
            $result = $this->api->update_service($user_data);
            if($result == 1){

              $response_code = '1';
              $response_message = $this->language_content['lg11_provide_details'];

              $to_user_id = 0;
              $title = $user_data['title'];
              $user_id = $this->api->get_user_id_using_token($user_data['token']);
              $name  = $this->api->username($user_id);
              $username = $name['username'];
              $message = $this->language_content['lg11_new_service_cre'].' '.$username;
              $this->notifications($this->language_content['lg11_update_service'],$title,$message,$to_user_id,$user_id);

            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function provide_details_post()
    {

      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }
      $user_data['token'] = $token;

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['service_id'])){

            $user_data['token'] = $token;
            $result = $this->api->get_service_details($user_data);

            if(!empty($result)){

              $response_code = '1';
              $response_message = $this->language_content['lg11_service_details'];
              $data['service_details'] = $result;
            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }
          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_service_id_is_m'];
          }

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);

    }
    public function service_remove_post()
    {

      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){
          $user_data['token'] = $token;

          if(!empty($user_data['service_id']) && !empty($user_data['token'])){

            $result = $this->api->service_remove($user_data);

            if($result){

              $response_code = '1';
              $response_message = $this->language_content['lg11_service_removed'];
              $data = array();

            }else{

              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];

            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);

    }


    public function request_remove_post()
    {

      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){
          $user_data['token'] = $token;

          if(!empty($user_data['request_id']) && !empty($user_data['token'])){

            $result = $this->api->request_remove($user_data);

            if($result){

              $response_code = '1';
              $response_message = $this->language_content['lg11_request_removed'];
              $data = array();

            }else{

              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];

            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);

    }

    public function provider_list_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

         if($token==$this->api_token){
            $result=1;           
        }
        else
        {
            $result = $this->api->token_is_valid($token);
        }

        if($result){

         if(!empty($user_data) && !empty($user_data['Latitude']) && !empty($user_data['Category']) && !empty($user_data['Longitude'])){

            $user_data['Token'] = $token;
            $user_data['Page']  = (!empty($user_data['Page']))?$user_data['Page']:1;

            $result = $this->api->provider_list($user_data);
         
            if(!empty($result['total_pages'])){

               $response_code = '1';
               $response_message = $this->language_content['lg11_provider_listed'];

               if($result['total_pages']< $result['current_page']){
                  $response_code = '-1';
                  $response_message = $this->language_content['lg11_invalid_page'];
              }

              $data = $result;

          }else{

           $response_code = '0';
           $response_message = $this->language_content['lg11_no_records_foun'];

       }

   }else{

    $response_code = '-1';
    $response_message = $this->language_content['lg11_required_input_'];
}


}else{

 $response_code = '-1';
 $response_message = $this->language_content['lg11_invalid_user_to'];
}

}else{

  $response_code = '-1';
  $response_message = $this->language_content['lg11_user_token_is_m'];
}
$result = $this->data_format($response_code,$response_message,$data);
$this->response($result, REST_Controller::HTTP_OK);
}

public function provider_search_list_post()
{
   $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if((!empty($user_data['Searchtitle']) || (!empty($user_data['Searchdate']) || !empty($user_data['Location'])))  || !empty($user_data['Latitude']) && !empty($user_data['Longitude']) ){

            $user_data['Token'] = $token;
            $user_data['Page']  = (!empty($user_data['Page']))?$user_data['Page']:1;

            $result = $this->api->provider_search_list($user_data);

            if(!empty($result['total_pages'])){

              $response_code = '1';
              $response_message = $this->language_content['lg11_provider_listed'];

              if($result['total_pages']< $result['current_page']){
                $response_code = '-1';
                $response_message = $this->language_content['lg11_invalid_page'];
              }

              $data = $result;

            }else{

              $response_code = '0';
              $response_message = $this->language_content['lg11_no_records_foun'];

            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function my_provider_list_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data)){

            $user_data['token'] = $token;
            $user_data['page']  = (!empty($user_data['page']))?$user_data['page']:1;

            $result = $this->api->my_provider_list($user_data);

            if(!empty($result['total_pages'])){

              $response_code = '1';
              $response_message = 'My list';

              if($result['total_pages']< $result['current_page']){
                $response_code = '-1';
                $response_message = $this->language_content['lg11_invalid_page'];
              }

              $data = $result;

            }else{

              $response_code = '0';
              $response_message = $this->language_content['lg11_no_records_foun'];

            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }

    
    public function request_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['Title']) && !empty($user_data['Description']) && !empty($user_data['Location']) && !empty($user_data['Requestdate']) && !empty($user_data['Requesttime']) && !empty($user_data['Proposedfee']) && !empty($user_data['Contactnumber'])&& !empty($user_data['Latitude']) && !empty($user_data['Longitude'])){

            $user_data['Token'] = $token;

            $result = $this->api->new_request_by_user($user_data);
            if($result == 1){

              $response_code = '1';
              $response_message =  $this->language_content['lg11_new_request_det'];

              $to_user_id = 0;
              $title = $user_data['Title'];
              $user_id = $this->api->get_user_id_using_token($user_data['Token']);
              $name  = $this->api->username($user_id);
              $username = $name['username'];
              $message = $this->language_content['lg11_new_request_cre'].' '.$username;

            }else if($result == 2){
              $response_code = '-1';
              $response_message = $this->language_content['lg11_this_title_alre'];
            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function request_update_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['title']) && !empty($user_data['description']) && !empty($user_data['location']) && !empty($user_data['request_date']) && !empty($user_data['request_time']) && !empty($user_data['proposed_fee']) && !empty($user_data['contact_number'])&& !empty($user_data['latitude']) && !empty($user_data['longitude']) && !empty($user_data['request_id'])){

            $user_data['token'] = $token;

            $result = $this->api->update_rquest($user_data);
            if($result == 1){

              $response_code = '1';
              $response_message = $this->language_content['lg11_request_details'];

              $to_user_id = 0;
              $title = $user_data['title'];
              $user_id = $this->api->get_user_id_using_token($user_data['token']);
              $name  = $this->api->username($user_id);
              $username = $name['username'];
              $message = $this->language_content['lg11_update_request_'].' '.$username;

            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function request_details_post()
    {

      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }
      $user_data['token'] = $token;

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['request_id'])){

            $user_data['token'] = $token;
            $result = $this->api->get_request_details($user_data);

            if(!empty($result)){

              $response_code = '1';
              $response_message = $this->language_content['lg11_service_details'];
              $data['service_details'] = $result;
            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }
          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_request_id_is_m'];
          }

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);

    }

    public function subscription_success_post()
    {

      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['subscription_id']) && !empty($user_data['transaction_id']) ){
            $user_data['token'] = $token;
            $result = $this->api->subscription_success($user_data);

            if(!empty($result)){

              $response_code = '1';
              $response_message = $this->language_content['lg11_new_subscriber_'];
              $data = $result;
            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);

    }

    public function profile_get()
    {

      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){


          $user_data['token'] = $token;
          $result = $this->api->profile($user_data);


          if(!empty($result)){

            $response_code = '1';
            $response_message = $this->language_content['lg11_profile'];
            $data['profile_details'] = $result;
          }else{
            $response_code = '-1';
            $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
          }




        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);

    }

    public function profile_image_upload_post()
   {
    $data = array();
    $response_code = '-1';
    $response_message = $this->language_content['lg11_validation_erro'];
    $user_data = array();
    $user_data =  getallheaders(); // Get Header Data
    $params = $this->post(); 
    $user_data = array_merge($user_data , $params);
    
    $token = (!empty($user_data['token']))?$user_data['token']:'';
    if(empty($token)){
      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
    }
    if(!empty($token)){

      $user_data['Token'] = $token;

      $user_id = $this->api->get_user_id_using_token($token);

      if($user_id > 0){


        if(!empty($_FILES['ic_card_image'])){

          $user_data['user_id'] = $user_id;

          $config['upload_path']          = FCPATH.'uploads/ic_card_image';
          $config['allowed_types']        = 'jpeg|jpg|png|JPEG|JPG|PNG';
          $new_name = time().'ic_card_image';
          $config['file_name'] = $new_name;
          $this->load->library('upload', $config);
          $this->upload->initialize($config);
          $ic_card_image = '';
          $profile_img = '';

          if ( ! $this->upload->do_upload('ic_card_image')){
            $upload_data = $this->upload->display_errors();
            $user_data['ic_card_image'] = '';
            $ic_card_image = $upload_data;
          }else{
            $upload_data =  $this->upload->data();
            $user_data['ic_card_image'] = 'uploads/ic_card_image/'.$upload_data['file_name'];
          }

          if(!empty($_FILES['profile_img'])){

            $config['upload_path']          = FCPATH.'uploads/profile_img';
            $config['allowed_types']        = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
            $new_name = time().'user';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);


            if ( ! $this->upload->do_upload('profile_img')){
              $upload_data = $this->upload->display_errors();
              $user_data['profile_img'] = '';
              $profile_img = $upload_data;
            }else{
              $upload_data =  $this->upload->data();
              $user_data['profile_img'] = 'uploads/profile_img/'.$upload_data['file_name'];
              $this->image_resize(200,200,$user_data['profile_img'],$upload_data['file_name']);
            }
          }else{
            $user_data['profile_img'] = '';
          }
          if($ic_card_image ==''){
            $result = $this->api->profile_image_upload($user_data);
            if(!empty($result)){
              $data = $result;
              $response_code = '1';
              $response_message = $this->language_content['lg11_profile_image_a'];
            }

          }else{

            $response_code = '-1';
            if(!empty($profile_img)){
              $response_message .= $this->language_content['lg11_profile_image_'];
              $response_message = $profile_img;
            }
            if(!empty($ic_card_image)){
              $response_message .= $this->language_content['lg11_ic_card_image_'];
              $response_message .= $ic_card_image;
            }
          }
        }else{
          $response_code = '-1';
          $response_message = $this->language_content['lg11_required_images'];
        }

      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_invalid_user_to'];
      }
    }else{
      $response_code = '-1';
      $response_message = $this->language_content['lg11_user_token_is_m'];
    }

    $result = $this->data_format($response_code,$response_message,$data);
    $this->response($result, REST_Controller::HTTP_OK);

  }

public function signup_post() {
    $user_data = array();
    $get_data = getallheaders();
    $params = $this->post();
    $user_data = array_merge($user_data , $params);

    $is_available = $this->api->check_user($user_data);
    $is_available_mobile = $this->api->check_mobile_no($user_data);
    if($is_available == 0 ) {
        if($is_available_mobile== 0) {
            $config['upload_path']          = FCPATH.'uploads/ic_card_image';
            $config['allowed_types']        = 'jpeg|jpg|png|JPEG|JPG|PNG';
            $new_name = time().'ic_card_image';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $ic_card_image = '';
            $profile_img = '';

            if ( ! $this->upload->do_upload('ic_card_image')){
              $upload_data = $this->upload->display_errors();
              $user_data['ic_card_image'] = '';
              $ic_card_image = $upload_data;
            }else{
              $upload_data =  $this->upload->data();
              $user_data['ic_card_image'] = 'uploads/ic_card_image/'.$upload_data['file_name'];
            }

            $config['upload_path']          = FCPATH.'uploads/profile_img';
            $config['allowed_types']        = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
            $new_name = time().'user';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);


            if ( ! $this->upload->do_upload('profile_img')){
              $upload_data = $this->upload->display_errors();
              $user_data['profile_img'] = '';
              $profile_img = $upload_data;
            }else{
              $upload_data =  $this->upload->data();
              $user_data['profile_img'] = 'uploads/profile_img/'.$upload_data['file_name'];
              $this->image_resize(200,200,$user_data['profile_img'],$upload_data['file_name']);
            }

            $data = array();
            $response_code = '-1';
            $response_message = $this->language_content['lg11_validation_erro'];

            if($user_data['Registerthrough'] == 1) {
                if(!empty($user_data['Username']) && !empty($user_data['Email']) && !empty($user_data['Password']) && !empty($user_data['Registerthrough']) && !empty($user_data['Mobileno'])){

                    $user_data = array_filter($user_data);

                        $user_data['Username'] = str_replace(' ','-',$user_data['Username']);
                    $result = $this->api->new_user($user_data);

                    
                    if($result == 1){

                      $response_code = '1';
                      $response_message = $this->language_content['lg11_new_user_detail'];
                    }else if($result == 2){
                      $response_code = '2';
                      $response_message = $this->language_content['lg11_this_user_alrea'];
                    }else{
                      $response_code = '-1';
                      $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
                    }
                } else {
                    $response_code = '-1';
                    $response_message = $this->language_content['lg11_required_input_'];
                }
            } else if($user_data['Registerthrough'] == 2 || $user_data['Registerthrough'] == 3) {
                if(!empty($user_data['Tokenid']) && !empty($user_data['Username']) && !empty($user_data['Registerthrough']) && !empty($user_data['Latitude']) && !empty($user_data['Longitude']) && !empty($user_data['Devicetype']) && !empty($user_data['Deviceid']) && !empty($user_data['Email'])) {

                  $result = $this->api->new_user($user_data);

                  if($result == 1){

                    $response_code = '1';
                    $response_message = $this->language_content['lg11_new_user_detail'];
                  }else if($result == 2){
                    $response_code = '-1';
                    $response_message = $this->language_content['lg11_this_user_alrea'];
                  }else{
                    $response_code = '-1';
                    $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
                  }

                }else{

                  $response_code = '-1';
                  $response_message = $this->language_content['lg11_required_input_'];
                }
            } else {
                if(!empty($user_data['Tokenid']) && !empty($user_data['Username']) && !empty($user_data['Registerthrough']) && !empty($user_data['Latitude']) && !empty($user_data['Longitude']) && !empty($user_data['Devicetype']) && !empty($user_data['Deviceid'])) {

                  $result = $this->api->new_user($user_data);

                  if($result == 1){

                    $response_code = '1';
                    $response_message = $this->language_content['lg11_new_user_detail'];
                  }else if($result == 2){
                    $response_code = '-1';
                    $response_message = $this->language_content['lg11_this_user_alrea'];
                  }else{
                    $response_code = '-1';
                    $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
                  }

                }else{

                  $response_code = '-1';
                  $response_message = $this->language_content['lg11_required_input_'];
                }
            }
        } else {
          $response_code = '-122';
          $response_message = $this->language_content['lg1_mobile_no_alrea'];
        }
    } else {
        $response_code = '-1';
        $response_message = $this->language_content['lg11_this_user_alrea'];
    }
    $result = $this->data_format($response_code,$response_message,$data);

    $this->response($result, REST_Controller::HTTP_OK);
}

public function request_accept_post()
{

  $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['request_id']) ){
            $user_data['token'] = $token;
            $result = $this->api->request_accept($user_data);
            if($result == 1){
              /* Notification starts */
              $request_details = $this->api->get_request_id_details($user_data['request_id']);
              $to_user_id = $request_details['requester_id'];
              $title = $request_details['title'];
              $user_id = $this->api->get_user_id_using_token($token);
              $name  = $this->api->username($user_id);
              $username = $name['username'];
              $message = $username.' accepted your request';
              $notification_type = 'Request Accept';
              $this->notifications($notification_type,$title,$message,$to_user_id,$user_id);
              /* Notification ends */

              $response_code = '1';
              $response_message = $this->language_content['lg11_new_request_has'];

            }elseif($result == 2){

              $response_code = '-1';
              $response_message = $this->language_content['lg11_not_yet_subscri'];
            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);

    }

    public function request_complete_post()
    {

      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['request_id']) ){
            $user_data['token'] = $token;
            $result = $this->api->request_complete($user_data);
            if($result == 1){
              $request_details = $this->api->get_history_details($user_data['request_id']);
              /* Notification starts */
              $to_user_id = $request_details['acceptor_id'];
              $title = $request_details['title'];
              $user_id = $this->api->get_user_id_using_token($token);
              $name  = $this->api->username($user_id);
              $username = $name['username'];
              $notify_message = $username.' completed your accepted request';
              $notification_type = 'Complete Request Accept';
              $this->notifications($notification_type,$title,$notify_message,$to_user_id,$user_id);
              /* Notification ends */

              $response_code = '1';
              $response_message = $this->language_content['lg11_the_request_has'];
          }else{
            $response_code = '-1';
            $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
          }

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_required_input_'];
        }


      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_invalid_user_to'];
      }

    }else{

      $response_code = '-1';
      $response_message = $this->language_content['lg11_user_token_is_m'];
    }

    $result = $this->data_format($response_code,$response_message,$data);

    $this->response($result, REST_Controller::HTTP_OK);

  }


  public function request_list_post()
  {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);
        
      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){
            if($token==$this->api_token){ $result=1; }
            else{ $result = $this->api->token_is_valid($token); }

            if($result){
               if(!empty($user_data) && !empty($user_data['Latitude']) && !empty($user_data['Longitude'])){
                $user_data['Token'] = $token;
                $user_data['Page']  = (!empty($user_data['Page']))?$user_data['Page']:1;
                $result = $this->api->request_list($user_data);
        
                if(!empty($result['total_pages'])){
                 $response_code = '1';
                 $response_message = $this->language_content['lg11_request_listed_'];
                 
                 if($result['total_pages']< $result['current_page']){
                  $response_code = '-1';
                  $response_message = $this->language_content['lg11_invalid_page'];
                }
                $data = $result;
              }else{
             $response_code = '0';
             $response_message = $this->language_content['lg11_no_records_foun'];
         }
     }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_required_input_'];
    }
}else{
   $response_code = '-1';
   $response_message = $this->language_content['lg11_invalid_user_to'];
  }
}else{
  $response_code = '-1';
  $response_message = $this->language_content['lg11_user_token_is_m'];
}
$result = $this->data_format($response_code,$response_message,$data);
$this->response($result, REST_Controller::HTTP_OK);
}


public function history_list_post()
{
  $user_data = array();
  $user_data =  getallheaders(); // Get Header Data
  $user_post_data = $this->post();
  $user_data = array_merge($user_data,$user_post_data);

  $token = (!empty($user_data['token']))?$user_data['token']:'';
  if(empty($token)){
    $token = (!empty($user_data['Token']))?$user_data['Token']:'';
  }

  $data = array();
  $response_code = '-1';
  $response_message = $this->language_content['lg11_validation_erro'];

  if(!empty($token)){
    $result = $this->api->token_is_valid($token);

    if($result){
      if(!empty($user_data['Request']) && !empty($user_data['Status'])){
    //   1 -> Requests created by logged in user
    //   2 -> Requests accepted by logged in user
    //   3 -> Both
       $status = $user_data['Status'];
       $user_data['Token'] = $token;
       $user_data['Page']  = (!empty($user_data['Page']))?$user_data['Page']:1;

       $result = $this->api->history_list($user_data);
           if(!empty($result['total_pages'])){

        $response_code = '1';

        if($status == 1){ $msg = 'Pending '; }
            elseif($status == 2){ $msg = 'Complete '; }

        $response_message = $msg.$this->language_content['lg11_history_listed_'];

        if($result['total_pages'] < $result['current_page']){
          $response_code = '-1';
            $response_message = $this->language_content['lg11_invalid_page'];
          }
          $data = $result;
        }else{
          $response_code = '0';
          $response_message = $this->language_content['lg11_no_records_foun'];
        }
      }else{
            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }
        }else{
          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }
      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }
      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function my_request_list_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data)){

            $user_data['token'] = $token;
            $user_data['page']  = (!empty($user_data['page']))?$user_data['page']:1;

            $result = $this->api->my_request_list($user_data);
                
            if(!empty($result['total_pages'])){
                   

              $response_code = '1';

              $response_message = $this->language_content['lg11_request_listed_'];

              if($result['total_pages']< $result['current_page']){
                $response_code = '-1';
                $response_message = $this->language_content['lg11_invalid_page'];
              }
              $data = $result;
                    
                    

            }else{

              $response_code = '0';
              $response_message = $this->language_content['lg11_no_records_foun'];

            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }    
       $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function search_request_list_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);
    
      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }
        
      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);
      
        if($result){
          if(!empty($user_data['Latitude']) && !empty($user_data['Longitude']) && (!empty($user_data['Searchtitle']) || !empty($user_data['Requestdate']) || !empty($user_data['Requesttime']) || !empty($user_data['Minprice']) || !empty($user_data['Maxprice']) || !empty($user_data['Location'])))
          {
            $user_data['Token'] = $token;
            $user_data['Page']  = (!empty($user_data['Page']))?$user_data['Page']:1;
            $result = $this->api->search_request_list($user_data);
  
            if(!empty($result)){
              $response_code = '1';
              $response_message = $this->language_content['lg11_request_listed_'];

              if($result['total_pages']< $result['current_page']){
                $response_code = '-1';
                $response_message = $this->language_content['lg11_invalid_page'];
              }
              $data = $result;

            }else{

              $response_code = '0';
              $response_message = $this->language_content['lg11_no_records_foun'];

            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }
      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function data_format($response_code,$response_message,$data)
    {
    $final_result = array();
    $response = array();
    $response['response_code']    = $response_code;
    $response['response_message'] = $response_message;

    if(!empty($data)){

      $data = $data;

    }else{

      $data = (object)$data;
    }

    $final_result['response'] = $response;
    $final_result['data'] = $data;

    return $final_result;
  }
  public function update_profile_post()
  {
    $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }
      $user_data['Token'] = $token;
      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          $user_post_data['latitude'] = $user_data['Latitude'];
          $user_post_data['longitude'] = $user_data['Longitude'];
          $user_post_data['mobile_no'] = $user_data['Mobileno'];
                $user_post_data['currency_code'] = $user_data['Currencycode'];

                $data = array();
                $final_result = array();
                $ic_card_image = '';
                $profile_img = '';

                $user_id = $this->api->get_user_id_using_token($token);
                if(!empty($user_id) && !empty($user_post_data['mobile_no'])){

                    if(!empty($_FILES['profile_img']) && !empty($_FILES['ic_card_image'])){

                       $profile_details = $this->api->profile($user_data);

                       if(!empty($profile_details['profile_img'])){
                          $del_prof_img = FCPATH.$profile_details['profile_img'];
                          if(file_exists($del_prof_img)){
                             unlink($del_prof_img);
                         }
                     }
                     if(!empty($profile_details['ic_card_image']))  {
                      $del_ic_img = FCPATH.$profile_details['ic_card_image'];
                      if(file_exists($del_ic_img)){
                         unlink($del_ic_img);
                     }
                 }

                 $config['upload_path']          = FCPATH.'uploads/ic_card_image';
                 $config['allowed_types']        = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
                 $new_name = time().'ic_card_image';
                 $config['file_name'] = $new_name;
                 $this->load->library('upload', $config);
                 $this->upload->initialize($config);



                 if ( ! $this->upload->do_upload('ic_card_image')){
                  $upload_data = $this->upload->display_errors();
                  $user_data['ic_card_image'] = '';
                  $ic_card_image = $upload_data;
              }else{
                  $upload_data =  $this->upload->data();
                  $user_data['ic_card_image'] = 'uploads/ic_card_image/'.$upload_data['file_name'];
              }

              $config['upload_path']          = FCPATH.'uploads/profile_img';
              $config['allowed_types']        = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
              $new_name = time().'user';
              $config['file_name'] = $new_name;
              $this->load->library('upload', $config);
              $this->upload->initialize($config);


              if ( ! $this->upload->do_upload('profile_img')){
                  $upload_data = $this->upload->display_errors();
                  $user_data['profile_img'] = '';
                  $profile_img = $upload_data;
              }else{
                  $upload_data =  $this->upload->data();
                  $user_data['profile_img'] = 'uploads/profile_img/'.$upload_data['file_name'];
                  $this->image_resize(200,200,$user_data['profile_img'],$upload_data['file_name']);
              }

              if($profile_img =='' && $ic_card_image ==''){
                  $user_post_data['profile_img'] = $user_data['Profileimg'];
                  $user_post_data['ic_card_image'] = $user_data['Iccardimage'];
                  $result = $this->db->update('users', $user_post_data, array('user_id'=>$user_id));

                  if($result == 1){
                     $data_result = $this->api->profile($user_data);
                     $final_result['mobile_no'] = $data_result['mobile_no'];
                     $final_result['currency_code'] = $data_result['currency_code'];
                     $final_result['profile_img'] = $data_result['profile_img'];
                     $final_result['ic_card_image'] = $data_result['ic_card_image'];
                     $response_code = '1';
                     $response_message = $this->language_content['lg11_your_profile_up'];
                     $data['profile_details'] = $final_result;
                 }else{
                     $response_code = '-1';
                     $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
                 }
             }else{

              $response_code = '-1';
              if(!empty($profile_img)){
                 $response_message .= $this->language_content['lg11_profile_image_'];
                 $response_message = $profile_img;
             }
             if(!empty($ic_card_image)){
                 $response_message .= $this->language_content['lg11_ic_card_image_'];
                 $response_message .= $ic_card_image;
             }
         }

     }
     elseif(!empty($_FILES['profile_img']) || !empty($_FILES['ic_card_image'])){
       $profile_details = $this->api->profile($user_data);
       if(!empty($_FILES['profile_img'])){
          $del_prof_img = FCPATH.$profile_details['profile_img'];
          if(file_exists($del_prof_img)){
             unlink($del_prof_img);
         }

         $config['upload_path']          = FCPATH.'uploads/profile_img';
         $config['allowed_types']        = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
         $new_name = time().'user';
         $config['file_name'] = $new_name;
         $this->load->library('upload', $config);
         $this->upload->initialize($config);


         if ( ! $this->upload->do_upload('profile_img')){
             $upload_data = $this->upload->display_errors();
             $user_data['profile_img'] = '';
             $profile_img = $upload_data;
         }else{
             $upload_data =  $this->upload->data();
             $user_data['profile_img'] = 'uploads/profile_img/'.$upload_data['file_name'];
             $this->image_resize(200,200,$user_data['profile_img'],$upload_data['file_name']);
         }

         if($profile_img ==''){
             $user_post_data['profile_img'] = $user_data['Profileimg'];
             $result = $this->db->update('users', $user_post_data, array('user_id'=>$user_id));

             if($result == 1){
                $data_result = $this->api->profile($user_data);
                $final_result['mobile_no'] = $data_result['mobile_no'];
                $final_result['currency_code'] = $data_result['currency_code'];
                $final_result['profile_img'] = $data_result['profile_img'];
                $final_result['ic_card_image'] = $data_result['ic_card_image'];
                $response_code = '1';
                $response_message = $this->language_content['lg11_your_profile_up'];
                $data['profile_details'] = $final_result;
            }else{
                $response_code = '-1';
                $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }
        }else{

         $response_code = '-1';
         if(!empty($profile_img)){
            $response_message .= $this->language_content['lg11_profile_image_'];
            $response_message = $profile_img;
        }
    }

}

elseif(!empty($_FILES['ic_card_image'])){
  $del_ic_img = FCPATH.$profile_details['ic_card_image'];
  if(file_exists($del_ic_img)){
     unlink($del_ic_img);
 }

 $config['upload_path']          = FCPATH.'uploads/ic_card_image';
 $config['allowed_types']        = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
 $new_name = time().'ic_card_image';
 $config['file_name'] = $new_name;
 $this->load->library('upload', $config);
 $this->upload->initialize($config);



 if ( ! $this->upload->do_upload('ic_card_image')){
     $upload_data = $this->upload->display_errors();
     $user_data['ic_card_image'] = '';
     $ic_card_image = $upload_data;
 }else{
     $upload_data =  $this->upload->data();
     $user_data['ic_card_image'] = 'uploads/ic_card_image/'.$upload_data['file_name'];
 }

 if($ic_card_image ==''){
     $user_post_data['ic_card_image'] = $user_data['ic_card_image'];
     $result = $this->db->update('users', $user_post_data, array('user_id'=>$user_id));

     if($result == 1){
        $data_result = $this->api->profile($user_data);
        $final_result['mobile_no'] = $data_result['mobile_no'];
        $final_result['currency_code'] = $data_result['currency_code'];
        $final_result['profile_img'] = $data_result['profile_img'];
        $final_result['ic_card_image'] = $data_result['ic_card_image'];
        $response_code = '1';
        $response_message = $this->language_content['lg11_your_profile_up'];
        $data['profile_details'] = $final_result;
    }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
    }
}else{

 $response_code = '-1';
 if(!empty($ic_card_image)){
    $response_message .= $this->language_content['lg11_ic_card_image_'];
    $response_message .= $ic_card_image;
}
}

}

}
else {
   unset($user_post_data['Token']);
   unset($user_post_data['Language']);
   /* Done by saravana fixing api error no 35*/
   if($_FILES['Iccardimage']['name']){
     $config['upload_path']          = FCPATH.'uploads/ic_card_image';
     $config['allowed_types']        = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
     $new_name = time().'ic_card_image';
     $config['file_name'] = $new_name;
     $this->load->library('upload', $config);
     $this->upload->initialize($config);



     if ( ! $this->upload->do_upload('Iccardimage')){
         $upload_data = $this->upload->display_errors();
         $user_data['ic_card_image'] = '';
         $ic_card_image = $upload_data;
     }else{
         $upload_data =  $this->upload->data();
         $user_post_data['ic_card_image'] = 'uploads/ic_card_image/'.$upload_data['file_name'];
     }
   }
   if($_FILES['Profileimg']['name']){
   $config['upload_path']          = FCPATH.'uploads/profile_img';
         $config['allowed_types']        = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
         $new_name = time().'user';
         $config['file_name'] = $new_name;
         $this->load->library('upload', $config);
         $this->upload->initialize($config);


         if ( ! $this->upload->do_upload('Profileimg')){
             $upload_data = $this->upload->display_errors();
             $user_data['profile_img'] = '';
             $profile_img = $upload_data;
         }else{
             $upload_data =  $this->upload->data();
             $user_post_data['profile_img'] = 'uploads/profile_img/'.$upload_data['file_name'];
         }
       }
   $user_post_data['full_name'] = $user_post_data['Fullname'];    unset($user_post_data['Fullname']);
   $user_post_data['mobile_no'] = $user_post_data['Mobileno'];    unset($user_post_data['Mobileno']);
   $user_post_data['currency_code'] = $user_post_data['Currencycode'];    unset($user_post_data['Currencycode']);
   $result = $this->db->update('users', $user_post_data, array('user_id'=>$user_id));

   if($result == 1){
      $data_result = $this->api->profile($user_data);
      $final_result['mobile_no'] = $data_result['mobile_no'];
      $final_result['currency_code'] = $data_result['currency_code'];
      $final_result['profile_img'] = $data_result['profile_img'];
      $final_result['ic_card_image'] = $data_result['ic_card_image'];
      $response_code = '1';
      $response_message = $this->language_content['lg11_your_profile_up'];
      $data['profile_details'] = $final_result;
  }else{
      $response_code = '-1';
      $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
  }
}


}else{

    $response_code = '-1';
    $response_message = $this->language_content['lg11_required_input_'];
}
}else{

 $response_code = '-1';
 $response_message = $this->language_content['lg11_invalid_user_to'];
}

}else{

  $response_code = '-1';
  $response_message = $this->language_content['lg11_user_token_is_m'];
}




$result = $this->data_format($response_code,$response_message,$data);

$this->response($result, REST_Controller::HTTP_OK);

}

public function colour_settings_get()
{
   $user_data = array();
      $user_data =  getallheaders(); // Get Header Data

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      $result = $this->api->colour_settings();
      $new_details = array();

      if(!empty($result)){

        $response_code = '1';
        $response_message = $this->language_content['lg11_colours_listed_'];

        $new_details['morning']    = $result['morning'];
        $new_details['afternoon'] = $result['afternoon'];
        $new_details['evening']  = $result['evening'];
        $new_details['night'] = $result['night'];
        $data = $new_details;
      }else{

        $response_code = '0';
        $response_message = $this->language_content['lg11_no_records_foun'];
      }



      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function notifications($notification_type,$title,$message,$to_user_id = 0,$login_id)
    {
      $ios_target = array();
      $android_target = array();
      $body =array(
        'notification_type'=>$notification_type,
        'title'=>   $title,
        'message'=> $message
      );
      $target = $this->api->get_deviceids($to_user_id,$login_id);
      $deviceid = 0;

      $ios_target = $target['ios'];
      if(count($ios_target) > 0){
        $ios_target = array_map('current', $ios_target);
        $deviceid =1;
      }
      $android_target = $target['android'];
      if(count($android_target) > 0){
        $android_target = array_map('current', $android_target);
        $deviceid = 1;
      }

      $data['body'] = $body;
    // Android Notifications
      if(count($android_target) > 0){
        $android_result_array = sendFCMMessage($data,$android_target);
      }
    // iOS Notifications
      if(count($ios_target) > 0){
        $ios_result_array = sendFCMiOSMessage($data,$ios_target);
      }
    }


    public function push_notifications_post()
    {
      $response_code = '1';
      $response_message = $this->language_content['lg11_notification_se'];

      if($this->input->post()){

        $ios_target = array();
        $android_target = array();

        $notification_type = $this->input->post('notification_type');
        $title = $this->input->post('title');
        $message = $this->input->post('message');
        $body =array(
          'notification_type'=>$notification_type,
          'title'=>   $title,
          'message'=> $message
        );

        $to_user_id = 0;
        $login_id = 0;
        $target = $this->api->get_deviceids($to_user_id,$login_id);
        $deviceid = 0;

        $ios_target = $target['ios'];
        if(count($ios_target) > 0){
          $ios_target = array_map('current', $ios_target);
          $deviceid =1;
        }
        $android_target = $target['android'];
        if(count($android_target) > 0){
          $android_target = array_map('current', $android_target);
          $deviceid = 1;
        }


        $data['body'] = $body;

    // Android Notifications
        if(count($android_target) > 0){
          $android_result_array = sendFCMMessage($data,$android_target);
        }

    // iOS Notifications
        if(count($ios_target) > 0){
          $ios_result_array = sendFCMiOSMessage($data,$ios_target);
        }

        $result_array = array();



      }

      $result = $this->data_format($response_code,$response_message,$result_array);
      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function push_notifications_ios_post()
    {
      $response_code = '1';
      $response_message = $this->language_content['lg11_notification_se'];
      $params = $this->post();
      $params = array_filter($params);

      if(count($params) > 0){
        $body =array(
          'notification_type'=>$params['notification_type'],
          'title'=>   $params['title'],
          'message'=> $params['message']
        );


        $data['body'] = $body;
    // iOS Notifications
    $ios_target[] = 'esTtw5zmfdg:APA91bFss7jNNhBOLq1k_pnhWMlDDJ7ATIXZWgaW4MiVkJdLEY23xT_DKA0yFqTiZvYg3eMkEdBMlTgkfosARvNd24Acc_1fN-6oN8nqqDj5GY6nkG9yDrep_2eAPsmVHEsQTPzJa99-';
    if(count($ios_target) > 0){
      $ios_result_array = sendFCMiOSMessage($data,$ios_target);
    }
    $result_array = array();



  }

  $result = $this->data_format($response_code,$response_message,$result_array);
}


public function chat_history_post()
{
    $data = array();
    $response_code = '-1';
    $response_message = $this->language_content['lg11_validation_erro'];
    $user_data = array();
    $user_data =  getallheaders(); // Get Header Data
    $params =  $this->post();    
  $user_data = array_merge($user_data, $params);

  $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      if(!empty($user_data['page'])){

        $user_data['page'] =$user_data['page'];
        $user_data['page'] = 1;
        $page  = (!empty($user_data['page']))?$user_data['page']:1;

        $result = $this->api->chat_history($token,$page);

        if(!empty($result)){
          $response_code = '1';
          $response_message = $this->language_content['lg11_chat_history_li'];
          $data = $result;
        }
      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_required_input_'];
      }

      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
    }


    public function chat_history_count_get()
    {


      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $provider_chat_count = $this->api->chat_history_count($token);
      $requester_chat_count = $this->api->chat_history_requester_count($token);
      $requester_pending_list_count = $this->api->requester_pending_list_count($token);

      $response_code = '1';
      $response_message = $this->language_content['lg11_chat_history_li'];
      $data['provider_chat_count'] = $provider_chat_count;
      $data['requester_chat_count'] = $requester_chat_count;
      $data['requester_count'] = $requester_pending_list_count['request_list'];
      $data['provider_count'] = $requester_pending_list_count['provider_list'];
      
      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function chat_post()
    {
      $data = array();
      $user_data = array();
      $history = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];
      $params = $this->post();
      $user_data =  getallheaders(); // Get Header Data
      $user_data = array_merge($user_data,$params);

      if(!empty($user_data['To']) && !empty($user_data['Content']))
      {
      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $array = array();
      date_default_timezone_set('UTC');
      $date_time = date('Y-m-d H:i');
      $array['chat_to'] = $user_data['To'];
      $array['content'] = $user_data['Content'];
      $array['chat_utc_time'] = $date_time;
      $array['token'] = $token;

      $history = $this->api->chat_conversation($array);
      $utctime = $history['chat_utc_time'];
      $time = utc_date_conversion($history['chat_utc_time']);
      $time = date('h:i A',strtotime($time));
      $history['date'] = date('Y-m-d',strtotime($time));
      $history['time'] = $time;

      $to_user_id         = $history['chat_to'];
      $from_user_id       = $history['chat_from'];
      $message              = $history['content'];

      $name  = $this->api->username($from_user_id);
      $title = $name['username'];

      $name1  = $this->api->username($to_user_id);
      $to_username = $name1['username'];
      $body =array(
        'notification_type'=>'chat',
        'title'=>   $title,
        'message'=> $message,
        'from_username'=> $title,
        'to_username'=> $to_username,
        'from_userid'=> $from_user_id,
        'to_userid'=> $to_user_id,
        'date'=> $history['date'],
        'time'=> $time,
        'utctime'=> $utctime
      );
      
      $login_id = $from_user_id;
      $target = $this->api->get_deviceids($to_user_id,$login_id);
      $deviceid = 0;

      $ios_target = $target['ios'];
      if(count($ios_target) > 0){
        $ios_target = array_map('current', $ios_target);
        $deviceid =1;
      }
      $android_target = $target['android'];
      if(count($android_target) > 0){
        $android_target = array_map('current', $android_target);
        $deviceid = 1;
      }

      $notificationdata =array();
      $notificationdata['body'] = $body;
    // Android Notifications
      $error = 0 ;
      $error1 = 0 ;
      if(count($android_target) > 0){
        $android_result_array = sendFCMMessage($notificationdata,$android_target);
      }else{
        $error = 1;
      }
    // iOS Notifications
      if(count($ios_target) > 0){
        $ios_result_array = sendFCMiOSMessage($notificationdata,$ios_target);
      }else{
        $error1 = 1;
      }
      if(!empty($history)){
        $response_code = '1';
        $response_message = $this->language_content['lg11_success'];
      }
    }else{
      $response_code = '-1';
      $response_message = $this->language_content['lg11_required_input_'];
    }
    $result = $this->data_format($response_code,$response_message,$history);
    $this->response($result, REST_Controller::HTTP_OK);
}


public function chat_details_post()
{
  $data = array();
  $response_code = '-1';
  $response_message = $this->language_content['lg11_validation_erro'];
  $params =  $this->post();
  $user_data = array();
  $user_data =  getallheaders(); // Get Header Data
  $user_data = array_merge($user_data,$params);


  if(!empty($params['chat_id']) && !empty($params['page']))
  {

    $user_data = array();
        $user_data =  getallheaders(); // Get Header Data
        $token = (!empty($user_data['token']))?$user_data['token']:'';
        if(empty($token)){
          $token = (!empty($user_data['Token']))?$user_data['Token']:'';
        }

        $user_data['token'] = $token;

        $id = $params['chat_id'];
        $page = $params['page'];
        $user_id = $this->api->get_user_id_using_token($user_data['token']);
        $history = $this->api->conversations($id,$user_id,$page);

        if(!empty($history)){
          $response_code = '1';
          $response_message = $this->language_content['lg11_success'];
          $data = $history;
        }

      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_required_input_'];
      }

      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
  }

  public function message_status_post()
  {
    $data = array();
    $response_code = '-1';
    $response_message = $this->language_content['lg11_validation_erro'];
    $params =  $this->post();

    if(!empty($params['chat_id']) && !empty($params['type']))
    {

      $user_data = array();
          $user_data =  getallheaders(); // Get Header Data
          $token = (!empty($user_data['token']))?$user_data['token']:'';
          if(empty($token)){
            $token = (!empty($user_data['Token']))?$user_data['Token']:'';
          }

          $user_data['token'] = $token;

          $id = $params['chat_id'];
          $user_id = $this->api->get_user_id_using_token($user_data['token']);
          
          if($params['type'] == 0){
            $table_name = 'chats_requester';
          }else {
            $table_name = 'chats';
          }
          $message_status = $this->api->message_status($id,$user_id,$table_name);

          if(!empty($message_status)){
            $response_code = '1';
            $response_message = $this->language_content['lg11_success'];
            $data = $history;
          }

        }else{
          $response_code = '-1';
          $response_message = $this->language_content['lg11_required_input_'];
        }

        $result = $this->data_format($response_code,$response_message,$data);
        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function chat_history_requester_post()
    {


      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $params =  $this->post();
      $user_data = array_merge($user_data, $params);
    
      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }
    
      if(!empty($user_data['page'])){
        $user_data['page'] = $user_data['page'];
        $user_data['page'] = 1;
        $page  = (!empty($user_data['page']))?$user_data['page']:1;

        $result = $this->api->chat_history_requester($token,$page);

        if(!empty($result)){
          $response_code = '1';
          $response_message = $this->language_content['lg11_chat_history_li'];
          $data = $result;
        }
      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_required_input_'];
      }

      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
    }
    
    public function chat_requester_post()
    {
      $data = array();
      $history = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      $params = $this->post();

      if(!empty($params['to']) && !empty($params['content']))
      {
        $user_data = array();
        $user_data =  getallheaders(); // Get Header Data
        $token = (!empty($user_data['token']))?$user_data['token']:'';
        if(empty($token)){
          $token = (!empty($user_data['Token']))?$user_data['Token']:'';
        }

        $array = array();
        date_default_timezone_set('UTC');
        $date_time = date('Y-m-d H:i');
        $array['chat_to'] = $params['to'];
        $array['content'] = $params['content'];
        $array['chat_utc_time'] = $date_time;
        $array['token'] = $token;


        $history = $this->api->chat_conversation_requester($array);
        $utctime = $history['chat_utc_time'];
        $time = utc_date_conversion($history['chat_utc_time']);
        $time = date('h:i A',strtotime($time));
        $history['date'] = date('Y-m-d',strtotime($time));
        $history['time'] = $time;

        $to_user_id         = $history['chat_to'];
        $from_user_id       = $history['chat_from'];
        $message              = $history['content'];

        $name  = $this->api->username($from_user_id);
        $title = $name['username'];

        $name1  = $this->api->username($to_user_id);
        $to_username = $name1['username'];
        $body =array(
          'notification_type'=>'chat',
          'title'=>   $title,
          'message'=> $message,
          'from_username'=> $title,
          'to_username'=> $to_username,
          'from_userid'=> $from_user_id,
          'to_userid'=> $to_user_id,
          'date'=> $history['date'],
          'time'=> $time,
          'utctime'=> $utctime
        );
        
        $login_id = $from_user_id;
        $target = $this->api->get_deviceids($to_user_id,$login_id);
        $deviceid = 0;

        $ios_target = $target['ios'];
        if(count($ios_target) > 0){
          $ios_target = array_map('current', $ios_target);
          $deviceid =1;
        }
        $android_target = $target['android'];
        if(count($android_target) > 0){
          $android_target = array_map('current', $android_target);
          $deviceid = 1;
        }

        $notificationdata =array();
        $notificationdata['body'] = $body;


      // Android Notifications
        $error = 0 ;
        $error1 = 0 ;
        if(count($android_target) > 0){
          $android_result_array = sendFCMMessage($notificationdata,$android_target);
        }else{
          $error = 1;
        }
      // iOS Notifications
        if(count($ios_target) > 0){
          $ios_result_array = sendFCMiOSMessage($notificationdata,$ios_target);
        }else{
          $error1 = 1;
        }

        if(!empty($history)){
          $response_code = '1';
          $response_message = $this->language_content['lg11_success'];

        }

      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_required_input_'];
      }

      $result = $this->data_format($response_code,$response_message,$history);
      $this->response($result, REST_Controller::HTTP_OK);
  }

  public function chat_details_requester_post()
  {
    $data = array();
    $response_code = '-1';
    $response_message = $this->language_content['lg11_validation_erro'];
    $params =  $this->post();

    if(!empty($params['chat_id']) && !empty($params['page']))
    {

      $user_data = array();
        $user_data =  getallheaders(); // Get Header Data
        $token = (!empty($user_data['token']))?$user_data['token']:'';
        if(empty($token)){
          $token = (!empty($user_data['Token']))?$user_data['Token']:'';
        }

        $user_data['token'] = $token;

        $id = $params['chat_id'];
        $page = $params['page'];
        $user_id = $this->api->get_user_id_using_token($user_data['token']);
        $history = $this->api->conversations_requester($id,$user_id,$page);

        if(!empty($history)){
          $response_code = '1';
          $response_message = $this->language_content['lg11_success'];
          $data = $history;
        }

      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_required_input_'];
      }

      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
  }

  public function subscription_payment_post()
  {
    $data = array();
    $response_code = '-1';
    $response_message = $this->language_content['lg11_validation_erro'];
    $user_data = getallheaders();
    $params =  $this->post();
    $params = array_merge($user_data , $params);
  
    if(!empty($params['amount']) && !empty($params['tokenid']) && !empty($params['description']) && $params['amount'] > 0 && !empty($params['type'])){

	    if(!empty($params['type']) && $params['type'] == 'stripe') {
	    
	      $this->load->library('stripe');
	      $charges_array = array();
	      $amount = $params['amount'];
	      $amount = ($amount *100);
	      $charges_array['amount']       = $amount;
	      $charges_array['currency']     = 'MYR';
	      $charges_array['description']  = $params['description'];
	      $charges_array['source']       = 'tok_visa';

	      $result = $this->stripe->stripe_charges($charges_array);
	  
	      $result = json_decode($result,true);
	      if(empty($result['error'])){
        	$data['transaction_id'] = $result['id'];
        	$data['payment_details'] = json_encode($result);

        	$response_code = '200';
        	$response_message = 'You have Subscribed Successfully';
      	}else{
        	$response_code = '-1';
        	$response_message = $this->language_content['lg11_stripe_payment_1'];
        	$data['error'] = $result['error'];
      	}
	    }  
	    else if(!empty($params['type']) && $params['type'] == 'razorpay') {
	    	$transaction_id = $params['tokenid'];
	    	$payment_details['payment_status'] = '1';

	    	if(!empty($transaction_id)){
        	$data['transaction_id'] = $transaction_id;
        	$data['payment_details'] = json_encode($payment_details);

        	$response_code = '200';
        	$response_message = 'You have Subscribed Successfully';
      	}else{
        	$response_code = '404';
        	$response_message = 'Sorry, Something went wrong';
        	$data['error'] = $result['error'];
      	}

	    }
     

      
    }else{
      $response_code = '-1';
      $response_message = $this->language_content['lg11_stripe_payment_'];
    }
    $result = $this->data_format($response_code,$response_message,$data);
    $this->response($result, REST_Controller::HTTP_OK);
  }



  public function ios_get($value='')
  {

    $connection = @fsockopen('gateway.sandbox.push.apple.com', '2195');

    if (is_resource($connection))
    {
      echo 'Open!';
      fclose($connection);
      return true;
    }
    else
    {
      echo 'Closed / not responding. :(';
      return false;
    }

    

  }

  public function push_notification_get($registrationIds=array(),$title='',$ano_user='')
  {



    $deviceToken = '17A9893E1F6D7BC9C068A91D5FECE0C6A0F692F0205C58F8BDEE87B62445E562';
    // Put your private key's passphrase here:
    $passphrase = '';
    $fl = file_get_contents(APPPATH.'controllers/api/pushcert.pem');
    // Put your alert message here:
    $message = 'Hello';

    ////////////////////////////////////////////////////////////////////////////////

    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', APPPATH.'controllers/api/pushcert.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    // Open a connection to the APNS server
    $fp = stream_socket_client(
      'ssl://gateway.sandbox.push.apple.com:2195', $err,
      $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
      exit("Failed to connect: $err $errstr" . PHP_EOL);

    echo 'Connected to APNS' . PHP_EOL;

    // Create the payload body
    $body['aps'] = array(
      'alert' => $message,
      'sound' => 'default'
    );

    // Encode the payload as JSON
    $payload = json_encode($body);

    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));

    if (!$result)
    {
      echo 'Message not delivered' . PHP_EOL;
    }
    else
    {
      echo 'Message successfully delivered' . PHP_EOL;

    }

    // Close the connection to the server
    fclose($fp);


    exit;
    $registrationIds = '6b6ac6b395ccbdb6b2a5b1b8771d3fe43ec53ff9abc4319307155e3341adc23e';

    $passphrase = '';

    $message = 'Your message';



    $ano_user = 1;
    $title = 'servrep';

    $deviceToken = array(trim($registrationIds));
    $passphrase = '';

  // Put your alert message here:
   $message = "Server App";  //print_r($deviceToken);

   $ctx = stream_context_create();
   stream_context_set_option($ctx, 'ssl', 'local_cert', APPPATH.'controllers/api/pushcert.pem');
   stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
  // Open a connection to the APNS server
   $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

   $body['aps'] = array(
    'alert' => $message,
    'sound' => 'default',
  //'category' =>$ano_user,
    'badge'=>1
   );

  // Encode the payload as JSON
   $payload = json_encode($body);
   for($i=0;$i<count($deviceToken);$i++)
   {
    $msg = chr(0) . pack('n', 32) . pack('H*', trim($deviceToken[$i])) . pack('n', strlen($payload)) .     $payload;
    $result = fwrite($fp, $msg, strlen($msg));
   }
   print_r($result);
   exit;
  //6cecb68733a19c83ac1b82b1d62a07e13ea2d0a51975d00007b12b2181d8c499, 09ABAC60-12F7-4A8D-BAA3-95192D176006
  


}

public function test_get()
{
  echo "<pre>";
  print_r($this->language_content);
  exit;

}

public function stripe_details_get()
{

      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          $publishable_key='';
          $secret_key='';
          $live_publishable_key='';
          $live_secret_key='';
          $stripe_option='';
          $paypal_option='';
          $paytab_option='';
          $razor_option='';

          $query = $this->db->query("select * from system_settings WHERE status = 1");
          $result = $query->result_array();
          $stripedetails=array();
          if(!empty($result))
          {
            foreach($result as $datas){

               
              if($datas['key'] == 'secret_key'){

                $secret_key = $datas['value'];

              }

              if($datas['key'] == 'publishable_key'){

                $publishable_key = $datas['value'];

              }

              if($datas['key'] == 'live_secret_key'){

                $live_secret_key = $datas['value'];

              }

              if($datas['key'] == 'live_publishable_key'){

                $live_publishable_key = $datas['value'];

              }

              if($datas['key'] == 'stripe_option'){

                $stripe_option = $datas['value'];
                

              } 

              if ($datas['key'] == 'paypal_option') {
                  $paypal_option = $datas['value'];
                 
              }
          
              if ($datas['key'] == 'paytabs_option') {
                  $paytab_option = $datas['value'];
              }
  
              if ($datas['key'] == 'razorpay_option') {
                  $razor_option = $datas['value'];
                  
              }

               if($datas['key'] == 'stripe_allow'){

                $stripe_allow = $datas['value'];
                $stripedetails['stripe_allow'] = $datas['value'];

              } 

              if ($datas['key'] == 'paypal_allow') {
                  $paypal_allow = $datas['value'];
                  $stripedetails['paypal_allow'] = $datas['value'];
              }
  
              if ($datas['key'] == 'razorpay_allow') {
                  $razorpay_allow = $datas['value'];
                  $stripedetails['razorpay_allow'] = $datas['value'];
              }
              
            }
          }

          

          if(@$stripe_option == 1){

            $stripedetails['publishable_key'] = $publishable_key;

            $stripedetails['secret_key']      = $secret_key;

          }

          if(@$stripe_option == 2){

            $stripedetails['publishable_key'] = $live_publishable_key;

            $stripedetails['secret_key']      = $live_secret_key;

          }

          $paypaldetails=array();

          if(@$paypal_option == 1) {
              $query = $this->db->query("select * from paypal_details");
              $result = $query->row();              
              $stripedetails['paypal_secret_key'] = $result->sandbox_paypal_secret_key;
              $stripedetails['braintree_key'] = $result->braintree_key;
          }

          if(@$paypal_option == 2) {
              $query = $this->db->query("select * from paypal_details");
              $result = $query->row();              
              $stripedetails['paypal_secret_key'] = $result->live_paypal_secret_key;
              $stripedetails['braintree_key'] = $result->braintree_key;
          }

          if(@$razor_option == 1) {
              $query = $this->db->query("select * from razorpay_gateway");
              $result = $query->row();              
              $stripedetails['razorpay_secret_key'] = $result->api_secret;
              $stripedetails['razorpay_apikey'] = $result->api_key;
          }

          if(@$razor_option == 2) {
              $query = $this->db->query("select * from razorpay_gateway");
              $result = $query->row();              
              $stripedetails['razorpay_secret_key'] = $result->secretkey;
              $stripedetails['razorpay_apikey'] = $result->api_key;
          }
          
          if(!empty($stripedetails)){
            $response_code = '1';
            $response_message = $this->language_content['lg11_success'];
            $data = $stripedetails;
          }

          else{
            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);

}

    public function braintree_paypal_post() {
        if ($this->api_token !='') {
        	
            $user_data = array();
            $user_data = $this->post();  
            $data = array();
            if (!empty($user_data['amount']) && !empty($user_data['payload_nonce']) && !empty($user_data['orderID']) && !empty($user_data['subscription_id']) && !empty($user_data['subscriber_id'])) { 
            	$token = $this->api_token;
            	
                $amount = $user_data['amount'];
                $orderId = $user_data['orderID'];
                $payload_nonce = $user_data['payload_nonce'];
                $subscription_id = $user_data['subscription_id'];
                $subscriber_id  = $user_data['subscriber_id'];
               
                require_once 'vendor/autoload.php'; 
                require_once 'vendor/braintree/braintree_php/lib/Braintree.php';
                $gateway = new Braintree\Gateway([
                    'environment' => 'sandbox',
                    'merchantId' => 'pd6gznv7zbrx9hb8',
                    'publicKey' => 'h8bydrz7gcjkp7d4',
                    'privateKey' => '47b83ae8fdcf23342f71b21c1a9a6223'
                ]);
                
                if ($gateway) {

                    $result = $gateway->transaction()->sale([
                        'amount' => $amount,
                        'paymentMethodNonce' => $payload_nonce,
                        'orderId' => $orderId,
                        'options' => [
                        'submitForSettlement' => True
                        ],
                    ]);
                    
                    if ($result->success) {
                        $transaction_id = $result->transaction->id;
                        
                          $subsdt=date('Y-m-d H:i:s');
                          $new_details['subscriber_id']  = $subscriber_id;
					      $new_details['subscription_id']  = $subscription_id;
					      $new_details['subscription_date'] = date('Y-m-d H:i:s');
					      $new_details['expiry_date_time'] =  date('Y-m-d H:i:s',strtotime(date("Y-m-d  H:i:s", strtotime($subsdt)) ." +".$duration."days"));
                          $count = $this->db->count_all_results('subscription_details');

                        if($count == 0) {
				            $this->db->insert('subscription_details', $new_details);
				            $table_data['sub_id'] = $this->db->insert_id();
          				}
          				else {
				            $this->db->where('subscriber_id', $subscriber_id);
				            $this->db->update('subscription_details', $new_details);
							$this->db->where('subscriber_id', $subscriber_id);
            				$details_sub = $this->db->get('subscription_details')->row_array();
        					$table_data['sub_id'] = $details_sub['id'];
          				}
          				 $table_data['sub_id'] = $subscriber_id;
          				 $table_data['tokenid'] = $transaction_id;
             			 $table_data['subscription_id'] = $subscription_id;
             			 $table_data['payment_details'] = $amount;
              			 $table_data['subscriber_id'] = $subscriber_id;
              			 $table_data['subscription_date'] = date('Y-m-d H:i:s');
          				 $res = $this->db->insert('subscription_payment', $table_data);
 					
          				 $payment_details['payment_status'] = json_decode($result->success,true);
          				 $transaction_details = $transaction_id;
                        if (!empty($res)) {

                            $response_code = '200';
                            $response_message = 'You have Subscribed Successfully';
                            $data['transactionId'] = $transaction_details;
                            $data['payment_details'] = json_encode($payment_details);
                        } else {

                            $response_code = '404';
                            $response_message = $this->language_content['lg_no_language_were_found'];
                            $data = [];
                        }
                    } else {
                        $response_code = '404';
                        $response_message = $this->language_content['lg_no_language_were_found'];
                        $data = [];
                    }
                } else {
                    $response_code = '404';
                    $response_message = $this->language_content['lg_no_language_were_found'];
                    $data = [];
                }
            }
            $result = $this->data_format($response_code, $response_message, $data);
            $this->response($result, REST_Controller::HTTP_OK);
        } else {
            $this->token_error();
        }
    }


     public function stripe_razor_payment_post() {

        $user_post_data = getallheaders();
        $token = (!empty($user_post_data['token'])) ? $user_post_data['token'] : '';
        if (empty($token)) {
            $token = (!empty($user_post_data['Token'])) ? $user_post_data['Token'] : '';
        }
        $params = $this->post();
        if (empty($token)) {
            $token = (!empty($params['Token'])) ? $params['Token'] : '';
        }
        if (!empty($token)) {
            $params = $this->post();
      //
      
      
      if($params['paytype'] == 'stripe'){

        if (!empty($params['amount']) && !empty($params['tokenid']) && $params['amount'] > 0) {

          $check_card = $this->db->get_where('stripe_customer_table', array('user_token' => $token))->row();
          
          if (!empty($check_card->user_token) && $check_card->user_token == $token) {
            /* create card info based on customer */

            $cust_info = $this->stripe->retrieve_customer($check_card->cust_id, $this->data['secret_key']);
            
            if (!empty($cust_info)) {

              $data['source'] = $params['tokenid']; /* The type of payment source. Should be card. */
              
              /* create customern in stripe */
              $create_cust = $this->stripe->create_card($data, $check_card->cust_id);
              
              
              $card_data = json_decode($create_cust);
              if (!empty($card_data) && !empty($card_data->id)) {
                $card_info['user_token'] = $token;
                $card_info['stripe_token'] = $params['tokenid'];
                $card_info['cust_id'] = $check_card->cust_id;
                $card_info['card_id'] = $card_data->id;
                $card_info['pay_type'] = $card_data->object;
                $card_info['brand'] = $card_data->brand;
                $card_info['cvc_check'] = $card_data->cvc_check;
                $card_info['card_number '] = $card_data->last4;
                $card_info['card_exp_month'] = $card_data->exp_month;
                $card_info['card_exp_year'] = $card_data->exp_year;
                $card_info['status'] = 1;
                $card_info['created_at'] = date('Y-m-d H:i:s');

                $vals = $this->db->insert('stripe_customer_card_details', $card_info);

                
                $charges_array = array();
                $amount = $params['amount'];
                $amount = ($amount * 100);
                $charges_array['amount'] = $amount;
                $charges_array['currency'] =$params['currency'];
                $charges_array['customer'] = $card_info['cust_id'];
                $charges_array['source'] = $card_info['card_id'];
                $charges_array['expand'] = array('balance_transaction');

                $result = $this->stripe->stripe_charges($charges_array);
                

                $pay_info = json_decode($result);
                if ($vals) {
                  $deleted = $this->stripe->delete_card($card_info['cust_id'], $card_info['card_id']);

                  $delete_card = json_decode($deleted);

                  if (empty($delete_card->error)) {
                    $wallet_data['status'] = 0;
                    $wallet_data['updated_on'] = date('Y-m-d H:i:s');
                    $WHERE = array('cust_id' => $card_info['cust_id'], 'card_id' => $card_info['card_id']);
                    $result = $this->api->update_customer_card($wallet_data, $WHERE);
                  }
                }
                
                if (empty($pay_info->error)) {
                  /* wallet infos */

                  $user_info = $this->api->get_token_info($token);

                  $wallet = $this->api->get_wallet($token);
                  if(empty($wallet['wallet_amt']))
                  {
                    $wallet['wallet_amt']=0;
                  }
                  
                  $curren_wallet = get_gigs_currency($wallet['wallet_amt'], $wallet['currency_code'], "USD");
                  if($curren_wallet=='NAN')
                  {
                    $curren_wallet=0;
                  }
                  else
                  {
                    $curren_wallet=$curren_wallet;
                  }

                  /* wallet infos */


                  $history_pay['token'] = $token;
                  $history_pay['currency_code']="USD";
                  $history_pay['user_provider_id'] = $user_info->id;
                  $history_pay['type'] = $user_info->type;
                  $history_pay['tokenid'] = $params['tokenid'];
                  $history_pay['payment_detail'] = $result;
                  $history_pay['charge_id'] = $pay_info->id;
                  $history_pay['transaction_id'] = $pay_info->balance_transaction->id;
                  $history_pay['exchange_rate'] = $pay_info->balance_transaction->exchange_rate;
                  $history_pay['paid_status'] = $pay_info->paid;
                  $history_pay['cust_id'] = $pay_info->source->customer;
                  $history_pay['card_id'] = $pay_info->source->id;
                  $history_pay['total_amt'] = $pay_info->balance_transaction->amount;
                  $history_pay['fee_amt'] = $pay_info->balance_transaction->fee;
                  $history_pay['net_amt'] = $pay_info->balance_transaction->net;
                  $history_pay['amount_refund'] = $pay_info->amount_refunded;
                  $history_pay['current_wallet'] = $curren_wallet;
                  $history_pay['credit_wallet'] = (($pay_info->balance_transaction->net) / 100);
                  $history_pay['debit_wallet'] = 0;
                  $history_pay['avail_wallet'] = (($pay_info->balance_transaction->net) / 100) + $curren_wallet;
                  $history_pay['reason'] = TOPUP;
                  $history_pay['created_at'] = date('Y-m-d H:i:s');
                  
                  if ($this->db->insert('wallet_transaction_history', $history_pay)) {
                    /* update wallet table */
                    $wallet_dat['currency_code']=$wallet['currency_code'];
                    $wallet_dat['wallet_amt'] = get_gigs_currency(($curren_wallet + $history_pay['credit_wallet']),"USD",$wallet['currency_code']);
                    $wallet_dat['updated_on'] = date('Y-m-d H:i:s');
                    $WHERE = array('token' => $token);
                    $result = $this->api->update_wallet($wallet_dat, $WHERE);
                    /* payment on stripe */
                    $response_code = '200';
                    $response_message = 'Amount added to wallet successfully';
                    $data['data'] = 'Successfully added to wallet...';
                  } else {
                    $response_code = '200';
                    $response_message = 'Stripe payment issue';
                    $data['data'] = 'history issues';
                  }
                } else {
                  $response_code = '200';
                  $response_message = 'Stripe payment issue';
                  $data['data'] = [];
                }
              } else {
                $response_code = '200';
                $response_message = 'card not created by customer...';
                $data['data'] = $card_data->error;
              }
            } else {
              $response_code = '200';
              $response_message = 'Stripe payment issue';
              $data['error'] = 'Not stored in card info';
            }

            $result = $this->data_format($response_code, $response_message, $data);
            $this->response($result, REST_Controller::HTTP_OK);
          } else {

            /* create new customer and card info */
            $user_info = $this->api->get_token_info($token);

            $data['email'] = $user_info->email;
            $data['source'] = $params['tokenid'];
            $create_cust = $this->stripe->customer_create($data);

            $cust = json_decode($create_cust);
            if (empty($cust->error)) {
              $cr_stripe_cust['cust_id'] = $cust->id;
              $cr_stripe_cust['user_token'] = $token;
              $cr_stripe_cust['created_at'] = date('Y-m-d H:i:s');

              if ($this->db->insert('stripe_customer_table', $cr_stripe_cust)) {
                if (!empty($cust->sources)) {
                  foreach ($cust->sources->data as $key => $value) {
                    $card_info['user_token'] = $token;
                    $card_info['stripe_token'] = $params['tokenid'];
                    $card_info['cust_id'] = $value->customer;
                    $card_info['card_id'] = $value->id;
                    $card_info['pay_type'] = $value->object;
                    $card_info['brand'] = $value->brand;
                    $card_info['cvc_check'] = $value->cvc_check;
                    $card_info['card_number '] = $value->last4;
                    $card_info['card_exp_month'] = $value->exp_month;
                    $card_info['card_exp_year'] = $value->exp_year;
                    $card_info['status'] = 1;
                    $card_info['created_at'] = date('Y-m-d H:i:s');

                    $vals = $this->db->insert('stripe_customer_card_details', $card_info);
                  }
                }
              }
             
              $charges_array = array();
              $amount = $params['amount'];
              $amount = ($amount * 100);
              $charges_array['amount'] = $amount;
              $charges_array['currency'] =$params['currency'];
              $charges_array['customer'] = $card_info['cust_id'];
              $charges_array['source'] = $card_info['card_id'];
              $charges_array['expand'] = array('balance_transaction');

              $result = $this->stripe->stripe_charges($charges_array);


              $pay_info = json_decode($result);

              if ($vals) {
                /* delete card */
                $deleted = $this->stripe->delete_card($card_info['cust_id'], $card_info['card_id']); //remove card
                $delete_card = json_decode($deleted);

                if (empty($delete_card->error)) {
                  $wallet_data['status'] = 0;
                  $wallet_data['updated_on'] = date('Y-m-d H:i:s');
                  $WHERE = array('cust_id' => $card_info['cust_id'], 'card_id' => $card_info['card_id']);
                  $result = $this->api->update_customer_card($wallet_data, $WHERE);
                }
              }
               if (empty($pay_info->error)) {
                  /* wallet infos */

                  $user_info = $this->api->get_token_info($token);

                  $wallet = $this->api->get_wallet($token);
                  if(empty($wallet['wallet_amt']))
                  {
                    $wallet['wallet_amt']=0;
                  }
                  

                  $curren_wallet = get_gigs_currency($wallet['wallet_amt'], $wallet['currency_code'], "USD");
                  if($curren_wallet=='NAN')
                  {
                    $curren_wallet=0;
                  }
                  else
                  {
                    $curren_wallet=$curren_wallet;
                  }

                  /* wallet infos */


                  $history_pay['token'] = $token;
                  $history_pay['currency_code']="USD";
                  $history_pay['user_provider_id'] = $user_info->id;
                  $history_pay['type'] = $user_info->type;
                  $history_pay['tokenid'] = $params['tokenid'];
                  $history_pay['payment_detail'] = $result;
                  $history_pay['charge_id'] = $pay_info->id;
                  $history_pay['transaction_id'] = $pay_info->balance_transaction->id;
                  $history_pay['exchange_rate'] = $pay_info->balance_transaction->exchange_rate;
                  $history_pay['paid_status'] = $pay_info->paid;
                  $history_pay['cust_id'] = $pay_info->source->customer;
                  $history_pay['card_id'] = $pay_info->source->id;
                  $history_pay['total_amt'] = $pay_info->balance_transaction->amount;
                  $history_pay['fee_amt'] = $pay_info->balance_transaction->fee;
                  $history_pay['net_amt'] = $pay_info->balance_transaction->net;
                  $history_pay['amount_refund'] = $pay_info->amount_refunded;
                  $history_pay['current_wallet'] = $curren_wallet;
                  $history_pay['credit_wallet'] = (($pay_info->balance_transaction->net) / 100);
                  $history_pay['debit_wallet'] = 0;
                  $history_pay['avail_wallet'] = (($pay_info->balance_transaction->net) / 100) + $curren_wallet;
                  $history_pay['reason'] = TOPUP;
                  $history_pay['created_at'] = date('Y-m-d H:i:s');

                  if ($this->db->insert('wallet_transaction_history', $history_pay)) {
                    /* update wallet table */
                    $wallet_dat['currency_code']=$wallet['currency_code'];
                    $wallet_dat['wallet_amt'] = get_gigs_currency(($curren_wallet + $history_pay['credit_wallet']),"USD",$wallet['currency_code']);
                    $wallet_dat['updated_on'] = date('Y-m-d H:i:s');
                    $WHERE = array('token' => $token);
                    $result = $this->api->update_wallet($wallet_dat, $WHERE);
                    /* payment on stripe */
                    $response_code = '200';
                    $response_message = 'Amount added to wallet successfully';
                    $data['data'] = 'Successfully added to wallet...';
                  } else {
                    $response_code = '200';
                    $response_message = 'Stripe payment issue';
                    $data['data'] = 'history issues';
                  }
                } else {
                $response_code = '200';
                $response_message = 'Stripe payment issue';
                $data['data'] = 'history issues';
              }
            } else {
              $response_code = '400';
              $response_message = 'This token Already Used...';
              $data['data'] = 'token already used...';
            }
          }


          $result = $this->data_format($response_code, $response_message, $data);
          $this->response($result, REST_Controller::HTTP_OK);
        } else {
          $response_code = '200';
          $response_message = 'Stripe payment issue';
          $data['error'] = $result['error'];

          $result = $this->data_format($response_code, $response_message, $data);
          $this->response($result, REST_Controller::HTTP_OK);
        }
      }
      else if($params['paytype'] == 'razorpay'){        
        $usertoken     = $params['token'];
        $user          = $this->db->where('token', $token)->get('users')->row_array();
        $token         = $this->session->userdata('chat_token');
        $user_id       = $user['id'];
        $user_name     = $user['name'];
        $user_token    = $user['token'];
        $currency_type = $user['currency_code'];
        $amt = $params['amount'];
        $wallet = $this->db->where('user_provider_id', $user_id)->limit(1)->order_by('id',"DESC")->get('wallet_table')->row_array();
        
        $wallet_amt = $wallet['wallet_amt'];
        if($wallet_amt){
          $current_wallet = $wallet_amt;
        }else{
          $current_wallet = $amt;
        }         
        $history_pay['token']=$user_token;
        $history_pay['currency_code'] = $currency_type;
        $history_pay['user_provider_id']=$user_id;
        $history_pay['type']='2';
        $history_pay['tokenid']=$user_post_data['tokenid'];
        $history_pay['payment_detail']="Razorpay";
        $history_pay['charge_id']=1;
        $history_pay['exchange_rate']=0;
        $history_pay['paid_status']="pass";
        $history_pay['cust_id']="self";
        $history_pay['card_id']="self";
        $history_pay['total_amt']=$amt;
        $history_pay['fee_amt']=0;
        $history_pay['net_amt']=$amt*100;
        $history_pay['amount_refund']=0;
        $history_pay['current_wallet']=$current_wallet;
        $history_pay['credit_wallet']=$amt;
        $history_pay['debit_wallet']=0;
        $history_pay['avail_wallet']=$amt + $current_wallet;
        $history_pay['reason']=TOPUP;
        $history_pay['created_at']=date('Y-m-d H:i:s');
        if($this->db->insert('wallet_transaction_history',$history_pay)){
          
          $this->db->where('user_provider_id', $user_id)->update('wallet_table', array(
            'currency_code' => $currency_type,
            'wallet_amt' => $amt+$current_wallet
          ));
          $response_code = '200';
          $response_message = 'Amount added to wallet successfully';
          $data['data'] = 'Successfully added to wallet...';               
        }else{
          $response_code = '200';
          $response_message = 'RazorPay payment issue';
          $data['data'] = 'history issues';                
        }
        $result = $this->data_format($response_code, $response_message, $data);
        $this->response($result, REST_Controller::HTTP_OK);
      }
        } else {
            $this->token_error();
        }
    }



    public function image_resize($width=0,$height=0,$image_url,$filename)

    {

      $source_path = $image_url;

      list($source_width, $source_height, $source_type) = getimagesize($source_path);

      switch ($source_type) {

        case IMAGETYPE_GIF:

        $source_gdim = imagecreatefromgif($source_path);

        break;

        case IMAGETYPE_JPEG:

        $source_gdim = imagecreatefromjpeg($source_path);

        break;

        case IMAGETYPE_PNG:

        $source_gdim = imagecreatefrompng($source_path);

        break;

      }

      $source_aspect_ratio = $source_width / $source_height;



      $desired_aspect_ratio = $width / $height;



      if ($source_aspect_ratio > $desired_aspect_ratio) {

      /*

       * Triggered when source image is wider

       */



      $temp_height = $height;

      $temp_width = ( int ) ($height * $source_aspect_ratio);

    } else {

      /*

       * Triggered otherwise (i.e. source image is similar or taller)

       */

      $temp_width = $width;

      $temp_height = ( int ) ($width / $source_aspect_ratio);

    }



    /*

     * Resize the image into a temporary GD image

     */

    $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);

    imagecopyresampled(

      $temp_gdim,

      $source_gdim,

      0, 0,

      0, 0,

      $temp_width, $temp_height,

      $source_width, $source_height

    );
    $x0 = ($temp_width - $width) / 2;

    $y0 = ($temp_height - $height) / 2;

    $desired_gdim = imagecreatetruecolor($width, $height);

    imagecopy(

      $desired_gdim,

      $temp_gdim,

      0, 0,

      $x0, $y0,

      $width, $height

    );
    $image_url = 'uploads/profile_img/'.$filename;

    if($source_type ==IMAGETYPE_PNG){
      imagepng($desired_gdim,$image_url);
    }
    if ($source_type ==IMAGETYPE_JPEG) {
      imagejpeg($desired_gdim,$image_url);
    }
    return $image_url;
  }


  public function provider_details_post()
  {

    $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();


      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          $result = $this->api->provider_details($user_post_data['p_id']);
          $response_code = '1';
          $response_message = "Availability Details";
          $data['availability_details'] = $result;

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);

    }


    public function views_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();

      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){
        $result = $this->api->token_is_valid($token);
        $results='';

        if($result){
          $this->db->select('id');
          $this->db->from('provider_views');
          $this->db->where('user_id',$user_data['Userid']);
          $this->db->where('p_id',$user_data['Pid']);
          $check_views = $this->db->count_all_results();

            $this->db->insert('provider_views', array('user_id'=>$user_data['Userid'], 'p_id'=>$user_data['Pid']));

            $this->db->set('views', 'views+1', FALSE);
            $this->db->where('p_id',$user_data['Pid']);
            $results= $this->db->update('provider_details');

          if($results){

            $response_code = '1';
            $response_message = $this->language_content['lg11_success'];
            
          }
          else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_invalid_user_to'];
          }

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }
      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }
      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function book_service_post()
    { 
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
    $user_data = array_merge($user_data,$user_post_data);
    
      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

        $results='';
      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){
        $result = $this->api->token_is_valid($token);
  
        if($result){
              if(!empty($user_data['Latitude'])&& !empty($user_data['Longitude'])&& !empty($user_data['Notes'])&& !empty($user_data['Providerid'])&& !empty($user_data['Servicedate'])&& !empty($user_data['Servicetime']))
          {
              $results=$this->api->book_service($token,$user_data);
            if($results==1){
              $to_user_id = 0;
              $details=$this->api->provider($user_data['Providerid']);
              $title = $details['title'];
              $to_user_id = $details['user_id'];
              $user_id = $this->api->get_user_id_using_token($token);
              $name  = $this->api->username($user_id); 
                    $username = $name['username'];
              $message = $username.' added new Booking';
              $notification_type = 'Create Booking';
              $this->notifications($notification_type,$title,$message,$to_user_id,$user_id);

              $response_code = '1';
              $response_message = $this->language_content['lg11_success'];
              

            }elseif($results==3){

              $response_code = '-1';
              $response_message = 'You have already booked this provider';
            }
            else{

              $response_code = '-1';
              $response_message = 'Failed';
            }
          }
          else
          {
            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }
        }else{
          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }
      }else{
        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }
      $result = $this->data_format($response_code,$response_message,$data);
      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function complete_provider_post()
    {
      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];
      $params =  $this->post();
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_data = array_merge($user_data,$params);
    
    
      if(!empty($user_data['Bookserviceid']) && !empty($user_data['Providerid']))
      {

        $user_data = array();
          $user_data =  getallheaders(); // Get Header Data
          $token = (!empty($user_data['Token']))?$user_data['Token']:'';
          if(empty($token)){
            $token = (!empty($user_data['Token']))?$user_data['Token']:'';
          }

          $user_data['Token'] = $token;

          $id = $user_data['Bookserviceid'];
          $user_id = $this->api->get_user_id_using_token($user_data['Token']);
          $provider_id = $user_data['Providerid'];
          $booking_service_status = $this->api->complete_provider($id,$user_id,$provider_id);

          if(!empty($booking_service_status)){
            $response_code = '1';
            $response_message = $this->language_content['lg11_success'];
            $data = $booking_service_status;
          }
        }else{
          $response_code = '-1';
          $response_message = $this->language_content['lg11_required_input_'];
        }

        $result = $this->data_format($response_code,$response_message,$data);
        $this->response($result, REST_Controller::HTTP_OK);
        
        
    }

    public function my_booking_list_get()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data


      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          $result = $this->api->my_booking_list($token);
          $response_code = '1';
          $response_message = "Booking list";
          $data['booking_list'] = $result;

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }


    public function booking_request_list_get()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data


      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          $result = $this->api->booking_request_list($token);
          $response_code = '1';
          $response_message = "Booking Request list";
          $data['booking_list'] = $result;

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }
    public function rate_review_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['rating']) && !empty($user_data['review']) && !empty($user_data['p_id']) && !empty($user_data['type'])){
            $user_data['token'] = $token;
            $result = $this->api->rate_review_for_provider($user_data);
            if($result == 1){
              $response_code = '1';
              $response_message = $this->language_content['lg1_test'];
              
            }elseif($result == 2){

              $response_code = '-1';
              $response_message = 'You have already reviwed this provider';
            }

            else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function rate_review_list_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data) && !empty($user_data['Pid'])){

            $user_data['Token'] = $token;
            $user_data['Page']  = (!empty($user_data['Page']))?$user_data['Page']:1;

            $result = $this->api->rate_review_list($user_data);
            if(!empty($result)){

              $response_code = '1';
              $response_message = $this->language_content['lg1_review_listed'];

              if($result['total_pages']< $result['current_page']){
                $response_code = '-1';
                $response_message = $this->language_content['lg11_invalid_page'];
              }

              $data = $result;

            }else{

              $response_code = '0';
              $response_message = $this->language_content['lg11_no_records_foun'];

            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    } 

    public function comments_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['comment']) && !empty($user_data['p_id'])){
            $user_data['token'] = $token;
            $last_id = $this->api->comments_for_provider($user_data);
            if(!empty($last_id)){
              $response_code = '1';
              $response_message = $this->language_content['lg1_thank_you_for_y'];
              $comments_details = $this->api->comments_details($last_id);
              $data = $comments_details;

            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }
    public function comments_list_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data) && !empty($user_data['Pid'])){

            $user_data['Token'] = $token;
            $user_data['Page']  = (!empty($user_data['Page']))?$user_data['Page']:1;

            $result = $this->api->comments_list($user_data);

            if(!empty($result['total_pages'])){

              $response_code = '1';
              $response_message = $this->language_content['lg1_comment_listed'];

              if($result['total_pages']< $result['current_page']){
                $response_code = '-1';
                $response_message = $this->language_content['lg11_invalid_page'];
              }
              $data = $result;

            }else{

              $response_code = '0';
              $response_message = $this->language_content['lg11_no_records_foun'];

            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    } 
    
    public function replies_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data['replies']) && !empty($user_data['p_id']) && !empty($user_data['comment_id'])){
            $user_data['token'] = $token;
            $last_id = $this->api->replies_for_comments($user_data);
            if(!empty($last_id)){
              $response_code = '1';
              $response_message = $this->language_content['lg1_thank_you_for_y'];
              $replies_details = $this->api->replies($last_id);
              $data = $replies_details;

            }else{
              $response_code = '-1';
              $response_message = $this->language_content['lg11_something_is_wr'].','.$this->language_content['lg11_please_try_agai'];
            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function replies_list_post()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data
      $user_post_data = $this->post();
      $user_data = array_merge($user_data,$user_post_data);

      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          if(!empty($user_data) && !empty($user_data['comment_id'])){

            $user_data['token'] = $token;
            $user_data['page']  = (!empty($user_data['page']))?$user_data['page']:1;

            $result = $this->api->replies_list($user_data);


            if(!empty($result['total_pages'])){

              $response_code = '1';
              $response_message = $this->language_content['lg1_comment_listed'];

              if($result['total_pages']< $result['current_page']){
                $response_code = '-1';
                $response_message = $this->language_content['lg11_invalid_page'];
              }
          
              $data = $result;

            }else{

              $response_code = '0';
              $response_message = $this->language_content['lg11_no_records_foun'];

            }

          }else{

            $response_code = '-1';
            $response_message = $this->language_content['lg11_required_input_'];
          }


        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }

    public function ratings_type_get()
    {
      $user_data = array();
      $user_data =  getallheaders(); // Get Header Data


      $token = (!empty($user_data['token']))?$user_data['token']:'';
      if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
      }

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_validation_erro'];

      if(!empty($token)){

        $result = $this->api->token_is_valid($token);

        if($result){

          $result = $this->api->ratings_type();
          $response_code = '1';
          $response_message = "Ratings type list";
          $data['ratings_type_list'] = $result;

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_invalid_user_to'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_user_token_is_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);
    }


    public function contact_us_post()
    {

      $user_data = array();
      $user_data = $this->post();

      $data = array();
      $response_code = '-1';
      $response_message = $this->language_content['lg11_email_address_n'];

      if(!empty($user_data['email_address'])){

        $result = $this->api->contact_us($user_data);

        if($result){

          $response_code = '1';
          $response_message = 'Mail send successfully';

        }else{

          $response_code = '-1';
          $response_message = $this->language_content['lg11_email_address_n1'];
        }

      }else{

        $response_code = '-1';
        $response_message = $this->language_content['lg11_email_address_m'];
      }

      $result = $this->data_format($response_code,$response_message,$data);

      $this->response($result, REST_Controller::HTTP_OK);

    }

    public function language_list_get() {
      $user_data = array();
      $user_post_data = array();
      $user_post_data = $this->post();
       $user_data =  getallheaders(); // Get Header Data
       $token = (!empty($user_data['token']))?$user_data['token']:'';
       if(empty($token)){
        $token = (!empty($user_data['Token']))?$user_data['Token']:'';
       }

       $data = array();
       if(!empty($token)){
        $result = $this->api->languages_list();

        if (!empty($result)) {
          
          $response_code= '1';
          $response_message = 'Sucess';
          $data = $result;
          
        } else {
          
          $response_code= '-1';
          $response_message = 'No Data Avilable';
        }
       }
       else{
        $response_code= '-1';
        $response_message = 'Tocken is Not Avilable';
       }
       
       $result = $this->data_format($response_code,$response_message,$data);
       $this->response($result, REST_Controller::HTTP_OK);
   }

   public function language_post() {
      $user_data = array();
      $user_post_data = array();
      $data = array();
      $user_post_data = $this->post();
        $user_data =  getallheaders(); // Get Header Data
      $token = (!empty($user_data['Token']))?$user_data['Token']:'';
         if(empty($token)){
          $token = (!empty($user_data['Token']))?$user_data['Token']:'';
         }
         if(!empty($token)){
          if (!empty($user_data['Language'])) {
            $result = $this->api->language_list($user_data['Language']);
        
            if (!empty($result)) {
              $response_code= '1';
              $response_message = 'Success';
              $data = $result;
            } else {
              $response_code= '-1';
              $response_message = 'No Data Avilable';
            }
          }else{
            $response_code= '-1';
            $response_message = 'Input filed is Required';
          }  
         }
         else{
          
          $response_code= '-1';
          $response_message = 'Tocken is Not Avilable';
          
         }
         $result = $this->data_format($response_code,$response_message,$data);
         $this->response($result, REST_Controller::HTTP_OK);
     }
     
     public function currency_list_get() {
      
      $user_data = array();
      $data = array();
      $user_post_data = array();
      $user_post_data = $this->post();
        $user_data =  getallheaders(); // Get Header Data
        $token = (!empty($user_data['token']))?$user_data['token']:'';
        if(empty($token)){
          $token = (!empty($user_data['Token']))?$user_data['Token']:'';
        }

        if(!empty($token)){
          $result=$this->db->where('status',1)->select('id,currency_code')->get('currency_rate')->result_array();

          if (!empty($result)) {
            $response_code= '1';
            $response_message = 'Sucess';
            $data = $result;
          } else {
            $response_code= '-1';
            $response_message = 'No Data Avilable';
          }
        }
        else{
          $response_code= '-1';
          $response_message = 'Tocken is Not Avilable';
        }

        
        
        $result = $this->data_format($response_code,$response_message,$data);
        $this->response($result, REST_Controller::HTTP_OK);
        
    } 


}
