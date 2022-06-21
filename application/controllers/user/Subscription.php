<?php
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
        $this->data['view'] = 'user';
        $this->data['base_url'] = base_url();
        $this->load->model('language_web_model');
        $this->load->library('paypal_lib');

        $this->load->model('language_web_model');
        $this->load->helper('custom_language');
        $lang = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
        $this->data['language_content'] = get_languages($lang);
        $this->web_validation_array = $this->data['language_content']['language'];

        $this->load->model('subscription_model','subscription');
        $this->load->helper('user_timezone_helper');$user_id = $this->session->userdata('user_id');
        $this->data['user_id'] = $user_id;
        $this->load->helper('subscription_helper');
        $this->data['subscription_details'] = get_subscription_details(md5($user_id));
        $this->load->model('categories_model','category');
        $this->load->model('language_model','language');
        $this->data['language'] = $this->language->active_language();
        $this->data['category'] = $this->category->show_category(); 
        $this->data['system_setting']= $this->db->query ("select * from system_settings")->result_array();


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

                  if($data['key'] == 'website_name'){
                  $this->website_name = $data['value'];
                  }

                if ($data['key'] == 'paypal_secret_key') {
                    $this->paypal_secret_key = !empty($data['value']) ? $data['value'] : '';
                }
                if ($data['key'] == 'paypal_secret_value') {
                    $this->paypal_secret_value = !empty($data['value']) ? $data['value'] : '';
                }
                if ($data['key'] == 'stripe_option') {
                    $this->stripe_option = $data['value'];
                }
                if ($data['key'] == 'paypal_allow') {
                    $this->paypal_allow = $data['value'];
                }
                if ($data['key'] == 'paytabs_allow') {
                    $this->paytabs_allow = $data['value'];
                }
                if ($data['key'] == 'stripe_allow') {
                    $this->stripe_allow = $data['value'];
                }
            if ($data['key'] == 'razorpay_allow') {
                    $this->razorpay_allow = $data['value'];
                }
            if ($data['key'] == 'razorpay_option') {
                    $this->razorpay_option = $data['value'];
                }
                if ($data['key'] == 'paypal_option') {
                    $this->paypal_option = $data['value'];
                }
                if ($data['key'] == 'paytabs_option') {
                    $paytabs_option = $data['value'];
                }
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
                  
                  if($data['key'] == 'logo_front'){
                      $this->data['website_logo_front'] =  $data['value'];
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
      if ($this->paypal_option == 1) {
            $this->paypal_id = $this->db->select('sandbox_email')->get('paypal_details')->row()->sandbox_email;
        }
        if ($this->paypal_option == 2) {
            $this->paypal_id = $this->db->select('email')->get('paypal_details')->row()->email;
        }
        if ($paytabs_option == 1) {
            $this->paytabs_email     = $this->db->select('sandbox_email')->get('paytabs_details')->row()->sandbox_email;
            $this->paytabs_secretkey = $this->db->select('sandbox_secretkey')->get('paytabs_details')->row()->sandbox_secretkey;
        }
        if ($paytabs_option == 2) {
            $this->paytabs_email     = $this->db->select('email')->get('paytabs_details')->row()->email;
            $this->paytabs_secretkey = $this->db->select('secretkey')->get('paytabs_details')->row()->secretkey;
        }
        $this->razorpaylive_apikey     = $this->db->select('api_key')->get('razorpay_gateway')->row()->api_key;
        $this->razorpaylive_apisecret = $this->db->select('api_secret')->get('razorpay_gateway')->row()->api_secret;
        
        $this->data['paypal_allow']    = $this->paypal_allow;
        $this->data['paytabs_allow']   = $this->paytabs_allow;
        $this->data['stripe_allow']    = $this->stripe_allow;
        $this->data['razorpay_allow']  = $this->razorpay_allow;
        $this->data['razorpay_option']  = $this->razorpay_option;
        $this->data['razorpaylive_apikey']  = $this->razorpaylive_apikey;
        $this->data['razorpaylive_apisecret']  = $this->razorpaylive_apisecret;
          $config['publishable_key'] =  $this->data['publishable_key'];

          $config['secret_key'] = $this->data['secret_key'];

          $this->load->library('stripe',$config);
          

        if(!$this->session->userdata('user_id')) {
            redirect(base_url('login'));
        }




    }

  public function index()
  {
    redirect(base_url('subscription-list'));
  }

  public function subscription_list()
  {
    $this->data['page'] = 'subscription-list';
    $this->data['model'] = 'subscription';
    $this->data['publishable_key'] = $this->data['publishable_key'];
    $this->data['list'] = $this->subscription->get_subscription_list();
    $this->data['my_subscribe'] = $this->subscription->get_my_subscription();
    $this->data['offline_subscribe'] = $this->subscription->get_offline_subscription();
    $lan = $this->session->userdata('lang');
    $query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'reference_currency_code'");
    $this->data["default_currency"] = $query->row_array(); 
    $this->data['lang_val'] = $this->language_web_model->lang_manage_data($lan);
    
    $this->load->vars($this->data);
    $this->load->view('template');
  }

public function payment_gateway($id)
  {
    $this->data['page'] = 'payment_gateway';
    $this->data['model'] = 'subscription';
    $lan = $this->session->userdata('lang');
    $query = $this->db->query("SELECT * FROM `subscription_fee` WHERE `id` = '$id' and `status`='1'");
    $this->data["subs"] = $query->row_array(); 
    $this->data['postdata']=$id;
    $this->load->vars($this->data);
    $this->load->view('template');
  }
 public function payment()
    {
      $params = $this->input->post();
      if (!empty($params)) {
           $amount        = $params['subs_amt'];
           $sub_id        = $params['sub_id'];
           $user_id       = $this->session->userdata('user_id');
           $user          = $this->db->where('user_id', $user_id)->get('users')->row_array();
            $user_name     = $user['username'];
           $user_token    = $user['unique_code'];
            $currency_type = $user['currency_code'];
         if ($this->input->post('group2') == 'PayTabs') {
                $this->paytabs_payments($amount, $user_id, $user_name, $currency_type, $user_token,$sub_id);
            } else {
              
                $this->buy($amount, $user_id, $user_name, $currency_type, $user_token,$sub_id);
            }
            
         }
        
    }
    function buy($amount, $user_id, $g_name, $currency_type, $user_token,$sub_id)
    {
        //Set variables for paypal form
        $returnURL = base_url() . 'user/subscription/paypal_success'; //payment success url
        $cancelURL = base_url() . 'user/subscription/paypal_cancel'; //payment cancel url
        $notifyURL = base_url() . 'user/subscription/ipn'; //ipn url
        $userID    = $user_id; //current user id
        $name      = $g_name;
        $subscription_id=$sub_id;

        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', $name);
        $this->paypal_lib->add_field('custom', $userID);
        $this->paypal_lib->add_field('item_number', $subscription_id);
        $this->paypal_lib->add_field('amount', $amount);
        $this->paypal_lib->add_field('currency_code', $currency_type);
        $this->paypal_lib->add_field('business', $this->paypal_id);
        $this->paypal_lib->paypal_auto_form();
    }
    public function paypal_success()
    {
        if (!empty($this->input->post('txn_id'))) {
            $paypalInfo  = $this->input->post();
            $txn_id      = $paypalInfo['txn_id'];
            $item_number = $paypalInfo['item_number'];
             $customerid = $paypalInfo['cm'];
        } else {
            $paypalInfo  = $this->input->get();
            print_r($paypalInfo);
            $txn_id      = $paypalInfo['tx'];
            $item_number = $paypalInfo['item_number'];
            $customerid = $paypalInfo['cm'];
            $amt= $paypalInfo['amt']."-". $paypalInfo['cc'];
        }
         if (!empty($txn_id) && !empty($item_number)) {
             $message                  = '';
             $order_id                 = $txn_id;
             $table_data['tokenid'] = $txn_id;
             $table_data['subscription_id'] = $item_number;
             $table_data['payment_details'] = $amt;
              $table_data['subscriber_id'] = $customerid;
              $table_data['subscription_date'] = date('Y-m-d H:i:s');
             
      $new_details['subscriber_id']  = $customerid;
      $new_details['subscription_id']  = $item_number;
      $this->db->select('duration');
       $feerecord = $this->db->get_where('subscription_fee',array('id'=>$item_number))->row_array();
       $duration=$feerecord['duration']*30;
          $new_details['subscription_date'] = date('Y-m-d H:i:s');
          $subsdt=date('Y-m-d H:i:s');
           $new_details['expiry_date_time'] =  date('Y-m-d H:i:s',strtotime(date("Y-m-d  H:i:s", strtotime($subsdt)) ." +".$duration."days"));
           $this->db->where('subscriber_id', $customerid);
          $count = $this->db->count_all_results('subscription_details');
          if($count == 0){
            $this->db->insert('subscription_details', $new_details);
        $table_data['sub_id'] = $this->db->insert_id();

          }else{

            $this->db->where('subscriber_id', $customerid);
            $this->db->update('subscription_details', $new_details);

        $this->db->where('subscriber_id', $customerid);
            $details_sub = $this->db->get('subscription_details')->row_array();
        $table_data['sub_id'] = $details_sub['id'];
          }
        
          if ($this->db->insert('subscription_payment',$table_data)) {
            $message = (!empty($this->user_language[$this->user_selected]['lg_subscription_success'])) ? $this->user_language[$this->user_selected]['lg_subscription_success'] : $this->default_language['en']['lg_subscription_success'];
            $this->session->set_flashdata('msg_success', 'You have Subscribed Successfully!');
            redirect('subscription-list');
         } else {
           $message = (!empty($this->user_language[$this->user_selected]['lg_something_went_wrong'])) ? $this->user_language[$this->user_selected]['lg_something_went_wrong'] : $this->default_language['en']['lg_something_went_wrong'];
          $this->session->set_flashdata('message', 'Sorry, something went wrong');
           redirect('subscription-list');
        }
        }
    }
    public function paypal_cancel()
    {
        $message = (!empty($this->user_language[$this->user_selected]['lg_something_went_wrong'])) ? $this->user_language[$this->user_selected]['lg_something_went_wrong'] : $this->default_language['en']['lg_something_went_wrong'];
        $this->session->set_flashdata('message', $message);
        redirect('home');
    }
     function ipn()
    {
        $paypalInfo = $this->input->post();
        $data['user_id'] = $paypalInfo['custom'];
        $data['product_id'] = $paypalInfo["item_number"];
        $data['txn_id'] = $paypalInfo["txn_id"];
        $data['payment_gross'] = $paypalInfo["payment_gross"];
        $data['currency_code'] = $paypalInfo["mc_currency"];
        $data['payer_email'] = $paypalInfo["payer_email"];
        $data['payment_status'] = $paypalInfo["payment_status"];
        $paypalURL = $this->paypal_lib->paypal_url;
        $result = $this->paypal_lib->curlPost($paypalURL, $paypalInfo);
        if (isset($TRANSACTIONID) && isset($user_pay_id)) {
            if (preg_match("/VERIFIED/i", $result)) {
                $table_data['transaction_id'] = $TRANSACTIONID;
                $table_data['transaction_status'] = 1;
                $table_data['transaction_date'] = date('Y-m-d H:i:s');
                $this->db->update('payments', $table_data, "id = " . $user_pay_id);
            }
        }
    }
       public function paytabs_payments($amount, $user_id, $g_name, $currency_type, $user_token,$sub_id)
    {
        $ip          = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
       $USERID      = $this->session->userdata('user_id');
       $userdetails = $this->db->query('select m.email,m.full_name,m.currency_code,m.mobile_no,m.latitude,m.longitude from users as m WHERE user_id=' . $USERID . '')->row_array();
      
       $refsnos=$USERID."%%".$sub_id;
        $details     = array(
            "merchant_email" => $this->paytabs_email,
            "secret_key" => $this->paytabs_secretkey,
            "site_url" => base_url($this->data['theme']),
            "return_url" => base_url($this->data['theme'] . 'user/subscription/paytabs_success/'),
            "title" => $g_name,
            "cc_first_name" => $userdetails['full_name'],
            "cc_last_name" => "Not Mentioned",
            "cc_phone_number" => !empty($userdetails['mobile_no']) ? $userdetails['mobile_no'] : '0000',
            "phone_number" => !empty($userdetails['mobile_no']) ? $userdetails['mobile_no'] : '0000',
            "email" => $userdetails['email'],
            "products_per_title" => $g_name,
            "unit_price" => $amount,
            "quantity" => "1",
            "other_charges" => "0",
            "amount" => $amount,
            "discount" => "0",
            "currency" => $currency_type,
            "reference_no" => $refsnos,
            "sub_id"=>$sub_id,
            "ip_customer" => $ip,
            "ip_merchant" => $ip,
             "billing_address" => !empty($userdetails['address']) ? $userdetails['address'] : 'abc street',
             "city" => !empty($userdetails['city']) ? $userdetails['city'] : 'Erode',
             "state" => !empty($userdetails['state_name']) ? $userdetails['state_name'] : 'TN',
             "postal_code" => !empty($userdetails['zipcode']) ? $userdetails['zipcode'] : '638004',
            "country" => !empty($userdetails['sortname']) ? $userdetails['sortname'] : 'IND',
            "shipping_first_name" => $userdetails['full_name'],
            "shipping_last_name" => "Not Mentioned",
             "address_shipping" => !empty($userdetails['address']) ? $userdetails['address'] : 'abc St',
             "state_shipping" => !empty($userdetails['state_name']) ? $userdetails['state_name'] : 'TN',
             "city_shipping" => !empty($userdetails['city']) ? $userdetails['city'] : 'Erode',
             "postal_code_shipping" => !empty($userdetails['zipcode']) ? $userdetails['zipcode'] : '638004',
             "country_shipping" => !empty($userdetails['sortname']) ? $userdetails['sortname'] : 'IND',
            "msg_lang" => "English",
            "cms_with_version" => "CodeIgniter 3.1.9"
        );

        $ch          = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytabs.com/apiv2/create_pay_page");

        curl_setopt($ch, CURLOPT_POST, 1);
        // In real life you should use something like:
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($details));
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $info     = curl_getinfo($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }

        curl_close($ch);
        $pay_tabs_response = json_decode($response);
        if (!empty($pay_tabs_response->payment_url)) {
            redirect(urldecode($pay_tabs_response->payment_url));
        }
    }
    public function paytabs_success()
    {
        $paytabInfo = $this->input->post();

        if (!empty($paytabInfo)) {
            $details = array(
                "merchant_email" => $this->paytabs_email,
                "secret_key" => $this->paytabs_secretkey,
                "payment_reference" => $paytabInfo['payment_reference']
            );
            $ch      = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.paytabs.com/apiv2/verify_payment");
            curl_setopt($ch, CURLOPT_POST, 1);
            // In real life you should use something like:
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($details));
            // Receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $info     = curl_getinfo($ch);
            curl_close($ch);
            $pay_tabs_response = json_decode($response);
            if ($pay_tabs_response->response_code == '100') {
                if (!empty($pay_tabs_response->reference_no)) {
                  $refsnos=$pay_tabs_response->reference_no;
                  $refexp=explode('%%',$refsnos);
                  $user_id=$refexp[0];
                  $sub_ids=$refexp[1];
                $user          = $this->db->where('user_id', $user_id)->get('users')->row_array();
                $user_name     = $user['username'];
                $user_token    = $user['unique_code'];
                $currency_type = $user['currency_code'];
                    $user_id_ref = $pay_tabs_response->reference_no;
                    $subscription_id = $sub_ids;
                    $txn_id  = $pay_tabs_response->transaction_id;
                    $amt     = $pay_tabs_response->amount;
                    $table_data['tokenid'] = $txn_id;
                $table_data['subscriber_id'] = $user_id;
                $table_data['payment_details'] = $amt;
                $table_data['subscription_date'] = date('Y-m-d H:i:s');
                $new_details['subscriber_id']  = $user_id;
               $new_details['subscription_id']  = $subscription_id;
                $this->db->select('duration');
       $feerecord = $this->db->get_where('subscription_fee',array('id'=>$subscription_id))->row_array();
       $duration=$feerecord['duration']*30;
          $new_details['subscription_date'] = date('Y-m-d H:i:s');
          $subsdt=date('Y-m-d H:i:s');
           $new_details['expiry_date_time'] =  date('Y-m-d H:i:s',strtotime(date("Y-m-d  H:i:s", strtotime($subsdt)) ." +".$duration."days"));
           $this->db->where('subscriber_id', $user_id);
          $count = $this->db->count_all_results('subscription_details');
          if($count == 0){
            $this->db->insert('subscription_details', $new_details);
        $table_data['sub_id'] = $this->db->insert_id();


          }else{

            $this->db->where('subscriber_id', $user_id);
            $this->db->update('subscription_details', $new_details);

        $this->db->where('subscriber_id', $user_id);
            $details_sub = $this->db->get('subscription_details')->row_array();
        $table_data['sub_id'] = $details_sub['id'];
          }
                    if($this->db->insert('subscription_payment',$table_data)){

                        $message = (!empty($this->user_language[$this->user_selected]['lg_wallet_amount_add_wallet'])) ? $this->user_language[$this->user_selected]['lg_wallet_amount_add_wallet'] : $this->default_language['en']['lg_wallet_amount_add_wallet'];
                        $this->session->set_flashdata('msg_success', $message);
                       redirect('subscription-list');
                    } else {
                        $message = (!empty($this->user_language[$this->user_selected]['lg_something_went_wrong'])) ? $this->user_language[$this->user_selected]['lg_something_went_wrong'] : $this->default_language['en']['lg_something_went_wrong'];
                        $this->session->set_flashdata('msg_error', $message);
                        redirect('subscription-list');
                    }
                }
            } else {
                $message = (!empty($this->user_language[$this->user_selected]['lg_something_went_wrong'])) ? $this->user_language[$this->user_selected]['lg_something_went_wrong'] : $this->default_language['en']['lg_something_went_wrong'];
                $this->session->set_flashdata('msg_error', $message);
                 redirect('subscription-list');
            }
        }
    }
  public function razor_payment_success()
    { 
        $params = $this->input->post();
        if (!empty($params)) {
            $amount        = $params['totalAmount'];
            $user_id       = $this->session->userdata('user_id');
            $user          = $this->db->where('user_id', $user_id)->get('users')->row_array();
            $user_name     = $user['username'];
            $user_token    = $user['unique_code'];
            $currency_type = $user['currency_code'];
      $history_pay['token']=$user_token;
      $history_pay['subscriber_id']=$user_id;
      $history_pay['currency_code']='INR';
      $history_pay['transaction_id']=$params['razorpay_payment_id'];
      $history_pay['paid_status']='1';
      $history_pay['total_amt']=$this->input->post('totalAmount');
      $history_pay['subscription_id']=$this->input->post('product_id');
     $this->db->select('duration');
       $feerecord = $this->db->get_where('subscription_fee',array('id'=>$params['product_id']))->row_array();
       $duration = $feerecord['duration']*30;
   
        $subscription_date = date('Y-m-d H:i:s');
        $expiry_date_time =  date('Y-m-d H:i:s',strtotime(date("Y-m-d  H:i:s", strtotime($subscription_date)) ." +".$duration."days"));


       $new_details['subscriber_id']  = $user_id;
       $new_details['subscription_id']  = $this->input->post('product_id');
       $new_details['subscription_date'] = $subscription_date;
       $new_details['expiry_date_time'] = $expiry_date_time;

      $this->db->where('subscriber_id', $user_id);
          $count = $this->db->count_all_results('subscription_details');
          if($count == 0){
            $this->db->insert('subscription_details', $new_details);
        $history_pay['sub_id'] = $this->db->insert_id();
          }else{

            $this->db->where('subscriber_id', $user_id);
            $this->db->update('subscription_details', $new_details);

        $this->db->where('subscriber_id', $user_id);
            $details_sub = $this->db->get('subscription_details')->row_array();
        $history_pay['sub_id'] = $details_sub['id'];
          }
      $history_pay['reason']='Subscription';
      $history_pay['created_at']=date('Y-m-d H:i:s');
      $history_pay['subscriber_id']  = $user_id;
        $history_pay['subscription_date'] = date('Y-m-d H:i:s');
      if($this->db->insert('subscription_payment',$history_pay)){
        echo 0;                
      }else{
        echo 1;                
      }         
        }
    
    }
  public function razorthankyou(){
    $result = $_REQUEST['res'];
    if ($result == 0) {
      $message = (!empty($this->user_language[$this->user_selected]['lg_wallet_amount_add_wallet'])) ? $this->user_language[$this->user_selected]['lg_wallet_amount_add_wallet'] : $this->default_language['en']['lg_wallet_amount_add_wallet'];
      $this->session->set_flashdata('msg_success', 'You have subscribed Successfully!');
      redirect('subscription-list');
    } else {
      $message = (!empty($this->user_language[$this->user_selected]['lg_something_went_wrong'])) ? $this->user_language[$this->user_selected]['lg_something_went_wrong'] : $this->default_language['en']['lg_something_went_wrong'];
      $this->session->set_flashdata('message', 'Sorry, something went wrong');
      redirect('subscription-list');
    }
  }



  public function stripe_payment(){
    $inputs = array();
    $sub_id = $this->input->post('sub_id'); // Package ID
    $records = $this->subscription->get_subscription($sub_id);
    $inputs['subscription_id'] = $sub_id;
    $inputs['user_id'] = $this->session->userdata('user_id');
    $inputs['token'] = $this->input->post('tokenid');

     $this->load->library('stripe');
     $charges_array = array();
     $amount = (!empty($records['fee']))?$records['fee']:2;
     $amountval = ($amount*100);
     $charges_array['amount']       = $amountval;
     $charges_array['currency']     = settings('default_currency');
     $charges_array['description']  = (!empty($records['subscription_name']))?$records['subscription_name']:'Subscription';
     $charges_array['source']       = 'tok_visa';


     $striperesult = $this->stripe->stripe_charges($charges_array);

     
     
     $result = json_decode($striperesult,true);
      if(empty($result['error'])){
        $inputs['token'] = $result['id'];
        $inputs['args'] = json_encode($result);
    $result = $this->subscription->subscription_success($inputs);
    if($result){
      $message=$this->web_validation_array['lg7_you_have_been_s'];
      $this->session->set_flashdata('success_message', 'You have Subscribed Successfully!');
          }else{
              
      $message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'];
      $this->session->set_flashdata('error_message',$message);
    }
      }else{

        $inputs['token'] = 'Issue - token_already_used';
        $message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'];
        $this->session->set_flashdata('error_message',$striperesult);
      }
    echo json_encode($result);
  }

  public function stripe_payments(){
    $inputs = array();
    $sub_id = $this->input->post('sub_id'); // Package ID
    $records = $this->subscription->get_subscription($sub_id);
    $inputs['subscription_id'] = $sub_id;
    $inputs['user_id'] = $this->session->userdata('user_id');
   
      
        $inputs['token'] = 'Free subscription';
        $inputs['args'] = '';
    $result = $this->subscription->subscription_success($inputs);
    if($result){
     
      $message=$this->web_validation_array['lg7_you_have_been_s'];
      $this->session->set_flashdata('success_message',$message);
          }else{
          
      $message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'];
      $this->session->set_flashdata('error_message',$message);
    }
     
    echo json_encode($result);
  }
  public function offlinepayment($sub_id)
  {
   $params = $this->input->post();
    if ($this->input->post('form_submit')) {
      $user_id       = $this->session->userdata('user_id');
      $user          = $this->db->where('user_id', $user_id)->get('users')->row_array();

      $uploaded_file_name = '';
      if(!is_dir('uploads/offline')) {
        mkdir('./uploads/offline/', 0777, TRUE);
      }
      if (isset($_FILES) && isset($_FILES['offline_doc']['name']) && !empty($_FILES['offline_doc']['name'])) {
        $uploaded_file_name = $_FILES['offline_doc']['name'];
        $uploaded_file_name_arr = explode('.', $uploaded_file_name);
        $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
        $this->load->library('common');
        $upload_sts = $this->common->global_file_upload('uploads/offline/', 'offline_doc', time() . $filename);

        if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
          $uploaded_file_name = $upload_sts['data']['file_name'];

          if (!empty($uploaded_file_name)) {
              $image_url = 'uploads/offline/' . $uploaded_file_name;   
         }
        }
      }
     

     $details = array(
          'bank_name'=>$this->input->post('bank_name'), 
          'holder_name'=>$this->input->post('holder_name'),
          'account_num' => $this->input->post('account_num'),
          'ifsc_code' => $this->input->post('ifsc_code'),
          'branch_name'=>$this->input->post('branch_name'),
          'upi_id'=>$this->input->post('upi_id'),
          );

    $result = json_encode($details,true);
    $table_data = $image_url;
    $history_pay['subscriber_id']  = $user_id;
    $history_pay['subscription_date'] = date('Y-m-d H:i:s');
    $history_pay['tokenid'] = 'Offline Payment';
    $history_pay['payment_details'] = $result;
    $history_pay['upload_doc'] = $image_url;
    $history_pay['subscription_id'] =  $sub_id;
    $history_pay['status'] = 1;
   //subscription_details insert 
   $this->db->select('duration');
   $feerecord = $this->db->get_where('subscription_fee',array('id'=>$sub_id))->row_array();
   $duration = $feerecord['duration']*30;

   $subscription_date = date('Y-m-d H:i:s');
   $expiry_date_time =  date('Y-m-d H:i:s',strtotime(date("Y-m-d  H:i:s", strtotime($subscription_date)) ." +".$duration."days"));
   $new_details['subscriber_id']  = $user_id;
   $new_details['subscription_id']  = $sub_id;
   $new_details['subscription_date'] = $subscription_date;
   $new_details['expiry_date_time'] = $expiry_date_time;

  $this->db->where('subscriber_id', $user_id);
      $count = $this->db->count_all_results('subscription_details');
      if($count == 0){
        $this->db->insert('subscription_details', $new_details);
    $history_pay['sub_id'] = $this->db->insert_id();
      }else{

        $this->db->where('subscriber_id', $user_id);
        $this->db->update('subscription_details', $new_details);
    $this->db->where('subscriber_id', $user_id);
        $details_sub = $this->db->get('subscription_details')->row_array();
    $history_pay['sub_id'] = $details_sub['id'];
      }
/*          echo "<pre>";print_r($history_pay);exit;
*/
    //subscription_payment insert
    $result=$this->db->insert('subscription_payment',$history_pay);
    if($result){
      $message='Waiting for admin approval';
      $this->session->set_flashdata('success_message',$message);
          }else{
      $message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'];
      $this->session->set_flashdata('error_message',$message);
    }
/*      echo $this->db->last_query();exit;
*/      
    redirect(base_url('subscription-list'));
    }
    $this->data['page'] = 'offline_payment';
    $this->data['model'] = 'subscription';
    $this->load->vars($this->data);
    $this->load->view('template');
  }

}
