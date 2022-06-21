<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
        $this->load->model('service_model','service');

                $this->load->model('common_model','common_model');

        $this->data['view'] = 'admin';
        $this->data['base_url'] = base_url();
        $this->session->keep_flashdata('error_message');
        $this->session->keep_flashdata('success_message');
        $this->load->helper('user_timezone_helper');

    }

	public function index()
	{
            $this->common_model->checkAdminUserPermission(6);

  		redirect(base_url('subscriptions'));
	}
	public function subscriptions()
	{
                $this->common_model->checkAdminUserPermission(6);

    if($this->session->userdata('admin_id'))
		{
  		$this->data['page'] = 'subscriptions';
  		$this->data['model'] = 'service';
  		$this->data['list'] = $this->service->subscription_list();
      $this->data['defaultcurr']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}
	}

	public function add_subscription()
	{
                $this->common_model->checkAdminUserPermission(6);

    if($this->session->userdata('admin_id'))
		{
  		$this->data['page'] = 'add_subscription';
  		$this->data['model'] = 'service';
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}

	}

  public function check_subscription_name()
  {
    $subscription_name = $this->input->post('subscription_name');
    $id = $this->input->post('subscription_id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('subscription_name', $subscription_name);
      $this->db->where('id !=', $id);
      $this->db->from('subscription_fee');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('subscription_name', $subscription_name);
      $this->db->from('subscription_fee');
      $result = $this->db->get()->num_rows();
    }
    if ($result > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
     ));
  }

  public function save_subscription()
	{
                $this->common_model->checkAdminUserPermission(6);

    $data['subscription_name'] = $this->input->post('subscription_name');
    $data['fee'] = $this->input->post('subscription_amount');
	$defaultcurrency = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
    $data['currency_code'] = $defaultcurrency[0]['value'];
    $data['duration'] = $this->input->post('subscription_duration');
    $data['fee_description'] = $this->input->post('fee_description');
    $data['status'] = $this->input->post('status');
		$result = $this->db->insert('subscription_fee', $data);
		if(!empty($result))
		{
			$this->session->set_flashdata('success_message','Subscription added successfully');
			echo 1;
		}
	 else
		{
      $this->session->set_flashdata('error_message','Something wrong, Please try again');
			echo 2;
		}
	}

	public function edit_subscription($id)
	{
                $this->common_model->checkAdminUserPermission(6);

    if($this->session->userdata('admin_id'))
		{
  		$this->data['page'] = 'edit_subscription';
  		$this->data['model'] = 'service';
      $this->data['subscription'] = $this->service->subscription_details($id);
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}

	}

  public function update_subscription()
	{
                $this->common_model->checkAdminUserPermission(6);

    $where['id'] = $this->input->post('subscription_id');
    $data['subscription_name'] = $this->input->post('subscription_name');
    $data['fee'] = $this->input->post('subscription_amount');
    $defaultcurrency = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
    $data['currency_code'] = $defaultcurrency[0]['value'];
    $data['duration'] = $this->input->post('subscription_duration');
    $data['fee_description'] = $this->input->post('fee_description');
    $data['status'] = $this->input->post('status');
		$result = $this->db->update('subscription_fee', $data, $where);
		if(!empty($result))
		{
			$this->session->set_flashdata('success_message','Subscription updated successfully');
			echo 1;
		}
	 else
		{
      $this->session->set_flashdata('error_message','Something wrong, Please try again');
			echo 2;
		}
	}

  public function delete_subscription($id)
  {
                $this->common_model->checkAdminUserPermission(6);

    $this->db->where('id', $id);
   
    $result = $this->db->delete('subscription_fee');
    if(!empty($result))
    {
      $this->session->set_flashdata('success_message','Subscription deleted successfully');
      redirect(base_url()."subscriptions");
    }
   else
    {
      $this->session->set_flashdata('error_message','Something wrong, Please try again');
      redirect(base_url()."subscriptions");
    }
  }
 
		public function service_providers()
	{
    $this->common_model->checkAdminUserPermission(8);

    if($this->session->userdata('admin_id'))
		{
  		$this->data['page'] = 'service_providers';
  		$this->data['model'] = 'service';
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}

	}

	public function provider_list()
	{
        
        $this->common_model->checkAdminUserPermission(8);

			$lists = $this->service->provider_list();
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
	            $row[]  = '<img class="avatar" alt="" src="'.$profile_img.'"><h2>'.$template->username.'</h2>';
	            $row[]  = $template->contact_number;
              $row[]  = $template->title;
              $date_format = $this->db->get_where('system_settings',array('key' => 'date_format'))->row()->value;
              $created_date='-';
							if (isset($template->created)) {
								 if (!empty($template->created) && $template->created != "0000-00-00 00:00:00") {
									 $date_time = $template->created;
						       $date_time = utc_date_conversion($date_time);
									 $created_date = date($date_format, strtotime($date_time));
								 }
							 }
              $row[]  = $created_date;
              $val = '';
              $status = $template->status;
              $delete_status = $template->delete_status;
              if($status == 0)
              {
                $val = '';
              }
              elseif($status == 1)
              {
                $val = 'checked';
              }
              $row[] ='<label class="switch toggle-small"><input type="checkbox" '.$val.' id="status_'.$template->p_id.'" data-on="Active" data-off="Inactive" onchange="change_Status('.$template->p_id.')"><span class="slider round" data-size="mini"></span></label>';
        
              $row[]='<a href="#" title="Delete" onclick="delete_service('.$template->p_id.')" ><i class="fas fa-trash-alt text-danger"></i></a>';

	            $data[] = $row;
        }
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->service->provider_list_all(), 
                        "recordsFiltered" => $this->service->provider_list_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);

	}
  public function change_Status()
  {
        $this->common_model->checkAdminUserPermission(8);

    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('p_id',$id);
    $this->db->update('provider_details',array('status' =>$status));
  }
  public function delete_provider()
  {
        $this->common_model->checkAdminUserPermission(8);

    $id=$this->input->post('id');
    $this->db->where('p_id',$id);
    if($this->db->update('provider_details',array('delete_status' =>1)))
    {
      echo 1;
    }
  }
	public function service_requests()
	{
        $this->common_model->checkAdminUserPermission(9);

    if($this->session->userdata('admin_id'))
		{
  		$this->data['page'] = 'service_requests';
  		$this->data['model'] = 'service';
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}
	}

  public function request_list()
	{
            $this->common_model->checkAdminUserPermission(9);

			$lists = $this->service->request_list();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($lists as $template) {
	            $no++;
	            $row    = array();
	            $row[]  = $no;
              $profile_img = $template['profile_img'];
              if(empty($profile_img)){
                $profile_img = 'assets/img/user.jpg';
              }
              $date_format = $this->db->get_where('system_settings',array('key' => 'date_format'))->row()->value;
              $time_format = $this->db->get_where('system_settings',array('key' => 'time_format'))->row()->value;
              $currency_symbol = $this->db->get_where('system_settings',array('key' => 'currency_symbol'))->row()->value;
	            $row[]  = '<a href="#" class="avatar"> <img alt="" src="'.$profile_img.'"></a><h2><a href="#">'.$template['username'].'</a></h2>';
	            $row[]  = $template['contact_number'];
              $row[]  = $template['title'];
              $row[]  = '<p class="price-sup"><sup>'.$currency_symbol.'</sup> '.$template['proposed_fee'].'</p>';
              $row[]  = '<span class="service-date">'.date($date_format, strtotime($template['request_date'])).'<span class="service-time">'.date("H.i A", strtotime($template['request_time'])).'</span></span>';
              $row[]  = date($date_format, strtotime($template['created']));
              $val = '';
              $status = $template['status'];
              if($status == -1)
              {
                $val = '<span class="label label-danger-border">Expired</span>';
              }
              if($status == 0)
              {
                $val = '<span class="label label-warning-border">Pending</span>';
              }
              elseif($status == 1)
              {
                $val = '<span class="label label-info-border">Accepted</span>';
              }
              elseif($status == 2)
              {
                $val = '<span class="label label-success-border">Completed</span>';
              }
              elseif($status == 3)
              {
                $val = '<span class="label label-danger-border">Declined</span>';
              }
              elseif($status == 4)
              {
                $val = '<span class="label label-danger-border">Deleted</span>';
              }
	            $row[]  = $val;
	            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->service->request_list_all(),
                        "recordsFiltered" => $this->service->request_list_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);

	}
}
