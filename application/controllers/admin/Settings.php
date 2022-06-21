<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

 public $data;

 public function __construct() {

  parent::__construct();
  $this->data['model'] = 'settings';
  $this->load->model('dashboard_model','dashboard');
          $this->load->model('common_model','common_model');
  $this->load->model('admin_model', 'admin');
  $this->data['view'] = 'admin';
  $this->data['base_url'] = base_url();
  $this->load->helper('user_timezone');

  $this->load->helper('ckeditor');
    $this->data['ckeditor_editor1'] = array(
      'id'   => 'ck_editor_textarea_id',
      'path' => 'assets/js/ckeditor',
      'config' => array(
        'toolbar'           => "Full",
        'filebrowserBrowseUrl'      => base_url() . 'assets/js/ckfinder/ckfinder.html',
        'filebrowserImageBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Images',
        'filebrowserFlashBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Flash',
        'filebrowserUploadUrl'      => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        'filebrowserImageUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        'filebrowserFlashUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
      )
        );
        $this->data['ckeditor_editor2'] = array(
      'id'   => 'ck_editor_textarea_id1',
      'path' => 'assets/js/ckeditor',
      'config' => array(
        'toolbar'           => "Full",
        'filebrowserBrowseUrl'      => base_url() . 'assets/js/ckfinder/ckfinder.html',
        'filebrowserImageBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Images',
        'filebrowserFlashBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Flash',
        'filebrowserUploadUrl'      => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        'filebrowserImageUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        'filebrowserFlashUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
      )
        );
        $this->data['ckeditor_editor3'] = array(
      'id'   => 'ck_editor_textarea_id2',
      'path' => 'assets/js/ckeditor',
      'config' => array(
        'toolbar'           => "Full",
        'filebrowserBrowseUrl'      => base_url() . 'assets/js/ckfinder/ckfinder.html',
        'filebrowserImageBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Images',
        'filebrowserFlashBrowseUrl' => base_url() . 'assets/js/ckfinder/ckfinder.html?Type=Flash',
        'filebrowserUploadUrl'      => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        'filebrowserImageUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        'filebrowserFlashUploadUrl' => base_url() . 'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
      )
    );
}

public function index ()
{ 
   $this->common_model->checkAdminUserPermission(14);
  if ($this->input->post('form_submit')) {
   if($data){
    $table_data=array();

        # stripe_option // 1 SandBox, 2 Live 
        # stripe_allow  // 1 Active, 2 Inactive  

    $live_publishable_key = $live_secret_key = $secret_key = $publishable_key = '';
    
    $query = $this->db->query("SELECT * FROM payment_gateways WHERE status = 1");
    $stripe_details = $query->result_array();
    if(!empty($stripe_details)){
      foreach ($stripe_details as $details) {
        if(strtolower($details['gateway_name']) == 'stripe'){
          if(strtolower($details['gateway_type'])=='sandbox'){
            
            $publishable_key    = $details['api_key'];
            $secret_key       = $details['value'];  
          }
          if(strtolower($details['gateway_type'])=='live'){
            $live_publishable_key = $details['api_key'];
            $live_secret_key    = $details['value'];
          }
        }
      }
    }
    
    $data['publishable_key']    = $publishable_key;
    $data['secret_key']       = $secret_key;
    $data['live_publishable_key'] = $live_publishable_key;
    $data['live_secret_key']    = $live_secret_key; 

    foreach ($data AS $key => $val) {
      if($key!='form_submit'){
        $this->db->where('key', $key);
        $this->db->delete('system_settings');
        $table_data['key']        = $key;
        $table_data['value']      = $val;
        $table_data['system']      = 1;
        $table_data['groups']      = 'config';
        $table_data['update_date']  = date('Y-m-d');
        $table_data['status']       = 1;
    
        $this->db->insert('system_settings', $table_data);
      }
    }
  }                         
  $message = '';
  if (!empty($error)) {
    
   $message.='<hr/><div class="alert alert-danger text-center in" id="flash_error_message">Image uploading failed '.$error.'</div>';
 }else{

  $message='<div class="alert alert-success text-center in" id="flash_succ_message">Settings saved successfully.</div>';
}
$this->session->set_flashdata('message',$message);
redirect(base_url('admin/settings'));


}
$results = $this->dashboard->get_setting_list();
$this->data['currency_list'] = $this->dashboard->get_setting_list();
foreach ($results AS $config) {
  $this->data[$config['key']] = $config['value'];
}
$this->data['currency'] = $this->db->where('status', 1)->get('currency')->result_array();

$this->data['page'] = 'index';
$this->data['model'] = 'settings';
$this->load->vars($this->data);
$this->load->view('template');
}


public function emailsettings ()
{
  $this->common_model->checkAdminUserPermission(14);
  if ($this->input->post('form_submit')) {
    $this->load->library('upload');
    $data = $this->input->post();
    if($data){
      $table_data= array();
      foreach ($data AS $key => $val) {
        if($key!='form_submit'){
          $this->db->where('key', $key);
          $this->db->delete('system_settings');
          $table_data['key']        = $key;
          $table_data['value']      = $val;
          $table_data['system']      = 1;
          $table_data['groups']      = 'config';
          $table_data['update_date']  = date('Y-m-d');
          $table_data['status']       = 1;
          $this->db->insert('system_settings', $table_data);
          
        }
      }
    }                         
    $this->session->set_flashdata('success_message', 'Settings saved successfully');
    redirect(base_url() . 'admin/emailsettings/');
  }
  
  $results = $this->dashboard->get_setting_list();
  foreach ($results AS $config) {
    $this->data[$config['key']] = $config['value'];
  }  
  $this->data['page'] = 'emailsettings';
  $this->data['model'] = 'settings';
  $this->load->vars($this->data);
  $this->load->view('template');
}
public function razor_payment_gateway() {    
          $this->common_model->checkAdminUserPermission(14);

   if ($this->input->post('form_submit')) {
            if ($this->data['admin_id'] > 1) {
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
                redirect(base_url() . 'admin/razor_payment_gateway');
            } else {
                $data['sandbox_email']    = $this->input->post('sandbox_email');
                $data['sandbox_secretkey'] = $this->input->post('sandbox_secretkey');
                $data['email']            = $this->input->post('email');
                $data['secretkey']         = $this->input->post('secretkey');
                $data['gateway_type']         = $this->input->post('razorpay_gateway_type');
                $data['status'] = !empty($this->input->post('razorpay_show'))?$this->input->post('razorpay_show'):0;
                $query                    = $this->db->query("SELECT * FROM razorpay_gateway");
                $result                   = $query->row_array();
                if (!empty($result)) {
                    $this->db->where('id', '1');
                    $this->db->update('razorpay_gateway', $data);
                } else {
                    $this->db->insert('razorpay_gateway', $data);
                }   
                $this->session->set_flashdata('success_message', 'Payment gateway edit successfully');
                redirect(base_url() . 'admin/razor_payment_gateway/');
            }
        }
  $this->data['page'] = 'razor_payment_gateway';
  $this->data['model'] = 'settings';
  $this->data['list'] = $this->dashboard->edit_razorpay_settings();
  $this->load->vars($this->data);
  $this->load->view('template');
} 

public function paytab_payment_gateway() {   
          $this->common_model->checkAdminUserPermission(14);

  if ($this->input->post('form_submit')) {
            if ($this->data['admin_id'] > 1) {
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
                redirect(base_url() . 'admin/paytab_payment_gateway');
            } else {
                $data['sandbox_email']    = $this->input->post('sandbox_email');
                $data['sandbox_secretkey'] = $this->input->post('sandbox_secretkey');
                $data['email']            = $this->input->post('email');
                $data['secretkey']         = $this->input->post('secretkey');
                $data['gateway_type']         = $this->input->post('paytab_gateway_type');
                $data['status'] = !empty($this->input->post('paytab_show'))?$this->input->post('paytab_show'):0;
                $query                    = $this->db->query("SELECT * FROM paytabs_details");
                $result                   = $query->row_array();
                if (!empty($result)) {
                    $this->db->where('id', '1');
                    $this->db->update('paytabs_details', $data);
                } else {
                    $this->db->insert('paytabs_details', $data);
                }   
                $this->session->set_flashdata('success_message', 'Payment gateway edit successfully');
                redirect(base_url() . 'admin/paytab_payment_gateway/');
               
            }
        }
  
  $this->data['page'] = 'paytab_payment_gateway';
  $this->data['model'] = 'settings';
  $this->data['list'] = $this->dashboard->edit_paytab_settings();
  $this->load->vars($this->data);
  $this->load->view('template');
} 
public function stripe_payment_gateway() {   
          $this->common_model->checkAdminUserPermission(14);

  
  $this->data['page'] = 'stripe_payment_gateway';
  $this->data['model'] = 'settings';
  $this->data['list'] = $this->dashboard->all_payment_gateway();
  $this->load->vars($this->data);
  $this->load->view('template');
} 
public function offline_payment() {   
  $this->common_model->checkAdminUserPermission(14);
  if ($this->input->post('form_submit')) {
    $data['bank_name']    = $this->input->post('bank_name');
    $data['holder_name'] = $this->input->post('holder_name');
    $data['account_num']            = $this->input->post('account_num');
    $data['ifsc_code']         = $this->input->post('ifsc_code');
    $data['branch_name']            = $this->input->post('branch_name');
    $data['upi_id']         = $this->input->post('upi_id');
    $data['status'] = !empty($this->input->post('offline_show'))?$this->input->post('offline_show'):0;
    $data['created_datetime'] =date('Y-m-d H:i:s');
    $data['updated_datetime'] =date('Y-m-d H:i:s');
    $query                    = $this->db->query("SELECT * FROM offline_payment");
    $results                   = $query->row_array();
    if (!empty($results)) {
        $this->db->where('id', '1');
        $this->db->update('offline_payment', $data);
    } else {
        $this->db->insert('offline_payment', $data);
    }   
    $this->session->set_flashdata('success_message', 'Offline Payment edit successfully');
    redirect(base_url() . 'admin/offlinepayment/');  
  }
  $results = $this->dashboard->get_setting_list();
  foreach ($results AS $config) {
    $this->data[$config['key']] = $config['value'];
  }
  $this->data['page'] = 'offline_payment';
  $this->data['model'] = 'settings';
  $this->data['list'] = $this->dashboard->all_payment_gateway();
  $this->load->vars($this->data);
  $this->load->view('template');
} 
 public function offlinepaymentdetails()
  {
    $this->data['list'] = $this->admin->result_getall();
/*    echo '<pre>';print_r($data['query']);exit;
*/    $this->data['page'] = 'offline_payment_details';
    $this->data['model'] = 'settings';
    $this->load->vars($this->data);
    $this->load->view('template');
  }
 public function offline_status(){
      $id=$this->input->post('status_id');
      $table_data['status'] =$this->input->post('status');
      $this->db->where('id',$id);
      if($this->db->update('subscription_payment',$table_data)){ 
        echo "success";
      } else {
        echo "error";
      }
    }
public function paypal_payment_gateway() {      
            $this->common_model->checkAdminUserPermission(14);

  if ($this->input->post('form_submit')) {
            if ($this->data['admin_id'] > 1) {
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
                redirect(base_url() . 'admin/paypal_settings');
            } else {
                $data['sandbox_email']    = $this->input->post('sandbox_email');
                $data['sandbox_password'] = $this->input->post('sandbox_password');
                $data['email']            = $this->input->post('email');
                $data['password']         = $this->input->post('password');
                $data['sandbox_paypal_secret_key']            = $this->input->post('sandbox_paypal_secret_key');
                $data['braintree_key']         = $this->input->post('braintree_key');
                $data['braintree_merchant']         = $this->input->post('braintree_merchant');
                $data['braintree_publickey']         = $this->input->post('braintree_publickey');
                $data['braintree_privatekey']         = $this->input->post('braintree_privatekey');


                $data['live_paypal_secret_key']         = $this->input->post('live_paypal_secret_key');
                $data['gateway_type']         = $this->input->post('gateway_type');
                $data['status'] = !empty($this->input->post('paypal_show'))?$this->input->post('paypal_show'):0;
                $query                    = $this->db->query("SELECT * FROM paypal_details");
                $result                   = $query->row_array();
                if (!empty($result)) {
                    $this->db->where('id', '1');
                    $this->db->update('paypal_details', $data);
                } else {
                    $this->db->insert('paypal_details', $data);
                }   
                 $this->session->set_flashdata('success_message', 'Payment gateway edit successfully');
                redirect(base_url() . 'admin/paypal_payment_gateway/');
            }
        }
  
  $this->data['page'] = 'paypal_payment_gateway';
  $this->data['model'] = 'settings';
  $this->data['list'] = $this->dashboard->edit_paypal_settings();
  $this->load->vars($this->data);
  $this->load->view('template');
} 

public function edit($id)
{
            $this->common_model->checkAdminUserPermission(14);

  if($this->input->post('form_submit')) 
  {

    $data['gateway_name'] = $this->input->post('gateway_name');
    $data['gateway_type'] = $this->input->post('gateway_type');
    $data['api_key'] = $this->input->post('api_key');
    $data['value'] = $this->input->post('value');
    $data['status'] = !empty($this->input->post('stripe_show'))?$this->input->post('stripe_show'):0;
    $this->db->where('id',$id);
    if($this->db->update('payment_gateways',$data))
    {
      if($this->input->post('gateway_type')=='sandbox')
      {
        $datass['publishable_key']  = $this->input->post('api_key');
        $datass['secret_key']  = $this->input->post('value');
        
      }
      else
      {
        $datass['live_publishable_key'] = $this->input->post('api_key');
        $datass['live_secret_key']   = $this->input->post('value');
        
      }
      
      foreach ($datass AS $key => $val) {
        $this->db->where('key', $key);
        $this->db->delete('system_settings');
        $table_data['key']        = $key;
        $table_data['value']      = $val;
        $table_data['system']      = 1;
        $table_data['groups']      = 'config';
        $table_data['update_date']  = date('Y-m-d');
        $table_data['status']       = 1;
        $this->db->insert('system_settings', $table_data);
      }

    }
    $this->session->set_flashdata('success_message', 'Payment gateway edit successfully');
    redirect(base_url() . 'admin/stripe_payment_gateway');
      
  }

  $this->data['list'] =  $this->dashboard->edit_payment_gateway($id);
  $this->data['model'] = 'settings';
  $this->data['page'] =    'stripe_payment_gateway_edit';
  $this->load->vars($this->data);
  $this->load->view('template');
  
}


 public function analytics() {
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
          if ($data) {
                if (isset($data['analytics_showhide'])) {
                    $data['analytics_showhide'] = '1';
                } else {
                    $data['analytics_showhide'] = '0';
                }
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Google Analytics Details updated successfully');
            redirect(base_url() . 'admin/other-settings');
            }
        }
    }

    public function cookies() {
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
           if ($data) {
                if (isset($data['cookies_showhide'])) {
                    $data['cookies_showhide'] = '1';
                } else {
                    $data['cookies_showhide'] = '0';
                }
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Cookies Agreement Details updated successfully');
            redirect(base_url() . 'admin/other-settings');
            }
        }
    }

     public function seoSetting() {
         if($this->input->post("form_submit") == true) {
            $data = $this->input->post();
            $table_data = array();
            foreach ($data AS $key => $val) {
                if ($key != 'form_submit') {
                    $data_details = $this->db->get_where('system_settings', array('key'=>$key))->row();
                    $table_data = array(
                        'key' => $key,
                        'value' => $val,
                        'system' => 1,
                        'groups' => 'config',
                        'update_date' => date('Y-m-d'),
                        'status' => 1
                    );
                    if(empty($data_details)) {
                        $this->db->insert('system_settings', $table_data);
                    } else {
                        $where = array('key' => $key);
                        $this->db->update('system_settings', $table_data, $where);
                    }
                    
                }
            }
            
           $this->session->set_flashdata('success_message', 'Details updated successfully');
            redirect(base_url() . 'admin/seo-settings');
        }
        $results = $this->dashboard->get_setting_list();
        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }
        $this->data['page'] = 'seo_settings';
        $this->load->vars($this->data);
        $this->load->view('template');
    }

     public function systemSetting() {
        if($this->input->post('form_submit') == true) {
            $map_details = $this->db->get_where('system_settings', array('key'=>'map_key'))->row();
            $apikey_details = $this->db->get_where('system_settings', array('key'=>'firebase_server_key'))->row();

            if($this->input->post('map_key')) {
                if(empty($map_details)) {
                    $table_data['key'] = 'map_key';
                    $table_data['value'] = $this->input->post('map_key');
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                } else {
                    $where = array('key' => 'map_key');
                    $table_data['key'] = 'map_key';
                    $table_data['value'] = $this->input->post('map_key');
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->admin->update_data('system_settings', $table_data, $where);
                }
            }
            if($this->input->post('firebase_server_key')) {
                if(empty($apikey_details)) {
                    $table_data['key'] = 'firebase_server_key';
                    $table_data['value'] = $this->input->post('firebase_server_key');
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->db->insert('system_settings', $table_data);
                } else {
                    $where = array('key' => 'firebase_server_key');
                    $table_data['key'] = 'firebase_server_key';
                    $table_data['value'] = $this->input->post('firebase_server_key');
                    $table_data['system'] = 1;
                    $table_data['groups'] = 'config';
                    $table_data['update_date'] = date('Y-m-d');
                    $table_data['status'] = 1;
                    $this->admin->update_data('system_settings', $table_data, $where);
                }
            }
            $this->session->set_flashdata('success_message', 'Details updated successfully');
            redirect(base_url() . 'admin/system-settings');
        }
        $results = $this->dashboard->get_setting_list();
        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }
     
        $this->data['page'] = 'system_settings';
        $this->load->vars($this->data);
        $this->load->view('template');
    }

    public function localization() {
         $data = $this->input->post();
        if ($this->input->post('form_submit')) {
            $country_key = $this->db->get_where('country_table', array('country_id'=>$data['countryCode']))->row()->country_code;
            $data['country_code_key'] = strtolower($country_key);
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                        
                    }
                }

             if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'Localization updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
            } else {
                $this->session->set_flashdata('error_message', 'Something went wront, Try again');
                redirect($_SERVER["HTTP_REFERER"]);
            }
            }
            $results = $this->dashboard->get_setting_list();
            foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
            }
        $this->data['currency_symbol'] = currency_code_symbol();
        $this->data['page'] = 'localization';
        $this->load->vars($this->data);
        $this->load->view('template');
    }
    public function get_currnecy_symbol() {
        $code = $this->input->post('id');
        $result = currency_code_sign($code);
        echo $result;
    }

    public function footerSetting() {
        $this->data['page'] = 'footersettings';
        $this->load->vars($this->data);
        $this->load->view('template');
    }

    public function pages() {
        $this->data['pages'] = $this->db->get('page_content')->result();
        $this->data['page'] = 'page';
        $this->load->vars($this->data);
        $this->load->view('template');
    } 
     public function aboutus($id) {
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 1))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] =date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                    echo $this->db->last_query();exit;
                } else {  
                    $where = array('id' => 1);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] = date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
                $this->session->set_flashdata('success_message', 'About Us updated successfully');
                redirect(base_url() . 'admin/page');
            
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'about-us';
        $this->load->vars($this->data);
        $this->load->view('template');
    } 
    public function cookie_policy($id) {
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 19))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] =date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                } else {  
                    $where = array('id'=> 19);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] = date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
            $this->session->set_flashdata('success_message', 'Cookie Policy updated successfully');
           redirect(base_url() . 'admin/page');
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'cookie_policy';
        $this->load->vars($this->data);
        $this->load->view('template');
    } 
     public function faq_delete() {
        $id = $this->input->post('id');
        $this->db->where('id',$id)->delete('faq');
        $result = $this->db->where('id',$id)->delete('faq');
          if($result){
           $this->session->set_flashdata('success_message', 'FAQ deleted successfully');
            redirect(base_url() . 'admin/page');
          }else{
           $this->session->set_flashdata('error_message', 'Something went wront, Try again');
          redirect(base_url() . 'admin/page');
          }
    }
    public function faq($id) {
        $titles = $this->input->post('page_title');
        $cont = $this->input->post('page_content'); 
        $faq_id = $this->input->post('faq_id'); 
        if($this->input->post("form_submit") == true) {
           foreach ($titles as $key => $value) {
                $data = array(  
                    'page_title'     => $value,
                    'page_content'  => $cont[$key],  
                    'status'   =>1,  
                    'created_datetime' =>date('Y-m-d H:i:s') 
                    );  

                 if (empty($faq_id[$key])) {
                    
                    $this->db->insert('faq', $data);
                }else {
                    $where = array('id'=> $faq_id[$key]);
                    $this->db->update('faq', $data ,$where);
               }

            }
            $this->session->set_flashdata('success_message', 'FAQ updated successfully');
           redirect(base_url() . 'admin/page');
            
        }
               
        $this->data['pages']=$this->admin->getting_faq_list();
        $this->data['page'] = 'faq';
        $this->load->vars($this->data);
        $this->load->view('template');
    }
    public function help($id) {
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 14))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] =date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                } else {  
                    $where = array('id'=> 14);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] = date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
          $this->session->set_flashdata('success_message', 'Help updated successfully');
         redirect(base_url() . 'admin/page');
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'help';
        $this->load->vars($this->data);
        $this->load->view('template');
    } 
    public function privacy_policy($id) {
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 15))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] =date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                } else {  
                    $where =array('id'=> 15);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] =date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
            $this->session->set_flashdata('success_message', 'Privacy Policy updated successfully');
           redirect(base_url() . 'admin/page');
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'privacy_policy';
        $this->load->vars($this->data);
        $this->load->view('template');
    } 
     public function terms_of_services($id) {
        $title = $this->input->post('page_title');
        if($this->input->post("form_submit") == true) {
            $page_title = $this->db->get_where('page_content', array('id'=> 16))->row();

            if(empty($page_title)) {
                
                    $table_data['page_title'] = $this->input->post('page_title');
                    $terms_slug = preg_replace('/[^A-Za-z0-9\-]/', '-', $table_data['page_title']);
                    $table_data['page_slug'] = strtolower($terms_slug);
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['status'] = 1;
                    $table_data['created_datetime'] = date('Y-m-d H:i:s');
                    $this->db->insert('page_content', $table_data);
                } else {  
                    $where = array('id'=> 16);
                    $table_data['page_title'] = $this->input->post('page_title');
                    $table_data['page_content'] = $this->input->post('page_content');
                    $table_data['updated_datetime'] = date('Y-m-d H:i:s');
                    $this->admin->update_data('page_content', $table_data, $where);
                }
           
          $this->session->set_flashdata('success_message', 'Terms Of Services updated successfully');
         redirect(base_url() . 'admin/page');
            
        }
        $this->data['pages']=$this->admin->getting_pages_list($id);
        $this->data['page'] = 'terms_of_services';
        $this->load->vars($this->data);
        $this->load->view('template');
    } 
    public function home_page() {
     $this->data['list'] = $this->admin->GetBannersettings();
      $results = $this->dashboard->get_setting_list();
        foreach ($results AS $config) {
            $this->data[$config['key']] = $config['value'];
        }
        $this->data['page'] = 'home_page';
        $this->load->vars($this->data);
        $this->load->view('template');
    } 
    public function bannersettings() {
        $title = $this->input->post('bgimg_for');
        if($this->input->post("form_submit")) {
            $banner_title = $this->db->get_where('bgimage', array('bgimg_id'=> 1))->row();
            $post_data = $this->input->post();
             $uploaded_file_name = '';
             if(!is_dir('uploads/banners')) {
                    mkdir('./uploads/banners/', 0777, TRUE);
                }
            if (isset($_FILES) && isset($_FILES['upload_image']['name']) && !empty($_FILES['upload_image']['name'])) {
                $uploaded_file_name = $_FILES['upload_image']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/banners/', 'upload_image', time() . $filename);

                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];

                    if (!empty($uploaded_file_name)) {
                        $image_url = 'uploads/banners/' . $uploaded_file_name;   
                 }
                }
            }else {
                $image_url = $banner_title->upload_image;
            }
            $table_data = array(
                'banner_content' => $post_data['banner_content'],
                'banner_sub_content' => $post_data['banner_sub_content'],
                'banner_settings' => ($post_data['banner_showhide'])?'1':'0',
                'main_search' => ($post_data['main_showhide'])?'1':'0',
                'popular_search' => ($post_data['popular_showhide'])?'1':'0',
                'upload_image' => $image_url,
                'popular_label' => $post_data['popular_label']
            );
            if(empty($banner_title)) {
                $table_data['created_datetime'] =date('Y-m-d H:i:s');
                $this->db->insert('bgimage', $table_data);
            } else {  
                $where = array('bgimg_id' => 1);
                $table_data['updated_datetime'] =date('Y-m-d H:i:s');
                $this->admin->update_data('bgimage', $table_data, $where);
                
            }
            $this->session->set_flashdata('success_message', 'Bannersettings Details updated successfully');
            redirect(base_url() . 'admin/page');
        }
    }

    public function howitworks() {
        $data = $this->input->post();
        if ($this->input->post('form_submit')) {
           if ($data) {
                if (isset($data['how_showhide'])) {
                    $data['how_showhide'] = '1';
                } else {
                    $data['how_showhide'] = '0';
                }

                $uploaded_file_name = '';
                 if(!is_dir('uploads/banners')) {
                    mkdir('./uploads/banners/', 0777, TRUE);
                }
                if (isset($_FILES) && isset($_FILES['how_title_img']['name']) && !empty($_FILES['how_title_img']['name'])) {
                    $uploaded_file_name = $_FILES['how_title_img']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'how_title_img', time() . $filename);

                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $image_url_1= 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                }
                else {
                $how_title_img = $this->db->get_where('system_settings',array('key' => 'how_title_img'))->row()->value;
                $image_url_1 = $how_title_img;
                }
                $data['how_title_img'] = $image_url_1;
                foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'How It Works Details updated successfully');
            redirect(base_url() . 'admin/page');
            }
        }
    }

    public function download_sec() {
         $data = $this->input->post();
        if ($this->input->post('form_submit')) {

            if ($data) {
                if (isset($data['download_showhide'])) {
                    $data['download_showhide'] = '1';
                } else {
                    $data['download_showhide'] = '0';
                }

                $uploaded_file_name = '';
                if(!is_dir('uploads/banners')) {
                    mkdir('./uploads/banners/', 0777, TRUE);
                }
                if (isset($_FILES) && isset($_FILES['app_store_img']['name']) && !empty($_FILES['app_store_img']['name'])) {
                    $uploaded_file_name = $_FILES['app_store_img']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';

                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'app_store_img', time() . $filename);
                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $app_store_img1 = 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                }
                else {
                $app_store_img = $this->db->get_where('system_settings',array('key' => 'app_store_img'))->row()->value;
                $app_store_img1 = $app_store_img;
                }
                $uploaded_file_name = '';
                if(!is_dir('uploads/banners')) {
                    mkdir('./uploads/banners/', 0777, TRUE);
                }
                if (isset($_FILES) && isset($_FILES['play_store_img']['name']) && !empty($_FILES['play_store_img']['name'])) {
                    $uploaded_file_name = $_FILES['play_store_img']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';

                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'play_store_img', time() . $filename);

                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $play_store_img1 = 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                } else {
                $play_store_img = $this->db->get_where('system_settings',array('key' => 'play_store_img'))->row()->value;
                $play_store_img1 = $play_store_img;
                }
                $uploaded_file_name = '';
                if(!is_dir('uploads/banners')) {
                    mkdir('./uploads/banners/', 0777, TRUE);
                }
                if (isset($_FILES) && isset($_FILES['download_right_img']['name']) && !empty($_FILES['download_right_img']['name'])) {
                    $uploaded_file_name = $_FILES['download_right_img']['name'];
                    $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                    $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';

                    $this->load->library('common');
                    $upload_sts = $this->common->global_file_upload('uploads/banners/', 'download_right_img', time() . $filename);

                    if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                        $uploaded_file_name = $upload_sts['data']['file_name'];

                        if (!empty($uploaded_file_name)) {
                            $download_right_img1 = 'uploads/banners/' . $uploaded_file_name;                    }
                    }
                } else {
                $download_right_img = $this->db->get_where('system_settings',array('key' => 'download_right_img'))->row()->value;
                $download_right_img1 = $download_right_img;
                }
                $data['download_right_img'] = $download_right_img1;
                $data['play_store_img'] = $play_store_img1;
                $data['app_store_img'] = $app_store_img1;
                 foreach ($data AS $key => $val) {
                    if ($key != 'form_submit') {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                }
            $this->session->set_flashdata('success_message', 'Download Section Details updated successfully');
            redirect(base_url() . 'admin/page');
            }
        }
    }
      public function page_status(){
        $id=$this->input->post('status_id');
        $table_data['status'] =$this->input->post('status');
        $this->db->where('id',$id);
        if($this->db->update('page_content',$table_data)){ 
          echo "success";
        } else {
          echo "error";
        }
      }

    public function generalSetting() {
    if($this->input->post('form_submit') == true) {
        $this->load->library('upload');
        $data = $this->input->post();
        if (!is_dir('uploads/logo')) {
            mkdir('./uploads/logo', 0777, TRUE);
        }

        if (!is_dir('uploads/placeholder_img')) {
            mkdir('./uploads/placeholder_img', 0777, TRUE);
        }
        if ($_FILES['logo_front']['name']) {
            $table_data1 = [];
            $configfile['upload_path'] = FCPATH . 'uploads/logo';
            $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
            $configfile['overwrite'] = FALSE;
            $configfile['remove_spaces'] = TRUE;
            $file_name = $_FILES['logo_front']['name'];
            $configfile['file_name'] = time() . '_' . $file_name;
            $image_name = $configfile['file_name'];
            $image_url = 'uploads/logo/' . $image_name;
            $this->upload->initialize($configfile);
            if ($this->upload->do_upload('logo_front')) {
                $img_uploadurl = 'uploads/logo' . $_FILES['logo_front']['name'];
                $key = 'logo_front';
                $val = 'uploads/logo/' . $image_name;
                $data['logo_front'] = $val;
            }
        }

        if ($_FILES['favicon']['name']) {
            $table_data1 = [];
            $configfile['upload_path'] = FCPATH . 'uploads/logo';
            $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
            $configfile['overwrite'] = FALSE;
            $configfile['remove_spaces'] = TRUE;
            $file_name = $_FILES['favicon']['name'];
            $configfile['file_name'] = time() . '_' . $file_name;
            $image_name = $configfile['file_name'];
            $image_url = 'uploads/logo/' . $image_name;
            $this->upload->initialize($configfile);
            if ($this->upload->do_upload('favicon')) {
                $img_uploadurl = 'uploads/logo' . $_FILES['favicon']['name'];
                $key = 'favicon';
                $val = $image_name;
                $data['favicon'] = $val;
            }
        }

        if ($data) {
            $table_data = array();
            foreach ($data AS $key => $val) {
                if ($key != 'form_submit') {
                    $data_details = $this->db->get_where('system_settings', array('key'=>$key))->row();
                    if(empty($data_details)) {
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->insert('system_settings', $table_data);
                    } else {
                        $where = array('key' => $key);
                        $table_data['key'] = $key;
                        $table_data['value'] = $val;
                        $table_data['system'] = 1;
                        $table_data['groups'] = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status'] = 1;
                        $this->db->update('system_settings', $table_data, $where);
                    }
                    
                }
            }
            $this->session->set_flashdata('success_message', 'Setting details updated successfully');
            redirect(base_url() . 'admin/general-settings');
        }
    }
    
    $results = $this->admin->get_setting_list();
    foreach ($results AS $config) {
        $this->data[$config['key']] = $config['value'];
    }
    $this->data['page'] = 'general-settings';
    $this->load->vars($this->data);
    $this->load->view('template');
  }






}
