<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
         error_reporting(0);
        $this->data['theme']  = 'admin';
        $this->data['model'] = 'dashboard';
        $this->load->model('dashboard_model','dashboard');
        $this->load->model('common_model','common_model');
        $this->data['view'] = 'admin';
        $this->data['base_url'] = base_url();
        $this->load->helper('user_timezone');

    }

	public function index()
	{
    if($this->session->userdata('admin_id'))
		{
  		$this->data['page'] = 'index';
  		$this->data['model'] = 'dashboard';
  		$this->data['requests'] = $this->dashboard->total_requests();
  		$this->data['providers'] = $this->dashboard->total_providers();
      $proposed_fee = $this->dashboard->total_revenue();
      $fee = $proposed_fee['proposed_fee'];
      if(empty($fee))
      {
        $fee = 0;
      }
  		$this->data['revenue'] = $fee;
  		$this->data['pending'] = $this->dashboard->total_pending_providers();
      $results = $this->dashboard->get_setting_list();
        foreach ($results AS $config) {
          $this->data[$config['key']] = $config['value'];
      }
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}
	}

  public function users($value='')
  {
      $this->common_model->checkAdminUserPermission(7);

      $this->data['page'] = 'users';
      $this->data['model'] = 'dashboard';
      $this->load->vars($this->data);
      $this->load->view('template');
  }

  public function users_list($value='')
  {
    $this->common_model->checkAdminUserPermission(7);
      $lists = $this->dashboard->users_list();
          $data = array();
          $no = $_POST['start'];
          foreach ($lists as $template) {
              $no++;
              $row    = array();
              $row[]  = $no;
              $profile_img = $template->profile_img;
              if(empty($profile_img)){
                $profile_img = 'assets/img/user.jpg';
              }
              $row[]  = '<a href="javascript:void(0)" class="avatar"> <img alt="" src="'.$profile_img.'"></a>
                        <h2><a>'.str_replace('-', ' ', $template->username).'</a></h2>';

              $row[]  = $template->email;
               $row[]  = $template->mobile_no;
              $date_format = $this->db->get_where('system_settings',array('key' => 'date_format'))->row()->value;
              $created_date='-';
              if (isset($template->last_login)) {
                 if (!empty($template->last_login) && $template->last_login != "0000-00-00 00:00:00") {
                   $date_time = $template->last_login;
                   $date_time = utc_date_conversion($date_time);
                   $created_date = date($date_format, strtotime($date_time));
                 }
               }
               $signup_date='-';
              if (isset($template->signup_date)) {
                 if (!empty($template->signup_date) && $template->signup_date != "0000-00-00 00:00:00") {
                   $date_time = $template->signup_date;
                   $date_time = utc_date_conversion($date_time);
                   $signup_date = date($date_format, strtotime($date_time));
                 }
               }
              $row[]  = $template->subscription_name;
              $row[]  = $signup_date;
              $row[]  = $created_date;

              if($template->is_active==0) $val='checked';
              else $val='checked';


              if($template->role==1) $row[] ='';
              else
              {

                 $row[] ='<label class="switch toggle-small"><input type="checkbox" '.$val.' id="status_'.$template->user_id.'" data-on="Active" data-off="Inactive" onchange="change_Status('.$template->user_id.')"><span class="slider round" data-size="mini"></span></label>';
              }
              $base_url="ll".base_url()."ll--";
              $row[]='<a data-toggle="modal" href="#" class="table-action-btn " onclick="delete_userlist('.$template->user_id.')" data-userid="'.$template->user_id.'" title="Delete"><i class="fas fa-trash-alt text-danger "></i></a>';



              $data[] = $row;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->dashboard->users_list_all(),
                        "recordsFiltered" => $this->dashboard->users_list_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);


  }
    public function delete_userlist() {
        $this->common_model->checkAdminUserPermission(7);
        $id=$this->input->post('userid');

        $this->db->where('user_id',$id);
        $this->db->delete('users');
        if($this->db->delete('users')) {
           $this->session->set_flashdata('success_message','Users deleted successfully');
           redirect(base_url()."users");
        } else {
            $this->session->set_flashdata('error_message','Something wrong, Please try again');
            redirect(base_url()."users");

        }
    }


   public function change_Status()
  {
    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('user_id',$id);
    $this->db->update('users',array('is_active' =>$status));
  }

  public function provider_request_chart_details()
	{
      $last_request_details = $this->dashboard->last_request_details();
      $last_date = $last_request_details["max(created)"];
      $cur_month = date("Y-m-d" ,strtotime($last_date));
      $full_data = array();
      $provide_data = array();
      $month = "";
      $year = "";
      for($i=0;$i<=4;$i++)
      {
        $date_det = date("Y-m-d", strtotime("-" .$i. " month", strtotime($cur_month)));
        $month = date('m', strtotime($date_det));
        $year = date('Y', strtotime($date_det));
        $request_data = array();
        $request_data["x"] = date("M Y",strtotime($date_det));
        $cur_req_det = $this->dashboard->request_details($month, $year);
        $request_data["y"] = $cur_req_det['tot'];
        $cur_pro_det = $this->dashboard->provider_details($month, $year);
        $request_data["z"] = $cur_pro_det['tot'];
        $full_data[] = $request_data;
      }
      $full_data = array_filter(array_reverse($full_data));
      echo json_encode($full_data);
	}

  public function colour_settings()
  {
            $this->common_model->checkAdminUserPermission(10);

    if($this->session->userdata('admin_id'))
    {
      if($this->input->post())
      {
        $data['morning'] = $this->input->post('morning');
        $data['afternoon'] = $this->input->post('afternoon');
        $data['evening'] = $this->input->post('evening');
        $data['night'] = $this->input->post('night');
        date_default_timezone_set('UTC');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $colour_details = $this->dashboard->colour_settings();
        $colour_id = $colour_details['id'];
        if(empty($colour_details))
        {
          $process_ins = $this->db->insert('colour_settings', $data);
        }
        else
        {
          $process_ins = $this->db->update('colour_settings', $data, array('id', $colour_id));
        }

        if($process_ins) {
          $this->session->set_flashdata('success_message','Colour settings updated successfully');
        }
        else {
          $this->session->set_flashdata('error_message','Something wrong, Please try again');
        }
      }

      $this->data['page'] = 'index';
      $this->data['model'] = 'colour';
      $this->data['list'] = $this->dashboard->colour_settings();
      $this->load->vars($this->data);
      $this->load->view('template');
    }
    else {
      redirect(base_url()."admin");
    }
  }

  public function settings($value='')
  {

      $this->data['page'] = 'index';
      $this->data['model'] = 'settings';
      $this->load->vars($this->data);
      $this->load->view('template');

  }

  public function emailsettings($value='')
  {

  		$this->data['page'] = 'emailsettings';
  		$this->data['model'] = 'settings';
  		$this->load->vars($this->data);
  		$this->load->view('template');

  }

  public function otherSettings() {
        $results = $this->dashboard->get_setting_list();
        foreach ($results AS $config) {
          $this->data[$config['key']] = $config['value'];
        }
        $this->data['page'] = 'other_settings';
        $this->load->vars($this->data);
        $this->load->view('template');
    }
}
